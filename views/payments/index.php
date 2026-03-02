<?php require_once '../views/layout/header.php'; ?>

<div class="row align-items-center mb-5">
    <div class="col-md-8">
        <h1 class="display-6 fw-bold text-dark mb-1"><i class="bi bi-piggy-bank-fill text-success me-2"></i> Financial
            Dues Status</h1>
        <p class="text-muted fs-5">Track your active platform levies and past payment verifications.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="/doncosa/public/payments/submit" class="btn btn-success shadow-sm fw-bold px-4 py-2 mt-3 mt-md-0"><i
                class="bi bi-cloud-arrow-up-fill me-1"></i> Submit Payment Log</a>
    </div>
</div>

<div class="row g-4 mb-5">

    <!-- Active Dues Target Column -->
    <div class="col-lg-5">
        <h4 class="mb-3 fw-bold"><i class="bi bi-card-checklist text-primary me-2"></i> Current Required Dues</h4>

        <?php if (empty($data['dues'])): ?>
            <div class="alert bg-white border border-secondary shadow-sm text-center py-5 rounded-4">
                <i class="bi bi-emoji-sunglasses display-4 text-muted opacity-25 d-block mb-3"></i>
                <h5 class="fw-bold text-dark">You're All Clear!</h5>
                <p class="text-muted small mb-0">The platform currently has no active dues deployed for collection.</p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($data['dues'] as $due): ?>
                    <?php
                    $border_class = 'border-success';
                    $icon_badge = '';
                    if ($due['is_monthly'] == 1) {
                        $border_class = 'border-primary';
                        $icon_badge = '<span class="badge bg-primary mb-2 shadow-sm rounded-pill"><i class="bi bi-calendar-range me-1"></i> Monthly Due</span>';
                    } elseif ($due['is_donation'] == 1) {
                        $border_class = 'border-warning';
                        $icon_badge = '<span class="badge bg-warning text-dark mb-2 shadow-sm rounded-pill"><i class="bi bi-gift-fill me-1"></i> Welfare Request</span>';
                    }
                    ?>
                    <div class="card shadow-sm border-0 border-start border-4 <?= $border_class ?> rounded-3 hover-lift">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <?= $icon_badge ?>
                                <h6 class="fw-bold text-dark mb-1"><?= htmlspecialchars($due['title']); ?></h6>
                                <p class="text-muted small mb-0 d-inline-block text-truncate" style="max-width: 200px;">
                                    <?= htmlspecialchars($due['description']); ?>
                                </p>

                                <?php if ($due['due_date']): ?>
                                    <small class="text-danger fw-bold mt-2 d-block"><i class="bi bi-stopclock me-1"></i> Due:
                                        <?= date('M j, Y', strtotime($due['due_date'])); ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="text-end ps-3">
                                <h4 class="fw-bold text-success mb-1">&#8358;<?= number_format($due['amount'], 2); ?></h4>
                                <a href="/doncosa/public/payments/submit/<?= $due['id']; ?>"
                                    class="btn btn-sm btn-outline-success rounded-pill fw-bold shadow-sm px-3 mt-2">Log
                                    Receipt</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Payment History / Ledger Column -->
    <div class="col-lg-7">
        <h4 class="mb-3 fw-bold"><i class="bi bi-journal-check text-success me-2"></i> My Personal Ledger</h4>

        <div class="card border-0 shadow-sm bg-white rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="list-group list-group-flush border-0">
                    <?php if (empty($data['my_payments'])): ?>
                        <div class="text-center py-5 px-3">
                            <i class="bi bi-receipt display-4 text-muted opacity-25 d-block mb-3"></i>
                            <h5 class="fw-bold text-secondary">No Payment History</h5>
                            <p class="text-muted small">You have not submitted any physical transfer logs into the platform
                                yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($data['my_payments'] as $payment): ?>
                            <div
                                class="list-group-item bg-transparent border-bottom px-4 py-3 d-flex justify-content-between align-items-center hover-light">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle shadow-sm flex-shrink-0 d-flex justify-content-center align-items-center text-white
                                        <?= ($payment['status'] === 'Verified') ? 'bg-success' : (($payment['status'] === 'Rejected') ? 'bg-danger' : 'bg-warning'); ?>
                                    " style="width: 45px; height: 45px;">
                                        <i
                                            class="bi <?= ($payment['status'] === 'Verified') ? 'bi-check-lg' : (($payment['status'] === 'Rejected') ? 'bi-x-lg' : 'bi-hourglass-split'); ?> fs-4"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bold text-dark">
                                            <?= htmlspecialchars($payment['due_title']) ?: '<span class="fst-italic text-secondary">General Fund Deposit</span>'; ?>
                                        </h6>
                                        <div class="text-muted small">
                                            <i class="bi bi-credit-card-2-front text-primary me-1"></i>
                                            <?= htmlspecialchars($payment['payment_method']); ?>
                                            <span class="mx-1">•</span>
                                            Ref: <span
                                                class="font-monospace fw-bold"><?= htmlspecialchars($payment['reference_number']) ?: 'N/A'; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <h5
                                        class="mb-0 fw-bold <?= ($payment['status'] === 'Verified') ? 'text-success' : 'text-dark'; ?>">
                                        &#8358;<?= number_format($payment['amount'], 2); ?></h5>
                                    <small
                                        class="text-muted d-block"><?= date('M j, Y', strtotime($payment['payment_date'])); ?></small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($data['my_payments'])): ?>
                <div class="card-footer bg-light border-top-0 py-3 text-center">
                    <small class="text-muted fw-bold"><i class="bi bi-shield-lock-fill me-1 text-success"></i> All financial
                        logs undergo strict Admin verification.</small>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../views/layout/footer.php'; ?>