<?php require_once('../config.php'); ?>
<!doctype html>
<html>
  <head>
     <title>used ja võtmed</title>
  </head>
  <body>
    <form>

	   Please, choose the door: <br />
	   <select name="text1"> <?php $result=$connection->prepare("SELECT id, description as description FROM doors");
	   $result->execute(); 
	   while($row=$result->fetchObject()){
	     echo "<option value='$row->id'>$row->description</option>";
	   }
	   ?>
	   </select><br />

	   Please, insert your Card id:<br />
	  <select name="text2"> <?php $result=$connection->prepare("SELECT id, username as username FROM cards");
	   $result->execute(); 
	   while($row=$result->fetchObject()){
	     echo "<option value='$row->id'>$row->username</option>";
	   }


	   ?>
	   </select><br />

	   
	   <input type="submit" name="acsess" value="Request" />
	</form>
 <?php if(isSet($_REQUEST["acsess"])){
     $connection->prepare(
      "SELECT rights (doorname, cardtype) VALUES (?, ?)")->
      execute(array($_REQUEST["text1"], $_REQUEST["text2"]));
     echo "You can enter the door";
  } else {
     echo "You can't enter the door";
  }
  ?>
</body>
</html>