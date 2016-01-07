<?php
require_once('../config.php'); 

  if(isSet($_REQUEST["deleteid"])){
     $connection->prepare("DELETE FROM rights WHERE id=?")->
	    execute(array($_REQUEST["deleteid"]));
  }
  if(isSet($_REQUEST["text1"])){
    $connection->prepare(
      "INSERT INTO rights (doorname, cardtype) VALUES (?, ?)"
	  )->execute(array($_REQUEST["text1"], $_REQUEST["text2"]));
	header("Location: $_SERVER[PHP_SELF]");
	exit();
  }
  if(isSet($_REQUEST["update"])) {
  $connection->prepare("Update rights SET doorname=?, cardtype=? WHERE id=?")-> 
  execute(array($_REQUEST["doorname"], $_REQUEST["cardtype"], $_REQUEST["modifysave"]));
  }
?>
<!doctype html>
<html>
  <head>
    <title>Displaying data</title>
  </head>
  <body>
    <h1>Cards access to doors</h1>
	<form action="?">
	  
	   Door Name: <select name="text1"> <?php $result=$connection->prepare("SELECT id, description FROM doors");
	   $result->execute(); 
	   while($row=$result->fetchObject()){
	     echo "<option value='$row->id'>$row->description</option>";
	   }
	   ?>
	   </select>
	   Card Type: <select name="text2"> <?php $result=$connection->prepare("SELECT id, username FROM cards");
	   $result->execute(); 
	   while($row=$result->fetchObject()){
	     echo "<option value='$row->id'>$row->username</option>";
	   }
	   ?>
	   </select>	  	   
	   <input type="submit" value="add data" />
	</form>
	




<form action="?">
	<table>
	  <tr>
	    <th></th>
	    <th><a href="?sort=doorname">Door Name</a></th>
	    <th><a href="?sort=cardtype">Card Type</a></th>		
	  </tr>




<?php	    	   
$sortcolumn="doorname";

	if(isSet($_REQUEST["sort"]) and $_REQUEST["sort"]=="cardtype"){
	                                          $sortcolumn="cardtype";}	   
		

$result=$connection->query(
          "SELECT id, doorname, cardtype FROM rights ORDER BY $sortcolumn");
       
	   while($row=$result->fetchObject()){
         echo "<tr>";
		 if(!empty($_REQUEST["modifystart"]) and
		 $_REQUEST["modifystart"]==$row->id) {
		 echo "<td>
		 <input type='hidden' name='modifysave' value='$row->id' />
		 <input type='submit' name='update' value='Update' />
		 <input type='submit' name='cancel' value='Cancel' />
		 
		 </td><td>";
		 
          ?>
		  <select name="doorname"> 
		  <?php $result2=$connection->prepare("SELECT id, description FROM doors");
	   $result2->execute(); 
	   while($row2=$result2->fetchObject()){
	     echo "<option value='$row2->id'>$row2->description</option>";
	   }
	   ?>
	   </select>	 
		 <?php 		   
		echo "</td><td>";
		 
		 ?>
		  <select name="cardtype"> 
		  <?php $result2=$connection->prepare("SELECT id, username FROM cards");
	   $result2->execute(); 
	   while($row2=$result2->fetchObject()){
	     echo "<option value='$row2->id'>$row2->username</option>";
	   }
	   ?>
	   </select>	 
<?php 		   
		echo "</td>";




		} else { 
		 echo "<td><a href='?deleteid=$row->id' 
		     onclick='return confirm(\"Do you want to delete?\")'>x</a>
			 <a href='?modifystart=$row->id'>m</a></td>
		   <td>$row->doorname</td><td>$row->cardtype</td>";
		}		
		 echo "</tr>";
      }
	  ?>

	</form>
	</table>
	</body>
	</html>