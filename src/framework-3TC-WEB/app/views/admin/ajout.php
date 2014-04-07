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
         
         $sql_requete = 'SELECT etat, unite FROM Mesure ORDER BY etat';
         $req_options = mysql_query($sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysql_error());
         $req_javascript = mysql_query($sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysql_error());      
      ?>
<?php
	echo "<script type=\"text/javascript\">\n";
	
	echo "\tfunction displayUnite()\n\t{\n";
	
	echo "\t\tnom=document.getElementById('etat_produit');\n";
	
	echo "\t\tunite_prix=document.getElementById('unite_produit_prix');\n\n";
	echo "\t\tunite_max=document.getElementById('unite_produit_max');\n\n";
	
	while($elem_javascript = mysql_fetch_array($req_javascript))
	{
		echo "\t\t\tif(nom.options[nom.selectedIndex].value==\"".$elem_javascript['etat']."\")\n\t\t\t{\n";
			
		echo "\t\t\t\tunite_prix.innerHTML=\"/".$elem_javascript['unite']."\";\n";
		echo "\t\t\t\tunite_max.innerHTML=\"".$elem_javascript['unite']."\";\n";
		echo "\n\t\t\t}\n";
	}
	
	echo "\t}\n";
	echo "</script>\n";
?>		
		
			<div id="right">
				<div id="login">
					<form action="/connect/admin/ajouter" method="POST">
							<table>
								<tr>
									<td>Nom precis du produit : </td>
									<td>
										<input type="text" name="nom" value="<?php if (isset($_POST['nom'])) echo htmlentities(trim($_POST['nom'])); ?>"/>
									</td>
								</tr>
								<tr>
									<td>Type/famille : </td>
									<td>
										<input type="text" name="type" value="<?php if (isset($_POST['type'])) echo htmlentities(trim($_POST['type'])); ?>"/>
									</td>
									<td>(ex : condiment, viande)</td>
								</tr>
								<tr>
									<td>Etat : </td>
									<td>
										<select name="etat" id="etat_produit" onchange="displayUnite()">
<?php
												$data= mysql_fetch_array($req_options);
												echo "\t\t\t\t\t\t\t<option value=\"".$data['etat']."\">".$data['etat']."</option> \n";
												//on isole la premiere fois pour adapter l'unite au premier qui sort
												$premiere_unite = $data['unite'];
												
												while ($data = mysql_fetch_array($req_options)) 
												{
													echo "\t\t\t\t\t\t\t<option value=\"".$data['etat']."\">".$data['etat']."</option> \n";
												}
?>
										</select>					
									</td>
									<td id='unite_produit_etat'></td>
								</tr>
								<tr>
									<td>Prix : </td>
									<td>
										<input type="text" name="prix" value="<?php if (isset($_POST['prix'])) echo htmlentities(trim($_POST['prix'])); ?>"/>
									</td>
									<td id='unite_produit_prix'><?php echo "/".$premiere_unite ;?> </td>
								</tr>
								<tr>
									<td>Quantite max : </td>
									<td>
										<input type="text" name="quantite" value="<?php if (isset($_POST['quantite'])) echo htmlentities(trim($_POST['quantite'])); ?>"/>
									</td>
									<td id='unite_produit_max'><?php echo $premiere_unite ;?> </td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td>
										<input type="submit" name="ajoutprod" value="Valider" id="submit">
									</td>
								</tr>
							</table>
						</form>
<?php 
					if (isset($erreur)) {
					echo "<p>".$erreur." </p>";}
?>
				</div>
			
			</div>
		</div>
<?php render_partial("admin.footer", $params) ?>
