$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ///////////////////////// fill the page ////////////////////////
    ////////////////////////////////////////////////////////////////

    fillNewsPage(0);

});//Ready

function fillNewsPage(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/client.hand.php"+url,
	    data: {'role': "newspaper" },
	    dataType: 'json',
	    success: function(response){

			$('#goBack').empty();
			$('#divNewspapers').empty();
			//On boucle sur news pour remplir la page
			for(i in response.newspaper){
			    $('#divNewspapers').append('<div id="newspaper'+response.newspaper[i]['ID_NEWSPAPER']+'" class="divNewspaper row" onclick="getNewspaperId('+response.newspaper[i]['ID_NEWSPAPER']+'); afficheArticle(0);">'  +
				    						 '<div class="headerDivNewspaper">'+
						    				 	'<h3>Journal N° '+response.newspaper[i]['ID_NEWSPAPER']+'<span class="dateDivNewspaper">'+response.newspaper[i]['PUBLICATION'].substring(0, 10)+'</span></h3>'+
						    				 '</div>'+
						    				 '<hr style="border-color: #000; border-style: solid;">'+
						    				 '<div class="col-md-12">'+
						    				 	'<p>'+response.newspaper[i]['SUMMARY']+'</p>'+
						    				 '</div>'+
					    				 '</div>');
			}
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillNewsPage');	

		$('.loaderTable').empty();

	});
};

function afficheArticle(page){

	var id = $('#divNewspapers').attr('idNewspaper');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$('#goBack').empty();
	$('#goBack').append('<button onclick="fillNewsPage(0)">Go back</button>');

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/client.hand.php"+url,
	    data: {'id': id, 'role': "news" },
	    dataType: 'json',
	    success: function(response){

			$('#divNewspapers').empty();
			//On boucle sur news pour remplir la page
			for(i in response.news){

				if(response.news[i]['PICTURE'][0] == '.'){ 
					response.news[i]['PICTURE'] = response.news[i]['PICTURE'].substr(3);
				}

			    $('#divNewspapers').append('<div class="headerDivNewspaper">'+
						    				 '<h3>'+response.news[i]['TITLE']+'</h3>'+
						    			   '</div>'+
						    				 '<div class="col-md-12">'+
						    				 '<img style="float:left" src="'+response.news[i]['PICTURE']+'"/>'+
						    				 	'<p>'+response.news[i]['CONTENT']+'</p>'+
						    				'</div>');
			}
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'afficheArticle');
	});
};

function getNewspaperId(id){
	$('#divNewspapers').attr('idNewspaper', id);
}