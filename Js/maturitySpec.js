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

});//Ready

function fillMaturityTable(page){

	if(table){
		table.destroy();
	}

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
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
													'<button class="altMaturity" idMaturity="'+response.maturity[i]['ID_MATURITY']+'" onclick="fillMaturityInfos('+response.maturity[i]['ID_MATURITY']+');" >Modif'+
													'</button>'+
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

	});
};

function fillMaturityInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
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
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateMaturity" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillMaturityTable(currentPage);
		$('#UpdateMaturityModal').modal('hide');
	});

};
