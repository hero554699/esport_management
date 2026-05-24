<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreResultRequest;
use App\Http\Requests\User\UpdateResultRequest;
use App\Models\Matches;
use App\Models\Result;

class ResultController extends Controller
{
    public function index(Matches $match)
    {
        $this->authorize('viewAny', [Result::class, $match]);

        $results = $match->result()
            ->with(['winner', 'mvp'])
            ->get();

        return view('user.results.index', compact('match', 'results'));
    }

    public function create(Matches $match)
    {
        $this->authorize('create', [Result::class, $match]);

        $match->load(['teamA.players', 'teamB.players', 'result']);

        return view('user.results.create', compact('match'));
    }

    public function store(StoreResultRequest $request, Matches $match)
    {
        $this->authorize('create', [Result::class, $match]);

        $validated = $request->validated();
        $validated['match_id'] = $match->id;

        Result::updateOrCreate(
            ['match_id' => $match->id],
            $validated
        );

        return redirect()->route('user.matches.results.index', $match)
            ->with('success', 'Result recorded successfully!');
    }

    public function show(Matches $match, Result $result)
    {
        $this->authorize('view', $result);
        abort_if($result->match_id !== $match->id, 404);

        $result->load(['winner', 'mvp']);

        return view('user.results.show', compact('match', 'result'));
    }

    public function edit(Matches $match, Result $result)
    {
        $this->authorize('update', $result);
        abort_if($result->match_id !== $match->id, 404);

        $match->load(['teamA.players', 'teamB.players']);

        return view('user.results.edit', compact('match', 'result'));
    }

    public function update(UpdateResultRequest $request, Matches $match, Result $result)
    {
        $this->authorize('update', $result);
        abort_if($result->match_id !== $match->id, 404);

        $validated = $request->validated();
        $validated['match_id'] = $match->id;

        $result->update($validated);

        return redirect()->route('user.matches.results.index', $match)
            ->with('success', 'Result updated successfully!');
    }

    public function destroy(Matches $match, Result $result)
    {
        $this->authorize('delete', $result);
        abort_if($result->match_id !== $match->id, 404);

        $result->delete();

        return redirect()->route('user.matches.results.index', $match)
            ->with('success', 'Result deleted.');
    }
}
