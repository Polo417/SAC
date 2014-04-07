<?php  
		try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
		}
		catch(Exception $e)
		{
		  die('Error : '.$e->getMessage());
		}
         mysql_select_db ('SAC', $base); 
         $sql = 'SELECT nom_produit, quantite_actuelle, quantite_max, unite FROM Stock_dispo, Produit, Mesure WHERE Stock_dispo.nom_produit = Produit.nom_precis AND Produit.etat = Mesure.etat ORDER BY Stock_dispo.nom_produit';
         $req = mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());   
         
         if (isset($_POST['reap']) && $_POST['reap'] == 'Reapprovisionner!') 
         { 
         
			 $sql2 = 'SELECT nom_produit, quantite_max FROM Stock_dispo ';
			 $req2 = mysql_query($sql2) or die('Erreur SQL !'.$sql2.'<br />'.mysql_error());
			 
			 while($data2 = mysql_fetch_array($req2)) 
			 {
				$sql3 = ' UPDATE Stock_dispo SET quantite_actuelle = ' .$data2['quantite_max'].' WHERE nom_produit="'.$data2['nom_produit'].'"';
				$req3 = mysql_query($sql3) or die('Erreur SQL !'.$sql3.'<br />'.mysql_error());
			 }
			 
			 $sqlfact = "DELETE FROM Consommation";
			 $reqfact = mysql_query($sqlfact) or die('Erreur SQL !'.$sqlfact.'<br />'.mysql_error());
		
			 header('Location: /connect/admin/reapprovisionner'); 
			 exit(); 
			 ob_flush();
		 }
		 $sqldel = 'SELECT nom_precis FROM Produit';
         $reqdel = mysql_query($sqldel) or die('Erreur SQL !'.$sqldel.'<br />'.mysql_error());   
		
		 if (isset($_POST['del']) && $_POST['del'] == 'Supprimer produit') 	
		 {
			 $del = "DELETE FROM Stock_dispo WHERE nom_produit='".$_POST['nom_precis']."'";
			 $rdel = mysql_query($del) or die('Erreur SQL !'.$del.'<br />'.mysql_error()); 
						 
			 header('Location: /connect/admin/reapprovisionner'); 
			 exit(); 
			 ob_flush();
		 }		 
?>
<?php render_partial("admin.header", $params); ?>
		<div id="right">
			<div id="clear">
				<table>
					<tr><td><h3>Produit&nbsp;&nbsp;</h3></td> <td><h3>Quantite actuelle</h3></td> <td><h3>Quantite max</h3></td></tr>
					<?php
					while ($data = mysql_fetch_array($req)) 
					{
						echo "\t\t\t\t<tr> ";
						echo "<td><b>".$data['nom_produit']."</b>&nbsp;&nbsp; </td> <td>".$data['quantite_actuelle']." ".$data['unite']."&nbsp;&nbsp;</td> <td>".$data['quantite_max']." ".$data['unite']. "&nbsp;&nbsp; </td> ";
						echo "</tr> \n";
					}
					?>
				</table>
				
			</div>
			
			<div id="clear">
				<form action="/connect/admin/reapprovisionner" method="POST" style="float:left;">
						<input type="submit" name="reap" value="Reapprovisionner!" id="submit">
				</form>
				<br>
				<br>
			</div>
			<br><br>
			<div id="clear">
				<form action="/connect/admin/reapprovisionner" method="POST" style="float:left;">
						<select name="nom_precis" id="select">
								<?php
									while ($datadel = mysql_fetch_array($reqdel)) 
									{
										echo '\t\t<option>'.$datadel['nom_precis'].'</option> \n';
									}
								?>
							</select>
							<br/>
						<input type="submit" name="del" value="Supprimer produit" id="submit">
				</form>
<?php 
				if (isset($erreur)) {
				echo "<p>".$erreur." </p>";}
?>
			</div>

		</div>
	</div>
		
		
<?php render_partial("admin.footer", $params) ?>
