<?php

require_once "lib/controller.php";

class Doc extends BaseController
{
	    
    public function doc($route)
    {
		$params = array("title" => "DOC TECHNIQUE",);
    }
    
    public function doc_technique($route)
    {
		require_once "doc_technique.html";
	}
    
}

?>
