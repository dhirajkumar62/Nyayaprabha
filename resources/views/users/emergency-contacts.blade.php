
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | User Profile</title>

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
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .full-width { grid-column: span 2; }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }
        .profile-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 16px;
        }
        .select2-container .select2-selection--single {
            height: 48px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background-color: var(--background);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-main);
            line-height: 46px;
            padding-left: 16px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            right: 10px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select your State"
        });
    });
    </script>
</head>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            @include('users.includes.sidebar')
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            @include('users.includes.header')
            
            <main class="main-content">
                    @if(session('successmsg'))
                        <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                            <i class="fa fa-check-circle" style="margin-right: 8px;"></i> {{ session('successmsg') }}
                        </div>
                    @endif

                    @if(session('errormsg'))
                        <div style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                            <i class="fa fa-exclamation-circle" style="margin-right: 8px;"></i> {{ session('errormsg') }}
                        </div>
                    @endif

                <!-- Emergency Contacts Section -->
                <div id="emergency-contacts" class="card" style="max-width: 800px; margin: 30px auto 0; scroll-margin-top: 100px;">
                    <div class="profile-header">
                        <div class="profile-avatar" style="background: rgba(239, 68, 68, 0.1); color: #EF4444;">
                            <i class="fa fa-heartbeat"></i>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; margin-bottom: 4px;">Emergency Contacts</h2>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Add up to 5 trusted contacts for SOS alerts.</p>
                        </div>
                    </div>

                    @if($emergencyContacts->count() > 0)
                        <div class="table-responsive" style="margin-bottom: 24px;">
                            <table class="table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                                <thead>
                                    <tr style="border-bottom: 2px solid var(--border); text-align: left;">
                                        <th style="padding: 12px; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">Name</th>
                                        <th style="padding: 12px; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">Phone</th>
                                        <th style="padding: 12px; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">Email</th>
                                        <th style="padding: 12px; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($emergencyContacts as $contact)
                                    <tr style="border-bottom: 1px solid var(--border);">
                                        <td style="padding: 12px; font-weight: 500;">{{ $contact->name }}</td>
                                        <td style="padding: 12px;">{{ $contact->phone }}</td>
                                        <td style="padding: 12px;">{{ $contact->email ?: 'N/A' }}</td>
                                        <td style="padding: 12px;">
                                            <form action="/users/emergency-contacts/{{ $contact->id }}" method="POST" onsubmit="return confirm('Remove this emergency contact?');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: none; border: none; color: #EF4444; cursor: pointer; padding: 4px 8px;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div style="text-align: center; padding: 30px; background: var(--background); border-radius: var(--radius-md); margin-bottom: 24px;">
                            <i class="fa fa-info-circle" style="font-size: 2rem; color: var(--text-muted); margin-bottom: 10px;"></i>
                            <p style="color: var(--text-muted);">You haven't added any emergency contacts yet.</p>
                        </div>
                    @endif

                    @if($emergencyContacts->count() < 5)
                        <div style="background: var(--background); padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--border);">
                            <h4 style="margin-top: 0; margin-bottom: 16px; color: var(--text-main); font-size: 1.1rem;">Add New Contact</h4>
                            <form method="post" action="/users/emergency-contacts">
                                @csrf
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label class="form-label">Contact Name <span style="color:#EF4444;">*</span></label>
                                        <input type="text" name="name" required class="form-control" placeholder="e.g. John Doe">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Phone Number <span style="color:#EF4444;">*</span></label>
                                        <input type="text" name="phone" required class="form-control" placeholder="Mobile Number">
                                    </div>
                                    <div class="form-group full-width">
                                        <label class="form-label">Email Address (Optional)</label>
                                        <input type="email" name="email" class="form-control" placeholder="For email alerts">
                                    </div>
                                </div>
                                <div style="margin-top: 16px; text-align: right;">
                                    <button type="submit" class="btn btn-primary" style="background: #10B981; border-color: #10B981;">
                                        <i class="fa fa-plus" style="margin-right: 8px;"></i> Add Contact
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div style="background: rgba(245, 158, 11, 0.1); color: #D97706; padding: 12px 16px; border-radius: 6px; text-align: center;">
                            <i class="fa fa-exclamation-triangle" style="margin-right: 8px;"></i> Maximum limit of 5 emergency contacts reached.
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>
