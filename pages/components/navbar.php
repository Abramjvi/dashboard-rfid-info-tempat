<?php
// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// Map filenames to display names
$page_names = [
    'dashboard.php' => 'Dashboard',
    'real-time-occupancy.php' => 'Real Time Occupancy',
    'evacuation-status-monitor.php' => 'Evacuation Status Monitor',
    'historical-occupancy.php' => 'Historical Occupancy',
    'people-tracking.php' => 'People Tracking',
    'dwell-time-analysis.php' => 'Dwell Time Analysis',
    'anomaly-detection.php' => 'Anomaly Detection'
];

// Get the display name for the current page, default to 'Dashboard' if not found
$page_display_name = isset($page_names[$current_page]) ? $page_names[$current_page] : 'Dashboard';
?>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><?php echo htmlspecialchars($page_display_name); ?></li>
            </ol>
            <h6 class="font-weight-bolder mb-0"><?php echo htmlspecialchars($page_display_name); ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body fs-6 font-weight-bold px-0">
                        <span id="datetime" class="badge bg-primary d-sm-inline d-none me-3"></span>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>