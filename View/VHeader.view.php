<?php
	class VHeader
	{
		public function __construct(){}

		public function __destruct(){}

		public function showHeader($log)
		{
			$vhtml = new VHtml();
			$header = 'Html/header.php';
			switch ($log) {
				case "MDBase_administrateur": $header = 'Html/headerDev.html';	    break;
				case "MDBase_adminquest": 	  $header = 'Html/headerSimple.html';	break;
				case "MDBase_developpeur": 	  $header = 'Html/headerDev.html';	    break;
				case "MDBase_moderateur": 	  $header = 'Html/headerSimple.html';	break;
				case "MDBase_specialiste": 	  $header = 'Html/headerSpec.html';		break;
				case "MDBase_editorialiste":  $header = 'Html/headerSimple.html';	break;
				case "MDBase_client": 		  $header = 'Html/headerClient.php';	break;
				default : 					  $header = 'Html/header.html';			break;
			}
        	$vhtml->showHtml($header);
		} // showHeader()
	} // VHeader
?>