var table;
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

});//Ready

function fillRegimeTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	var json_option = {
	    LIB_REGIME : $('#searchNameRegime').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
	    data: {'data': json_option, 'role': "tableRegime" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableRegimes').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.regime){
			    $('#bodyTableRegimes').append( '<tr>'+
												'<td>'+response.regime[i]['ID_REGIME']+'</td>'+
												'<td>'+response.regime[i]['LIB_REGIME']+'</td>'+
												'<td>'+
													'<button class="altRegime" idRegime="'+response.regime[i]['ID_REGIME']+'" onclick="fillRegimeInfos('+response.regime[i]['ID_REGIME']+');" >Modif'+
													'</button>'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillRegimeTable');

		// Application de DataTable à un tableau
		table = $('#tableRegimes').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();

	});
};

function fillRegimeInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
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

	//verify fields
	if ($('#alterNameRegime').val().trim() == '') {	// trim is used to remove the white space at the begining 
		alert("You must fill all required fields");		// and the end of a string
		return false;
	}

	var json_option = {
	    NAME : $('#alterNameRegime').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateRegime" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillRegimeTable(currentPage);
		$('#UpdateRegimeModal').modal('hide');
	});

};
