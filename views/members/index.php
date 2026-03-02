<?php require_once '../views/layout/header.php'; ?>

<div class="container my-5 pb-5">

    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="display-6 fw-bold text-primary mb-1"><i class="bi bi-people-fill me-2"></i>Global Directory</h1>
            <p class="text-muted fs-5">Search, filter, and connect with other distinguished Alumni.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <!-- Export Form Button -->
            <form action="/doncosa/public/members/export" method="GET" class="d-inline">
                <input type="hidden" name="search" value="<?= htmlspecialchars($data['filters']['search']); ?>">
                <input type="hidden" name="graduation_year"
                    value="<?= htmlspecialchars($data['filters']['graduation_year']); ?>">
                <input type="hidden" name="class_set" value="<?= htmlspecialchars($data['filters']['class_set']); ?>">
                <input type="hidden" name="sort_by" value="<?= htmlspecialchars($data['sort_by']); ?>">
                <input type="hidden" name="sort_dir" value="<?= htmlspecialchars($data['sort_dir']); ?>">
                <button type="submit" class="btn btn-outline-success shadow-sm rounded-pill px-4 fw-bold">
                    <i class="bi bi-file-earmark-spreadsheet-fill me-1"></i> Export Data (CSV)
                </button>
            </form>
        </div>
    </div>

    <!-- Live Filters Architecture -->
    <div class="card shadow-sm border-0 mb-4 bg-light rounded-4 border border-2 border-primary border-opacity-25">
        <div class="card-body p-4">
            <form action="/doncosa/public/members" method="GET" class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Intelligent Global Search</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-primary"><i
                                class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                            placeholder="Name, Email, Phone..."
                            value="<?= htmlspecialchars($data['filters']['search']); ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-bold text-uppercase text-muted">Graduation Year</label>
                    <select name="graduation_year" class="form-select text-dark shadow-none border">
                        <option value="">Any Year</option>
                        <?php foreach ($data['distinct_years'] as $yr): ?>
                            <option value="<?= htmlspecialchars($yr); ?>" <?= ($data['filters']['graduation_year'] == $yr) ? 'selected' : ''; ?>><?= htmlspecialchars($yr); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">Class Set</label>
                    <select name="class_set" class="form-select text-dark shadow-none border">
                        <option value="">Any Set</option>
                        <?php foreach ($data['distinct_sets'] as $set): ?>
                            <option value="<?= htmlspecialchars($set); ?>" <?= ($data['filters']['class_set'] == $set) ? 'selected' : ''; ?>><?= htmlspecialchars($set); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">Order Filter By</label>
                    <div class="input-group">
                        <select name="sort_by" class="form-select shadow-none border-end-0 border">
                            <option value="full_name" <?= ($data['sort_by'] == 'full_name') ? 'selected' : ''; ?>>Name
                            </option>
                            <option value="graduation_year" <?= ($data['sort_by'] == 'graduation_year') ? 'selected' : ''; ?>>Grad Year</option>
                            <option value="class_set" <?= ($data['sort_by'] == 'class_set') ? 'selected' : ''; ?>>Class Set
                            </option>
                            <option value="created_at" <?= ($data['sort_by'] == 'created_at') ? 'selected' : ''; ?>>Join
                                Date</option>
                        </select>
                        <select name="sort_dir" class="form-select shadow-none border" style="max-width: 80px;">
                            <option value="ASC" <?= ($data['sort_dir'] == 'ASC') ? 'selected' : ''; ?>>▲</option>
                            <option value="DESC" <?= ($data['sort_dir'] == 'DESC') ? 'selected' : ''; ?>>▼</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm fw-bold"><i
                            class="bi bi-funnel-fill me-1"></i> Apply Engine</button>
                    <!-- Small reset helper -->
                    <?php if (!empty($_GET)): ?>
                        <div class="text-center mt-2">
                            <a href="/doncosa/public/members" class="text-decoration-none small text-danger"><i
                                    class="bi bi-x-circle me-1"></i>Clear Filters</a>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Results Rendering -->
    <div class="row g-4">
        <?php if (empty($data['members'])): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-search display-1 text-muted opacity-25 mb-4"></i>
                <h3 class="fw-bold text-secondary">No matching alumni found.</h3>
                <p class="text-muted">Adjust your filter parameters and scan the directory again.</p>
            </div>
        <?php else: ?>
            <?php foreach ($data['members'] as $user): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative hover-lift">

                        <!-- Top Header Frame -->
                        <div class="bg-primary text-white p-3 d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-white d-flex align-items-center justify-content-center border border-2 border-white shadow-sm"
                                style="width: 55px; height: 55px; overflow: hidden; flex-shrink: 0;">
                                <?php if (!empty($user['profile_picture'])): ?>
                                    <img src="/doncosa/public/<?= htmlspecialchars($user['profile_picture']); ?>"
                                        class="w-100 h-100" style="object-fit: cover;">
                                <?php else: ?>
                                    <span
                                        class="fs-4 text-primary fw-bold"><?= strtoupper(substr($user['full_name'], 0, 1)); ?></span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold lh-sm text-truncate" style="max-width: 200px;">
                                    <?= htmlspecialchars($user['full_name']); ?></h5>
                                <?php if (!empty($user['membership_position'])): ?>
                                    <span class="badge bg-warning text-dark mt-1 shadow-sm opacity-100"><i
                                            class="bi bi-award-fill"></i>
                                        <?= htmlspecialchars($user['membership_position']); ?></span>
                                <?php else: ?>
                                    <small class="text-white-50"><i class="bi bi-mortarboard-fill me-1"></i> Class of
                                        <?= htmlspecialchars($user['graduation_year'] ?: 'Unknown'); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Inner Contact Frame -->
                        <div class="card-body p-4 bg-white">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2 text-truncate" title="<?= htmlspecialchars($user['email']); ?>">
                                    <i class="bi bi-envelope-fill text-primary me-2 opacity-75"></i> <a
                                        href="mailto:<?= htmlspecialchars($user['email']); ?>"
                                        class="text-decoration-none text-dark"><?= htmlspecialchars($user['email']); ?></a>
                                </li>
                                <?php if (!empty($user['phone_number'])): ?>
                                    <li class="mb-2">
                                        <i class="bi bi-telephone-fill text-success me-2 opacity-75"></i> <a
                                            href="tel:<?= htmlspecialchars($user['phone_number']); ?>"
                                            class="text-decoration-none text-dark"><?= htmlspecialchars($user['phone_number']); ?></a>
                                    </li>
                                <?php endif; ?>
                                <?php if (!empty($user['class_set'])): ?>
                                    <li class="mb-0">
                                        <i class="bi bi-people-fill text-secondary me-2 opacity-75"></i> <span
                                            class="text-dark fw-bold">Set:</span> <?= htmlspecialchars($user['class_set']); ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

<?php require_once '../views/layout/footer.php'; ?>