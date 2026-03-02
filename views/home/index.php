<style>
    /* Premium Modern Homepage Animations */
    .hero-section {
        background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.95) 0%, rgba(var(--bs-secondary-rgb), 0.9) 100%), url('https://source.unsplash.com/1600x900/?college,university') center/cover;
        color: white;
        padding: 3.5rem 0;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .hover-lift {
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
    }

    .exco-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        background: #ffffff;
        text-align: center;
        padding: 2rem 1rem;
        position: relative;
    }

    .exco-avatar-wrapper {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-secondary));
    }

    .exco-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid white;
    }

    .exco-avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 4px solid white;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #adb5bd;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        background: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
    }
</style>

<!-- Modern Hero Section -->
<div class="hero-section text-center px-4">
    <div class="container my-4">
        <h1 class="display-5 fw-bolder mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
            <?= htmlspecialchars($data['title']); ?>
        </h1>
        <p class="lead mb-4 fw-light fs-5" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
            <?= htmlspecialchars($data['description']); ?>
            <br>
            A vibrant, centralized ecosystem for connecting generations.
        </p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a class="btn btn-light btn-lg px-5 fw-bold shadow-lg rounded-pill" href="/dashboard">
                    Access Network Dashboard <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            <?php else: ?>
                <a class="btn btn-light btn-lg px-5 fw-bold shadow-lg rounded-pill text-primary"
                    href="/auth/register">
                    Join the Elite Network
                </a>
                <a class="btn btn-outline-light btn-lg px-5 fw-bold rounded-pill" href="/auth/login">
                    Secure Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Features Architecture -->
<div class="row g-4 mt-2 mb-5">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-lift border-0">
            <div class="card-body text-center p-4">
                <div class="feature-icon">
                    <i class="bi bi-calendar-event-fill"></i>
                </div>
                <h4 class="card-title fw-bold">Live Events</h4>
                <p class="card-text text-muted mb-4">Discover past memories and stay dynamically updated on upcoming
                    reunions, summits, and pivotal alumni activities.</p>
                <a href="/events" class="btn btn-primary rounded-pill px-4">View Directory</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-lift border-0">
            <div class="card-body text-center p-4">
                <div class="feature-icon">
                    <i class="bi bi-rocket-takeoff-fill"></i>
                </div>
                <h4 class="card-title fw-bold">Active Projects</h4>
                <p class="card-text text-muted mb-4">Track milestone projects undertaken by our alumni consortium to
                    directly empower and support the college's future.</p>
                <a href="/projects" class="btn btn-primary rounded-pill px-4">View Initiatives</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 shadow-sm hover-lift border-0">
            <div class="card-body text-center p-4">
                <div class="feature-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h4 class="card-title fw-bold">Mentorship</h4>
                <p class="card-text text-muted mb-4">Interact instantly, mentor the next generation, and build powerful
                    resilient relationships with other distinguished members.</p>
                <a href="/home/about" class="btn btn-primary rounded-pill px-4">Read Manifesto</a>
            </div>
        </div>
    </div>
</div>

<!-- Executive Leadership Roster -->
<?php if (!empty($data['excos'])): ?>
    <div class="container-fluid bg-light py-5 rounded-4 shadow-sm mb-5 border">
        <div class="text-center mb-5">
            <span class="badge bg-primary px-3 py-2 rounded-pill mb-2 shadow-sm text-uppercase tracking-wide">Platform
                Leadership</span>
            <h2 class="display-6 fw-bold text-dark">Alumni Executive Officers</h2>
            <p class="text-muted fs-5">Recognizing the visionaries and leaders spearheading our initiatives.</p>
        </div>

        <div class="row justify-content-center g-4 px-3">
            <?php foreach ($data['excos'] as $exco): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card exco-card shadow-sm hover-lift border-top border-4 border-primary">
                        <div class="exco-avatar-wrapper shadow-sm">
                            <?php if (!empty($exco['profile_picture'])): ?>
                                <img src="/<?= htmlspecialchars($exco['profile_picture']); ?>"
                                    alt="<?= htmlspecialchars($exco['full_name']); ?>" class="exco-avatar">
                            <?php else: ?>
                                <div class="exco-avatar-placeholder">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($exco['full_name']); ?></h5>
                        <p class="text-primary fw-bold small mb-2 text-uppercase tracking-wider">
                            <i class="bi bi-star-fill text-warning me-1"></i>
                            <?= htmlspecialchars($exco['membership_position']); ?>
                        </p>
                        <div class="mt-2 text-muted small">
                            <?php if ($exco['graduation_year']): ?>
                                <span class="d-block"><i class="bi bi-mortarboard me-1"></i> Class of
                                    <?= htmlspecialchars($exco['graduation_year']); ?></span>
                            <?php endif; ?>
                            <?php if ($exco['class_set']): ?>
                                <span class="d-block"><i class="bi bi-house-door me-1"></i>
                                    <?= htmlspecialchars($exco['class_set']); ?> Set</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>