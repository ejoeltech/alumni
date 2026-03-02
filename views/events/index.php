<div class="row w-100 mb-5">
    <div class="col-md-10 mx-auto text-center">
        <h1 class="display-5 text-primary">Alumni Events</h1>
        <p class="lead text-muted">Join us, reconnect, and celebrate our shared heritage.</p>
    </div>
</div>

<div class="row w-100">
    <div class="col-md-10 mx-auto">
        <!-- Upcoming Events Section -->
        <h3 class="mb-4 d-flex align-items-center"><span class="badge bg-success me-2">Upcoming</span> Important Dates
        </h3>
        <div class="row mb-5">
            <?php if (empty($data['upcoming_events'])): ?>
                <div class="col-12">
                    <p class="text-muted fst-italic">There are no upcoming events scheduled at this time.</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['upcoming_events'] as $event): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-success shadow-sm">
                            <?php if (!empty($event['image'])): ?>
                                <img src="/doncosa/public/<?= $event['image']; ?>" class="card-img-top img-fluid" alt="Event Flier"
                                    style="max-height: 250px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $event['title']; ?>
                                </h5>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <small>📅
                                        <?= date('l, F j, Y', strtotime($event['event_date'])); ?>
                                    </small> <br>
                                    <small>📍
                                        <?= $event['location']; ?>
                                    </small>
                                </h6>
                                <p class="card-text mt-3">
                                    <?= substr($event['description'], 0, 100); ?>...
                                </p>
                                <a href="#" class="card-link">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <hr class="mb-5">

        <!-- Past Events Section -->
        <h3 class="mb-4 d-flex align-items-center"><span class="badge bg-secondary me-2">Past</span> Memories</h3>
        <div class="row">
            <?php if (empty($data['past_events'])): ?>
                <div class="col-12">
                    <p class="text-muted fst-italic">No past events found in the archives.</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['past_events'] as $event): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 shadow-sm bg-light text-muted">
                            <?php if (!empty($event['image'])): ?>
                                <img src="/doncosa/public/<?= $event['image']; ?>" class="card-img-top img-fluid" alt="Event Flier"
                                    style="max-height: 150px; object-fit: cover; opacity: 0.8;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h6 class="card-title">
                                    <?= $event['title']; ?>
                                </h6>
                                <p class="small mb-1">📅
                                    <?= date('M j, Y', strtotime($event['event_date'])); ?>
                                </p>
                                <small class="fst-italic">📍
                                    <?= $event['location']; ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>