<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Emergency Helplines</title>

    <!-- Global Design System -->
    <link href="/css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout { display: flex; min-height: 100vh; background: var(--background); }
        .sidebar-wrapper { width: 260px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; }
        
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li a { display: block; padding: 16px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; }
        .sidebar-menu li a:hover { background: var(--primary-light); color: var(--primary); }
        .sidebar-menu li a i { margin-right: 12px; width: 20px; text-align: center; }
        
        .topbar { background: var(--surface); padding: 16px 30px; display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); }
        .topbar .logo { font-size: 1.25rem; font-weight: 700; color: var(--primary); }
        
        .helpline-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .helpline-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 24px;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        
        .helpline-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-color: var(--primary-light);
        }
        
        .helpline-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.1);
            color: #DC2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 20px;
            flex-shrink: 0;
        }
        
        .helpline-info h3 {
            font-size: 1.1rem;
            color: var(--text-main);
            margin-bottom: 4px;
        }
        
        .helpline-info p {
            font-size: 1.2rem;
            font-weight: 700;
            color: #DC2626;
            letter-spacing: 1px;
        }
        
        .helpline-info span {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            @include('users.includes.sidebar')
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            @include('users.includes.header')
            
            <main class="main-content">
                <div class="card" style="max-width: 1000px; margin: 0 auto;">
                    <div style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 24px;">
                        <h2 style="font-size: 1.5rem;"><i class="fa fa-phone-alt" style="margin-right: 10px; color: var(--primary);"></i> Emergency Helplines</h2>
                        <p style="color: var(--text-muted); margin-top: 8px;">Quick access to important national emergency numbers and women safety helplines.</p>
                    </div>

                    <div class="helpline-grid">
                        @foreach($helplines as $helpline)
                        <div class="helpline-card">
                            <div class="helpline-icon">
                                <i class="fa fa-phone-volume"></i>
                            </div>
                            <div class="helpline-info">
                                <h3>{{ $helpline->name }}</h3>
                                <span>{{ $helpline->category }}</span>
                                <p>{{ $helpline->number }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
