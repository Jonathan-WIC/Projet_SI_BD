var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    /////////////////// fill dropdowns of modal ////////////////////
    ////////////////////////////////////////////////////////////////

    fillMonsterTable(0);
    fillSelectSubSpecie();
    fillSelectMaturity();
    fillSelectRegime();
    fillSelectDanger();
    fillElementModalGrid();

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current monster //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesMonster').click(function(){
		var dataID = $(this).attr('idMonster'); // get the current monster's ID
		updateMonsterInfos(dataID);
	});

	$('#btnAddMonster').click(function(){
		addMonster();
	});

	$('#UpdateMonsterModal').on('hide.bs.modal', function(){
		fillElementModalGrid();
	});

	$('#AddMonsterModal').on('hide.bs.modal', function(){
		fillElementModalGrid();
	});

});//Ready

	/////////////////////////////////////////////////////////////////
    ////////////////// Check/Uncheck all checkbox  //////////////////
    /////////////////////////////////////////////////////////////////

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxMonster').prop('checked', true);
	else
		$('.checkboxMonster').prop('checked', false);
};


function showAddMonsterModal(){
	$('#AddMonsterModal').modal('show');
};


function fillMonsterTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	$('#optionMonster').empty();
	$('#optionMonster').append('<button id="addMonster" onclick="showAddMonsterModal()">Add Monster</button>'+
							 '<button id="deleteMonster" onclick="deleteMultipleMonster()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	var json_option = {
		    NAME : $('#alterNameMonster').val(),
		    GENDER : $('#selectAlterGenderMonster').val(),
		    AGE : $('#alterAgeMonster').val(),
		    WEIGHT : $('#alterWeightMonster').val(),
		    DANGER_SCALE : $('#selectAlterDangerMonster').val(),
		    HEALTH_STATE : $('#alterHealthMonster').val(),
		    HUNGER_STATE : $('#alterHungerMonster').val(),
		    CLEAN_SCALE : $('#alterCleanMonster').val(),
		    LIB_SPECIE : $('#selectAlterSubSpecieMonster').val(),
		    LIB_SUB_SPECIE : $('#selectAlterSubSpecieMonster').val(),
		    LIB_MATURITY : $('#selectAlterMaturityMonster').val(),
		    LIB_REGIME : $('#selectAlterRegimeMonster').val()
		};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'role': "tableMonster" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableMonsters').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.infos){

				if (response.infos[i]['ID_PERSO'] == null) response.infos[i]['ID_PERSO'] = 'N/A';

			    $('#bodyTableMonsters').append( '<tr>'+
													'<td>'+response.infos[i]['ID_MONSTER']+'</td>'+
													'<td>'+response.infos[i]['NAME']+'</td>'+
													'<td>'+response.infos[i]['LIB_SPECIE']+'</td>'+
													'<td>'+response.infos[i]['LIB_SUB_SPECIE']+'</td>'+
													'<td>'+response.infos[i]['GENDER']+'</td>'+
													'<td>'+response.infos[i]['AGE']+'</td>'+
													'<td>'+response.infos[i]['LIB_MATURITY']+'</td>'+
													'<td>'+response.infos[i]['WEIGHT']+'</td>'+
													'<td>'+response.infos[i]['DANGER_SCALE']+'</td>'+
													'<td>'+response.infos[i]['HEALTH_STATE']+'</td>'+
													'<td>'+response.infos[i]['HUNGER_STATE']+'</td>'+
													'<td>'+response.infos[i]['CLEAN_SCALE']+'</td>'+
													'<td>'+response.infos[i]['LIB_REGIME']+'</td>'+
													'<td>'+
														'<select id="elementMonster'+response.infos[i]['ID_MONSTER']+'" class="elementMonsterTable">'+
														'</select>'+
													'</td>'+
													'<td>'+response.infos[i]['ID_PERSO']+'</td>'+
													'<td>'+
														'<button class="altMonster" onclick="fillMonsterInfos('+ response.infos[i]['ID_MONSTER'] +');" >Modif</button>'+
														'<button class="deleteMonster" onclick="deleteMonster('+ response.infos[i]['ID_MONSTER'] +');" >Supr</button>'+
													'</td>'+
													'<td>'+
														'<input type="checkbox" name="selectedMonster" value="'+response.infos[i]['ID_MONSTER']+'" class="checkboxMonster">'+
													'</td>'+
				    				 			'</tr>');
			}

			//On remplit les select liés aux éléments des mobs
			for(i in response.element){
            	$('#elementMonster'+response.element[i]['ID_MONSTER']).append('<option>'+response.element[i]['LIB_ELEMENT']+'</option>');
            }

            //On cherche les selects qui ne sont pas remplis (les mob qui n'ont pas d'éléments) et on met le 'N/A' par défaut
            $('.elementMonsterTable:empty').append('<option>N/A</option>');

			//$('#divLoader').empty();
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillMonsterTable');

		// Application de DataTable à un tableau
		table = $('#tableMonsters').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();
	});
};

function fillElementModalGrid(){

	$('#listAddElement').empty();
	$('#listUpdateElement').empty();

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'role': "element"},
	    dataType: 'json',
	    success: function(response){
	    	for(i in response.element){
	        	$('#listUpdateElement').append('<li>'+
			        						   '<input id="Elem_'+response.element[i]['LIB_ELEMENT']+'" type="checkbox" name="elementMob" value="'+response.element[i]['ID_ELEMENT']+'" />'+
			        						   '<label for="Elem_'+response.element[i]['LIB_ELEMENT']+'">'+response.element[i]['LIB_ELEMENT']+'</label>'+
			        						   '</li>');
	        	$('#listAddElement').append('<li>'+
			        						'<input id="addElem_'+response.element[i]['LIB_ELEMENT']+'" type="checkbox" name="elementMob" value="'+response.element[i]['ID_ELEMENT']+'" />'+
			        						'<label for="addElem_'+response.element[i]['LIB_ELEMENT']+'">'+response.element[i]['LIB_ELEMENT']+'</label>'+
			        						'</li>');
	        }
	    }
	});
};

function fillMonsterInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "infosMonster" },
	    dataType: 'json',
	    success: function(response){
	        $('#alterNameMonster').val(response.infos[0]['NAME']);
	        $('#selectAlterGenderMonster option[value="'+response.infos[0]['GENDER']+'"]').prop('selected', true);
	        $('#selectAlterSubSpecieMonster option[value="'+response.infos[0]['ID_SUB_SPECIE']+'"]').prop('selected', true);
	        $('#selectAlterMaturityMonster option[value="'+response.infos[0]['ID_MATURITY']+'"]').prop('selected', true);
	        $('#selectAlterRegimeMonster option[value="'+response.infos[0]['ID_REGIME']+'"]').prop('selected', true);
	        $('#alterAgeMonster').val(response.infos[0]['AGE']);
	        $('#alterWeightMonster').val(response.infos[0]['WEIGHT']);
	        $('#alterHungerMonster').val(response.infos[0]['HUNGER_STATE']);
	        $('#alterHealthMonster').val(response.infos[0]['HEALTH_STATE']);
	        $('#alterCleanMonster').val(response.infos[0]['CLEAN_SCALE']);
	        $('#selectAlterDangerMonster option[value="'+response.infos[0]['DANGER_SCALE']+'"]').prop('selected', true);

	        for(i in response.element)
	        	$('#Elem_'+response.element[i]['LIB_ELEMENT']).attr('checked', true);
	    }
	});
	$('#btnSaveChangesMonster').attr('idMonster', id); //get the ID for the Updtae fonction
	$('#UpdateMonsterModal').modal('show');
	return false;
};

function updateMonsterInfos(id){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#alterNameMonster').val().trim() == ""){
		alert("You must fill correctly fill the Name's field");
		return false;
	}
	if(isNaN(parseFloat($('#alterAgeMonster').val())) || $('#alterAgeMonster').val().trim() < 0 || $('#alterAgeMonster').val().trim() > 9999){
		alert("The age's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#alterWeightMonster').val())) || $('#alterWeightMonster').val().trim() < 0 || $('#alterWeightMonster').val().trim() > 9999){
		alert("The weigth's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#alterHealthMonster').val())) || $('#alterHealthMonster').val().trim() < 0 || $('#alterHealthMonster').val().trim() > 9999){
		alert("The health's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#alterHungerMonster').val())) || $('#alterHungerMonster').val().trim() < 0 || $('#alterHungerMonster').val().trim() > 9999){
		alert("The hunger's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#alterCleanMonster').val())) || $('#alterCleanMonster').val().trim() < 0 || $('#alterCleanMonster').val().trim() > 9999){
		alert("The clean's value must be beetween 0 and 9999");
		return false;
	}

	/*****************************
	 ****** Update elements ******
	 *****************************/

	var elementChecked = new Array();
	$("input:checked[name=elementMob]").each(function() { //get the ID of all elements selected
		elementChecked.push($(this).val());
	});

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': elementChecked, 'role': "updateElemMonster" }
	}).done(function(){
		var json_option = {
		    NAME : $('#alterNameMonster').val(),
		    GENDER : $('#selectAlterGenderMonster').val(),
		    AGE : $('#alterAgeMonster').val(),
		    WEIGHT : $('#alterWeightMonster').val(),
		    DANGER_SCALE : $('#selectAlterDangerMonster').val(),
		    HEALTH_STATE : $('#alterHealthMonster').val(),
		    HUNGER_STATE : $('#alterHungerMonster').val(),
		    CLEAN_SCALE : $('#alterCleanMonster').val(),
		    ID_SUB_SPECIE : $('#selectAlterSubSpecieMonster').val(),
		    ID_MATURITY : $('#selectAlterMaturityMonster').val(),
		    ID_REGIME : $('#selectAlterRegimeMonster').val()
		};

		$.ajax({
		    type: "POST", //Sending method
		    url:"Handler/developpeur.hand.php",
		    data: {'id': id, 'data': json_option, 'role': "updateMonster" }
		}).done(function(){
			var currentPage = $('.active').attr('id').replace("page", "");
			fillMonsterTable(currentPage);
			$('#UpdateMonsterModal').modal('hide');
		});

	});

};

function deleteMonster(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deleteMonster" },
	    dataType: 'json'
	}).done(function(){
		alert("Monster Erased");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillMonsterTable(currentPage);
	});
};

function deleteMultipleMonster(){

	var monsterChecked = new Array();
	$("input:checked[name=selectedMonster]").each(function() { //get the ID of all elements selected
		monsterChecked.push($(this).val());
	});

	if (monsterChecked.length < 1) {
		alert("You must select at least 1 monster");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': monsterChecked, 'role': "deleteMultipleMonster" }
	}).done(function(){
		fillMonsterTable(0);
		
	});
};

function addMonster(){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#addNameMonster').val().trim() == ""){
		alert("You must fill correctly fill the Name's field");
		return false;
	}
	if(isNaN(parseFloat($('#addAgeMonster').val())) || $('#addAgeMonster').val().trim() < 0 || $('#addAgeMonster').val().trim() > 9999){
		alert("The age's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#addWeightMonster').val())) || $('#addWeightMonster').val().trim() < 0 || $('#addWeightMonster').val().trim() > 9999){
		alert("The weigth's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#addHealthMonster').val())) || $('#addHealthMonster').val().trim() < 0 || $('#addHealthMonster').val().trim() > 9999){
		alert("The health's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#addHungerMonster').val())) || $('#addHungerMonster').val().trim() < 0 || $('#addHungerMonster').val().trim() > 9999){
		alert("The hunger's value must be beetween 0 and 9999");
		return false;
	}
	if(isNaN(parseFloat($('#addCleanMonster').val())) || $('#addCleanMonster').val().trim() < 0 || $('#addCleanMonster').val().trim() > 9999){
		alert("The clean's value must be beetween 0 and 9999");
		return false;
	}

	/*****************************
	 ******** add elements *******
	 *****************************/

	var elementChecked = new Array();
	$("input:checked[name=elementMob]").each(function() { //get the ID of all elements selected
		elementChecked.push($(this).val());
	});

	var json_option = {
	    NAME : $('#addNameMonster').val(),
	    GENDER : $('#selectAddGenderMonster').val(),
	    AGE : $('#addAgeMonster').val(),
	    WEIGHT : $('#addWeightMonster').val(),
	    DANGER_SCALE : $('#selectAddDangerMonster').val(),
	    HEALTH_STATE : $('#addHealthMonster').val(),
	    HUNGER_STATE : $('#addHungerMonster').val(),
	    CLEAN_SCALE : $('#addCleanMonster').val(),
	    ID_SUB_SPECIE : $('#selectAddSubSpecieMonster').val(),
	    ID_MATURITY : $('#selectAddMaturityMonster').val(),
	    ID_REGIME : $('#selectAddRegimeMonster').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'elem': elementChecked, 'role': "addMonster" }
	}).done(function(){
		fillMonsterTable(0);
		$('#AddMonsterModal').modal('hide');
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

function fillSelectMaturity(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'role': "maturity" },
	    dataType: 'json',
	    success: function(response){
			for(i in response.maturity)
	    		$('.selectMaturity').append('<option value='+ response.maturity[i]['ID_MATURITY'] +'>'+ response.maturity[i]['LIB_MATURITY'] +'</option>');
	    }
	});
};

function fillSelectRegime(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'role': "regime" },
	    dataType: 'json',
	    success: function(response){
			for(i in response.regime)
	    		$('.selectRegime').append('<option value='+ response.regime[i]['ID_REGIME'] +'>'+ response.regime[i]['LIB_REGIME'] +'</option>');
	    }
	});
};

function fillSelectDanger(){
	$('.selectDanger').append(
		'<option value="INOFFENSIVE">INOFFENSIVE</option>' +
		'<option value="AGGRESSIVE">AGGRESSIVE</option>'	 +
		'<option value="DANGEROUS">DANGEROUS</option>'	 +
		'<option value="MORTAL">MORTAL</option>'
	);
};
