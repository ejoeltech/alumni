<div class="row pt-4">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card shadow-sm border-primary border-top border-4 rounded-3 h-100 my-4 pb-4 px-4 py-3">
            <div class="card-header bg-white border-0 pb-0 pt-4 px-0 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-primary fw-bold"><i class="bi bi-file-earmark-plus-fill me-2"></i> Construct Role Abstract</h3>
                <a href="/doncosa/public/admin/positions" class="btn btn-sm btn-outline-secondary px-3 rounded-pill"><i class="bi bi-x-circle me-1"></i> Cancel Process</a>
            </div>
            
            <div class="card-body px-0 pt-4">
                
                <div class="alert alert-info border border-info shadow-sm mb-4 d-flex align-items-center" role="alert">
                    <i class="bi bi-info-circle-fill fs-4 text-info me-3"></i>
                    <div>
                        <span class="small font-monospace text-dark opacity-75">
                            You are defining an abstract executive role here (e.g. <b>Global Secretary</b>). 
                            You will later attach this node into multiple live Elections spanning different years.
                        </span>
                    </div>
                </div>

                <form action="/doncosa/public/admin/positionCreate" method="POST">
                    
                    <div class="mb-4">
                        <label for="title" class="form-label d-block text-uppercase small fw-bold mb-2">Formal Role Designation <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg border-2 shadow-sm <?= (!empty($data['title_err'])) ? 'is-invalid border-danger' : ''; ?>" value="<?= htmlspecialchars($data['position_title']); ?>" placeholder="e.g. President, Treasurer..." required autofocus autocomplete="off">
                        <?php if (!empty($data['title_err'])): ?>
                            <div class="invalid-feedback fw-bold mt-2"><i class="bi bi-exclamation-triangle-fill"></i> <?= $data['title_err']; ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-5">
                        <label for="description" class="form-label d-block text-uppercase small fw-bold mb-2 text-muted">Core Responsibilities / Manifest (Optional)</label>
                        <textarea name="description" id="description" class="form-control border-2 shadow-none" rows="4" placeholder="Detail the legal responsibilities bound to this office parameter..."><?= htmlspecialchars($data['description']); ?></textarea>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary text-white btn-lg shadow rounded border-0 fw-bold py-3 text-uppercase tracking-wider">
                            Commise Node Registration <i class="bi bi-check2-circle fs-5 ms-2 align-middle"></i>
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
