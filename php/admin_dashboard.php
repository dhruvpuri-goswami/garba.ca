<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: ../login.php");

    exit();
}

// Get the username from the session
$username = $_SESSION["username"];

// Connect to the database and fetch request details
require './connection.php';


$sql_approved = "SELECT * FROM tbl_event WHERE status='1'";
$result_approved = mysqli_query($conn, $sql_approved);
$approved = mysqli_num_rows($result_approved);

$sql_pending = "SELECT * FROM tbl_event WHERE status='0'";
$result_pending = mysqli_query($conn, $sql_pending);
$pending = mysqli_num_rows($result_pending);

$sql_total = "SELECT * FROM tbl_event";
$result_total = mysqli_query($conn, $sql_total);
$total = mysqli_num_rows($result_total);

$sql_completed = "SELECT * FROM tbl_event WHERE is_complete='1'";
$result_completed = mysqli_query($conn, $sql_completed);
$completed = mysqli_num_rows($result_completed);

$sql = "SELECT * FROM tbl_event LIMIT 3";
$result = mysqli_query($conn, $sql);
$requests = [];
while ($row = mysqli_fetch_assoc($result)) {
    $requests[] = $row;
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Garba.ca</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin_dashboard.php">
                <div class="sidebar-brand-text mx-3">Garba</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="./admin_dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">



            <!-- Heading -->
            <div class="sidebar-heading">
                Events
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>APPROVE EVENTS</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">APROVE EVENTS</h6>
                        <a class="collapse-item" href="./approve_requests.php">APPROVE EVENT</a>
                        <a class="collapse-item" href="./accepted_requests.php">ACCEPTED EVENTS</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Heading -->
            <div class="sidebar-heading">
                STATUS
            </div>


            <!-- Nav Item - Utilities Collapse Menu -->
                        <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>CHECK HISTORY</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">CHECK HISTORY</h6>
                        <a class="collapse-item" href="./all_requests.php">EVENT HISTORY</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="featured_events.php">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>FEATURE EVENTS</span>
                </a>
</li>
<li class="nav-item">
                <a class="nav-link" href="give_away.php">
                    <i class="fas fa-fw fa-donate"></i>
                    <span>GIVE AWAY</span>
                </a>
</li>
<li class="nav-item">
                <a class="nav-link" href="give_away_result.php">
                    <i class="fas fa-fw fa-donate"></i>
                    <span>GIVE AWAY RESULT</span>
                </a>
</li>
            <!-- Nav Item - Charts -->

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">admin</span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><b>Dashboard</b></h1>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-gradient-danger mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Events</h5>
                                    <p class="card-text display-4">
                                        <?php echo $total; ?>
                                    </p>
                                    <a href="./all_requests.php" class="btn btn-light">View All</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-gradient-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Approved Events</h5>
                                    <p class="card-text display-4">
                                        <?php echo $approved; ?>
                                    </p>
                                    <a href="./accepted_requests.php" class="btn btn-light">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-gradient-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Events</h5>
                                    <p class="card-text display-4">
                                        <?php echo $pending; ?>
                                    </p>
                                    <a href="./approve_requests.php" class="btn btn-light">View All</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-white bg-gradient-dark mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Completed Events</h5>
                                    <p class="card-text display-4">
                                        <?php echo $completed; ?>
                                    </p>
                                    <a href="./completed_events.php" class="btn btn-light">View All</a>
                                </div>
                            </div>
                        </div>
                    </div><br>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Latest Activity</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Event Name</th>
                                            <th>Venue</th>
                                            <th>Host</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1;
                                        foreach ($requests as $request): ?>
                                            <tr>
                                                <td>
                                                    <?php echo $count++; ?>
                                                </td>
                                                <td>
                                                    <?php echo $request['event_name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $request['event_venue']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $request['event_host']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $request['gmail']; ?>
                                                </td>
                                                <?php
                                                $data = $request['status'];
                                                $case;

                                                switch ($data) {
                                                    case 1:
                                                        $case = '<button type="button" class="btn btn-success btn-sm btn-nocursor">Approved</button>';
                                                        break;
                                                    case -1:
                                                        $case = '<button type="button" class="btn btn-danger btn-sm btn-nocursor">Denied</button>';
                                                        break;
                                                    case 0:
                                                        $case = '<button type="button" style="color: black;" class="btn btn-warning btn-sm btn-nocursor">Pending</button>';
                                                        break;
                                                }
                                                ?>
                                                <td>
                                                    <?php echo $case; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <a href="./all_requests.php" class="btn bg-gradient-primary text-white">Show
                                        All</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/demo/chart-area-demo.js"></script>
    <script src="../js/demo/chart-pie-demo.js"></script>


</body>

</html>