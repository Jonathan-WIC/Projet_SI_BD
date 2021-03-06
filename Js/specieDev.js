var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillSpecieTable(0);

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Specie //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesSpecie').click(function(){
		var dataID = $(this).attr('idSpecie'); // get the current monster's ID
		updateSpecieInfos(dataID);
	});

	$('#btnAddSpecie').click(function(){
		addSpecie();
	});

});//Ready


function showAddSpecieModal(){
	$('#AddSpecieModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxSpecie').prop('checked', true);
	else
		$('.checkboxSpecie').prop('checked', false);
};

function fillSpecieTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	$('#optionSpecie').empty();
	$('#optionSpecie').append('<button id="addSpecie" onclick="showAddSpecieModal()">Add Specie</button>'+
							   '<button id="deleteSpecie" onclick="deleteMultipleSpecie()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	var json_option = {
		LIB_SPECIE : $('#searchNameSpecie').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'data' : json_option, 'role': "tableSpecie" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableSpecies').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.specie){
			    $('#bodyTableSpecies').append( '<tr>'+
												'<td>'+response.specie[i]['ID_SPECIE']+'</td>'+
												'<td>'+response.specie[i]['LIB_SPECIE']+'</td>'+
												'<td>'+
													'<button class="altSpecie" onclick="fillSpecieInfos('+response.specie[i]['ID_SPECIE']+');" >Modif</button>'+
													'<button class="deleteSpecie" onclick="deleteSpecie('+response.specie[i]['ID_SPECIE']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedSpecie" value="'+response.specie[i]['ID_SPECIE']+'" class="checkboxSpecie">'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillSpecieTable');	

		// Application de DataTable à un tableau
		table = $('#tableSpecies').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();
	
	});
};

function fillSpecieInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
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

	if ($('#alterNameSpecie').val().trim() == '') {
		alert("You must fill all required fields");
		return false;
	}

	var json_option = {
	    NAME : $('#alterNameSpecie').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateSpecie" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillSpecieTable(currentPage);
		$('#UpdateSpecieModal').modal('hide');
	});

};

function deleteSpecie(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deleteSpecie"},
	    dataType: 'json'
	}).done(function(){
		alert("Specie deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillSpecieTable(currentPage);
	});
};

function deleteMultipleSpecie(){
	
	var specieChecked = new Array();
	$("input:checked[name=selectedSpecie]").each(function() { //get the ID of all species selected
		specieChecked.push($(this).val());
	});

	if (specieChecked.length < 1) {
		alert("You must select at least 1 specie");
		return false;
	}

	for (var i = 0; i < specieChecked.length; i++) {
		deleteSpecie(specieChecked[i]);
	};
};

function addSpecie(){
	
	//verify fields
	if ($('#addNameSpecie').val().trim() == '') {// trim is used to remove the white space at the begining and the end
		alert("you must fill corectly all required fields!");
		return false;
	}

	var json_option = {
	    NAME : $('#addNameSpecie').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addSpecie" }
	}).done(function(){
		$('#AddSpecieModal').modal('hide');
		alert("Specie created!")
		fillSpecieTable(0);
	});

};
