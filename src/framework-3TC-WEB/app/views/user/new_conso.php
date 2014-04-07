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
         
         $sql = 'SELECT nom_produit FROM Stock_dispo WHERE quantite_actuelle != 0 ORDER BY nom_produit';
         $req = mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());   

?>
			<div id="right">
				<div id="login">
					<form method="POST" action="/connect/user/prod_choisi">
						<select name="produit" id="select">
						<?php
							while ($data = mysql_fetch_array($req)) 
							{
								echo "\t\t<option>".$data['nom_produit']."</option>\n";
							}
						?>
						</select>
						<input type="submit" name="choix_produit" value="Valider" id="submit">
					</form>
					
				</div>
<?php 
					if (isset($erreur)) {
					echo "<p>".$erreur." </p>";}
?>
			</div>
		</div>
		
<?php render_partial("user.footer", $params) ?>
