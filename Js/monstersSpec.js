$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    /////////////////// fill dropdowns of modal ////////////////////
    ////////////////////////////////////////////////////////////////

    fillSelectSpecie();
    fillSelectSubSpecie();
    fillSelectMaturity();
    fillSelectRegime();
    fillSelectDanger();
    fillElementModalGrid();


	/////////////////////////////////////////////////////////////////
    /////////////// get infos from the current monster //////////////
    /////////////////////////////////////////////////////////////////

	$('.altMonster').click(function(){

		var dataID = $(this).attr('idMonster'); // get the current monster's ID

		/*************** Ajax calls ***************/

		$.ajax({
		    type: "POST", //Sending method
		    url:"Handler/monsterInfoSpc.hand.php",
		    data: {'id': dataID, 'role': "infos" },
		    dataType: 'json',
		    success: function(response){
		        $('#alterNameMonster').val(response.infos[0]['NAME']);
		        $('#selectAlterGenderMonster option[value="'+response.infos[0]['GENDER']+'"]').prop('selected', true);
		        $('#selectAlterSpecieMonster option[value="'+response.infos[0]['ID_SPECIE']+'"]').prop('selected', true);
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

		$('#UpdateMonsterModal').modal('show');
		return false;
	});

});

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
	        							 '<input id="Elem_'+response.element[i]['LIB_ELEMENT']+'" type="checkbox" name="'+response.element[i]['LIB_ELEMENT']+'" value="'+response.element[i]['ID_ELEMENT']+'" />'+
	        							 '<label for="'+response.element[i]['LIB_ELEMENT']+'">'+response.element[i]['LIB_ELEMENT']+'</label>'+
	        							 '</li>');
	        }
	    }
	});
};
