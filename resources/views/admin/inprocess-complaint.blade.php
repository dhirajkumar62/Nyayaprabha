<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Admin Pending Cases</title>
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
                    <h2><i class="fa fa-spinner" style="margin-right: 10px; color: var(--primary);"></i> In Process Complaints</h2>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Complaint No</th>
                                <th>Complainant Name</th>
                                <th>Reg Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($complaints as $row)                                  
                            <tr>
                                <td>{{ $row->complaintNumber }}</td>
                                <td style="font-weight: 600; color: var(--text-main);">{{ $row->name }}</td>
                                <td style="color: var(--text-muted);">{{ $row->regDate }}</td>
                                <td>
                                    <span class="badge" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;">In Process</span>
                                </td>
                                <td>
                                    <a href="/admin/complaint-details/{{ $row->complaintNumber }}" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i> View Details</a>
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
