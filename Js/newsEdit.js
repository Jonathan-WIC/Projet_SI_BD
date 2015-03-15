$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ///////////////////////// fill the page ////////////////////////
    ////////////////////////////////////////////////////////////////

    fillNewsPage(0);


	/////////////////////////////////////////////////////////////////
    ///////////////////  Bind actions on buttons  ///////////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesNewspaper').click(function(){
		var dataID = $(this).attr('idNewspaper'); // get the current Newspaper's ID
		updateNewspaper(dataID);
	});

	$('#btnCreateNewspaper').click(function(){
		insertNewspaper();
	});

	$("#btnSaveChangesNews").click(function(e) {
		e.preventDefault();
		$("#formUpdateNews").submit();
	});

	$("#btnCreateNews").click(function(e) {
		e.preventDefault();
		$("#formCreateNews").submit();
	});


	/////////////////////////////////////////////////////////////////
    /////////////  form's handler (ajax + upload file)  /////////////
    /////////////////////////////////////////////////////////////////

    //Update News
	$('#formUpdateNews').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();

        //verify fields
        if ($.trim($('#updateTitle').val()) == '' || $.trim($('#updateContent').val()) == '') {
        	alert("You must fill all required fields");
        	return false;
        }

        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
 
        $.ajax({
            url: "Handler/"+MDBase+".hand.php",
            type: $form.attr('method'),
            contentType: false, // obligatoire pour de l'upload
            processData: false, // obligatoire pour de l'upload
            dataType: 'json', 	// selon le retour attendu
            data: data,
        }).done(function(){
			var currentPage = $('.active').attr('id').replace("page", "");
			idNewspaper = $('#divNewspapers').attr('idNewspaper');
			afficheArticle(idNewspaper, currentPage);
			$('#updateNewsModal').modal('hide');
		});
    });

    //Create News
	$('#formCreateNews').on('submit', function (e) {
        // On empêche le navigateur de soumettre le formulaire
        e.preventDefault();

        //verify fields
        if ($.trim($('#addTitle').val()) == '' || $.trim($('#addContent').val()) == '') {
        	alert("You must fill all required fields");
        	return false;
        }

        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
 
        $.ajax({
            url: "Handler/"+MDBase+".hand.php",
            type: $form.attr('method'),
            contentType: false, // obligatoire pour de l'upload
            processData: false, // obligatoire pour de l'upload
            dataType: 'json', 	// selon le retour attendu
            data: data,
        }).done(function(){
			idNewspaper = $('#divNewspapers').attr('idNewspaper');
			afficheArticle(idNewspaper, 0);
			$('#addNewsModal').modal('hide');
		});
    });


	/////////////////////////////////////////////////////////////////
    /////////////////////  reset modal's forms  /////////////////////
    /////////////////////////////////////////////////////////////////

    $('#addNewsModal').on('hide.bs.modal', function(){
		$("#formCreateNews")[0].reset();
	});

    $('#addNewspaperModal').on('hide.bs.modal', function(){
		$("#formCreateNewspaper")[0].reset();
	});


});//Ready



var MDBase = "";
if($('#valMD') == 0)
	MDBase = "editorialiste";
else
	MDBase = "developpeur";


	/////////////////////////////////////////////////////////////////
    //////////////  functions made for opening modals  //////////////
    /////////////////////////////////////////////////////////////////

function showAddNewspaperModal(){
	$('#addNewspaperModal').modal('show');
};

function showAddNewsModal(){
	$('#addNewsModal').modal('show');
};


	/////////////////////////////////////////////////////////////////
    ////////////////// Check/Uncheck all checkbox  //////////////////
    /////////////////////////////////////////////////////////////////

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxNewsPaper').prop('checked', true);
	else
		$('.checkboxNewsPaper').prop('checked', false);
};

								/****************************************************/
								/*************** Newspaper's functions **************/
								/****************************************************/

function fillNewsPage(page){

	$("#optionNews").empty();
	$("#optionNews").append('<input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll()">'+
							 '<label for="selectAll">SelectAll</label>'+
							 '<button id="addNewspaper" onclick="showAddNewspaperModal()">Add Newspaper</button>'+
							 '<button id="deleteSelected" onclick="deleteMultipleNewspaper()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php"+url,
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
								    				 	'<h3>Journal N° '+response.newspaper[i]['ID_NEWSPAPER']+'<span class="dateDivNewspaper">'+response.newspaper[i]['PUBLICATION'].substring(0, 10)+'</span></h3>'+
								    				 '</div>'+
								    				 '<hr style="border-color: #000; border-style: solid;">'+
								    				 '<div class="col-md-11">'+
								    				 	'<p>'+response.newspaper[i]['SUMMARY']+'</p>'+
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
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'id': id, 'role': "infosNewspapers" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterResume').val(response.newspaper[0]['SUMMARY']);
	    }
	});
	$('#btnSaveChangesNewspaper').attr('idNewspaper', id); //get the ID for the Update fonction
	$('#updateNewspaperModal').modal('show');
};

function updateNewspaper(id){

	//verify fields
	if ($.trim($('#alterResume').val()) == '') {	// trim is used to remove the white space at the begining 
		alert("You must fill all required fields");	// and the end of a string
		return false;
	}

	var json_option = {
	    SUMMARY : $('#alterResume').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
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
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'id': id, 'role': "publishNewspaper" }
	}).done(function(){
		fillNewsPage(0);
		alert('Newspaper published!');
	});
};

function deleteNewspaper(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
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
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'data': newspaperChecked, 'role': "deleteMultipleNewspaper" }
	}).done(function(){
		fillNewsPage(0);
		
	});
};

function insertNewspaper(){

	//verify fields
	if ($.trim($('#insertResume').val()) == '') {	// trim is used to remove the white space at the begining 
		alert("You must fill all required fields");		// and the end of a string
		return false;
	}

	var json_option = {
	    SUMMARY : $('#insertResume').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'data': json_option, 'role': "insertNewspaper" }
	}).done(function(){
		$('#addNewspaperModal').modal('hide');
		fillNewsPage(0);
		alert("Newspaper inserted!")
	});
};


								/**************************************************/
								/************* Article's functions **************/
								/**************************************************/


function afficheArticle(id, page){

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$("#optionNews").empty();
	$("#optionNews").append('<button onclick="showAddNewsModal();">Create Article</button>');
	$('#goBack').empty();
	$('#goBack').append('<button onclick="fillNewsPage(0)">Go back</button>');

	$.ajax({
	    type: "POST", //Sending method
	    url: "Handler/"+MDBase+".hand.php"+url,
	    data: {'id': id, 'role': "news"},
	    dataType: 'json',
	    success: function(response){

			$('#divNewspapers').empty();
			$('#divNewspapers').attr('idNewspaper', id);
			$('#recupNewspaperId').val(id);
			//On boucle sur news pour remplir la page

			if(response.news.length == 0){
				$('#divNewspapers').append('<div class="headerDivNewspaper">'+
											"Aucun article n'a encore été inséré dans ce journal.");
			}

			for(i in response.news){

				if(response.news[i]['PICTURE'][0] == '.'){ 
					response.news[i]['PICTURE'] = response.news[i]['PICTURE'].substr(3);
				}

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

function fillNewsInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'id': id, 'role': "infosNews" },
	    dataType: 'json',
	    success: function(response){
	         $('#updateTitle').val(response.news[0]['TITLE']);
	         $('#updateContent').val(response.news[0]['CONTENT']);
	    }
	});
	$('#recupNewsId').val(id); //get the ID for the Update fonction
	$('#updateNewsModal').modal('show');
};

function deleteNews(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/"+MDBase+".hand.php",
	    data: {'id': id, 'role': "deleteNews" },
	    dataType: 'json',
	}).done(function(){
		afficheArticle($('#divNewspapers').attr('idNewspaper'), 0);
		alert("News deleted!")
	});
};
