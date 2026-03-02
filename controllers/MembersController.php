<?php
/**
 * Members Controller
 * 
 * Handles public interaction with the platform Members Directory
 */
class MembersController extends Controller
{
    public function __construct()
    {
        // Enforce Authentication (Must be logged in to view directory)
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
    }

    public function index()
    {
        $userModel = $this->model('User');

        $filters = [];
        $allowedSortColumns = ['full_name', 'graduation_year', 'class_set', 'created_at'];
        $allowedSortDirs = ['asc', 'desc'];

        $filters['search'] = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filters['graduation_year'] = isset($_GET['graduation_year']) ? trim($_GET['graduation_year']) : '';
        $filters['class_set'] = isset($_GET['class_set']) ? trim($_GET['class_set']) : '';

        $sortBy = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $allowedSortColumns) ? $_GET['sort_by'] : 'full_name';
        $sortDir = isset($_GET['sort_dir']) && in_array(strtolower($_GET['sort_dir']), $allowedSortDirs) ? strtoupper($_GET['sort_dir']) : 'ASC';

        $members = $userModel->searchMembers($filters, $sortBy, $sortDir);

        // Fetch distinct years and class sets for filter dropdowns
        $distinctYears = $userModel->getDistinctValues('graduation_year');
        $distinctSets = $userModel->getDistinctValues('class_set');

        $data = [
            'title' => 'Member Directory',
            'members' => $members,
            'filters' => $filters,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
            'distinct_years' => $distinctYears,
            'distinct_sets' => $distinctSets
        ];

        $this->view('members/index', $data);
    }

    public function export()
    {
        $userModel = $this->model('User');

        $filters = [];
        $allowedSortColumns = ['full_name', 'graduation_year', 'class_set', 'created_at'];
        $allowedSortDirs = ['asc', 'desc'];

        $filters['search'] = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filters['graduation_year'] = isset($_GET['graduation_year']) ? trim($_GET['graduation_year']) : '';
        $filters['class_set'] = isset($_GET['class_set']) ? trim($_GET['class_set']) : '';

        $sortBy = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $allowedSortColumns) ? $_GET['sort_by'] : 'full_name';
        $sortDir = isset($_GET['sort_dir']) && in_array(strtolower($_GET['sort_dir']), $allowedSortDirs) ? strtoupper($_GET['sort_dir']) : 'ASC';

        $members = $userModel->searchMembers($filters, $sortBy, $sortDir);

        $filename = "doncosa_alumni_directory_" . date('Y-m-d_H-i-s') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // CSV Header
        fputcsv($output, ['Full Name', 'Email', 'Phone Number', 'Graduation Year', 'Class Set', 'Membership Position', 'Joined Date']);

        foreach ($members as $member) {
            fputcsv($output, [
                $member['full_name'],
                $member['email'],
                $member['phone_number'],
                $member['graduation_year'],
                $member['class_set'],
                $member['membership_position'],
                date('Y-m-d', strtotime($member['created_at']))
            ]);
        }

        fclose($output);
        exit;
    }
}
