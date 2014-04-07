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
         $sql = 'SELECT Consommation.nom_produit, Consommation.quantite, Produit.prix_unite, Mesure.unite FROM Consommation, Produit, Mesure WHERE Consommation.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat AND Consommation.num_appart = '.$_SESSION['appart'].' ORDER BY Consommation.nom_produit';
         $req = mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());   


?>
			<div id="right">
				<table>
					<tr><td><h3>Produit&nbsp;&nbsp;</h3></td> <td><h3>Quantite consommee&nbsp;&nbsp;</h3></td> <td><h3>Prix</h3></td></tr>
<?php
					$total=0;
					while ($data = mysql_fetch_array($req)) 
					{
						$total = $total + $data['quantite']*$data['prix_unite'];
						echo "\t\t\t\t<tr> ";
						echo "<td>".$data['nom_produit']."&nbsp;&nbsp; </td> <td>".$data['quantite']." ".$data['unite']. "  </td> <td>".$data['quantite']*$data['prix_unite']." € </td> ";
						echo "</tr> \n";
						
					}
?>
				</table>
				<h3><?php echo "Total : ".$total. " €"; ?></h3>	
				
<?php 
				if (isset($erreur)) {
				echo "<p>".$erreur." </p>";}
?>
			</div>
			
		</div>
		
<?php render_partial("user.footer", $params) ?>
