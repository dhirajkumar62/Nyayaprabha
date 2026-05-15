
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha Admin | Women Safety Dashboard</title>

    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout { display: flex; min-height: 100vh; background: var(--background); }
        .sidebar-wrapper { width: 280px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; z-index: 10; display: flex; flex-direction: column; height: 100vh; position: sticky; top: 0; overflow-y: auto; }
        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; background: var(--background); }
        
        .alert-banner {
            background: rgba(225, 29, 72, 0.05);
            border: 1px solid rgba(225, 29, 72, 0.2);
            border-left: 4px solid var(--accent);
            border-radius: var(--radius-md);
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            box-shadow: 0 4px 12px rgba(225, 29, 72, 0.05);
        }
        
        .alert-text { color: var(--accent); font-weight: 600; display: flex; align-items: center; gap: 12px; font-size: 1.05rem; }
        .alert-pulse {
            width: 12px; height: 12px; border-radius: 50%; background: var(--accent);
            box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7);
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(225, 29, 72, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0); }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: var(--transition);
        }
        
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(124, 58, 237, 0.1); border-color: var(--primary-light); }

        .stat-icon {
            width: 64px; height: 64px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center; font-size: 1.8rem;
        }

        .stat-info h3 { font-size: 2rem; margin-bottom: 4px; color: var(--text-main); font-weight: 800; }
        .stat-info p { color: var(--text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .panel {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 28px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .panel-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;
        }
        
        .panel-title { font-size: 1.25rem; font-weight: 700; color: var(--text-main); display: flex; align-items: center; gap: 12px; }

        .map-placeholder {
            width: 100%; height: 380px; background: #f8fafc; border-radius: var(--radius-md);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            border: 2px dashed #cbd5e1; color: var(--text-muted); position: relative; overflow: hidden;
        }
        
        .map-placeholder::before {
            content: ''; position: absolute; width: 100%; height: 100%;
            background: url('https://cdn-icons-png.flaticon.com/512/854/854878.png') no-repeat center;
            background-size: 150px; opacity: 0.03;
        }

        .activity-list { list-style: none; padding: 0; }
        .activity-item {
            padding: 16px 0; border-bottom: 1px solid var(--border); display: flex; gap: 16px; align-items: flex-start;
        }
        .activity-item:last-child { border-bottom: none; padding-bottom: 0; }
        .activity-icon {
            width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            background: var(--primary-light); color: var(--primary); flex-shrink: 0; font-size: 1.1rem;
        }
        .activity-details h4 { font-size: 1rem; margin-bottom: 4px; font-weight: 600; color: var(--text-main); }
        .activity-details p { font-size: 0.9rem; color: var(--text-muted); line-height: 1.4; }
        .activity-time { font-size: 0.8rem; color: var(--text-muted); margin-top: 6px; font-weight: 500; }
        
        /* Fixed Sidebar Styles */
        .sidebar-menu { list-style: none; padding: 0; margin-top: 10px; }
        .sidebar-menu li { margin-bottom: 4px; }
        .sidebar-menu li a { 
            display: flex; align-items: center; padding: 12px 24px; 
            color: #475569 !important; font-weight: 500; text-decoration: none; font-size: 0.95rem;
            transition: all 0.2s ease; border-right: 3px solid transparent;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { 
            background: var(--primary-light); color: var(--primary) !important; 
            border-right: 3px solid var(--primary); font-weight: 600;
        }
        .sidebar-menu li a i { margin-right: 14px; width: 20px; text-align: center; font-size: 1.1rem; opacity: 0.8; }
        .sidebar-menu li a:hover i { opacity: 1; }
        
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
            @include('admin.include.header')
            
            <main class="main-content">
                
                <div class="alert-banner">
                    <div class="alert-text">
                        <div class="alert-pulse"></div>
                        <span>SYSTEM: 2 Active SOS Alerts in your jurisdiction require immediate attention.</span>
                    </div>
                    <button class="btn btn-primary" style="background-color: var(--accent);"><i class="fa fa-map-marker-alt" style="margin-right: 8px;"></i> View on Map</button>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;"><i class="fa fa-exclamation-circle"></i></div>
                        <div class="stat-info">
                            <h3>{{ $num1 }}</h3>
                            <p>New Complaints</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;"><i class="fa fa-spinner"></i></div>
                        <div class="stat-info">
                            <h3>{{ $num2 }}</h3>
                            <p>In Progress</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;"><i class="fa fa-check-circle"></i></div>
                        <div class="stat-info">
                            <h3>{{ $num3 }}</h3>
                            <p>Resolved</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background: var(--primary-light); color: var(--primary);"><i class="fa fa-users"></i></div>
                        <div class="stat-info">
                            <h3>{{ $num4 }}</h3>
                            <p>Registered Users</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fa fa-map-marked-alt" style="color: var(--primary);"></i> Live SOS & Incident Map</h3>
                            <div class="badge badge-error">Live Tracking Active</div>
                        </div>
                        <div class="map-placeholder">
                            <i class="fa fa-satellite-dish" style="font-size: 3rem; margin-bottom: 16px; color: var(--text-muted); opacity: 0.5;"></i>
                            <p style="font-weight: 500;">Interactive GIS Map Placeholder</p>
                            <p style="font-size: 0.85rem;">Requires Google Maps / Mapbox API Integration for Live SOS Tracking</p>
                            
                            <div style="position: absolute; top: 20px; left: 20px; display: flex; flex-direction: column; gap: 8px;">
                                <span class="badge badge-error"><i class="fa fa-map-marker-alt"></i> SOS - Delhi (2 mins ago)</span>
                                <span class="badge badge-error"><i class="fa fa-map-marker-alt"></i> SOS - Mumbai (5 mins ago)</span>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fa fa-bolt" style="color: var(--warning);"></i> Recent Activity</h3>
                        </div>
                        <ul class="activity-list">
                            <li class="activity-item">
                                <div class="activity-icon" style="background: rgba(225, 29, 72, 0.1); color: var(--accent);"><i class="fa fa-bell"></i></div>
                                <div class="activity-details">
                                    <h4>SOS Alert Triggered</h4>
                                    <p>User #1042 activated emergency SOS in South Delhi.</p>
                                    <div class="activity-time">Just now</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon"><i class="fa fa-file-signature"></i></div>
                                <div class="activity-details">
                                    <h4>New Complaint Logged</h4>
                                    <p>Complaint #45 registered under Domestic Violence.</p>
                                    <div class="activity-time">10 mins ago</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon" style="background: rgba(16, 185, 129, 0.1); color: #10B981;"><i class="fa fa-check"></i></div>
                                <div class="activity-details">
                                    <h4>Complaint Resolved</h4>
                                    <p>Officer Sharma closed Case #39.</p>
                                    <div class="activity-time">1 hour ago</div>
                                </div>
                            </li>
                            <li class="activity-item">
                                <div class="activity-icon" style="background: rgba(245, 158, 11, 0.1); color: #F59E0B;"><i class="fa fa-user-plus"></i></div>
                                <div class="activity-details">
                                    <h4>New User Registration</h4>
                                    <p>A new user verified their account via OTP.</p>
                                    <div class="activity-time">2 hours ago</div>
                                </div>
                            </li>
                        </ul>
                        <a href="#" class="btn btn-secondary" style="width: 100%; margin-top: 16px;">View All Logs</a>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
