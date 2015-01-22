<?php include_once "db_open.php" ?>

<?php
	$val = json_decode(file_get_contents('php://input'),true);
	
	//var_dump($val);
	
	if(isset($val['username'])) //find existing username in database
	{
		$user = $val['username'];
		
		$finduser ="
					SELECT username
					FROM chatusers
					WHERE username = '$user'
					";
		$finduser = mysql_query($finduser);
		if($finduser===false)
			echo mysql_error();
		if(mysql_fetch_assoc($finduser))
		{
			echo "You have been logged in as $user<br/>";
		}
		else
		{
			echo"No user found under the name $user, would you like to create an account?<br/>";
			echo "
					<td><input TYPE='button' VALUE='Yes' onclick='createuser(true)'/></td>
					<td><input TYPE='button' VALUE='No' onclick='createuser(false)'/></td>
			";
		}
	}
	else if(isset($val['requestname']))
	{
		$user = $val['requestname'];
		
		$setuser ="
				INSERT INTO chatusers(username)
				VALUES('$user')
				";
		$setuser = mysql_query($setuser);
		if($setuser===false)
			echo mysql_error();
		if($setuser)
		{
			echo "You have been logged in as $user. Welcome!<br/>";
			
		}
	}
	else
	{
		echo "You fucked up you pussy";
	}

	//DELETE FROM tablename WHERE stuff 
	
?>

<?php /*
					
	if($relationship2 == false)
		echo mysql_error();//outputs error message
	 
	//while($row=mysql_fetch_assoc[])//insert appropriate query here
		//{
			//$id = $row['id'];
			//$group = $row['group'];
			//echo "<option value=$id>$group</option>";
		//}*/
?>

<?php include_once "db_close.php" ?>