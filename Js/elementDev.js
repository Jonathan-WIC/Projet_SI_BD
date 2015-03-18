var table;
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

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	$('#optionElement').empty();
	$('#optionElement').append('<button id="addElement" onclick="showAddElementModal()">Add Element</button>'+
							   '<button id="deleteElement" onclick="deleteMultipleElement()">Delete Selected</button>');

	var json_option = {
		LIB_ELEMENT: $('#searchNameElement').val()
	};

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'data': json_option, 'role': "tableElement" },
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
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillElementTable');

		// Application de DataTable à un tableau
		table = $('#tableElements').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();

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
		$('#AddElementModal').modal('hide');
		alert("Element created!")
		fillElementTable(0);
	});

};
