

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Admin Login</title>
    
    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('https://assets-global.website-files.com/6398616f874d1a4a696f704d/64215e4db8c37b9cbc402a41_molly-blackbird-a-xEUwYSPLw-unsplash.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%);
        }
        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: var(--text-light);
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .admin-badge {
            display: inline-block;
            background: rgba(244, 63, 94, 0.2);
            color: #F43F5E;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="overlay"></div>
        
        <div class="login-container glass-panel-dark">
            <div class="login-header">
                <div class="admin-badge">Secure Admin Portal</div>
                <h2>Nyayaprabha</h2>
                <p style="color: var(--text-muted);">Enter credentials to access the admin dashboard</p>
            </div>
            
            <form method="post" action="/admin/login">
                @csrf
                @if(session('errmsg'))
                    <div style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
                        {{ session('errmsg') }}
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label" style="color: var(--text-light);">Username</label>
                    <div style="position: relative;">
                        <i class="fa fa-user" style="position: absolute; left: 16px; top: 16px; color: var(--text-muted);"></i>
                        <input type="text" class="form-control" name="username" placeholder="Enter admin username" style="padding-left: 44px;" required autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" style="color: var(--text-light);">Password</label>
                    <div style="position: relative;">
                        <i class="fa fa-lock" style="position: absolute; left: 16px; top: 16px; color: var(--text-muted);"></i>
                        <input type="password" class="form-control" name="password" placeholder="Enter password" style="padding-left: 44px;" required>
                    </div>
                </div>
                
                <button class="btn btn-primary" style="width: 100%; margin-top: 10px; background-color: var(--accent); box-shadow: 0 4px 14px 0 rgba(244, 63, 94, 0.39);" name="submit" type="submit">
                    <i class="fa fa-shield-alt" style="margin-right: 8px;"></i> Secure Login
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 24px; font-size: 0.8rem; color: var(--text-muted);">
                &copy; 2026 Nyayaprabha Admin. Authorized Access Only.
            </div>
        </div>
    </div>
</body>
</html>
