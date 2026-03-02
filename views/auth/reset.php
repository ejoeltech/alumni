<div class="row w-100">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm border-success border-top border-4 rounded-3 h-100 mt-5">
            <div
                class="card-header bg-white border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center mb-2">
                <h3 class="mb-0 text-dark fw-bold">Set New Password</h3>
            </div>

            <div class="card-body">
                <div class="alert bg-success bg-opacity-10 text-success border border-success shadow-sm mb-4 d-flex align-items-center"
                    role="alert">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div>
                        <span class="small font-monospace">Identity Verified! Please enter a secure new password for
                            your account below.</span>
                    </div>
                </div>

                <form action="/doncosa/public/auth/reset" method="post">
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold">New Password <sup>*</sup></label>
                        <input type="password" name="password"
                            class="form-control form-control-lg shadow-sm <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= htmlspecialchars($data['password']); ?>" required>
                        <span class="invalid-feedback">
                            <?= $data['password_err']; ?>
                        </span>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label fw-bold">Confirm New Password
                            <sup>*</sup></label>
                        <input type="password" name="confirm_password"
                            class="form-control form-control-lg shadow-sm <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= htmlspecialchars($data['confirm_password']); ?>" required>
                        <span class="invalid-feedback">
                            <?= $data['confirm_password_err']; ?>
                        </span>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>