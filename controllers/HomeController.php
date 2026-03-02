<?php
/**
 * Home Controller
 * 
 * Handles requests for the main landing page and public areas.
 */
class HomeController extends Controller
{

    public function index()
    {
        $userModel = $this->model('User');
        $excos = $userModel->getExcoMembers();

        // Prepare data to send to the view
        $data = [
            'title' => 'Welcome to Dore Numa College Warri Alumni Platform',
            'description' => 'Connect, collaborate, and stay updated with your alumni network.',
            'excos' => $excos
        ];

        // Load the view 'home/index' and pass the data
        $this->view('home/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'Learn more about the mission and vision of the Dore Numa College Warri Alumni.'
        ];

        $this->view('home/about', $data);
    }
}
