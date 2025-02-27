<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EdtechRegistration;

class EdTechController extends Controller
{
    public function index()
    {
        $registrations = EdtechRegistration::all();
        // dd($registrations);
        return view('admin.edtech.viewedtech', compact('registrations'));
    }

    public function destroy($id)
    {
        $registration = EdtechRegistration::findOrFail($id);
        $registration->delete();

        return redirect()->route('ed-tech-franchise')->with('success', 'Registration deleted successfully!');
    }

}
