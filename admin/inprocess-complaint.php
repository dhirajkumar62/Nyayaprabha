<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date( 'd-m-Y h:i:s A', time () );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Admin Pending Complaints</title>

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
        
        .table-container { background: var(--surface); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden; border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; padding: 16px; text-align: left; font-size: 0.875rem; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border); }
        td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: var(--primary-light); }
    </style>
</head>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            <?php include("include/sidebar.php"); ?>
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            <?php include("include/header.php"); ?>
            
            <main class="main-content">
                <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
                    <h2><i class="fa fa-clock" style="margin-right: 10px; color: var(--warning);"></i> Pending Complaints</h2>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Complaint No</th>
                                <th>Complainant Name</th>
                                <th>Reg Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $st='in process';
                        $query=mysqli_query($bd, "select tblcomplaints.*,users.fullName as name from tblcomplaints join users on users.id=tblcomplaints.userId where tblcomplaints.status='$st'");
                        while($row=mysqli_fetch_array($query)) {
                        ?>                                  
                            <tr>
                                <td style="font-weight: 600;">#<?php echo htmlentities($row['complaintNumber']);?></td>
                                <td style="font-weight: 500; color: var(--text-main);"><?php echo htmlentities($row['name']);?></td>
                                <td style="color: var(--text-muted);"><?php echo htmlentities($row['regDate']);?></td>
                                <td><span class="badge badge-warning">In Process</span></td>
                                <td>
                                    <a href="complaint-details.php?cid=<?php echo htmlentities($row['complaintNumber']);?>" class="btn btn-secondary btn-sm" style="padding: 4px 12px; font-size: 0.8rem;">
                                        <i class="fa fa-eye" style="margin-right: 4px;"></i> View Details
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
<?php } ?>