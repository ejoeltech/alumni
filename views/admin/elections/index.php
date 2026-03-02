<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="text-success mb-0">Platform Elections Manager</h2>
        <p class="text-muted">Deploy secure elections, map formal positions, and manage live democratic states.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="/doncosa/public/admin/electionCreate" class="btn btn-success"><i
                class="bi bi-box2-heart-fill me-1"></i> Deploy New Election</a>
        <a href="/doncosa/public/dashboard" class="btn btn-outline-secondary ms-2">Back to Dashboard</a>
    </div>
</div>

<div class="card shadow-sm border-0 border-top border-success border-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Election Identity</th>
                        <th class="py-3">Live Status</th>
                        <th class="py-3">Launch Window</th>
                        <th class="py-3">Termination Window</th>
                        <th class="pe-4 py-3 text-end">Destructive Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['elections'])): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No elections exist on the ledger. Create one
                                to begin.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['elections'] as $elec): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-dark">
                                    <h6 class="mb-0 fw-bold">
                                        <?= htmlspecialchars($elec['title']); ?>
                                    </h6>
                                    <span class="small text-muted fw-normal">
                                        <?= substr(htmlspecialchars($elec['description']), 0, 50); ?>...
                                    </span>
                                </td>
                                <td>
                                    <?php if ($elec['is_active']): ?>
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i
                                                class="bi bi-broadcast me-1"></i> ACTIVE / OPEN</span>
                                    <?php else: ?>
                                        <span
                                            class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1"><i
                                                class="bi bi-lock-fill me-1"></i> LOCKED</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted fw-bold">
                                        <?= date('M j, Y h:i A', strtotime($elec['start_date'])); ?>
                                    </small>
                                </td>
                                <td>
                                    <small class="text-muted fw-bold text-danger">
                                        <?= date('M j, Y h:i A', strtotime($elec['end_date'])); ?>
                                    </small>
                                </td>
                                <td class="pe-4 text-end">
                                    <form action="/doncosa/public/admin/electionDelete/<?= $elec['id']; ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('CRITICAL WARNING: Terminating this Election block will cascade delete ALL registered votes, candidates, and mappings connected to it permanently. PROCEED?');">
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i>
                                            Vaporize Block</button>
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