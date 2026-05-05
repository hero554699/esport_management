@extends('layouts.admin')
@section('title', 'Organizations')
@section('content')

@if(session('success'))
<div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">All Organizations</h2>
    <a href="{{ route('admin.organizations.create') }}"
        class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
        + Add Organization
    </a>
</div>

<div class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-gray-800 text-gray-400 text-left">
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Country</th>
                <th class="px-4 py-3">Website</th>
                <th class="px-4 py-3">Teams</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($organizations as $org)
            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                <td class="px-4 py-3 font-medium">{{ $org->name }}</td>
                <td class="px-4 py-3 text-gray-400">{{ $org->country ?? '—' }}</td>
                <td class="px-4 py-3">
                    @if($org->website)
                    <a href="{{ $org->website }}" target="_blank"
                        class="text-orange-500 hover:text-orange-400 text-xs transition">
                        Visit site
                    </a>
                    @else
                    <span class="text-gray-600">—</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <span class="bg-gray-800 text-gray-300 px-2 py-1 rounded text-xs">
                        {{ $org->teams_count }} teams
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.organizations.edit', $org) }}"
                            class="text-blue-400 hover:text-blue-300 text-xs transition">Edit</a>
                        <form method="POST" action="{{ route('admin.organizations.destroy', $org) }}"
                            onsubmit="return confirm('Delete this organization?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-xs transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-500">No organizations found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection