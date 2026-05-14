<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index()
    {
        $query = \App\Models\Registration::with(['user', 'event', 'status']);

        if (request()->filled('user_name')) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . request()->user_name . '%');
            });
        }

        if (request()->filled('event_name')) {
            $query->whereHas('event', function ($q) {
                $q->where('name', 'like', '%' . request()->event_name . '%');
            });
        }

        if (request()->filled('status')) {
            $query->whereHas('status', function ($q) {
                $q->where('name', request()->status);
            });
        }

        $registrations = $query->orderBy('registration_date', 'desc')->get();
        $statuses = DB::table('registration_status')->get();
        return view('registrations.viewAll', compact('registrations', 'statuses'));
    }
}
