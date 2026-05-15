<?php
session_start();
include('include/config.php');
if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
} else {
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date( 'd-m-Y h:i:s A', time () );

    if(isset($_POST['submit'])) {
        $category=$_POST['category'];
        $description=$_POST['description'];
        $sql=mysqli_query($bd, "insert into category(categoryName,categoryDescription) values('$category','$description')");
        $_SESSION['msg']="Category Created !!";
    }

    if(isset($_GET['del'])) {
        mysqli_query($bd, "delete from category where id = '".$_GET['id']."'");
        $_SESSION['delmsg']="Category deleted !!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nyayaprabha | Admin Categories</title>

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
                <div style="margin-bottom: 24px;">
                    <h2><i class="fa fa-folder" style="margin-right: 10px; color: var(--primary);"></i> Category Management</h2>
                </div>
                
                <?php if(isset($_POST['submit'])) { ?>
                    <div style="background: rgba(16, 185, 129, 0.1); color: #10B981; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                        <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                    </div>
                <?php } ?>

                <?php if(isset($_GET['del'])) { ?>
                    <div style="background: rgba(239, 68, 68, 0.1); color: #EF4444; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px;">
                        <?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
                    </div>
                <?php } ?>

                <div class="card" style="margin-bottom: 30px;">
                    <h3 style="margin-bottom: 20px; font-size: 1.25rem;">Create Category</h3>
                    <form name="Category" method="post" style="max-width: 600px;">
                        <div class="form-group">
                            <label class="form-label">Category Name</label>
                            <input type="text" placeholder="Enter category Name" name="category" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="5" placeholder="Enter category description"></textarea>
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Create Category</button>
                    </form>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Creation date</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $query=mysqli_query($bd, "select * from category");
                        $cnt=1;
                        while($row=mysqli_fetch_array($query)) {
                        ?>                                  
                            <tr>
                                <td><?php echo htmlentities($cnt);?></td>
                                <td style="font-weight: 600; color: var(--text-main);"><?php echo htmlentities($row['categoryName']);?></td>
                                <td><?php echo htmlentities($row['categoryDescription']);?></td>
                                <td style="color: var(--text-muted);"><?php echo htmlentities($row['creationDate']);?></td>
                                <td style="color: var(--text-muted);"><?php echo htmlentities($row['updationDate']);?></td>
                                <td>
                                    <a href="edit-category.php?id=<?php echo $row['id']?>" style="color: var(--info); margin-right: 12px;"><i class="fa fa-edit"></i></a>
                                    <a href="category.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete?')" style="color: var(--error);"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php $cnt=$cnt+1; } ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
<?php } ?>