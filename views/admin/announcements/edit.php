<div class="row pt-4">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card bg-transparent border-0 pb-0">
            <div class="card-body py-1 d-flex justify-content-between">
                <a href="/doncosa/public/admin/announcements" class="text-secondary text-decoration-none"><i
                        class="bi bi-arrow-left-short"></i> Back to Messaging Base</a>
                <span class="badge bg-secondary p-2 rounded-pill shadow-sm">Message ID: #
                    <?= $data['id']; ?>
                </span>
            </div>
        </div>

        <div class="card shadow-sm border-info border-top border-4 rounded-3 h-100 my-4 pb-4 px-4 py-3">
            <div class="card-header bg-white border-0 pb-0 pt-4 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-info text-dark fw-bold">Edit Live Announcement</h3>
            </div>
            <div class="card-body">

                <div class="alert alert-warning border border-warning shadow-sm mt-3 mb-5 d-flex align-items-center bg-white"
                    role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-4 text-warning me-3"></i>
                    <div>
                        <span class="small font-monospace text-dark pt-1">You are modifying a broadcast template.
                            Changing a Live/Published status back to Draft will immediately unlist the message globally
                            across all active member feeds.</span>
                    </div>
                </div>

                <form action="/doncosa/public/admin/announcementEdit/<?= $data['id']; ?>" method="POST">

                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Broadcast Headline / Subject <span
                                class="text-danger">*</span></label>
                        <input type="text" name="title"
                            class="form-control form-control-lg border-info shadow-none <?= (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= htmlspecialchars($data['announcement_title']); ?>">
                        <div class="invalid-feedback fw-bold">
                            <?= $data['title_err']; ?>
                        </div>
                    </div>

                    <div class="mb-4 position-relative border-bottom border-light pb-4">
                        <label for="content" class="form-label fw-bold text-secondary">Rendered Text Content <span
                                class="text-danger">*</span></label>
                        <textarea name="content" rows="7"
                            class="form-control hover-shadow border-2 <?= (!empty($data['content_err'])) ? 'is-invalid' : ''; ?>"><?= htmlspecialchars($data['content']); ?></textarea>
                        <div class="invalid-feedback fw-bold">
                            <?= $data['content_err']; ?>
                        </div>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <!-- Status Overwrite -->
                        <div class="col-md-6 pt-3 px-4 bg-light rounded shadow-sm border text-center mx-auto">
                            <label for="status"
                                class="form-label fw-bold d-block text-dark fs-5 border-bottom pb-3 mb-3">Live Status
                                Check</label>

                            <select name="status"
                                class="form-select border-bottom border-3 <?= ($data['status'] == 'Published') ? 'border-success text-success' : 'border-secondary text-secondary'; ?> form-select-lg mb-3 fw-bold bg-white text-center">
                                <option class="text-secondary" value="Draft" <?= ($data['status'] == 'Draft') ? 'selected' : ''; ?>>Withheld (Draft Node)</option>
                                <option class="text-success" value="Published" <?= ($data['status'] == 'Published') ? 'selected' : ''; ?>>Push Live (Published)</option>
                            </select>
                            <small class="d-block text-muted mt-3 py-2 lh-sm fst-italic">Note: Pushing text messages
                                manually via API arrays will be available shortly <span
                                    class="badge bg-danger rounded-pill px-2">Offline</span></small>
                        </div>

                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit"
                            class="btn btn-info text-white border-info btn-lg shadow-sm rounded border-3 fw-bold">Update
                            Broadcast Node <i class="bi bi-broadcast ms-2 border-start ps-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>