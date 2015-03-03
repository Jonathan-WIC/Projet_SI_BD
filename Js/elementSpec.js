$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillElementTable(0);
    fillSelectElement();

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Element //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesElement').click(function(){
		var dataID = $(this).attr('idElement'); // get the current monster's ID
		updateElementInfos(dataID);
	});

});//Ready

function fillElementTable(page){

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php"+url,
	    data: {'role': "tableElement" },
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

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillElementTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillElementTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillElementTable('+nextPage+')">'+
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

function fillSelectElement(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'role': "element"},
	    dataType: 'json',
	    success: function(response){
	    	for(i in response.element){
	    		$('.selectElements').append('<option value='+ response.element[i]['ID_ELEMENT'] +'>'+ response.element[i]['LIB_ELEMENT'] +'</option>');
	        }
	    }
	});
};