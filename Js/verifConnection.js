$(document).ready(function(){

	$(document).keypress(function(e) {
    if(e.which == 13) {
        $('#btnLog').trigger('click');
    }
});

	$('#btnLog').click(function(){
		identification();
	});

});

function identification(){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/login.hand.php",
	    data: {'username': $('#username').val(), 'password': $('#password').val() },
	    dataType: 'text',
	    success : function(response){
	    	window.location.replace(response);
	    }
	});

}
