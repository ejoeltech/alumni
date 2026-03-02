<div class="row pt-4">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card bg-light border-0 pb-0">
            <div class="card-body py-1 d-flex justify-content-between">
                <a href="/doncosa/public/admin/projects" class="text-secondary text-decoration-none"><i
                        class="bi bi-arrow-left-short"></i> Back to Projects List</a>
                <span class="badge bg-secondary p-2 rounded-pill">ID: #
                    <?= $data['id']; ?>
                </span>
            </div>
        </div>

        <div class="card shadow-sm border-info border-top border-4 rounded-3 h-100 my-4 pb-4 px-4 py-3">
            <div class="card-header bg-white border-0 pb-0 pt-4">
                <h3 class="mb-0 text-info fw-bold">Edit Active Project</h3>
                <p class="text-muted small">Update budget lines, adjust managers, or change the status below.</p>
            </div>
            <div class="card-body">
                <form action="/doncosa/public/admin/projectEdit/<?= $data['id']; ?>" method="POST">

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Project Name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control form-control-lg border-info shadow-none <?= (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= $data['name']; ?>">
                        <div class="invalid-feedback">
                            <?= $data['name_err']; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold text-secondary">Detailed Description /
                            Objectives</label>
                        <textarea name="description" rows="4"
                            class="form-control hover-shadow"><?= $data['description']; ?></textarea>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <div class="col-md-6 pt-3 px-4 bg-light rounded border border-light shadow-sm text-center">
                            <label for="status" class="form-label fw-bold d-block text-secondary">Current Status
                                Configuration</label>

                            <!-- Custom Badged Select Dropdown via CSS & JS trick or just standard -->
                            <select name="status" class="form-select border-bottom border-3">
                                <option value="Pending" <?= ($data['status'] == 'Pending') ? 'selected' : ''; ?>
                                    >Tracking: Pending</option>
                                <option value="Running" <?= ($data['status'] == 'Running') ? 'selected' : ''; ?>
                                    >Tracking: Running / Active</option>
                                <option value="Past" <?= ($data['status'] == 'Past') ? 'selected' : ''; ?>>Tracking: Past
                                    / Completed</option>
                                <option value="Future" <?= ($data['status'] == 'Future') ? 'selected' : ''; ?>>Tracking:
                                    Scheduled Future</option>
                            </select>
                            <br>
                        </div>
                        <div class="col-md-6 pt-1">
                            <label for="budget" class="form-label fw-bold">Actual / Estimated Budget (₦)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">₦</span>
                                <input type="number" step="0.01" name="budget" class="form-control border-start-0 ps-0"
                                    value="<?= $data['budget']; ?>" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 border rounded border-info p-3 bg-white mb-4 shadow-sm position-relative">
                        <div class="position-absolute bg-white px-2 fw-bold text-info"
                            style="top:-14px; left:15px; width:auto;">Timeline Constraints</div>
                        <div class="col-md-4 mt-4">
                            <label for="start_date"
                                class="form-label small text-muted text-uppercase fw-bold">Commencement Date</label>
                            <input type="date" name="start_date" class="form-control"
                                value="<?= $data['start_date']; ?>">
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="completion_date"
                                class="form-label small text-muted text-uppercase fw-bold">Projected Delivery</label>
                            <input type="date" name="completion_date" class="form-control bg-light"
                                value="<?= $data['completion_date']; ?>">
                        </div>
                        <div class="col-md-4 mt-4">
                            <label for="project_lead"
                                class="form-label small text-muted text-uppercase fw-bold">Oversight Director</label>
                            <input type="text" name="project_lead" class="form-control text-primary fw-bold"
                                value="<?= $data['project_lead']; ?>">
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-info text-white btn-lg shadow rounded">Update Database
                            Logic Base <i class="bi bi-check-circle ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>