<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="text-primary mb-0"><i class="bi bi-megaphone-fill"></i> Broadcast Announcements</h2>
        <p class="text-muted">Draft and manage public platform announcements and SMS/WhatsApp blasts.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="/admin/announcementCreate" class="btn btn-primary shadow-sm"><i
                class="bi bi-plus-circle"></i> New Broadcast Announcement</a>
        <a href="/dashboard" class="btn btn-outline-secondary ms-2">Back to Dashboard</a>
    </div>
</div>

<div class="card shadow-sm border-0 border-top border-primary border-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary text-uppercase small">
                    <tr>
                        <th class="ps-4 py-3">Message Subject</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Written By</th>
                        <th class="py-3">Date Drafted</th>
                        <th class="pe-4 py-3 text-end">Administration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['announcements'])): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-info-circle fs-2 d-block mb-3 text-secondary opacity-50"></i>
                                No announcements have been generated yet. Click "New Broadcast Announcement" to start
                                drafting.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['announcements'] as $announcement): ?>
                            <tr>
                                <td class="ps-4">
                                    <h6 class="mb-1 text-dark fw-bold">
                                        <?= htmlspecialchars($announcement['title']); ?>
                                    </h6>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 350px;">
                                        <?= htmlspecialchars(substr($announcement['content'], 0, 75)); ?>...
                                    </small>
                                </td>
                                <td>
                                    <?php if ($announcement['status'] == 'Published'): ?>
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i
                                                class="bi bi-globe me-1"></i> Published</span>
                                    <?php else: ?>
                                        <span
                                            class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1"><i
                                                class="bi bi-file-earmark-text me-1"></i> Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted fw-semibold">
                                        <?= htmlspecialchars($announcement['author_name'] ?: 'Unknown User'); ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('M j, Y g:i A', strtotime($announcement['created_at'])); ?>
                                    </small>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="/admin/announcementEdit/<?= $announcement['id']; ?>"
                                        class="btn btn-sm btn-light border shadow-sm text-primary">Edit / Push</a>

                                    <form action="/admin/announcementDelete/<?= $announcement['id']; ?>"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('WARNING: Are you sure you want to delete this broadcast?');">
                                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1"><i
                                                class="bi bi-trash3"></i></button>
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