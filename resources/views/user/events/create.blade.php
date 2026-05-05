<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tournament — EsportsTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root { --orange: #e8460a; --bg: #07070f; --card: #111120; --border: rgba(255,255,255,0.07); --border-hi: rgba(232,70,10,0.25); --t1: #e4e4f4; --t2: #8a8aa8; --t3: #4a4a68; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--t1); min-height: 100vh; }
        body::before { content: ''; position: fixed; inset: 0; background-image: linear-gradient(rgba(232,70,10,0.025) 1px, transparent 1px), linear-gradient(90deg, rgba(232,70,10,0.025) 1px, transparent 1px); background-size: 48px 48px; pointer-events: none; z-index: 0; }
        nav { position: sticky; top: 0; z-index: 100; background: rgba(7,7,15,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 32px; height: 60px; gap: 24px; }
        .nav-logo { font-family: 'Rajdhani', sans-serif; font-size: 20px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #fff; text-decoration: none; }
        .nav-logo span { color: var(--orange); }
        .container { max-width: 720px; margin: 0 auto; padding: 40px 32px; position: relative; z-index: 1; }
        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-family: 'Rajdhani', sans-serif; font-size: 26px; font-weight: 700; letter-spacing: 1px; color: var(--t1); }
        .page-header p { font-size: 14px; color: var(--t2); margin-top: 4px; }
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 32px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; color: var(--t2); margin-bottom: 8px; }
        .form-input, .form-select, .form-textarea { width: 100%; background: rgba(255,255,255,0.04); border: 1px solid var(--border); border-radius: 8px; padding: 10px 14px; color: var(--t1); font-family: 'Inter', sans-serif; font-size: 14px; outline: none; transition: border-color 0.2s; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: rgba(232,70,10,0.4); }
        .form-input::placeholder { color: var(--t3); }
        .form-select option { background: #111120; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .btn-primary { display: inline-flex; align-items: center; gap: 6px; padding: 10px 24px; background: var(--orange); border: none; border-radius: 8px; color: #fff; font-size: 14px; font-weight: 600; cursor: pointer; transition: opacity 0.15s; text-decoration: none; }
        .btn-primary:hover { opacity: 0.85; }
        .btn-ghost { display: inline-flex; align-items: center; padding: 10px 24px; background: transparent; border: 1px solid var(--border); border-radius: 8px; color: var(--t2); font-size: 14px; text-decoration: none; transition: all 0.15s; }
        .btn-ghost:hover { border-color: var(--border-hi); color: var(--t1); }
        .alert-error { background: rgba(232,70,10,0.08); border: 1px solid rgba(232,70,10,0.25); color: #ff7a50; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; }
    </style>
</head>
<body>
<nav>
    <a href="{{ route('home') }}" class="nav-logo">Esports<span>Track</span></a>
    <a href="{{ route('dashboard') }}" style="font-size:13px;color:var(--t2);text-decoration:none;margin-left:8px;">← Back to Dashboard</a>
</nav>

<div class="container">
    <div class="page-header">
        <h1>Create Tournament</h1>
        <p>Set up a new esports tournament</p>
    </div>

    @if($errors->any())
        <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route('user.events.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Tournament Name *</label>
                <input type="text" name="name" class="form-input" required
                       value="{{ old('name') }}"
                       placeholder="e.g. Manila Esports Cup 2026">
            </div>

            <div class="form-group">
                <label class="form-label">Game *</label>
                <select name="game_id" class="form-select" required>
                    <option value="">Select a game...</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                            {{ $game->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-input" required
                           value="{{ old('start_date') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-input" required
                           value="{{ old('end_date') }}">
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Prize Pool</label>
                    <input type="text" name="prize_pool" class="form-input"
                           value="{{ old('prize_pool') }}"
                           placeholder="e.g. $500 or ₱10,000">
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="live" {{ old('status') == 'live' ? 'selected' : '' }}>Live</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            </div>

            <div style="display:flex; gap:12px; margin-top:8px;">
                <button type="submit" class="btn-primary">Create Tournament</button>
                <a href="{{ route('dashboard') }}" class="btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>