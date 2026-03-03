<?php
/**
 * Front Controller
 * 
 * All requests are routed through here.
 */

// Start session
session_start();

// Simple .env parser for beginners
function loadEnv($path)
{
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue; // Skip comments
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        // Remove quotes if present
        if (preg_match('/^"(.*)"$/', $value, $matches)) {
            $value = $matches[1];
        }
        putenv(sprintf('%s=%s', $name, $value));
    }
}

// Load environment variables
loadEnv('../.env');

// Enable error reporting if debug mode is on
if (getenv('DEBUG_MODE') === 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Require necessary core files
require_once '../core/App.php';
require_once '../core/Controller.php';
require_once '../config/Database.php';

// Instantiate the App (Starts Routing) with a global diagnostic failsafe for production deployment tracking
try {
    $app = new App();
} catch (\Throwable $e) {
    // Intercept Fatal Errors and database Exceptions that would otherwise cause a silent 500 Internal Server Error Crash on strict-mode hostings
    http_response_code(500);
    echo "<div style='padding:30px; background-color:#fff3cd; color:#856404; border-left:6px solid #ffeeba; margin:40px; font-family:sans-serif; border-radius:4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>";
    echo "<h2 style='margin-top:0; color:#d39e00;'>⚠️ Critical System Exception</h2>";
    echo "<p><strong>Error Message:</strong> <span style='color:#dc3545;'>" . htmlspecialchars($e->getMessage()) . "</span></p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line " . $e->getLine() . ")</p>";
    echo "</div>";
}
