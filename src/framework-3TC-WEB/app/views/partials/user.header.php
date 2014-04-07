<?php
	ob_start();
	session_start();  
	if (!isset($_SESSION['login'])) { 
	   header ('Location: /connect/login'); 
	   exit();  
	}  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>

<head>
	<meta charset="utf-8" />
	<?php //link_to_css("style.css") ?>
	<?php require_once "static/css/style.css" ?>
    <title>SAC - <?php echo $params["title"] ?></title>
</head>
<body>
	
	<div id="container">
		<div id="title_wrapper">
			<div id="title"><h1>SAC - Stock Alimentaire Commun</h1></div>
		</div>
		<div id="main">
			<div id="title"><h2>ESPACE MEMBRES</h2></div>
			<div>
				<form action="/connect/user" method="POST" style="float:left;">
								<input type="submit" name="home" value="Home" id="submit">
				</form>
				<form action="/connect/user/modif" method="POST" style="float:left;">
								<input type="submit" name="modif" value="New password" id="submit">
				</form>
				<form action="/connect/user/conso_actuelle" method="POST" style="float:left;">
								<input type="submit" name="conso_actuelle" value="Conso actuelle" id="submit">
				</form>
				<form action="/connect/user/new_conso" method="POST" style="float:left;">
								<input type="submit" name="new_conso" value="Nouvelle conso" id="submit">
				</form>
				<form action="/connect/user/stock_dispo" method="POST" style="float:left;">
								<input type="submit" name="stock_dispo" value="Stock dispo" id="submit">
				</form>
				<table id="tab">
					<tr>
						<td><?php echo htmlentities(trim($_SESSION['login'])); ?></td>
						<td><form action="/connect/login/deconnexion" method="POST">
								<input type="submit" name="deconnexion" value="Logout" id="submit">
							</form>
						</td>
					</tr>
				</table>
			</div>
