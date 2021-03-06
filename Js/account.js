var table;
$(document).ready(function(){

	////////////////////////////////////////////////////////////////
    ////////////////////// fill Table of page //////////////////////
    ////////////////////////////////////////////////////////////////

    fillAccountTable(0);

	/////////////////////////////////////////////////////////////////
    ////////////// update infos of the current Account //////////////
    /////////////////////////////////////////////////////////////////

	$('#btnSaveChangesAccount').click(function(){
		var dataID = $(this).attr('idAccount'); // get the current account's ID
		updateAccountInfos(dataID);
	});

	$('#btnAddAccount').click(function(){
		addAccount();
	});

});//Ready


function isEmail(mail){
	// Reg ex pour une addresse mail
	var regEmail = new RegExp('^[0-9a-z._-]+@{1}[0-9a-z.-]{2,}[.]{1}[a-z]{2,5}$','i');
	return regEmail.test(mail);
};

function showAddAccountModal(){
	$('#AddAccountModal').modal('show');
};

function selectAll(){
	if( $("#selectAll").is(':checked') )
		$('.checkboxAccount').prop('checked', true);
	else
		$('.checkboxAccount').prop('checked', false);
};

function fillAccountTable(page){

	$('.divLoader').append('<img alt="loader" src="Img/loader.gif" />');

	if(table){
		table.destroy();
	}

	$('#optionAccount').empty();
	$('#optionAccount').append('<button id="addAccount" onclick="showAddAccountModal()">Add Account</button>'+
							   '<button id="deleteAccount" onclick="deleteMultipleAccount()">Delete Selected</button>');

	var url = "";
	if (page != 0){
		url = "?p=" + page;
	}

	var json_option = {
	    PSEUDO : $('#searchPseudoAccount').val(),
	    GENDER : $('#searchGenderAccount').val(),
	    AGE : $('#searchAgeAccount').val(),
	    DATEREG : $('#searchDateRegisterAccount').val(),
	    DATECO : $('#searchDateLastCoAccount').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php"+url,
	    data: {'dataTable': json_option, 'role': "tableAccount"},
	    dataType: 'json',
	    success: function(response){

			$('#bodyTableAccounts').empty();
			//On boucle sur accounts pour remplir le tableau des carac
			for(i in response.account){
			    $('#bodyTableAccounts').append( '<tr>'+
												'<td>'+response.account[i]['ID_ACCOUNT']+'</td>'+
												'<td>'+response.account[i]['PSEUDO']+'</td>'+
												'<td>'+response.account[i]['PASSWORD']+'</td>' +
												'<td>'+response.account[i]['GENDER']+'</td>' +
												'<td>'+response.account[i]['AGE']+'</td>' +
												'<td>'+response.account[i]['PHONE_NUMBER']+'</td>' +
												'<td>'+response.account[i]['EMAIL']+'</td>' +
												'<td>'+response.account[i]['WEBSITE']+'</td>' +
												'<td>'+response.account[i]['DESCRIPTION']+'</td>' +
												'<td>'+
													'<select id="playerAccount'+response.account[i]['ID_ACCOUNT']+'" class="playerAccountTable">'+
													'</select>'+
												'</td>'+
												'<td>'+response.account[i]['DATE_INSCRIPTION'].substring(0, 10)+'</td>' +
												'<td>'+response.account[i]['IP']+'</td>' +
												'<td>'+response.account[i]['DATE_LAST_CONNEXION'].substring(0, 10)+'</td>' +
												'<td>'+
													'<button class="altAccount" onclick="fillAccountInfos('+response.account[i]['ID_ACCOUNT']+');">Modif</button>'+
													'<button class="deleteAccount" onclick="deleteAccount('+response.account[i]['ID_ACCOUNT']+');">Delete</button>'+
												'</td>'+
												'<td>'+
													'<input type="checkbox" name="selectedAccount" value="'+response.account[i]['ID_ACCOUNT']+'" class="checkboxAccount">'+
												'</td>'+
				    				 			'</tr>');
			}

			//On remplit les select liés aux persos des comptes
			for(i in response.perso){
            	$('#playerAccount'+response.perso[i]['ID_ACCOUNT']).append('<option>'+response.perso[i]['FIRST_NAME']+' '+response.perso[i]['LAST_NAME']+'</option>');
            }

            //On cherche les selects qui ne sont pas remplis (les mob qui n'ont pas d'éléments) et on met le 'N/A' par défaut
            $('.playerAccountTable:empty').append('<option>N/A</option>');
	    }
	}).done(function(response){
		// On active la pagination
		pagination(response.nbPage, response.page, 'fillAccountTable');

		
		// Application de DataTable à un tableau
		table = $('#tableAccounts').DataTable({
			paging: false,
			searching: false,
			info: false
		});

		$('.loaderTable').empty();

	});
};

function fillAccountInfos(id){

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "infosAccounts" },
	    dataType: 'json',
	    success: function(response){
	         $('#alterPseudoAccount').val(response.accountInfos[0]['PSEUDO']);
	         $('#alterPassAccount').val(response.accountInfos[0]['PASSWORD']);
	         $('#alterGenderAccount option[value="'+response.accountInfos[0]['GENDER']+'"]').prop('selected', true);
	         $('#alterAgeAccount').val(response.accountInfos[0]['AGE']);
	         $('#alterTelAccount').val(response.accountInfos[0]['PHONE_NUMBER']);
	         $('#alterMailAccount').val(response.accountInfos[0]['EMAIL']);
	         $('#alterSiteAccount').val(response.accountInfos[0]['WEBSITE']);
	         $('#alterMiscellaneousAccount').val(response.accountInfos[0]['DESCRIPTION']);
	    }
	});
	$('#btnSaveChangesAccount').attr('idAccount', id); //get the ID for the Updtae fonction
	$('#UpdateAccountModal').modal('show');
};

function updateAccountInfos(id){

	if ($('#alterPseudoAccount').val().trim() == ""){
		alert("You must enter a valid pseudo");
		return false;
	}
	if ($('#alterPassAccount').val().trim() == ""){
		alert("You must enter a valid password");
		return false;
	}
	if (!isEmail($('#alterMailAccount').val())){
		alert("You must enter a valid mail");
		return false;
	}
	if(isNaN(parseFloat($('#alterAgeAccount').val())) || $('#alterAgeAccount').val().trim() < 0 || $('#alterAgeAccount').val().trim() > 150){
		alert("The age's value must be beetween 0 and 150");
		return false;
	}

	var json_option = {
	    PSEUDO : $('#alterPseudoAccount').val(),
	    PASSWORD : $('#alterPassAccount').val(),
	    GENDER : $('#alterGenderAccount').val(),
	    AGE : $('#alterAgeAccount').val(),
	    PHONE_NUMBER : $('#alterTelAccount').val(),
	    EMAIL : $('#alterMailAccount').val(),
	    WEBSITE : $('#alterSiteAccount').val(),
	    DESCRIPTION : $('#alterMiscellaneousAccount').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'data': json_option, 'role': "updateAccount" }
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillAccountTable(currentPage);
		$('#UpdateAccountModal').modal('hide');
	});

};

function deleteAccount(id){
	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'id': id, 'role': "deleteAccount"},
	    dataType: 'json'
	}).done(function(){
		var currentPage = $('.active').attr('id').replace("page", "");
		fillAccountTable(currentPage);
	});
};

function deleteMultipleAccount(){
	
	var accountChecked = new Array();
	$("input:checked[name=selectedAccount]").each(function() { //get the ID of all accounts selected
		accountChecked.push($(this).val());
	});

	if (accountChecked.length < 1) {
		alert("You must select at least 1 account");
		return false;
	}

	for (var i = 0; i < accountChecked.length; i++) {
		deleteAccount(accountChecked[i]);
	};
};

function addAccount(){
	
	//verify fields
	if ($('#addPseudoAccount').val().trim() == ""){
		alert("You must enter a valid pseudo");
		return false;
	}
	if ($('#addPassAccount').val().trim() == ""){
		alert("You must enter a valid password");
		return false;
	}
	if (!isEmail($('#addMailAccount').val())){
		alert("You must enter a valid mail");
		return false;
	}
	if(isNaN(parseFloat($('#addAgeAccount').val())) || $('#addAgeAccount').val().trim() < 0 || $('#addAgeAccount').val().trim() > 150){
		alert("The age's value must be beetween 0 and 150");
		return false;
	}

	var json_option = {
	    PSEUDO : $('#addPseudoAccount').val(),
	    PASSWORD : $('#addPassAccount').val(),
	    GENDER : $('#addGenderAccount').val(),
	    AGE : $('#addAgeAccount').val(),
	    PHONE_NUMBER : $('#addTelAccount').val(),
	    EMAIL : $('#addMailAccount').val(),
	    WEBSITE : $('#addSiteAccount').val(),
	    DESCRIPTION : $('#addMiscellaneousAccount').val()
	};

	$.ajax({
	    type: "POST", //Sending method
	    url:"Handler/developpeur.hand.php",
	    data: {'data': json_option, 'role': "addAccount" }
	}).done(function(){
		$('#AddAccountModal').modal('hide');
		alert("Account created!")
		fillAccountTable(0);
	});

};
