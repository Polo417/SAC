<?php

require_once "conf/routes.php";

function route_for_request_path($path)
{
    $tableau = explode('/',$path); // pour parser les arguments


    if(count($tableau) == 1)
    {
		if ($tableau[0] == 'login') {
			$route = array("controller" => $tableau[0], "action" => "log",);
		}
		else if ($tableau[0] == 'admin') {
			$route = array("controller" => $tableau[0], "action" => "defaut",);
		}
		else if ($tableau[0] == 'user') {
			$route = array("controller" => $tableau[0], "action" => "defaut",);
		}
		else if ($tableau[0] == 'doc') {
			$route  = array("controller" => $tableau[0], "action" => "doc_technique",);
		}
    }
    else if(count($tableau) == 2)
    {
		$route = array("controller" => $tableau[0], "action" => $tableau[1],);
	}    
    else 
    {	
        $route = array("controller" => "login","action" => "log",);
    }

    return $route;
}

function route_to($route)
{
    $cont = $route["controller"];
    $cont_class = ucfirst("$cont"); 
    $controller_path = "app/controllers/$cont/$cont.php";
    
        if(file_exists($controller_path))
        {
			$action = $route["action"];
			require_once $controller_path;
			$class_instance = new $cont_class($route);
			if (method_exists($class_instance, $action))
			{
				$class_instance->$action($route);
			}
			else
			{
				$message = "$cont_class n'a pas de fonction $action";
				$class_instance->render_error("404", $message, $route);
			}
        }
       
        else 
        {
            echo "<br><br><h1>Page inexistante</h1>";
        } 
}
?>

