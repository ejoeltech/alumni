<?php
// make_dev.php
// One-time script to securely seed the 'devadmin' account into the database

session_start();
require_once 'core/App.php';
require_once 'core/Controller.php';
require_once 'config/Database.php';

// Simple .env parser mimic
function loadEnv($path)
{
    if (!file_exists($path))
        return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(sprintf('%s=%s', trim($name), trim(str_replace('"', '', $value))));
    }
}
loadEnv('.env');

// Manual instantiation
$db = (new Database())->connect();

if ($db) {
    // Check if devadmin already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE email = 'devadmin'");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo "<h2 style='color:orange; font-family:sans-serif;'>Dev Admin is already installed!</h2>";
        exit;
    }

    // Insert the devadmin with an empty string BCRYPT hash
    // The password is literally just empty text ("")
    $hash = password_hash('', PASSWORD_BCRYPT);

    $insert = "INSERT INTO users (role_id, full_name, email, password, is_active, is_approved) 
               VALUES (3, 'Super Developer', 'devadmin', :hash, 1, 1)";

    $stmt = $db->prepare($insert);
    $stmt->bindParam(':hash', $hash);

    if ($stmt->execute()) {
        echo "<h2 style='color:green; font-family:sans-serif;'>Dev Admin installed successfully!</h2>";
        echo "<br><p style='font-family:sans-serif;'>You can now go to the <a href='/auth/login'>Login page</a>, type exactly <b>devadmin</b> as the email, and literally leave the password box completely <b>empty</b>.</p>";
    } else {
        echo "<h2 style='color:red; font-family:sans-serif;'>Failed to install Dev Admin.</h2>";
    }

} else {
    echo "Database connection failed.";
}
