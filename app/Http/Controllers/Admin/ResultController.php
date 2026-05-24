<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreResultRequest;
use App\Http\Requests\Admin\UpdateResultRequest;
use App\Models\Matches;
use App\Models\Result;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::with(['match.event', 'match.teamA', 'match.teamB', 'winner', 'mvp'])
            ->latest()
            ->get();

        return view('admin.results.index', compact('results'));
    }

    public function create()
    {
        $matches = Matches::with(['event', 'teamA', 'teamB'])
            ->whereNull('pandascore_id')
            ->latest('scheduled_at')
            ->get();

        return view('admin.results.create', compact('matches'));
    }

    public function store(StoreResultRequest $request)
    {
        $validated = $request->validated();
        Result::updateOrCreate(
            ['match_id' => $validated['match_id']],
            $validated
        );

        return redirect()->route('admin.results.index')
            ->with('success', 'Result created successfully!');
    }

    public function show(Result $result)
    {
        $result->load(['match.event', 'match.teamA', 'match.teamB', 'winner', 'mvp']);

        return view('admin.results.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $matches = Matches::with(['event', 'teamA', 'teamB'])
            ->whereNull('pandascore_id')
            ->latest('scheduled_at')
            ->get();

        return view('admin.results.edit', compact('result', 'matches'));
    }

    public function update(UpdateResultRequest $request, Result $result)
    {
        $result->update($request->validated());

        return redirect()->route('admin.results.index')
            ->with('success', 'Result updated successfully!');
    }

    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()->route('admin.results.index')
            ->with('success', 'Result deleted.');
    }
}
