<?php

namespace App\Http\Controllers\AdminPortal;

use App\Http\Controllers\Controller;
use App\Models\TransactionCategory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class TransactionCategoryController extends Controller
{
    public function index()
    {
        $categories = TransactionCategory::all();
        return view('admin_portal.finance.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin_portal.finance.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'status' => 'required|in:active,inactive',
        ]);

        $category = TransactionCategory::create($validated);

        ActivityLog::log('category_created', "Admin created transaction category: {$category->name} ({$category->type})", $category);

        return redirect()->route('finance.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(TransactionCategory $category)
    {
        return view('admin_portal.finance.categories.edit', compact('category'));
    }

    public function update(Request $request, TransactionCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'status' => 'required|in:active,inactive',
        ]);

        $category->update($validated);

        ActivityLog::log('category_updated', "Admin updated transaction category: {$category->name} ({$category->type})", $category);

        return redirect()->route('finance.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(TransactionCategory $category)
    {
        if ($category->transactions()->count() > 0) {
            return redirect()->route('finance.categories.index')->with('error', 'Cannot delete category with associated transactions.');
        }

        ActivityLog::log('category_deleted', "Admin deleted transaction category: {$category->name}", $category);
        $category->delete();

        return redirect()->route('finance.categories.index')->with('success', 'Category deleted successfully.');
    }
}
