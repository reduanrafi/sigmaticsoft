<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Contact;
use Illuminate\Http\Request;

class StaticPageController extends Controller {

    public function learning() {
        return view('website.pages.learning');
    }

    public function about() {
        return view('website.pages.about');
    }

    public function contact() {
        return view('website.pages.contact');
    }

    // Services
    public function softwareAudit() {
        return view('website.pages.services.software-audit');
    }

    public function legacyModernization() {
        return view('website.pages.services.legacy-modernization');
    }

    public function systemIntegration() {
        return view('website.pages.services.system-integration');
    }

    public function aiBusinessAutomation() {
        return view('website.pages.services.ai-business-automation');
    }

    public function managedEngineering() {
        return view('website.pages.services.managed-engineering');
    }

    // Industries
    public function retailDistribution() {
        return view('website.pages.industries.retail-distribution');
    }

    public function ecommerce() {
        return view('website.pages.industries.ecommerce');
    }

    public function professionalServices() {
        return view('website.pages.industries.professional-services');
    }

    // Case Studies
    public function caseStudiesIndex() {
        $caseStudies = CaseStudy::where('is_active', 1)->orderBy('id', 'desc')->get();
        return view('website.pages.case_studies.index', compact('caseStudies'));
    }

    public function caseStudyShow($slug) {
        $caseStudy = CaseStudy::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        return view('website.pages.case_studies.show', compact('caseStudy'));
    }

    // Legal
    public function privacy() {
        return view('website.pages.privacy');
    }

    public function terms() {
        return view('website.pages.terms');
    }

    public function contactSubmit(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'situation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'project_size' => 'nullable|string|max:255',
            'contact_method' => 'nullable|string|max:255',
        ]);

        $formattedMessage = "Company: " . ($validatedData['company'] ?? 'N/A') . "\n"
            . "Website: " . ($validatedData['website'] ?? 'N/A') . "\n"
            . "Situation: " . ($validatedData['situation'] ?? 'N/A') . "\n"
            . "Project Size: " . ($validatedData['project_size'] ?? 'N/A') . "\n"
            . "Preferred Contact Method: " . ($validatedData['contact_method'] ?? 'N/A') . "\n\n"
            . "Tell Us About The Problem:\n" . $validatedData['message'];

        Contact::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'message' => $formattedMessage,
            'subject' => $request->input('subject', 'B2B Website Lead'),
            'phone' => $request->input('phone', null),
        ]);

        return redirect()->back()->with('success', 'Your request has been received. Our engineering team will review it and get in touch.');
    }
}
