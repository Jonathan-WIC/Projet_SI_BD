$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ///////////////////////// fill the page ////////////////////////
    ////////////////////////////////////////////////////////////////

    fillPlayerTable(0);

	/////////////////////////////////////////////////////////////////
    ///////////////////  Bind actions on buttons  ///////////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesPlayer').click(function(){
		var dataID = $(this).attr('idPlayer'); // get the current Player's ID
		updatePlayer(dataID);
	});

	$('#btnCreatePlayer').click(function(){
		insertPlayer();
	});

	/////////////////////////////////////////////////////////////////
    /////////////////////  reset modal's forms  /////////////////////
    /////////////////////////////////////////////////////////////////

    $('#addPlayerModal').on('hide.bs.modal', function(){
		$("#formCreatePlayer")[0].reset();
	});

});//Ready


	/////////////////////////////////////////////////////////////////
    //////////////  functions made for opening modals  //////////////
    /////////////////////////////////////////////////////////////////

function showAddPlayerModal(){
	$('#addPlayerModal').modal('show');
};

function showAddNewsModal(){
	$('#addNewsModal').modal('show');
};

	/////////////////////////////////////////////////////////////////
    ////////////////// Check/Uncheck all checkbox  //////////////////
    /////////////////////////////////////////////////////////////////

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxPlayer').prop('checked', true);
	else
		$('.checkboxPlayer').prop('checked', false);
};




								/****************************************************/
								/*************** quest's functions **************/
								/****************************************************/

function fillPlayerTable(page){

	$('#optionPlayer').empty();
	$('#optionPlayer').append('<button id="addquest" onclick="showAddPlayerModal()">Add Player</button>'+
							 '<button id="deleteSelected" onclick="deleteMultiplePlayer()">Delete Selected</button>');
							 

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php"+url,
	    data: {'role': "tablePlayer" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTablePlayers').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.quest){

			    $('#bodyTablePlayers').append( '<tr>'+
												'<td>'+response.quest[i]['ID_QUEST']+'</td>'+
												'<td>'+response.quest[i]['NAME']+'</td>'+
												'<td>'+response.quest[i]['DATE_DEB']+'</td>'+
												'<td>'+response.quest[i]['DURATION']+'</td>'+
												'<td>'+response.quest[i]['FEE']+'</td>'+
												'<td>'+
													'<button class="altPlayer" onclick="fillPlayerInfos('+response.quest[i]['ID_QUEST']+');">Update</button>'+
													'<button class="suprPlayer" onclick="deletePlayer('+response.quest[i]['ID_QUEST']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedPlayer" value="'+response.quest[i]['ID_QUEST']+'" class="checkboxPlayer">'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillPlayerTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillPlayerTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillPlayerTable('+nextPage+')">'+
									'<a href="#" aria-label="Next">'+
										'<span aria-hidden="true">&raquo;</span>'+
									'</a>'+
								'</li>')

		if (nextPage > response.nbPage){
			$('#nextArrow').attr('class', 'disabled');
			$('#nextArrow').removeAttr('onclick');
		}
		
	});
};

function fillPlayerInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'id': id, 'role': "infosPlayers" },
	    dataType: 'json',
	    success: function(response){
	         $('#updateName').val(response.quest[0]['NAME']);
	         $('#updateStartingDate').val(response.quest[0]['DATE_DEB']);
	         $('#updateDuration').val(response.quest[0]['DURATION']);
	         $('#updateFee').val(response.quest[0]['FEE']);
	    }
	});
	$('#btnSaveChangesPlayer').attr('idPlayer', id); //get the ID for the Update fonction
	$('#updatePlayerModal').modal('show');
};

function updatePlayer(id){

	var json_option = {
	    NAME : $('#updateName').val(),
	    DATE_DEB : $('#updateStartingDate').val(),
	    DURATION : $('#updateDuration').val(),
	    FEE : $('#updateFee').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updatePlayer" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillPlayerTable(currentPage);
		$('#updatePlayerModal').modal('hide');
	});
};

function deletePlayer(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'id': id, 'role': "deletePlayer" }
	}).done(function(){
		fillPlayerTable(0);
		alert("Player erased!")
	});
};

function deleteMultiplePlayer(){

	var questChecked = new Array();
	$("input:checked[name=selectedPlayer]").each(function() { //get the ID of all elements selected
		console.log($(this).val());
		questChecked.push($(this).val());
	});

	console.log(questChecked);

	if (questChecked.length < 1) {
		alert("You must select at least 1 quest");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'data': questChecked, 'role': "deleteMultiplePlayer" }
	}).done(function(){
		fillPlayerTable(0);
		
	});
};

function insertPlayer(){

	var json_option = {
	    NAME : $('#addName').val(),
	    DATE_DEB : $('#addStartingDate').val(),
	    DURATION : $('#addDuration').val(),
	    FEE : $('#addFee').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'data': json_option, 'role': "insertPlayer" }
	}).done(function(){
		$('#addPlayerModal').modal('hide');
		fillPlayerTable(0);
		alert("Player inserted!")
	});
};
