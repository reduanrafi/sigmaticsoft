<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $clients = $query->latest()->paginate(10);

        return view('admin_portal.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin_portal.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $client = Client::create($validated);

        ActivityLog::log('client_created', "Admin created client profile: {$client->company_name}", $client);

        return redirect()->route('clients.index')->with('success', 'Client profile created successfully.');
    }

    public function show(Client $client)
    {
        $client->load(['projects', 'users', 'requests']);
        return view('admin_portal.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('admin_portal.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $client->update($validated);

        ActivityLog::log('client_updated', "Admin updated client profile: {$client->company_name}", $client);

        return redirect()->route('clients.index')->with('success', 'Client profile updated successfully.');
    }

    public function destroy(Client $client)
    {
        ActivityLog::log('client_deleted', "Admin deleted client profile: {$client->company_name}", $client);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client profile deleted successfully.');
    }

    public function createUser(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'client_id' => $client->id,
            'role' => 'client',
        ]);

        ActivityLog::log('client_user_created', "Admin created user login {$user->email} for client {$client->company_name}", $user);

        return redirect()->route('clients.show', $client->id)->with('success', 'Client login user account created successfully.');
    }
}
