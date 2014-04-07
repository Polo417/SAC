<?php render_partial("login.header", $params) ?>
<?php $liste = $this->session_get("todo.items", array());?>
<?php
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Valider')
{ 
   if ((isset($_POST['usrId']) && !empty($_POST['usrId'])) && (isset($_POST['passwd']) && !empty($_POST['passwd'])))
   { 
      try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
	  }
	  catch(Exception $e)
	  {
		  die('Error : '.$e->getMessage());
	  }
	  mysql_select_db ('PASSWORD', $base);   
	  
	  
	  // GESTION DES CONNEXIONS GRACE A UNE TABLE MySQL
	  
	  $sql_requete_de_presence = 'SELECT count(*) FROM Password WHERE id="'.mysql_escape_string($_POST['usrId']).'" AND pswd="'.mysql_escape_string(MD5($_POST['passwd'])).'"'; 
	  $req_reponse_de_presence = mysql_query($sql_requete_de_presence) or die('Erreur SQL !<br />'.$sql_requete_de_presence.'<br />'.mysql_error()); 
	  $does_the_user_exist = mysql_fetch_array($req_reponse_de_presence);
	  
	  
	  $sql2_recup_info_perso = 'SELECT appart, id FROM Password WHERE id="'.mysql_escape_string($_POST['usrId']).'" AND pswd="'.mysql_escape_string(MD5($_POST['passwd'])).'"'; 
	  $req2_infos_perso = mysql_query($sql2_recup_info_perso) or die('Erreur SQL !<br />'.$sql2_recup_info_perso.'<br />'.mysql_error()); 
	  $data2_info_perso = mysql_fetch_array($req2_infos_perso); 
	  
	   
	  mysql_free_result($req_reponse_de_presence); 
	  mysql_free_result($req2_infos_perso); 
	  mysql_close(); 
	
	
	
	  if ($does_the_user_exist[0] == 1)
	  { 
		 session_start(); 
		 if ($data2_info_perso['id'] == 'admin')
		 {
			$_SESSION['login'] = $data2_info_perso['id']; 
			header('Location: /connect/admin'); 
		 }
		 else
		 {
			$_SESSION['appart'] = $data2_info_perso['appart'];
			$_SESSION['login'] = ucfirst($data2_info_perso['id']); 
			header('Location: /connect/user'); 
		 }
		 exit(); 
	  } 
	  elseif ($does_the_user_exist[0] == 0)
	  { 
		 $erreur = 'Compte non reconnu.'; 
	  } 
	  else
	  { 
		 $erreur = "Probème dans la base de données : plusieurs membres ont les mêmes identifiants de connexion: contactez l'administrateur."; 
	  } 
   } 
   else
   { 
      $erreur = 'Au moins un des champs est vide.'; 
   }  
}  
?>
			<div id="right">
				<div id="login">
					<form action="/connect/login" method="POST">
						<table>
							<tr>
								<td>
									User name : 
								</td>
								<td>
									<input type="text" name="usrId" value="<?php //if (isset($_POST['usrId'])) echo htmlentities(trim($_POST['usrId'])); ?>"/>
								</td>
							</tr>
							<tr>
								<td>
									Password :  
								</td>
								<td>
									<input type="password" name="passwd" value="<?php //if (isset($_POST['passwd'])) echo htmlentities(trim($_POST['passwd'])); ?>"/>
								</td>
							</tr>
							<tr> <td>&nbsp;</td></tr>
							<tr>
								<td>
									<input type="submit" name="connexion" value="Valider" id="submit">
								</td>
							</tr>
						</table>
					</form>
				</div>
				
<?php
		if (isset($erreur)) echo '<p>'.$erreur.'</p>';  
?>
			</div>
		</div>

		
<?php render_partial("login.footer", $params) ?>
