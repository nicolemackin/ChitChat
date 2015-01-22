<?php include_once "db_open.php" ?>

<?php
	$val = json_decode(file_get_contents('php://input'),true);
	
	if(isset($val['groupid']))
	{
		$user = $val['username'];
		$group = $val['groupid'];
		
		$setgroup ="
					UPDATE chatusers
					SET groupid = '$group'
					WHERE username = '$user'
					";
		$setgroup = mysql_query($setgroup);
		
		if($setgroup===false)
			echo mysql_error();
		else
		{
			echo "Welcome to $group!";
		}
	}
	else if(isset($val['creategroup']))
	{
		$user = $val['username'];
		$group = $val['creategroup'];
		
		$findgroup ="
					SELECT groupid
					FROM chatusers
					WHERE groupid = '$group'
					";
		$findgroup = mysql_query($findgroup);
		if($findgroup===false)
			echo mysql_error();
		else
		{
			if(mysql_fetch_assoc($findgroup))
			{
				echo "This group already exists! Pick another name! <br/>";
				echo "
					<td> Create New Group: </td>
					<td> <input TYPE='TEXT' ID='creategroup' /></td>
					<td><input TYPE='SUBMIT' VALUE='Submit'/></td>
					";
			}
			else
			{
				$setgroup ="
						UPDATE chatusers
						SET groupid = '$group'
						WHERE username = '$user'
						";
				$setgroup = mysql_query($setgroup);
			
				if($setgroup===false)
					echo mysql_error();
				else
				{
					echo "Welcome to $group!";
				}	
			}
		}
		
	}
	else if($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		
		$getgroups ="
					SELECT DISTINCT groupid
					FROM chatusers
					ORDER BY groupid
					";//only selects each one once and displays them in alphabetical order
					
		$group = mysql_query($getgroups);
		
		if($group===false)
			echo mysql_error();
			
		else
		{
			echo "<option value='NULL'>Choose a group</option>";
			while($val = mysql_fetch_assoc($group))
			{
				if($val['groupid'] != NULL)
				{
					$val = $val['groupid'];
					echo "
					<option value='$val'>$val</option>
				";
				}
			}
		}
	}
	else
	{
		echo "You fucked up you pussy";
	}
	
	
?>

<?php include_once "db_close.php" ?>