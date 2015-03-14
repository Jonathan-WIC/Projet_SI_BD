$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillRegimeTable(0);

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Regime //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesRegime').click(function(){
		var dataID = $(this).attr('idRegime'); // get the current monster's ID
		updateRegimeInfos(dataID);
	});

	$('#btnAddRegime').click(function(){
		addRegime();
	});

});//Ready


function showAddRegimeModal(){
	$('#AddRegimeModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxRegime').prop('checked', true);
	else
		$('.checkboxRegime').prop('checked', false);
};

function fillRegimeTable(page){

	$('#optionRegime').empty();
	$('#optionRegime').append('<button id="addRegime" onclick="showAddRegimeModal()">Add Regime</button>'+
							   '<button id="deleteRegime" onclick="deleteMultipleRegime()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'role': "tableRegime" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableRegimes').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.regime){
			    $('#bodyTableRegimes').append( '<tr>'+
												'<td>'+response.regime[i]['ID_REGIME']+'</td>'+
												'<td>'+response.regime[i]['LIB_REGIME']+'</td>'+
												'<td>'+
													'<button class="altRegime" onclick="fillRegimeInfos('+response.regime[i]['ID_REGIME']+');" >Modif</button>'+
													'<button class="deleteRegime" onclick="deleteRegime('+response.regime[i]['ID_REGIME']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedRegime" value="'+response.regime[i]['ID_REGIME']+'" class="checkboxRegime">'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillRegimeTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillRegimeTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillRegimeTable('+nextPage+')">'+
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

function fillRegimeInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "infosRegimes" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterNameRegime').val(response.regimeInfos[0]['LIB_REGIME']);
	    }
	});
	$('#btnSaveChangesRegime').attr('idRegime', id); //get the ID for the Updtae fonction
	$('#UpdateRegimeModal').modal('show');
};

function updateRegimeInfos(id){

	if ($('#alterNameRegime').val().trim() == '') {
		alert("You must fill all required fields");
		return false;
	}

	var json_option = {
	    NAME : $('#alterNameRegime').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateRegime" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillRegimeTable(currentPage);
		$('#UpdateRegimeModal').modal('hide');
	});

};

function deleteRegime(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deleteRegime"},
	    dataType: 'json'
	}).done(function(){
		alert("Regime deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillRegimeTable(currentPage);
	});
};

function deleteMultipleRegime(){
	
	var regimeChecked = new Array();
	$("input:checked[name=selectedRegime]").each(function() { //get the ID of all regimes selected
		regimeChecked.push($(this).val());
	});

	if (regimeChecked.length < 1) {
		alert("You must select at least 1 regime");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': regimeChecked, 'role': "deleteMultipleRegime" }
	}).done(function(){
		alert("Regimes deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillRegimeTable(currentPage);
	});
};

function addRegime(){
	
	//verify fields
	if ($('#addNameRegime').val().trim() == '') {// trim is used to remove the white space at the begining and the end
		alert("you must fill corectly all required fields!");
		return false;
	}

	var json_option = {
	    NAME : $('#addNameRegime').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addRegime" }
	}).done(function(){
		$('#AddRegimeModal').modal('hide');
		alert("Regime created!")
		fillRegimeTable(0);
	});

};
