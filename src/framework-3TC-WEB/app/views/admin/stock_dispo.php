<?php render_partial("admin.header", $params) ?>
<?php
		try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
		}
		catch(Exception $e)
		{
		  die('Error : '.$e->getMessage());
		}
         mysql_select_db ('SAC', $base); 
         //~ $sql = 'SELECT nom_produit, quantite_actuelle, quantite_max, unite FROM Stock_dispo, Produit, Mesure WHERE Stock_dispo.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat AND quantite_actuelle<>0 ORDER BY Stock_dispo.nom_produit';
         //~ $sql = 'SELECT nom_produit, quantite_actuelle, quantite_max, unite FROM Stock_dispo, Produit, Mesure WHERE Stock_dispo.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat ORDER BY Stock_dispo.nom_produit';
         $sql_requete = 'SELECT nom_produit, quantite_actuelle, quantite_max, unite, prix_unite FROM Stock_dispo, Produit, Mesure WHERE Stock_dispo.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat ORDER BY Stock_dispo.nom_produit';
         $req_result = mysql_query($sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysql_error());   

?>

		<div id="clear">
			<table>
				<tr><td><h3>Produit&nbsp;&nbsp;</h3></td> <td><h3>Quantite actuelle</h3></td> <td><h3>Quantite max</h3></td><td><h3>Prix à l'unité</h3></td></tr>
				<?php
				while ($ligne = mysql_fetch_array($req_result)) 
				{
					echo "\t\t\t\t<tr> ";
					//~ echo "<td>".$data['nom_produit']."&nbsp;&nbsp; </td> <td>".$data['quantite_actuelle']." ".$data['unite']."&nbsp;&nbsp;</td> <td>".$data['quantite_max']." ".$data['unite']. "&nbsp;&nbsp; </td> ";
					echo "<td><b>".ucfirst($ligne['nom_produit'])."</b>&nbsp;&nbsp; </td> <td>".$ligne['quantite_actuelle']." ".$ligne['unite']."&nbsp;&nbsp;</td> <td>".$ligne['quantite_max']." ".$ligne['unite']. "&nbsp;&nbsp </td><td>".$ligne['prix_unite']." €/".$ligne['unite']."</td>";
					echo "</tr> \n";
				}
				?>
			</table>
<?php 
			if (isset($erreur)) {
			echo "<p>".$erreur." </p>";}
?>
		</div>
					
	</div>
		
<?php render_partial("admin.footer", $params) ?>
