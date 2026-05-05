@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
        <p class="text-gray-400 text-sm">Games</p>
        <p class="text-3xl font-bold text-green-400 mt-1">{{ $stats['games'] }}</p>
    </div>
    <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
        <p class="text-gray-400 text-sm">Organizations</p>
        <p class="text-3xl font-bold text-green-400 mt-1">{{ $stats['organizations'] }}</p>
    </div>
    <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
        <p class="text-gray-400 text-sm">Events</p>
        <p class="text-3xl font-bold text-green-400 mt-1">{{ $stats['events'] }}</p>
    </div>
    <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
        <p class="text-gray-400 text-sm">Teams</p>
        <p class="text-3xl font-bold text-green-400 mt-1">{{ $stats['teams'] }}</p>
    </div>
    <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
        <p class="text-gray-400 text-sm">Players</p>
        <p class="text-3xl font-bold text-green-400 mt-1">{{ $stats['players'] }}</p>
    </div>
    <div class="bg-gray-900 rounded-xl p-6 border border-gray-800">
        <p class="text-gray-400 text-sm">Matches</p>
        <p class="text-3xl font-bold text-green-400 mt-1">{{ $stats['matches'] }}</p>
    </div>
</div>
@endsection