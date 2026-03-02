<div class="row w-100">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm border-warning border-top border-4 rounded-3 h-100 mt-5">
            <div
                class="card-header bg-white border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center mb-2">
                <h3 class="mb-0 text-dark fw-bold">Account Recovery</h3>
            </div>

            <div class="card-body">
                <div class="alert bg-light border text-muted shadow-sm mb-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-shield-lock-fill fs-4 text-warning me-3"></i>
                    <div>
                        <span class="small font-monospace">Please verify your identity by entering both your registered
                            email address and primary phone number.</span>
                    </div>
                </div>

                <?php if (!empty($data['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                        <?= htmlspecialchars($data['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="/doncosa/public/auth/recover" method="post">
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Registered Email <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg shadow-sm"
                            value="<?= htmlspecialchars($data['email']); ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="phone_number" class="form-label fw-bold">Registered Phone Number
                            <sup>*</sup></label>
                        <input type="text" name="phone_number" class="form-control form-control-lg shadow-sm"
                            value="<?= htmlspecialchars($data['phone_number']); ?>" required>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-warning btn-lg fw-bold shadow-sm">Verify Identity &
                            Recover</button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <a href="/doncosa/public/auth/login" class="text-secondary text-decoration-none small"><i
                            class="bi bi-arrow-left-short"></i> Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>