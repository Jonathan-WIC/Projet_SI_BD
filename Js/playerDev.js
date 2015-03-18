var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillPlayerTable(0);
    fillSelectAccount();

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Player //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesPlayer').click(function(){
		var dataID = $(this).attr('idPlayer'); // get the current monster's ID
		updatePlayerInfos(dataID);
	});

	$('#btnAddPlayer').click(function(){
		addPlayer();
	});

});//Ready


function showAddPlayerModal(){
	$('#AddPlayerModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxPlayer').prop('checked', true);
	else
		$('.checkboxPlayer').prop('checked', false);
};

function fillPlayerTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	$('#optionPlayer').empty();
	$('#optionPlayer').append('<button id="addPlayer" onclick="showAddPlayerModal()">Add Player</button>'+
							   '<button id="deletePlayer" onclick="deleteMultiplePlayer()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'role': "tablePlayer" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTablePlayers').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.player){
			    $('#bodyTablePlayers').append( '<tr>'+
											 	'<td>'+response.player[i]['ID_PERSO']+'</td>'+
											 	'<td>'+response.player[i]['FIRST_NAME']+'</td>'+
											 	'<td>'+response.player[i]['LAST_NAME']+'</td>'+
											 	'<td>'+response.player[i]['GENDER']+'</td>'+
											 	'<td>'+response.player[i]['PMONEY']+'</td>'+
											 	'<td>'+response.player[i]['ID_ACCOUNT']+'</td>'+
											 	'<td>'+
											 		'<select id="questPlayer'+response.player[i]['ID_PERSO']+'" class="questPlayerTable">'+
											 		'</select>'+
											 	'</td>'+
											 	'<td>'+
											 		'<select id="parkPlayer'+response.player[i]['ID_PERSO']+'" class="parkPlayerTable">'+
											 		'</select>'+
											 	'</td>'+
											 	'<td>'+
											 		'<select id="monsterPlayer'+response.player[i]['ID_PERSO']+'" class="monsterPlayerTable">'+
											 		'</select>'+
											 	'</td>'+
											 	'<td>'+
											 		'<select id="itemPlayer'+response.player[i]['ID_PERSO']+'" class="itemPlayerTable">'+
											 		'</select>'+
											 	'</td>'+
											 	'<td>'+
											 		'<button class="altPlayer" onclick="fillPlayerInfos('+response.player[i]['ID_PERSO']+');" >Modif</button>'+
											 		'<button class="deletePlayer" onclick="deletePlayer('+response.player[i]['ID_PERSO']+');">Delete</button>'+
											 	'</td>'+
											 	'<td>'+
											 		'<input type="checkbox" name="selectedPlayer" value="'+response.player[i]['ID_PERSO']+'" class="checkboxPlayer">'+
											 	'</td>'+
				    				 		 '</tr>');
			}

			for(i in response.quest){
            	$('#questPlayer'+response.quest[i]['ID_PERSO']).append('<option>'+response.quest[i]['NAME']+'</option>');
            }
            $('.questPlayerTable:empty').append('<option>N/A</option>');

			for(i in response.park){
            	$('#parkPlayer'+response.park[i]['ID_PERSO']).append('<option>'+response.park[i]['NAME_PARK']+'</option>');
            }
            $('.parkPlayerTable:empty').append('<option>N/A</option>');
	    
			for(i in response.monster){
            	$('#monsterPlayer'+response.monster[i]['ID_PERSO']).append('<option>'+response.monster[i]['NAME']+'</option>');
            }
            $('.monsterPlayerTable:empty').append('<option>N/A</option>');

			for(i in response.item){
            	$('#itemPlayer'+response.item[i]['ID_PERSO']).append('<option>'+response.item[i]['LIB_ITEM']+'</option>');
            }
            $('.itemPlayerTable:empty').append('<option>N/A</option>');
	    
	    
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillPlayerTable');

		// Application de DataTable à un tableau
		table = $('#tablePlayers').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();

	});
};

function fillPlayerInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "infosPlayers" },
	    dataType: 'json',
	    success: function(response){
	    	$('#alterNamePlayer').val(response.playerInfos[0]['FIRST_NAME']);
	    	$('#alterLastNamePlayer').val(response.playerInfos[0]['LAST_NAME']);
	    	$('#selectAlterGenderPlayer option[value="'+response.playerInfos[0]['GENDER']+'"]').prop('selected', true);
	    	$('#alterMoneyPlayer').val(response.playerInfos[0]['PMONEY']);
	    	$('#selectAlterAccountPlayer option[value="'+response.playerInfos[0]['ID_ACCOUNT']+'"]').prop('selected', true);
	    }
	});
	$('#btnSaveChangesPlayer').attr('idPlayer', id); //get the ID for the Updtae fonction
	$('#UpdatePlayerModal').modal('show');
};

function updatePlayerInfos(id){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#alterNamePlayer').val().trim() == ""){
		alert("You must fill correctly fill the First Name's field");
		return false;
	}
	if ($('#alterLastNamePlayer').val().trim() == ""){
		alert("You must fill correctly fill the Last Name's field");
		return false;
	}
	if(isNaN(parseFloat($('#alterMoneyPlayer').val())) || $('#alterMoneyPlayer').val().trim() < 0 || $('#alterMoneyPlayer').val().trim() > 999999999){
		alert("The capacity's value must be beetween 0 and 999999999");
		return false;
	}

	var json_option = {
	    FIRST_NAME : $('#alterNamePlayer').val(),
	    LAST_NAME : $('#alterLastNamePlayer').val(),
	    GENDER : $('#selectAlterGenderPlayer').val(),
	    PMONEY : $('#alterMoneyPlayer').val(),
	    ID_ACCOUNT : $('#selectAlterAccountPlayer').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updatePlayer"}
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillPlayerTable(currentPage);
		$('#UpdatePlayerModal').modal('hide');
	});

};

function deletePlayer(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deletePlayer"},
	    dataType: 'json'
	}).done(function(){
		alert("Player deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillPlayerTable(currentPage);
	});
};

function deleteMultiplePlayer(){
	
	var playerChecked = new Array();
	$("input:checked[name=selectedPlayer]").each(function() { //get the ID of all players selected
		playerChecked.push($(this).val());
	});

	if (playerChecked.length < 1) {
		alert("You must select at least 1 player");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': playerChecked, 'role': "deleteMultiplePlayer" }
	}).done(function(){
		alert("Players deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillPlayerTable(currentPage);
	});
};

function addPlayer(){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#addNamePlayer').val().trim() == ""){
		alert("You must fill correctly fill the First Name's field");
		return false;
	}
	if ($('#addLastNamePlayer').val().trim() == ""){
		alert("You must fill correctly fill the Last Name's field");
		return false;
	}
	if(isNaN(parseFloat($('#addMoneyPlayer').val())) || $('#addMoneyPlayer').val().trim() < 0 || $('#addMoneyPlayer').val().trim() > 999999999){
		alert("The capacity's value must be beetween 0 and 999999999");
		return false;
	}

	var json_option = {
	    FIRST_NAME : $('#addNamePlayer').val(),
	    LAST_NAME : $('#addLastNamePlayer').val(),
	    GENDER : $('#selectAddGenderPlayer').val(),
	    PMONEY : $('#addMoneyPlayer').val(),
	    ID_ACCOUNT : $('#selectAddAccountPlayer').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addPlayer"}
	}).done(function(){
		$('#AddPlayerModal').modal('hide');
		alert("Player created!")
		fillPlayerTable(0);
	});

};

function fillSelectAccount(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'role': "account" },
	    dataType: 'json',
	    success: function(response){
			for(i in response.account)
	    		$('.selectAccount').append('<option value='+ response.account[i]['ID_ACCOUNT'] +'>'+ response.account[i]['ID_ACCOUNT'] +'</option>');
	    }
	});
};
