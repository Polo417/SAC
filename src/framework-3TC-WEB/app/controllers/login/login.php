<?php

require_once "lib/controller.php";

class Login extends BaseController
{
	    
    public function login($route)
    {
		$header_file = $route["controller"];
		$header_file = "$header_file.header";
		$params = array("title" => "LOGIN",);
		mise_en_forme($header_file, $params);
    }
    
    public function log($route)
    {
		$this->render_view("login", array("title" => "Connect","tache" => $this->session_get("tache", array())));
	}
    
    public function deconnexion($route)
    {
		$this->render_view("deconnexion", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
}

?>
