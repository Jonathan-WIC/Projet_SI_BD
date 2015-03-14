$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillSpecieTable(0);
    fillSelectSpecie();

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Specie ///////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesSpecie').click(function(){
		var dataID = $(this).attr('idSpecie'); // get the current monster's ID
		updateSpecieInfos(dataID);
	});

});//Ready

function fillSpecieTable(page){

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
	    data: {'role': "tableSpecie" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableSpecies').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.specie){
			    $('#bodyTableSpecies').append( '<tr>'+
												'<td>'+response.specie[i]['ID_SPECIE']+'</td>'+
												'<td>'+response.specie[i]['LIB_SPECIE']+'</td>'+
												'<td>'+
													'<button class="altSpecie" idSpecie="'+response.specie[i]['ID_SPECIE']+'" onclick="fillSpecieInfos('+response.specie[i]['ID_SPECIE']+');" >Modif'+
													'</button>'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillSpecieTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillSpecieTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillSpecieTable('+nextPage+')">'+
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

function fillSpecieInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'role': "infosSpecies" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterNameSpecie').val(response.specieInfos[0]['LIB_SPECIE']);
	    }
	});
	$('#btnSaveChangesSpecie').attr('idSpecie', id); //get the ID for the Updtae fonction
	$('#UpdateSpecieModal').modal('show');
};

function updateSpecieInfos(id){

	//verify fields
	if ($('#alterNameSpecie').val().trim() == '') {	// trim is used to remove the white space at the begining 
		alert("You must fill all required fields");		// and the end of a string
		return false;
	}

	var json_option = {
	    NAME : $('#alterNameSpecie').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateSpecie" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillSpecieTable(currentPage);
		$('#UpdateSpecieModal').modal('hide');
	});

};

function fillSelectSpecie(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'role': "specie" },
	    dataType: 'json',
	    success: function(response){
	    	for(i in response.specie)
	    		$('.selectSpecies').append('<option value='+ response.specie[i]['ID_SPECIE'] +'>'+ response.specie[i]['LIB_SPECIE'] +'</option>');
	    }
	});
};