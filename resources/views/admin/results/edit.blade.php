@extends('layouts.admin')
@section('title', 'Edit Result')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.results.index') }}" class="text-gray-400 hover:text-white text-sm transition mb-6 inline-block">&larr; Back to Results</a>
    <form method="POST" action="{{ route('admin.results.update', $result) }}" class="bg-gray-900 rounded-xl border border-gray-800 p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm text-gray-400 mb-1">Match</label>
            <select name="match_id" id="match-select" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm">
                @foreach($matches as $match)
                <option value="{{ $match->id }}" data-a="{{ $match->team_a_id }}" data-b="{{ $match->team_b_id }}" data-a-name="{{ $match->teamA?->name }}" data-b-name="{{ $match->teamB?->name }}" {{ old('match_id', $result->match_id) == $match->id ? 'selected' : '' }}>
                    {{ $match->event?->name }} - {{ $match->teamA?->name }} vs {{ $match->teamB?->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Winner Team</label>
            <select name="winner_team_id" id="winner-select" data-selected="{{ old('winner_team_id', $result->winner_team_id) }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm"></select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <input type="number" name="score_a" min="0" value="{{ old('score_a', $result->score_a) }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm">
            <input type="number" name="score_b" min="0" value="{{ old('score_b', $result->score_b) }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm">
        </div>
        <input type="number" name="mvp_player" value="{{ old('mvp_player', $result->mvp_player) }}" placeholder="MVP player ID (optional)" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm">
        <textarea name="notes" rows="3" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm">{{ old('notes', $result->notes) }}</textarea>
        <button class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg text-sm">Update Result</button>
    </form>
</div>
<script>
function fillWinnerTeams(){
    const matchSelect = document.getElementById('match-select');
    const winnerSelect = document.getElementById('winner-select');
    const selected = matchSelect.options[matchSelect.selectedIndex];
    const selectedWinner = winnerSelect.dataset.selected;
    winnerSelect.innerHTML = '';
    const optionA = new Option(selected.dataset.aName, selected.dataset.a, false, selectedWinner == selected.dataset.a);
    const optionB = new Option(selected.dataset.bName, selected.dataset.b, false, selectedWinner == selected.dataset.b);
    winnerSelect.add(optionA); winnerSelect.add(optionB);
}
document.getElementById('match-select').addEventListener('change', fillWinnerTeams);
fillWinnerTeams();
</script>
@endsection
