var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillEnclosureTable(0);
    fillSelectSubSpecie();
    fillSelectPark();

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Enclosure //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesEnclosure').click(function(){
		var dataID = $(this).attr('idEnclosure'); // get the current monster's ID
		updateEnclosureInfos(dataID);
	});

	$('#btnAddEnclosure').click(function(){
		addEnclosure();
	});

});//Ready


function showAddEnclosureModal(){
	$('#AddEnclosureModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxEnclosure').prop('checked', true);
	else
		$('.checkboxEnclosure').prop('checked', false);
};

function fillEnclosureTable(page){

	if(table){
		table.destroy();
	}

	$('#optionEnclosure').empty();
	$('#optionEnclosure').append('<button id="addEnclosure" onclick="showAddEnclosureModal()">Add Enclosure</button>'+
							   '<button id="deleteEnclosure" onclick="deleteMultipleEnclosure()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'role': "tableEnclosure" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableEnclosures').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.enclosure){
			    $('#bodyTableEnclosures').append( '<tr>'+
												'<td>'+response.enclosure[i]['ID_ENCLOSURE']+'</td>'+
												'<td>'+response.enclosure[i]['ID_PARK']+'</td>'+
												'<td>'+response.enclosure[i]['TYPE_ENCLOS']+'</td>'+
												'<td>'+response.enclosure[i]['CAPACITY_MONSTER']+'</td>'+
												'<td>'+response.enclosure[i]['PRICE']+'</td>'+
												'<td>'+response.enclosure[i]['CLIMATE']+'</td>'+
												'<td>'+response.enclosure[i]['LIB_SUB_SPECIE']+'</td>'+
												'<td>'+
													'<button class="altEnclosure" onclick="fillEnclosureInfos('+response.enclosure[i]['ID_ENCLOSURE']+');" >Modif</button>'+
													'<button class="deleteEnclosure" onclick="deleteEnclosure('+response.enclosure[i]['ID_ENCLOSURE']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedEnclosure" value="'+response.enclosure[i]['ID_ENCLOSURE']+'" class="checkboxEnclosure">'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillEnclosureTable');


		// Application de DataTable à un tableau
		table = $('#tableEnclosures').DataTable({
			paging: false,
			searching: false,
			info: false
		});

	});
};

function fillEnclosureInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "infosEnclosures" },
	    dataType: 'json',
	    success: function(response){
	        $('#selectAlterParkEnclosure option[value="'+response.enclosureInfos[0]['ID_PARK']+'"]').prop('selected', true);
	        $('#selectAlterTypeEnclosure option[value="'+response.enclosureInfos[0]['TYPE_ENCLOS']+'"]').prop('selected', true);
	        $('#alterCapacityEnclosure').val(response.enclosureInfos[0]['CAPACITY_MONSTER']);
	        $('#alterPriceEnclosure').val(response.enclosureInfos[0]['PRICE']);
	        $('#selectAlterClimatEnclosure option[value="'+response.enclosureInfos[0]['CLIMATE']+'"]').prop('selected', true);
	        $('#selectAlterSubSpecieEnclosure option[value="'+response.enclosureInfos[0]['ID_SUB_SPECIE']+'"]').prop('selected', true);
	    }
	});
	$('#btnSaveChangesEnclosure').attr('idEnclosure', id); //get the ID for the Updtae fonction
	$('#UpdateEnclosureModal').modal('show');
};

function updateEnclosureInfos(id){

	if(isNaN(parseFloat($('#alterCapacityEnclosure').val())) || $('#alterCapacityEnclosure').val().trim() < 0 || $('#alterCapacityEnclosure').val().trim() > 10){
		alert("The capacity's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#alterPriceEnclosure').val())) || $('#alterPriceEnclosure').val().trim() < 0 || $('#alterPriceEnclosure').val().trim() > 99999){
		alert("The price's value must be beetween 0 and 9999");
		return false;
	}

	var json_option = {
	    ID_PARK : $('#selectAlterParkEnclosure').val(),
	    TYPE_ENCLOS : $('#selectAlterTypeEnclosure').val(),
	    CAPACITY_MONSTER : $('#alterCapacityEnclosure').val(),
	    PRICE : $('#alterPriceEnclosure').val(),
	    CLIMATE : $('#selectAlterClimatEnclosure').val(),
	    ID_SUB_SPECIE : $('#selectAlterSubSpecieEnclosure').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateEnclosure" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillEnclosureTable(currentPage);
		$('#UpdateEnclosureModal').modal('hide');
	});

};

function deleteEnclosure(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deleteEnclosure"},
	    dataType: 'json'
	}).done(function(){
		alert("Enclosure deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillEnclosureTable(currentPage);
	});
};

function deleteMultipleEnclosure(){
	
	var enclosureChecked = new Array();
	$("input:checked[name=selectedEnclosure]").each(function() { //get the ID of all enclosures selected
		enclosureChecked.push($(this).val());
	});

	if (enclosureChecked.length < 1) {
		alert("You must select at least 1 enclosure");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': enclosureChecked, 'role': "deleteMultipleEnclosure" }
	}).done(function(){
		alert("Enclosures deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillEnclosureTable(currentPage);
	});
};

function addEnclosure(){
	
	//verify fields
	if(isNaN(parseFloat($('#addCapacityEnclosure').val())) || $('#addCapacityEnclosure').val().trim() < 0 || $('#addCapacityEnclosure').val().trim() > 10){
		alert("The capacity's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#addPriceEnclosure').val())) || $('#addPriceEnclosure').val().trim() < 0 || $('#addPriceEnclosure').val().trim() > 99999){
		alert("The price's value must be beetween 0 and 9999");
		return false;
	}

	var json_option = {
	    ID_PARK : $('#selectAddParkEnclosure').val(),
	    TYPE_ENCLOS : $('#selectAddTypeEnclosure').val(),
	    CAPACITY_MONSTER : $('#addCapacityEnclosure').val(),
	    PRICE : $('#addPriceEnclosure').val(),
	    CLIMATE : $('#selectAddClimatEnclosure').val(),
	    ID_SUB_SPECIE : $('#selectAddSubSpecieEnclosure').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addEnclosure" }
	}).done(function(){
		$('#AddEnclosureModal').modal('hide');
		alert("Enclosure created!")
		fillEnclosureTable(0);
	});

};

function fillSelectSubSpecie(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'role': "subSpecie" },
	    dataType: 'json',
	    success: function(response){
			for(i in response.subSpecie)
	    		$('.selectSubSpecies').append('<option value='+ response.subSpecie[i]['ID_SUB_SPECIE'] +'>'+ response.subSpecie[i]['LIB_SUB_SPECIE'] +'</option>');
	    }
	});
};

function fillSelectPark(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'role': "park" },
	    dataType: 'json',
	    success: function(response){
			for(i in response.park)
	    		$('.selectPark').append('<option value='+ response.park[i]['ID_PARK'] +'>'+ response.park[i]['ID_PARK'] +'</option>');
	    }
	});
};
