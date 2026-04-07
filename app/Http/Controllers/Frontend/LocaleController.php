<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request)
    {
        $request->validate([
            'locale' => 'required|in:en,kh',
        ]);

        session()->put('locale', $request->input('locale'));
        app()->setLocale($request->input('locale'));

        return redirect()->back();
    }
}
