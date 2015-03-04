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

	$('#btnCreateNewspaper').click(function(){
		insertNewspaper();
	});

});//Ready


function showAddModal(){
	$('#addNewspaperModal').modal('show');
};


								/****************************************************/
								/*************** Newspaper's functions **************/
								/****************************************************/

function fillNewsPage(page){

	$("#optionNews").empty();
	$("#optionNews").append('<input type="checkbox" name="selectAll" id="selectAll">'+
							 '<label for="selectAll">SelectAll</label>'+
							 '<button id="addNewspaper" onclick="showAddModal()">Add Newspaper</button>'+
							 '<button id="deleteSelected" onclick="deleteMultipleNewspaper()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php"+url,
	    data: {'role': "newspaper" },
	    dataType: 'json',
	    success: function(response){

			$('#goBack').empty();
			$('#divNewspapers').empty();
			//On boucle sur news pour remplir la page
			for(i in response.newspaper){
			    $('#divNewspapers').append(	 '<div class="contentNews">'+
					    						 '<div id="actnsNewspapers'+response.newspaper[i]['ID_NEWSPAPER']+'" class="actnsNewspapers">'+
						    						 '<input type="checkbox" name="selectedNewsPaper"value="'+response.newspaper[i]['ID_NEWSPAPER']+'" class="checkboxNewsPaper">'+
						    						 '<button class="altNewspaper" onclick="fillNewspaperInfos('+response.newspaper[i]['ID_NEWSPAPER']+');">Update</button>'+
						    						 '<button class="suprNewspaper" onclick="deleteNewspaper('+response.newspaper[i]['ID_NEWSPAPER']+');">Delete</button>');

			    if(response.newspaper[i]['STATUS'] == 0){
					$('#actnsNewspapers'+response.newspaper[i]['ID_NEWSPAPER']).append('<button class="publishNewspaper" onclick="publishNewspaper('+response.newspaper[i]['ID_NEWSPAPER']+');">Publish</button>');
				}

				$('#divNewspapers').append(	 	'</div>'+
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
	$('#updateNewspaperModal').modal('show');
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
		$('#updateNewspaperModal').modal('hide');
	});
};

function publishNewspaper(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'id': id, 'role': "publishNewspaper" }
	}).done(function(){
		fillNewsPage(0);
		alert('Newspaper published!');
	});
};

function deleteNewspaper(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'id': id, 'role': "deleteNewspaper" }
	}).done(function(){
		fillNewsPage(0);
		alert("Newspaper erased!")
	});
};

function deleteMultipleNewspaper(){

	var newspaperChecked = new Array();
	$("input:checked[name=selectedNewsPaper]").each(function() { //get the ID of all elements selected
		newspaperChecked.push($(this).val());
	});

	if (newspaperChecked.length < 1) {
		alert("You must select at least 1 newspaper");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'data': newspaperChecked, 'role': "deleteMultipleNewspaper" }
	}).done(function(){
		fillNewsPage(0);
		
	});
};

function insertNewspaper(){

	var json_option = {
	    QUICK_RESUME : $('#insertResume').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'data': json_option, 'role': "insertNewspaper" }
	}).done(function(){
		$('#addNewspaperModal').modal('hide');
		fillNewsPage(0);
		alert("Newspaper inserted!")
	});
};


								/****************************************************/
								/*************** Newspaper's functions **************/
								/****************************************************/


function afficheArticle(id, page){

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$("#optionNews").empty();
	$("#optionNews").append('<button class="suprNews" onclick="insertNews();">Create Article</button>');
	$('#goBack').empty();
	$('#goBack').append('<button onclick="fillNewsPage(0)">Go back</button>');

	$.ajax({
	    type: "POST", //Sending method
	    url: "Handler/editorialiste.hand.php"+url,
	    data: {'id': id, 'role': "news"},
	    dataType: 'json',
	    success: function(response){

			$('#divNewspapers').empty();
			$('#divNewspapers').attr('idNewspaper', response.newspaper[0]);
			//On boucle sur news pour remplir la page
			for(i in response.news){
				$("#optionNews").append('<button class="altNews" onclick="fillNewsInfos('+response.news[i]['ID_NEWS']+');">Update</button>'+
						    		    '<button class="suprNews" onclick="deleteNews('+response.news[i]['ID_NEWS']+');">Delete</button>');
			    
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

/*function fillNewsInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'id': id, 'role': "infosNews" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterResume').val(response.newspaper[0]['QUICK_RESUME']);
	    }
	});
	$('#btnSaveChangesNewspaper').attr('idNewspaper', id); //get the ID for the Update fonction
	$('#updateNewspaperModal').modal('show');
};

function updateNewspaper(id){

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
	$('#updateNewspaperModal').modal('show');
};*/

function deleteNews(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/editorialiste.hand.php",
	    data: {'id': id, 'role': "deleteNews" },
	    dataType: 'json',
	}).done(function(){
		afficheArticle($('#divNewspapers').attr('idNewspaper'), 0);
		alert("News deleted!")
	});
};
