var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillElementTable(0);

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Element //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesElement').click(function(){
		var dataID = $(this).attr('idElement'); // get the current monster's ID
		updateElementInfos(dataID);
	});

});//Ready

function fillElementTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	var json_option = {
		LIB_ELEMENT: $('#searchNameElement').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
	    data: {'data': json_option, 'role': "tableElement" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableElements').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.element){
			    $('#bodyTableElements').append( '<tr>'+
												'<td>'+response.element[i]['ID_ELEMENT']+'</td>'+
												'<td>'+response.element[i]['LIB_ELEMENT']+'</td>'+
												'<td>'+
													'<button class="altElement" idElement="'+response.element[i]['ID_ELEMENT']+'" onclick="fillElementInfos('+response.element[i]['ID_ELEMENT']+');" >Modif'+
													'</button>'+
												'</td>'+
				    				 			'</tr>');
			}
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillElementTable');

		
		// Application de DataTable à un tableau
		table = $('#tableElements').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();

	});
};

function fillElementInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'role': "infosElements" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterNameElement').val(response.elementInfos[0]['LIB_ELEMENT']);
	    }
	});
	$('#btnSaveChangesElement').attr('idElement', id); //get the ID for the Updtae fonction
	$('#UpdateElementModal').modal('show');
};

function updateElementInfos(id){

	//verify fields
	if ($('#alterNameElement').val().trim() == '') {	// trim is used to remove the white space at the begining 
		alert("You must fill all required fields");		// and the end of a string
		return false;
	}

	var json_option = {
	    NAME : $('#alterNameElement').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateElement" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillElementTable(currentPage);
		$('#UpdateElementModal').modal('hide');
	});

};
