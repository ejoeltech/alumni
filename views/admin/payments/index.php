<?php require_once '../views/layout/header.php'; ?>

<div class="row mb-5 align-items-center">
    <div class="col-md-7">
        <h2 class="fw-bold text-dark mb-1"><i class="bi bi-bank2 text-success me-2"></i> Accounting Engine</h2>
        <p class="text-muted">Review, verify, and reject physical member payments transferred to the platform.</p>
    </div>

    <div class="col-md-5 mt-4 mt-md-0">
        <div class="card border-0 shadow-sm bg-success text-white rounded-pill p-2 overflow-hidden position-relative">
            <i class="bi bi-cash-stack position-absolute text-white opacity-25"
                style="font-size: 4rem; right: 10px; top: -10px;"></i>
            <div class="d-flex justify-content-between align-items-center px-4 position-relative z-1">
                <span class="text-uppercase fw-bold small opacity-75">Total Verified Revenue</span>
                <span class="fs-4 fw-bold mb-0">
                    <span class="text-white-50 fw-bold me-1">&#8358;</span>
                    <?= number_format($data['total_verified'], 2); ?>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white mb-5">
    <div class="card-header bg-transparent border-bottom-0 pt-4 px-4 pb-2 d-flex justify-content-between">
        <h5 class="fw-bold text-dark mb-0">Global Audit Ledger</h5>
        <a href="/doncosa/public/admin/dues" class="btn btn-sm btn-outline-dark fw-bold rounded-pill"><i
                class="bi bi-wallet2 me-1"></i> Manage Base Levies</a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="py-3 px-4">PAYEE NAME</th>
                        <th class="py-3">PAYMENT MAP (LEVY)</th>
                        <th class="py-3">VALUE</th>
                        <th class="py-3">METHOD (REF)</th>
                        <th class="py-3">DATE LOGGED</th>
                        <th class="py-3">FRAUD STATUS</th>
                        <th class="py-3 text-end px-4">AUDIT ACTION</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($data['payments'])): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted fst-italic">
                                <i class="bi bi-hourglass-bottom display-4 d-block mb-3 opacity-25"></i>
                                No payments have entered the node yet line.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['payments'] as $payment): ?>
                            <tr>
                                <td class="py-3 px-4">
                                    <h6 class="mb-0 fw-bold text-dark text-truncate" style="max-width: 150px;"
                                        title="<?= htmlspecialchars($payment['full_name']); ?>">
                                        <?= htmlspecialchars($payment['full_name']); ?>
                                    </h6>
                                    <small class="text-muted"><i class="bi bi-envelope-fill me-1"></i>
                                        <?= htmlspecialchars($payment['email']); ?>
                                    </small>
                                </td>

                                <td class="text-truncate" style="max-width: 150px;">
                                    <?php if ($payment['due_title']): ?>
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 shadow-sm fw-bold">
                                            <?= htmlspecialchars($payment['due_title']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">General Pool</span>
                                    <?php endif; ?>
                                </td>

                                <td class="fw-bold text-success fs-6">
                                    &#8358;
                                    <?= number_format($payment['amount'], 2); ?>
                                </td>

                                <td class="text-muted small">
                                    <i class="bi bi-credit-card-2-front-fill me-1"></i> <b>
                                        <?= htmlspecialchars($payment['payment_method']); ?>
                                    </b><br>
                                    <span class="font-monospace" style="font-size: 0.70rem;">
                                        <?= htmlspecialchars($payment['reference_number']) ?: 'No Ref'; ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="d-block text-dark fw-bold">
                                        <?= date('M j, Y', strtotime($payment['payment_date'])); ?>
                                    </span>
                                    <small class="text-muted" style="font-size: 0.65rem;">Logged:
                                        <?= date('M j Y H:i', strtotime($payment['created_at'])); ?>
                                    </small>
                                </td>

                                <td>
                                    <?php if ($payment['status'] === 'Verified'): ?>
                                        <span
                                            class="badge bg-success bg-opacity-25 text-success rounded-pill fw-bold border border-success px-3 shadow-sm py-2"><i
                                                class="bi bi-check-circle-fill me-1"></i> CLEAR</span>
                                    <?php elseif ($payment['status'] === 'Rejected'): ?>
                                        <span
                                            class="badge bg-danger bg-opacity-25 text-danger rounded-pill fw-bold border border-danger px-3 shadow-sm py-2"><i
                                                class="bi bi-x-octagon-fill me-1"></i> DENIED</span>
                                    <?php else: ?>
                                        <span
                                            class="badge bg-warning bg-opacity-25 text-dark rounded-pill fw-bold border border-warning px-3 shadow-sm py-2"><i
                                                class="bi bi-clock-history me-1"></i> PENDING</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-end px-4">
                                    <?php if ($payment['status'] === 'Pending'): ?>
                                        <div class="btn-group shadow-sm">
                                            <a href="/doncosa/public/admin/paymentVerify/<?= $payment['id']; ?>?status=Verified"
                                                class="btn btn-sm btn-success fw-bold px-3"><i class="bi bi-check-lg"></i></a>
                                            <a href="/doncosa/public/admin/paymentVerify/<?= $payment['id']; ?>?status=Rejected"
                                                class="btn btn-sm btn-danger fw-bold px-3"><i class="bi bi-x-lg"></i></a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic small">Audited.</span>
                                        <!-- Allow override back to pending if needed -->
                                        <a href="/doncosa/public/admin/paymentVerify/<?= $payment['id']; ?>?status=Pending"
                                            class="d-inline-block ms-2 text-warning" title="Reset to Pending"><i
                                                class="bi bi-arrow-counterclockwise"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../views/layout/footer.php'; ?>