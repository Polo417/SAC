<?php render_partial("user.header", $params) ?>
<?php
		try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
		}
		catch(Exception $e)
		{
		  die('Error : '.$e->getMessage());
		}
         mysql_select_db ('SAC', $base); 
         //~ $sql_request = 'SELECT nom_produit, quantite_actuelle, quantite_max, unite FROM Stock_dispo, Produit, Mesure WHERE Stock_dispo.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat AND quantite_actuelle<>0  ORDER BY nom_produit';
         //~ $sql_request = 'SELECT nom_produit, quantite_actuelle, unite FROM Stock_dispo, Produit, Mesure WHERE Stock_dispo.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat AND quantite_actuelle<>0  ORDER BY nom_produit';
         $sql_request = 'SELECT nom_produit, quantite_actuelle, unite, prix_unite FROM Stock_dispo, Produit, Mesure WHERE Stock_dispo.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat AND quantite_actuelle<>0  ORDER BY nom_produit';

         $req_result = mysql_query($sql_request) or die('Erreur SQL !'.$sql_request.'<br />'.mysql_error());   

?>
			<div id="right">
				<table>
					<tr><td><h3>Produit&nbsp;&nbsp;</h3></td> <td><h3>Quantite actuelle</h3></td> <?php /*<td><h3>Quantite max</h3></td>*/ ?><td><h3>Prix à l'unité</h3></td></tr>
					<?php
					while ($ligne = mysql_fetch_array($req_result)) 
					{
						echo "\t\t\t\t<tr> ";
						//~ echo "<td>".$ligne['nom_produit'].":&nbsp;&nbsp; </td> <td>".$ligne['quantite_actuelle']." ".$ligne['unite']."&nbsp;&nbsp;</td> ";// <td>".$ligne['quantite_max']." ".$ligne['unite']. "&nbsp;&nbsp; </td> ";
						echo "<td><b>".ucfirst($ligne['nom_produit'])." :</b>&nbsp;&nbsp; </td> <td>".$ligne['quantite_actuelle']." ".$ligne['unite']."&nbsp;&nbsp;</td> <td>".$ligne['prix_unite']." €/".$ligne['unite']."</td>";// <td>".$ligne['quantite_max']." ".$ligne['unite']. "&nbsp;&nbsp; </td> ";
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
		
<?php render_partial("user.footer", $params) ?>
