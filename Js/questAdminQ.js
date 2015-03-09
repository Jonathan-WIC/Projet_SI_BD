$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ///////////////////////// fill the page ////////////////////////
    ////////////////////////////////////////////////////////////////

    fillQuestTable(0);

	/////////////////////////////////////////////////////////////////
    ///////////////////  Bind actions on buttons  ///////////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesQuest').click(function(){
		var dataID = $(this).attr('idQuest'); // get the current Quest's ID
		updateQuest(dataID);
	});

	$('#btnCreateQuest').click(function(){
		insertQuest();
	});

	/////////////////////////////////////////////////////////////////
    /////////////////////  reset modal's forms  /////////////////////
    /////////////////////////////////////////////////////////////////

    $('#addQuestModal').on('hide.bs.modal', function(){
		$("#formCreateQuest")[0].reset();
	});

});//Ready


	/////////////////////////////////////////////////////////////////
    //////////////  functions made for opening modals  //////////////
    /////////////////////////////////////////////////////////////////

function showAddQuestModal(){
	$('#addQuestModal').modal('show');
};

function showAddNewsModal(){
	$('#addNewsModal').modal('show');
};

	/////////////////////////////////////////////////////////////////
    ////////////////// Check/Uncheck all checkbox  //////////////////
    /////////////////////////////////////////////////////////////////

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxQuest').prop('checked', true);
	else
		$('.checkboxQuest').prop('checked', false);
};




								/****************************************************/
								/*************** quest's functions **************/
								/****************************************************/

function fillQuestTable(page){

	$('#optionQuest').empty();
	$('#optionQuest').append('<button id="addquest" onclick="showAddQuestModal()">Add Quest</button>'+
							 '<button id="deleteSelected" onclick="deleteMultipleQuest()">Delete Selected</button>');
							 

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php"+url,
	    data: {'role': "tableQuest" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableQuests').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.quest){

			    $('#bodyTableQuests').append( '<tr>'+
												'<td>'+response.quest[i]['ID_QUEST']+'</td>'+
												'<td>'+response.quest[i]['NAME']+'</td>'+
												'<td>'+response.quest[i]['DATE_DEB']+'</td>'+
												'<td>'+response.quest[i]['DURATION']+'</td>'+
												'<td>'+response.quest[i]['FEE']+'</td>'+
												'<td>'+
													'<button class="altQuest" onclick="fillQuestInfos('+response.quest[i]['ID_QUEST']+');">Update</button>'+
													'<button class="suprQuest" onclick="deleteQuest('+response.quest[i]['ID_QUEST']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedQuest" value="'+response.quest[i]['ID_QUEST']+'" class="checkboxQuest">'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillQuestTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillQuestTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillQuestTable('+nextPage+')">'+
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


function fillQuestInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'id': id, 'role': "infosQuests" },
	    dataType: 'json',
	    success: function(response){
	         $('#updateName').val(response.quest[0]['NAME']);
	         $('#updateStartingDate').val(response.quest[0]['DATE_DEB']);
	         $('#updateDuration').val(response.quest[0]['DURATION']);
	         $('#updateFee').val(response.quest[0]['FEE']);
	    }
	});
	$('#btnSaveChangesQuest').attr('idQuest', id); //get the ID for the Update fonction
	$('#updateQuestModal').modal('show');
};

function updateQuest(id){

	var json_option = {
	    NAME : $('#updateName').val(),
	    DATE_DEB : $('#updateStartingDate').val(),
	    DURATION : $('#updateDuration').val(),
	    FEE : $('#updateFee').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateQuest" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillQuestTable(currentPage);
		$('#updateQuestModal').modal('hide');
	});
};

function deleteQuest(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'id': id, 'role': "deleteQuest" }
	}).done(function(){
		fillQuestTable(0);
		alert("Quest erased!")
	});
};

function deleteMultipleQuest(){

	var questChecked = new Array();
	$("input:checked[name=selectedQuest]").each(function() { //get the ID of all elements selected
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
	    data: {'data': questChecked, 'role': "deleteMultipleQuest" }
	}).done(function(){
		fillQuestTable(0);
		
	});
};

function insertQuest(){

	var json_option = {
	    NAME : $('#addName').val(),
	    DATE_DEB : $('#addStartingDate').val(),
	    DURATION : $('#addDuration').val(),
	    FEE : $('#addFee').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/adminquest.hand.php",
	    data: {'data': json_option, 'role': "insertQuest" }
	}).done(function(){
		$('#addQuestModal').modal('hide');
		fillQuestTable(0);
		alert("Quest inserted!")
	});
};
