<?php render_partial("admin.header", $params) ?>
<?php
// on teste si le visiteur a soumis le formulaire
if (isset($_POST['desinsc']) && $_POST['desinsc'] == 'Valider') { 
   // on teste l'existence de nos variables. On teste également si elles ne sont pas vides
   if ((isset($_POST['login']) && !empty($_POST['login']) && $_POST['login']!="admin")) { 
      
        try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
		}
		catch(Exception $e)
		{
		  die('Error : '.$e->getMessage());
		}
         mysql_select_db ('PASSWORD', $base); 
         
         // on recherche si ce login est déjà utilisé par un autre membre
         $sql = 'SELECT count(*) FROM Password WHERE id="'.mysql_escape_string($_POST['login']).'"'; 
         $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error()); 
         $data = mysql_fetch_array($req); 
 
         if ($data[0] == 1) { 
            
            $sql0 = 'SELECT appart FROM Password WHERE id="'.mysql_escape_string($_POST['login']).'"';
            $req0 = mysql_query($sql0) or die('Erreur SQL !<br />'.$sql0.'<br />'.mysql_error()); 
            $data0 = mysql_fetch_array($req0);
            
            $sql1 = 'DELETE FROM Password WHERE id ="'.mysql_escape_string($_POST['login']).'"'; 
            mysql_query($sql1) or die('Erreur SQL !'.$sql1.'<br />'.mysql_error()); 
            
            $_SESSION['appart'] = $data0['appart'];
            
            header('Location: /connect/admin/desinscriptionSac'); 
            exit();
            ob_flush(); 
            
         } 
         else { 
            $erreur = 'Membre inexistant!'; 
         } 
      
   } 
   else { 
      $erreur = 'Au moins un des champs est vide.'; 
   }  
}  
?>

			<div id="right">
				<div id="login">
					<form action="/connect/admin/desinscription" method="POST">
						<table>
							<tr>
								<td>Id:</td>
								<td>
									<input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>"/>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<input type="submit" name="desinsc" value="Valider" id="submit">
								</td>
							</tr>
						</table>
					</form>
				</div>
<?php 
				if (isset($erreur)) {
				echo "<p>".$erreur." </p>";}
?>
			</div>
		
			
		</div>
		
<?php render_partial("admin.footer", $params) ?>
