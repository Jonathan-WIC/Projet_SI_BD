var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillMaturityTable(0);

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Maturity //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesMaturity').click(function(){
		var dataID = $(this).attr('idMaturity'); // get the current monster's ID
		updateMaturityInfos(dataID);
	});

	$('#btnAddMaturity').click(function(){
		addMaturity();
	});

});//Ready


function showAddMaturityModal(){
	$('#AddMaturityModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxMaturity').prop('checked', true);
	else
		$('.checkboxMaturity').prop('checked', false);
};

function fillMaturityTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	$('#optionMaturity').empty();
	$('#optionMaturity').append('<button id="addMaturity" onclick="showAddMaturityModal()">Add Maturity</button>'+
							   '<button id="deleteMaturity" onclick="deleteMultipleMaturity()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'role': "tableMaturity" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableMaturitys').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.maturity){
			    $('#bodyTableMaturitys').append( '<tr>'+
												'<td>'+response.maturity[i]['ID_MATURITY']+'</td>'+
												'<td>'+response.maturity[i]['LIB_MATURITY']+'</td>'+
												'<td>'+
													'<button class="altMaturity" onclick="fillMaturityInfos('+response.maturity[i]['ID_MATURITY']+');" >Modif</button>'+
													'<button class="deleteMaturity" onclick="deleteMaturity('+response.maturity[i]['ID_MATURITY']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedMaturity" value="'+response.maturity[i]['ID_MATURITY']+'" class="checkboxMaturity">'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillMaturityTable');

		// Application de DataTable à un tableau
		table = $('#tableMaturitys').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();

	});
};

function fillMaturityInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "infosMaturitys" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterNameMaturity').val(response.maturityInfos[0]['LIB_MATURITY']);
	    }
	});
	$('#btnSaveChangesMaturity').attr('idMaturity', id); //get the ID for the Updtae fonction
	$('#UpdateMaturityModal').modal('show');
};

function updateMaturityInfos(id){

	if ($('#alterNameMaturity').val().trim() == '') {
		alert("You must fill all required fields");
		return false;
	}

	var json_option = {
	    NAME : $('#alterNameMaturity').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateMaturity" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillMaturityTable(currentPage);
		$('#UpdateMaturityModal').modal('hide');
	});

};

function deleteMaturity(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deleteMaturity"},
	    dataType: 'json'
	}).done(function(){
		alert("Maturity deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillMaturityTable(currentPage);
	});
};

function deleteMultipleMaturity(){
	
	var maturityChecked = new Array();
	$("input:checked[name=selectedMaturity]").each(function() { //get the ID of all maturitys selected
		maturityChecked.push($(this).val());
	});

	if (maturityChecked.length < 1) {
		alert("You must select at least 1 maturity");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': maturityChecked, 'role': "deleteMultipleMaturity" }
	}).done(function(){
		alert("Maturitys deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillMaturityTable(currentPage);
	});
};

function addMaturity(){
	
	//verify fields
	if ($('#addNameMaturity').val().trim() == '') {// trim is used to remove the white space at the begining and the end
		alert("you must fill corectly all required fields!");
		return false;
	}

	var json_option = {
	    NAME : $('#addNameMaturity').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addMaturity" }
	}).done(function(){
		$('#AddMaturityModal').modal('hide');
		alert("Maturity created!")
		fillMaturityTable(0);
	});

};
