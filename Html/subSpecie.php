<h3>Administrer les sous-éspèces du jeu</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-3 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="selectNameSubSpecie">Name :</label>
				<div class="controls">
					<select id="selectNameSubSpecie" name="selectNameSubSpecie" class="selectSubSpecies">
					</select>
				</div>
			</div>
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="selectNameSpecie">Parent's Specie :</label>
				<div class="controls">
					<select id="selectNameSubSpecie" name="selectNameSubSpecie" class="selectSpecies">
					</select>
				</div>
			</div>
			<div class="control-group">
				<label id="nameSearch" class="control-label" for="selectHabitat">Habitat :</label>
				<div class="controls">
					<select id="selectHabitat" name="selectHabitat" class="selectHabitat">
					</select>
				</div>
			</div>
			<div>
				<button class="btn" id="btnSubSpecieSearch">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-5" style="margin-top:2%;">

	<div id="optionSubSpecie">
	</div>

	<table id="tableSubSpecies" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Parent's Specie</th>
				<th>Habitat</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="bodyTableSubSpecies">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ---------------------------------------------  Modals Update SubSpecie ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="UpdateSubSpecieModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier une sous-éspèce</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

                    <form class="form-horizontal">
						<div class="control-group">
							<label id="nameSearch" class="control-label" for="alterNameSubSpecie">Name :</label>
							<div class="controls">
								<input type="text" name="alterNameSubSpecie" id="alterNameSubSpecie" />
							</div>
						</div>
						<div class="control-group">
							<label id="nameSearch" class="control-label" for="selectAlterIdSpecie">Parent's Specie :</label>
							<div class="controls">
								<select id="selectAlterIdSpecie" class="selectSpecies">
								</select>
							</div>
						</div>
						<div class="control-group">
							<label id="nameSearch" class="control-label" for="selectAlterHabitat">Habitat :</label>
							<div class="controls">
								<select id="selectAlterHabitat" name="selectAlterHabitat" class="selectHabitat">
								</select>
							</div>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesSubSpecie">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>