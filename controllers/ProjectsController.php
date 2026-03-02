<?php
/**
 * Projects Controller
 * 
 * Displays college support projects on the public site logically grouped by status.
 */
class ProjectsController extends Controller
{

    public function index()
    {
        // Instantiate Model
        $projectModel = $this->model('Project');
        $projects = $projectModel->getProjects();

        // Categorize exactly per spec ('Past', 'Running', 'Pending', 'Future')
        $categorized_projects = [
            'Running' => [],
            'Pending' => [],
            'Past' => [],
            'Future' => []
        ];

        foreach ($projects as $project) {
            if (array_key_exists($project['status'], $categorized_projects)) {
                $categorized_projects[$project['status']][] = $project;
            }
        }

        $data = [
            'title' => 'Alumni Projects - Alumni Platform',
            'projects' => $categorized_projects
        ];

        // Load project index view
        $this->view('projects/index', $data);
    }
}
