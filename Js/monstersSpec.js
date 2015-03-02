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
		$('#listElement').empty();
		fillElementModalGrid();
	});

});//Ready

function fillMonsterTable(page){

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/monsterInfoSpc.hand.php"+url,
	    data: {'role': "table" },
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

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillMonsterTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (response.page == 1){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i < response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'""><a href="#" onclick="fillMonsterTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillMonsterTable('+nextPage+')">'+
									'<a href="#" aria-label="Next">'+
										'<span aria-hidden="true">&raquo;</span>'+
									'</a>'+
								'</li>')

		if (response.page == response.nbPage -1){
			$('#nextArrow').attr('class', 'disabled');
			$('#nextArrow').removeAttr('onclick');
		}
		
	});
};

function fillSelectSpecie(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/monsterInfoSpc.hand.php",
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
	    url:"Handler/monsterInfoSpc.hand.php",
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
	    url:"Handler/monsterInfoSpc.hand.php",
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
	    url:"Handler/monsterInfoSpc.hand.php",
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

function fillElementModalGrid(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/monsterInfoSpc.hand.php",
	    data: {'role': "element"},
	    dataType: 'json',
	    success: function(response){
	    	for(i in response.element){
	        	$('#listElement').append('<li>'+
	        							 '<input id="Elem_'+response.element[i]['LIB_ELEMENT']+'" type="checkbox" name="elementMob" value="'+response.element[i]['ID_ELEMENT']+'" />'+
	        							 '<label for="'+response.element[i]['LIB_ELEMENT']+'">'+response.element[i]['LIB_ELEMENT']+'</label>'+
	        							 '</li>');
	        }
	    }
	});
};

function fillMonsterInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/monsterInfoSpc.hand.php",
	    data: {'id': id, 'role': "infos" },
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
	 ****** Update elements ******
	 *****************************/

	var elementChecked = new Array();
	$("input:checked[name=elementMob]").each(function() { //get the ID of all elements selected
		elementChecked.push($(this).val());
	});

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/monsterInfoSpc.hand.php",
	    data: {'id': id, 'data': elementChecked, 'role': "updateElem" }
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
		    url:"Handler/monsterInfoSpc.hand.php",
		    data: {'id': id, 'data': json_option, 'role': "update" }
		}).done(function(){
			fillMonsterTable();
			$('#UpdateMonsterModal').modal('hide');
		});

	});

};

/*	/////////////////////////////////////////////////////////////////
    ////////////////// Check/Uncheck all checkbox  //////////////////
    /////////////////////////////////////////////////////////////////

	$("#selectAll").click( function(){
		if( $(this).is(':checked') )
			$('.checkboxMstr').prop('checked', true);
		else
			$('.checkboxMstr').prop('checked', false);
	});
*/
