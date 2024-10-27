<?php

class Router 
{
    private $_uri = array();
    private $_action = array();

    // Method to add a new route
    public function add($uri, $action = null) 
    {
        $this->_uri[] = '/' . trim($uri, '/');

        if ($action != null) 
        {
            $this->_action[] = $action;
        }
    }

    // Method to run the action associated with the given URI
    public function run($uri, $db, $values) 
    {

        $uriGet = isset($uri) ? '/' . trim($uri, '/') : '/';

        foreach ($this->_uri as $key => $value) 
        {
            if (preg_match("#^$value$#", $uriGet)) 
            {
                $action = $this->_action[$key];
                $this->runAction($action, $db, $values);
                return; // Stop execution after finding the first match
            }
        }
        
        // Handle case where route is not found (optional)
        $this->handleNotFound();
    }

    // Method to run the action
    private function runAction($action, $db, $values) 
    {
        if ($action instanceof \Closure) 
        {
            $action();
        } 
        else 
        {
            $params = explode('@', $action);

            if (count($params) != 2) {
                throw new Exception('Invalid action format.');
            }

            $controller = $params[0];
            $method = $params[1];

            if (!class_exists($controller)) {
                throw new Exception("Controller $controller not found.");
            }

            $obj = new $controller($db);

            if (!method_exists($obj, $method)) {
                throw new Exception("Method $method not found in controller $controller.");
            }

            $obj->{$method}($values);
        }
    }

    // Optional method to handle routes not found
    private function handleNotFound() {
        http_response_code(403); // Código 403 para "Forbidden" (prohibido)
    }
}

?>
