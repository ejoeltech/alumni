<?php
require_once '../models/Setting.php';
$settingModel = new Setting();
$global_site_name = $settingModel->getSetting('site_name') ?: getenv('APP_NAME') ?: 'Alumni Platform';
$global_site_logo = $settingModel->getSetting('site_logo');

// Theme Colors Initialization -> HEX to RGB conversion for Bootstrap core bindings
$themePrimary = $settingModel->getSetting('theme_color_primary') ?: '#0d6efd';
$themeSecondary = $settingModel->getSetting('theme_color_secondary') ?: '#6c757d';

function hexToRgbString($hex)
{
    if (!$hex)
        return "13, 110, 253"; // default blue
    $hex = str_replace("#", "", $hex);
    if (strlen($hex) == 3) {
        return hexdec(substr($hex, 0, 1) . substr($hex, 0, 1)) . ", " . hexdec(substr($hex, 1, 1) . substr($hex, 1, 1)) . ", " . hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        return hexdec(substr($hex, 0, 2)) . ", " . hexdec(substr($hex, 2, 2)) . ", " . hexdec(substr($hex, 4, 2));
    }
}

$primaryRgb = hexToRgbString($themePrimary);
$secondaryRgb = hexToRgbString($themeSecondary);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($data['title']) ? $data['title'] . ' - ' . $global_site_name : $global_site_name; ?>
    </title>
    <!-- Include Bootstrap CSS for quick and beginner-friendly styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="/doncosa/public/css/style.css" rel="stylesheet">

    <!-- Dynamic Global Theme System CSS Injector -->
    <style>
        :root {
            --bs-primary:
                <?= $themePrimary ?>
            ;
            --bs-primary-rgb:
                <?= $primaryRgb ?>
            ;
            --bs-secondary:
                <?= $themeSecondary ?>
            ;
            --bs-secondary-rgb:
                <?= $secondaryRgb ?>
            ;
        }

        .btn-primary {
            --bs-btn-bg: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-bg: rgba(var(--bs-primary-rgb), 0.85);
            --bs-btn-hover-border-color: rgba(var(--bs-primary-rgb), 0.85);
            --bs-btn-active-bg: rgba(var(--bs-primary-rgb), 0.75);
        }

        .btn-outline-primary {
            --bs-btn-color: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-bg: var(--bs-primary);
            --bs-btn-hover-border-color: var(--bs-primary);
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold" href="/doncosa/public/">
                <?php if (!empty($global_site_logo)): ?>
                    <img src="/doncosa/public/<?= htmlspecialchars($global_site_logo); ?>" alt="Site Logo"
                        style="height: 96px; margin-right: 15px; object-fit: contain; background: white; padding: 5px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <?php endif; ?>
                <?= htmlspecialchars($global_site_name); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="/doncosa/public/">Home</a>
                    </li>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="/doncosa/public/dashboard">Dashboard</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="/doncosa/public/home/about">About</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="discoverDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Platform
                        </a>
                        <ul class="dropdown-menu shadow border-0" aria-labelledby="discoverDropdown">
                            <li><a class="dropdown-item" href="/doncosa/public/events"><i class="bi bi-calendar-event me-2 text-warning"></i> Events</a></li>
                            <li><a class="dropdown-item" href="/doncosa/public/projects"><i class="bi bi-clipboard2-data me-2 text-info"></i> Projects</a></li>
                        </ul>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="hubDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Community Hub
                            </a>
                            <ul class="dropdown-menu shadow border-0" aria-labelledby="hubDropdown">
                                <li><a class="dropdown-item" href="/doncosa/public/members"><i class="bi bi-people-fill me-2 text-primary"></i> Member Directory</a></li>
                                <li><a class="dropdown-item" href="/doncosa/public/payments"><i class="bi bi-bank2 me-2 text-success"></i> Payments & Ledger</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown ms-lg-3 mt-3 mt-lg-0">
                            <a class="nav-link dropdown-toggle btn btn-light text-danger fw-bold px-3 py-2 rounded-pill shadow-sm" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> <?= $_SESSION['user_name']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item py-2" href="/doncosa/public/dashboard/editProfile"><i class="bi bi-person-badge me-2 text-secondary"></i> My Profile</a></li>
                                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] >= 2): ?>
                                    <li><a class="dropdown-item py-2 fw-bold" href="/doncosa/public/dashboard/settings"><i class="bi bi-gear-fill me-2 text-danger"></i> Settings & Admin</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2 text-danger fw-bold" href="/doncosa/public/auth/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-2 mt-3 mt-lg-0">
                            <a class="nav-link text-white fw-bold" href="/doncosa/public/auth/login">Login</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-light text-danger fw-bold rounded-pill px-4 shadow-sm" href="/doncosa/public/auth/register">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">