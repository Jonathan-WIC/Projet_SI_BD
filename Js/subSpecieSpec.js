var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillSubSpecieTable(0);
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

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	var json_option = {
	    LIB_SUB_SPECIE : $('#searchNameSubSpecie').val(),
	    LIB_SPECIE : $('#searchNameSpecie').val(),
	    LIB_HABITAT : $('#selectHabitat').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
	    data: {'data': json_option, 'role': "tableSubSpecie" },
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
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillSubSpecieTable');

		// Application de DataTable à un tableau
		table = $('#tableSubSpecies').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();

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

	//verify fields
	if ($('#alterNameSubSpecie').val().trim() == '') {	// trim is used to remove the white space at the begining 
		alert("You must fill all required fields");		// and the end of a string
		return false;
	}

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