
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Complaint History</title>

    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
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
                <div class="card">
                    <div style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 24px;">
                        <h2 style="font-size: 1.5rem;"><i class="fa fa-history" style="margin-right: 10px; color: var(--primary);"></i> Your Complaint History</h2>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Complaint No</th>
                                    <th>Reg Date</th>
                                    <th>Last Updation</th>
                                    <th>Status</th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($complaints as $row)
                                <tr>
                                    <td><strong>{{ $row->complaintNumber }}</strong></td>
                                    <td>{{ $row->regDate }}</td>
                                    <td>{{ $row->lastUpdationDate ? $row->lastUpdationDate : '-' }}</td>
                                    <td>
                                        @if(is_null($row->status) || $row->status == "")
                                            <span class="badge" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">Not Processed</span>
                                        @elseif(strtolower($row->status) == "in process")
                                            <span class="badge" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">In Process</span>
                                        @elseif(strtolower($row->status) == "closed")
                                            <span class="badge" style="background: rgba(16, 185, 129, 0.1); color: #10B981;">Closed</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="/users/complaint-details/{{ $row->complaintNumber }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.85rem;">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
