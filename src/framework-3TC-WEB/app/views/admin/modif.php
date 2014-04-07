<?php render_partial("admin.header", $params) ?>
<?php
// on teste si le visiteur a soumis le formulaire
if (isset($_POST['newpswd']) && $_POST['newpswd'] == 'Valider') { 
   // on teste l'existence de nos variables. On teste également si elles ne sont pas vides
   if ((isset($_POST['oldpasswd']) && !empty($_POST['oldpasswd'])) && (isset($_POST['newpasswd']) && !empty($_POST['newpasswd'])) && (isset($_POST['conf_passwd']) && !empty($_POST['conf_passwd'])) ) { 
      // on teste les deux mots de passe
      if ($_POST['newpasswd'] != $_POST['conf_passwd']) { 
         $erreur = 'Les 2 nouveaux mots de passe sont différents.'; 
      } 
      else { 
        try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
		}
		catch(Exception $e)
		{
		  die('Error : '.$e->getMessage());
		}
         mysql_select_db ('PASSWORD', $base); 
         
         // on recherche si ce login est déjà utilisé par un autre membre
         $sql = 'SELECT count(*) FROM Password WHERE pswd="'.mysql_escape_string(md5($_POST['oldpasswd'])).'" AND id="'.$_SESSION['login'].'"'; 
         $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error()); 
         $data = mysql_fetch_array($req); 
 
         if ($data[0] == 1) { 
            $sql = 'UPDATE Password SET pswd="'.mysql_escape_string(md5($_POST['newpasswd'])).'" WHERE id="'.$_SESSION['login'].'"'; 
            mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
 
            header('Location: /connect/admin'); 
            exit(); 
            ob_flush();
         } 
         else { 
            $erreur = 'Wrong Old Password.'; 
         } 
      } 
   } 
   else { 
      $erreur = 'Au moins un des champs est vide.'; 
   }  
}  
?>

		<div style="clear:both;">
			<form action="/connect/admin/modif" method="POST">
					<table>
						<tr>
							<td>
								Old password:  
							</td>
							<td>
								<input type="password" name="oldpasswd" value="<?php if (isset($_POST['oldpasswd'])) echo htmlentities(trim($_POST['passwd'])); ?>"/>
							</td>
						</tr>
						<tr>
							<td>
								New password:  
							</td>
							<td>
								<input type="password" name="newpasswd" value="<?php if (isset($_POST['newpasswd'])) echo htmlentities(trim($_POST['passwd'])); ?>"/>
							</td>
						</tr>
						<tr>
							<td>
								Confirm new password:  
							</td>
							<td>
								<input type="password" name="conf_passwd" value="<?php if (isset($_POST['conf_passwd'])) echo htmlentities(trim($_POST['conf_passwd'])); ?>"/>
							</td>
						</tr>

						<tr>
							<td>
								<input type="submit" name="newpswd" value="Valider">
							</td>
						</tr>
					</table>
				</form>
		</div>
		<div>
			<?php 
			if (isset($erreur)) {
			echo "<p>".$erreur." </p>";}?>
		</div>
		
<?php render_partial("admin.footer", $params) ?>
