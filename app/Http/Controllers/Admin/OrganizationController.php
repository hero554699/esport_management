<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::withCount('teams')->orderBy('name')->get();
        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'country'  => 'nullable|string|max:60',
            'website'  => 'nullable|url',
            'logo_url' => 'nullable|url',
        ]);

        Organization::create([
            'name'     => $request->name,
            'slug'     => Str::slug($request->name),
            'country'  => $request->country,
            'website'  => $request->website,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization created successfully!');
    }

    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'country'  => 'nullable|string|max:60',
            'website'  => 'nullable|url',
            'logo_url' => 'nullable|url',
        ]);

        $organization->update([
            'name'     => $request->name,
            'slug'     => Str::slug($request->name),
            'country'  => $request->country,
            'website'  => $request->website,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization updated successfully!');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return redirect()->route('admin.organizations.index')
            ->with('success', 'Organization deleted!');
    }
}
