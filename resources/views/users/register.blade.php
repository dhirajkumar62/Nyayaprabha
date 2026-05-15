

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | User Registration</title>
    
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
            max-width: 450px;
            padding: 40px;
            margin: 40px 0;
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
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function userAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "/users/check-availability",
            data: 'email='+$("#email").val(),
            type: "POST",
            success: function(data) {
                $("#user-availability-status1").html(data);
                $("#loaderIcon").hide();
            },
            error: function () {}
        });
    }
    </script>
</head>
<body>
    <div class="login-page">
        <div class="overlay"></div>
        
        <div class="login-container glass-panel-dark">
            <div class="login-header">
                <h2>Create Account</h2>
                <p style="color: var(--primary-light);">Join Nyayaprabha today</p>
            </div>
            
            <form name="registration" method="post" action="/users/register">
                @csrf
                @if(session('msg'))
                    <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center;">
                        {{ session('msg') }}
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label" style="color: var(--text-light);">Full Name</label>
                    <input type="text" class="form-control" name="fullname" placeholder="Enter your full name" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label" style="color: var(--text-light);">Email Address</label>
                    <input type="email" class="form-control" id="email" onBlur="userAvailability()" name="email" placeholder="Enter your email" required>
                    <span id="user-availability-status1" style="font-size: 12px; margin-top: 4px; display: block; color: var(--primary-light);"></span>
                </div>
                
                <div class="form-group">
                    <label class="form-label" style="color: var(--text-light);">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Create a password" required>
                </div>

                <div class="form-group">
                    <label class="form-label" style="color: var(--text-light);">Contact Number</label>
                    <input type="text" class="form-control" maxlength="10" name="contactno" placeholder="Enter 10-digit number" required>
                </div>
                
                <button class="btn btn-primary" style="width: 100%; margin-top: 10px;" name="submit" id="submit" type="submit">
                    <i class="fa fa-user-plus" style="margin-right: 8px;"></i> Register
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 24px; font-size: 0.9rem; color: #E2E8F0;">
                Already Registered? <a href="/users/login" class="auth-link" style="font-weight: 600;">Sign in here</a>
            </div>
        </div>
    </div>
</body>
</html>
