<?php

function render_partial($name, $params)
{
    require_once "app/views/partials/".$name.".php";
}

function link_to_css($name)
{
	//global $BASE_URL;
    echo '<link href="/static/css/'.$name.'" type="text/css" rel="stylesheet" media="screen"/>';
    echo "\n";
}

function mise_en_forme($name, $params)
{
	render_partial($name, $params);
}

class BaseController
{
    function __construct()
    {
        session_start();
    }
    
    function clear_session()
    {
        $_SESSION = array();
        session_destroy();
    }
    
    function session_set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    function session_get($key, $default)
    {
        if (isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return $default;
        }
    }
    
    function render_view($viewname, $params)
    {
        $classname = get_class($this);
        $contname = strtolower($classname);
        $viewf = "app/views/$contname/$viewname.php";
        if (file_exists($viewf))
        {
            require_once($viewf);
        }
        else
        {
            $msg = "$classname n'a pas de view $viewname";
            $this->render_error("404", $msg, $params);
        }
    }
    
    function render_error($http_status, $message, $context_map)
    {
        header("HTTP/1.1 $http_status $message");
        header("Status: $http_status $message");
        require_once "static/html/error.php";
    }
    
    function redirect_to($url)
    {
        header("Location: $url");
        exit;
    }
}

?>
