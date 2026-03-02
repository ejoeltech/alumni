<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="text-primary mb-0">Member Directory</h2>
        <p class="text-muted">Manage active alumni, adjust system roles, and revoke capabilities.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="/dashboard" class="btn btn-outline-secondary">Back to Dashboard</a>
    </div>
</div>

<div class="card shadow-sm border-0 border-top border-primary border-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Member Name & Contact</th>
                        <th class="py-3">Grad Data</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">System Role</th>
                        <th class="py-3">Joined</th>
                        <th class="pe-4 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['users'])): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No members found in the database.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['users'] as $user): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3 shadow-sm"
                                            style="width: 40px; height: 40px; font-weight: bold;">
                                            <?= strtoupper(substr($user['full_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-dark fw-bold">
                                                <?= htmlspecialchars($user['full_name']); ?>
                                            </h6>
                                            <small class="text-muted d-block">
                                                <?= htmlspecialchars($user['email']); ?>
                                            </small>
                                            <small class="text-muted d-block"><i class="bi bi-telephone-fill"></i>
                                                <?= htmlspecialchars($user['phone_number']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="d-block fw-bold text-dark">Class of
                                        <?= $user['graduation_year'] ?: '<span class="text-muted fst-italic">Unknown</span>'; ?>
                                    </span>
                                    <small class="text-muted">Set:
                                        <?= htmlspecialchars($user['class_set'] ?? '') ?: 'N/A'; ?>
                                    </small>
                                </td>
                                <td>
                                    <?php if ($user['is_approved'] == 0): ?>
                                        <span
                                            class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-2 py-1"><i
                                                class="bi bi-clock-history me-1"></i> Pending</span>
                                    <?php elseif ($user['is_active']): ?>
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i
                                                class="bi bi-check-circle-fill me-1"></i> Active</span>
                                    <?php else: ?>
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1"><i
                                                class="bi bi-x-circle-fill me-1"></i> Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    $roleBadge = 'bg-secondary';
                                    if ($user['role_id'] == 2)
                                        $roleBadge = 'bg-info text-dark';
                                    if ($user['role_id'] == 3)
                                        $roleBadge = 'bg-dark text-warning';
                                    ?>
                                    <span class="badge <?= $roleBadge; ?>">
                                        <?= $user['role_name']; ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M j, Y', strtotime($user['created_at'])); ?>
                                    </small>
                                </td>
                                <td class="pe-4 text-end">
                                    <?php if ($user['is_approved'] == 0): ?>
                                        <form action="/admin/memberApprove/<?= $user['id']; ?>" method="POST"
                                            class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-success shadow-sm me-1"><i
                                                    class="bi bi-check-lg"></i> Approve</button>
                                        </form>
                                    <?php endif; ?>

                                    <a href="/admin/memberEdit/<?= $user['id']; ?>"
                                        class="btn btn-sm btn-light border shadow-sm text-primary"><i
                                            class="bi bi-pencil-square"></i> Modify</a>

                                    <!-- Delete Button Form -->
                                    <form action="/admin/memberDelete/<?= $user['id']; ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('WARNING: Are you sure you want to permanently delete this member? All associated events/projects created by this user will be orphaned.');">
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger ms-1 <?= ($user['id'] == $_SESSION['user_id'] || ($_SESSION['user_role'] < 3 && $user['role_id'] >= 2)) ? 'disabled' : ''; ?>"><i
                                                class="bi bi-trash3"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>