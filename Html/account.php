<h3>Administrer les comptes de joueur</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-2 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="searchNameAccount">Name :</label>
				<div class="controls">
					<input id="searchNameAccount" name="searchNameAccount" />
				</div>
			</div>
			<div>
				<button class="btn" id="btnAccountSearch">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-10" style="margin-top:2%;">

	<div id="optionAccount"> </div>

	<table id="tableAccounts" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Pseudo</th>
				<th>Pass</th>
				<th>Gdr</th>
				<th>Age</th>
				<th>Tel</th>
				<th>Mail</th>
				<th>Site</th>
				<th>Misc</th>
				<th>Perso</th>
				<th>Date register</th>
				<th>IP</th>
				<th>LastCo.</th>
				<th>Action</th>
				<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>
			</tr>
		</thead>
		<tbody id="bodyTableAccounts">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ---------------------------------------------- Modals Update Account ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="UpdateAccountModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un compte</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->
					
					<div class="row"> <!-- Don't forget class="row" !!!! -->
	                    <form class="form-horizontal">
							<div class="col-md-6">
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="alterPseudoAccount">Pseudo* :</label>
									<div class="controls">
										<input type="text" name="alterPseudoAccount" id="alterPseudoAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="alterPassAccount">Pass* :</label>
									<div class="controls">
										<input type="text" name="alterPassAccount" id="alterPassAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="alterGenderAccount">Gender :</label>
									<div class="controls">
										<select id="alterGenderAccount">
											<option value="M">M</option>
											<option value="F">F</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="alterAgeAccount">Age* :</label>
									<div class="controls">
										<input type="number" name="alterAgeAccount" id="alterAgeAccount" />
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="alterMailAccount">Mail* :</label>
									<div class="controls">
										<input type="email" name="alterMailAccount" id="alterMailAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="alterTelAccount">Tel :</label>
									<div class="controls">
										<input type="tel" name="alterTelAccount" id="alterTelAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="alterSiteAccount">Site :</label>
									<div class="controls">
										<input type="url" name="alterSiteAccount" id="alterSiteAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="alterMiscellaneousAccount">Miscellaneous :</label>
									<div class="controls">
										<input type="text" name="alterMiscellaneousAccount" id="alterMiscellaneousAccount" />
									</div>
								</div>
							</div>
						</form>
					</div>
				</div><!-- /.modal-body --> 

				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesAccount">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------  Modals add Account ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="AddAccountModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ajouter un type compte</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->
					<div class="row"> <!-- Don't forget class="row" !!!! -->
	                    <form class="form-horizontal">
	                    	<div class="col-md-6">
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="addPseudoAccount">Pseudo* :</label>
									<div class="controls">
										<input type="text" name="addPseudoAccount" id="addPseudoAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="addPassAccount">Pass* :</label>
									<div class="controls">
										<input type="text" name="addPassAccount" id="addPassAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="addGenderAccount">Gender* :</label>
									<div class="controls">
										<select id="addGenderAccount">
											<option value="M">M</option>
											<option value="F">F</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="addAgeAccount">Age* :</label>
									<div class="controls">
										<input type="number" name="addAgeAccount" id="addAgeAccount" />
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="addMailAccount">Mail* :</label>
									<div class="controls">
										<input type="email" name="addMailAccount" id="addMailAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="addTelAccount">Tel :</label>
									<div class="controls">
										<input type="tel" name="addTelAccount" id="addTelAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="addSiteAccount">Site :</label>
									<div class="controls">
										<input type="url" name="addSiteAccount" id="addSiteAccount" />
									</div>
								</div>
								<div class="control-group">
									<label id="nameSearch" class="control-label" for="addMiscellaneousAccount">Miscellaneous :</label>
									<div class="controls">
										<input type="text" name="addMiscellaneousAccount" id="addMiscellaneousAccount" />
									</div>
								</div>
							</div>
						</form>
					</div>
				</div><!-- /.modal-body --> 

				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnAddAccount">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>