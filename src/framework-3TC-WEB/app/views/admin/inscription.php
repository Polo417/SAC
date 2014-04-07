<?php render_partial("admin.header", $params) ?>
<?php
// on teste si le visiteur a soumis le formulaire
if (isset($_POST['newinsc']) && $_POST['newinsc'] == 'Valider') { 
   // on teste l'existence de nos variables. On teste également si elles ne sont pas vides
   if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['passwd']) && !empty($_POST['passwd'])) && (isset($_POST['conf_passwd']) && !empty($_POST['conf_passwd'])) && (isset($_POST['number']) && !empty($_POST['number'])) ) { 
      // on teste les deux mots de passe
      if ($_POST['passwd'] != $_POST['conf_passwd']) { 
         $erreur = 'Les 2 mots de passe sont différents.'; 
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
         $sql = 'SELECT count(*) FROM Password WHERE id="'.mysql_escape_string($_POST['login']).'" OR appart= " '.mysql_escape_string($_POST['number']).'"'; 
         $req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error()); 
         $data = mysql_fetch_array($req); 
 
         if ($data[0] == 0) { 
            $sql = 'INSERT INTO Password VALUES("'.mysql_escape_string($_POST['login']).'", "'.mysql_escape_string($_POST['number']).'", "'.mysql_escape_string(md5($_POST['passwd'])).'")'; 
            mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
            
            $_SESSION['appart'] = $_POST['number'];
            $_SESSION['nom'] = $_POST['name'];
 
            header('Location: /connect/admin/inscriptionSac'); 
            exit();
            ob_flush(); 
            
			 
         } 
         else { 
            $erreur = 'Un membre possède déjà ce login.'; 
         } 
      } 
   } 
   else { 
      $erreur = 'Au moins un des champs est vide.'; 
   }  
}  
?>

			<div id="right">
				<div id="login">
					<form action="/connect/admin/inscription" method="POST">
							<table>
								<tr>
									<td>Id : </td>
									<td>
										<input type="text" name="login" value="<?php if (isset($_POST['login'])) echo htmlentities(trim($_POST['login'])); ?>"/>
									</td>
								</tr>
								<tr>
									<td>Appartement number : </td>
									<td>
										<input type="text" name="number" value="<?php if (isset($_POST['number'])) echo htmlentities(trim($_POST['number'])); ?>"/>
									</td>
								</tr>
								<tr>
									<td>Nom : </td>
									<td>
										<input type="text" name="name" value="<?php if (isset($_POST['name'])) echo htmlentities(trim($_POST['name'])); ?>"/>
									</td>
								</tr>
								<tr>
									<td>Password : </td>
									<td>
										<input type="password" name="passwd" value="<?php if (isset($_POST['passwd'])) echo htmlentities(trim($_POST['passwd'])); ?>"/>
									</td>
								</tr>
								<tr>
									<td>Confirm password : </td>
									<td>
										<input type="password" name="conf_passwd" value="<?php if (isset($_POST['conf_passwd'])) echo htmlentities(trim($_POST['conf_passwd'])); ?>"/>
									</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
									<td><input type="submit" name="newinsc" value="Valider" id="submit"></td>
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
