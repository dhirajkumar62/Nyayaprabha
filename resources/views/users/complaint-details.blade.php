
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Complaint Details</title>

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

        body { font-family: 'Poppins', sans-serif; background: #F8FAFC; color: #1f2937; margin: 0; }
        .dashboard-layout { display: flex; min-height: 100vh; }
        .sidebar-wrapper { width: 260px; background: #ffffff; border-right: 1px solid #e5e7eb; flex-shrink: 0; z-index: 10; }
        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; background: #F8FAFC; background-image: radial-gradient(circle at top right, rgba(236, 72, 153, 0.05) 0%, transparent 40%); }
        
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li a { display: block; padding: 16px 24px; color: #4b5563; font-weight: 500; text-decoration: none; transition: 0.2s; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: #eff6ff; color: #2563eb; border-right: 3px solid #2563eb; }
        .sidebar-menu li a i { margin-right: 12px; width: 20px; text-align: center; }
        
        .topbar { background: #ffffff; padding: 16px 40px; display: flex; justify-content: space-between; border-bottom: 1px solid #e5e7eb; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .topbar .logo { font-size: 1.25rem; font-weight: 700; color: #7C3AED; text-decoration: none; }
        
        /* Premium Layout */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
        .page-title { font-size: 1.875rem; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; }
        .page-subtitle { font-size: 0.875rem; color: #64748B; margin-top: 6px; display: flex; align-items: center; gap: 8px; }
        
        .btn-outline { background: white; border: 1px solid #E2E8F0; color: #475569; padding: 10px 20px; border-radius: 50px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; transition: 0.3s; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .btn-outline:hover { background: #F1F5F9; color: #0F172A; transform: translateY(-2px); }
        
        .content-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; align-items: start; }
        
        /* Modern Cards */
        .saas-card { background: #ffffff; border-radius: 20px; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.05); border: 1px solid rgba(226, 232, 240, 0.8); overflow: hidden; margin-bottom: 30px; }
        .card-header { padding: 24px 30px; border-bottom: 1px solid #F1F5F9; background: #ffffff; display: flex; justify-content: space-between; align-items: center; }
        .card-title { font-size: 1.2rem; font-weight: 600; color: #1E293B; margin: 0; display: flex; align-items: center; gap: 10px; }
        .card-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: var(--soft-purple); color: #7C3AED; }
        .card-body { padding: 30px; }
        
        /* Badges */
        .status-badge { display: inline-flex; align-items: center; padding: 6px 16px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-not-processed { background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }
        .status-in-process { background: #FEF3C7; color: #D97706; border: 1px solid #FDE68A; }
        .status-closed { background: #DCFCE7; color: #16A34A; border: 1px solid #BBF7D0; }
        
        /* Priority Labels */
        .priority-high { background: #FFE4E6; color: #E11D48; border: 1px solid #FECDD3; }
        
        /* Data Lists */
        .meta-list { list-style: none; padding: 0; margin: 0; }
        .meta-list li { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid #F1F5F9; }
        .meta-list li:last-child { border-bottom: none; padding-bottom: 0; }
        .meta-label { font-size: 0.9rem; color: #64748B; font-weight: 500; display: flex; align-items: center; gap: 8px; }
        .meta-value { font-size: 0.95rem; color: #0F172A; font-weight: 600; text-align: right; }
        
        /* Enhanced Timeline */
        .timeline-container { position: relative; padding-left: 30px; margin-top: 10px; }
        .timeline-container::before { content: ''; position: absolute; left: 0; top: 10px; bottom: 0; width: 3px; background: linear-gradient(180deg, #8B5CF6 0%, #E2E8F0 100%); border-radius: 3px; }
        
        .timeline-item { position: relative; margin-bottom: 30px; }
        .timeline-item:last-child { margin-bottom: 0; }
        
        .timeline-marker { 
            position: absolute; left: -39px; top: 0; width: 22px; height: 22px; 
            border-radius: 50%; background: #ffffff; border: 4px solid #8B5CF6; 
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1); z-index: 1;
        }
        
        .timeline-item.closed .timeline-marker { border-color: #10B981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
        .timeline-item.process .timeline-marker { border-color: #F59E0B; box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1); }
        
        .timeline-content { 
            background: #ffffff; padding: 24px; border-radius: 16px; 
            border: 1px solid #E2E8F0; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            position: relative;
        }
        
        .timeline-content::before {
            content: ''; position: absolute; left: -10px; top: 10px;
            border-width: 10px 10px 10px 0; border-style: solid;
            border-color: transparent #E2E8F0 transparent transparent;
        }
        .timeline-content::after {
            content: ''; position: absolute; left: -8px; top: 11px;
            border-width: 9px 9px 9px 0; border-style: solid;
            border-color: transparent #ffffff transparent transparent;
        }
        
        .timeline-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .timeline-date { font-size: 0.85rem; color: #64748B; font-weight: 500; display: flex; align-items: center; gap: 6px; }
        
        .admin-remark-box {
            background: #F8FAFC; border-left: 4px solid #8B5CF6;
            padding: 16px; border-radius: 0 8px 8px 0; margin-top: 16px;
        }
        .admin-remark-title { font-size: 0.8rem; text-transform: uppercase; color: #8B5CF6; font-weight: 700; margin-bottom: 6px; letter-spacing: 0.5px; }
        .admin-remark-text { font-size: 0.95rem; color: #334155; margin: 0; line-height: 1.6; }
        
        .empty-state { text-align: center; padding: 50px 20px; color: #64748B; background: #F8FAFC; border-radius: 16px; border: 1px dashed #CBD5E1; }
        .empty-state i { font-size: 3rem; color: #CBD5E1; margin-bottom: 16px; }
        
        /* Details Block */
        .details-block { background: #F8FAFC; padding: 24px; border-radius: 12px; border: 1px solid #E2E8F0; margin-top: 16px; }
        .details-label { font-size: 0.85rem; color: #64748B; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 8px; }
        .details-text { font-size: 1rem; color: #1E293B; line-height: 1.7; margin: 0; }
        
        @media (max-width: 1024px) {
            .content-layout { grid-template-columns: 1fr; }
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
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Complaint #{{ $complaint->complaintNumber }}</h1>
                        <p class="page-subtitle">
                            <i class="fa-regular fa-calendar"></i> Registered on {{ date('F j, Y \a\t g:i A', strtotime($complaint->regDate)) }}
                        </p>
                    </div>
                    <a href="/users/complaint-history" class="btn-outline">
                        <i class="fa-solid fa-arrow-left-long" style="margin-right: 8px;"></i> Back to History
                    </a>
                </div>

                <div class="content-layout">
                    <!-- Left Column: Timeline & Details -->
                    <div class="main-panel">
                        
                        <!-- Status Tracking Timeline -->
                        <div class="saas-card">
                            <div class="card-header">
                                <h2 class="card-title">
                                    <div class="card-icon"><i class="fa-solid fa-timeline"></i></div>
                                    Status Tracking & Updates
                                </h2>
                            </div>
                            <div class="card-body">
                                @if(count($remarkHistory) == 0)
                                    <div class="empty-state">
                                        <i class="fa-solid fa-hourglass-start"></i>
                                        <h3 style="color: #334155; margin-bottom: 8px;">Awaiting Processing</h3>
                                        <p style="margin:0;">Your complaint has been successfully registered and is currently in the queue for administrative review.</p>
                                    </div>
                                @else
                                    <div class="timeline-container">
                                        @foreach($remarkHistory as $rw)
                                        @php
                                            $timelineClass = '';
                                            if(strtolower($rw->status) == 'closed') $timelineClass = 'closed';
                                            elseif(strtolower($rw->status) == 'in process') $timelineClass = 'process';
                                        @endphp
                                        <div class="timeline-item {{ $timelineClass }}">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <div class="timeline-header">
                                                    <span class="status-badge 
                                                        @if(strtolower($rw->status) == 'in process') status-in-process
                                                        @elseif(strtolower($rw->status) == 'closed') status-closed
                                                        @else status-not-processed @endif">
                                                        {{ $rw->status }}
                                                    </span>
                                                    <div class="timeline-date">
                                                        <i class="fa-regular fa-clock"></i> {{ date('M j, Y • g:i A', strtotime($rw->remarkDate)) }}
                                                    </div>
                                                </div>
                                                
                                                @if($rw->remark)
                                                <div class="admin-remark-box">
                                                    <div class="admin-remark-title"><i class="fa-solid fa-user-shield" style="margin-right:6px;"></i> Admin Response</div>
                                                    <p class="admin-remark-text">{{ $rw->remark }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        <!-- Initial Stage -->
                                        <div class="timeline-item">
                                            <div class="timeline-marker" style="border-color: #94A3B8; box-shadow: 0 0 0 4px rgba(148, 163, 184, 0.1);"></div>
                                            <div class="timeline-content" style="background: #F8FAFC;">
                                                <div class="timeline-header" style="margin-bottom:0;">
                                                    <strong style="color: #475569;">Complaint Registered</strong>
                                                    <div class="timeline-date">
                                                        <i class="fa-regular fa-clock"></i> {{ date('M j, Y • g:i A', strtotime($complaint->regDate)) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Complaint Details -->
                        <div class="saas-card">
                            <div class="card-header">
                                <h2 class="card-title">
                                    <div class="card-icon" style="background: #E0F2FE; color: #0284C7;"><i class="fa-solid fa-file-lines"></i></div>
                                    Complaint Information
                                </h2>
                            </div>
                            <div class="card-body">
                                <div>
                                    <div class="details-label">Nature of Complaint</div>
                                    <p style="font-size: 1.15rem; font-weight: 600; color: #0F172A; margin: 0 0 20px 0;">{{ $complaint->noc }}</p>
                                </div>
                                <div class="details-block">
                                    <div class="details-label"><i class="fa-solid fa-align-left" style="margin-right: 6px;"></i> Full Description</div>
                                    <p class="details-text">
                                        {{ $complaint->complaintDetails }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Meta Info & Attachments -->
                    <div class="side-panel">
                        <div class="saas-card">
                            <div class="card-header" style="flex-direction: column; align-items: flex-start; gap: 12px;">
                                <h2 class="card-title" style="margin-bottom: 8px;">Case Status</h2>
                                @if(empty($complaint->status) || $complaint->status == "NULL")
                                    <div style="width: 100%; height: 6px; background: #E2E8F0; border-radius: 10px; overflow:hidden;">
                                        <div style="width: 10%; height: 100%; background: #EF4444;"></div>
                                    </div>
                                    <span class="status-badge status-not-processed" style="width: 100%; justify-content: center; margin-top:8px;">Pending Review</span>
                                @elseif(strtolower($complaint->status) == "in process")
                                    <div style="width: 100%; height: 6px; background: #E2E8F0; border-radius: 10px; overflow:hidden;">
                                        <div style="width: 50%; height: 100%; background: #F59E0B;"></div>
                                    </div>
                                    <span class="status-badge status-in-process" style="width: 100%; justify-content: center; margin-top:8px;">Investigation Active</span>
                                @else
                                    <div style="width: 100%; height: 6px; background: #E2E8F0; border-radius: 10px; overflow:hidden;">
                                        <div style="width: 100%; height: 100%; background: #10B981;"></div>
                                    </div>
                                    <span class="status-badge status-closed" style="width: 100%; justify-content: center; margin-top:8px;">Case Resolved</span>
                                @endif
                            </div>
                            <div class="card-body" style="padding-top: 10px;">
                                <ul class="meta-list">
                                    <li>
                                        <span class="meta-label"><i class="fa-solid fa-layer-group"></i> Category</span>
                                        <span class="meta-value">{{ $complaint->catname }}</span>
                                    </li>
                                    <li>
                                        <span class="meta-label"><i class="fa-solid fa-list-ul"></i> Sub-Category</span>
                                        <span class="meta-value">{{ $complaint->subcategory }}</span>
                                    </li>
                                    <li>
                                        <span class="meta-label"><i class="fa-solid fa-tag"></i> Type</span>
                                        <span class="meta-value">{{ $complaint->complaintType }}</span>
                                    </li>
                                    <li>
                                        <span class="meta-label"><i class="fa-solid fa-location-dot"></i> State</span>
                                        <span class="meta-value">{{ $complaint->state }}</span>
                                    </li>
                                    @if($complaint->campus)
                                    <li>
                                        <span class="meta-label"><i class="fa-solid fa-building-columns"></i> Campus</span>
                                        <span class="meta-value">{{ $complaint->campus }}</span>
                                    </li>
                                    @endif
                                    @if($complaint->block_number)
                                    <li>
                                        <span class="meta-label"><i class="fa-solid fa-building"></i> Block No.</span>
                                        <span class="meta-value">{{ $complaint->block_number }}</span>
                                    </li>
                                    @endif
                                    <li>
                                        <span class="meta-label"><i class="fa-solid fa-flag"></i> Priority</span>
                                        <span class="status-badge priority-high" style="padding: 4px 10px; font-size: 0.7rem;">High</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="saas-card">
                            <div class="card-header">
                                <h2 class="card-title">
                                    <div class="card-icon" style="background: #FCE7F3; color: #DB2777; width: 32px; height: 32px; font-size: 1rem;"><i class="fa-solid fa-paperclip"></i></div>
                                    Attachments
                                </h2>
                            </div>
                            <div class="card-body" style="text-align: center; padding: 24px;">
                                @if(empty($complaint->complaintFile) || $complaint->complaintFile == "NULL")
                                    <div class="empty-state" style="padding: 20px 10px;">
                                        <i class="fa-regular fa-file-image" style="font-size: 2.5rem; margin-bottom: 12px;"></i>
                                        <p style="margin: 0; font-size: 0.9rem;">No files or evidence attached</p>
                                    </div>
                                @else
                                    <div style="padding: 10px 0;">
                                        <i class="fa-solid fa-file-pdf" style="font-size: 3rem; color: #ef4444; margin-bottom: 16px;"></i>
                                        <p style="font-weight: 500; color: #374151; margin-bottom: 20px; word-break: break-all; font-size: 0.9rem;">{{ $complaint->complaintFile }}</p>
                                        <a href="/complaintdocs/{{ $complaint->complaintFile }}" target="_blank" class="btn-outline" style="width: 100%; justify-content: center;">
                                            <i class="fa-solid fa-cloud-arrow-down" style="margin-right: 8px;"></i> View Document
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
