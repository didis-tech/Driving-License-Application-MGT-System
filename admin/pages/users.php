<?php
session_start();
if (!isset($_SESSION['adm_login']) || $_SESSION['adm_login'] !== true) {
    header("location: ./login.php");
}
require '../../resources/db_connect.php';
require '../../resources/admin-fetch.php';
$Users = $conn->query("SELECT * FROM `user`");
$countUsers = $Users->num_rows;
$ExpiredLicense = $conn->query("SELECT * FROM `license` where `license_status`='expired'");
$countExpiredLicense = $ExpiredLicense->num_rows;
$activeLicense = $conn->query("SELECT * FROM `license` where `license_status`='active'");
$countActiveLicense = $activeLicense->num_rows;
$page = 'users';
if (isset($_POST['driving_skill'])) {
    $driving_skill = (int)($_POST['driving_skill']);
    $braking = (int)($_POST['braking']);
    $sight = (int)($_POST['sight']);
    $overtaking = (int)($_POST['overtaking']);
    $user_id = $_POST['user_id'];
    $total = $driving_skill + $braking + $sight + $overtaking;
    $average = $total / 4;
    $testStat = ($average >= 5) ? 'pass' : 'failed';
    $chkQuery = $conn->query("SELECT * FROM `driving_test` WHERE `driver_id`='$user_id'");
    $countQuery = $chkQuery->num_rows;
    if ($countQuery !== 0) {
        $conn->query("UPDATE `driving_test` SET
                    `sight`='$sight',
                    `driving_skill`='$driving_skill',
                    `overtaking`='$overtaking',
                    `braking`='$braking',
                    `total`='$average',
                    `test_status`='$testStat' WHERE `driver_id`='$user_id'");
    } else {
        $conn->query("INSERT INTO `driving_test`(
            `driver_id`,
              `sight`,
               `driving_skill`,
                `overtaking`,
                 `braking`,
                  `total`,
                   `test_status`,
                     `datetime`) 
           VALUES (
           '$user_id',
           '$sight',
           '$driving_skill',
           '$overtaking',
           '$braking',
           '$average',
           '$testStat',
           now())");
    }

    if ($average >= 5) {
        $conn->query("UPDATE user SET `status`='in progress' where user_id='$user_id'");
    }
    echo "<script> window.location= 'users.php' </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <title>GetLicensed - Admin</title>
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="../assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <style media="screen">
        @import url(../../web-fonts-with-css/css/all.css);
        @import url(../../web-fonts-with-css/css/brands.css);
        @import url(../../web-fonts-with-css/css/fontawesome.css);
        @import url(../../web-fonts-with-css/css/svg-with-js.css);
        @import url(../../web-fonts-with-css/css/regular.css);
        @import url(../../web-fonts-with-css/css/solid.css);
        @import url(../../web-fonts-with-css/css/v4-shims.css);

        .form-control {
            border: 2px solid black !important;
        }
    </style>
    <link rel="stylesheet" href="/driving_license/DataTables/datatables.css">
    <script src="../assets/js/core/jquery.min.js"></script>
    <script src="/driving_license/DataTables/datatables.js"></script>
</head>

<body class="white-content">
    <div class="wrapper">
        <?php require 'sidebar.php' ?>
        <div class="main-panel">
            <!-- Navbar -->
            <?php require 'header.php' ?>
            <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH" />
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal modal-search fade" id="testUser" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Test</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="title">Test in progress</h5>
                                </div>
                                <div class="card-body">
                                    <form id="testForm" method="post">
                                        <input type="hidden" id="test_user_id" name="user_id" required>
                                        <div class="row">
                                            <div class="col-md-6 pr-md-1">
                                                <div class="form-group">
                                                    <label>Sight</label>
                                                    <select name="sight" id="sight" class="form-control" required>
                                                        <?php for ($i = 0; $i <= 10; $i++) {
                                                            echo "<option value='$i'>$i</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-md-1">
                                                <div class="form-group">
                                                    <label>Driving skill</label>
                                                    <select name="driving_skill" id="driving_skill" class="form-control" required>
                                                        <?php for ($i = 0; $i <= 10; $i++) {
                                                            echo "<option value='$i'>$i</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 pr-md-1">
                                                <div class="form-group">
                                                    <label>Overtaking</label>
                                                    <select name="overtaking" id="overtaking" class="form-control" required>
                                                        <?php for ($i = 0; $i <= 10; $i++) {
                                                            echo "<option value='$i'>$i</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-md-1">
                                                <div class="form-group">
                                                    <label>Braking</label>
                                                    <select name="braking" id="braking" class="form-control" required>
                                                        <?php for ($i = 0; $i <= 10; $i++) {
                                                            echo "<option value='$i'>$i</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-fill btn-primary">Save</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Navbar -->
            <div class="content">

                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header">
                            <h4 class="card-title"> Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table tablesorter " id="users">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>
                                                Passport
                                            </th>
                                            <th>
                                                Name
                                            </th>
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Phone number
                                            </th>
                                            <th>
                                                State
                                            </th>
                                            <th>
                                                LGA
                                            </th>
                                            <th>
                                                Address
                                            </th>
                                            <th>
                                                Date of birth
                                            </th>
                                            <th>
                                                Level of registration
                                            </th>
                                            <th>
                                                Registration Status
                                            </th>
                                            <th class="text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($Users as $key => $user) { ?>
                                            <tr>
                                                <td> <img src="/driving_license/assets/passports/<?php echo $user['passport']; ?>" alt="" width="20">

                                                </td>
                                                <td><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td><?php echo $user['phone']; ?></td>
                                                <td><?php echo $user['state']; ?></td>
                                                <td><?php echo $user['lga']; ?></td>
                                                <td><?php echo $user['address']; ?></td>
                                                <td><?php echo $user['dob']; ?></td>
                                                <td><?php echo $user['level']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($user['status'] === 'pending') {
                                                        $bagde = "badge badge-secondary";
                                                    } elseif ($user['status'] === 'in progress') {
                                                        $bagde = "badge badge-primary";
                                                    } else {
                                                        $bagde = "badge badge-success";
                                                    } ?>
                                                    <span class="<?php echo $bagde; ?>"><?php echo $user['status']; ?></span>

                                                </td>
                                                <?php if ($user['level'] == 'level 1') { ?>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button type="button" onclick="testUser(<?php echo $user['user_id']; ?>)" class="btn btn-primary">Test</button>
                                                        </div>
                                                    </td>
                                                <?php } ?>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script>
        function testUser(params) {
            const user_id = params;
            $("#test_user_id").val(user_id);
            $("#testUser").modal();
        }
    </script>
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title">Sidebar Background</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger background-color">
                        <div class="badge-colors text-center">
                            <span class="badge filter badge-primary active" data-color="primary"></span>
                            <span class="badge filter badge-info" data-color="blue"></span>
                            <span class="badge filter badge-success" data-color="green"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="adjustments-line text-center color-change">
                    <span class="color-label">LIGHT MODE</span>
                    <span class="badge light-badge mr-2"></span>
                    <span class="badge dark-badge ml-2"></span>
                    <span class="color-label">DARK MODE</span>
                </li>
            </ul>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <!--  Notifications Plugin    -->
    <script src="../assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script>
    <!-- Black Dashboard DEMO methods, don't include it in your project! -->
    <script src="../assets/demo/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('#users').DataTable({
                "order": [
                    [3, "desc"]
                ]
            });
            $().ready(function() {
                $sidebar = $(".sidebar");
                $navbar = $(".navbar");
                $main_panel = $(".main-panel");

                $full_page = $(".full-page");

                $sidebar_responsive = $("body > .navbar-collapse");
                sidebar_mini_active = true;
                white_color = false;

                window_width = $(window).width();

                fixed_plugin_open = $(
                    ".sidebar .sidebar-wrapper .nav li.active a p"
                ).html();

                $(".fixed-plugin a").click(function(event) {
                    if ($(this).hasClass("switch-trigger")) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $(".fixed-plugin .background-color span").click(function() {
                    $(this).siblings().removeClass("active");
                    $(this).addClass("active");

                    var new_color = $(this).data("color");

                    if ($sidebar.length != 0) {
                        $sidebar.attr("data", new_color);
                    }

                    if ($main_panel.length != 0) {
                        $main_panel.attr("data", new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr("filter-color", new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr("data", new_color);
                    }
                });

                $(".switch-sidebar-mini input").on(
                    "switchChange.bootstrapSwitch",
                    function() {
                        var $btn = $(this);

                        if (sidebar_mini_active == true) {
                            $("body").removeClass("sidebar-mini");
                            sidebar_mini_active = false;
                            blackDashboard.showSidebarMessage(
                                "Sidebar mini deactivated..."
                            );
                        } else {
                            $("body").addClass("sidebar-mini");
                            sidebar_mini_active = true;
                            blackDashboard.showSidebarMessage("Sidebar mini activated...");
                        }

                        // we simulate the window Resize so the charts will get updated in realtime.
                        var simulateWindowResize = setInterval(function() {
                            window.dispatchEvent(new Event("resize"));
                        }, 180);

                        // we stop the simulation of Window Resize after the animations are completed
                        setTimeout(function() {
                            clearInterval(simulateWindowResize);
                        }, 1000);
                    }
                );

                $(".switch-change-color input").on(
                    "switchChange.bootstrapSwitch",
                    function() {
                        var $btn = $(this);

                        if (white_color == true) {
                            $("body").addClass("change-background");
                            setTimeout(function() {
                                $("body").removeClass("change-background");
                                $("body").removeClass("white-content");
                            }, 900);
                            white_color = false;
                        } else {
                            $("body").addClass("change-background");
                            setTimeout(function() {
                                $("body").removeClass("change-background");
                                $("body").addClass("white-content");
                            }, 900);

                            white_color = true;
                        }
                    }
                );

                $(".light-badge").click(function() {
                    $("body").addClass("white-content");
                });

                $(".dark-badge").click(function() {
                    $("body").removeClass("white-content");
                });
            });
        });
    </script>
</body>

</html>