$(document).ready(function(){

	$('#btnLog').click(function(){
		identificationSwich();
	});
 
	$('#content').keypress(function(e){
	    if( e.which == 13 ){	//Si on appui sur la touche entrée
	       identificationSwich();
	    }
	});

});


	/////////////////////////////////////////////////////////////////
    /////////////// this switch must be in server side //////////////
    /////////////////////////////////////////////////////////////////


function identificationSwich(){
	switch ($('#username').val()) {
		case "administrateur":
			if($('#password').val() == "admin")
				window.location.replace("index.php?EX=logadmin");
			else
				window.location.replace("index.php?EX=failLog");
			break;
		case "adminquest":
			if($('#password').val() == "quest")
				window.location.replace("index.php?EX=logquest");
			else
				window.location.replace("index.php?EX=failLog");
			break;
		case "devloppeur":
			if($('#password').val() == "dev")
				window.location.replace("index.php?EX=logdev");
			else
				window.location.replace("index.php?EX=failLog");
			break;
		case "moderateur":
			if($('#password').val() == "mod")
				window.location.replace("index.php?EX=logmod");
			else
				window.location.replace("index.php?EX=failLog");
			break;
		case "specialiste":
			if($('#password').val() == "spec")
				window.location.replace("index.php?EX=logspec");
			else
				window.location.replace("index.php?EX=failLog");
			break;
		case "editorialiste":
			if($('#password').val() == "edit")
				window.location.replace("index.php?EX=logedit");
			else
				window.location.replace("index.php?EX=failLog");
			break;
		case "client":
			if($('#password').val() == "client")
				window.location.replace("index.php?EX=logclient");
			else
				window.location.replace("index.php?EX=failLog");
			break;
		default : 
			window.location.replace("index.php?EX=failLog");
			break;
	}
};