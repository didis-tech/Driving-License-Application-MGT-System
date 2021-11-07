<?php
$active = 'class="active"';
?>
<div class="sidebar">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="javascript:void(0)" class="simple-text logo-mini"> GL </a>
            <a href="javascript:void(0)" class="simple-text logo-normal">
                GetLicensed
            </a>
        </div>
        <ul class="nav">
            <li <?php $isActive = ($page == 'home') ? $active : '';
                echo $isActive; ?>>
                <a href="./index.php">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li <?php $isActive = ($page == 'users') ? $active : '';
                echo $isActive; ?>>
                <a href="./users.php">
                    <i class="fa fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
            <li <?php $isActive = ($page == 'license') ? $active : '';
                echo $isActive; ?>>
                <a href="./licenses.php">
                    <i class="tim-icons icon-badge"></i>
                    <p>Licenses</p>
                </a>
            </li>
            <li <?php $isActive = ($page == 'tests') ? $active : '';
                echo $isActive; ?>>
                <a href="./tests.php">
                    <i class="tim-icons icon-paper"></i>
                    <p>Tests</p>
                </a>
            </li>
            <li <?php $isActive = ($page == 'profile') ? $active : '';
                echo $isActive; ?>>
                <a href="./user.php">
                    <i class="tim-icons icon-single-02"></i>
                    <p>Profile</p>
                </a>
            </li>
        </ul>
    </div>
</div>