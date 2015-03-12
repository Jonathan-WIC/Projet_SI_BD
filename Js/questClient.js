$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillQuestTable(0);

});//Ready

function fillQuestTable(page){

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/client.hand.php"+url,
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
