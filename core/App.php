<?php
/**
 * Core App Class (Router)
 * 
 * Parses the URL and routes requests to the appropriate Controller and Method.
 * URL Format: /public/index.php?url=controller/method/params
 */
class App
{
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // 1. Look in controllers for first value
        if (isset($url[0]) && file_exists('../controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            // Set as current controller
            $this->currentController = ucfirst($url[0]) . 'Controller';
            // Unset 0 Index
            unset($url[0]);
        }

        // Require the controller
        require_once '../controllers/' . $this->currentController . '.php';

        // Instantiate controller class
        $this->currentController = new $this->currentController;

        // 2. Check for second part of URL (Method)
        if (isset($url[1])) {
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }

        // 3. Get parameters (Any remaining parts of URL)
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * Parse the URL into an array
     * @return array|null
     */
    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            // Remove ending slash
            $url = rtrim($_GET['url'], '/');
            // Sanitize string as URL
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Break into an array
            $url = explode('/', $url);
            return $url;
        }
        return null;
    }
}
