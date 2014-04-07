<?php

require_once "lib/controller.php";

class User extends BaseController
{
	    
    public function user($route)
    {
		$header_file = $route["controller"];
		$header_file = "$header_file.header";
		$params = array("title" => "USER",);
		mise_en_forme($header_file, $params);
    }
    
    public function defaut($route)
    {
		$this->render_view("user", array("title" => "Connect","tache" => $this->session_get("tache", array())));
	}
	
    public function modif($route)
    {		
		$this->render_view("modif", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function conso_actuelle($route)
    {
		$this->render_view("conso_actuelle", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function new_conso($route)
    {
		$this->render_view("new_conso", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function stock_dispo($route)
    {
		$this->render_view("stock_dispo", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function prod_choisi($route)
    {
		$this->render_view("prod_choisi", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
     public function actu_conso($route)
    {
		$this->render_view("actu_conso", array("title" => "Connect","tache" => $this->session_get("tache", array())));
	}
    
    public function deconnexion($route)
    {
		$this->render_view("deconnexion", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
}

?>
