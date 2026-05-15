
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
                <div class="card" style="max-width: 800px; margin: 0 auto;">
                    
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="fa fa-user"></i>
                        </div>
                        <div>
                            <h2 style="font-size: 1.5rem; margin-bottom: 4px;">{{ $user->fullName }}'s Profile</h2>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Last Updated: {{ $user->updationDate ? $user->updationDate : 'Never' }}</p>
                        </div>
                    </div>

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

                    <form method="post" action="/users/profile" name="profile">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" required value="{{ $user->fullName }}" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="useremail" required value="{{ $user->userEmail }}" class="form-control" readonly style="background: var(--background); cursor: not-allowed;">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contactno" required value="{{ $user->contactNo }}" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Registration Date</label>
                                <input type="text" name="regdate" required value="{{ $user->regDate }}" class="form-control" readonly style="background: var(--background); cursor: not-allowed;">
                            </div>

                            <div class="form-group full-width">
                                <label class="form-label">Address</label>
                                <textarea name="address" required class="form-control" rows="3">{{ $user->address }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">State</label>
                                <select name="state" required class="form-control select2">
                                    <option value="{{ $user->State }}">{{ $user->State }}</option>
                                    @foreach($states as $rw)
                                        @if($rw->stateName != $user->State)
                                            <option value="{{ $rw->stateName }}">{{ $rw->stateName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" required value="{{ $user->country }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="pincode" maxlength="6" required value="{{ $user->pincode }}" class="form-control">
                            </div>
                        </div>

                        <div style="margin-top: 24px; text-align: right;">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-save" style="margin-right: 8px;"></i> Save Changes</button>
                        </div>
                    </form>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
