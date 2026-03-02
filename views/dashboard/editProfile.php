<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header bg-white pb-0 pt-4 d-flex justify-content-between align-items-center mb-2">
                <h3 class="mb-0 text-dark fw-bold">Edit Profile</h3>
                <a href="/doncosa/public/dashboard" class="btn btn-sm btn-outline-secondary"><i
                        class="bi bi-arrow-left"></i> Back</a>
            </div>

            <div class="card-body px-4 pb-4">
                <?php if (!empty($data['error'])): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= htmlspecialchars($data['error']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($data['success'])): ?>
                    <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i>
                        <?= htmlspecialchars($data['success']); ?>
                    </div>
                <?php endif; ?>

                <form action="/doncosa/public/dashboard/editProfile" method="post" enctype="multipart/form-data">

                    <!-- Avatar Upload Section -->
                    <div class="d-flex align-items-center mb-4 bg-light p-3 rounded border">
                        <div class="me-4 position-relative">
                            <?php if (!empty($data['user']['profile_picture'])): ?>
                                <img src="/doncosa/public/<?= htmlspecialchars($data['user']['profile_picture']); ?>"
                                    id="previewAvatar" class="rounded-circle shadow-sm"
                                    style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #0d6efd;">
                            <?php else: ?>
                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex justify-content-center align-items-center shadow-sm"
                                    id="previewAvatar" style="width: 80px; height: 80px; border: 3px solid #6c757d;">
                                    <i class="bi bi-person-fill text-secondary fs-1"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                            <label for="profile_picture" class="form-label fw-bold mb-1">Upload Passport / Profile
                                Picture</label>
                            <input class="form-control form-control-sm shadow-sm" type="file" name="profile_picture"
                                id="profile_picture" accept="image/*">
                            <small class="text-muted d-block mt-1">Maximum size 2MB. Square images work best.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="full_name" class="form-label fw-bold">Full Name <sup>*</sup></label>
                        <input type="text" name="full_name" class="form-control"
                            value="<?= htmlspecialchars($data['full_name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-muted">Account Email Address <small>(Cannot be
                                changed)</small></label>
                        <input type="email" class="form-control bg-light"
                            value="<?= htmlspecialchars($data['user']['email']); ?>" disabled readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label fw-bold">Primary Phone Number
                                <sup>*</sup></label>
                            <input type="text" name="phone_number" class="form-control"
                                value="<?= htmlspecialchars($data['phone_number']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label fw-bold">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control"
                                value="<?= htmlspecialchars($data['date_of_birth']); ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="graduation_year" class="form-label fw-bold">Graduation Year</label>
                            <input type="text" name="graduation_year" class="form-control"
                                value="<?= htmlspecialchars($data['graduation_year']); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="class_set" class="form-label fw-bold">Class Set</label>
                            <input type="text" name="class_set" class="form-control"
                                value="<?= htmlspecialchars($data['class_set']); ?>">
                        </div>
                    </div>

                    <hr class="my-4">
                    
                    <h5 class="fw-bold text-danger mb-3"><i class="bi bi-shield-lock-fill me-2"></i> Access Credentials Update</h5>
                    <div class="alert alert-warning py-2 mb-4 shadow-sm border-warning">
                        <small><i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> If you were assigned a blank Developer password, you <b>must</b> securely set a new one here immediately to protect your login.</small>
                    </div>
                    
                    <div class="mb-5">
                        <label for="new_password" class="form-label fw-bold">Overwrite Password <span class="text-muted small fw-normal">(Leave blank to keep current)</span></label>
                        <input type="password" name="new_password" class="form-control border-danger border-2" autocomplete="new-password">
                    </div>

                    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded border">
                        <a href="/doncosa/public/auth/recover" class="btn btn-outline-secondary btn-sm"><i class="bi bi-envelope-fill me-1"></i> Or Recover via Email Token</a>
                        <button type="submit" class="btn btn-primary shadow-sm fw-bold px-4 py-2"><i class="bi bi-save-fill me-2"></i> Lock Profile Changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Small script to preview image upload dynamically
    document.getElementById('profile_picture').addEventListener('change', function (e) {
        if (e.target.files && e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function (ev) {
                let avatarBox = document.getElementById('previewAvatar');
                if (avatarBox.tagName === 'DIV') {
                    // morph it into an img tag dynamically
                    let newImg = document.createElement('img');
                    newImg.id = 'previewAvatar';
                    newImg.className = 'rounded-circle shadow-sm';
                    newImg.style = 'width: 80px; height: 80px; object-fit: cover; border: 3px solid #0d6efd;';
                    newImg.src = ev.target.result;
                    avatarBox.parentNode.replaceChild(newImg, avatarBox);
                } else {
                    avatarBox.src = ev.target.result;
                }
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>