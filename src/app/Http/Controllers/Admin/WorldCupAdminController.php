<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WorldCupAdminController extends Controller
{
    /**
     * Display the World Cup matches dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $filePath = storage_path('app/worldcup_matches_fallback.json');
        
        $rawJson = '';
        $matches = [];
        
        if (File::exists($filePath)) {
            $rawJson = File::get($filePath);
            $matches = json_decode($rawJson, true) ?? [];
        }

        // Format raw JSON to be pretty printed in textarea
        $prettyJson = '';
        if ($rawJson) {
            $decoded = json_decode($rawJson);
            if ($decoded) {
                $prettyJson = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
        }

        return view('admin.pages.worldcup.index', [
            'matches' => $matches,
            'prettyJson' => $prettyJson
        ]);
    }

    /**
     * Update the World Cup fixtures dataset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $jsonContent = '';

        // 1. Check if a JSON file was uploaded
        if ($request->hasFile('json_file')) {
            $request->validate([
                'json_file' => 'required|file|mimes:json,txt',
            ]);
            $jsonContent = File::get($request->file('json_file')->getRealPath());
        } else {
            // 2. Fall back to raw JSON textarea input
            $request->validate([
                'json_text' => 'required|string',
            ]);
            $jsonContent = $request->input('json_text');
        }

        // 3. Robust JSON Syntax Validation
        $decoded = json_decode($jsonContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'JSON Schema Validation Failed: ' . json_last_error_msg());
        }

        // 4. Validate array structure
        if (!is_array($decoded)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid Format: The root element must be a valid JSON array of match objects.');
        }

        // 5. Ensure at least some match attributes exist (optional structural sanity check)
        if (count($decoded) > 0) {
            $sample = $decoded[0];
            $requiredKeys = ['home_team', 'away_team', 'venue', 'stage_name'];
            $missingKeys = [];
            foreach ($requiredKeys as $key) {
                if (!isset($sample[$key])) {
                    $missingKeys[] = $key;
                }
            }
            
            if (count($missingKeys) > 0) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'JSON Validation Warning: Sample match objects are missing expected keys: ' . implode(', ', $missingKeys));
            }
        }

        // 6. Write validated pretty JSON to high-fidelity storage path
        $filePath = storage_path('app/worldcup_matches_fallback.json');
        $prettyJson = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        
        File::put($filePath, $prettyJson);

        return redirect()->route('admin.worldcup.index')
            ->with('success', 'World Cup dataset successfully updated! Predictors will immediately see the new fixtures.');
    }
}
