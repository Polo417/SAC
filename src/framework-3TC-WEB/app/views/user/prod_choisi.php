<?php render_partial("user.header", $params) ?>
<?php
	if ($_POST['produit'] && $_POST['choix_produit'] == 'Valider' )
	{		
		try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
		}
		catch(Exception $e)
		{
		  die('Error : '.$e->getMessage());
		}
         mysql_select_db ('SAC', $base); 
         
         $sql = 'SELECT quantite_actuelle, unite FROM Stock_dispo, Produit, Mesure WHERE nom_produit = "'.mysql_escape_string($_POST['produit']).'" AND Stock_dispo.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat ';
         $req = mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());   
		 $data = mysql_fetch_array($req);
	 }
	 else
	 {
		$erreur = 'Champ vide !'; 
	 }
?>

			<div id="right">
				<p><?php echo 'Il reste ';
				echo $data['quantite_actuelle']." ".$data['unite'];
				echo ' de '.$_POST['produit'].' en stock.';		
				?></p>
				<div id="login">
					<form method="POST" action="/connect/user/actu_conso">
						<h4 id="no_pad">Quelle quantité désirez-vous retirer ?</h4>
						<input type="text" name="quantite_demandee" />
						<input type="hidden" name="produit" value= "<?php echo $_POST['produit']; ?>"/>
						<input type="hidden" name="quantite_dispo" value= "<?php echo $data['quantite_actuelle']; ?>"/>		
						<input type="submit" name="demande_transaction" value="Valider" id="submit">
					</form>
				</div>
<?php 
				if (isset($erreur)) {
				echo "<p>".$erreur." </p>";}
?>
			</div>
		</div>
		
<?php render_partial("user.footer", $params) ?>
