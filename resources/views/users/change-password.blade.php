

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Change Password</title>

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
            grid-template-columns: 1fr;
            gap: 20px;
        }
    </style>
    
    <script type="text/javascript">
    function valid() {
        if(document.chngpwd.password.value=="") {
            alert("Current Password Field is Empty !!");
            document.chngpwd.password.focus();
            return false;
        }
        else if(document.chngpwd.newpassword.value=="") {
            alert("New Password Field is Empty !!");
            document.chngpwd.newpassword.focus();
            return false;
        }
        else if(document.chngpwd.confirmpassword.value=="") {
            alert("Confirm Password Field is Empty !!");
            document.chngpwd.confirmpassword.focus();
            return false;
        }
        else if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value) {
            alert("Password and Confirm Password Field do not match  !!");
            document.chngpwd.confirmpassword.focus();
            return false;
        }
        return true;
    }
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
                <div class="card" style="max-width: 600px; margin: 0 auto;">
                    <div style="border-bottom: 1px solid var(--border); padding-bottom: 20px; margin-bottom: 24px;">
                        <h2 style="font-size: 1.5rem;"><i class="fa fa-lock" style="margin-right: 10px; color: var(--primary);"></i> Change Password</h2>
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

                    <form method="post" action="/users/change-password" name="chngpwd" onSubmit="return valid();">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="password" required class="form-control" placeholder="Enter current password">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" name="newpassword" required class="form-control" placeholder="Enter new password">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="confirmpassword" required class="form-control" placeholder="Confirm new password">
                            </div>
                        </div>

                        <div style="margin-top: 24px; text-align: right;">
                            <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-key" style="margin-right: 8px;"></i> Update Password</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
