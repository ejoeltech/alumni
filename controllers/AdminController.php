<?php
/**
 * Admin Controller
 * 
 * Handles Admin-level and Developer-level portal features (RBAC protected).
 */
class AdminController extends Controller
{

    public function __construct()
    {
        // Enforce Authentication and Authorization (Role 2, 3, or 4)
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] < 2) {
            header('Location: /doncosa/public/dashboard');
            exit;
        }

        // --- Role 4: FINANCIAL ADMIN ISOLATION ---
        // Financial Admins (Role 4) are strictly restricted to Accounting features.
        // We evaluate their target URL and block access if they try to touch members, events, etc.
        if ($_SESSION['user_role'] == 4) {
            $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
            $urlParts = explode('/', $url);
            $method = isset($urlParts[1]) ? $urlParts[1] : 'index'; // 'index' is the default method inside a controller

            $allowedFinancialMethods = ['dues', 'dueCreate', 'dueDelete', 'payments', 'paymentVerify'];

            if (!in_array($method, $allowedFinancialMethods)) {
                // If they request an unauthorized method, punt them back to dashboard
                header('Location: /doncosa/public/dashboard');
                exit;
            }
        }
    }

    // --- EVENTS MANAGEMENT ---

    public function events()
    {
        $eventModel = $this->model('Event');
        $events = $eventModel->getEvents();

        $data = [
            'title' => 'Manage Events - Admin',
            'events' => $events
        ];

        $this->view('admin/events/index', $data);
    }

    public function eventCreate()
    {
        $data = [
            'title' => 'Create Event',
            'event_title' => '',
            'description' => '',
            'event_date' => '',
            'location' => '',
            'status' => 'Upcoming',
            'title_err' => '',
            'date_err' => '',
            'location_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['event_title'] = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : '';
            $data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
            $data['event_date'] = isset($_POST['event_date']) ? trim(htmlspecialchars($_POST['event_date'])) : '';
            $data['location'] = isset($_POST['location']) ? trim(htmlspecialchars($_POST['location'])) : '';
            $data['status'] = isset($_POST['status']) ? trim(htmlspecialchars($_POST['status'])) : '';

            if (empty($data['event_title']))
                $data['title_err'] = 'Please enter a title';
            if (empty($data['event_date']))
                $data['date_err'] = 'Please define a date';
            if (empty($data['location']))
                $data['location_err'] = 'Please specify a location';

            if (empty($data['title_err']) && empty($data['date_err']) && empty($data['location_err'])) {
                $eventModel = $this->model('Event');
                $imagePath = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../public/uploads/events/';
                    $fileName = time() . '_' . basename($_FILES['image']['name']);
                    $targetPath = $uploadDir . $fileName;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                        $imagePath = 'uploads/events/' . $fileName;
                    }
                }

                $insertData = [
                    'title' => $data['event_title'],
                    'description' => $data['description'],
                    'event_date' => $data['event_date'],
                    'location' => $data['location'],
                    'status' => $data['status'],
                    'image' => $imagePath,
                    'created_by' => $_SESSION['user_id']
                ];

                if ($eventModel->addEvent($insertData)) {
                    header('Location: /doncosa/public/admin/events');
                    exit;
                } else {
                    die('Error creating event');
                }
            } else {
                $this->view('admin/events/create', $data);
            }
        } else {
            $this->view('admin/events/create', $data);
        }
    }

    public function eventEdit($id)
    {
        $eventModel = $this->model('Event');
        $event = $eventModel->getEventById($id);

        if (!$event) {
            header('Location: /doncosa/public/admin/events');
            exit;
        }

        $data = [
            'title' => 'Edit Event',
            'id' => $event['id'],
            'event_title' => $event['title'],
            'description' => $event['description'],
            // Properly format MySQL datetime for HTML5 datetime-local input
            'event_date' => date('Y-m-d\TH:i', strtotime($event['event_date'])),
            'location' => $event['location'],
            'status' => $event['status'],
            'title_err' => '',
            'date_err' => '',
            'location_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['event_title'] = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : '';
            $data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
            $data['event_date'] = isset($_POST['event_date']) ? trim(htmlspecialchars($_POST['event_date'])) : '';
            $data['location'] = isset($_POST['location']) ? trim(htmlspecialchars($_POST['location'])) : '';
            $data['status'] = isset($_POST['status']) ? trim(htmlspecialchars($_POST['status'])) : '';

            if (empty($data['event_title']))
                $data['title_err'] = 'Please enter a title';
            if (empty($data['event_date']))
                $data['date_err'] = 'Please define a date';
            if (empty($data['location']))
                $data['location_err'] = 'Please specify a location';

            if (empty($data['title_err']) && empty($data['date_err']) && empty($data['location_err'])) {
                $imagePath = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../public/uploads/events/';
                    $fileName = time() . '_' . basename($_FILES['image']['name']);
                    $targetPath = $uploadDir . $fileName;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                        $imagePath = 'uploads/events/' . $fileName;
                    }
                }

                $updateData = [
                    'id' => $id,
                    'title' => $data['event_title'],
                    'description' => $data['description'],
                    'event_date' => $data['event_date'],
                    'location' => $data['location'],
                    'status' => $data['status'],
                    'image' => $imagePath
                ];

                if ($eventModel->updateEvent($updateData)) {
                    header('Location: /doncosa/public/admin/events');
                    exit;
                } else {
                    die('Error updating event');
                }
            } else {
                $this->view('admin/events/edit', $data);
            }
        } else {
            $this->view('admin/events/edit', $data);
        }
    }

    public function eventDelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $eventModel = $this->model('Event');
            if ($eventModel->deleteEvent($id)) {
                header('Location: /doncosa/public/admin/events');
                exit;
            } else {
                die('Error deleting event');
            }
        } else {
            header('Location: /doncosa/public/admin/events');
            exit;
        }
    }

    // --- PROJECTS MANAGEMENT ---

    public function projects()
    {
        $projectModel = $this->model('Project');
        $projects = $projectModel->getProjects();

        $data = [
            'title' => 'Manage Projects - Admin',
            'projects' => $projects
        ];

        $this->view('admin/projects/index', $data);
    }

    public function projectCreate()
    {
        $data = [
            'title' => 'Create Project',
            'name' => '',
            'description' => '',
            'budget' => '',
            'start_date' => '',
            'completion_date' => '',
            'status' => 'Pending',
            'project_lead' => '',
            'name_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['name'] = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : '';
            $data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
            $data['budget'] = !empty($_POST['budget']) ? trim(htmlspecialchars($_POST['budget'])) : null;
            $data['start_date'] = !empty($_POST['start_date']) ? trim(htmlspecialchars($_POST['start_date'])) : null;
            $data['completion_date'] = !empty($_POST['completion_date']) ? trim(htmlspecialchars($_POST['completion_date'])) : null;
            $data['status'] = isset($_POST['status']) ? trim(htmlspecialchars($_POST['status'])) : 'Pending';
            $data['project_lead'] = isset($_POST['project_lead']) ? trim(htmlspecialchars($_POST['project_lead'])) : '';

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a project name';
            }

            if (empty($data['name_err'])) {
                $projectModel = $this->model('Project');
                $insertData = [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'budget' => $data['budget'],
                    'start_date' => $data['start_date'],
                    'completion_date' => $data['completion_date'],
                    'status' => $data['status'],
                    'project_lead' => $data['project_lead'],
                    'created_by' => $_SESSION['user_id']
                ];

                if ($projectModel->addProject($insertData)) {
                    header('Location: /doncosa/public/admin/projects');
                    exit;
                } else {
                    die('Error creating project');
                }
            } else {
                $this->view('admin/projects/create', $data);
            }
        } else {
            $this->view('admin/projects/create', $data);
        }
    }

    public function projectEdit($id)
    {
        $projectModel = $this->model('Project');
        $project = $projectModel->getProjectById($id);

        if (!$project) {
            header('Location: /doncosa/public/admin/projects');
            exit;
        }

        $data = [
            'title' => 'Edit Project',
            'id' => $project['id'],
            'name' => $project['name'],
            'description' => $project['description'],
            'budget' => $project['budget'],
            'start_date' => $project['start_date'],
            'completion_date' => $project['completion_date'],
            'status' => $project['status'],
            'project_lead' => $project['project_lead'],
            'name_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['name'] = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : '';
            $data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
            $data['budget'] = !empty($_POST['budget']) ? trim(htmlspecialchars($_POST['budget'])) : null;
            $data['start_date'] = !empty($_POST['start_date']) ? trim(htmlspecialchars($_POST['start_date'])) : null;
            $data['completion_date'] = !empty($_POST['completion_date']) ? trim(htmlspecialchars($_POST['completion_date'])) : null;
            $data['status'] = isset($_POST['status']) ? trim(htmlspecialchars($_POST['status'])) : 'Pending';
            $data['project_lead'] = isset($_POST['project_lead']) ? trim(htmlspecialchars($_POST['project_lead'])) : '';

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a project name';
            }

            if (empty($data['name_err'])) {
                $updateData = [
                    'id' => $id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'budget' => $data['budget'],
                    'start_date' => $data['start_date'],
                    'completion_date' => $data['completion_date'],
                    'status' => $data['status'],
                    'project_lead' => $data['project_lead']
                ];

                if ($projectModel->updateProject($updateData)) {
                    header('Location: /doncosa/public/admin/projects');
                    exit;
                } else {
                    die('Error updating project');
                }
            } else {
                $this->view('admin/projects/edit', $data);
            }
        } else {
            $this->view('admin/projects/edit', $data);
        }
    }

    public function projectDelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $projectModel = $this->model('Project');
            if ($projectModel->deleteProject($id)) {
                header('Location: /doncosa/public/admin/projects');
                exit;
            } else {
                die('Error deleting project');
            }
        } else {
            header('Location: /doncosa/public/admin/projects');
            exit;
        }
    }
    // --- MEMBERS MANAGEMENT ---

    public function members()
    {
        $userModel = $this->model('User');
        $users = $userModel->getAllUsers();

        $data = [
            'title' => 'Manage Members - Admin',
            'users' => $users
        ];

        $this->view('admin/members/index', $data);
    }

    public function memberEdit($id)
    {
        $userModel = $this->model('User');
        $user = $userModel->getUserById($id);

        if (!$user) {
            header('Location: /doncosa/public/admin/members');
            exit;
        }

        // Only Super Admins (Role 3) can edit other Admins or Developer accounts to prevent self-lockouts or overrides
        if ($_SESSION['user_role'] < 3 && $user['role_id'] >= 2 && $user['id'] != $_SESSION['user_id']) {
            die('Permission Denied: Only Developer Managers can modify Admin accounts.');
        }

        $data = [
            'title' => 'Edit Member',
            'user' => $user
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $role_id = isset($_POST['role_id']) ? (int) $_POST['role_id'] : 1;
            $is_active = isset($_POST['is_active']) ? (int) $_POST['is_active'] : 0;
            $membership_position = isset($_POST['membership_position']) ? trim(htmlspecialchars($_POST['membership_position'])) : null;

            if ($userModel->updateUserAdmin($id, $role_id, $is_active, $membership_position)) {
                header('Location: /doncosa/public/admin/members');
                exit;
            } else {
                die('Error updating user');
            }
        } else {
            $this->view('admin/members/edit', $data);
        }
    }

    public function memberApprove($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');

            // Execute approval utilizing session user id as the approver
            if ($userModel->approveUser($id, $_SESSION['user_id'])) {
                header('Location: /doncosa/public/admin/members');
                exit;
            } else {
                die('Error approving user');
            }
        } else {
            header('Location: /doncosa/public/admin/members');
            exit;
        }
    }

    public function memberDelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Protect against self-deletion
            if ($id == $_SESSION['user_id']) {
                die('You cannot delete your own active session account.');
            }

            $userModel = $this->model('User');
            $user = $userModel->getUserById($id);

            // Only Super Admins (Role 3) can delete Admins
            if ($_SESSION['user_role'] < 3 && $user['role_id'] >= 2) {
                die('Permission Denied: Only Developer Managers can delete Admin accounts.');
            }

            if ($userModel->deleteUser($id)) {
                header('Location: /doncosa/public/admin/members');
                exit;
            } else {
                die('Error deleting user');
            }
        } else {
            header('Location: /doncosa/public/admin/members');
            exit;
        }
    }

    // --- POSITIONS MANAGEMENT (Level 2+) ---

    public function positions()
    {
        $excoPositionModel = $this->model('ExcoPosition');
        $positions = $excoPositionModel->getAllPositions();

        $data = [
            'title' => 'Exco Positions Hierarchy',
            'positions' => $positions
        ];

        $this->view('admin/positions/index', $data);
    }

    public function positionCreate()
    {
        $data = [
            'title' => 'Create Abstract Exco Position',
            'position_title' => '',
            'description' => '',
            'title_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['position_title'] = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : '';
            $data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';

            if (empty($data['position_title'])) {
                $data['title_err'] = 'Please enter a formal abstract title for this position map.';
            }

            if (empty($data['title_err'])) {
                $posData = [
                    'title' => $data['position_title'],
                    'description' => $data['description']
                ];
                $excoPositionModel = $this->model('ExcoPosition');
                if ($excoPositionModel->createPosition($posData)) {
                    header('Location: /doncosa/public/admin/positions');
                    exit;
                } else {
                    die('Entity Error. Could not create abstract position.');
                }
            }
        }
        $this->view('admin/positions/create', $data);
    }

    public function positionDelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $excoPositionModel = $this->model('ExcoPosition');
            if ($excoPositionModel->deletePosition($id)) {
                header('Location: /doncosa/public/admin/positions');
                exit;
            } else {
                die('Integrity Guard Active. Failed to destroy abstract position map.');
            }
        } else {
            header('Location: /doncosa/public/admin/positions');
            exit;
        }
    }

    // --- ELECTION MANAGEMENT (Level 2+) ---

    public function elections()
    {
        $electionModel = $this->model('Election');
        $elections = $electionModel->getAllElections();

        $data = [
            'title' => 'Manager Live Elections',
            'elections' => $elections
        ];

        $this->view('admin/elections/index', $data);
    }

    public function electionCreate()
    {
        $data = [
            'title' => 'Create New Election',
            'election_title' => '',
            'description' => '',
            'start_date' => '',
            'end_date' => '',
            'is_active' => 0,
            'title_err' => '',
            'date_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['election_title'] = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : '';
            $data['description'] = isset($_POST['description']) ? trim(htmlspecialchars($_POST['description'])) : '';
            $data['start_date'] = isset($_POST['start_date']) ? trim(htmlspecialchars($_POST['start_date'])) : '';
            $data['end_date'] = isset($_POST['end_date']) ? trim(htmlspecialchars($_POST['end_date'])) : '';
            $data['is_active'] = isset($_POST['is_active']) ? (int) $_POST['is_active'] : 0;

            // Expected positions to map from the checkboxes
            $mapped_positions = isset($_POST['positions']) ? $_POST['positions'] : [];

            if (empty($data['election_title'])) {
                $data['title_err'] = 'Please enter a title for the election.';
            }

            if (empty($data['start_date']) || empty($data['end_date'])) {
                $data['date_err'] = 'Start and end timelines are strictly mandatory.';
            }

            if (empty($data['title_err']) && empty($data['date_err'])) {
                $electionData = [
                    'title' => $data['election_title'],
                    'description' => $data['description'],
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'is_active' => $data['is_active']
                ];

                $electionModel = $this->model('Election');

                // Tricky part: We need the newly created ID back to bind positions
                $this->db = new Database(); // Re-use raw DB access slightly to get lastInsertId safely

                $stmt = $this->db->prepare('INSERT INTO elections (title, description, start_date, end_date, is_active) VALUES (:title, :description, :start_date, :end_date, :is_active)');
                $stmt->bindParam(':title', $electionData['title']);
                $stmt->bindParam(':description', $electionData['description']);
                $stmt->bindParam(':start_date', $electionData['start_date']);
                $stmt->bindParam(':end_date', $electionData['end_date']);
                $stmt->bindParam(':is_active', $electionData['is_active']);

                if ($stmt->execute()) {
                    $new_election_id = $this->db->lastInsertId();

                    // Bind positions
                    foreach ($mapped_positions as $pos_title) {
                        $electionModel->mapPositionToElection($new_election_id, trim(htmlspecialchars($pos_title)));
                    }

                    header('Location: /doncosa/public/admin/elections');
                    exit;
                } else {
                    die('Entity Error. Could not deploy new election object.');
                }
            }
        }

        // Load abstract positions so Admin can tick which ones are needed for this election
        $excoPositionModel = $this->model('ExcoPosition');
        $data['abstract_positions'] = $excoPositionModel->getAllPositions();

        $this->view('admin/elections/create', $data);
    }

    public function electionDelete($id)
    {
        // Enforce Level 2 access
        if ($_SESSION['user_role'] < 2) {
            header('Location: /doncosa/public/dashboard');
            exit;
        }

        $electionModel = $this->model('Election');
        $electionModel->deleteElection($id);

        header('Location: /doncosa/public/admin/elections');
    }

    // --- DUES & ACCOUNTING ---

    public function dues()
    {
        // Enforce Level 2 access
        if ($_SESSION['user_role'] < 2) {
            header('Location: /doncosa/public/dashboard');
            exit;
        }

        $paymentModel = $this->model('Payment');
        $dues = $paymentModel->getAllDues();

        $data = [
            'title' => 'Manage Dues & Levies',
            'dues' => $dues
        ];

        $this->view('admin/dues/index', $data);
    }

    public function dueCreate()
    {
        // Enforce Level 2 access
        if ($_SESSION['user_role'] < 2) {
            header('Location: /doncosa/public/dashboard');
            exit;
        }

        $data = [
            'title' => 'Create New Due or Levy',
            'title_input' => '',
            'amount' => '',
            'description' => '',
            'due_date' => '',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['title_input'] = trim(htmlspecialchars($_POST['title']));
            $data['amount'] = trim(htmlspecialchars($_POST['amount']));
            $data['description'] = trim(htmlspecialchars($_POST['description']));
            $data['due_date'] = trim(htmlspecialchars($_POST['due_date']));

            if (empty($data['title_input']) || empty($data['amount'])) {
                $data['error'] = 'Title and Amount are required fields.';
            } else {
                $paymentModel = $this->model('Payment');

                $dueData = [
                    'title' => $data['title_input'],
                    'amount' => $data['amount'],
                    'description' => $data['description'],
                    'due_date' => $data['due_date'],
                    'is_monthly' => isset($_POST['is_monthly']) ? 1 : 0,
                    'is_donation' => isset($_POST['is_donation']) ? 1 : 0
                ];

                if ($paymentModel->createDue($dueData)) {
                    header('Location: /doncosa/public/admin/dues');
                    exit;
                } else {
                    $data['error'] = 'Something went wrong creating the due.';
                }
            }
        }

        $this->view('admin/dues/create', $data);
    }

    public function dueDelete($id)
    {
        // Enforce Level 2 access
        if ($_SESSION['user_role'] < 2) {
            header('Location: /doncosa/public/dashboard');
            exit;
        }

        $paymentModel = $this->model('Payment');
        $paymentModel->deleteDue($id);

        header('Location: /doncosa/public/admin/dues');
    }

    public function payments()
    {
        // Enforce Level 2 access
        if ($_SESSION['user_role'] < 2) {
            header('Location: /doncosa/public/dashboard');
            exit;
        }

        $paymentModel = $this->model('Payment');
        $payments = $paymentModel->getAllPayments();

        // Calculate total verified amount
        $totalVerified = 0;
        foreach ($payments as $payment) {
            if ($payment['status'] === 'Verified') {
                $totalVerified += $payment['amount'];
            }
        }

        $data = [
            'title' => 'Payments & Accounting',
            'payments' => $payments,
            'total_verified' => $totalVerified
        ];

        $this->view('admin/payments/index', $data);
    }

    public function paymentVerify($id)
    {
        // Enforce Level 2 access
        if ($_SESSION['user_role'] < 2) {
            header('Location: /doncosa/public/dashboard');
            exit;
        }

        $paymentModel = $this->model('Payment');
        $status = $_GET['status'] ?? 'Verified';

        if (in_array($status, ['Verified', 'Rejected', 'Pending'])) {
            $paymentModel->updatePaymentStatus($id, $status);
        }

        header('Location: /doncosa/public/admin/payments');
    }

    // --- SETTINGS MANAGEMENT ---

    public function settings()
    {
        // Settings page ideally only for Developer Managers (Role 3), or high level Admins
        if ($_SESSION['user_role'] < 2) {
            die('Permission Denied.');
        }

        $settingModel = $this->model('Setting');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $site_name = isset($_POST['site_name']) ? trim(htmlspecialchars($_POST['site_name'])) : '';
            $contact_email = isset($_POST['contact_email']) ? trim(htmlspecialchars($_POST['contact_email'])) : '';

            $settingModel->updateOrInsertSetting('site_name', $site_name);
            $settingModel->updateOrInsertSetting('contact_email', $contact_email);

            // Interface Customization settings
            if (isset($_POST['theme_color_primary'])) {
                $settingModel->updateOrInsertSetting('theme_color_primary', trim(htmlspecialchars($_POST['theme_color_primary'])));
            }
            if (isset($_POST['theme_color_secondary'])) {
                $settingModel->updateOrInsertSetting('theme_color_secondary', trim(htmlspecialchars($_POST['theme_color_secondary'])));
            }

            // AI Features Settings Base
            if (isset($_POST['ai_provider'])) {
                $settingModel->updateOrInsertSetting('ai_provider', trim(htmlspecialchars($_POST['ai_provider'])));
                $settingModel->updateOrInsertSetting('ai_model', trim(htmlspecialchars($_POST['ai_model'])));
                $settingModel->updateOrInsertSetting('ai_system_prompt', trim(htmlspecialchars($_POST['ai_system_prompt'])));

                // Only update the API key if a new one was actually typed in (to avoid blanking out the DB)
                if (!empty(trim($_POST['ai_api_key']))) {
                    $settingModel->updateOrInsertSetting('ai_api_key', trim(htmlspecialchars($_POST['ai_api_key'])));
                }
            }

            // Messaging SMS/Whatsapp Gateway Hook
            if (isset($_POST['sms_provider'])) {
                $settingModel->updateOrInsertSetting('sms_provider', trim(htmlspecialchars($_POST['sms_provider'])));
                $settingModel->updateOrInsertSetting('sms_sender_id', trim(htmlspecialchars($_POST['sms_sender_id'])));

                if (!empty(trim($_POST['sms_api_key']))) {
                    $settingModel->updateOrInsertSetting('sms_api_key', trim(htmlspecialchars($_POST['sms_api_key'])));
                }

                if (!empty(trim($_POST['whatsapp_token']))) {
                    $settingModel->updateOrInsertSetting('whatsapp_token', trim(htmlspecialchars($_POST['whatsapp_token'])));
                }
            }

            // Handle logo image upload
            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                // Ensure upload directory exists
                $uploadDir = '../public/uploads/system/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $fileName = 'logo_' . time() . '_' . basename($_FILES['site_logo']['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['site_logo']['tmp_name'], $targetPath)) {
                    $settingModel->updateOrInsertSetting('site_logo', 'uploads/system/' . $fileName);
                }
            }

            // Provide a success flash message or just redirect
            header('Location: /doncosa/public/admin/settings');
            exit;
        } else {
            $settings = $settingModel->getAllSettings();
            $data = [
                'title' => 'Platform Settings',
                'settings' => $settings
            ];
            $this->view('admin/settings/index', $data);
        }
    }

    // --- ANNOUNCEMENTS MANAGEMENT ---

    public function announcements()
    {
        $announcementModel = $this->model('Announcement');
        $announcements = $announcementModel->getAllAnnouncements();

        $data = [
            'title' => 'Broadcast Announcements',
            'announcements' => $announcements
        ];

        $this->view('admin/announcements/index', $data);
    }

    public function announcementCreate()
    {
        $data = [
            'title' => 'New Announcement',
            'announcement_title' => '',
            'content' => '',
            'status' => 'Draft',
            'title_err' => '',
            'content_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['announcement_title'] = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : '';
            $data['content'] = isset($_POST['content']) ? trim(htmlspecialchars($_POST['content'])) : '';
            $data['status'] = isset($_POST['status']) ? trim(htmlspecialchars($_POST['status'])) : 'Draft';
            $data['created_by'] = $_SESSION['user_id'];

            if (empty($data['announcement_title'])) {
                $data['title_err'] = 'Please enter a title';
            }
            if (empty($data['content'])) {
                $data['content_err'] = 'Please enter broadcast content';
            }

            if (empty($data['title_err']) && empty($data['content_err'])) {
                $announcementModel = $this->model('Announcement');
                // We use 'title' natively in model binding
                $saveData = [
                    'title' => $data['announcement_title'],
                    'content' => $data['content'],
                    'status' => $data['status'],
                    'created_by' => $data['created_by']
                ];
                if ($announcementModel->addAnnouncement($saveData)) {
                    header('Location: /doncosa/public/admin/announcements');
                    exit;
                } else {
                    die('Error saving announcement');
                }
            } else {
                $this->view('admin/announcements/create', $data);
            }
        } else {
            $this->view('admin/announcements/create', $data);
        }
    }

    public function announcementEdit($id)
    {
        $announcementModel = $this->model('Announcement');
        $announcement = $announcementModel->getAnnouncementById($id);

        if (!$announcement) {
            header('Location: /doncosa/public/admin/announcements');
            exit;
        }

        $data = [
            'title' => 'Edit Announcement',
            'id' => $announcement['id'],
            'announcement_title' => $announcement['title'],
            'content' => $announcement['content'],
            'status' => $announcement['status'],
            'title_err' => '',
            'content_err' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['announcement_title'] = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : '';
            $data['content'] = isset($_POST['content']) ? trim(htmlspecialchars($_POST['content'])) : '';
            $data['status'] = isset($_POST['status']) ? trim(htmlspecialchars($_POST['status'])) : 'Draft';

            if (empty($data['announcement_title'])) {
                $data['title_err'] = 'Please enter a title';
            }
            if (empty($data['content'])) {
                $data['content_err'] = 'Please enter content';
            }

            if (empty($data['title_err']) && empty($data['content_err'])) {
                $saveData = [
                    'id' => $data['id'],
                    'title' => $data['announcement_title'],
                    'content' => $data['content'],
                    'status' => $data['status']
                ];
                if ($announcementModel->updateAnnouncement($saveData)) {
                    header('Location: /doncosa/public/admin/announcements');
                    exit;
                } else {
                    die('Error updating announcement');
                }
            } else {
                $this->view('admin/announcements/edit', $data);
            }
        } else {
            $this->view('admin/announcements/edit', $data);
        }
    }

    public function announcementDelete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $announcementModel = $this->model('Announcement');
            if ($announcementModel->deleteAnnouncement($id)) {
                header('Location: /doncosa/public/admin/announcements');
                exit;
            } else {
                die('Error deleting announcement');
            }
        } else {
            header('Location: /doncosa/public/admin/announcements');
            exit;
        }
    }

    // --- AI SYSTEM INTEGRATION PHASE 3 ---

    public function generateAIDraft()
    {
        // Ensure standard users cannot abuse API requests
        if ($_SESSION['user_role'] < 2) {
            echo json_encode(['error' => 'Permission Denied. Unauthorized clearance level.']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $topic = isset($input['topic']) ? trim(htmlspecialchars($input['topic'])) : '';

            // Require input context
            if (empty($topic)) {
                echo json_encode(['error' => 'No broadcast subject provided for AI context.']);
                exit;
            }

            // Hook the new AIService
            require_once '../core/AIService.php';
            $aiService = new AIService();

            // Systematically inject the prompt formatting over their topic
            $prompt = "Please compose an engaging, professional, and grammatically perfect announcement blast covering the following topic: " . $topic;

            // Ping the API
            $draftArray = $aiService->generateContent($prompt);

            echo json_encode(['draft' => $draftArray]);
            exit;
        }
    }

    // --- PHASE 4 DEVELOPER ANALYTICS & LOGS ---

    public function analytics()
    {
        // Enforce Super Admin (Developer Manager) Clearance ONLY
        if ($_SESSION['user_role'] != 3) {
            die('Permission Denied. Critical Developer Clearance Required.');
        }

        $db = (new Database())->connect();

        // Fetch aggregate AI Token Usage
        $stmtTokens = $db->query('SELECT SUM(prompt_tokens) as total_pt, SUM(completion_tokens) as total_ct FROM ai_logs');
        $tokenSums = $stmtTokens->fetch(PDO::FETCH_ASSOC);

        // Fetch detailed API Ping history specifically mapping to users
        $stmtLogs = $db->query('SELECT l.*, u.full_name, u.email FROM ai_logs l LEFT JOIN users u ON l.created_by = u.id ORDER BY l.created_at DESC LIMIT 100');
        $aiLogs = $stmtLogs->fetchAll(PDO::FETCH_ASSOC);

        // Fetch detailed Messaging logs (Termii/Twilio/WhatsApp)
        $stmtMsgLogs = $db->query('SELECT m.*, u.full_name FROM message_logs m LEFT JOIN users u ON m.created_by = u.id ORDER BY m.created_at DESC LIMIT 100');
        $msgLogs = $stmtMsgLogs->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Master Developer Analytics',
            'token_aggregations' => $tokenSums,
            'ai_logs' => $aiLogs,
            'msg_logs' => $msgLogs
        ];

        $this->view('admin/analytics/index', $data);
    }

    public function staff()
    {
        // Enforce Super Admin (Developer Manager) Clearance ONLY
        if ($_SESSION['user_role'] != 3) {
            die('Permission Denied. Critical Developer Clearance Required.');
        }

        $db = (new Database())->connect();

        // Fetch specifically Administrative members
        $stmt = $db->query('
            SELECT u.*, r.role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.id 
            WHERE u.role_id >= 2 
            ORDER BY u.role_id DESC, u.created_at ASC
        ');
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Admin Staff Control',
            'users' => $admins
        ];

        $this->view('admin/staff/index', $data);
    }
}
