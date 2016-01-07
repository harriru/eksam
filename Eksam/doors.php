<?php
require_once('../config.php');
  if(isSet($_REQUEST["deleteid"])){
     $connection->prepare("DELETE FROM cards WHERE id=?")->
	    execute(array($_REQUEST["deleteid"]));
  }
  if(isSet($_REQUEST["text1"])){
    $connection->prepare(
      "INSERT INTO cards (username) VALUES (?)"
	  )->execute(array($_REQUEST["text1"]));
	header("Location: $_SERVER[PHP_SELF]");
	exit();
  }
  if(isSet($_REQUEST["update"])) {
  $connection->prepare("Update cards SET username=? WHERE id=?")-> 
  execute(array($_REQUEST["username"], $_REQUEST["modifysave"]));
  }
?>
<!doctype html>
<html>
  <head>
    <title>Näitan datat</title>
  </head>
  <body>
    <h1>kaardid</h1>
	<form action="?">
	   Username:    <input type="text" name="text1" />
	   
	   
	   <input type="submit" value="add data" />
	</form>
	<form action="?">
	<table>
	  <tr>
	    <th></th>
	    <th><a href="?sort=username">Username</a></th>
		
	  </tr>

	  

	  
<?php	    	   
$sortcolumn="username";
      
$result=$connection->query(
          "SELECT id, username FROM cards ORDER BY $sortcolumn");
       
	   while($row=$result->fetchObject()){
         echo "<tr>";
		 if(!empty($_REQUEST["modifystart"]) and
		 $_REQUEST["modifystart"]==$row->id) {
		 echo "<td>
		 <input type='hidden' name='modifysave' value='$row->id' />
		 <input type='submit' name='update' value='Update' />
		 <input type='submit' name='cancel' value='Cancel' />
		 
		 </td>";
		 echo "<td>
		 <input type='text' name='username' value='$row->username' /></td>
		  
		 </td>";
		 
		 } else { 
		 echo "<td><a href='?deleteid=$row->id' 
		     onclick='return confirm(\"tahad kustutada?\")'>x</a>
			 <a href='?modifystart=$row->id'>m</a></td>
		   <td>$row->username</td>";
		  
		
		}		
		 echo "</tr>";
      }



?>
	</form>
	</table>
  </body>
</html>