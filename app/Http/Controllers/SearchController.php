<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $patients = Patient::where('patient_id', $query)->get();
        $users = User::where('id', $query)->get();

        return view('search.results', compact('patients', 'users', 'query'));
    }
}
