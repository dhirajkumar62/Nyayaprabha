

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | User Login</title>
    
    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('https://storage.needpix.com/rsynced_images/violence-against-women-4209778_1280.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(79, 70, 229, 0.6) 100%);
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
        .auth-link {
            color: var(--primary-light);
            font-size: 0.9rem;
            text-decoration: underline;
        }
        .auth-link:hover {
            color: var(--surface);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: var(--surface);
            padding: 30px;
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 400px;
        }
    </style>
    <script type="text/javascript">
        function valid() {
            if(document.forgot.password.value != document.forgot.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match!!");
                document.forgot.confirmpassword.focus();
                return false;
            }
            return true;
        }
        
        function toggleModal() {
            const modal = document.getElementById('forgotModal');
            modal.classList.toggle('active');
        }
    </script>
</head>
<body>
    <div class="login-page">
        <div class="overlay"></div>
        
        <div class="login-container glass-panel-dark">
            <div class="login-header">
                <h2>Welcome Back</h2>
                <p style="color: var(--primary-light);">Sign in to your account</p>
            </div>
            
            <form name="login" method="post" action="/users/login">
                @csrf
                @if(session('errormsg'))
                    <div style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
                        {{ session('errormsg') }}
                    </div>
                @endif
                
                @if(session('msg'))
                    <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
                        {{ session('msg') }}
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label" style="color: var(--text-light);">Email Address</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter your email" required autofocus>
                </div>
                
                <div class="form-group">
                    <div class="flex-between mb-4">
                        <label class="form-label" style="color: var(--text-light); margin-bottom: 0;">Password</label>
                        <a href="javascript:void(0);" onclick="toggleModal()" class="auth-link" style="text-decoration: none;">Forgot Password?</a>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                </div>
                
                <button class="btn btn-primary" style="width: 100%; margin-top: 10px;" name="submit" type="submit">
                    <i class="fa fa-sign-in-alt" style="margin-right: 8px;"></i> Sign In
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 24px; font-size: 0.9rem; color: #E2E8F0;">
                Don't have an account? <a href="/users/register" class="auth-link" style="font-weight: 600;">Create new account</a>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" class="modal">
        <div class="modal-content">
            <div class="flex-between mb-12" style="margin-bottom: 20px;">
                <h3 style="color: var(--text-main);">Reset Password</h3>
                <button onclick="toggleModal()" style="background: none; border: none; cursor: pointer; font-size: 1.2rem; color: var(--text-muted);">&times;</button>
            </div>
            
            <form name="forgot" method="post" action="/users/forgot-password">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email Address" autocomplete="off" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="text" name="contact" placeholder="Contact Number" autocomplete="off" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="New Password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword" required>
                </div>
                
                <div class="flex-between" style="margin-top: 24px;">
                    <button type="button" class="btn btn-secondary" onclick="toggleModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="change" onclick="return valid();">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
