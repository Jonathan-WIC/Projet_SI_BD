<h3>Manage monster's sub-species</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-3 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label class="control-label" for="searchNameSubSpecie">Name :</label>
				<div class="controls">
					<input id="searchNameSubSpecie" name="searchNameSubSpecie" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="searchNameSpecie">Parent's Specie :</label>
				<div class="controls">
					<input id="searchNameSpecie" name="searchNameSpecie" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="selectHabitat">Habitat :</label>
				<div class="controls">
					<select id="selectHabitat" name="selectHabitat" class="selectHabitat">
						<option value="">Select an option</option>
					</select>
				</div>
			</div>
			<div>
				<button class="btn" id="btnSubSpecieSearch" onclick="fillSubSpecieTable(0)">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-5" style="margin-top:2%;">

	<div class="tableOption" id="optionSubSpecie">
	</div>

	<div class="loaderTable divLoader"></div>

	<table id="tableSubSpecies" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Parent's Specie</th>
				<th>Habitat</th>
				<th>Action</th>
				<?php
					if( $_SESSION['model'] == "MDBase_developpeur" OR $_SESSION['model'] == "MDBase_administrateur" )
				    	echo '<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>';
				?>
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
							<label class="control-label" for="alterNameSubSpecie">Name* :</label>
							<div class="controls">
								<input type="text" name="alterNameSubSpecie" id="alterNameSubSpecie" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterIdSpecie">Parent's Specie :</label>
							<div class="controls">
								<select id="selectAlterIdSpecie" name="selectAlterIdSpecie" class="selectSpecies">
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterHabitat">Habitat :</label>
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

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ---------------------------------------------- Modals add SubSpecie ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="AddSubSpecieModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ajouter une sous-éspèce</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="addNameSubSpecie">Name* :</label>
							<div class="controls">
								<input type="text" name="addNameSubSpecie" id="addNameSubSpecie" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddIdSpecie">Parent's Specie :</label>
							<div class="controls">
								<select id="selectAddIdSpecie"  name="selectAddIdSpecie" class="selectSpecies">
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddHabitat">Habitat :</label>
							<div class="controls">
								<select id="selectAddHabitat" name="selectAddHabitat" class="selectHabitat">
								</select>
							</div>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnAddSubSpecie">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>