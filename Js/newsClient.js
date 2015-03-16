$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ///////////////////////// fill the page ////////////////////////
    ////////////////////////////////////////////////////////////////

    fillNewsPage(0);

});//Ready

function fillNewsPage(page){

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
			    $('#divNewspapers').append('<div id="newspaper'+response.newspaper[i]['ID_NEWSPAPER']+'" class="divNewspaper row" onclick="afficheArticle('+response.newspaper[i]['ID_NEWSPAPER']+', 0);">'  +
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

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="fillNewsPage('+ previousPage +')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		if(response.nbPage <= 12){
			for (var i = 1; i <= response.nbPage; i++) {
				$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillNewsPage('+i+')">'+i+'</a></li>');
				if (i == response.page) {
					$('#page'+i).attr('class', 'active');
				}
			}
		} else{
			for (var i = 1; i < 6; i++) {
				$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillNewsPage('+i+')">'+i+'</a></li>');
				if (i == response.page) {
					$('#page'+i).attr('class', 'active');
				}
			}
			for (var i = response.nbPage; i > response.nbPage - 6; i--) {
				$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="fillNewsPage('+i+')">'+i+'</a></li>');
				if (i == response.page) {
					$('#page'+i).attr('class', 'active');
				}
			}
		}

		$('#pagination').append('<li id="nextArrow" onclick="fillNewsPage('+nextPage+')">'+
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

function afficheArticle(id, page){


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
			$('#divNewspapers').attr('idNewspaper', response.newspaper[0]);
			//On boucle sur news pour remplir la page
			for(i in response.news){

				if(response.news[i]['PICTURE'][0] == '.'){ 
					response.news[i]['PICTURE'] = response.news[i]['PICTURE'].substr(3);
				}

			    $('#divNewspapers').append('<div class="headerDivNewspaper">'+
						    				 '<h3>'+response.news[i]['TITLE']+'</h3>'+
						    			   '</div>'+
						    				 '<div class="col-md-12">'+
						    				 '<img style="float:left" alt="news picture" src="'+response.news[i]['PICTURE']+'"/>'+
						    				 	'<p>'+response.news[i]['CONTENT']+'</p>'+
						    				'</div>');
			}
	    }
	}).done(function(response){

		var previousPage = parseInt(response.page - 1);
		var nextPage = parseInt(response.page) + 1;

		$('#pagination').empty();
		$('#pagination').append('<li id="previousArrow" onclick="afficheArticle('+ $('#divNewspapers').attr('idNewspaper') +','+ previousPage+')">'+
									'<a href="#" aria-label="Previous">'+
										'<span aria-hidden="true">&laquo;</span>'+
									'</a>'+
								'</li>');

		if (previousPage == 0){
			$('#previousArrow').attr('class', 'disabled');
			$('#previousArrow').removeAttr('onclick');
		}
		
		for (var i = 1; i <= response.nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="afficheArticle('+ $('#divNewspapers').attr('idNewspaper') +','+ i+')">'+i+'</a></li>');
			if (i == response.page) {
				$('#page'+i).attr('class', 'active');
			}
		}


		$('#pagination').append('<li id="nextArrow" onclick="afficheArticle('+ $('#divNewspapers').attr('idNewspaper') +','+ nextPage +')">'+
									'<a href="#" aria-label="Next">'+
										'<span aria-hidden="true">&raquo;</span>'+
									'</a>'+
								'</li>');

		if (nextPage > response.nbPage){
			$('#nextArrow').attr('class', 'disabled');
			$('#nextArrow').removeAttr('onclick');
		}	
	});
};


//'<img style="float:left" alt="news picture" src="'+response.news[i]['PICTURE']+'"/>'+