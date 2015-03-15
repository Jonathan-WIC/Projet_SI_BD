<h3>Administrer les enclos du jeu</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-2 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label class="control-label" for="searchNameEnclosure">Name :</label>
				<div class="controls">
					<input id="searchNameEnclosure" name="searchNameEnclosure" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="searchSelectSubSpecies">Sub-SPecies :</label>
				<select size="1" class="search_bar selectSubSpecies" id="searchSelectSubSpecies"></select>
			</div>
			<div>
			<div class="control-group">
				<label class="control-label" for="searchSelectPark">SelectPark :</label>
				<select class="search_bar selectPark" id="searchSelectPark"></select>
			</div>
			<div>
				<button class="btn" id="btnEnclosureSearch">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-7" style="margin-top:2%;">

	<div id="optionEnclosure">
	</div>

	<table id="tableEnclosures" class="table table-bordered">
		<thead>
			<tr>
				<th>Id Enclosure</th>
				<th>Id Park</th>
				<th>Type</th>
				<th>Capacity</th>
				<th>Price</th>
				<th>Climate</th>
				<th>Type Monster</th>
				<th>Action</th>
				<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>
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
							<label class="control-label" for="selectAlterParkEnclosure">Select a park :</label><br>
							<select class="search_bar selectPark" id="selectAlterParkEnclosure"></select>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterSubSpecieEnclosure">Select a type of monster :</label><br>
							<select id ="selectAlterSubSpecieEnclosure" class="search_bar selectSubSpecies"></select>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterTypeEnclosure">Select a type :</label><br>
							<select id ="selectAlterTypeEnclosure">
								<option value="BASIC">BASIC</option>
								<option value="AQUARIUM">AQUARIUM</option>
								<option value="AVIARY">AVIARY</option>
							</select>
						</div>
						<div class="control-group">
							<label class="control-label" for="alterCapacityEnclosure">Capacity* :</label>
							<div class="controls">
								<input type="number" name="alterCapacityEnclosure" id="alterCapacityEnclosure" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="alterPriceEnclosure">Price* :</label>
							<div class="controls">
								<input type="number" name="alterPriceEnclosure" id="alterPriceEnclosure" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterClimatEnclosure">Select a Climat :</label><br>
							<select id ="selectAlterClimatEnclosure">
								<option value="ARCTIC">ARCTIC</option>
								<option value="ARID">ARID</option>
								<option value="CAVERNOUS">CAVERNOUS</option>
								<option value="FOREST">FOREST</option>
								<option value="ISLAND">ISLAND</option>
								<option value="MONTAINOUS">MONTAINOUS</option>
								<option value="OCEANIC">OCEANIC</option>
								<option value="TROPICAL">TROPICAL</option>
								<option value="VOLCANIC">VOLCANIC</option>
							</select>
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
							<label class="control-label" for="selectAddParkEnclosure">Select a park :</label><br>
							<select class="search_bar selectPark" id="selectAddParkEnclosure"></select>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddParkEnclosure">Select a type of monster :</label><br>
							<select id ="selectAddSubSpecieEnclosure" class="search_bar selectSubSpecies"></select>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddTypeEnclosure">Select a type :</label><br>
							<select id ="selectAddTypeEnclosure">
								<option value="BASIC">BASIC</option>
								<option value="AQUARIUM">AQUARIUM</option>
								<option value="AVIARY">AVIARY</option>
							</select>
						</div>
						<div class="control-group">
							<label class="control-label" for="addCapacityEnclosure">Capacity* :</label>
							<div class="controls">
								<input type="number" name="addCapacityEnclosure" id="addCapacityEnclosure" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="addPriceEnclosure">Price* :</label>
							<div class="controls">
								<input type="number" name="addPriceEnclosure" id="addPriceEnclosure" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddClimatEnclosure">Select a Climat :</label><br>
							<select id ="selectAddClimatEnclosure">
								<option value="ARCTIC">ARCTIC</option>
								<option value="ARID">ARID</option>
								<option value="CAVERNOUS">CAVERNOUS</option>
								<option value="FOREST">FOREST</option>
								<option value="ISLAND">ISLAND</option>
								<option value="MONTAINOUS">MONTAINOUS</option>
								<option value="OCEANIC">OCEANIC</option>
								<option value="TROPICAL">TROPICAL</option>
								<option value="VOLCANIC">VOLCANIC</option>
							</select>
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