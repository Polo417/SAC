<?php
	 ob_start();
	session_start();  
	if (!isset($_SESSION['login'])) { 
	   header ('Location: /connect/login'); 
	   exit();
	} ?>
<!DOCTYPE HTML> 

<html>

<head>
	<meta charset="utf-8" />
	<?php //link_to_css("style.css") ?>
	<?php include "static/css/style.css" ?>
	
    <title>SAC - <?php echo $params["title"] ?></title>
</head>
<body>
	
	<div id="container">
		<div id="title_wrapper">
			<div id="title"><h1>SAC - Stock Alimentaire Commun</h1></div>
		</div> 
		<div id="main">
			<div id="title"><h2>ESPACE ADMIN</h2></div>
			<div> 
				<form action="/connect/admin" method="POST" style="float:left;">
								<input type="submit" name="home" value="Home" id="submit">
				</form>
				<form action="/connect/admin/inscription" method="POST" style="float:left;">
								<input type="submit" name="inscription" value="Nouvel utilisateur" id="submit">
				</form>
				<form action="/connect/admin/desinscription" method="POST" style="float:left;">
								<input type="submit" name="desinscription" value="Supprimer utilisateur" id="submit">
				</form>
				<form action="/connect/admin/list_user" method="POST" style="float:left;">
								<input type="submit" name="list_user" value="Afficher utilisateurs" id="submit">
				</form>
				<form action="/connect/admin/ajout" method="POST" style="float:left;">
								<input type="submit" name="ajout" value="Ajouter nouveau produit" id="submit">
				</form>
				<form action="/connect/admin/reapprovisionner" method="POST" style="float:left;">
								<input type="submit" name="reapprovisionner" value="Reapprovisionner" id="submit">
				</form>
				<form action="/connect/admin/stock_dispo" method="POST" style="float:left;">
								<input type="submit" name="stock_dispo" value="Stock actuel" id="submit">
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
