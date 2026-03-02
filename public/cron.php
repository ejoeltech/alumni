<?php
/**
 * Automated Birthday & Anniversary Engine
 * 
 * Scheduled Task / Cron Job script.
 * Usage CLI: php public/cron.php
 * Usage Web: http://localhost/doncosa/public/cron.php?auth=internal_system
 */

// Simple security check to prevent web abuse (can bypass if running via strictly CLI)
$isCli = php_sapi_name() == 'cli';
$isAuthorizedWeb = isset($_GET['auth']) && $_GET['auth'] === 'internal_system';

if (!$isCli && !$isAuthorizedWeb) {
    http_response_code(403);
    die('Forbidden: Automated Task Engine is secured.');
}

// Emulate environment loading so we can access models and core functionality
require_once '../core/Database.php';
require_once '../core/AIService.php';
require_once '../models/Setting.php';

$db = (new Database())->connect();
$settingModel = new Setting();

echo "========================================================\n";
echo "DONCOSA AUTOMATED SYSTEM TASKS: INITIALIZING...\n";
echo "Date/Time: " . date('Y-m-d H:i:s') . "\n";
echo "========================================================\n\n";

try {
    // 1. Fetch Users whose birthday is strictly today
    $stmt = $db->query('
        SELECT id, full_name, email, phone_number, date_of_birth, class_set 
        FROM users 
        WHERE is_active = 1 
        AND date_of_birth IS NOT NULL 
        AND MONTH(date_of_birth) = MONTH(CURRENT_DATE()) 
        AND DAY(date_of_birth) = DAY(CURRENT_DATE())
    ');
    $birthdayUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Found " . count($birthdayUsers) . " active member(s) celebrating a birthday today.\n\n";

    if (count($birthdayUsers) > 0) {
        $aiService = new AIService();
        $basePrompt = "Please write a short, extremely warm, professional, and personalized 'Happy Birthday' message for an alumni member named [NAME]. It should be 2 to 3 sentences maximum, specifically tailored as a text message from their old high school alumni association (Dore Numa College Warri). Say congratulations.";

        foreach ($birthdayUsers as $user) {
            echo "Processing birthday for: " . $user['full_name'] . " (UID #" . $user['id'] . ")...\n";

            // 2. Security Check: Did we already text them today? (Don't double bill or annoy them)
            $checkStmt = $db->prepare('
                SELECT id 
                FROM message_logs 
                WHERE recipient_id = :uid 
                AND message_type = "Birthday" 
                AND DATE(created_at) = CURRENT_DATE()
            ');
            $checkStmt->execute([':uid' => $user['id']]);

            if ($checkStmt->rowCount() > 0) {
                echo " -> [SKIPPED] Birthday message already transmitted earlier today.\n";
                continue;
            }

            // 3. Generate Personal Message via AI Engine
            $personalizedPrompt = str_replace('[NAME]', $user['full_name'], $basePrompt);
            $messageDraft = $aiService->generateContent($personalizedPrompt);

            // Handle catastrophic AI failure (fallback template so they still get a happy birthday)
            if (strpos($messageDraft, 'Error:') !== false || empty($messageDraft)) {
                $messageDraft = "Happy Birthday " . $user['full_name'] . "! Wishing you a fantastic day from all of us at the Dore Numa College Warri Alumni Network.";
            }

            echo " -> [AI COMPILED]: " . substr($messageDraft, 0, 50) . "...\n";

            // 4. Log the message transmission back into the central Cellular Audit logs
            // Note: In an actual production environment, a true SMS API cURL request (like Termii) would execute right here.
            $logStmt = $db->prepare('
                INSERT INTO message_logs (recipient_number, recipient_id, gateway, message_type, status, message_body) 
                VALUES (:number, :uid, :gateway, "Birthday", "Sent", :body)
            ');

            $logStmt->execute([
                ':number' => $user['phone_number'] ?: $user['email'], // Fallback to email if no phone registered
                ':uid' => $user['id'],
                ':gateway' => 'SMS', // Default vector, can be dynamic
                ':body' => $messageDraft
            ]);

            echo " -> [SUCCESS] Transmission Recorded in Database.\n\n";
        }
    }

    echo "========================================================\n";
    echo "AUTOMATED ROUTINES COMPLETE. ENGINE SHUTDOWN.\n";
    echo "========================================================\n";


} catch (Exception $e) {
    echo "FATAL CRASH: " . $e->getMessage() . "\n";
}
