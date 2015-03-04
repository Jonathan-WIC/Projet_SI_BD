$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ///////////////////////// fill the page ////////////////////////
    ////////////////////////////////////////////////////////////////

    fillNewsPage(0);

	/////////////////////////////////////////////////////////////////
    ////////////////// Check/Uncheck all checkbox  //////////////////
    /////////////////////////////////////////////////////////////////

	$("#selectAll").click( function(){
		if( $(this).is(':checked') )
			$('.checkboxNewsPaper').prop('checked', true);
		else
			$('.checkboxNewsPaper').prop('checked', false);
	});

	$('#btnSaveChangesNewspaper').click(function(){
		var dataID = $(this).attr('idNewspaper'); // get the current monster's ID
		updateNewspaper(dataID);
	});

});//Ready


								/****************************************************/
								/****************Newspaper's functions***************/
								/****************************************************/

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
			    $('#divNewspapers').append(	 '<div class="contentNews">'+
					    						 '<div class="actnsNewspapers">'+
						    						 '<input type="checkbox" class="checkboxNewsPaper">'+
						    						 '<button class="altNewspaper" onclick="fillNewspaperInfos('+response.newspaper[i]['ID_NEWSPAPER']+');">Update</button>'+
						    						 '<button class="suprNewspaper" onclick="deleteNewspaper('+response.newspaper[i]['ID_NEWSPAPER']+');">Delete</button>'+
					    						 '</div>'+
					    						 '<div id="newspaper'+response.newspaper[i]['ID_NEWSPAPER']+'" class="divNewspaper row" onclick="afficheArticle('+response.newspaper[i]['ID_NEWSPAPER']+', 0);">'+
						    						 '<div class="headerDivNewspaper">'+
								    				 	'<h3>Journal N° '+response.newspaper[i]['ID_NEWSPAPER']+'<span class="dateDivNewspaper">'+response.newspaper[i]['PUBLICATION']+'</span></h3>'+
								    				 '</div>'+
								    				 '<hr style="border-color: #000; border-style: solid;">'+
								    				 '<div class="col-md-11">'+
								    				 	'<p>'+response.newspaper[i]['QUICK_RESUME']+'</p>'+
								    				 '</div>'+
						    				 	 '</div>'+
					    				 	 '</div>');
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

function fillNewspaperInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'id': id, 'role': "infosNewspapers" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterResume').val(response.newspaper[0]['QUICK_RESUME']);
	    }
	});
	$('#btnSaveChangesNewspaper').attr('idNewspaper', id); //get the ID for the Update fonction
	$('#UpdateNewspaperModal').modal('show');
};

function updateNewspaper(id){

	var json_option = {
	    QUICK_RESUME : $('#alterResume').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateNewspaper" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillNewsPage(currentPage);
		$('#UpdateNewspaperModal').modal('hide');
	});
};

function deleteNewspaper(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'id': id, 'role': "deleteNewspaper" }
	}).done(function(){
		alert("Newspaper erased!")
		fillNewsPage(0);
	});
};




								/****************************************************/
								/****************Newspaper's functions***************/
								/****************************************************/

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
