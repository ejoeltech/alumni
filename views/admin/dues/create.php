<?php require_once '../views/layout/header.php'; ?>

<div class="row min-vh-100 align-items-center justify-content-center pt-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-5">

            <div class="card-header bg-success text-white py-4 px-4 border-0 position-relative">
                <i class="bi bi-wallet2 position-absolute text-white opacity-25"
                    style="font-size: 6rem; right: -15px; top: -15px;"></i>
                <div class="position-relative z-1">
                    <h3 class="fw-bold mb-1"><i class="bi bi-plus-circle-fill me-2"></i> Create New Levy</h3>
                    <p class="mb-0 text-white-50 small">Deploy a financial obligation to the Global Directory</p>
                </div>
            </div>

            <div class="card-body p-5 bg-white">
                <?php if (!empty($data['error'])): ?>
                    <div
                        class="alert alert-danger shadow-sm border-danger border-start-0 border-top-0 border-end-0 border-bottom border-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($data['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="/admin/dueCreate" method="post">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold small text-uppercase text-muted">Levy or Dues Title
                            <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg bg-light border-0 shadow-sm"
                            value="<?= htmlspecialchars($data['title_input']); ?>"
                            placeholder="e.g. 2026 Annual Registration Dues" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="form-label fw-bold small text-uppercase text-muted">Amount <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white fw-bold border-0 shadow-sm"><span
                                    class="fw-bold fs-5 lh-1">&#8358;</span></span>
                            <input type="number" step="0.01" name="amount"
                                class="form-control form-control-lg bg-light border-0 shadow-sm"
                                value="<?= htmlspecialchars($data['amount']); ?>" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="form-label fw-bold small text-uppercase text-muted">Payment
                            Deadline (Optional)</label>
                        <input type="date" name="due_date"
                            class="form-control form-control-lg bg-light border-0 shadow-sm mb-3"
                            value="<?= htmlspecialchars($data['due_date']); ?>">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div
                                    class="form-check form-switch bg-light p-3 rounded-4 shadow-sm border-0 h-100 d-flex align-items-center">
                                    <input class="form-check-input ms-0 me-3 fs-4" type="checkbox" role="switch"
                                        name="is_monthly" id="is_monthly" value="1">
                                    <label class="form-check-label ms-1" for="is_monthly">
                                        <span class="d-block fw-bold text-dark">Recurring Monthly Due</span>
                                        <small class="text-muted" style="font-size: 0.70rem;">Mark as a standard monthly
                                            member cycle.</small>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div
                                    class="form-check form-switch bg-light p-3 rounded-4 shadow-sm border-0 h-100 d-flex align-items-center">
                                    <input class="form-check-input ms-0 me-3 fs-4" type="checkbox" role="switch"
                                        name="is_donation" id="is_donation" value="1">
                                    <label class="form-check-label ms-1" for="is_donation">
                                        <span class="d-block fw-bold text-dark">Welfare Support / Donation</span>
                                        <small class="text-muted" style="font-size: 0.70rem;">Allow free-will payment
                                            amounts.</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="description" class="form-label fw-bold small text-uppercase text-muted">Description
                            & Details</label>
                        <textarea name="description"
                            class="form-control bg-light border-0 shadow-sm rounded-4 text-dark p-3" rows="4"
                            placeholder="Fully describe what this payment covers. Include payment instructions or bank account details if physical transfer is required."><?= htmlspecialchars($data['description']); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                        <a href="/admin/dues"
                            class="btn btn-outline-secondary fw-bold px-4 rounded-pill"><i
                                class="bi bi-x-circle me-1"></i> Cancel</a>
                        <button type="submit"
                            class="btn btn-success shadow-lg px-5 py-2 fw-bold rounded-pill text-uppercase"
                            style="letter-spacing: 1px;"><i class="bi bi-send-check-fill me-2"></i> Deploy Levy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/layout/footer.php'; ?>