<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        Session::put('locale', $request->get('locale'));
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'urlBack' => url()->previous(),
            ]);
        }else{
            dd();
            return view(route('dashboard-user'));
        }
    }
}
