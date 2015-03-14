$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillElementTable(0);

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Element //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesElement').click(function(){
		var dataID = $(this).attr('idElement'); // get the current element's ID
		updateElementInfos(dataID);
	});

	$('#btnAddElement').click(function(){
		addElement();
	});

});//Ready


function showAddElementModal(){
	$('#AddElementModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxElement').prop('checked', true);
	else
		$('.checkboxElement').prop('checked', false);
};

function fillElementTable(page){

	$('#optionElement').empty();
	$('#optionElement').append('<button id="addElement" onclick="showAddElementModal()">Add Element</button>'+
							   '<button id="deleteElement" onclick="deleteMultipleElement()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'role': "tableElement" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableElements').empty();
			//On boucle sur elements pour remplir le tableau des carac
			for(i in response.element){
			    $('#bodyTableElements').append( '<tr>'+
												'<td>'+response.element[i]['ID_ELEMENT']+'</td>'+
												'<td>'+response.element[i]['LIB_ELEMENT']+'</td>'+
												'<td>'+
													'<button class="altElement" onclick="fillElementInfos('+response.element[i]['ID_ELEMENT']+');">Modif</button>'+
													'<button class="deleteElement" onclick="deleteElement('+response.element[i]['ID_ELEMENT']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedElement" value="'+response.element[i]['ID_ELEMENT']+'" class="checkboxElement">'+
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
	    url:"Handler/developpeur.hand.php",
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
	if ($('#alterNameElement').val().trim() == '') {// trim is used to remove the white space at the begining and the end
		alert("you must fill corectly all required fields!");
		return false;
	}

	var json_option = {
	    NAME : $('#alterNameElement').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateElement" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillElementTable(currentPage);
		$('#UpdateElementModal').modal('hide');
	});

};

function deleteElement(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deleteElement"},
	    dataType: 'json'
	}).done(function(){
		alert("Element deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillElementTable(currentPage);
	});
};

function deleteMultipleElement(){
	
	var elementChecked = new Array();
	$("input:checked[name=selectedElement]").each(function() { //get the ID of all elements selected
		elementChecked.push($(this).val());
	});

	if (elementChecked.length < 1) {
		alert("You must select at least 1 element");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': elementChecked, 'role': "deleteMultipleElement" }
	}).done(function(){
		alert("Elements deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillElementTable(currentPage);
	});
};

function addElement(){
	
	//verify fields
	if ($('#addNameElement').val().trim() == '') {// trim is used to remove the white space at the begining and the end
		alert("you must fill corectly all required fields!");
		return false;
	}

	var json_option = {
	    NAME : $('#addNameElement').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addElement" }
	}).done(function(){
		$('#addElementModal').modal('hide');
		alert("Element created!")
		fillElementTable(0);
	});

};
