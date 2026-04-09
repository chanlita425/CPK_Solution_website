<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request)
    {
        // Get the locale from query ?locale=kh or ?locale=en
        $locale = $request->query('locale');

        // Validate locale
        if (!in_array($locale, ['en', 'kh'])) {
            abort(400, 'Invalid locale');
        }

        // Save to session
        session()->put('locale', $locale);

        // Set app locale for current request
        app()->setLocale($locale);

        // Redirect back to previous page
        return redirect()->back();
    }
}
