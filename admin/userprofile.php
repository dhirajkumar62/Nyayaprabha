<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) { 
    header('location:index.php');
} else { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Details</title>
    
    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        body {
            background: var(--background);
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .profile-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
        }

        .profile-header {
            background: var(--primary-gradient);
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: white;
            color: var(--primary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .profile-header h2 {
            color: white;
            margin-bottom: 4px;
            font-size: 1.5rem;
        }

        .profile-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .profile-body {
            padding: 30px;
        }

        .detail-row {
            display: flex;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            width: 40%;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-value {
            width: 60%;
            color: var(--text-main);
            font-weight: 500;
        }

        .profile-footer {
            padding: 20px 30px;
            background: var(--background);
            border-top: 1px solid var(--border);
            text-align: right;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>

    <script language="javascript" type="text/javascript">
        function closeWindow() {
            window.close();
        }
        function printProfile() {
            window.print(); 
        }
    </script>
</head>
<body>

<?php 
$ret1=mysqli_query($bd, "select * FROM users where id='".$_GET['uid']."'");
while($row=mysqli_fetch_array($ret1)) {
?>
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fa fa-user"></i>
            </div>
            <h2><?php echo htmlentities($row['fullName']); ?></h2>
            <p>Registered User</p>
        </div>
        
        <div class="profile-body">
            <div class="detail-row">
                <div class="detail-label"><i class="fa fa-calendar-alt"></i> Registration Date</div>
                <div class="detail-value"><?php echo htmlentities($row['regDate']); ?></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label"><i class="fa fa-envelope"></i> Email Address</div>
                <div class="detail-value"><?php echo htmlentities($row['userEmail']); ?></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label"><i class="fa fa-phone"></i> Contact Number</div>
                <div class="detail-value"><?php echo htmlentities($row['contactNo']); ?></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label"><i class="fa fa-map-marker-alt"></i> Address</div>
                <div class="detail-value">
                    <?php echo htmlentities($row['address']); ?><br>
                    <?php echo htmlentities($row['State']); ?>, <?php echo htmlentities($row['country']); ?> - <?php echo htmlentities($row['pincode']); ?>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label"><i class="fa fa-clock"></i> Last Updated</div>
                <div class="detail-value"><?php echo htmlentities($row['updationDate']); ?></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label"><i class="fa fa-shield-alt"></i> Account Status</div>
                <div class="detail-value">
                    <?php if($row['status']==1) { ?>
                        <span class="badge badge-success">Active</span>
                    <?php } else { ?>
                        <span class="badge badge-error">Blocked</span>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="profile-footer">
            <button class="btn btn-secondary btn-sm" onClick="printProfile();"><i class="fa fa-print" style="margin-right: 8px;"></i> Print Details</button>
            <button class="btn btn-primary" onClick="closeWindow();"><i class="fa fa-times" style="margin-right: 8px;"></i> Close Window</button>
        </div>
    </div>
<?php } ?>

</body>
</html>
<?php } ?>