<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Admin Complaint Details</title>

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
        th, td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
        td b { color: var(--text-muted); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; display: block; margin-bottom: 4px; }
        tr:last-child td { border-bottom: none; }
    </style>

    <script language="javascript" type="text/javascript">
    var popUpWin=0;
    function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin) {
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }
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
                <div style="margin-bottom: 24px;">
                    <h2><i class="fa fa-file-alt" style="margin-right: 10px; color: var(--primary);"></i> Complaint Details</h2>
                </div>

                <div class="table-container">
                    <table>
                        <tbody>
                        <?php 
                        $query=mysqli_query($bd, "select tblcomplaints.*,users.fullName as name,category.categoryName as catname from tblcomplaints join users on users.id=tblcomplaints.userId join category on category.id=tblcomplaints.category where tblcomplaints.complaintNumber='".$_GET['cid']."'");
                        while($row=mysqli_fetch_array($query)) {
                        ?>                                  
                            <tr>
                                <td><b>Complaint Number</b> <span style="font-size: 1.1rem; font-weight: 700; color: var(--primary);">#<?php echo htmlentities($row['complaintNumber']);?></span></td>
                                <td><b>Complainant Name</b> <?php echo htmlentities($row['name']);?></td>
                                <td><b>Reg Date</b> <?php echo htmlentities($row['regDate']);?></td>
                            </tr>
                            <tr>
                                <td><b>Category</b> <?php echo htmlentities($row['catname']);?></td>
                                <td><b>SubCategory</b> <?php echo htmlentities($row['subcategory']);?></td>
                                <td><b>Complaint Type</b> <?php echo htmlentities($row['complaintType']);?></td>
                            </tr>
                            <tr>
                                <td><b>State</b> <?php echo htmlentities($row['state']);?></td>
                                <td colspan="2"><b>Nature of Complaint</b> <?php echo htmlentities($row['noc']);?></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Complaint Details</b> <div style="background: var(--background); padding: 16px; border-radius: 8px; margin-top: 8px;"><?php echo htmlentities($row['complaintDetails']);?></div></td>
                            </tr>
                            <tr>
                                <td colspan="3"><b>File (if any)</b> 
                                    <?php $cfile=$row['complaintFile'];
                                    if($cfile=="" || $cfile=="NULL") {
                                      echo "<span style='color: var(--text-muted);'>No File Attached</span>";
                                    } else { ?>
                                        <a href="../users/complaintdocs/<?php echo htmlentities($row['complaintFile']);?>" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; padding: 6px 12px;"><i class="fa fa-paperclip" style="margin-right: 6px;"></i> View Attached File</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            
                            <?php 
                            $ret=mysqli_query($bd, "select complaintremark.remark as remark,complaintremark.status as sstatus,complaintremark.remarkDate as rdate from complaintremark join tblcomplaints on tblcomplaints.complaintNumber=complaintremark.complaintNumber where complaintremark.complaintNumber='".$_GET['cid']."'");
                            while($rw=mysqli_fetch_array($ret)) {
                            ?>
                            <tr>
                                <td colspan="3" style="background: var(--primary-light);">
                                    <b>Admin Remark (<?php echo htmlentities($rw['rdate']); ?>)</b>
                                    <p style="margin: 8px 0;"><?php echo htmlentities($rw['remark']); ?></p>
                                    <b>Status Updated To:</b> <span class="badge badge-info"><?php echo htmlentities($rw['sstatus']); ?></span>
                                </td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="3">
                                    <b>Final Status</b>
                                    <?php if($row['status']=="") { 
                                        echo "<span class='badge badge-error'>Not Processed Yet</span>";
                                    } else if($row['status']=="in process") {
                                        echo "<span class='badge badge-warning'>In Process</span>";
                                    } else {
                                        echo "<span class='badge badge-success'>Closed</span>";
                                    } ?>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3" style="background: var(--background); padding: 24px;">
                                    <div style="display: flex; gap: 16px;">
                                        <?php if($row['status'] != "closed") { ?>
                                            <a href="javascript:void(0);" onClick="popUpWindow('updatecomplaint.php?cid=<?php echo htmlentities($row['complaintNumber']);?>');" class="btn btn-primary">
                                                <i class="fa fa-edit" style="margin-right: 8px;"></i> Take Action
                                            </a>
                                        <?php } ?>
                                        <a href="javascript:void(0);" onClick="popUpWindow('userprofile.php?uid=<?php echo htmlentities($row['userId']);?>');" class="btn btn-secondary">
                                            <i class="fa fa-user" style="margin-right: 8px;"></i> View User Details
                                        </a>
                                    </div>
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
