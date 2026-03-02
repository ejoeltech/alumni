<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm mt-4 border-info border-top border-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-info">Edit Event</h4>
                <small class="text-muted">ID: #
                    <?= $data['id']; ?>
                </small>
            </div>
            <div class="card-body">
                <form action="/admin/eventEdit/<?= $data['id']; ?>" method="POST"
                    enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="title" class="form-label">Event Title <sup>*</sup></label>
                        <input type="text" name="title"
                            class="form-control form-control-lg <?= (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= $data['event_title']; ?>">
                        <div class="invalid-feedback">
                            <?= $data['title_err']; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Event Flier / Image (Leave blank to keep existing)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_date" class="form-label">Event Date & Time <sup>*</sup></label>
                            <input type="datetime-local" name="event_date"
                                class="form-control <?= (!empty($data['date_err'])) ? 'is-invalid' : ''; ?>"
                                value="<?= $data['event_date']; ?>">
                            <div class="invalid-feedback">
                                <?= $data['date_err']; ?>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Upcoming" <?= ($data['status'] == 'Upcoming') ? 'selected' : ''; ?>>Upcoming
                                </option>
                                <option value="Past" <?= ($data['status'] == 'Past') ? 'selected' : ''; ?>>Past</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location <sup>*</sup></label>
                        <input type="text" name="location"
                            class="form-control <?= (!empty($data['location_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= $data['location']; ?>">
                        <div class="invalid-feedback">
                            <?= $data['location_err']; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description / Details</label>
                        <textarea name="description" rows="5"
                            class="form-control"><?= $data['description']; ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded">
                        <a href="/admin/events" class="text-secondary text-decoration-none">Cancel</a>
                        <button type="submit" class="btn btn-info px-4 text-white">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>