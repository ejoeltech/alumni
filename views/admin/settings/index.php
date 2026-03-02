<div class="row pt-4">
    <div class="col-md-10 col-lg-8 mx-auto">
        <div class="card bg-transparent border-0 pb-0">
            <div class="card-body py-1 d-flex justify-content-between">
                <a href="/dashboard" class="text-secondary text-decoration-none"><i
                        class="bi bi-arrow-left-short"></i> Back to Dashboard</a>
                <span class="badge bg-secondary p-2 rounded-pill shadow-sm">Global System Variables</span>
            </div>
        </div>

        <div class="card shadow-sm border-dark border-top border-4 rounded-3 h-100 my-4 pb-4 px-4 py-3">
            <div class="card-header bg-white border-0 pb-0 pt-4 d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-dark fw-bold">Platform Settings & Branding</h3>
            </div>
            <div class="card-body">

                <div class="alert bg-light border text-muted shadow-sm mt-3 mb-5 d-flex align-items-center"
                    role="alert">
                    <i class="bi bi-gear-fill fs-4 text-secondary me-3"></i>
                    <div>
                        <span class="small">These variables modify how the application appears to public visitors and
                            standard alumni members.</span>
                    </div>
                </div>

                <form action="/admin/settings" method="POST" enctype="multipart/form-data">

                    <div class="mb-4">
                        <label for="site_name" class="form-label fw-bold">Platform Title / Site Name</label>
                        <input type="text" name="site_name" class="form-control form-control-lg border-dark shadow-sm"
                            value="<?= htmlspecialchars($data['settings']['site_name'] ?? ''); ?>"
                            placeholder="e.g. Doncosa Alumni Platform">
                    </div>

                    <div class="mb-4">
                        <label for="contact_email" class="form-label fw-bold">Master Contact Email</label>
                        <input type="email" name="contact_email" class="form-control shadow-sm"
                            value="<?= htmlspecialchars($data['settings']['contact_email'] ?? ''); ?>"
                            placeholder="admin@example.com">
                    </div>

                    <div class="row g-4 mb-4 mt-2 border-top pt-3 border-bottom pb-4 border-secondary opacity-75">
                        <div class="col-md-6">
                            <label for="theme_color_primary" class="form-label fw-bold"><i
                                    class="bi bi-palette-fill text-primary"></i> Primary Theme Color</label>
                            <input type="color" name="theme_color_primary"
                                class="form-control form-control-color border-primary shadow-sm w-100"
                                value="<?= htmlspecialchars($data['settings']['theme_color_primary'] ?? '#0d6efd'); ?>"
                                title="Choose your primary brand color">
                            <small class="text-muted fst-italic mt-1 d-block">Modifies core navbars, hero sections, and
                                main buttons.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="theme_color_secondary" class="form-label fw-bold"><i
                                    class="bi bi-circle-fill text-secondary"></i> Secondary Ascent Color</label>
                            <input type="color" name="theme_color_secondary"
                                class="form-control form-control-color border-secondary shadow-sm w-100"
                                value="<?= htmlspecialchars($data['settings']['theme_color_secondary'] ?? '#6c757d'); ?>"
                                title="Choose your secondary accent color">
                            <small class="text-muted fst-italic mt-1 d-block">Modifies badges, disabled actions, and
                                sub-elements.</small>
                        </div>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <div class="col-md-12 p-4 bg-light rounded shadow-sm border border-secondary">
                            <label for="site_logo"
                                class="form-label fw-bold d-block text-dark fs-5 border-bottom border-secondary pb-3 mb-3">Global
                                Brand Logo</label>

                            <div class="d-flex align-items-center mb-3">
                                <?php if (!empty($data['settings']['site_logo'])): ?>
                                    <div class="me-4 p-2 bg-white border rounded shadow-sm text-center">
                                        <small class="d-block text-muted fw-bold mb-2">Current Logo</small>
                                        <img src="/<?= htmlspecialchars($data['settings']['site_logo']); ?>"
                                            alt="Current Logo" style="max-height: 80px; object-fit: contain;">
                                    </div>
                                <?php endif; ?>

                                <div class="flex-grow-1">
                                    <label class="form-label fw-bold text-muted small">Upload New File (PNG, JPG,
                                        SVG)</label>
                                    <input type="file" name="site_logo" class="form-control bg-white shadow-sm"
                                        accept="image/*">
                                    <small class="d-block text-muted mt-2 lh-sm fst-italic">This will elegantly replace
                                        the textual site name inside the main navigation header site-wide.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <div class="col-md-12 p-4 rounded shadow-sm border border-warning"
                            style="background-color: #fff9e6;">
                            <label
                                class="form-label fw-bold d-block text-warning-emphasis fs-5 border-bottom border-warning pb-3 mb-4"><i
                                    class="bi bi-robot me-2"></i> Artificial Intelligence Integration</label>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ai_provider" class="form-label fw-bold text-dark">AI Provider
                                        Engine</label>
                                    <select name="ai_provider" class="form-select border-warning shadow-sm">
                                        <option value="groq" <?= (isset($data['settings']['ai_provider']) && $data['settings']['ai_provider'] == 'groq') ? 'selected' : ''; ?>>Groq (Fast
                                            Open-Source)</option>
                                        <option value="openai" <?= (isset($data['settings']['ai_provider']) && $data['settings']['ai_provider'] == 'openai') ? 'selected' : ''; ?>>OpenAI
                                            (GPT Models)</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ai_model" class="form-label fw-bold text-dark">Target Model Name</label>
                                    <input type="text" name="ai_model" class="form-control border-warning shadow-sm"
                                        value="<?= htmlspecialchars($data['settings']['ai_model'] ?? 'llama3-8b-8192'); ?>"
                                        placeholder="e.g. gpt-4o or llama3-8b-8192">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="ai_api_key" class="form-label fw-bold text-dark">Provider API Key <span
                                        class="badge bg-danger ms-1">Secret</span></label>
                                <input type="password" name="ai_api_key" class="form-control border-warning shadow-sm"
                                    value="<?= htmlspecialchars($data['settings']['ai_api_key'] ?? ''); ?>"
                                    placeholder="Paste your API Token secretly here...">
                            </div>

                            <div class="mb-2">
                                <label for="ai_system_prompt" class="form-label fw-bold text-dark">AI Personality /
                                    System Instructions</label>
                                <textarea name="ai_system_prompt" rows="3"
                                    class="form-control border-warning shadow-sm"><?= htmlspecialchars($data['settings']['ai_system_prompt'] ?? 'You are a professional, engaging, and respectful assistant for the Dore Numa College Warri Alumni Network.'); ?></textarea>
                                <small class="text-muted fst-italic mt-1 d-block">Define how you want the AI to write.
                                    Mention tone, style, and boundaries.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4 mt-2">
                        <div class="col-md-12 p-4 rounded shadow-sm border border-info"
                            style="background-color: #e6f7ff;">
                            <label
                                class="form-label fw-bold d-block text-info-emphasis fs-5 border-bottom border-info pb-3 mb-4"><i
                                    class="bi bi-phone-vibrate-fill me-2"></i> Communications Gateway (SMS &
                                WhatsApp)</label>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="sms_provider" class="form-label fw-bold text-dark">Primary Broadcast
                                        Provider</label>
                                    <select name="sms_provider" class="form-select border-info shadow-sm">
                                        <option value="termii" <?= (isset($data['settings']['sms_provider']) && $data['settings']['sms_provider'] == 'termii') ? 'selected' : ''; ?>>Termii
                                            SMS API</option>
                                        <option value="twilio" <?= (isset($data['settings']['sms_provider']) && $data['settings']['sms_provider'] == 'twilio') ? 'selected' : ''; ?>>Twilio
                                            (International)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="sms_sender_id" class="form-label fw-bold text-dark">Sender ID
                                        (Alpha-Numeric)</label>
                                    <input type="text" name="sms_sender_id" class="form-control border-info shadow-sm"
                                        value="<?= htmlspecialchars($data['settings']['sms_sender_id'] ?? 'DONCOSA'); ?>"
                                        placeholder="Max 11 chars (e.g. DORENUMA)">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="sms_api_key" class="form-label fw-bold text-dark">SMS Provider API Key /
                                    Token <span class="badge bg-danger ms-1">Secret</span></label>
                                <input type="password" name="sms_api_key" class="form-control border-info shadow-sm"
                                    value="<?= htmlspecialchars($data['settings']['sms_api_key'] ?? ''); ?>"
                                    placeholder="Paste your Secret SMS Router Access Key...">
                            </div>

                            <div class="mb-2">
                                <label for="whatsapp_token" class="form-label fw-bold text-dark">WhatsApp Business App
                                    Token <span class="badge bg-danger ms-1">Secret</span></label>
                                <input type="password" name="whatsapp_token" class="form-control border-info shadow-sm"
                                    value="<?= htmlspecialchars($data['settings']['whatsapp_token'] ?? ''); ?>"
                                    placeholder="Paste your Meta App Access Token here (Optional)...">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit"
                            class="btn btn-dark text-white btn-lg shadow-sm rounded border-3 fw-bold">Apply System
                            Changes <i class="bi bi-cloud-arrow-up ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>