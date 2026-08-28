<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Insight;
use Illuminate\Http\Request;

class InsightController extends Controller {

    public static $strategicInsights = [
        'how-to-modernize-legacy-laravel-application' => 'Modernization',
        'rewrite-vs-modernize-which-should-your-business-choose' => 'Modernization',
        '7-signs-your-software-has-become-technical-debt' => 'Modernization',
        'why-business-systems-fail-to-integrate' => 'Integration',
        'shopify-erp-integration-architecture' => 'Integration',
        'building-reliable-webhook-based-integrations' => 'Integration',
        'where-ai-actually-saves-businesses-time' => 'AI Automation',
        'ai-agents-vs-traditional-automation' => 'AI Automation',
        'how-to-find-ai-automation-opportunities' => 'AI Automation',
        'why-ai-projects-fail-without-good-data' => 'AI Automation',
        'when-a-business-outgrows-its-pos' => 'Business Systems',
        'centralized-management-systems-for-growing-businesses' => 'Business Systems',
        'why-spreadsheets-become-operational-debt' => 'Business Systems',
    ];

    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        
        $categories = collect([
            ['name' => 'Modernization', 'slug' => 'modernization'],
            ['name' => 'Integration', 'slug' => 'integration'],
            ['name' => 'AI Automation', 'slug' => 'ai-automation'],
            ['name' => 'Business Systems', 'slug' => 'business-systems'],
        ])->map(function ($c) {
            return (object)$c;
        });

        $query = Insight::latest();
        
        if ($categorySlug) {
            $categoryName = null;
            if ($categorySlug === 'modernization') $categoryName = 'Modernization';
            elseif ($categorySlug === 'integration') $categoryName = 'Integration';
            elseif ($categorySlug === 'ai-automation') $categoryName = 'AI Automation';
            elseif ($categorySlug === 'business-systems') $categoryName = 'Business Systems';

            if ($categoryName) {
                $matchingSlugs = [];
                foreach (self::$strategicInsights as $slug => $cat) {
                    if ($cat === $categoryName) {
                        $matchingSlugs[] = $slug;
                    }
                }
                
                $query->where(function($q) use ($matchingSlugs, $categorySlug, $categoryName) {
                    $q->whereIn('slug', $matchingSlugs)
                      ->orWhere('meta_keywords', 'like', '%' . $categorySlug . '%')
                      ->orWhere('meta_keywords', 'like', '%' . $categoryName . '%');
                });
            }
        }

        $insights = $query->paginate(10);

        foreach ($insights as $insight) {
            $insight->category = self::$strategicInsights[$insight->slug] ?? 'General';
        }

        return view('website.pages.insight', compact('insights', 'categories', 'categorySlug'));
    }

    public function show($slug)
    {
        $categories = collect([
            ['name' => 'Modernization', 'slug' => 'modernization'],
            ['name' => 'Integration', 'slug' => 'integration'],
            ['name' => 'AI Automation', 'slug' => 'ai-automation'],
            ['name' => 'Business Systems', 'slug' => 'business-systems'],
        ])->map(function ($c) {
            return (object)$c;
        });

        $insight = Insight::where('slug', $slug)->firstOrFail();
        $insight->category = self::$strategicInsights[$insight->slug] ?? 'General';

        return view('website.pages.show_insight', compact('insight', 'categories'));
    }
}
