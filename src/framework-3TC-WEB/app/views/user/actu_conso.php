<?php render_partial("user.header", $params) ?>
<?php
	if (isset($_POST['quantite_demandee']) && $_POST['demande_transaction'] == 'Valider' && is_numeric($_POST['quantite_demandee']))
	{	
		try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
		}
		catch(Exception $e)
		{
		  die('Error : '.$e->getMessage());
		}
         mysql_select_db ('SAC', $base); 
       
       
        if (is_numeric($_POST['quantite_demandee'])==true)
		{
			$tableau_prod_unitaire = array("boite de conserve", "cannette", "paquet", "bouteille");
			
			$sql_unitaire = "SELECT etat FROM Produit WHERE nom_precis = '".mysql_escape_string($_POST['produit'])."'";
			$result_unitaire = mysql_query($sql_unitaire) or die('Erreur SQL !'.$sql_unitaire.'<br />'.mysql_error());
			$etat_pour_control = mysql_fetch_array($result_unitaire);
			
			if(in_array($etat_pour_control['etat'], $tableau_prod_unitaire) && ($_POST['quantite_demandee']-intval($_POST['quantite_demandee']) <> 0))
			{
				$erreur =  "Impossible ! Donnez une valeur entiere !";
			}
			elseif ($_POST['quantite_demandee'] > $_POST['quantite_dispo'])
			{
				$erreur =  "Impossible ! Quantité insuffisante !";
			}
			else
			{	
				if ($_POST['quantite_demandee'] > 0)
				{		
					 $vari = $_POST['quantite_dispo'] - $_POST['quantite_demandee'];
					 
					 $sql = " UPDATE Stock_dispo SET quantite_actuelle = ".mysql_real_escape_string($vari)." WHERE Stock_dispo.nom_produit = '".mysql_escape_string($_POST['produit'])."' ";
					 
					 try
					 {
						$req = mysql_query($sql) ;
					 }
					 catch(Exception $e)
					 {
					    die('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
					 }
					  
					 
					 $sql2 = ' SELECT quantite FROM Consommation WHERE num_appart='.$_SESSION['appart'].'	AND nom_produit like "'.mysql_escape_string($_POST['produit']).'"';
					 
					 $req2 = mysql_query($sql2) or die('Erreur SQL !'.$sql2.'<br />'.mysql_error());
					    
					 $data2 = mysql_fetch_array($req2);
					 
					 if ($data2==NULL)
					 {
						 $sql3 = " INSERT INTO Consommation VALUES (".$_SESSION['appart'].",'".mysql_escape_string($_POST['produit'])."',".mysql_escape_string($_POST['quantite_demandee']).")";
						 $req3 = mysql_query($sql3) or die('Erreur SQL !'.$sql3.'<br />'.mysql_error());   
						 
					 }
					 else
					 {
						 $var2 = $_POST['quantite_demandee'] + $data2[0];
						 $sql4 = " UPDATE Consommation SET quantite = ".mysql_real_escape_string($var2)." WHERE num_appart = ".$_SESSION['appart']." AND nom_produit = '".mysql_escape_string($_POST['produit'])."'";
						 $req4 = mysql_query($sql4) or die('Erreur SQL !'.$sql4.'<br />'.mysql_error());   

				 	 }
				}
				else if($_POST['quantite_demandee'] == 0)
				{
					$erreur = "C'est pas tres utile d'entrer une consommation nulle !";
				}
				else
				{
					$erreur =  "Erreur : Valeur négative entrée !";
				}
				
			}
		}
		else
		{
			$erreur = "Erreur : entrée invalide !";
		}
	}
	else
	{
		$erreur = 'Champ invalide!';
	}
			
?>

			<div id="right">
			<?php 
			if (isset($vari))
			{
				echo "<p>nom du produit : ".$_POST['produit'];
				echo "</p>";
				echo "<p>quantité désirée : ".$_POST['quantite_demandee'];
				echo "</p>";
				echo "<p>quantite disponible : ".$vari;
				echo "</p>";
			}
			
			?>
			</div>
<?php 
			if (isset($erreur)) {
			echo "<p>".$erreur." </p>";}
?>
		</div>
		
<?php render_partial("user.footer", $params) ?>
