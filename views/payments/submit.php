<?php require_once '../views/layout/header.php'; ?>

<div class="row min-vh-100 justify-content-center align-items-center pt-5">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5 bg-white position-relative">
            <div class="card-header bg-success text-white py-4 px-5 border-bottom-0 pb-1 position-relative">
                <i class="bi bi-cloud-arrow-up-fill position-absolute text-white opacity-25"
                    style="font-size: 8rem; right: -25px; top: -20px;"></i>
                <h3 class="fw-bold mb-1 position-relative z-1"><i class="bi bi-send-check-fill me-2"></i> Submit Payment
                    Log</h3>
                <p class="text-white-50 mb-0 position-relative z-1">Upload transfer details for Admin verification.</p>
            </div>

            <div class="card-body p-5 pt-4">
                <?php if (!empty($data['error'])): ?>
                    <div
                        class="alert alert-danger shadow-sm border-danger border-start-0 border-top-0 border-end-0 border-bottom border-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= htmlspecialchars($data['error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($data['success'])): ?>
                    <div
                        class="alert alert-success shadow-sm border-success border-start-0 border-top-0 border-end-0 border-bottom border-3">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <?= htmlspecialchars($data['success']); ?>
                        <div class="mt-2 text-end">
                            <a href="/doncosa/public/payments"
                                class="btn btn-sm btn-outline-success fw-bold px-3 rounded-pill shadow-sm"><i
                                    class="bi bi-arrow-return-left me-1"></i> Back to Finances</a>
                        </div>
                    </div>
                <?php else: ?>
                    <form action="/doncosa/public/payments/submit/<?= $data['due_id']; ?>" method="post">

                        <div class="mb-4">
                            <label for="due_id" class="form-label fw-bold text-uppercase small text-muted">Select Target
                                Levy / Dues (Optional)</label>
                            <select name="due_id" class="form-select form-select-lg bg-light border-0 shadow-sm text-dark">
                                <option value="">-- General Fund Deposit --</option>
                                <optgroup label="Monthly Subscription Dues">
                                    <?php foreach ($data['all_dues'] as $due): ?>
                                        <?php if ($due['is_monthly'] == 1): ?>
                                            <option value="<?= $due['id']; ?>" <?= ($data['due_id'] == $due['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($due['title']); ?> (<?= '&#8358;' . number_format($due['amount'], 2); ?>)
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </optgroup>

                                <optgroup label="Welfare & Direct Donations">
                                    <?php foreach ($data['all_dues'] as $due): ?>
                                        <?php if ($due['is_donation'] == 1): ?>
                                            <option value="<?= $due['id']; ?>" <?= ($data['due_id'] == $due['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($due['title']); ?> (<?= '&#8358;' . number_format($due['amount'], 2); ?> base target)
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </optgroup>

                                <optgroup label="Standard One-Time Levies">
                                    <?php foreach ($data['all_dues'] as $due): ?>
                                        <?php if ($due['is_monthly'] == 0 && $due['is_donation'] == 0): ?>
                                            <option value="<?= $due['id']; ?>" <?= ($data['due_id'] == $due['id']) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($due['title']); ?> (<?= '&#8358;' . number_format($due['amount'], 2); ?>)
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                            <small class="text-muted fst-italic mt-1 d-block"><i class="bi bi-info-circle me-1"></i> Pick
                                the specific platform levy you are fulfilling.</small>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="form-label fw-bold small text-uppercase text-muted">Amount
                                Transferred <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white fw-bold border-0 shadow-sm"><span
                                        class="fw-bold fs-5 lh-1">&#8358;</span></span>
                                <input type="number" step="0.01" name="amount"
                                    class="form-control form-control-lg bg-light border-0 shadow-sm"
                                    value="<?= htmlspecialchars($data['amount']); ?>" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="row mb-4 g-3">
                            <div class="col-md-6">
                                <label for="payment_date" class="form-label fw-bold small text-uppercase text-muted">Date
                                    Generated <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date"
                                    class="form-control form-control-lg bg-light border-0 shadow-sm"
                                    value="<?= htmlspecialchars($data['payment_date']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="payment_method"
                                    class="form-label fw-bold small text-uppercase text-muted">Transfer Method <span
                                        class="text-danger">*</span></label>
                                <select name="payment_method"
                                    class="form-select form-select-lg bg-light border-0 shadow-sm">
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cash Deposit">Cash Deposit</option>
                                    <option value="Online Gateway">Online Gateway</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="reference_number" class="form-label fw-bold small text-uppercase text-muted">Receipt
                                / Reference ID</label>
                            <input type="text" name="reference_number"
                                class="form-control form-control-lg bg-light border-0 shadow-sm text-monospace"
                                value="<?= htmlspecialchars($data['reference_number']); ?>"
                                placeholder="e.g. TXN-94921-2026">
                            <small class="text-muted mt-2 d-block text-justify lh-sm"><i
                                    class="bi bi-shield-check text-success me-1"></i> Providing the exact reference ID
                                explicitly helps the Administration verify your ledger deposit significantly faster.</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                            <a href="/doncosa/public/payments"
                                class="btn btn-outline-secondary px-4 fw-bold shadow-sm rounded-pill"><i
                                    class="bi bi-x-circle me-1"></i> Cancel</a>
                            <button type="submit"
                                class="btn btn-success px-5 py-2 shadow-sm rounded-pill fw-bold text-uppercase"
                                style="letter-spacing: 1px;"><i class="bi bi-send-fill me-2"></i> Submit Log</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/layout/footer.php'; ?>