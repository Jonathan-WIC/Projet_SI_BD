$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillRegimeTable(0);
    fillSelectRegime();

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Regime //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesRegime').click(function(){
		var dataID = $(this).attr('idRegime'); // get the current monster's ID
		updateRegimeInfos(dataID);
	});

});//Ready

function fillRegimeTable(page){

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
	    data: {'role': "tableRegime" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableRegimes').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.regime){
			    $('#bodyTableRegimes').append( '<tr>'+
												'<td>'+response.regime[i]['ID_REGIME']+'</td>'+
												'<td>'+response.regime[i]['LIB_REGIME']+'</td>'+
												'<td>'+
													'<button class="altRegime" idRegime="'+response.regime[i]['ID_REGIME']+'" onclick="fillRegimeInfos('+response.regime[i]['ID_REGIME']+');" >Modif'+
													'</button>'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillRegimeTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillRegimeTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillRegimeTable('+nextPage+')">'+
									'<a href="#" aria-label="Next">'+
										'<span aria-hidden="true">&raquo;</span>'+
									'</a>'+
								'</li>')

		if (nextPage > response.nbPage){
			$('#nextArrow').attr('class', 'disabled');
			$('#nextArrow').removeAttr('onclick');
		}
		
	});
};

function fillRegimeInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'role': "infosRegimes" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterNameRegime').val(response.regimeInfos[0]['LIB_REGIME']);
	    }
	});
	$('#btnSaveChangesRegime').attr('idRegime', id); //get the ID for the Updtae fonction
	$('#UpdateRegimeModal').modal('show');
};

function updateRegimeInfos(id){

	var json_option = {
	    NAME : $('#alterNameRegime').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateRegime" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillRegimeTable(currentPage);
		$('#UpdateRegimeModal').modal('hide');
	});

};

function fillSelectRegime(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'role': "regime"},
	    dataType: 'json',
	    success: function(response){
	    	for(i in response.regime){
	    		$('.selectRegimes').append('<option value='+ response.regime[i]['ID_REGIME'] +'>'+ response.regime[i]['LIB_REGIME'] +'</option>');
	        }
	    }
	});
};