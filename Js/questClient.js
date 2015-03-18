var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillQuestTable(0);

});//Ready

function fillQuestTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

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
