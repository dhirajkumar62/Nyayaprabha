

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Women Safety Dashboard</title>

    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --soft-pink: #FFF0F5;
            --soft-purple: #F3E8FF;
            --safety-red: #FF3B30;
            --safety-red-hover: #D32F2F;
            --card-bg: #FFFFFF;
            --text-dark: #2D3748;
            --text-gray: #718096;
            --gradient-primary: linear-gradient(135deg, #EC4899 0%, #8B5CF6 100%);
            --gradient-sos: linear-gradient(135deg, #FF416C 0%, #FF4B2B 100%);
            --gradient-card: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(249,250,255,1) 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F8FAFC;
        }

        .dashboard-layout {
            display: flex;
            min-height: 100vh;
            background: var(--background);
            background-image: radial-gradient(circle at top right, rgba(236, 72, 153, 0.08) 0%, transparent 40%),
                              radial-gradient(circle at bottom left, rgba(139, 92, 246, 0.08) 0%, transparent 40%);
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
            padding: 32px 40px;
            overflow-y: auto;
        }
        
        /* Banner */
        .welcome-banner {
            background: var(--gradient-primary);
            border-radius: 24px;
            padding: 40px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            box-shadow: 0 15px 30px rgba(139, 92, 246, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 50%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
            transform: rotate(30deg);
        }

        .welcome-text {
            position: relative;
            z-index: 2;
        }
        
        .welcome-text h2 { 
            color: white; 
            font-size: 2.2rem; 
            font-weight: 700;
            margin-bottom: 12px; 
            letter-spacing: -0.5px;
        }
        
        .welcome-text p { 
            color: rgba(255, 255, 255, 0.95); 
            font-size: 1.15rem; 
            max-width: 600px;
            line-height: 1.6;
        }
        
        /* Pulsing SOS Button */
        .sos-btn-wrapper {
            position: relative;
            z-index: 2;
        }

        .sos-btn {
            background: var(--gradient-sos);
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(255, 59, 48, 0.5);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            position: relative;
        }
        
        .sos-btn::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border-radius: 50px;
            border: 2px solid #FF4B2B;
            animation: pulse-ring 2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
            z-index: -1;
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.3); opacity: 0; }
        }
        
        .sos-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 30px rgba(255, 59, 48, 0.6);
        }

        .sos-btn i { font-size: 1.5rem; }

        /* Section Titles */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-dark);
            position: relative;
            padding-left: 16px;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 24px;
            background: var(--gradient-primary);
            border-radius: 10px;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 28px;
            margin-bottom: 40px;
        }

        /* Modern Cards */
        .modern-card {
            background: var(--gradient-card);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
        }

        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 30px rgba(139, 92, 246, 0.1);
            border-color: rgba(236, 72, 153, 0.3);
        }
        
        .modern-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 150px; height: 150px;
            background: radial-gradient(circle, rgba(236, 72, 153, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
            transition: all 0.4s ease;
        }

        .modern-card:hover::after {
            transform: translate(10%, -10%) scale(1.2);
        }

        .card-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .icon-location { background: #E0F2FE; color: #0284C7; }
        .icon-contacts { background: #FCE7F3; color: #DB2777; }
        .icon-safe { background: #DCFCE7; color: #16A34A; }
        .icon-helpline { background: #FEF3C7; color: #D97706; }

        .modern-card h3 { 
            font-size: 1.25rem; 
            font-weight: 600;
            margin-bottom: 12px; 
            color: var(--text-dark); 
            z-index: 2;
        }
        
        .modern-card p { 
            color: var(--text-gray); 
            font-size: 0.95rem; 
            line-height: 1.5;
            margin-bottom: 24px; 
            flex-grow: 1; 
            z-index: 2;
        }
        
        .card-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.95rem;
            transition: gap 0.3s ease;
            z-index: 2;
        }
        
        .modern-card:hover .card-action { 
            gap: 12px; 
            color: var(--secondary);
        }

        /* Stats & Analytics */
        .stats-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--border);
            margin-bottom: 40px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .stat-box {
            padding: 24px;
            background: #F8FAFC;
            border-radius: 16px;
            text-align: center;
            border: 1px solid #E2E8F0;
            transition: transform 0.3s ease;
        }
        
        .stat-box:hover {
            transform: translateY(-5px);
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.04);
        }

        .stat-value { 
            font-size: 2.5rem; 
            font-weight: 700; 
            margin-bottom: 8px; 
            font-family: 'Poppins', sans-serif;
        }
        
        .val-filed { color: #8B5CF6; }
        .val-pending { color: #F59E0B; }
        .val-resolved { color: #10B981; }

        .stat-label { 
            color: var(--text-gray); 
            font-size: 1rem; 
            font-weight: 500; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Safety Tips Section */
        .tips-section {
            background: linear-gradient(135deg, #FDF2F8 0%, #FAF5FF 100%);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid #FBCFE8;
        }
        
        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .tip-item {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            transition: transform 0.3s ease;
        }
        
        .tip-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }

        .tip-icon {
            width: 45px; height: 45px;
            background: #FCE7F3;
            color: #DB2777;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .tip-content h4 {
            font-size: 1.05rem;
            color: var(--text-dark);
            margin-bottom: 6px;
            font-weight: 600;
        }
        
        .tip-content p {
            font-size: 0.9rem;
            color: var(--text-gray);
            line-height: 1.5;
        }

        @media (max-width: 1024px) {
            .welcome-banner { flex-direction: column; text-align: center; gap: 30px; padding: 30px; }
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

        <div style="display: flex; flex-direction: column; flex-grow: 1; overflow-x: hidden;">
            @include('users.includes.header')
            
            <main class="main-content">
                
                <!-- Alerts -->
                @if(session('sos_success'))
                    <div style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10B981; color: #10B981; padding: 16px 24px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; font-weight: 500;">
                        <i class="fa fa-check-circle" style="margin-right: 12px; font-size: 1.2rem;"></i> <strong>SOS Dispatched:</strong> &nbsp;{{ session('sos_success') }}
                    </div>
                @endif
                
                @if(session('sos_error'))
                    <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #EF4444; color: #EF4444; padding: 16px 24px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; font-weight: 500;">
                        <i class="fa fa-exclamation-circle" style="margin-right: 12px; font-size: 1.2rem;"></i> <strong>SOS Alert Issue:</strong> &nbsp;{{ session('sos_error') }}
                    </div>
                @endif

                <!-- Welcome Banner & SOS -->
                <div class="welcome-banner">
                    <div class="welcome-text">
                        <h2>Your Safety is Our Priority</h2>
                        <p>Welcome to your personal safety dashboard. Access emergency services, manage trusted contacts, and stay protected anytime, anywhere.</p>
                    </div>
                    <div class="sos-btn-wrapper">
                        <form id="sosForm" action="/users/sos/trigger" method="POST">
                            @csrf
                            <input type="hidden" name="latitude" id="sos_lat" value="">
                            <input type="hidden" name="longitude" id="sos_lng" value="">
                            <button type="button" class="sos-btn" onclick="triggerSos()">
                                <i class="fa fa-exclamation-triangle"></i> Emergency SOS
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Quick Actions Grid -->
                <div class="section-header">
                    <h3 class="section-title">Safety Features</h3>
                </div>

                <div class="dashboard-grid">
                    <!-- Feature 1: Location -->
                    <a href="#" class="modern-card" onclick="alert('Live location tracking initiated.')">
                        <div class="card-icon-wrapper icon-location">
                            <i class="fa-solid fa-location-crosshairs"></i>
                        </div>
                        <h3>Live Location Sharing</h3>
                        <p>Instantly share your real-time GPS coordinates with trusted contacts and authorities during an emergency.</p>
                        <span class="card-action">Share Now <i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    
                    <!-- Feature 2: Emergency Contacts Panel -->
                    <a href="/users/emergency-contacts" class="modern-card">
                        <div class="card-icon-wrapper icon-contacts">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <h3>Emergency Contacts</h3>
                        <p>Manage your close circle of trusted contacts who will be instantly notified if you trigger an SOS alert.</p>
                        <span class="card-action">Manage Contacts <i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    
                    <!-- Feature 3: Safe Places -->
                    <a href="#" class="modern-card" onclick="alert('Opening map with safe zones...')">
                        <div class="card-icon-wrapper icon-safe">
                            <i class="fa-solid fa-house-chimney-medical"></i>
                        </div>
                        <h3>Nearby Safe Places</h3>
                        <p>Locate the nearest police stations, hospitals, and designated 24/7 safe zones in your immediate vicinity.</p>
                        <span class="card-action">View Map <i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                    
                    <!-- Feature 4: Helplines -->
                    <a href="/users/helplines" class="modern-card">
                        <div class="card-icon-wrapper icon-helpline">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h3>Helpline Numbers</h3>
                        <p>Quick directory access to national and state-level women safety helplines available 24 hours a day.</p>
                        <span class="card-action">Call Help <i class="fa-solid fa-arrow-right"></i></span>
                    </a>
                </div>
                
                <!-- Complaint Overview -->
                <div class="stats-container">
                    <div class="section-header" style="margin-bottom: 30px;">
                        <h3 class="section-title">My Complaints Overview</h3>
                        <a href="/users/register-complaint" class="btn btn-primary" style="background: var(--gradient-primary); color: white; border: none; border-radius: 50px; padding: 10px 24px; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center;">
                            <i class="fa fa-plus" style="margin-right: 8px;"></i> New Complaint
                        </a>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-value val-filed">{{ $num1 }}</div>
                            <div class="stat-label">Filed</div>
                        </div>
                        
                        <div class="stat-box">
                            <div class="stat-value val-pending">{{ $num2 }}</div>
                            <div class="stat-label">Pending</div>
                        </div>
                        
                        <div class="stat-box">
                            <div class="stat-value val-resolved">{{ $num3 }}</div>
                            <div class="stat-label">Resolved</div>
                        </div>
                    </div>
                </div>

                <!-- Safety Tips Section -->
                <div class="tips-section">
                    <div class="section-header">
                        <h3 class="section-title">Safety Tips & Awareness</h3>
                    </div>
                    <div class="tips-grid">
                        <div class="tip-item">
                            <div class="tip-icon"><i class="fa-solid fa-eye"></i></div>
                            <div class="tip-content">
                                <h4>Stay Aware</h4>
                                <p>Always be mindful of your surroundings. Avoid distractions like texting when walking alone in unfamiliar areas.</p>
                            </div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-icon"><i class="fa-solid fa-route"></i></div>
                            <div class="tip-content">
                                <h4>Share Your Route</h4>
                                <p>If traveling late, share your live trip status or cab details with a trusted family member or friend.</p>
                            </div>
                        </div>
                        <div class="tip-item">
                            <div class="tip-icon"><i class="fa-solid fa-mobile-screen"></i></div>
                            <div class="tip-content">
                                <h4>Keep Phone Charged</h4>
                                <p>Ensure your phone has sufficient battery before leaving. Keep the emergency SOS feature on standby.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </main>
            @include('includes.footer')
        </div>
    </div>

    <!-- SOS Trigger Script -->
    <script>
        function triggerSos() {
            if (confirm('WARNING: This will instantly send emergency SMS and Email alerts to all your registered contacts. Are you sure you want to trigger the SOS?')) {
                const btn = document.querySelector('.sos-btn');
                btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Locating...';
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.8';

                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            document.getElementById('sos_lat').value = position.coords.latitude;
                            document.getElementById('sos_lng').value = position.coords.longitude;
                            document.getElementById('sosForm').submit();
                        },
                        function(error) {
                            alert("Could not get your precise location, but the SOS will still be sent.");
                            document.getElementById('sosForm').submit();
                        },
                        { timeout: 10000 }
                    );
                } else {
                    document.getElementById('sosForm').submit();
                }
            }
        }
    </script>
</body>
</html>
