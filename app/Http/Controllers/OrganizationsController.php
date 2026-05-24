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

    public function show(Organization $organization)
    {
        $organization->load(['teams' => function ($query) {
            $query->orderBy('name');
        }]);

        return view('public.organizations.show', compact('organization'));
    }
}
