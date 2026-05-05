<?php

namespace App\Http\Controllers;

use App\Models\Organization;

class OrganizationsController extends Controller
{
    public function index()
    {
        $organizations = Organization::withCount('teams')
            ->orderBy('name')
            ->get();

        return view('public.organizations.index', compact('organizations'));
    }
}
