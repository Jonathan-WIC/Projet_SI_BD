var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillItemTable(0);

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Item //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesItem').click(function(){
		var dataID = $(this).attr('idItem'); // get the current monster's ID
		updateItemInfos(dataID);
	});

	$('#btnAddItem').click(function(){
		addItem();
	});

});//Ready


function showAddItemModal(){
	$('#AddItemModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxItem').prop('checked', true);
	else
		$('.checkboxItem').prop('checked', false);
};

function fillItemTable(page){

	if(table){
		table.destroy();
	}

	$('#optionItem').empty();
	$('#optionItem').append('<button id="addItem" onclick="showAddItemModal()">Add Item</button>'+
							   '<button id="deleteItem" onclick="deleteMultipleItem()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'role': "tableItem" },
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableItems').empty();
			//On boucle sur monsters pour remplir le tableau des carac
			for(i in response.item){
			    $('#bodyTableItems').append( '<tr>'+
											 	'<td>'+response.item[i]['ID_ITEM']+'</td>'+
											 	'<td>'+response.item[i]['LIB_ITEM']+'</td>'+
											 	'<td>'+response.item[i]['TYPE_ITEM']+'</td>'+
											 	'<td>'+response.item[i]['FAMILY_ITEM']+'</td>'+
											 	'<td>'+response.item[i]['PRIX_ITEM']+'</td>'+
											 	'<td>'+
											 		'<button class="altItem" onclick="fillItemInfos('+response.item[i]['ID_ITEM']+');" >Modif</button>'+
											 		'<button class="deleteItem" onclick="deleteItem('+response.item[i]['ID_ITEM']+');">Delete</button>'+
											 	'</td>'+
											 	'<td>'+
											 		'<input type="checkbox" name="selectedItem" value="'+response.item[i]['ID_ITEM']+'" class="checkboxItem">'+
											 	'</td>'+
				    				 		 '</tr>');
			}
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillItemTable');

		// Application de DataTable à un tableau
		table = $('#tableItems').DataTable({
			paging: false,
			searching: false,
			info: false
		});

	});
};

function fillItemInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "infosItems" },
	    dataType: 'json',
	    success: function(response){
	    	$('#alterNameItem').val(response.itemInfos[0]['LIB_ITEM']);
	    	$('#selectAlterTypeItem option[value="'+response.itemInfos[0]['TYPE_ITEM']+'"]').prop('selected', true);
	    	$('#selectAlterFamilyItem option[value="'+response.itemInfos[0]['FAMILY_ITEM']+'"]').prop('selected', true);
	    	$('#alterPriceItem').val(response.itemInfos[0]['PRIX_ITEM']);
	    }
	});
	$('#btnSaveChangesItem').attr('idItem', id); //get the ID for the Updtae fonction
	$('#UpdateItemModal').modal('show');
};

function updateItemInfos(id){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#alterNameItem').val().trim() == ""){
		alert("You must fill correctly fill the Name's field");
		return false;
	}
	if(isNaN(parseFloat($('#alterPriceItem').val())) || $('#alterPriceItem').val().trim() < 0 || $('#alterPriceItem').val().trim() > 99999){
		alert("The capacity's value must be beetween 0 and 99 999");
		return false;
	}

	var json_option = {
	    LIB_ITEM : $('#alterNameItem').val(),
	    TYPE_ITEM : $('#selectAlterTypeItem').val(),
	    FAMILY_ITEM : $('#selectAlterFamilyItem').val(),
	    PRIX_ITEM : $('#alterPriceItem').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateItem"}
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillItemTable(currentPage);
		$('#UpdateItemModal').modal('hide');
	});

};

function deleteItem(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deleteItem"},
	    dataType: 'json'
	}).done(function(){
		alert("Item deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillItemTable(currentPage);
	});
};

function deleteMultipleItem(){
	
	var itemChecked = new Array();
	$("input:checked[name=selectedItem]").each(function() { //get the ID of all items selected
		itemChecked.push($(this).val());
	});

	if (itemChecked.length < 1) {
		alert("You must select at least 1 item");
		return false;
	}

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': itemChecked, 'role': "deleteMultipleItem" }
	}).done(function(){
		alert("Items deleted");
		var currentPage = $('.active').attr('id').replace("page", "");
		fillItemTable(currentPage);
	});
};

function addItem(){

	/*****************************
	 ******* verify fields *******
	 *****************************/

	if ($('#addNameItem').val().trim() == ""){
		alert("You must fill correctly fill the Name's field");
		return false;

	}
	if(isNaN(parseFloat($('#addPriceItem').val())) || $('#addPriceItem').val().trim() < 0 || $('#addPriceItem').val().trim() > 99999){
		alert("The capacity's value must be beetween 0 and 99 999");
		return false;
	}

	var json_option = {
	    LIB_ITEM : $('#addNameItem').val(),
	    TYPE_ITEM : $('#selectAddTypeItem').val(),
	    FAMILY_ITEM : $('#selectAddFamilyItem').val(),
	    PRIX_ITEM : $('#addPriceItem').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addItem"}
	}).done(function(){
		$('#AddItemModal').modal('hide');
		alert("Item created!")
		fillItemTable(0);
	});

};
