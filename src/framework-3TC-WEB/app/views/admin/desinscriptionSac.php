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
         
         if (isset($_SESSION['appart']))
         {
			 $sql = " DELETE FROM Info_interne WHERE num_appart = ".$_SESSION['appart'];
			 $req = mysql_query($sql) or die('Erreur SQL !'.$sql.'<br />'.mysql_error());  
			 
		 }
         else
         {
			 $erreur = ' Erreur variable session ';
		 }
		
		 unset($_SESSION['appart']);
         
		 
		 header('Location: /connect/admin/list_user'); 
         exit();
         ob_flush();
?>

		<div style="clear:both;">
			<?php 
			if (isset($erreur)) {
			echo "<p>".$erreur." </p>";}?>
		</div>
		
<?php render_partial("admin.footer", $params) ?>
