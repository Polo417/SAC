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
         
         if(isset($_POST['nom']))
         {
			$nom_nouveau_produit = strtolower($_POST['nom']);
		 }
         if(isset($_POST['type']))
         {
			$nom_type = strtolower($_POST['type']);
		 }
		 
         $sql_requete 		= 'SELECT etat, unite FROM Mesure ORDER BY etat';
         $req_options	 	= mysql_query($sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysql_error());
         $req_javascript 	= mysql_query($sql_requete) or die('Erreur SQL !'.$sql_requete.'<br />'.mysql_error());   
         
         if (isset($_POST['ajoutprod']) && $_POST['ajoutprod'] == 'Valider') 
         { 
			 if  (isset($nom_nouveau_produit) && !empty($nom_nouveau_produit) && isset($_POST['prix']) && !empty($_POST['prix']) && isset($_POST['quantite']) && !empty($_POST['quantite']) && is_numeric($_POST['quantite']) && is_numeric($_POST['prix']) )
			 {
				 $sql2_verification_existance = ' SELECT count(*) FROM Stock_dispo WHERE nom_produit="'.mysql_escape_string($nom_nouveau_produit).'"';
				 $req2_verification_existance = mysql_query($sql2_verification_existance) or die('Erreur SQL !'.$sql2_verification_existance.'<br />'.mysql_error());  
				 $data2_verification_existance = mysql_fetch_array($req2_verification_existance);
				 
				 if ($data2_verification_existance[0] == 0)
				 {
					 $sql0_effectuer_ajout = ' SELECT count(*) FROM Produit WHERE nom_precis="'.mysql_escape_string($nom_nouveau_produit).'"';
					 $req0_effectuer_ajout = mysql_query($sql0_effectuer_ajout) or die('Erreur SQL !'.$sql0_effectuer_ajout.'<br />'.mysql_error()); 
					 $data0_control_champs_a_ajouter = mysql_fetch_array($req0_effectuer_ajout);
					 
					 if ($data0_control_champs_a_ajouter[0] == 0) 
					 {
					 	 
						 if (isset($nom_type) && !empty($nom_type))
						 {
							 $sql3_action_ajout = " INSERT INTO Produit VALUES ('".mysql_escape_string($nom_nouveau_produit)."','".mysql_escape_string($nom_type)."','".mysql_escape_string($_POST['etat'])."',".mysql_escape_string($_POST['prix']).")";
							 $req3_control = mysql_query($sql3_action_ajout) or die('Erreur SQL !'.$sql3_action_ajout.'<br />'.mysql_error());  
						 }
						 else
						 {
							 $sql3_action_ajout = " INSERT INTO Produit VALUES ('".mysql_escape_string($nom_nouveau_produit)."','','".mysql_escape_string($_POST['etat'])."',".mysql_escape_string($_POST['prix']).")";
							 $req3_control = mysql_query($sql3_action_ajout) or die('Erreur SQL !'.$sql3_action_ajout.'<br />'.mysql_error());  
						 }
					 }
					 else
					 {
						 if (isset($nom_type) && !empty($nom_type))
						 {
							 $sql6_ajout_avec_famille_denre = " UPDATE Produit SET famille_denree = '".mysql_escape_string($nom_type)."', etat = '".mysql_escape_string($_POST['etat'])."', prix_unite = ".mysql_escape_string($_POST['prix'])." WHERE nom_precis = ".mysql_escape_string($nom_nouveau_produit);
							 $req6_control_action = mysql_query($sql6_ajout_avec_famille_denre) or die('Erreur SQL !'.$sql6_ajout_avec_famille_denre.'<br />'.mysql_error());  
						 }
						 else
						 {
							 $sql6_ajout_sans_famille_denre = " UPDATE Produit SET etat = '".mysql_escape_string($_POST['etat'])."', prix_unite = ".mysql_escape_string($_POST['prix'])." WHERE nom_precis = ".mysql_escape_string($nom_nouveau_produit);
							 $req6_control_action = mysql_query($sql6_ajout_sans_famille_denre) or die('Erreur SQL !'.$sql6_ajout_sans_famille_denre.'<br />'.mysql_error());  
						 }
						 
					 }
					 
					 $sql4_insert_stock_dispo = " INSERT INTO Stock_dispo VALUES ('".mysql_escape_string($nom_nouveau_produit)."',".mysql_escape_string($_POST['quantite']).",".mysql_escape_string($_POST['quantite']).")";
					 $req4_control_de_retour = mysql_query($sql4_insert_stock_dispo) or die('Erreur SQL !'.$sql4_insert_stock_dispo.'<br />'.mysql_error());  
					 
					 $_SESSION['last_entry']=$nom_nouveau_produit;
					 
				 }
				 else
				 {
					 $erreur = 'Le produit existe deja!';
				 }
			 
			 }
			 else
			 {
				 $erreur = 'les champs Nom precis, Quantite max et Prix sont obligatoires!';
			 }
			
         
		 }
		 
		 if (isset($_POST['undo']) && $_POST['undo'] == 'Effacer la derniere entree' && isset($_SESSION['last_entry']))
		 {
			 $sqldel = "DELETE FROM Stock_dispo WHERE nom_produit='".$_SESSION['last_entry']."'";
			 $reqdel_control = mysql_query($sqldel) or die('Erreur SQL !'.$sqldel.'<br />'.mysql_error()); 
			 $sqldel2 = "DELETE FROM Produit WHERE nom_precis='".$_SESSION['last_entry']."'";
			 $reqdel2_control = mysql_query($sqldel2) or die('Erreur SQL !'.$sqldel2.'<br />'.mysql_error());
			 unset($_SESSION['last_entry']);
			 header('Location: /connect/admin/ajouter'); 
			 exit();
			 ob_flush();
		 }
		 
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
				<div id="login"></div>
					<form action="/connect/admin/ajouter" method="POST">
							<table>
								<tr>
									<td>Nom precis du produit : </td>
									<td>
										<input type="text" name="nom" value="<?php if (isset($nom_nouveau_produit)) echo htmlentities(trim($nom_nouveau_produit)); ?>"/>
									</td>
								</tr>
								<tr>
									<td>Type/famille : </td>
									<td>
										<input type="text" name="type" value="<?php if (isset($nom_type)) echo htmlentities(trim($nom_type)); ?>"/>
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
						<form action="/connect/admin/ajouter" method="POST">
							<input type="submit" name="undo" value="Effacer la derniere entree" id="submit">
						</form>
<?php 
					if (isset($erreur)) {
					echo "<p>".$erreur." </p>";}
?>
				</div>
			
			</div>
		</div>
		
<?php render_partial("admin.footer", $params) ?>
