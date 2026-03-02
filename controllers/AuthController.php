<?php
/**
 * Auth Controller
 * 
 * Handles User Login, Registration, and Logout.
 */
class AuthController extends Controller
{

    public function login()
    {
        // If user is already logged in, redirect to dashboard or home
        if (isset($_SESSION['user_id'])) {
            header('Location: /doncosa/public/');
            exit;
        }

        $data = [
            'title' => 'Login - Alumni Platform',
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => ''
        ];

        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $data['email'] = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
            $data['password'] = isset($_POST['password']) ? trim(htmlspecialchars($_POST['password'])) : '';

            // Validate Email or Phone Number
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email or phone number';
            }

            // Validate Password
            if (empty($data['password'])) {
                // Secret bypass strictly allowing the devadmin string username to hit the DB natively with an empty hash payload
                if ($data['email'] !== 'devadmin') {
                    $data['password_err'] = 'Please enter your password';
                }
            }

            // Check if user exists
            $userModel = $this->model('User');
            if ($userModel->findUserByEmailOrPhone($data['email'])) {
                // User found
            } else {
                // User not found
                $data['email_err'] = 'No user found with this email or phone number';
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    if ($loggedInUser['is_approved'] == 0) {
                        $data['email_err'] = 'This account is pending approval by an assigned Administrator.';
                        $this->view('auth/login', $data);
                    } elseif ($loggedInUser['is_active'] == 0) {
                        $data['email_err'] = 'This account has been suspended by an Administrator.';
                        $this->view('auth/login', $data);
                    } else {
                        // Create Session
                        $this->createUserSession($loggedInUser);

                        // Force newly seeded blank Developer Admins straight into the Password Update form
                        if ($loggedInUser['email'] === 'devadmin' && empty($data['password'])) {
                            header('Location: /doncosa/public/dashboard/editProfile');
                            exit;
                        }
                    }
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }
        } else {
            // Load view for GET request
            $this->view('auth/login', $data);
        }
    }

    public function register()
    {
        // If user is already logged in, redirect
        if (isset($_SESSION['user_id'])) {
            header('Location: /doncosa/public/');
            exit;
        }

        $data = [
            'title' => 'Register - Alumni Platform',
            'full_name' => '',
            'email' => '',
            'phone_number' => '',
            'graduation_year' => '',
            'class_set' => '',
            'password' => '',
            'confirm_password' => '',
            'full_name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Init data
            $data['full_name'] = isset($_POST['full_name']) ? trim(htmlspecialchars($_POST['full_name'])) : '';
            $data['email'] = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
            $data['phone_number'] = isset($_POST['phone_number']) ? trim(htmlspecialchars($_POST['phone_number'])) : '';
            $data['date_of_birth'] = isset($_POST['date_of_birth']) ? trim(htmlspecialchars($_POST['date_of_birth'])) : '';
            $data['graduation_year'] = isset($_POST['graduation_year']) ? trim(htmlspecialchars($_POST['graduation_year'])) : '';
            $data['class_set'] = isset($_POST['class_set']) ? trim(htmlspecialchars($_POST['class_set'])) : '';
            $data['password'] = isset($_POST['password']) ? trim(htmlspecialchars($_POST['password'])) : '';
            $data['confirm_password'] = isset($_POST['confirm_password']) ? trim(htmlspecialchars($_POST['confirm_password'])) : '';

            // Validate variables
            $userModel = $this->model('User');

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Check email exists
                if ($userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            if (empty($data['phone_number'])) {
                $data['phone_number_err'] = 'Please enter your phone number';
            } else {
                if ($userModel->findUserByPhone($data['phone_number'])) {
                    $data['phone_number_err'] = 'Phone number is already associated with an account';
                }
            }

            if (empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter your full name';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['full_name_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['phone_number_err'])) {
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

                // Register User
                $userModel = $this->model('User');
                if ($userModel->register($data)) {
                    // Redirect to login
                    header('Location: /doncosa/public/auth/login');
                    exit;
                } else {
                    die('Something went wrong. Please try again later.');
                }
            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }
        } else {
            // Load view
            $this->view('auth/register', $data);
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        header('Location: /doncosa/public/auth/login');
        exit;
    }

    public function recover()
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: /doncosa/public/');
            exit;
        }

        $data = [
            'title' => 'Recover Account',
            'email' => '',
            'phone_number' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['email'] = trim(htmlspecialchars($_POST['email']));
            $data['phone_number'] = trim(htmlspecialchars($_POST['phone_number']));

            if (empty($data['email']) || empty($data['phone_number'])) {
                $data['error'] = 'Please provide both your registered email and phone number to verify your identity.';
            } else {
                $userModel = $this->model('User');
                $user = $userModel->findUserByEmail($data['email']);

                if ($user && $user['phone_number'] === $data['phone_number']) {
                    // Validated! Safe to set a temp session for password resetting
                    $_SESSION['recovery_user_id'] = $user['id'];
                    header('Location: /doncosa/public/auth/reset');
                    exit;
                } else {
                    $data['error'] = 'The provided email and phone number combination does not match our records.';
                }
            }
        }

        $this->view('auth/recover', $data);
    }

    public function reset()
    {
        if (!isset($_SESSION['recovery_user_id'])) {
            header('Location: /doncosa/public/auth/login');
            exit;
        }

        $data = [
            'title' => 'Set New Password',
            'password' => '',
            'confirm_password' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['password'] = trim(htmlspecialchars($_POST['password']));
            $data['confirm_password'] = trim(htmlspecialchars($_POST['confirm_password']));

            if (empty($data['password']) || strlen($data['password']) < 6) {
                $data['password_err'] = 'Please enter a valid password (min 6 characters).';
            }

            if ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match.';
            }

            if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Update password natively
                $hashed = password_hash($data['password'], PASSWORD_BCRYPT);
                $userModel = $this->model('User');
                if ($userModel->updatePassword($_SESSION['recovery_user_id'], $hashed)) {
                    unset($_SESSION['recovery_user_id']); // Ensure temporary access token is destroyed
                    header('Location: /doncosa/public/auth/login?reset=success');
                    exit;
                } else {
                    die('Critical Error updating user password structure.');
                }
            }
        }

        $this->view('auth/reset', $data);
    }

    /**
     * Create user session variables after successful login
     */
    private function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role_id'];

        // Redirect to home or dashboard
        header('Location: /doncosa/public/');
        exit;
    }
}
