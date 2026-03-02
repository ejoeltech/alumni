<div class="row w-100 mb-5">
    <div class="col-md-10 mx-auto text-center">
        <h1 class="display-5 text-primary">Our Projects</h1>
        <p class="lead text-muted">Track our college support initiatives and milestones.</p>
    </div>
</div>

<div class="row w-100">
    <div class="col-md-10 mx-auto">
        <!-- Navigation Tabs grouping by Status -->
        <ul class="nav nav-pills nav-fill bg-white shadow-sm border rounded-pill p-2 mb-5 mx-0 mx-md-4" id="projectTabs"
            role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill fw-bold" id="running-tab" data-bs-toggle="tab"
                    data-bs-target="#running" type="button" role="tab" aria-controls="running" aria-selected="true"><i
                        class="bi bi-play-circle-fill me-1"></i> Running</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill text-secondary fw-bold" id="pending-tab" data-bs-toggle="tab"
                    data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false"><i
                        class="bi bi-hourglass-split me-1"></i> Pending</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill text-secondary fw-bold" id="future-tab" data-bs-toggle="tab"
                    data-bs-target="#future" type="button" role="tab" aria-controls="future" aria-selected="false"><i
                        class="bi bi-lightbulb-fill me-1 text-warning"></i> Ideas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill text-secondary fw-bold" id="past-tab" data-bs-toggle="tab"
                    data-bs-target="#past" type="button" role="tab" aria-controls="past" aria-selected="false"><i
                        class="bi bi-check-circle-fill me-1 text-success"></i> Completed</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="projectTabsContent">

            <!-- Generate each tab dynamically based on the PHP categorized array keys -->
            <?php
            $tab_status = ['Running' => 'active show', 'Pending' => '', 'Future' => '', 'Past' => ''];
            foreach ($tab_status as $status => $activeClass): ?>

                <div class="tab-pane fade <?= $activeClass; ?>" id="<?= strtolower($status); ?>" role="tabpanel"
                    aria-labelledby="<?= strtolower($status); ?>-tab">

                    <div class="row">
                        <?php if (empty($data['projects'][$status])): ?>
                            <div class="col-12 py-4">
                                <p class="text-muted fst-italic">No projects currently listed under "
                                    <?= $status; ?>".
                                </p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($data['projects'][$status] as $project): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm border-0 bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title text-dark">
                                                <?= $project['name']; ?>
                                            </h5>
                                            <span
                                                class="badge bg-<?= ($status == 'Running') ? 'primary' : (($status == 'Past') ? 'secondary' : 'info'); ?> mb-2">
                                                <?= $status; ?>
                                            </span>
                                            <p class="card-text text-muted mt-2">
                                                <small>
                                                    <?= substr($project['description'], 0, 150); ?>...
                                                </small>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <small class="text-muted"><strong>Lead:</strong>
                                                <?= $project['project_lead'] ?: 'TBA'; ?>
                                            </small>
                                            <br>
                                            <small class="text-muted"><strong>Budget:</strong>
                                                <?= $project['budget'] ? '$' . number_format($project['budget'], 2) : 'N/A'; ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div> <!-- End Tab Content -->
    </div>
</div>