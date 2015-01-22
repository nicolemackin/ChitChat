<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ChitChat</title>
</head>

<link rel="stylesheet" type="text/css" href="chitchat.css">

<body>

<script>

// if username is picked, checks groups
function findgroupid()
{	
	var req = new XMLHttpRequest();
	req.open("GET", "groupid.php");
	req.send();
	req.onreadystatechange = function(){
		if (req.readyState != 4) 
			return;
		if (req.status != 200) 
			console.log("Error!");
		console.log(req.responseText);
		var replace = document.getElementById("existinggroups");
		replace.innerHTML = req.responseText;
	}
}

function getgroupid()
{	
	var groupid = document.getElementById('existinggroups').value;
	window.groupid = groupid;
	var string = JSON.stringify({groupid: groupid,username:username});
	var req = new XMLHttpRequest();
	req.open("POST", "groupid.php");
	req.setRequestHeader("Content-Type", "application/json");
	req.send(string);
	req.onreadystatechange = function(){
		if (req.readyState != 4) 
			return;
		if (req.status != 200) 
			console.log("Error!");
		console.log(req.responseText);
		var replace = document.getElementById("groups");
		replace.innerHTML = req.responseText;
		setInterval(gettxt, 1000);
	}
}

function creategroupid()
{	
	var creategroup = document.getElementById('creategroup').value;
	window.groupid = groupid;
	var string = JSON.stringify({creategroup: creategroup,username:username});
	var req = new XMLHttpRequest();
	req.open("POST", "groupid.php");
	req.setRequestHeader("Content-Type", "application/json");
	req.send(string);
	req.onreadystatechange = function(){
		if (req.readyState != 4) 
			return;
		if (req.status != 200) 
			console.log("Error!");
		console.log(req.responseText);
		var replace = document.getElementById("groups");
		replace.innerHTML = req.responseText;
		setInterval(gettxt, 1000);
	}
}

function usernamesearch() //searches for existing username
{
	var username = document.getElementById("username").value;
	window.username = username;
	var string = JSON.stringify({username: username});
	var req = new XMLHttpRequest();
	req.open("POST", "ajax.php");
	req.setRequestHeader("Content-Type", "application/json");
	req.send(string);
	req.onreadystatechange = function(){
		if (req.readyState != 4) 
			return;
		if (req.status != 200) 
			console.log("Error!");
		console.log(req.responseText);
		var replace = document.getElementById("nametr");
		replace.innerHTML = req.responseText;
		findgroupid();
	}
}

function createuser(hamlet) //checks to see if user wants to use this name
{
	if(hamlet)
	{
		var string = JSON.stringify({requestname: username});
		var req = new XMLHttpRequest();
		req.open("POST", "ajax.php");
		req.setRequestHeader("Content-Type", "application/json");
		req.send(string);
		req.onreadystatechange = function(){
			if (req.readyState != 4) 
				return;
			if (req.status != 200) 
				console.log("Error!");
			console.log(req.responseText);
			var replace = document.getElementById("nametr");
			replace.innerHTML = req.responseText;
			findgroupid();
		}
	}
	else
	{ // if user choses not to, page reloads
		location.reload();
	}
	
}

function submittxt() //submits text to group
{
	var msg = document.getElementById('chat').value;
	var string = JSON.stringify({action:'post',msg:msg, username:username, groupid:groupid});
	var req = new XMLHttpRequest();
	req.open("POST", "message.php");
	req.setRequestHeader("Content-Type", "application/json");
	req.send(string);
	req.onreadystatechange = function(){
		if (req.readyState != 4) 
			return;
		if (req.status != 200) 
			console.log("Error!");
		console.log(req.responseText);
		var replace = document.getElementById("chatdisplay");
		replace.innerHTML += req.responseText;
		document.getElementById("chattxt").value = "";
	}
}

function gettxt() //submits text to group
{
	var string = JSON.stringify({action:'retreive', username:username, groupid:groupid});
	var req = new XMLHttpRequest();
	req.open("POST", "message.php");
	req.setRequestHeader("Content-Type", "application/json");
	req.send(string);
	req.onreadystatechange = function(){
		if (req.readyState != 4) 
			return;
		if (req.status != 200) 
			console.log("Error!");
		console.log(req.responseText);
		var replace = document.getElementById("chatdisplay");
		replace.innerHTML += req.responseText;
	}
}
</script>

<!--login user-->
<h1>CHIT CHAT</h1>

<div id='login'>
<form onsubmit="event.preventDefault(); usernamesearch();">
  <table border="0">
	<tr id="nametr">
        <td> Username: </td>
    	<td> <input TYPE="TEXT" ID="username"/></td>
    	<td><input TYPE="SUBMIT" VALUE="Submit"/></td>
    </tr>
   </table>
</form> 
	<br/>
<form onsubmit="event.preventDefault(); getgroupid()">
    <table id='groups'>
    <tr>
    	<td>Group:</td>
    	<td>
        <select id="existinggroups">
	    </select>
		</td>
    	<td><input TYPE="SUBMIT" VALUE="Submit"/></td>
    </tr>
</form>
    
<form onsubmit="event.preventDefault(); creategroupid();">
     <tr>
    	<td> Create New Group: </td>
    	<td> <input TYPE="TEXT" ID="creategroup" /></td>
    	<td><input TYPE="SUBMIT" VALUE="Submit"/></td>
    </tr> 

</table>
</form>
</div>
<!-- If user is logged in -->
<br/><br/>

<div id="chatzone">
<table id= 'chatdisplay'>
</table>
<table id= 'chatinput'>
    <form id="chattxt" onsubmit="event.preventDefault(); submittxt();">
    <tr>
    	<td> <input TYPE="TEXT" ID="chat" /></td>
    	<td><input TYPE="SUBMIT" VALUE="Submit"/></td>
    </tr>
    </form>
</table>
</div>

</body>
</html>