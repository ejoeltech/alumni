<div class="row pt-4">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card bg-transparent border-0 pb-0">
            <div class="card-body py-1 d-flex justify-content-between">
                <a href="/doncosa/public/admin/members" class="text-secondary text-decoration-none"><i
                        class="bi bi-arrow-left-short"></i> Back to Members Directory</a>
                <span class="badge bg-secondary p-2 rounded-pill shadow-sm">UID: #
                    <?= $data['user']['id']; ?>
                </span>
            </div>
        </div>

        <div class="card shadow-sm border-warning border-top border-4 rounded-3 h-100 my-4 pb-4 px-4 py-3">
            <div class="card-header bg-white border-0 pb-0 pt-4 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-warning text-dark fw-bold">Modify Member Account</h3>
                <span class="text-muted fst-italic h5">Joined:
                    <?= date('M Y', strtotime($data['user']['created_at'])); ?>
                </span>
            </div>
            <div class="card-body">

                <div class="alert alert-warning border border-warning shadow-sm mt-3 mb-5 d-flex align-items-center"
                    role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-4 text-warning me-3"></i>
                    <div>
                        <h6 class="alert-heading fw-bold mb-1">Administrative Warning</h6>
                        <span class="small font-monospace">You are modifying system permissions and authentication
                            access for
                            <?= htmlspecialchars($data['user']['full_name']); ?>. Any changes made are applied
                            immediately.
                        </span>
                    </div>
                </div>

                <?php if ($data['user']['is_approved'] == 0): ?>
                    <div class="alert alert-danger border border-danger shadow-sm mb-5 d-flex align-items-center"
                        role="alert">
                        <i class="bi bi-clock-history fs-4 text-danger me-3"></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">Account Pending Approval</h6>
                            <span class="small font-monospace">This account has not yet been approved for platform entry.
                                You must approve them via the Member Directory dashboard before they can physically sign
                                in.</span>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="/doncosa/public/admin/memberEdit/<?= $data['user']['id']; ?>" method="POST">

                    <div class="row g-4 mb-5 pb-3 border-bottom text-muted opacity-75">
                        <div class="col-md-6">
                            <label class="form-label d-block text-uppercase small fw-bold mb-1">Registered Alias</label>
                            <span class="fs-5 text-dark fw-bold">
                                <?= htmlspecialchars($data['user']['full_name']); ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block text-uppercase small fw-bold mb-1">Registered Email</label>
                            <span class="fs-5 text-dark fw-bold">
                                <?= htmlspecialchars($data['user']['email']); ?>
                            </span>
                        </div>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <!-- Account Status Control -->
                        <div class="col-md-6 p-4 bg-light rounded shadow-sm border text-center">
                            <label for="is_active"
                                class="form-label fw-bold d-block text-dark fs-5 border-bottom pb-3 mb-3">Login
                                Status</label>

                            <select name="is_active"
                                class="form-select form-select-lg border border-3 <?= ($data['user']['is_active']) ? 'border-success' : 'border-danger'; ?> shadow-sm text-center fw-bold">
                                <option class="text-success" value="1" <?= ($data['user']['is_active'] == 1) ? 'selected' : ''; ?>>Authorized & Active</option>
                                <option class="text-danger" value="0" <?= ($data['user']['is_active'] == 0) ? 'selected' : ''; ?>>LOCKED OUT / SUSPENDED</option>
                            </select>
                            <small class="d-block text-muted mt-3 py-2 lh-sm fst-italic">Setting an account to suspended
                                prevents the user from logging in or making any changes.</small>
                        </div>

                        <!-- Role Assignment Control -->
                        <div class="col-md-6 p-4 bg-light rounded shadow-sm border border-secondary text-center">
                            <label for="role_id"
                                class="form-label fw-bold d-block text-dark fs-5 border-bottom border-secondary pb-3 mb-3">System
                                Role Binding</label>

                            <select name="role_id"
                                class="form-select form-select-lg border border-secondary border-3 shadow-none text-center bg-white text-dark fw-bold">
                                <option value="1" <?= ($data['user']['role_id'] == 1) ? 'selected' : ''; ?>>Level 1 (Basic
                                    Member)</option>
                                <option value="2" <?= ($data['user']['role_id'] == 2) ? 'selected' : ''; ?>
                                    <?= ($_SESSION['user_role'] < 3 && $data['user']['role_id'] == 3) ? 'disabled' : ''; ?>>Level
                                    2 (Admin Operations)
                                </option>
                                <option class="text-success fw-bold bg-success bg-opacity-10" value="4"
                                    <?= ($data['user']['role_id'] == 4) ? 'selected' : ''; ?>>Level 2b (Financial Admin)
                                </option>
                                <?php if ($_SESSION['user_role'] == 3): ?>
                                    <option class="text-warning bg-dark" value="3" <?= ($data['user']['role_id'] == 3) ? 'selected' : ''; ?>>Level 3 (Developer / Super Admin)</option>
                                <?php endif; ?>
                            </select>
                            <small class="d-block text-muted mt-3 py-2 lh-sm fst-italic">Escalate or revoke role
                                privileges. <mark class="bg-warning text-dark px-1">Changes log out standard
                                    users.</mark></small>
                        </div>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <!-- Membership Exco Position Assignment -->
                        <div class="col-md-12 p-4 bg-light rounded shadow-sm border border-secondary text-center">
                            <label for="membership_position"
                                class="form-label fw-bold d-block text-dark fs-5 border-bottom border-secondary pb-3 mb-3">
                                <i class="bi bi-person-badge-fill text-primary"></i> Executive Membership Position
                            </label>

                            <input type="text" name="membership_position"
                                class="form-control form-control-lg border border-secondary border-3 text-center fw-bold"
                                placeholder="e.g. Current President, Former Secretary..."
                                value="<?= htmlspecialchars($data['user']['membership_position'] ?? '') ?>">

                            <small class="d-block text-muted mt-3 py-2 lh-sm fst-italic">
                                Leave this blank for regular members. Setting an Alumni Title here explicitly escalates
                                their platform profile directly into the Welcome Page Mugshot directory!
                            </small>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit"
                            class="btn btn-warning text-dark border-dark btn-lg shadow-sm rounded border-3 fw-bold">Save
                            System Access Attributes <i class="bi bi-shield-check ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>