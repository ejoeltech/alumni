<?php require_once '../views/layout/header.php'; ?>

<!-- Welcome Header -->
<div class="row mb-5 align-items-center">
    <div class="col-md-8">
        <h1 class="display-6 fw-bold mb-1">
            <?php
            $hour = date('H');
            $greeting = ($hour < 12) ? 'Good Morning' : (($hour < 17) ? 'Good Afternoon' : 'Good Evening');
            echo $greeting . ', ' . htmlspecialchars(explode(' ', $data['user']['full_name'])[0]) . '!';
            ?>
        </h1>
        <p class="text-muted fs-5 mb-0">Here is what's happening in your network today.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <span
            class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 fs-6 shadow-sm">
            <i class="bi bi-person-badge-fill me-1"></i> <?= htmlspecialchars($data['role_name']); ?>
        </span>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Main Dashboard Feed Array -->
    <div class="col-lg-8">

        <!-- Quick Stats Cards (Dummy data strictly for dashboard look as requested) -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div
                    class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white overflow-hidden position-relative">
                    <i class="bi bi-people-fill position-absolute text-white opacity-25"
                        style="font-size: 5rem; right: -10px; bottom: -15px;"></i>
                    <div class="card-body p-4 position-relative z-1">
                        <h6 class="text-uppercase fw-bold text-white-50 mb-1">Total Members</h6>
                        <h2 class="display-5 fw-bold mb-0">
                            <!-- Could be dynamic, defaulting strictly for look -->
                            2,491
                        </h2>
                        <small class="text-white-50"><i class="bi bi-arrow-up-right"></i> +12 this week</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div
                    class="card border-0 shadow-sm rounded-4 h-100 bg-warning text-dark overflow-hidden position-relative">
                    <i class="bi bi-calendar-event-fill position-absolute text-dark opacity-10"
                        style="font-size: 5rem; right: -10px; bottom: -15px;"></i>
                    <div class="card-body p-4 position-relative z-1">
                        <h6 class="text-uppercase fw-bold text-black-50 mb-1">Active Events</h6>
                        <h2 class="display-5 fw-bold mb-0">3</h2>
                        <small class="text-black-50">Next: Homecoming 2026</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div
                    class="card border-0 shadow-sm rounded-4 h-100 bg-success text-white overflow-hidden position-relative">
                    <i class="bi bi-cash-coin position-absolute text-white opacity-25"
                        style="font-size: 5rem; right: -10px; bottom: -15px;"></i>
                    <div class="card-body p-4 position-relative z-1">
                        <h6 class="text-uppercase fw-bold text-white-50 mb-1">Fundraising</h6>
                        <h2 class="display-5 fw-bold mb-0">84<span class="fs-4">%</span></h2>
                        <small class="text-white-50">Library project goal met</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Global Announcements Feed -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-megaphone-fill text-danger me-2"></i> Important
                    Announcements</h5>
            </div>
            <div class="card-body p-4">
                <div class="alert bg-light border-start border-4 border-danger shadow-sm rounded p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-danger"><i class="bi bi-exclamation-circle-fill me-1"></i> Annual
                            General Meeting (AGM) Setup</span>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.70rem;">2 Days Ago</small>
                    </div>
                    <p class="mb-0 text-dark small">All regional chapter coordinators must strictly submit their
                        finalized local registries into the system before the end of the month leading into the AGM.</p>
                </div>

                <div class="alert bg-light border-start border-4 border-primary shadow-sm rounded p-3 mb-0">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-primary"><i class="bi bi-info-circle-fill me-1"></i> New Platform
                            Architecture Deployed</span>
                        <small class="text-muted text-uppercase fw-bold" style="font-size: 0.70rem;">March 2,
                            2026</small>
                    </div>
                    <p class="mb-0 text-dark small">The development team has just pushed massive upgrades to the
                        Directory and Elections components! Please update your member profiles when you have the chance.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Side Panel Widgets -->
    <div class="col-lg-4">

        <!-- Direct Messages / Notifications -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div
                class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-bell-fill text-warning me-2"></i> Notifications</h5>
                <span class="badge bg-danger rounded-pill">2 New</span>
            </div>
            <div class="card-body p-0 mt-2">
                <div class="list-group list-group-flush border-0">
                    <a href="#"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 bg-primary bg-opacity-10 text-dark">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm flex-shrink-0"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold fs-6">Connection Request</h6>
                                <small class="text-muted d-block">Musa Saliu requested to link networking
                                    profiles.</small>
                            </div>
                        </div>
                    </a>
                    <a href="#"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 bg-primary bg-opacity-10 text-dark border-top border-white">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm flex-shrink-0"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-wallet-fill"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 fw-bold fs-6">Dues Confirmed</h6>
                                <small class="text-muted d-block">Your 2026 Annual Dues have been cleared.</small>
                            </div>
                        </div>
                    </a>
                    <a href="#"
                        class="list-group-item list-group-item-action border-0 px-4 py-3 text-dark border-top border-light">
                        <div class="d-flex align-items-center">
                            <div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm flex-shrink-0"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-check2-all"></i>
                            </div>
                            <div class="ms-3 text-muted">
                                <h6 class="mb-0 fw-bold fs-6">Profile Updated</h6>
                                <small class="d-block">Your contact data was modified successfully.</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- System Alerts & Info -->
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body p-4 text-center">
                <i class="bi bi-shield-lock-fill text-muted opacity-25 display-3 mb-3"></i>
                <h5 class="fw-bold text-dark">Account Security Status</h5>
                <p class="text-muted small mb-3">Your encryption status is strictly active and stable.</p>
                <a href="/doncosa/public/dashboard/editProfile"
                    class="btn btn-outline-dark rounded-pill shadow-sm btn-sm px-4 fw-bold"><i
                        class="bi bi-pencil-square me-1"></i> Update Security Info</a>
            </div>
        </div>

    </div>
</div>

<?php require_once '../views/layout/footer.php'; ?>