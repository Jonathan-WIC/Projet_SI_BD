<h3>Manage Characters from players account</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-2 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label class="control-label" for="selectNamePlayer">First Name :</label>
				<div class="controls">
					<input id="selectNamePlayer" name="selectNamePlayer"/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="selectLastNamePlayer">Last Name :</label>
				<div class="controls">
					<input id="selectLastNamePlayer" name="selectLastNamePlayer"/>
				</div>
			</div>
			<div>
				<button class="btn" id="btnPlayerSearch">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-10" style="margin-top:2%;">

	<div class="tableOption" id="optionPlayer">
	</div>

	<table id="tablePlayers" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Gender</th>
				<th>Money</th>
				<th>Id Account</th>
				<th>Quest Cleared</th>
				<th>Parks</th>
				<th>Monster</th>
				<th>Items</th>
				<th>Action</th>
				<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>
			</tr>
		</thead>
		<tbody id="bodyTablePlayers">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>



	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ---------------------------------------------- Modals Update Player ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="UpdatePlayerModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un perso</h4>
				</div>

				<div class="modal-body">

                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="alterNamePlayer">First Name* :</label>
							<div class="controls">
								<input type="text" name="alterNamePlayer" id="alterNamePlayer" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="alterLastNamePlayer">Last Name* :</label>
							<div class="controls">
								<input type="text" name="alterLastNamePlayer" id="alterLastNamePlayer" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterGenderPlayer">Gender :</label>
							<div class="controls">
								<select id="selectAlterGenderPlayer">
									<option value="M">M</option>
									<option value="F">F</option>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="alterMoneyPlayer">Money* :</label>
							<div class="controls">
								<input type="number" name="alterMoneyPlayer" id="alterMoneyPlayer" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterAccountPlayer">Account :</label><br/>
							<select id ="selectAlterAccountPlayer" class="selectAccount"></select>
						</div>
					</form>
				</div><!-- /.modal-body -->

				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesPlayer">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- -------------------------------------------------- Modals add Players ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="AddPlayerModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ajouter un perso</h4>
				</div>

				<div class="modal-body">

                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="addNamePlayer">First Name* :</label>
							<div class="controls">
								<input type="text" name="addNamePlayer" id="addNamePlayer" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addLastNamePlayer">Last Name* :</label>
							<div class="controls">
								<input type="text" name="addLastNamePlayer" id="addLastNamePlayer" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddGenderPlayer">Gender :</label>
							<div class="controls">
								<select id="selectAddGenderPlayer">
									<option value="M">M</option>
									<option value="F">F</option>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addMoneyPlayer">Money* :</label>
							<div class="controls">
								<input type="number" name="addMoneyPlayer" id="addMoneyPlayer" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddAccountPlayer">Account :</label><br/>
							<select id ="selectAddAccountPlayer" class="selectAccount"></select>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnAddPlayer">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>