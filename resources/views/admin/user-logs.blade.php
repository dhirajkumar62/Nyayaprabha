<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | User Logs</title>

    <link href="/css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout { display: flex; min-height: 100vh; background: var(--background); }
        .sidebar-wrapper { width: 260px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; }
        .main-content { flex-grow: 1; padding: 30px; overflow-y: auto; }
        
        .table-container { background: var(--surface); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border); }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: var(--primary-light); }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            @include('admin.include.sidebar')
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            @include('admin.include.header')
            
            <main class="main-content">
                <div style="margin-bottom: 24px;">
                    <h2><i class="fa fa-list-alt" style="margin-right: 10px; color: var(--primary);"></i> User Login Logs</h2>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Email</th>
                                <th>IP Address</th>
                                <th>Login Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $index => $row)                                  
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="font-weight: 600; color: var(--text-main);">{{ $row->uid }}</td>
                                <td>{{ $row->userip }}</td>
                                <td style="color: var(--text-muted);">{{ $row->loginTime }}</td>
                                <td>
                                    @if($row->status == 1)
                                        <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">Success</span>
                                    @else
                                        <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">Failed</span>
                                    @endif
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
