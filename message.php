<?php include_once "db_open.php" ?>

<?php
	$val = json_decode(file_get_contents('php://input'),true);
	
	//var_dump($val);
	
	if($val['action'] == 'post')
	{
		$msg = $val['msg'];
		$user = $val['username'];
		$group = $val['groupid'];
		
		$receiver = "
					SELECT username
					FROM chatusers
					WHERE groupid = '$group'
					";
		
		$receiver = mysql_query($receiver);
		
		if($receiver===false)
			echo mysql_error();
			
		else
		{
			while($val = mysql_fetch_assoc($receiver))
			{
				if($val['username'] != NULL)
				{
					$val = $val['username'];
					
					$send = "
					INSERT INTO chatchit(senderid,receiverid, groupid, msg)
					VALUES('$user','$val', '$group', '$msg')
					";
					
					$send = mysql_query($send);
					
					if($send===false)
						echo mysql_error();
				}
			}
		}		
	}
	else if($val['action'] == 'retreive')
	{
		$user = $val['username'];
		$group = $val['groupid'];
		
		
		$getmsg = "
					SELECT msg, senderid, time
					FROM chatchit
					WHERE receiverid = '$user'
					AND groupid = '$group'
					ORDER BY time
					";
					
		$getmsg = mysql_query($getmsg);
		
		if($getmsg===false)
			echo mysql_error();
			
		else
		{
			while($val = mysql_fetch_assoc($getmsg))
			{
				$sender = $val['senderid'];
				$msg = $val['msg'];
				$time = $val['time'];
				
				
					echo "<br/> <b>$sender</b>: $msg";
					
				$delete = "
							DELETE FROM chatchit
							WHERE receiverid = '$user' 
							AND groupid = '$group' 
							AND time='$time'
							";
				$delete = mysql_query($delete);
		
				if($delete===false)
					echo mysql_error();
			}
		}
	}
	else
	{
		echo "You fucked up you pussy";
	}
?>

<?php include_once "db_close.php" ?>