<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        Session::put('locale', $request->route()->parameter('locale'));
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'urlBack' => url()->previous(),
            ]);
        }else{
//            return redirect(route('dashboard-user'));
            return redirect(url()->previous());
        }
    }
}
