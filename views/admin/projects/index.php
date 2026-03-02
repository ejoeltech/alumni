<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="text-primary mb-0">Project Management</h2>
        <p class="text-muted">Manage all active, pending, and past alumni projects.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="/admin/projectCreate" class="btn btn-primary shadow-sm"><i
                class="bi bi-plus-circle"></i> Create New Project</a>
        <a href="/dashboard" class="btn btn-outline-secondary ms-2">Back to Dashboard</a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Project Name</th>
                        <th>Status</th>
                        <th>Budget</th>
                        <th>Dates</th>
                        <th>Lead</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['projects'])): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No projects found. Click "Create New
                                Project" to add one.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['projects'] as $project): ?>
                            <tr>
                                <td class="ps-4">
                                    <h6 class="mb-0 text-dark">
                                        <?= $project['name']; ?>
                                    </h6>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">
                                        <?= substr($project['description'], 0, 50); ?>...
                                    </small>
                                </td>
                                <td>
                                    <?php
                                    $badgeClass = 'bg-secondary';
                                    if ($project['status'] == 'Running')
                                        $badgeClass = 'bg-success';
                                    if ($project['status'] == 'Pending')
                                        $badgeClass = 'bg-warning text-dark';
                                    if ($project['status'] == 'Future')
                                        $badgeClass = 'bg-info text-dark';
                                    ?>
                                    <span class="badge <?= $badgeClass; ?>">
                                        <?= $project['status']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?= (!empty($project['budget'])) ? '₦' . number_format($project['budget']) : '<span class="text-muted">N/A</span>'; ?>
                                </td>
                                <td>
                                    <small class="d-block"><strong>Start:</strong>
                                        <?= (!empty($project['start_date'])) ? date('M j, Y', strtotime($project['start_date'])) : 'TBD'; ?>
                                    </small>
                                    <small class="d-block"><strong>End:</strong>
                                        <?= (!empty($project['completion_date'])) ? date('M j, Y', strtotime($project['completion_date'])) : 'TBD'; ?>
                                    </small>
                                </td>
                                <td>
                                    <?= (!empty($project['project_lead'])) ? $project['project_lead'] : '<span class="text-muted fst-italic">None Assigned</span>'; ?>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="/admin/projectEdit/<?= $project['id']; ?>"
                                        class="btn btn-sm btn-outline-info">Edit</a>

                                    <!-- Delete Form -->
                                    <form action="/admin/projectDelete/<?= $project['id']; ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.');">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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