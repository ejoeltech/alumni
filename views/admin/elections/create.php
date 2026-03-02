<div class="row pt-4">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card shadow-sm border-success border-top border-4 rounded-3 h-100 my-4 pb-4 px-4 py-3">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-0 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-success fw-bold"><i class="bi bi-box2-heart-fill me-2"></i> Deploy Validated Election</h3>
                <a href="/admin/elections" class="btn btn-sm btn-outline-secondary px-3 rounded-pill"><i class="bi bi-x-circle me-1"></i> Cancel Process</a>
            </div>
            
            <div class="card-body px-0 pt-4">
                
                <div class="alert alert-secondary border shadow-sm mb-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-hdd-network-fill fs-4 text-secondary me-3"></i>
                    <div>
                        <span class="small font-monospace text-dark opacity-75">
                            You are defining an active voting ledger context. Once deployed and toggled Active, eligible users will dynamically attach to the embedded positions as candidates or voters.
                        </span>
                    </div>
                </div>

                <form action="/admin/electionCreate" method="POST">
                    
                    <div class="mb-4">
                        <label for="title" class="form-label d-block text-uppercase small fw-bold mb-2">Platform Election Designate <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg border-2 shadow-sm <?= (!empty($data['title_err'])) ? 'is-invalid border-danger' : ''; ?>" value="<?= htmlspecialchars($data['election_title']); ?>" placeholder="e.g. 2026 Executive Presidential Cycle" required autofocus>
                        <?php if (!empty($data['title_err'])): ?>
                            <div class="invalid-feedback fw-bold mt-2"><i class="bi bi-exclamation-triangle-fill"></i> <?= $data['title_err']; ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-4">
                        <label for="description" class="form-label d-block text-uppercase small fw-bold mb-2 text-muted">Legal Summary & Protocols</label>
                        <textarea name="description" id="description" class="form-control border-2 shadow-none" rows="3" placeholder="Provide background legal constraints or details regarding this election event..."><?= htmlspecialchars($data['description']); ?></textarea>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <div class="col-md-6 border-end">
                            <label for="start_date" class="form-label d-block text-uppercase small fw-bold mb-2 text-success">Live Launch Target <i class="bi bi-rocket me-1"></i></label>
                            <input type="datetime-local" name="start_date" class="form-control border-success border-2 <?= (!empty($data['date_err'])) ? 'is-invalid border-danger' : ''; ?>" value="<?= htmlspecialchars($data['start_date']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label d-block text-uppercase small fw-bold mb-2 text-danger">Absolute Termination Window <i class="bi bi-stop-circle me-1"></i></label>
                            <input type="datetime-local" name="end_date" class="form-control border-danger border-2 <?= (!empty($data['date_err'])) ? 'is-invalid border-danger' : ''; ?>" value="<?= htmlspecialchars($data['end_date']); ?>" required>
                        </div>
                        <?php if (!empty($data['date_err'])): ?>
                            <div class="text-danger small fw-bold mt-3 text-center"><i class="bi bi-exclamation-triangle-fill"></i> <?= $data['date_err']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Abstract Position Mapping Checkboxes -->
                    <div class="mb-4 p-4 border rounded bg-light border-2">
                        <label class="form-label d-block text-uppercase small fw-bold mb-3">Map Pre-Configured Positions</label>
                        <p class="small text-muted mb-4 pb-2 border-bottom">Select the officially constructed abstract roles that will be contestable inside *this* specific election ledger.</p>
                        
                        <?php if (empty($data['abstract_positions'])): ?>
                            <div class="text-danger small fw-bold fst-italic"><i class="bi bi-exclamation-octagon-fill me-1"></i> Critical Issue: You have not generated any Exco positions in the registry yet. Create positions first before mapping an election.</div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach($data['abstract_positions'] as $pos): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch form-check-lg" style="font-size: 1.1rem;">
                                            <input class="form-check-input border-secondary shadow-sm" type="checkbox" name="positions[]" value="<?= htmlspecialchars($pos['title']); ?>" id="pos_<?= $pos['id']; ?>">
                                            <label class="form-check-label ms-2 text-dark fw-bold" for="pos_<?= $pos['id']; ?>"><?= htmlspecialchars($pos['title']); ?></label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-check form-switch mt-5 mb-4 border p-3 rounded shadow-sm border-2 pt-3">
                        <input class="form-check-input ms-0 mt-1" type="checkbox" name="is_active" value="1" id="is_active" style="width: 2.5rem; height: 1.25rem;">
                        <label class="form-check-label fw-bold text-success ms-3" for="is_active">
                            Force Override Activation Pulse
                            <span class="d-block small text-muted fw-normal mt-1 mt-1 pb-1">Bypass start-date constraints and actively unlock logic immediately upon save.</span>
                        </label>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn bg-success text-white btn-lg shadow rounded border-0 fw-bold py-3 text-uppercase tracking-wider">
                            Commise Election Protocol <i class="bi bi-check2-circle fs-5 ms-2 align-middle"></i>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
