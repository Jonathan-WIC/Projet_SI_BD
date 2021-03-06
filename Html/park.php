<h3>Manage Parks and Player's parks</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-2 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label class="control-label" for="searchNamePark">Name :</label>
				<div class="controls">
					<input type="text" id="searchNamePark" name="searchNamePark" />
				</div>
			</div>
			<div>
			<div class="control-group">
				<label class="control-label" for="searchCapacityPark">Capacity :</label>
				<div class="controls">
					<input type="number" id="searchCapacityPark" name="searchCapacityPark" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="selectSearchPersoPark">Owner :</label><br>
				<div class="controls">
					<input type="number" id="selectSearchPersoPark" name="selectSearchPersoPark" />
				</div>
			</div>
			<div>
				<button class="btn" id="btnParkSearch" onclick="fillParkTable(0)">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-7" style="margin-top:2%;">

	<div class="tableOption" id="optionPark">
	</div>
	
	<div class="loaderTable divLoader"></div>

	<table id="tableParks" class="table table-bordered">
		<thead>
			<tr>
				<th>Id Park</th>
				<th>Name</th>
				<th>Capacity</th>
				<th>Owner ID</th>
				<th>Enclosure</th>
				<th>Action</th>
				<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>
			</tr>
		</thead>
		<tbody id="bodyTableParks">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ---------------------------------------------- Modals Update Park ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="UpdateParkModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un park</h4>
				</div>

				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="alterNamePark">Name* :</label>
							<div class="controls">
								<input type="text" name="alterNamePark" id="alterNamePark" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="alterCapacityPark">Capacity* :</label>
							<div class="controls">
								<input type="number" name="alterCapacityPark" id="alterCapacityPark" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterPersoPark">Select a perso :</label><br>
							<select id ="selectAlterPersoPark" class="search_bar selectPersos"></select>
						</div>
					</form>
				</div><!-- /.modal-body -->

				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesPark">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------  Modals add Park ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="AddParkModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ajouter un park</h4>
				</div>

				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="addNamePark">Name* :</label>
							<div class="controls">
								<input type="text" name="addNamePark" id="addNamePark" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addCapacityPark">Capacity* :</label>
							<div class="controls">
								<input type="number" name="addCapacityPark" id="addCapacityPark" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddPersoPark">Select a perso :</label><br>
							<select id ="selectAddPersoPark" class="search_bar selectPersos"></select>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnAddPark">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>