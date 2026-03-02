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

// Instantiate the App (Starts Routing)
$app = new App();
