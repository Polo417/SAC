<?php

require_once "lib/controller.php";

class Admin extends BaseController
{
	    
    public function admin($route)
    {
		$header_file = $route["controller"];
		$header_file = "$header_file.header";
		$params = array("title" => "ADMIN",);
		mise_en_forme($header_file, $params);
    }
    
    public function defaut($route)
    {
		$this->render_view("admin", array("title" => "Connect","tache" => $this->session_get("tache", array())));
	}
	
    public function inscription($route)
    {		
		$this->render_view("inscription", array("title" => "Inscription","tache" => $this->session_get("tache", array())));	
    }
    
    public function inscriptionSac($route)
    {		
		$this->render_view("inscriptionSac", array("title" => "Inscription","tache" => $this->session_get("tache", array())));	
    }
    
    public function desinscription($route)
    {
		$this->render_view("desinscription", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function desinscriptionSac($route)
    {
		$this->render_view("desinscriptionSac", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    
    public function deconnexion($route)
    {
		$this->render_view("deconnexion", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function modif($route)
    {
		$this->render_view("modif", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function list_user($route)
    {
		$this->render_view("list_user", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function ajout($route)
    {
		$this->render_view("ajout", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function ajouter($route)
    {
		$this->render_view("ajouter", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function reapprovisionner($route)
    {
		$this->render_view("reapprovisionner", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
    
    public function stock_dispo($route)
    {
		$this->render_view("stock_dispo", array("title" => "Connect","tache" => $this->session_get("tache", array())));	
    }
}

?>
