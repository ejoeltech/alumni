<?php
/**
 * Base Controller Class
 * 
 * All controllers should extend this class.
 * It provides core methods like loading models and rendering views.
 */
class Controller
{

    /**
     * Load a model class and instantiate it
     * 
     * @param string $model Name of the model (e.g., 'User')
     * @return object Instance of the model
     */
    public function model($model)
    {
        // Require the model file
        require_once '../models/' . $model . '.php';
        // Return a new instance of the model
        return new $model();
    }

    /**
     * Load a view file and pass data to it
     * 
     * @param string $view Path to the view file relative to 'views/' (e.g., 'home/index')
     * @param array $data Data to pass to the view
     */
    public function view($view, $data = [])
    {
        // Check if the view file exists
        if (file_exists('../views/' . $view . '.php')) {
            // Require header
            require_once '../views/layout/header.php';
            // Require the view
            require_once '../views/' . $view . '.php';
            // Require footer
            require_once '../views/layout/footer.php';
        } else {
            // If view doesn't exist, show an error
            die("View '" . $view . "' does not exist.");
        }
    }
}
