<?php

namespace App\Http\Controllers;

use App\Models\RadarLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RadarLeadController extends Controller
{
    /**
     * Display a listing of radar leads with filtering & pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = RadarLead::query();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by service fit
        if ($request->filled('service_fit') && $request->service_fit !== 'all') {
            $query->where('service_fit', $request->service_fit);
        }

        // Filter by minimum score
        if ($request->filled('min_score')) {
            $query->where('ai_score', '>=', (int) $request->min_score);
        }

        // Filter by source platform
        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('source', 'like', $request->source . '%');
        }

        // Search in title, text, author, or summary
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('text', 'like', "%{$s}%")
                  ->orWhere('problem_summary', 'like', "%{$s}%")
                  ->orWhere('author', 'like', "%{$s}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'ai_score');
        $sortDir = $request->get('sort_dir', 'desc');

        if (in_array($sortBy, ['ai_score', 'found_at', 'heuristic_score', 'created_at'])) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('ai_score', 'desc')->orderBy('found_at', 'desc');
        }

        $perPage = min((int) $request->get('per_page', 15), 100);
        $leads = $query->paginate($perPage);

        return response()->json($leads);
    }

    /**
     * Get aggregate statistics for lead pipeline counters.
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total'          => RadarLead::count(),
            'new'            => RadarLead::where('status', 'new')->count(),
            'initiated'      => RadarLead::where('status', 'initiated')->count(),
            'contacted'      => RadarLead::where('status', 'contacted')->count(),
            'in_discussion'  => RadarLead::where('status', 'in_discussion')->count(),
            'won'            => RadarLead::where('status', 'won')->count(),
            'ignored'        => RadarLead::where('status', 'ignored')->count(),
            'high_priority'  => RadarLead::where('ai_score', '>=', 8)->whereIn('status', ['new', 'initiated'])->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Update lead status (e.g. mark as initiated, contacted, won, ignored).
     */
    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:new,initiated,contacted,in_discussion,won,ignored',
            'notes'  => 'nullable|string',
        ]);

        $lead = RadarLead::findOrFail($id);
        $lead->status = $request->status;
        $lead->last_action_at = now();

        if ($request->filled('notes')) {
            $stamp = now()->format('Y-m-d H:i');
            $newNote = "[{$stamp}] Status -> {$request->status}: " . trim($request->notes);
            $lead->notes = $lead->notes ? $lead->notes . "\n" . $newNote : $newNote;
        }

        $lead->save();

        return response()->json([
            'message' => "Lead marked as '{$lead->status}' successfully.",
            'lead'    => $lead,
        ]);
    }

    /**
     * Update lead notes.
     */
    public function updateNotes(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'notes' => 'required|string',
        ]);

        $lead = RadarLead::findOrFail($id);
        $lead->notes = $request->notes;
        $lead->save();

        return response()->json([
            'message' => 'Notes saved successfully.',
            'lead'    => $lead,
        ]);
    }

    /**
     * Delete or dismiss a lead.
     */
    public function destroy(string $id): JsonResponse
    {
        $lead = RadarLead::findOrFail($id);
        $lead->delete();

        return response()->json([
            'message' => 'Lead removed successfully.',
        ]);
    }

    /**
     * Render the admin management view.
     */
    public function adminView()
    {
        return view('admin_portal.radar_leads.index');
    }
}
