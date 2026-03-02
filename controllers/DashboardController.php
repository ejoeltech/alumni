<?php
/**
 * Dashboard Controller
 * 
 * Secure portal for logged-in users.
 * Displays content based on user roles and permissions.
 */
class DashboardController extends Controller
{

    public function __construct()
    {
        // Enforce Authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: /doncosa/public/auth/login');
            exit;
        }
    }

    public function index()
    {
        // Fetch current user details
        $userModel = $this->model('User');
        $user = $userModel->findUserByEmail($_SESSION['user_email']);

        if (!$user) {
            // Failsafe in case session user is somehow deleted from DB
            header('Location: /doncosa/public/auth/logout');
            exit;
        }

        $data = [
            'title' => 'Dashboard - Alumni Platform',
            'user' => $user,
            'role_name' => $this->getRoleName($user['role_id'])
        ];

        $this->view('dashboard/index', $data);
    }

    public function settings()
    {
        // Enforce Level 2 access or higher
        if ($_SESSION['user_role'] < 2) {
            header('Location: /doncosa/public/dashboard');
            exit;
        }

        $userModel = $this->model('User');
        $user = $userModel->getUserById($_SESSION['user_id']);

        $data = [
            'title' => 'Platform Settings',
            'user' => $user
        ];

        $this->view('dashboard/settings', $data);
    }

    public function editProfile()
    {
        $userModel = $this->model('User');
        $user = $userModel->getUserById($_SESSION['user_id']); // Ensure we are dealing with active exact row

        $data = [
            'title' => 'Edit Profile',
            'user' => $user,
            'full_name' => $user['full_name'],
            'phone_number' => $user['phone_number'],
            'date_of_birth' => $user['date_of_birth'],
            'graduation_year' => $user['graduation_year'],
            'class_set' => $user['class_set'],
            'error' => '',
            'success' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $updateData = [
                'full_name' => trim(htmlspecialchars($_POST['full_name'])),
                'phone_number' => trim(htmlspecialchars($_POST['phone_number'])),
                'date_of_birth' => trim(htmlspecialchars($_POST['date_of_birth'])),
                'graduation_year' => trim(htmlspecialchars($_POST['graduation_year'])),
                'class_set' => trim(htmlspecialchars($_POST['class_set']))
            ];

            // Password Reset Handling inside Profile Editor
            if (!empty($_POST['new_password'])) {
                if (strlen($_POST['new_password']) < 6) {
                    $data['error'] = 'Password must be at least 6 characters.';
                } else {
                    $hashed_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
                    $userModel->updatePassword($_SESSION['user_id'], $hashed_password);
                    $data['success'] = 'Security credentials updated drastically.';
                }
            }

            // Handle Passport/Photo Upload
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                // Ensure upload directory exists
                $uploadDir = '../public/uploads/passports/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $filename = 'uid_' . $_SESSION['user_id'] . '_' . time() . '_' . basename($_FILES['profile_picture']['name']);
                $targetFile = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                    $updateData['profile_picture'] = 'uploads/passports/' . $filename;
                } else {
                    $data['error'] = 'Failed to upload photo securely.';
                }
            }

            if (empty($data['error'])) {
                if ($userModel->updateProfile($_SESSION['user_id'], $updateData)) {
                    $data['success'] = 'Profile updated successfully!';
                    // Refresh data in view
                    $data['user'] = $userModel->getUserById($_SESSION['user_id']);
                } else {
                    $data['error'] = 'Database logic error while updating your profile. Try again.';
                }
            }
        }

        $this->view('dashboard/editProfile', $data);
    }

    /**
     * Map role ID to string name for frontend display.
     */
    private function getRoleName($role_id)
    {
        switch ($role_id) {
            case 1:
                return 'Regular Member';
            case 2:
                return 'Admin User';
            case 3:
                return 'Developer Manager';
            case 4:
                return 'Financial Admin';
            default:
                return 'Unknown Role';
        }
    }
}
