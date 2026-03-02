<?php require_once '../views/layout/header.php'; ?>

<div class="row mb-4 align-items-center">
    <div class="col-md-8">
        <h2 class="fw-bold text-dark"><i class="bi bi-wallet2 me-2"></i> Manage Dues & Levies</h2>
        <p class="text-muted">Create and manage financial obligations for platform members.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="/doncosa/public/admin/payments" class="btn btn-outline-primary mb-2 mb-md-0 shadow-sm fw-bold"><i
                class="bi bi-cash-stack me-1"></i> View Payments</a>
        <a href="/doncosa/public/admin/dueCreate" class="btn btn-success shadow-sm fw-bold"><i
                class="bi bi-plus-circle-fill me-1"></i> Add New Levy</a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4">TITLE & DESCRIPTION</th>
                        <th class="py-3">AMOUNT</th>
                        <th class="py-3">DUE DATE</th>
                        <th class="py-3">CREATED</th>
                        <th class="py-3 text-end px-4">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($data['dues'])): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted fst-italic">
                                <i class="bi bi-inbox display-4 d-block mb-3 opacity-25"></i>
                                No dues or levies have been created yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['dues'] as $due): ?>
                            <tr>
                                <td class="py-3 px-4">
                                    <?php if ($due['is_monthly'] == 1): ?>
                                        <span class="badge bg-primary mb-1 shadow-sm"><i class="bi bi-calendar-range me-1"></i>
                                            Monthly Due</span>
                                    <?php elseif ($due['is_donation'] == 1): ?>
                                        <span class="badge bg-warning text-dark mb-1 shadow-sm"><i class="bi bi-gift-fill me-1"></i>
                                            Welfare Request</span>
                                    <?php endif; ?>
                                    <h6 class="mb-1 fw-bold text-dark">
                                        <?= htmlspecialchars($due['title']); ?>
                                    </h6>
                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                        <?= htmlspecialchars($due['description']) ?: 'No description provided.'; ?>
                                    </small>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 fs-6">
                                        <?= '&#8358;' . number_format($due['amount'], 2); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($due['due_date']): ?>
                                        <span class="text-dark fw-bold">
                                            <?= date('M j, Y', strtotime($due['due_date'])); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic">No Deadline</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted small">
                                    <?= date('M j, Y', strtotime($due['created_at'])); ?>
                                </td>
                                <td class="text-end px-4">
                                    <a href="/doncosa/public/admin/dueDelete/<?= $due['id']; ?>"
                                        class="btn btn-sm btn-outline-danger shadow-sm"
                                        onclick="return confirm('Are you sure? This will not delete past payments tied to it but will remove the requirement.')">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
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