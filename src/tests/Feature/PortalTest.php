<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\ClientRequest;
use App\Models\TaskComment;
use App\Models\Account;
use App\Models\TransactionCategory;
use App\Models\Transaction;

class PortalTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $clientA;
    protected $clientB;
    protected $clientAUser;
    protected $clientBUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Admin
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create Clients
        $this->clientA = Client::create([
            'name' => 'Client A Contact',
            'company_name' => 'Company A Ltd.',
            'status' => 'active',
        ]);

        $this->clientB = Client::create([
            'name' => 'Client B Contact',
            'company_name' => 'Company B Ltd.',
            'status' => 'active',
        ]);

        // Create Client Logins
        $this->clientAUser = User::factory()->create([
            'client_id' => $this->clientA->id,
            'role' => 'client',
        ]);

        $this->clientBUser = User::factory()->create([
            'client_id' => $this->clientB->id,
            'role' => 'client',
        ]);
    }

    /** @test */
    public function clients_cannot_access_admin_dashboard()
    {
        $response = $this->actingAs($this->clientAUser)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    /** @test */
    public function admins_can_access_admin_dashboard()
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function client_cannot_access_another_clients_projects()
    {
        // Project for Client B
        $projectB = Project::create([
            'client_id' => $this->clientB->id,
            'name' => 'Client B Project',
            'slug' => 'client-b-project',
            'project_code' => 'PRJ-9999',
            'status' => 'active',
            'priority' => 'medium',
        ]);

        // Client A tries to view Project B
        $response = $this->actingAs($this->clientAUser)->get(route('client.projects.show', $projectB->id));
        $response->assertStatus(403);

        // Client B can view Project B
        $response2 = $this->actingAs($this->clientBUser)->get(route('client.projects.show', $projectB->id));
        $response2->assertStatus(200);
    }

    /** @test */
    public function clients_cannot_see_internal_task_comments()
    {
        $projectA = Project::create([
            'client_id' => $this->clientA->id,
            'name' => 'Client A Project',
            'slug' => 'client-a-project',
            'project_code' => 'PRJ-1111',
            'status' => 'active',
            'priority' => 'medium',
        ]);

        $task = Task::create([
            'project_id' => $projectA->id,
            'title' => 'Sample Task',
            'task_code' => 'TSK-11111',
            'client_visible' => true,
        ]);

        $publicComment = TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $this->adminUser->id,
            'body' => 'Public info',
            'visibility' => 'public',
        ]);

        $internalComment = TaskComment::create([
            'task_id' => $task->id,
            'user_id' => $this->adminUser->id,
            'body' => 'Secret internal details',
            'visibility' => 'internal',
        ]);

        $response = $this->actingAs($this->clientAUser)->get(route('client.tasks.show', $task->id));
        $response->assertStatus(200);
        $response->assertSee('Public info');
        $response->assertDontSee('Secret internal details');
    }

    /** @test */
    public function client_can_submit_request_and_admin_can_convert_to_task()
    {
        $projectA = Project::create([
            'client_id' => $this->clientA->id,
            'name' => 'Client A Project',
            'slug' => 'client-a-project',
            'project_code' => 'PRJ-1111',
            'status' => 'active',
            'priority' => 'medium',
        ]);

        // Client submits request
        $this->actingAs($this->clientAUser)->post(route('client.requests.store'), [
            'project_id' => $projectA->id,
            'title' => 'Bugs in checkout',
            'description' => 'Fix Checkout page on iOS',
            'type' => 'bug',
            'priority' => 'high',
        ]);

        $request = ClientRequest::first();
        $this->assertNotNull($request);
        $this->assertEquals('submitted', $request->status);

        // Admin converts request to task
        $response = $this->actingAs($this->adminUser)->post(route('requests.convert', $request->id), [
            'title' => 'Fix Checkout page on iOS - Task',
            'type' => 'bug',
            'priority' => 'high',
            'status' => 'accepted',
        ]);

        $request->refresh();
        $this->assertEquals('converted', $request->status);
        $this->assertNotNull($request->converted_task_id);

        $task = Task::find($request->converted_task_id);
        $this->assertNotNull($task);
        $this->assertEquals($projectA->id, $task->project_id);
        $this->assertEquals('Fix Checkout page on iOS - Task', $task->title);
    }

    /** @test */
    public function finance_income_and_expense_work_correctly_and_remain_decoupled_from_tasks()
    {
        $account = Account::create([
            'name' => 'Bank Account',
            'type' => 'bank',
            'opening_balance' => 1000.00,
        ]);

        $categoryIncome = TransactionCategory::create(['name' => 'Payment', 'type' => 'income']);
        $categoryExpense = TransactionCategory::create(['name' => 'Server', 'type' => 'expense']);

        // Record income
        Transaction::create([
            'account_id' => $account->id,
            'type' => 'income',
            'amount' => 500.00,
            'category_id' => $categoryIncome->id,
            'transaction_date' => now()->toDateString(),
            'created_by' => $this->adminUser->id,
        ]);

        // Verify balance increased
        $this->assertEquals(1500.00, $account->fresh()->balance);

        // Record expense
        Transaction::create([
            'account_id' => $account->id,
            'type' => 'expense',
            'amount' => 200.00,
            'category_id' => $categoryExpense->id,
            'transaction_date' => now()->toDateString(),
            'created_by' => $this->adminUser->id,
        ]);

        // Verify balance decreased
        $this->assertEquals(1300.00, $account->fresh()->balance);
    }

    /** @test */
    public function finance_transfers_do_not_affect_total_business_profit()
    {
        $accountFrom = Account::create([
            'name' => 'BKash',
            'type' => 'mobile_wallet',
            'opening_balance' => 1000.00,
        ]);

        $accountTo = Account::create([
            'name' => 'Bank',
            'type' => 'bank',
            'opening_balance' => 500.00,
        ]);

        // Transfer funds
        Transaction::create([
            'account_id' => $accountFrom->id,
            'transfer_to_account_id' => $accountTo->id,
            'type' => 'transfer',
            'amount' => 300.00,
            'transaction_date' => now()->toDateString(),
            'created_by' => $this->adminUser->id,
        ]);

        // BKash drops by 300
        $this->assertEquals(700.00, $accountFrom->fresh()->balance);
        // Bank increases by 300
        $this->assertEquals(800.00, $accountTo->fresh()->balance);

        // Combined total remains identical (1500)
        $this->assertEquals(1500.00, Account::all()->sum('balance'));
    }
}
