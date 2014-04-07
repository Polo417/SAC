<?php

//~ echo $_GET["request_path"]."\n\n";
//~ $test = preg_match('satic', $_GET["request_path"], $matches );
$test = strpos( "_offset_".$_GET["request_path"] , 'static' );

if( ($test === false) || ($test === 0) )
{
	require_once "lib/routing.php";

	$route = route_for_request_path($_GET["request_path"]);

	route_to($route);
}
else
{
	//~ require $_GET["request_path"];
	include $_GET["request_path"];
}

?>

