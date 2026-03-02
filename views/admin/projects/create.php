<div class="row pt-4">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card shadow-sm border-primary border-top border-4 rounded-3 h-100 mb-5 pb-4 px-4 py-3">
            <div class="card-header bg-white border-0 pb-0 pt-4">
                <h3 class="mb-0 text-primary fw-bold">Create New Project</h3>
                <p class="text-muted small">Fill in the details below to initialize a new alumni project.</p>
            </div>
            <div class="card-body">
                <form action="/admin/projectCreate" method="POST">

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Project Name <span
                                class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control form-control-lg <?= (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= $data['name']; ?>" placeholder="e.g., School Library Renovation">
                        <div class="invalid-feedback">
                            <?= $data['name_err']; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Detailed Description / Objectives</label>
                        <textarea name="description" rows="4" class="form-control hover-shadow"
                            placeholder="What is the goal of this project?"><?= $data['description']; ?></textarea>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-bold">Current Status</label>
                            <select name="status" class="form-select bg-light">
                                <option value="Pending" <?= ($data['status'] == 'Pending') ? 'selected' : ''; ?>>Pending
                                    (Reviewing/Funding)</option>
                                <option value="Running" <?= ($data['status'] == 'Running') ? 'selected' : ''; ?>>Running
                                    (Active Construction)</option>
                                <option value="Past" <?= ($data['status'] == 'Past') ? 'selected' : ''; ?>>Past
                                    (Completed)</option>
                                <option value="Future" <?= ($data['status'] == 'Future') ? 'selected' : ''; ?>>Future
                                    (Planned Outline)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="budget" class="form-label fw-bold">Estimated Budget (₦)</label>
                            <input type="number" step="0.01" name="budget" class="form-control"
                                value="<?= $data['budget']; ?>" placeholder="e.g. 1500000.00">
                            <small class="text-muted fst-italic">Leave blank if unknown.</small>
                        </div>
                    </div>

                    <div class="row g-4 border rounded p-3 bg-light mb-4">
                        <div class="col-12 mt-0 mb-n2">
                            <h6 class="text-secondary fw-bold">Timeline & Management</h6>
                            <hr>
                        </div>
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control"
                                value="<?= $data['start_date']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="completion_date" class="form-label">Estimated Completion</label>
                            <input type="date" name="completion_date" class="form-control"
                                value="<?= $data['completion_date']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="project_lead" class="form-label">Project Lead / Manager</label>
                            <input type="text" name="project_lead" class="form-control"
                                value="<?= $data['project_lead']; ?>" placeholder="Name of overseer">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="/admin/projects"
                            class="text-secondary text-decoration-none px-3 py-2 btn btn-link">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-lg shadow px-5 rounded-pill">Create Project <i
                                class="bi bi-arrow-right-short"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>