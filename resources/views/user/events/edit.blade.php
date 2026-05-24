@extends('layouts.public')
@section('title', 'Edit Tournament')

@section('content')
<div class="min-h-screen bg-gray-900">
    <div class="max-w-2xl mx-auto px-4 py-12">

        <a href="{{ route('user.events.index') }}"
            class="inline-flex items-center gap-1.5 text-gray-400 hover:text-orange-500 transition mb-5 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Tournaments
        </a>

        <h1 class="text-2xl font-medium text-white mb-1">Edit Tournament</h1>
        <p class="text-gray-400 text-sm mb-8">Update your tournament details and certification.</p>

        @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('user.events.update', $event) }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 border border-gray-700 rounded-xl p-8 flex flex-col gap-5">
            @csrf
            @method('PUT')

            {{-- Tournament Name --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Tournament Name <span class="text-orange-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $event->name) }}"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition"
                    required>
                @error('name')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Game --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Game <span class="text-orange-500">*</span>
                </label>
                <select name="game_id"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition"
                    required>
                    <option value="">Select a game</option>
                    @foreach($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id', $event->game_id) == $game->id ? 'selected' : '' }}>
                        {{ $game->name }}
                    </option>
                    @endforeach
                </select>
                @error('game_id')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tournament Type --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Tournament Type <span class="text-orange-500">*</span>
                </label>
                <select name="type" id="tournamentType"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition"
                    required onchange="toggleCertification()">
                    <option value="">Select type</option>
                    <option value="local" {{ old('type', $event->type) == 'local'         ? 'selected' : '' }}>Local</option>
                    <option value="national" {{ old('type', $event->type) == 'national'      ? 'selected' : '' }}>National</option>
                    <option value="international" {{ old('type', $event->type) == 'international' ? 'selected' : '' }}>International</option>
                    <option value="world" {{ old('type', $event->type) == 'world'         ? 'selected' : '' }}>World</option>
                </select>
                @error('type')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Prize Pool --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-sm font-medium text-gray-300">
                    Prize Pool <span class="text-gray-500 font-normal">(optional)</span>
                </label>
                <input type="text" name="prize_pool" value="{{ old('prize_pool', $event->prize_pool) }}"
                    placeholder="e.g., 50,000"
                    class="bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm placeholder-gray-600 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/10 focus:outline-none transition">
                @error('prize_pool')
                <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Certification Section --}}
            <div id="certificationSection" class="hidden flex flex-col gap-4">

                <div class="border-t border-gray-700"></div>

                {{-- Info banner --}}
                <div class="bg-blue-500/8 border border-blue-500/25 rounded-lg px-4 py-3 flex gap-3 items-start">
                    <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z" />
                    </svg>
                    <p class="text-blue-300 text-xs leading-relaxed">
                        <strong class="text-blue-400">Certification required</strong> — National, International, and World tournaments need a valid certification document.
                    </p>
                </div>

                {{-- Already uploaded --}}
                @if($event->hasCertification())
                <div class="bg-green-500/8 border border-green-500/25 rounded-lg px-4 py-3 flex gap-3 items-start">
                    <svg class="w-4 h-4 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-green-400 text-xs font-medium">Certification uploaded</p>
                        <p class="text-green-300 text-xs mt-0.5 break-all">{{ basename($event->certification_path) }}</p>
                    </div>
                </div>
                @endif

                {{-- Upload --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-medium text-gray-300">
                        @if($event->hasCertification())
                        Update Certification <span class="text-gray-500 font-normal">(optional)</span>
                        @else
                        Upload Certification <span class="text-orange-500">*</span>
                        @endif
                    </label>
                    <p class="text-xs text-gray-500">PDF, JPG, PNG, GIF, DOC, DOCX — max 5MB</p>
                    <div class="border border-dashed border-gray-600 rounded-xl p-7 text-center hover:border-orange-500 hover:bg-orange-500/[0.03] transition cursor-pointer group"
                        onclick="document.getElementById('certificationInput').click()">
                        <div class="w-10 h-10 rounded-lg bg-orange-500/10 flex items-center justify-center mx-auto mb-3 group-hover:bg-orange-500/20 transition">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <p class="text-gray-400 text-sm">Click to upload or drag and drop</p>
                        @if($event->hasCertification())
                        <p class="text-gray-600 text-xs mt-1">Upload a new file to replace the existing one</p>
                        @endif
                        <input type="file" id="certificationInput" name="certification" class="hidden"
                            accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx"
                            onchange="updateCertificationName(this)">
                    </div>
                    <p id="certificationFileName" class="text-orange-400 text-xs mt-1 min-h-[16px]"></p>
                    @error('certification')
                    <p class="text-red-400 text-xs mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Toggle --}}
                <div class="bg-gray-900 border border-gray-700 rounded-xl px-4 py-3.5 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-white">Make Certification Public</p>
                        <p class="text-xs text-gray-500 mt-0.5">Visible on the tournament details page</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                        <input type="checkbox" name="is_certification_public" class="sr-only peer"
                            {{ $event->is_certification_public ? 'checked' : '' }}>
                        <div class="w-10 h-6 bg-gray-700 rounded-full peer
                                    peer-checked:bg-orange-500
                                    after:content-[''] after:absolute after:top-[3px] after:left-[3px]
                                    after:bg-white after:rounded-full after:h-[18px] after:w-[18px]
                                    after:transition-all peer-checked:after:translate-x-4">
                        </div>
                    </label>
                </div>

            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-700"></div>

            {{-- Status info --}}
            <div class="bg-gray-900 border border-gray-700 rounded-xl px-4 py-3.5 flex items-center justify-between">
                <span class="text-gray-500 text-sm">Approval status</span>
                @if($event->approval_status === 'pending')
                <span class="text-yellow-500 text-sm font-medium">Pending review</span>
                @elseif($event->approval_status === 'approved')
                <span class="text-green-400 text-sm font-medium">Approved</span>
                @else
                <span class="text-red-400 text-sm font-medium">Rejected</span>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="relative overflow-hidden w-full bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium py-3 rounded-xl transition-colors duration-200 btn-shine">
                Update Tournament
            </button>

        </form>
    </div>
</div>

<style>
    .btn-shine::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.18), transparent);
        transform: skewX(-20deg);
        transition: left 0.5s ease;
    }

    .btn-shine:hover::after {
        left: 150%;
    }
</style>

<script>
    function toggleCertification() {
        const type = document.getElementById('tournamentType').value;
        const certSection = document.getElementById('certificationSection');
        const certInput = document.getElementById('certificationInput');

        if (['national', 'international', 'world'].includes(type)) {
            certSection.classList.remove('hidden');
            certInput.required = {
                {
                    $event - > hasCertification() ? 'false' : 'true'
                }
            };
        } else {
            certSection.classList.add('hidden');
            certInput.required = false;
        }
    }

    function updateCertificationName(input) {
        const name = input.files[0]?.name || '';
        document.getElementById('certificationFileName').textContent = name ? 'Selected: ' + name : '';
    }

    document.addEventListener('DOMContentLoaded', toggleCertification);
</script>
@endsection