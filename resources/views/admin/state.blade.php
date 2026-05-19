<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Admin States</title>

    <link href="/css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout { display: flex; min-height: 100vh; background: var(--background); }
        .sidebar-wrapper { width: 280px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; z-index: 10; display: flex; flex-direction: column; height: 100vh; position: sticky; top: 0; overflow-y: auto; }
        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; background: var(--background); }
        
        .table-container { background: var(--surface); border-radius: var(--radius-lg); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); overflow: hidden; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border); }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: var(--primary-light); }
        
        /* Fixed Header Styles */
        .topbar { background: var(--surface); padding: 16px 40px; display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .topbar .logo { font-size: 1.25rem; font-weight: 700; color: var(--primary); }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            @include('admin.include.sidebar')
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            <!-- Fixed Topbar -->
            <header class="topbar">
                <a href="/admin/dashboard" class="logo" style="text-decoration:none; display:flex; align-items:center; gap:10px;">
                    <i class="fa-solid fa-shield-halved"></i>
                    Nyayaprabha Admin
                </a>
                <div class="user-menu" style="display:flex; align-items:center; gap:16px;">
                    <span class="badge" style="background:#DCFCE7; color:#16A34A; padding:4px 12px; border-radius:50px; font-size:0.75rem; font-weight:600;"><i class="fa-solid fa-check-circle" style="margin-right: 4px;"></i> System Secure</span>
                    <a href="/admin/logout" class="btn" style="background:transparent; border:1px solid var(--primary); color:var(--primary); padding:8px 16px; border-radius:50px; text-decoration:none; font-size:0.9rem; font-weight:500;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </header>
            
            <main class="main-content">
                <div style="margin-bottom: 24px;">
                    <h2 style="font-size:1.5rem; font-weight:700;"><i class="fa fa-map-marker-alt" style="margin-right: 10px; color: var(--primary);"></i> State Management</h2>
                </div>
                
                @if(session('msg'))
                    <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                        {{ session('msg') }}
                    </div>
                @endif

                @if(session('delmsg'))
                    <div style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                        {{ session('delmsg') }}
                    </div>
                @endif

                <div class="card" style="margin-bottom: 30px; background:var(--surface); border-radius:var(--radius-lg); padding:28px; border:1px solid var(--border); box-shadow:0 4px 15px rgba(0,0,0,0.03);">
                    <h3 style="margin-bottom: 20px; font-size: 1.25rem;">Add State</h3>
                    <form name="State" method="post" action="/admin/state" style="max-width: 600px;">
                        @csrf
                        <div class="form-group" style="margin-bottom:16px;">
                            <label class="form-label" style="display:block; margin-bottom:8px; font-weight:500;">State Name</label>
                            <input type="text" placeholder="Enter state Name" name="state" class="form-control" style="width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:8px; outline:none;" required>
                        </div>

                        <div class="form-group" style="margin-bottom:16px;">
                            <label class="form-label" style="display:block; margin-bottom:8px; font-weight:500;">Description</label>
                            <textarea class="form-control" name="description" rows="5" placeholder="Enter state description" style="width:100%; padding:10px 14px; border:1px solid var(--border); border-radius:8px; outline:none;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="background:var(--primary); color:white; border:none; padding:10px 20px; border-radius:8px; font-weight:600; cursor:pointer;">Add State</button>
                    </form>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>State</th>
                                <th>Description</th>
                                <th>Creation date</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($states as $index => $row)                                  
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="font-weight: 600; color: var(--text-main);">{{ $row->stateName }}</td>
                                <td>{{ $row->stateDescription }}</td>
                                <td style="color: var(--text-muted);">{{ $row->postingDate }}</td>
                                <td style="color: var(--text-muted);">{{ $row->updationDate }}</td>
                                <td>
                                    <a href="/admin/state/delete/{{ $row->id }}" onClick="return confirm('Are you sure you want to delete?')" style="color: #EF4444; text-decoration:none;"><i class="fa fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
