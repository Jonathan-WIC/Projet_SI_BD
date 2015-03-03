$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillSubSpecieTable(0);
    fillSelectSubSpecie();
    fillSelectSpecie();
    fillSelectHabitat();

	/////////////////////////////////////////////////////////////////
    //////////// update infos of the current Sub Specie /////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesSubSpecie').click(function(){
		var dataID = $(this).attr('idSubSpecie'); // get the current monster's ID
		updateSubSpecieInfos(dataID);
	});

});//Ready

function fillSubSpecieTable(page){

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
	    data: {'role': "tableSubSpecie" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableSubSpecies').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.subSpecie){
			    $('#bodyTableSubSpecies').append( '<tr>'+
												'<td>'+response.subSpecie[i]['ID_SUB_SPECIE']+'</td>'+
												'<td>'+response.subSpecie[i]['LIB_SUB_SPECIE']+'</td>'+
												'<td>'+response.subSpecie[i]['LIB_SPECIE']+'</td>'+
												'<td>'+response.subSpecie[i]['LIB_HABITAT']+'</td>'+
												'<td>'+
													'<button class="altSubSpecie" idSubSpecie="'+response.subSpecie[i]['ID_SUB_SPECIE']+'" onclick="fillSubSpecieInfos('+response.subSpecie[i]['ID_SUB_SPECIE']+');" >Modif'+
													'</button>'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillSubSpecieTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillSubSpecieTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillSubSpecieTable('+nextPage+')">'+
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

function fillSubSpecieInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'role': "infosSubSpecies" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterNameSubSpecie').val(response.subSpecieInfos[0]['LIB_SUB_SPECIE']);
	         $('#selectAlterIdSpecie option[value="'+response.subSpecieInfos[0]['ID_SPECIE']+'"]').prop('selected', true);
	         $('#selectAlterHabitat option[value="'+response.subSpecieInfos[0]['LIB_HABITAT']+'"]').prop('selected', true);
	    }
	});
	$('#btnSaveChangesSubSpecie').attr('idSubSpecie', id); //get the ID for the Updtae fonction
	$('#UpdateSubSpecieModal').modal('show');
};

function updateSubSpecieInfos(id){

	var json_option = {
	    NAME : $('#alterNameSubSpecie').val(),
	    ID_SPECIE : $('#selectAlterIdSpecie').val(),
	    HABITAT : $('#selectAlterHabitat').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateSubSpecie" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillSubSpecieTable(currentPage);
		$('#UpdateSubSpecieModal').modal('hide');
	});

};

function fillSelectSubSpecie(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'role': "subSpecie" },
	    dataType: 'json',
	    success: function(response){
	    	for(i in response.subSpecie)
	    		$('.selectSubSpecies').append('<option value='+ response.subSpecie[i]['ID_SUB_SPECIE'] +'>'+ response.subSpecie[i]['LIB_SUB_SPECIE'] +'</option>');
	    }
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

function fillSelectHabitat(){
	$('.selectHabitat').append(
		'<option value="JUNGLE">JUNGLE</option>'	 +
		'<option value="OCEAN">OCEAN</option>'		 +
		'<option value="PLAINE">PLAINE</option>'	 +
		'<option value="VOLCANO">VOLCANO</option>'	 +
		'<option value="CITY">CITY</option>'		 +
		'<option value="FOREST">FOREST</option>'	 +
		'<option value="MOUNTAIN">MOUNTAIN</option>' +
		'<option value="CAVERN">CAVERN</option>'	 +
		'<option value="MARAIS">MARAIS</option>'	 +
		'<option value="DESERT">DESERT</option>'	 +
		'<option value="ILE">ILE</option>'			 +
		'<option value="TOUNDRA">TOUNDRA</option>'	 +
		'<option value="HILL">HILL</option>'		 +
		'<option value="CANYON">CANYON</option>'	 +
		'<option value="LAKE">LAKE</option>'		 +
		'<option value="BEACH">BEACH</option>'
	);
};