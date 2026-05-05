<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — EsportsTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --orange: #e8460a;
            --orange-dim: rgba(232,70,10,0.12);
            --bg: #07070f;
            --surface: #0d0d1a;
            --card: #111120;
            --border: rgba(255,255,255,0.07);
            --border-hi: rgba(232,70,10,0.25);
            --t1: #e4e4f4;
            --t2: #8a8aa8;
            --t3: #4a4a68;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--t1); min-height: 100vh; }
        body::before { content: ''; position: fixed; inset: 0; background-image: linear-gradient(rgba(232,70,10,0.025) 1px, transparent 1px), linear-gradient(90deg, rgba(232,70,10,0.025) 1px, transparent 1px); background-size: 48px 48px; pointer-events: none; z-index: 0; }

        /* Nav */
        nav { position: sticky; top: 0; z-index: 100; background: rgba(7,7,15,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 32px; height: 60px; gap: 24px; }
        .nav-logo { font-family: 'Rajdhani', sans-serif; font-size: 20px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #fff; text-decoration: none; }
        .nav-logo span { color: var(--orange); }
        .nav-links { display: flex; gap: 24px; list-style: none; }
        .nav-links a { font-size: 12px; letter-spacing: 1px; text-transform: uppercase; color: var(--t2); text-decoration: none; transition: color 0.15s; }
        .nav-links a:hover { color: var(--t1); }
        .nav-links a.active { color: var(--orange); }
        .nav-right { margin-left: auto; display: flex; align-items: center; gap: 16px; }
        .nav-user { font-size: 13px; color: var(--t2); }
        .btn-logout { padding: 6px 14px; background: transparent; border: 1px solid var(--border); border-radius: 6px; color: var(--t2); font-size: 12px; cursor: pointer; text-decoration: none; transition: all 0.15s; }
        .btn-logout:hover { border-color: var(--border-hi); color: var(--orange); }

        /* Layout */
        .container { max-width: 1200px; margin: 0 auto; padding: 40px 32px; position: relative; z-index: 1; }

        /* Welcome */
        .welcome { margin-bottom: 36px; }
        .welcome h1 { font-family: 'Rajdhani', sans-serif; font-size: 28px; font-weight: 700; letter-spacing: 1px; color: var(--t1); }
        .welcome h1 span { color: var(--orange); }
        .welcome p { font-size: 14px; color: var(--t2); margin-top: 4px; }

        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 40px; }
        .stat-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 20px 24px; transition: border-color 0.2s; }
        .stat-card:hover { border-color: var(--border-hi); }
        .stat-num { font-family: 'Rajdhani', sans-serif; font-size: 36px; font-weight: 700; color: var(--orange); line-height: 1; }
        .stat-label { font-size: 12px; letter-spacing: 1px; text-transform: uppercase; color: var(--t3); margin-top: 6px; }

        /* Section */
        .section { margin-bottom: 40px; }
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .section-title { font-family: 'Rajdhani', sans-serif; font-size: 18px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--t1); }
        .btn-create { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: var(--orange); border: none; border-radius: 8px; color: #fff; font-size: 13px; font-weight: 600; text-decoration: none; transition: opacity 0.15s; cursor: pointer; }
        .btn-create:hover { opacity: 0.85; }

        /* Cards */
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px; }
        .item-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 20px; transition: border-color 0.2s; }
        .item-card:hover { border-color: var(--border-hi); }
        .item-name { font-family: 'Rajdhani', sans-serif; font-size: 17px; font-weight: 600; color: var(--t1); margin-bottom: 4px; }
        .item-meta { font-size: 12px; color: var(--t3); }
        .item-actions { display: flex; gap: 8px; margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border); }
        .btn-edit { padding: 5px 12px; background: transparent; border: 1px solid var(--border); border-radius: 6px; color: var(--t2); font-size: 12px; text-decoration: none; transition: all 0.15s; }
        .btn-edit:hover { border-color: var(--border-hi); color: var(--t1); }
        .btn-delete { padding: 5px 12px; background: transparent; border: 1px solid rgba(224,80,80,0.2); border-radius: 6px; color: #f87171; font-size: 12px; cursor: pointer; transition: all 0.15s; }
        .btn-delete:hover { background: rgba(224,80,80,0.08); }

        /* Status badges */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 4px; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; font-weight: 600; }
        .badge-live { background: rgba(232,70,10,0.12); color: var(--orange); border: 1px solid var(--border-hi); }
        .badge-upcoming { background: rgba(100,100,200,0.12); color: #8888dd; border: 1px solid rgba(100,100,200,0.2); }
        .badge-completed { background: rgba(255,255,255,0.04); color: var(--t3); border: 1px solid var(--border); }

        /* Empty state */
        .empty { text-align: center; padding: 48px 20px; background: var(--card); border: 1px dashed var(--border); border-radius: 12px; }
        .empty p { color: var(--t3); font-size: 14px; margin-bottom: 16px; }

        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .container { padding: 24px 16px; }
        }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('home') }}" class="nav-logo">Esports<span>Track</span></a>
    <ul class="nav-links">
        <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
        <li><a href="{{ route('home') }}">Public Site</a></li>
    </ul>
    <div class="nav-right">
        <span class="nav-user">{{ $user->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">Sign out</button>
        </form>
    </div>
</nav>

<div class="container">

    {{-- Welcome --}}
    <div class="welcome">
        <h1>Welcome back, <span>{{ $user->name }}</span>!</h1>
        <p>Manage your tournaments, teams and players from here.</p>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-num">{{ $stats['tournaments'] }}</div>
            <div class="stat-label">My Tournaments</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $stats['teams'] }}</div>
            <div class="stat-label">My Teams</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $stats['players'] }}</div>
            <div class="stat-label">My Players</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $stats['matches'] }}</div>
            <div class="stat-label">My Matches</div>
        </div>
    </div>

    {{-- My Tournaments --}}
    <div class="section">
        <div class="section-header">
            <span class="section-title">My Tournaments</span>
            <a href="{{ route('user.events.create') }}" class="btn-create">+ New Tournament</a>
        </div>

        @if($myEvents->count() > 0)
            <div class="cards-grid">
                @foreach($myEvents as $event)
                    <div class="item-card">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:8px;">
                            <div class="item-name">{{ $event->name }}</div>
                            <span class="badge badge-{{ $event->status }}">
                                @if($event->status === 'live')
                                    <span style="width:5px;height:5px;background:currentColor;border-radius:50%;display:inline-block;"></span>
                                @endif
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                        <div class="item-meta">
                            {{ $event->game?->name ?? 'No game' }} •
                            {{ $event->matches_count }} matches
                            @if($event->prize_pool)
                                • {{ $event->prize_pool }}
                            @endif
                        </div>
                        <div class="item-meta" style="margin-top:4px;">
                            @if($event->start_date)
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M d') }}
                                @if($event->end_date)
                                    — {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                @endif
                            @endif
                        </div>
                        <div class="item-actions">
                            <a href="{{ route('user.events.edit', $event) }}" class="btn-edit">Edit</a>
                            <form method="POST" action="{{ route('user.events.destroy', $event) }}"
                                  onsubmit="return confirm('Delete {{ $event->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty">
                <p>You haven't created any tournaments yet.</p>
                <a href="{{ route('user.events.create') }}" class="btn-create">+ Create your first tournament</a>
            </div>
        @endif
    </div>

    {{-- My Teams --}}
    <div class="section">
        <div class="section-header">
            <span class="section-title">My Teams</span>
            <a href="{{ route('user.teams.create') }}" class="btn-create">+ New Team</a>
        </div>

        @if($myTeams->count() > 0)
            <div class="cards-grid">
                @foreach($myTeams as $team)
                    <div class="item-card">
                        <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                            @if($team->logo_url)
                                <img src="{{ $team->logo_url }}" style="width:36px;height:36px;border-radius:6px;object-fit:cover;">
                            @else
                                <div style="width:36px;height:36px;border-radius:6px;background:var(--orange-dim);border:1px solid var(--border-hi);display:flex;align-items:center;justify-content:center;font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;color:var(--orange);">
                                    {{ strtoupper(substr($team->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <div class="item-name">{{ $team->name }}</div>
                                <div class="item-meta">{{ $team->players_count }} players</div>
                            </div>
                        </div>
                        <div class="item-actions">
                            <a href="{{ route('user.teams.edit', $team) }}" class="btn-edit">Edit</a>
                            <form method="POST" action="{{ route('user.teams.destroy', $team) }}"
                                  onsubmit="return confirm('Delete {{ $team->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty">
                <p>You haven't created any teams yet.</p>
                <a href="{{ route('user.teams.create') }}" class="btn-create">+ Create your first team</a>
            </div>
        @endif
    </div>

</div>

</body>
</html>