<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) { 
    header('location:index.php');
} else {

    // Set active tab
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'helplines';

    // Handle Helpline Creation
    if(isset($_POST['submit_helpline'])) {
        $name = $_POST['h_name'];
        $number = $_POST['h_number'];
        $category = $_POST['h_category'];
        
        $query = mysqli_query($bd, "INSERT INTO tbl_helplines(name, number, category) VALUES('$name','$number','$category')");
        if($query) {
            $msg = "Helpline Added Successfully";
        } else {
            $err = "Something went wrong. Please try again.";
        }
    }

    // Handle Helpline Deletion
    if(isset($_GET['del_helpline'])) {
        $id = $_GET['id'];
        mysqli_query($bd, "DELETE FROM tbl_helplines WHERE id='$id'");
        $msg = "Helpline Deleted !!";
        header("location:helpline-management.php?tab=helplines");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpline & Support Management</title>
    
    <!-- Global Design System -->
    <link href="../css/global.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />

    <style>
        .dashboard-layout { display: flex; min-height: 100vh; background: var(--background); }
        .sidebar-wrapper { width: 280px; background: var(--surface); border-right: 1px solid var(--border); flex-shrink: 0; z-index: 10; display: flex; flex-direction: column; height: 100vh; position: sticky; top: 0; overflow-y: auto; }
        .main-content { flex-grow: 1; padding: 40px; overflow-y: auto; background: var(--background); }
        
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-title { font-size: 1.5rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 12px; }
        
        .tabs-container {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-muted);
            background: transparent;
            border: none;
            cursor: pointer;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }
        
        .tab-btn:hover { color: var(--primary); background: var(--primary-light); }
        .tab-btn.active { color: var(--primary); background: var(--primary-light); border-bottom: 3px solid var(--primary); border-bottom-left-radius: 0; border-bottom-right-radius: 0; }

        .data-panel { background: var(--surface); border-radius: var(--radius-lg); border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; }
        
        .panel-toolbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 24px; border-bottom: 1px solid var(--border); background: #fdfdfd;
        }
        
        .search-box {
            position: relative; width: 300px;
        }
        .search-box i { position: absolute; left: 12px; top: 12px; color: var(--text-muted); }
        .search-box input { width: 100%; padding: 10px 10px 10px 36px; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; }
        .search-box input:focus { border-color: var(--primary); }

        table { width: 100%; border-collapse: collapse; }
        th { background: var(--background); color: var(--text-muted); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; padding: 16px 24px; text-align: left; border-bottom: 1px solid var(--border); }
        td { padding: 16px 24px; border-bottom: 1px solid var(--border); font-size: 0.95rem; color: var(--text-main); }
        tr:hover { background: #fafafa; }
        
        .action-icon {
            display: inline-flex; width: 32px; height: 32px; border-radius: 8px;
            align-items: center; justify-content: center; margin-right: 8px; transition: var(--transition); cursor: pointer;
        }
        .icon-edit { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .icon-delete { background: rgba(239, 68, 68, 0.1); color: #EF4444; }
        .icon-edit:hover { background: #3B82F6; color: white; }
        .icon-delete:hover { background: #EF4444; color: white; }

        /* Form styling */
        .modal-bg { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 100; align-items: center; justify-content: center; }
        .modal-content { background: var(--surface); padding: 30px; border-radius: var(--radius-lg); width: 100%; max-width: 500px; box-shadow: var(--shadow-lg); }
        
        /* Fixed Sidebar Styles */
        .sidebar-menu { list-style: none; padding: 0; margin-top: 10px; }
        .sidebar-menu li { margin-bottom: 4px; }
        .sidebar-menu li a { display: flex; align-items: center; padding: 12px 24px; color: #475569 !important; font-weight: 500; text-decoration: none; font-size: 0.95rem; transition: all 0.2s ease; border-right: 3px solid transparent; }
        .sidebar-menu li a:hover, .sidebar-menu li a.active { background: var(--primary-light); color: var(--primary) !important; border-right: 3px solid var(--primary); font-weight: 600; }
        .sidebar-menu li a i { margin-right: 14px; width: 20px; text-align: center; font-size: 1.1rem; opacity: 0.8; }
        .sidebar-menu li a:hover i { opacity: 1; }
        
        /* Fixed Header Styles */
        .topbar { background: var(--surface); padding: 16px 40px; display: flex; justify-content: space-between; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
        .topbar .logo { font-size: 1.25rem; font-weight: 700; color: var(--primary); }
    </style>
    <script>
        function openModal() { document.getElementById('addModal').style.display = 'flex'; }
        function closeModal() { document.getElementById('addModal').style.display = 'none'; }
    </script>
</head>
<body>
    <div class="dashboard-layout">
        <aside class="sidebar-wrapper">
            <?php include("include/sidebar.php"); ?>
        </aside>

        <div style="display: flex; flex-direction: column; flex-grow: 1;">
            <?php include("include/header.php"); ?>
            
            <main class="main-content">
                <div class="page-header">
                    <h2 class="page-title"><i class="fa fa-hands-helping" style="color: var(--accent);"></i> Helpline & Support Management</h2>
                </div>

                <?php if($msg) { ?>
                    <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 16px; border-radius: 8px; margin-bottom: 24px; font-weight: 500;">
                        <i class="fa fa-check-circle"></i> <?php echo htmlentities($msg);?>
                    </div>
                <?php } ?>

                <div class="tabs-container">
                    <a href="?tab=helplines"><button class="tab-btn <?php if($active_tab=='helplines') echo 'active'; ?>"><i class="fa fa-phone-alt"></i> Emergency Helplines</button></a>
                    <a href="?tab=ngos"><button class="tab-btn <?php if($active_tab=='ngos') echo 'active'; ?>"><i class="fa fa-hand-holding-heart"></i> NGOs</button></a>
                    <a href="?tab=police"><button class="tab-btn <?php if($active_tab=='police') echo 'active'; ?>"><i class="fa fa-shield-alt"></i> Police Stations</button></a>
                    <a href="?tab=support"><button class="tab-btn <?php if($active_tab=='support') echo 'active'; ?>"><i class="fa fa-building"></i> Support Centers</button></a>
                </div>

                <div class="data-panel">
                    <div class="panel-toolbar">
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" placeholder="Search records...">
                        </div>
                        <?php if($active_tab=='helplines') { ?>
                            <button class="btn btn-primary" onclick="openModal()"><i class="fa fa-plus"></i> Add New Helpline</button>
                        <?php } else { ?>
                            <button class="btn btn-primary" onclick="alert('Feature coming soon in advanced phase.')"><i class="fa fa-plus"></i> Add New Record</button>
                        <?php } ?>
                    </div>

                    <div style="overflow-x: auto;">
                        <table>
                            <?php if($active_tab == 'helplines') { ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service Name</th>
                                        <th>Number</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $query=mysqli_query($bd, "SELECT * FROM tbl_helplines");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td style="font-weight: 600; color: var(--primary);"><?php echo htmlentities($row['name']);?></td>
                                        <td style="font-size: 1.1rem; font-weight: 700; color: var(--accent);"><i class="fa fa-phone-square-alt"></i> <?php echo htmlentities($row['number']);?></td>
                                        <td><span class="badge" style="background: var(--primary-light); color: var(--primary);"><?php echo htmlentities($row['category']);?></span></td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td>
                                            <a href="#" class="action-icon icon-edit"><i class="fa fa-edit"></i></a>
                                            <a href="helpline-management.php?tab=helplines&id=<?php echo $row['id']?>&del_helpline=1" onClick="return confirm('Are you sure you want to delete?')" class="action-icon icon-delete"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php $cnt++; } ?>
                                </tbody>

                            <?php } elseif($active_tab == 'ngos') { ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NGO Name</th>
                                        <th>Contact Info</th>
                                        <th>Location</th>
                                        <th>Services Offered</th>
                                        <th>Verification</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $query=mysqli_query($bd, "SELECT * FROM tbl_ngos");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td style="font-weight: 600;"><?php echo htmlentities($row['name']);?></td>
                                        <td><i class="fa fa-phone" style="font-size: 0.8rem; color: var(--text-muted);"></i> <?php echo htmlentities($row['contact']);?><br>
                                            <span style="font-size: 0.8rem; color: var(--text-muted);"><?php echo htmlentities($row['email']);?></span>
                                        </td>
                                        <td><?php echo htmlentities($row['city']);?>, <?php echo htmlentities($row['state']);?></td>
                                        <td><?php echo htmlentities($row['services']);?></td>
                                        <td><span class="badge badge-success"><i class="fa fa-check-circle"></i> <?php echo htmlentities($row['verification_status']);?></span></td>
                                        <td>
                                            <a href="#" class="action-icon icon-edit"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <?php $cnt++; } ?>
                                </tbody>

                            <?php } elseif($active_tab == 'police') { ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Police Station Name</th>
                                        <th>Address & Location</th>
                                        <th>Contact Number</th>
                                        <th>Map Coord</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $query=mysqli_query($bd, "SELECT * FROM tbl_police_stations");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td style="font-weight: 600; color: #1e293b;"><i class="fa fa-shield-alt" style="color: var(--primary); margin-right: 6px;"></i> <?php echo htmlentities($row['name']);?></td>
                                        <td><?php echo htmlentities($row['address']);?><br><span style="font-size: 0.8rem; color: var(--text-muted);"><?php echo htmlentities($row['city']);?>, <?php echo htmlentities($row['state']);?></span></td>
                                        <td style="font-weight: 600;"><?php echo htmlentities($row['contact']);?></td>
                                        <td><a href="#" style="font-size: 0.85rem;"><i class="fa fa-map-marker-alt"></i> View Map</a></td>
                                        <td>
                                            <a href="#" class="action-icon icon-edit"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <?php $cnt++; } ?>
                                </tbody>

                            <?php } elseif($active_tab == 'support') { ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Center Name</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>Hours</th>
                                        <th>Contact</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $query=mysqli_query($bd, "SELECT * FROM tbl_support_centers");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt);?></td>
                                        <td style="font-weight: 600; color: var(--secondary);"><?php echo htmlentities($row['name']);?></td>
                                        <td><span class="badge" style="background: rgba(236, 72, 153, 0.1); color: var(--secondary);"><?php echo htmlentities($row['type']);?></span></td>
                                        <td><?php echo htmlentities($row['city']);?>, <?php echo htmlentities($row['state']);?></td>
                                        <td><i class="fa fa-clock" style="color: var(--text-muted);"></i> <?php echo htmlentities($row['hours']);?></td>
                                        <td><?php echo htmlentities($row['contact']);?></td>
                                        <td>
                                            <a href="#" class="action-icon icon-edit"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <?php $cnt++; } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Add Helpline Modal -->
    <div class="modal-bg" id="addModal">
        <div class="modal-content">
            <h3 style="margin-bottom: 20px; font-size: 1.3rem; border-bottom: 1px solid var(--border); padding-bottom: 16px;">Add Emergency Helpline</h3>
            <form method="post">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;">Service Name</label>
                    <input type="text" name="h_name" class="form-control" placeholder="e.g. Cyber Crime Helpline" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 6px;">
                </div>
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;">Contact Number</label>
                    <input type="text" name="h_number" class="form-control" placeholder="e.g. 1930" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 6px;">
                </div>
                <div class="form-group" style="margin-bottom: 24px;">
                    <label style="display: block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;">Category</label>
                    <select name="h_category" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 6px;">
                        <option value="Emergency">Emergency</option>
                        <option value="Police">Police</option>
                        <option value="Women Safety">Women Safety</option>
                        <option value="Domestic Violence">Domestic Violence</option>
                        <option value="Medical">Medical</option>
                        <option value="Cyber Crime">Cyber Crime</option>
                        <option value="Child Safety">Child Safety</option>
                        <option value="NGO">NGO Support</option>
                    </select>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="submit_helpline" class="btn btn-primary" style="background: var(--primary);">Save Helpline</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
<?php } ?>
