<div class="row pt-4 mb-3 align-items-center">
    <div class="col-md-6">
        <h2 class="text-danger text-dark-emphasis mb-0"><i class="bi bi-shield-lock-fill text-danger me-2"></i> Admin &
            Staff Access Control</h2>
        <p class="text-muted fw-bold">Manage elevated system user accounts, permissions, and roles.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="/doncosa/public/admin/members" class="btn btn-outline-primary ms-2 shadow-sm rounded border-3"><i
                class="bi bi-people-fill pe-1"></i> Add Admin from Member Directory</a>
        <a href="/doncosa/public/dashboard" class="btn btn-outline-secondary ms-2 shadow-sm rounded border-3">Exit
            Station</a>
    </div>
</div>

<div class="row mb-5 g-4 mt-2">
    <!-- Level 3 -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 bg-dark text-white rounded">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span
                        class="badge bg-warning text-dark fs-6 shadow-sm border border-warning px-3 py-2 rounded-pill fw-bold">Level
                        3</span>
                    <h5 class="ms-3 mb-0 text-white fw-bold">Developer Manager</h5>
                </div>
                <p class="font-monospace small mb-2 text-white-50">- The highest possible database permission.</p>
                <p class="font-monospace small mb-2 text-white-50">- Cannot be deleted by Level 2 Admins.</p>
                <p class="font-monospace small mb-0 text-white-50">- Access to all platform features & API logs.</p>
            </div>
        </div>
    </div>

    <!-- Level 2b -->
    <div class="col-md-4">
        <div class="card border-1 border-success shadow-sm h-100 bg-success bg-opacity-10 rounded">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span
                        class="badge bg-success text-white fs-6 shadow-sm border border-success px-3 py-2 rounded-pill fw-bold">Level
                        2b</span>
                    <h5 class="ms-3 mb-0 text-success fw-bold">Financial Admin</h5>
                </div>
                <p class="text-success font-monospace small mb-2">- Operations-focused accounting staff.</p>
                <p class="text-success font-monospace small mb-2">- Can view, create, and verify Member payments and
                    platform dues.</p>
                <p class="text-success font-monospace small mb-0">- <span
                        class="fw-bold text-decoration-underline text-danger">Strictly blocked</span> from all other
                    Admin tools (Members, Events, etc).</p>
            </div>
        </div>
    </div>

    <!-- Level 2 -->
    <div class="col-md-4">
        <div class="card border-1 border-secondary shadow-sm h-100 bg-white rounded">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span
                        class="badge bg-secondary text-white fs-6 shadow-sm border border-secondary px-3 py-2 rounded-pill fw-bold">Level
                        2</span>
                    <h5 class="ms-3 mb-0 text-dark fw-bold">Admin User</h5>
                </div>
                <p class="text-secondary font-monospace small mb-2">- Standard operations staff member.</p>
                <p class="text-secondary font-monospace small mb-2">- Controls Members, Events, Projects, Announcements.
                </p>
                <p class="text-secondary font-monospace small mb-0">- <span
                        class="text-danger fw-bold text-decoration-underline">Cannot</span> access Developer Station.
                </p>
            </div>
        </div>
    </div>
</div>


<div class="card shadow-sm border-0 border-top border-danger border-4 rounded-3 h-100 mb-5">
    <div
        class="card-header bg-white border-bottom-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center mb-2">
        <h4 class="mb-0 text-dark fw-bold">Elevated Operations Users</h4>
        <div class="badge bg-danger text-white p-2 border border-danger shadow-sm"><i
                class="bi bi-person-badge pe-1"></i> Staff Records</div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary text-uppercase small" style="border-top: 2px solid #eaeaea;">
                    <tr>
                        <th class="ps-4 py-3">Administrator Name</th>
                        <th class="py-3">Contact Binding</th>
                        <th class="py-3">Current System Role</th>
                        <th class="py-3">Status</th>
                        <th class="text-end pe-4 py-3">Manage Permissions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['users'])): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-2 d-block mb-3 text-secondary opacity-25"></i>
                                No Admin users have been assigned yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['users'] as $user): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger bg-opacity-10 text-danger fw-bold rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm border border-danger border-opacity-25"
                                            style="width: 45px; height: 45px; font-size: 18px;">
                                            <?= strtoupper(substr($user['full_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <span class="text-dark fw-bold fs-6 d-block">
                                                <?= htmlspecialchars($user['full_name']); ?>
                                            </span>
                                            <small class="text-muted font-monospace">UID #
                                                <?= $user['id']; ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="d-block text-dark fw-bold text-truncate" style="max-width:250px;"><i
                                            class="bi bi-envelope-fill text-muted me-1"></i>
                                        <?= htmlspecialchars($user['email']); ?>
                                    </span>
                                    <small class="d-block text-muted mt-1"><i class="bi bi-telephone-fill me-1"></i>
                                        <?= htmlspecialchars($user['phone_number'] ?: 'Not Provided'); ?>
                                    </small>
                                </td>
                                <td>
                                    <?php if ($user['role_id'] == 3): ?>
                                        <span class="badge bg-dark text-warning border border-warning shadow-sm"><i
                                                class="bi bi-star-fill text-warning me-1"></i> Developer Manager</span>
                                    <?php elseif ($user['role_id'] == 4): ?>
                                        <span class="badge bg-success text-white shadow-sm"><i
                                                class="bi bi-currency-exchange me-1"></i> Financial Admin (2b)</span>
                                    <?php elseif ($user['role_id'] == 2): ?>
                                        <span class="badge bg-info text-dark shadow-sm"><i class="bi bi-person-gear me-1"></i> Level
                                            2 Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($user['role_name']); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user['is_active']): ?>
                                        <span class="text-success fw-bold small"><i class="bi bi-shield-check me-1"></i>
                                            Valid</span>
                                    <?php else: ?>
                                        <span class="text-danger fw-bold small"><i class="bi bi-shield-lock me-1"></i>
                                            Suspended</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="/doncosa/public/admin/memberEdit/<?= $user['id']; ?>"
                                        class="btn btn-sm btn-outline-dark shadow-sm rounded <?= ($user['id'] == clone $_SESSION['user_id']) ? 'disabled' : ''; ?>"><i
                                            class="bi bi-sliders pe-1"></i> Edit Access</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>