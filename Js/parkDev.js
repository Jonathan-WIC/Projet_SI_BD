var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillParkTable(0);
    fillSelectPerso();

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Park //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesPark').click(function(){
		var dataID = $(this).attr('idPark'); // get the current monster's ID
		updateParkInfos(dataID);
	});

	$('#btnAddPark').click(function(){
		addPark();
	});

});//Ready


function showAddParkModal(){
	$('#AddParkModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxPark').prop('checked', true);
	else
		$('.checkboxPark').prop('checked', false);
};

function fillParkTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	$('#optionPark').empty();
	$('#optionPark').append('<button id="addPark" onclick="showAddParkModal()">Add Park</button>'+
							   '<button id="deletePark" onclick="deleteMultiplePark()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'role': "tablePark" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableParks').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.park){
			    $('#bodyTableParks').append( '<tr>'+
												'<td>'+response.park[i]['ID_PARK']+'</td>'+
												'<td>'+response.park[i]['NAME_PARK']+'</td>'+
												'<td>'+response.park[i]['CAPACITY_ENCLOSURE']+'</td>'+
												'<td>'+response.park[i]['ID_PERSO']+'</td>'+
												'<td>'+
													'<select id="enclosurePark'+response.park[i]['ID_PARK']+'" class="enclosureParkTable">'+
													'</select>'+
												'</td>'+
												'<td>'+
													'<button class="altPark" onclick="fillParkInfos('+response.park[i]['ID_PARK']+');" >Modif</button>'+
													'<button class="deletePark" onclick="deletePark('+response.park[i]['ID_PARK']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedPark" value="'+response.park[i]['ID_PARK']+'" class="checkboxPark">'+
												'</td>'+
				    				 			'</tr>');
			}
			//On remplit les select liés aux éléments des mobs
			for(i in response.enclosure){
            	$('#enclosurePark'+response.enclosure[i]['ID_PARK']).append('<option>'+response.enclosure[i]['ID_ENCLOSURE']+'</option>');
            }

            //On cherche les selects qui ne sont pas remplis (les mob qui n'ont pas d'éléments) et on met le 'N/A' par défaut
            $('.enclosureParkTable:empty').append('<option>N/A</option>');
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillParkTable');

		// Application de DataTable à un tableau
		table = $('#tableParks').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();
	
	});
};

function fillParkInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "infosParks" },
	    dataType: 'json',
	    success: function(response){
	        $('#alterNamePark').val(response.parkInfos[0]['NAME_PARK']);
	        $('#alterCapacityPark').val(response.parkInfos[0]['CAPACITY_ENCLOSURE']);
	        $('#selectAlterPersoPark option[value="'+response.parkInfos[0]['ID_PERSO']+'"]').prop('selected', true);
	    }
	});
	$('#btnSaveChangesPark').attr('idPark', id); //get the ID for the Updtae fonction
	$('#UpdateParkModal').modal('show');
};

function updateParkInfos(id){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#alterNamePark').val().trim() == ""){
		alert("You must fill correctly fill the Name's field");
		return false;
	}
	if(isNaN(parseFloat($('#alterCapacityPark').val())) || $('#alterCapacityPark').val().trim() < 0 || $('#alterCapacityPark').val().trim() > 30){
		alert("The capacity's value must be beetween 0 and 30");
		return false;
	}

	var json_option = {
	    NAME_PARK : $('#alterNamePark').val(),
	    CAPACITY_ENCLOSURE : $('#alterCapacityPark').val(),
	    ID_PERSO : $('#selectAlterPersoPark').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updatePark" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillParkTable(currentPage);
		$('#UpdateParkModal').modal('hide');
	});

};

function deletePark(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deletePark"},
	    dataType: 'json'
	}).done(function(){
		alert("Park deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillParkTable(currentPage);
	});
};

function deleteMultiplePark(){
	
	var parkChecked = new Array();
	$("input:checked[name=selectedPark]").each(function() { //get the ID of all parks selected
		parkChecked.push($(this).val());
	});

	if (parkChecked.length < 1) {
		alert("You must select at least 1 park");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': parkChecked, 'role': "deleteMultiplePark" }
	}).done(function(){
		alert("Parks deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillParkTable(currentPage);
	});
};

function addPark(){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#addNamePark').val().trim() == ""){
		alert("You must fill correctly fill the Name's field");
		return false;
	}
	if(isNaN(parseFloat($('#addCapacityPark').val())) || $('#addCapacityPark').val().trim() < 0 || $('#addCapacityPark').val().trim() > 30){
		alert("The capacity's value must be beetween 0 and 30");
		return false;
	}

	var json_option = {
	    NAME_PARK : $('#addNamePark').val(),
	    CAPACITY_ENCLOSURE : $('#addCapacityPark').val(),
	    ID_PERSO : $('#selectAddPersoPark').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addPark" }
	}).done(function(){
		$('#AddParkModal').modal('hide');
		alert("Park created!")
		fillParkTable(0);
	});

};

function fillSelectPerso(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'role': "perso" },
	    dataType: 'json',
	    success: function(response){
			for(i in response.perso)
	    		$('.selectPersos').append('<option value='+ response.perso[i]['ID_PERSO'] +'>'+ response.perso[i]['ID_PERSO'] +'</option>');
	    }
	});
};
