<?php 

	switch ($_POST['username']) {
		case "administrateur":
			if($_POST['password'] == "admin")
				$url = "index.php?EX=logadmin";
			else
				$url = "index.php?EX=failLog";
			break;
		case "adminquest":
			if($_POST['password'] == "quest")
				$url = "index.php?EX=logquest";
			else
				$url = "index.php?EX=failLog";
			break;
		case "developpeur":
			if($_POST['password'] == "dev")
				$url = "index.php?EX=logdev";
			else
				$url = "index.php?EX=failLog";
			break;
		case "moderateur":
			if($_POST['password'] == "mod")
				$url = "index.php?EX=logmod";
			else
				$url = "index.php?EX=failLog";
			break;
		case "specialiste":
			if($_POST['password'] == "spec")
				$url = "index.php?EX=logspec";
			else
				$url = "index.php?EX=failLog";
			break;
		case "editorialiste":
			if($_POST['password'] == "edit")
				$url = "index.php?EX=logedit";
			else
				$url = "index.php?EX=failLog";
			break;
		case "client":
			if($_POST['password'] == "client")
				$url = "index.php?EX=logclient";
			else
				$url = "index.php?EX=failLog";
			break;
		default : 
			$url = "index.php?EX=failLog";
			break;
	}

	echo $url;

?>