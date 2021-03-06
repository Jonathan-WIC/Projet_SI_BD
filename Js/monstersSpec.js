var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    /////////////////// fill dropdowns of modal ////////////////////
    ////////////////////////////////////////////////////////////////

    fillMonsterTable(0);
    fillSelectSpecie();
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



	$('#UpdateMonsterModal').on('hide.bs.modal', function(){
		$('#listUpdateElement').empty();
		fillElementModalGrid();
	});

});//Ready

function fillMonsterTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}


	var json_option = {
		    NAME : $('#nameSearch').val(),
		    GENDER : $('#searchGenderMonster').val(),
		    DANGER_SCALE : $('#selectDanger').val(),
		    LIB_SPECIE : $('#selectSpecies').val(),
		    LIB_SUB_SPECIE : $('#selectSubSpecies').val(),
		    LIB_MATURITY : $('#selectMaturity').val(),
		    LIB_REGIME : $('#selectRegime').val(),
		    CLEAN_SCALE : $('#searchCleanMonster').val(),
		    HEALTH_STATE : $('#searchHealthMonster').val(),
		    HUNGER_STATE : $('#searchHungerMonster').val(),
		    AGE : $('#searchAgeMonster').val(),
		    WEIGHT : $('#searchWeigthMonster').val()
		};


	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
	    data: {'data': json_option, 'role': "tableMonster" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableMonsters').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.infos){
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
													'</select></td>'+
												'<td>'+
													'<button class="altMonster" idMonster="'+response.infos[i]['ID_MONSTER']+'" onclick="fillMonsterInfos('+ response.infos[i]['ID_MONSTER'] +');" >Modif'+
													'</button>'+
												'</td>'+
				    				 			'</tr>');
			}

			//On remplit les select liés aux éléments des mobs
			for(i in response.element){
            	$('#elementMonster'+response.element[i]['ID_MONSTER']).append('<option>'+response.element[i]['LIB_ELEMENT']+'</option>');
            }

            //On cherche les selects qui ne sont pas remplis (les mob qui n'ont pas d'éléments) et on met le 'N/A' par défaut
            $('.elementMonsterTable:empty').append('<option>N/A</option>');
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
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'role': "element"},
	    dataType: 'json',
	    success: function(response){
	    	for(i in response.element){
	        	$('#listUpdateElement').append('<li>'+
	        							 '<input id="Elem_'+response.element[i]['LIB_ELEMENT']+'" type="checkbox" name="elementMob" value="'+response.element[i]['ID_ELEMENT']+'" />'+
	        							 '<label for="Elem_'+response.element[i]['LIB_ELEMENT']+'">'+response.element[i]['LIB_ELEMENT']+'</label>'+
	        							 '</li>');
	        }
	    }
	});
};

function fillMonsterInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
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
	    url:"Handler/specialiste.hand.php",
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
		    url:"Handler/specialiste.hand.php",
		    data: {'id': id, 'data': json_option, 'role': "updateMonster" }
		}).done(function(){
			var currentPage = $('.active').attr('id').replace("page", "");
			fillMonsterTable(currentPage);
			$('#UpdateMonsterModal').modal('hide');
		});

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

function fillSelectMaturity(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
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
	    url:"Handler/specialiste.hand.php",
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
