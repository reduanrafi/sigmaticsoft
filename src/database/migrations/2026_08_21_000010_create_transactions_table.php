<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->string('type'); // income, expense, transfer
            $table->decimal('amount', 15, 2);
            $table->foreignId('category_id')->nullable()->constrained('transaction_categories')->onDelete('set null');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('set null');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('transfer_to_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
