<h3>Administrer les régimes du jeu</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-3 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="searchNameEnclosure">Name :</label>
				<div class="controls">
					<input id="searchNameEnclosure" name="searchNameEnclosure" />
				</div>
			</div>
			<div>
				<button class="btn" id="btnEnclosureSearch">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-5" style="margin-top:2%;">

	<div id="optionEnclosure">
	</div>

	<table id="tableEnclosures" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Action</th>
				<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>';
			</tr>
		</thead>
		<tbody id="bodyTableEnclosures">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ---------------------------------------------- Modals Update Enclosure ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="UpdateEnclosureModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un enclos</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

                    <form class="form-horizontal">
						<div class="control-group">
							<label id="nameSearch" class="control-label" for="alterNameEnclosure">Name* :</label>
							<div class="controls">
								<input type="text" name="alterNameEnclosure" id="alterNameEnclosure" />
							</div>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesEnclosure">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------  Modals add Enclosure ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="AddEnclosureModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ajouter un enclos</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

                    <form class="form-horizontal">
						<div class="control-group">
							<label id="nameSearch" class="control-label" for="addNameEnclosure">Name* :</label>
							<div class="controls">
								<input type="text" name="addNameEnclosure" id="addNameEnclosure" />
							</div>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnAddEnclosure">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>