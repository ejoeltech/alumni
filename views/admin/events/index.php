<div class="row">
    <div class="col-md-10 mx-auto">
        <h2 class="mb-4">Manage Events</h2>

        <div class="d-flex justify-content-between mb-3">
            <a href="/admin/eventCreate" class="btn btn-primary">Add New Event</a>
            <a href="/dashboard" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data['events'])): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted fst-italic">No events found. Start by
                                    adding one!</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($data['events'] as $event): ?>
                                <tr class="align-middle">
                                    <td><strong>
                                            <?= $event['title']; ?>
                                        </strong></td>
                                    <td>
                                        <?= date('M j, Y h:i A', strtotime($event['event_date'])); ?>
                                    </td>
                                    <td>
                                        <?= $event['location']; ?>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-<?= ($event['status'] == 'Upcoming') ? 'success' : 'secondary'; ?>">
                                            <?= $event['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/admin/eventEdit/<?= $event['id']; ?>"
                                            class="btn btn-sm btn-info text-white">Edit</a>
                                        <form action="/admin/eventDelete/<?= $event['id']; ?>" method="POST"
                                            class="d-inline">
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('WARNING!\nAre you sure you want to delete this event? This action cannot be undone.');">Delete</button>
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
</div>