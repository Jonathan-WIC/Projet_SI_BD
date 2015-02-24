$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    /////////////////// fill dropdowns of modal ////////////////////
    ////////////////////////////////////////////////////////////////

    fillSelectSpecie();
    fillSelectSubSpecie();
    fillSelectMaturity();


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
		        $('#selectAlterSpecieMonster option[value="'+response.infos[0]['LIB_SPECIE']+'"]').prop('selected', true);
		        $('#selectAlterSubSpecieMonster option[value="'+response.infos[0]['LIB_SUB_SPECIE']+'"]').prop('selected', true);
		        $('#selectAlterMaturityMonster option[value="'+response.infos[0]['LIB_MATURITY']+'"]').prop('selected', true);
		        $('#alterAgeMonster').val(response.infos[0]['AGE']);
		        $('#alterWeightMonster').val(response.infos[0]['WEIGHT']);
		        $('#alterDangerMonster').val(response.infos[0]['DANGER_SCALE']);
		        $('#alterHungerMonster').val(response.infos[0]['HUNGER_STATE']);
		        $('#alterHealthMonster').val(response.infos[0]['HEALTH_STATE']);
		        $('#alterCleanMonster').val(response.infos[0]['CLEAN_SCALE']);
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
	    		$('#selectAlterSpecieMonster').append('<option value='+ response.specie[i]['ID_SPECIE'] +'>'+ response.specie[i]['LIB_SPECIE'] +'</option>');
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
	    		$('#selectAlterSubSpecieMonster').append('<option value='+ response.subSpecie[i]['ID_SUB_SPECIE'] +'>'+ response.subSpecie[i]['LIB_SUB_SPECIE'] +'</option>');
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
	    		$('#selectAlterMaturityMonster').append('<option value='+ response.maturity[i]['ID_MATURITY'] +'>'+ response.maturity[i]['LIB_MATURITY'] +'</option>');
	    }
	});
};