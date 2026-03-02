</div> <!-- Close container from header -->

<footer class="bg-light text-center py-4 mt-5">
    <div class="container">
        <p class="text-muted mb-0">&copy;
            <?= date('Y'); ?>
            <?= getenv('APP_NAME') ?: 'Alumni Platform'; ?>. All rights reserved.
        </p>
        <p class="text-muted small">Status: Development Phase | Version: 1.0</p>
    </div>
</footer>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/doncosa/public/js/main.js"></script>
</body>

</html>