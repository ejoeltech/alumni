<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="text-primary mb-0">Exco Positions Hierarchy</h2>
        <p class="text-muted">Generate abstract available positions that can be mapped to active elections later.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="/admin/positionCreate" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>
            Register New Position Map</a>
        <a href="/dashboard" class="btn btn-outline-secondary ms-2">Back to Dashboard</a>
    </div>
</div>

<div class="card shadow-sm border-0 border-top border-primary border-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Formal Title Constraint</th>
                        <th class="py-3">Role Descriptor</th>
                        <th class="py-3">Timestamp Created</th>
                        <th class="pe-4 py-3 text-end">Destructive Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['positions'])): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No abstract positions structured yet.
                                Register one to get started.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['positions'] as $pos): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-dark">
                                    <i class="bi bi-award-fill text-warning me-2"></i>
                                    <?= htmlspecialchars($pos['title']); ?>
                                </td>
                                <td class="fs-6 text-muted">
                                    <?= htmlspecialchars($pos['description']) ?: '<span class="fst-italic opacity-50">No Role Details</span>'; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M j, Y h:i A', strtotime($pos['created_at'])); ?>
                                    </small>
                                </td>
                                <td class="pe-4 text-end">
                                    <form action="/admin/positionDelete/<?= $pos['id']; ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('CRITICAL WARNING: Wiping an abstract position map will cascade delete ALL registered votes, candidates, and live mappings connected to it inside active elections. PROCEED?');">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i>
                                            Vaporize Node</button>
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