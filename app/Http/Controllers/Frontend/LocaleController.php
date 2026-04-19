<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request)
    {
        $locale = $request->query('locale');

        // Change 'kh' to 'km'
        if (!in_array($locale, ['en', 'km'])) {
            abort(400, 'Invalid locale');
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        return redirect()->back();
    }
}
