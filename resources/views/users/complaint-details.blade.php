
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Complaint Details</title>

    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; color: #1f2937; margin: 0; }
        .dashboard-layout { display: flex; min-height: 100vh; }
        .sidebar-wrapper { width: 260px; background: #ffffff; border-right: 1px solid #e5e7eb; flex-shrink: 0; }
        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; background: #f9fafb; }
        
        .sidebar-menu { list-style: none; padding: 0; margin: 0; }
        .sidebar-menu li a { display: block; padding: 16px 24px; color: #4b5563; font-weight: 500; text-decoration: none; transition: 0.2s; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: #eff6ff; color: #2563eb; border-right: 3px solid #2563eb; }
        .sidebar-menu li a i { margin-right: 12px; width: 20px; text-align: center; }
        
        .topbar { background: #ffffff; padding: 16px 40px; display: flex; justify-content: space-between; border-bottom: 1px solid #e5e7eb; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .topbar .logo a { font-size: 1.25rem; font-weight: 700; color: #2563eb; text-decoration: none; }
        
        /* Premium Layout */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
        .page-title { font-size: 1.875rem; font-weight: 700; color: #111827; margin: 0; }
        .page-subtitle { font-size: 0.875rem; color: #6b7280; margin-top: 4px; }
        
        .btn-outline { background: white; border: 1px solid #d1d5db; color: #374151; padding: 8px 16px; border-radius: 6px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; transition: 0.2s; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .btn-outline:hover { background: #f9fafb; color: #111827; }
        
        .content-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start; }
        
        /* Cards */
        .saas-card { background: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #f3f4f6; overflow: hidden; margin-bottom: 24px; }
        .card-header { padding: 20px 24px; border-bottom: 1px solid #f3f4f6; background: #ffffff; display: flex; justify-content: space-between; align-items: center; }
        .card-title { font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0; }
        .card-body { padding: 24px; }
        
        /* Badges */
        .status-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .status-not-processed { background: #fee2e2; color: #991b1b; }
        .status-in-process { background: #fef3c7; color: #92400e; }
        .status-closed { background: #d1fae5; color: #065f46; }
        
        /* Data Lists */
        .meta-list { list-style: none; padding: 0; margin: 0; }
        .meta-list li { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6; }
        .meta-list li:last-child { border-bottom: none; padding-bottom: 0; }
        .meta-label { font-size: 0.875rem; color: #6b7280; font-weight: 500; }
        .meta-value { font-size: 0.875rem; color: #111827; font-weight: 600; text-align: right; }
        
        /* Timeline */
        .timeline { position: relative; padding-left: 24px; margin-top: 10px; }
        .timeline::before { content: ''; position: absolute; left: 0; top: 8px; bottom: 0; width: 2px; background: #e5e7eb; }
        .timeline-item { position: relative; margin-bottom: 24px; }
        .timeline-item:last-child { margin-bottom: 0; }
        .timeline-dot { position: absolute; left: -29px; top: 4px; width: 12px; height: 12px; border-radius: 50%; background: #2563eb; border: 3px solid #ffffff; box-shadow: 0 0 0 2px #eff6ff; }
        .timeline-date { font-size: 0.75rem; color: #6b7280; margin-bottom: 4px; font-weight: 500; }
        .timeline-content { background: #f9fafb; padding: 16px; border-radius: 8px; border: 1px solid #f3f4f6; }
        .timeline-text { font-size: 0.95rem; color: #374151; margin: 0 0 12px 0; line-height: 1.5; }
        
        .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }
        .empty-state i { font-size: 3rem; color: #d1d5db; margin-bottom: 16px; }
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
                        <p class="page-subtitle">Filed on {{ date('F j, Y, g:i a', strtotime($complaint->regDate)) }}</p>
                    </div>
                    <a href="/users/complaint-history" class="btn-outline">
                        <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Back to History
                    </a>
                </div>

                <div class="content-layout">
                    <!-- Left Column: Details & Timeline -->
                    <div class="main-panel">
                        <div class="saas-card">
                            <div class="card-header">
                                <h2 class="card-title"><i class="fa fa-align-left text-primary" style="margin-right: 8px; color: #2563eb;"></i> Complaint Description</h2>
                            </div>
                            <div class="card-body">
                                <div style="margin-bottom: 24px;">
                                    <h4 style="font-size: 0.875rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 8px 0;">Nature of Complaint</h4>
                                    <p style="font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0;">{{ $complaint->noc }}</p>
                                </div>
                                <div>
                                    <h4 style="font-size: 0.875rem; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 8px 0;">Full Details</h4>
                                    <p style="font-size: 1rem; color: #374151; line-height: 1.6; margin: 0; background: #f9fafb; padding: 16px; border-radius: 8px; border: 1px solid #f3f4f6;">
                                        {{ $complaint->complaintDetails }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="saas-card">
                            <div class="card-header">
                                <h2 class="card-title"><i class="fa fa-history text-primary" style="margin-right: 8px; color: #2563eb;"></i> Status Tracking Timeline</h2>
                            </div>
                            <div class="card-body">
                                @if(count($remarkHistory) == 0)
                                    <div class="empty-state">
                                        <i class="fa fa-clock"></i>
                                        <p>No administrative remarks have been posted yet. Your complaint is queued for processing.</p>
                                    </div>
                                @else
                                    <div class="timeline">
                                        @foreach($remarkHistory as $rw)
                                        <div class="timeline-item">
                                            <div class="timeline-dot"></div>
                                            <div class="timeline-date">{{ date('M j, Y, g:i a', strtotime($rw->remarkDate)) }}</div>
                                            <div class="timeline-content">
                                                <p class="timeline-text">{{ $rw->remark }}</p>
                                                <span class="status-badge 
                                                    @if(strtolower($rw->status) == 'in process') status-in-process
                                                    @elseif(strtolower($rw->status) == 'closed') status-closed
                                                    @else status-not-processed @endif">
                                                    Status changed to: {{ $rw->status }}
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Meta Info & Attachments -->
                    <div class="side-panel">
                        <div class="saas-card">
                            <div class="card-header">
                                <h2 class="card-title">Case Metadata</h2>
                                @if(empty($complaint->status) || $complaint->status == "NULL")
                                    <span class="status-badge status-not-processed">Pending</span>
                                @elseif(strtolower($complaint->status) == "in process")
                                    <span class="status-badge status-in-process">In Process</span>
                                @else
                                    <span class="status-badge status-closed">Closed</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <ul class="meta-list">
                                    <li>
                                        <span class="meta-label">Category</span>
                                        <span class="meta-value">{{ $complaint->catname }}</span>
                                    </li>
                                    <li>
                                        <span class="meta-label">Sub-category</span>
                                        <span class="meta-value">{{ $complaint->subcategory }}</span>
                                    </li>
                                    <li>
                                        <span class="meta-label">Type</span>
                                        <span class="meta-value">{{ $complaint->complaintType }}</span>
                                    </li>
                                    <li>
                                        <span class="meta-label">State</span>
                                        <span class="meta-value">{{ $complaint->state }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="saas-card">
                            <div class="card-header">
                                <h2 class="card-title">Attached Evidence</h2>
                            </div>
                            <div class="card-body" style="text-align: center;">
                                @if(empty($complaint->complaintFile) || $complaint->complaintFile == "NULL")
                                    <div class="empty-state" style="padding: 20px;">
                                        <i class="fa fa-folder-open" style="font-size: 2.5rem; margin-bottom: 12px;"></i>
                                        <p style="margin: 0; font-size: 0.9rem;">No files attached</p>
                                    </div>
                                @else
                                    <div style="padding: 20px 0;">
                                        <i class="fa fa-file-pdf" style="font-size: 3rem; color: #ef4444; margin-bottom: 16px;"></i>
                                        <p style="font-weight: 500; color: #374151; margin-bottom: 16px; word-break: break-all;">{{ $complaint->complaintFile }}</p>
                                        <a href="/complaintdocs/{{ $complaint->complaintFile }}" target="_blank" class="btn-outline" style="width: 100%; justify-content: center; background: #f9fafb;">
                                            <i class="fa fa-download" style="margin-right: 8px;"></i> View Document
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
