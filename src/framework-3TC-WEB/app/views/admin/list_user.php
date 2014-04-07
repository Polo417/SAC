<?php render_partial("admin.header", $params) ?>
<?php
        try {
		  $base = mysql_connect('localhost:3306:/tmp/mysqld.sock','root',''); 
		}
		catch(Exception $e)
		{
		  die('Error : '.$e->getMessage());
		}
         mysql_select_db ('PASSWORD', $base); 
 
         $sql2 = 'SELECT id, appart FROM Password WHERE id<>"admin" ORDER BY appart'; 
         $req2 = mysql_query($sql2) or die('Erreur SQL !'.$sql2.'<br />'.mysql_error()); 
?>

			<div id="right">
				<table>
					<tr><td><h3>ID&nbsp;&nbsp;</h3></td> <td><h3>Appartement</h3></td></tr>
					<?php  while ($data2 = mysql_fetch_array($req2)) 
					{
						echo "\t\t\t\t<tr> ";
						echo "<td>".$data2['id']."&nbsp;&nbsp; </td> <td>".$data2['appart']."</td> ";
						echo "</tr> \n";
					}		
					?>	
				</table>	
<?php 
				if (isset($erreur)) {
				echo "<p>".$erreur." </p>";}
?>
			</div>

		</div>
		
<?php render_partial("admin.footer", $params) ?>
