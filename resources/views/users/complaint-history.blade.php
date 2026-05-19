
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Your Complaint History</title>

    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --soft-pink: #FFF0F5;
            --soft-purple: #F3E8FF;
            --gradient-primary: linear-gradient(135deg, #EC4899 0%, #8B5CF6 100%);
            --gradient-card: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(249,250,255,1) 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8FAFC;
            margin: 0;
        }

        .dashboard-layout { 
            display: flex; 
            min-height: 100vh; 
            background: var(--background); 
            background-image: radial-gradient(circle at top right, rgba(236, 72, 153, 0.08) 0%, transparent 40%),
                              radial-gradient(circle at bottom left, rgba(139, 92, 246, 0.08) 0%, transparent 40%);
        }
        .sidebar-wrapper { width: 260px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; z-index: 10; }
        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; }
        
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li a { display: block; padding: 16px 24px; color: var(--text-main); font-weight: 500; text-decoration: none; transition: 0.3s; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: var(--primary-light); color: var(--primary); border-right: 3px solid var(--primary); }
        .sidebar-menu li a i { margin-right: 12px; width: 20px; text-align: center; }
        
        .topbar { background: var(--surface); padding: 16px 40px; display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); }
        .topbar .logo { font-size: 1.25rem; font-weight: 700; color: var(--primary); }
        
        /* Modern Table Card */
        .history-card {
            background: var(--gradient-card);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.05);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-header {
            padding: 30px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            background: var(--soft-purple);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1E293B;
            margin: 0;
            letter-spacing: -0.5px;
        }

        /* Modern Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
            padding: 0 20px 20px 20px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        thead th {
            background: transparent;
            color: #64748B;
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 20px;
            text-align: left;
            border-bottom: 2px solid #E2E8F0;
        }

        tbody tr {
            background: #FFFFFF;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(139, 92, 246, 0.08);
        }

        tbody td {
            padding: 20px;
            font-size: 0.95rem;
            color: #334155;
            vertical-align: middle;
        }

        tbody td:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; border-left: 1px solid #E2E8F0; }
        tbody td:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; border-right: 1px solid #E2E8F0; }
        tbody td { border-top: 1px solid #E2E8F0; border-bottom: 1px solid #E2E8F0; }

        .complaint-no {
            font-weight: 600;
            color: var(--primary);
            font-size: 1rem;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-not-processed { background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }
        .status-in-process { background: #FEF3C7; color: #D97706; border: 1px solid #FDE68A; }
        .status-closed { background: #DCFCE7; color: #16A34A; border: 1px solid #BBF7D0; }

        .btn-view {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(139, 92, 246, 0.4);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #CBD5E1;
            margin-bottom: 16px;
        }
        
        .empty-state h3 {
            color: #475569;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }
        
        .empty-state p {
            color: #94A3B8;
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
                <div class="history-card">
                    <div class="card-header">
                        <div class="header-icon">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <h2>Your Complaint History</h2>
                    </div>

                    @if(count($complaints) > 0)
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
                                    <td><span class="complaint-no">#{{ $row->complaintNumber }}</span></td>
                                    <td><i class="fa-regular fa-calendar" style="color: #94A3B8; margin-right: 8px;"></i> {{ date('d M Y, h:i A', strtotime($row->regDate)) }}</td>
                                    <td>
                                        @if($row->lastUpdationDate)
                                            <i class="fa-solid fa-pen-rotate" style="color: #94A3B8; margin-right: 8px;"></i> {{ date('d M Y, h:i A', strtotime($row->lastUpdationDate)) }}
                                        @else
                                            <span style="color: #94A3B8;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(is_null($row->status) || $row->status == "")
                                            <span class="status-badge status-not-processed"><i class="fa-solid fa-circle-exclamation" style="margin-right: 6px;"></i> Not Processed</span>
                                        @elseif(strtolower($row->status) == "in process")
                                            <span class="status-badge status-in-process"><i class="fa-solid fa-spinner" style="margin-right: 6px;"></i> In Process</span>
                                        @elseif(strtolower($row->status) == "closed")
                                            <span class="status-badge status-closed"><i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i> Closed</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="/users/complaint-details/{{ $row->complaintNumber }}" class="btn-view">
                                            View Details <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="fa-solid fa-folder-open"></i>
                        <h3>No Complaints Found</h3>
                        <p>You haven't registered any complaints yet.</p>
                        <a href="/users/register-complaint" class="btn-view" style="margin-top: 16px;">
                            <i class="fa fa-plus"></i> New Complaint
                        </a>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>
