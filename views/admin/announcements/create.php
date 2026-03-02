<div class="row pt-4">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card shadow-sm border-primary border-top border-4 rounded-3 h-100 mb-5 pb-4 px-4 py-3">
            <div class="card-header bg-white border-0 pb-0 pt-4 d-flex justify-content-between">
                <div>
                    <h3 class="mb-0 text-primary fw-bold">Draft New Broadcast</h3>
                    <p class="text-muted small">Compose a message to send out to platform users and alumni networks.</p>
                </div>
                <a href="/admin/announcements" class="text-secondary text-decoration-none mt-2"><i
                        class="bi bi-x-circle fs-3 text-secondary"></i></a>
            </div>
            <div class="card-body">
                <form action="/admin/announcementCreate" method="POST">

                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Broadcast Subject / Headline <span
                                class="text-danger">*</span></label>
                        <input type="text" name="title"
                            class="form-control form-control-lg border-primary shadow-sm <?= (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= $data['announcement_title']; ?>"
                            placeholder="e.g. Annual General Meeting Delayed">
                        <div class="invalid-feedback fw-bold">
                            <?= $data['title_err']; ?>
                        </div>
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="content" class="form-label fw-bold">Message Content <span
                                class="text-danger">*</span></label>
                        <textarea name="content" rows="6"
                            class="form-control hover-shadow shadow-sm <?= (!empty($data['content_err'])) ? 'is-invalid' : ''; ?>"
                            placeholder="Type the full announcement here... Remember to keep it professional and engaging!"><?= $data['content']; ?></textarea>
                        <div class="invalid-feedback fw-bold">
                            <?= $data['content_err']; ?>
                        </div>

                        <!-- Active AI Engine Hook -->
                        <div class="position-absolute d-flex align-items-center" style="bottom: 15px; right: 15px;">
                            <span id="aiLoadingRing" class="d-none me-3"><span
                                    class="spinner-grow spinner-grow-sm text-info" role="status"></span> <small
                                    class="text-secondary fw-bold fst-italic">AI composing...</small></span>
                            <button type="button" id="aiDraftButton"
                                class="btn btn-sm btn-info text-white shadow-sm fw-bold">
                                <i class="bi bi-robot text-white pe-1"></i> Compose with AI
                            </button>
                        </div>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <div class="col-md-6 pt-3 px-4 bg-light rounded border shadow-sm text-center mx-auto">
                            <label for="status"
                                class="form-label fw-bold d-block text-secondary border-bottom pb-2">Publishing Status
                                Control</label>

                            <select name="status"
                                class="form-select border-bottom border-3 form-select-lg mb-3 shadow-none">
                                <option value="Draft" <?= ($data['status'] == 'Draft') ? 'selected' : ''; ?>>Tracking:
                                    Private Draft</option>
                                <option value="Published" class="text-success fw-bold" <?= ($data['status'] == 'Published') ? 'selected' : ''; ?>>LIVE: Publish Globally</option>
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-info py-2 d-flex align-items-center mt-3 shadow-sm border border-info"
                        role="alert">
                        <span><i class="bi bi-chat-square-text-fill me-3 fs-3 text-primary"></i></span>
                        <div class="small text-dark font-monospace">SMS & WhatsApp direct gateway blasting capabilities
                            are temporarily disabled until API tokens are configured by Developers later.</div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg shadow rounded py-3 fs-5">Save Generated
                            Broadcast <i class="bi bi-send-check-fill ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const aiDraftBtn = document.getElementById('aiDraftButton');
        const loadRing = document.getElementById('aiLoadingRing');
        const titleInput = document.querySelector('input[name="title"]');
        const contentBox = document.querySelector('textarea[name="content"]');

        if (aiDraftBtn) {
            aiDraftBtn.addEventListener('click', () => {
                const subject = titleInput.value.trim();

                if (!subject) {
                    alert('Oops! Please write a Broadcast Subject in the Headline input box first, and then the AI will know what to write about!');
                    return;
                }

                aiDraftBtn.disabled = true;
                loadRing.classList.remove('d-none');

                fetch('/admin/generateAIDraft', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ topic: subject })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            alert('Configuration Error: ' + data.error);
                        } else if (data.draft) {
                            // Check if content already exists to prevent catastrophic overrides
                            if (contentBox.value.trim() !== '') {
                                if (confirm('Do you want to overwrite your currently typed-out content with the AI generated draft?')) {
                                    contentBox.value = data.draft;
                                } else {
                                    contentBox.value += '\n\n' + data.draft;
                                }
                            } else {
                                contentBox.value = data.draft;
                            }
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('A systemic network crash happened attempting to reach the server context.');
                    })
                    .finally(() => {
                        aiDraftBtn.disabled = false;
                        loadRing.classList.add('d-none');
                    });
            });
        }
    });
</script>