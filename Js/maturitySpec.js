$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillMaturityTable(0);
    fillSelectMaturity();

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Maturity //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesMaturity').click(function(){
		var dataID = $(this).attr('idMaturity'); // get the current monster's ID
		updateMaturityInfos(dataID);
	});

});//Ready

function fillMaturityTable(page){

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

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillMaturityTable('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillMaturityTable('+i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="fillMaturityTable('+nextPage+')">'+
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

function fillSelectMaturity(){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/specialiste.hand.php",
	    data: {'role': "maturity"},
	    dataType: 'json',
	    success: function(response){
	    	for(i in response.maturity){
	    		$('.selectMaturitys').append('<option value='+ response.maturity[i]['ID_MATURITY'] +'>'+ response.maturity[i]['LIB_MATURITY'] +'</option>');
	        }
	    }
	});
};