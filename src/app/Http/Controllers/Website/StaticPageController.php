<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
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
    public function contactSubmit(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validatedData);

        return redirect()->route('website.contact')->with('success', 'Your message has been sent!');
    }
}
