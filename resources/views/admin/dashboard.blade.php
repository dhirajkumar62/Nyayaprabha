<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha Admin | Enterprise Dashboard</title>

    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet Map CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        :root {
            --admin-primary: #7C3AED;
            --admin-primary-light: #F5F3FF;
            --admin-secondary: #EC4899;
            --admin-bg: #F8FAFC;
            --admin-surface: #FFFFFF;
            --admin-text-main: #0F172A;
            --admin-text-muted: #64748B;
            --admin-border: #E2E8F0;
        }

        body { font-family: 'Poppins', sans-serif; background: var(--admin-bg); margin: 0; color: var(--admin-text-main); }
        .dashboard-layout { display: flex; min-height: 100vh; }
        
        /* Fixed Sidebar */
        .sidebar-wrapper { width: 280px; background: var(--admin-surface); border-right: 1px solid var(--admin-border); flex-shrink: 0; z-index: 10; display: flex; flex-direction: column; height: 100vh; position: sticky; top: 0; overflow-y: auto; }
        
        .sidebar-menu { list-style: none; padding: 0; margin-top: 10px; }
        .sidebar-menu li { margin-bottom: 4px; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 14px 24px; color: var(--admin-text-muted) !important; font-weight: 500; text-decoration: none; font-size: 0.95rem; transition: all 0.2s ease; border-right: 3px solid transparent; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: var(--admin-primary-light); color: var(--admin-primary) !important; border-right: 3px solid var(--admin-primary); font-weight: 600; }
        .sidebar-menu li a i { margin-right: 14px; width: 20px; text-align: center; font-size: 1.1rem; opacity: 0.8; }
        .sidebar-menu li a:hover i { opacity: 1; }

        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; background: var(--admin-bg); background-image: radial-gradient(circle at top right, rgba(236, 72, 153, 0.03) 0%, transparent 40%); }
        
        /* Fixed Header */
        .topbar { background: var(--admin-surface); padding: 16px 40px; display: flex; justify-content: space-between; border-bottom: 1px solid var(--admin-border); position: sticky; top: 0; z-index: 100; box-shadow: 0 2px 10px rgba(0,0,0,0.02); align-items: center; }
        .topbar .logo { font-size: 1.25rem; font-weight: 700; color: var(--admin-primary); text-decoration: none; display: flex; align-items: center; gap: 10px; }
        
        /* Alerts */
        .alert-banner { background: #FFF1F2; border: 1px solid #FECDD3; border-left: 4px solid #E11D48; border-radius: 12px; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; box-shadow: 0 4px 12px rgba(225, 29, 72, 0.05); }
        .alert-text { color: #BE123C; font-weight: 600; display: flex; align-items: center; gap: 12px; font-size: 1rem; }
        .alert-pulse { width: 12px; height: 12px; border-radius: 50%; background: #E11D48; box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7); animation: pulse 1.5s infinite; }
        @keyframes pulse { 0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7); } 70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(225, 29, 72, 0); } 100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0); } }

        /* 6-Card Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px; }
        .stat-card { background: var(--admin-surface); border-radius: 16px; padding: 24px; border: 1px solid var(--admin-border); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02); display: flex; align-items: center; gap: 20px; transition: transform 0.3s ease, box-shadow 0.3s ease; position: relative; overflow: hidden; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 25px rgba(124, 58, 237, 0.1); border-color: #DDD6FE; }
        .stat-card::before { content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 4px; background: var(--admin-primary); border-radius: 4px 0 0 4px; opacity: 0; transition: opacity 0.3s ease; }
        .stat-card:hover::before { opacity: 1; }
        
        .stat-icon { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .stat-info { flex-grow: 1; }
        .stat-info h3 { font-size: 1.8rem; margin: 0 0 4px 0; color: var(--admin-text-main); font-weight: 700; line-height: 1; }
        .stat-info p { color: var(--admin-text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin: 0; }

        /* Icon Colors */
        .icon-users { background: #E0E7FF; color: #4F46E5; }
        .icon-active { background: #DCFCE7; color: #16A34A; }
        .icon-sos { background: #FEE2E2; color: #DC2626; }
        .icon-pending { background: #FEF3C7; color: #D97706; }
        .icon-resolved { background: #E0F2FE; color: #0284C7; }
        .icon-contacts { background: #F3E8FF; color: #9333EA; }

        /* Dashboard Main Grid */
        .dashboard-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px; }
        
        .panel { background: var(--admin-surface); border-radius: 20px; padding: 28px; border: 1px solid var(--admin-border); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03); }
        .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .panel-title { font-size: 1.2rem; font-weight: 700; color: var(--admin-text-main); display: flex; align-items: center; gap: 10px; margin: 0; }
        
        .badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-error { background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }
        .badge-success { background: #DCFCE7; color: #16A34A; border: 1px solid #BBF7D0; }

        /* Map & Charts */
        .map-container { width: 100%; height: 400px; border-radius: 12px; overflow: hidden; border: 1px solid var(--admin-border); position: relative; z-index: 1; }
        .chart-container { width: 100%; height: 350px; position: relative; }

        /* Recent Activity */
        .activity-list { list-style: none; padding: 0; margin: 0; }
        .activity-item { padding: 16px 0; border-bottom: 1px solid #F1F5F9; display: flex; gap: 16px; align-items: flex-start; }
        .activity-item:last-child { border-bottom: none; padding-bottom: 0; }
        .activity-icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1rem; }
        .activity-details { flex-grow: 1; }
        .activity-details h4 { font-size: 0.95rem; margin: 0 0 4px 0; font-weight: 600; color: var(--admin-text-main); }
        .activity-details p { font-size: 0.85rem; color: var(--admin-text-muted); margin: 0; line-height: 1.4; }
        .activity-time { font-size: 0.75rem; color: #94A3B8; margin-top: 6px; font-weight: 500; display: flex; align-items: center; gap: 4px; }
        
        .act-sos { background: #FEE2E2; color: #DC2626; }
        .act-complaint { background: #FEF3C7; color: #D97706; }
        .act-user { background: #E0E7FF; color: #4F46E5; }

        /* User Menu */
        .user-menu { display: flex; align-items: center; gap: 16px; }
        .btn-outline-primary { background: transparent; border: 1px solid var(--admin-primary); color: var(--admin-primary); padding: 8px 16px; border-radius: 50px; text-decoration: none; font-size: 0.9rem; font-weight: 500; transition: 0.2s; }
        .btn-outline-primary:hover { background: var(--admin-primary); color: white; }
        
        @media (max-width: 1200px) {
            .dashboard-grid { grid-template-columns: 1fr; }
        }
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
                <a href="/admin/dashboard" class="logo">
                    <i class="fa-solid fa-shield-halved"></i>
                    Nyayaprabha Admin
                </a>
                <div class="user-menu">
                    <span class="badge badge-success"><i class="fa-solid fa-check-circle" style="margin-right: 4px;"></i> System Secure</span>
                    <a href="/admin/logout" class="btn-outline-primary"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </div>
            </header>
            
            <main class="main-content">
                
                @if($sosAlerts > 0)
                <div class="alert-banner">
                    <div class="alert-text">
                        <div class="alert-pulse"></div>
                        <span>SYSTEM: {{ $sosAlerts }} Active SOS Alert(s) require immediate attention.</span>
                    </div>
                    <a href="#map-section" class="btn btn-primary" style="background-color: #E11D48; border-color: #E11D48; color: white; padding: 8px 16px; border-radius: 50px; text-decoration: none; font-weight: 500;"><i class="fa-solid fa-map-location-dot" style="margin-right: 8px;"></i> View on Map</a>
                </div>
                @endif

                <!-- 6-Card Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon icon-users"><i class="fa-solid fa-users"></i></div>
                        <div class="stat-info">
                            <h3>{{ $totalUsers }}</h3>
                            <p>Total Users</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon icon-active"><i class="fa-solid fa-user-check"></i></div>
                        <div class="stat-info">
                            <h3>{{ $activeUsers }}</h3>
                            <p>Active Users</p>
                        </div>
                    </div>

                    <div class="stat-card" style="border-color: {{ $sosAlerts > 0 ? '#FECACA' : 'var(--admin-border)' }};">
                        <div class="stat-icon icon-sos"><i class="fa-solid fa-bell"></i></div>
                        <div class="stat-info">
                            <h3 style="color: {{ $sosAlerts > 0 ? '#DC2626' : 'var(--admin-text-main)' }};">{{ $sosAlerts }}</h3>
                            <p>Active SOS Alerts</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon icon-pending"><i class="fa-solid fa-folder-open"></i></div>
                        <div class="stat-info">
                            <h3>{{ $pendingComplaints }}</h3>
                            <p>Pending Complaints</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon icon-resolved"><i class="fa-solid fa-clipboard-check"></i></div>
                        <div class="stat-info">
                            <h3>{{ $resolvedCases }}</h3>
                            <p>Resolved Cases</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon icon-contacts"><i class="fa-solid fa-address-book"></i></div>
                        <div class="stat-info">
                            <h3>{{ $emergencyRequests }}</h3>
                            <p>Emergency Contacts</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <!-- Analytics Chart Panel -->
                    <div class="panel" style="grid-column: 1 / -1;">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fa-solid fa-chart-area" style="color: var(--admin-primary);"></i> Platform Analytics</h3>
                            <select style="padding: 6px 12px; border-radius: 8px; border: 1px solid var(--admin-border); outline: none;">
                                <option>This Week</option>
                                <option>This Month</option>
                                <option>This Year</option>
                            </select>
                        </div>
                        <div class="chart-container">
                            <canvas id="analyticsChart"></canvas>
                        </div>
                    </div>

                    <!-- Live SOS Map Panel -->
                    <div class="panel" id="map-section">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fa-solid fa-map-marked-alt" style="color: #EC4899;"></i> Live SOS Tracking Map</h3>
                            @if($sosAlerts > 0)
                                <div class="badge badge-error" style="animation: pulse 1.5s infinite;"><i class="fa-solid fa-satellite-dish" style="margin-right: 6px;"></i> Live Tracking</div>
                            @else
                                <div class="badge badge-success"><i class="fa-solid fa-satellite-dish" style="margin-right: 6px;"></i> Standby</div>
                            @endif
                        </div>
                        <div class="map-container" id="sosMap"></div>
                    </div>

                    <!-- Recent Activity Panel -->
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fa-solid fa-bolt" style="color: #F59E0B;"></i> Recent Activity</h3>
                        </div>
                        <ul class="activity-list">
                            @forelse($recentActivity as $activity)
                                <li class="activity-item">
                                    @if($activity->type == 'sos')
                                        <div class="activity-icon act-sos"><i class="fa-solid fa-triangle-exclamation"></i></div>
                                    @elseif($activity->type == 'complaint')
                                        <div class="activity-icon act-complaint"><i class="fa-solid fa-file-signature"></i></div>
                                    @else
                                        <div class="activity-icon act-user"><i class="fa-solid fa-user-plus"></i></div>
                                    @endif
                                    
                                    <div class="activity-details">
                                        <h4>{{ $activity->title }}</h4>
                                        <p>By User: <strong>{{ $activity->user }}</strong></p>
                                        <div class="activity-time"><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($activity->time)->diffForHumans() }}</div>
                                    </div>
                                </li>
                            @empty
                                <li style="text-align: center; color: var(--admin-text-muted); padding: 20px 0;">No recent activity found.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

            </main>
            @include('includes.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Chart.js Setup
            const ctx = document.getElementById('analyticsChart').getContext('2d');
            
            // Gradient for chart
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(124, 58, 237, 0.4)');   
            gradient.addColorStop(1, 'rgba(124, 58, 237, 0.0)');

            let gradient2 = ctx.createLinearGradient(0, 0, 0, 400);
            gradient2.addColorStop(0, 'rgba(236, 72, 153, 0.4)');   
            gradient2.addColorStop(1, 'rgba(236, 72, 153, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [
                        {
                            label: 'Complaints Registered',
                            data: [5, 9, 3, 14, 8, 5, {{ $pendingComplaints + $resolvedCases }}],
                            borderColor: '#7C3AED',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#FFFFFF',
                            pointBorderColor: '#7C3AED',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        },
                        {
                            label: 'SOS Triggers',
                            data: [1, 0, 2, 0, 3, 1, {{ $sosAlerts }}],
                            borderColor: '#EC4899',
                            backgroundColor: gradient2,
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#FFFFFF',
                            pointBorderColor: '#EC4899',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { usePointStyle: true, boxWidth: 8, font: { family: 'Poppins', size: 13 } } }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#E2E8F0' }, border: { display: false } },
                        x: { grid: { display: false }, border: { display: false } }
                    },
                    interaction: { mode: 'index', intersect: false }
                }
            });

            // Leaflet Map Setup
            const map = L.map('sosMap').setView([20.5937, 78.9629], 4); // Default to India center
            
            // Minimalist CartoDB Positron tiles for professional look
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
                subdomains: 'abcd',
                maxZoom: 20
            }).addTo(map);

            // Custom SOS Marker Icon
            const sosIcon = L.divIcon({
                className: 'custom-sos-marker',
                html: '<div style="background-color: #E11D48; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.4); display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; animation: pulse 1.5s infinite;"><i class="fa-solid fa-exclamation"></i></div>',
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });

            // Add live SOS alerts from DB
            const liveAlerts = @json($liveSosAlerts);
            let bounds = [];
            
            if (liveAlerts && liveAlerts.length > 0) {
                liveAlerts.forEach(alert => {
                    if (alert.latitude && alert.longitude) {
                        const marker = L.marker([alert.latitude, alert.longitude], {icon: sosIcon}).addTo(map);
                        marker.bindPopup(`<b>🚨 SOS Alert!</b><br><b>User:</b> ${alert.user_name}<br><b>Contact:</b> ${alert.contactNo}<br><b>Time:</b> ${new Date(alert.created_at).toLocaleString()}`);
                        bounds.push([alert.latitude, alert.longitude]);
                    }
                });
                
                if (bounds.length > 0) {
                    map.fitBounds(bounds, {padding: [50, 50]});
                }
            } else {
                // Dummy marker for visualization if no real data
                L.marker([28.6139, 77.2090], {
                    icon: L.divIcon({
                        className: 'dummy-marker',
                        html: '<div style="background-color: #94A3B8; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white;"></div>',
                        iconSize: [16, 16]
                    })
                }).addTo(map).bindPopup("No active SOS alerts. Safe zone.");
            }
        });
    </script>
</body>
</html>
