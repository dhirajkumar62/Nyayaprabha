

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Women Safety Dashboard</title>

    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
            background: var(--background);
            background-image: radial-gradient(circle at top right, rgba(139, 92, 246, 0.05) 0%, transparent 40%),
                              radial-gradient(circle at bottom left, rgba(236, 72, 153, 0.05) 0%, transparent 40%);
        }
        .sidebar-wrapper {
            width: 260px;
            background: var(--surface);
            border-right: 1px solid var(--border);
            flex-shrink: 0;
            z-index: 10;
        }
        .main-content {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
        }
        
        .welcome-banner {
            background: var(--primary-gradient);
            border-radius: var(--radius-xl);
            padding: 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px -5px rgba(124, 58, 237, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-banner::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            width: 300px;
            height: 100%;
            background: url('https://cdn-icons-png.flaticon.com/512/3366/3366113.png') no-repeat right center;
            background-size: contain;
            opacity: 0.15;
            pointer-events: none;
        }
        
        .welcome-text h2 { color: white; font-size: 2rem; margin-bottom: 8px; }
        .welcome-text p { color: rgba(255, 255, 255, 0.9); font-size: 1.1rem; }
        
        .sos-btn {
            background: var(--accent-gradient);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: var(--radius-full);
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(225, 29, 72, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 2;
        }
        
        .sos-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 25px rgba(225, 29, 72, 0.5);
        }

        .sos-btn i { font-size: 1.5rem; }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .feature-card {
            background: var(--surface-glass);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
        }

        .icon-primary { background: var(--primary-light); color: var(--primary); }
        .icon-secondary { background: rgba(236, 72, 153, 0.1); color: var(--secondary); }
        .icon-success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .icon-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning); }

        .feature-card h3 { font-size: 1.2rem; margin-bottom: 8px; color: var(--text-main); }
        .feature-card p { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 16px; flex-grow: 1; }
        
        .feature-link {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .feature-link:hover { color: var(--primary-hover); gap: 10px; }

        .stats-section {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: var(--background);
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
        }

        .stat-item h4 { font-size: 2rem; color: var(--primary); margin-bottom: 4px; }
        .stat-item p { color: var(--text-muted); font-size: 0.9rem; font-weight: 500; }

        @media (max-width: 992px) {
            .welcome-banner { flex-direction: column; text-align: center; gap: 24px; }
            .stats-grid { grid-template-columns: 1fr; }
        }
        
        /* Temporary Sidebar & Header fixes */
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li a { display: block; padding: 16px 24px; color: var(--text-main); font-weight: 500; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: var(--primary-light); color: var(--primary); border-right: 3px solid var(--primary); }
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
                
                <div class="welcome-banner">
                    <div class="welcome-text">
                        <h2>Your Safety is Our Priority</h2>
                        <p>Access emergency services, register complaints, and stay protected.</p>
                    </div>
                    <form id="sosForm" action="/users/sos/trigger" method="POST">
                        @csrf
                        <input type="hidden" name="latitude" id="sos_lat" value="">
                        <input type="hidden" name="longitude" id="sos_lng" value="">
                        <button type="button" class="sos-btn" onclick="triggerSos()">
                            <i class="fa fa-exclamation-triangle"></i> Emergency SOS
                        </button>
                    </form>
                    
                    <script>
                        function triggerSos() {
                            if (confirm('WARNING: This will instantly send emergency SMS and Email alerts to all your registered contacts. Are you sure you want to trigger the SOS?')) {
                                const btn = document.querySelector('.sos-btn');
                                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Locating...';
                                btn.disabled = true;

                                if ("geolocation" in navigator) {
                                    navigator.geolocation.getCurrentPosition(
                                        function(position) {
                                            // Success: add location and submit
                                            document.getElementById('sos_lat').value = position.coords.latitude;
                                            document.getElementById('sos_lng').value = position.coords.longitude;
                                            document.getElementById('sosForm').submit();
                                        },
                                        function(error) {
                                            // Error/Denied: submit without location
                                            alert("Could not get your precise location, but the SOS will still be sent.");
                                            document.getElementById('sosForm').submit();
                                        },
                                        { timeout: 10000 } // wait max 10 seconds for location
                                    );
                                } else {
                                    // Geolocation not supported, submit anyway
                                    document.getElementById('sosForm').submit();
                                }
                            }
                        }
                    </script>
                </div>
                
                @if(session('sos_success'))
                    <div style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10B981; color: #10B981; padding: 16px; border-radius: 4px; margin-bottom: 24px;">
                        <i class="fa fa-check-circle" style="margin-right: 8px;"></i> <strong>SOS Dispatched:</strong> {{ session('sos_success') }}
                    </div>
                @endif
                
                @if(session('sos_error'))
                    <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #EF4444; color: #EF4444; padding: 16px; border-radius: 4px; margin-bottom: 24px;">
                        <i class="fa fa-exclamation-circle" style="margin-right: 8px;"></i> <strong>SOS Alert Issue:</strong> {{ session('sos_error') }}
                    </div>
                @endif
                
                <div class="feature-grid">
                    <!-- Feature 1 -->
                    <div class="feature-card">
                        <div class="feature-icon icon-primary">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <h3>Live Location Sharing</h3>
                        <p>Instantly share your real-time location with trusted contacts and authorities during an emergency.</p>
                        <a href="#" class="feature-link" onclick="alert('Live location tracking initiated.')">Share Location <i class="fa fa-arrow-right"></i></a>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="feature-card">
                        <div class="feature-icon icon-secondary">
                            <i class="fa fa-shield-alt"></i>
                        </div>
                        <h3>Nearby Safe Places</h3>
                        <p>Locate the nearest police stations, hospitals, and designated safe zones in your vicinity.</p>
                        <a href="#" class="feature-link" onclick="alert('Opening map with safe zones...')">View Map <i class="fa fa-arrow-right"></i></a>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="feature-card">
                        <div class="feature-icon icon-warning">
                            <i class="fa fa-phone-alt"></i>
                        </div>
                        <h3>Helpline Numbers</h3>
                        <p>Quick access to national and state-level women safety helplines available 24/7.</p>
                        <a href="#" class="feature-link">View Helplines <i class="fa fa-arrow-right"></i></a>
                    </div>
                    
                    <!-- Feature 4 -->
                    <div class="feature-card">
                        <div class="feature-icon icon-success">
                            <i class="fa fa-hands-helping"></i>
                        </div>
                        <h3>Community Support</h3>
                        <p>Connect with local NGOs, support groups, and legal aid volunteers for assistance and guidance.</p>
                        <a href="#" class="feature-link">Get Support <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                
                <div class="stats-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <h3 style="font-size: 1.25rem;">Complaint Overview</h3>
                        <a href="register-complaint.php" class="btn btn-primary btn-sm" style="padding: 8px 16px;"><i class="fa fa-plus"></i> New Complaint</a>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-item">
                            <h4>{{ $num1 }}</h4>
                            <p>Filed</p>
                        </div>
                        
                        <div class="stat-item">
                            <h4 style="color: var(--warning);">{{ $num2 }}</h4>
                            <p>Pending</p>
                        </div>
                        
                        <div class="stat-item">
                            <h4 style="color: var(--success);">{{ $num3 }}</h4>
                            <p>Resolved</p>
                        </div>
                    </div>
                </div>
                
            </main>
        </div>
    </div>
</body>
</html>
