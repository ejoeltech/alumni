<?php require_once '../views/layout/header.php'; ?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h1 class="display-6 fw-bold text-dark mb-1"><i class="bi bi-gear-fill text-muted me-2"></i>Platform Settings
        </h1>
        <p class="text-muted fs-5">Administrative and Developer configuration hubs.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="/dashboard" class="btn btn-outline-secondary shadow-sm px-4 fw-bold"><i
                class="bi bi-arrow-left me-1"></i> Back to Dashboard</a>
    </div>
</div>

<div class="row g-4">
    <!-- Admin Panel (Role >= 2) -->
    <?php if ($data['user']['role_id'] >= 2): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-light rounded-4">
                <div class="card-body p-4">
                    <h4 class="card-title text-danger fw-bold mb-4"><i class="bi bi-tools me-2"></i> Admin Tools</h4>
                    <div class="list-group list-group-flush border-0 rounded-3 shadow-sm">
                        <?php if ($data['user']['role_id'] != 4): ?>
                            <a href="/admin/members"
                                class="list-group-item list-group-item-action py-3 fw-bold"><i
                                    class="bi bi-people-fill text-primary me-2"></i> Manage Global Members</a>
                        <?php endif; ?>

                        <a href="/admin/payments"
                            class="list-group-item list-group-item-action py-3 fw-bold"><i
                                class="bi bi-bank2 text-success me-2"></i> Accounting Engine & Levies</a>

                        <?php if ($data['user']['role_id'] != 4): ?>
                            <a href="/admin/events"
                                class="list-group-item list-group-item-action py-3 fw-bold"><i
                                    class="bi bi-calendar-event-fill text-warning me-2"></i> Create & Edit Events</a>
                            <a href="/admin/projects"
                                class="list-group-item list-group-item-action py-3 fw-bold"><i
                                    class="bi bi-clipboard2-data-fill text-info me-2"></i> Manage College Projects</a>
                            <a href="/admin/positions"
                                class="list-group-item list-group-item-action py-3 fw-bold text-primary"><i
                                    class="bi bi-diagram-3-fill me-2"></i> Pre-Configure Exco Positions</a>
                            <a href="/admin/elections"
                                class="list-group-item list-group-item-action py-3 fw-bold text-success"><i
                                    class="bi bi-box2-heart-fill me-2"></i> Run Live Platform Elections</a>
                            <a href="/admin/announcements"
                                class="list-group-item list-group-item-action py-3 fw-bold text-dark"><i
                                    class="bi bi-megaphone-fill text-danger me-2"></i> Broadcast Mass Announcements</a>
                            <a href="/admin/settings"
                                class="list-group-item list-group-item-action py-3 fw-bold text-danger"><i
                                    class="bi bi-gear-fill me-2"></i> Core Platform Variables</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Developer/Super Admin features (Role == 3) -->
    <?php if ($data['user']['role_id'] == 3): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 bg-dark text-white rounded-4 border border-1 border-secondary">
                <div class="card-body p-4">
                    <h4 class="card-title text-warning fw-bold mb-4"><i class="bi bi-terminal-fill me-2"></i> Developer
                        Station</h4>

                    <div class="list-group list-group-flush border-0 rounded-3 bg-transparent">
                        <a href="/admin/analytics"
                            class="list-group-item list-group-item-action py-3 fw-bold bg-transparent text-warning border-secondary"><i
                                class="bi bi-cpu text-info me-2"></i> Master Developer Analytics</a>
                        <a href="/admin/staff"
                            class="list-group-item list-group-item-action py-3 fw-bold bg-transparent text-danger border-secondary"><i
                                class="bi bi-shield-lock text-danger me-2"></i> Admin Roles & Staff Routing</a>
                    </div>

                    <div class="alert alert-danger border-danger mt-4 bg-opacity-10 py-3 shadow-none">
                        <small class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Critical Access
                            Area</small><br>
                        <small class="text-white-50 mt-1 d-block" style="font-size: 0.8rem;">Modifying variables in the
                            Developer Station alters logic loops across the entire production codebase.</small>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-warning bg-light opacity-50">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center p-5">
                    <i class="bi bi-lock-fill display-1 text-muted opacity-25 mb-3"></i>
                    <div class="fs-4 fw-bold text-secondary">Developer Lockout</div>
                    <p class="text-muted small">Elevated credentials required to mount Station node.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../views/layout/footer.php'; ?>