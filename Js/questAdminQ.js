var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ///////////////////////// fill the page ////////////////////////
    ////////////////////////////////////////////////////////////////

    fillSelectItems();
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


var MDBase = "";
if($('#valMD') == 0)
	MDBase = "adminquest";
else
	MDBase = "developpeur";

	/////////////////////////////////////////////////////////////////
    //////////////  functions made for opening modals  //////////////
    /////////////////////////////////////////////////////////////////

function showAddQuestModal(){
	$('#addQuestModal').modal('show');
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


	/////////////////////////////////////////////////////////////////
    ////////////////////// fill Item's select  //////////////////////
    /////////////////////////////////////////////////////////////////

function fillSelectItems(){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'role': "fillItems" },
	    dataType: 'json',
	    success: function(response){
  
	    	$(".selectItem").append('<option value="'+null+'">N/A</option>');

			//On remplit les selects liés aux items dans les modales
			for(i in response.item){
            	$(".selectItem").append('<option value="'+response.item[i]['ID_ITEM']+'">'+response.item[i]['LIB_ITEM']+'</option>');
            }

	    }
	});
}


								/****************************************************/
								/***************** Quest's functions ****************/
								/****************************************************/

function fillQuestTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	$('#optionQuest').empty();
	$('#optionQuest').append('<button id="addquest" onclick="showAddQuestModal()">Add Quest</button>'+
							 '<button id="deleteSelected" onclick="deleteMultipleQuest()">Delete Selected</button>');
							 

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php"+url,
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
													'<select id="questItem'+response.quest[i]['ID_QUEST']+'" class="questItemTable">'+
													'</select>'+
												'</td>'+
												'<td>'+
													'<button class="altQuest" onclick="fillQuestInfos('+response.quest[i]['ID_QUEST']+');">Update</button>'+
													'<button class="suprQuest" onclick="deleteQuest('+response.quest[i]['ID_QUEST']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedQuest" value="'+response.quest[i]['ID_QUEST']+'" class="checkboxQuest">'+
												'</td>'+
				    				 			'</tr>');
			}


			//On remplit les selects liés aux items des quests
			for(i in response.item){
            	$('#questItem'+response.item[i]['ID_QUEST']).append('<option>'+response.item[i]['LIB_ITEM']+'</option>');
            }

            //On cherche les selects qui ne sont pas remplis (les quest qui n'ont pas d'item) et on met le 'N/A' par défaut
            $('.questItemTable:empty').append('<option>N/A</option>');

	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillQuestTable');

		// Application de DataTable à un tableau
		table = $('#tableQuests').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();

	});
};


function fillQuestInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'id': id, 'role': "infosQuests" },
	    dataType: 'json',
	    success: function(response){
	        $('#updateName').val(response.quest[0]['NAME']);
	        $('#updateStartingDate').val(response.quest[0]['DATE_DEB']);
	        $('#updateDuration').val(response.quest[0]['DURATION']);
	        $('#updateFee').val(response.quest[0]['FEE']);

	        //fill the select item reward
	        if(response.item.length > 0){
	        	for (var i = 0; i < response.item.length; i++) {
		        	//id of selects begin at 1, so we make i+1 to fill the good select :-)
		        	$('#selectUpdateReward'+(i+1)+' option[value="'+response.item[i]['ID_ITEM']+'"]').prop('selected', true);
		        };
	        } else{
	        	$('#selectUpdateReward1 option[value="null"]').prop('selected', true);
	        	$('#selectUpdateReward2 option[value="null"]').prop('selected', true);
	        }
		         
	    }
	});
	$('#btnSaveChangesQuest').attr('idQuest', id); //get the ID for the Update fonction
	$('#updateQuestModal').modal('show');
};


function updateQuest(id){


	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#updateName').val().trim() == ""){
		alert("You must fill correctly fill the Name fields");
		return false;
	}
	if($('#updateStartingDate').val().trim() == "" && $('#updateStartingDate').val().trim().length != 10){
		alert("You must fill correctly fill the Starting date field (format is 'YYYY-MM-DD'");
		return false;
	}
	if(isNaN(parseFloat($('#updateDuration').val())) || $('#updateDuration').val().trim() < 0 || $('#updateDuration').val().trim() > 365){
		alert("The duration's value must be beetween 0 and 365");
		return false;
	}
	if(isNaN(parseFloat($('#updateFee').val())) || $('#updateFee').val().trim() < 0 || $('#updateFee').val().trim() > 1000000){
		alert("The fee's value must be beetween 0 and 1 000 000");
		return false;
	}


	var json_option = {
	    NAME : $('#updateName').val(),
	    DATE_DEB : $('#updateStartingDate').val(),
	    DURATION : $('#updateDuration').val(),
	    FEE : $('#updateFee').val()
	};

	var json_reward = [
		$('#selectUpdateReward1').val(),
		$('#selectUpdateReward2').val()
	];

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'id': id, 'data': json_option, 'reward': json_reward, 'role': "updateQuest" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillQuestTable(currentPage);
		$('#updateQuestModal').modal('hide');
	});
};


function deleteQuest(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'id': id, 'role': "deleteQuest" }
	}).done(function(){
		fillQuestTable(0);
		alert("Quest erased!")
	});
};


function deleteMultipleQuest(){

	var questChecked = new Array();
	$("input:checked[name=selectedQuest]").each(function() { //get the ID of all elements selected
		questChecked.push($(this).val());
	});

	if (questChecked.length < 1) {
		alert("You must select at least 1 quest");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'data': questChecked, 'role': "deleteMultipleQuest" }
	}).done(function(){
		fillQuestTable(0);
		
	});
};


function insertQuest(){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#addName').val().trim() == ""){
		alert("You must fill correctly fill the Name fields");
		return false;
	}
	if($('#addStartingDate').val().trim() == "" && $('#addStartingDate').val().trim().length != 10){
		alert("You must fill correctly fill the Starting date field (format is 'YYYY-MM-DD'");
		return false;
	}
	if(isNaN(parseFloat($('#addDuration').val())) || $('#addDuration').val().trim() < 0 || $('#addDuration').val().trim() > 365){
		alert("The duration's value must be beetween 0 and 365");
		return false;
	}
	if(isNaN(parseFloat($('#addFee').val())) || $('#addFee').val().trim() < 0 || $('#addFee').val().trim() > 1000000){
		alert("The fee's value must be beetween 0 and 1 000 000");
		return false;
	}

	var json_option = {
	    NAME : $('#addName').val(),
	    DATE_DEB : $('#addStartingDate').val(),
	    DURATION : $('#addDuration').val(),
	    FEE : $('#addFee').val()
	};

	var tab_reward = [
		$('#selectInsertReward1').val(),
		$('#selectInsertReward2').val()
	];

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'data': json_option, 'data_reward': tab_reward, 'role': "insertQuest" }
	}).done(function(){
		$('#addQuestModal').modal('hide');
		fillQuestTable(0);
		alert("Quest inserted!")
	});
};
