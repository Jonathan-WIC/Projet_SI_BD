<h3>Administrer les items du jeu</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-2 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label class="control-label" for="searchNameItem">Name :</label>
				<div class="controls">
					<input type="text" id="searchNameItem" name="searchNameItem" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="selectSearchTypeItem">Type :</label><br/>
				<select id ="selectSearchTypeItem" class="search_bar">
					<option value="">Select an option</option>
					<option value="ARMOR">ARMOR</option>
					<option value="ENTRETIEN">ENTRETIEN</option>
					<option value="FOOD">FOOD</option>
					<option value="WEAPON">WEAPON</option>
				</select>
			</div>
			<div class="control-group">
				<label class="control-label" for="searchFamilyItem">Family :</label><br/>
				<select id ="searchFamilyItem" class="search_bar">
					<option value="">Select an option</option>
					<option value="EQUIPMENT">EQUIPMENT</option>
					<option value="CONSUMABLE">CONSUMABLE</option>
				</select>
			</div>
			<div class="control-group">
				<label class="control-label" for="searchMinPriceItem">Maximal Price :</label>
				<div class="controls">
					<input type="number" id="searchMinPriceItem" name="searchMinPriceItem" />
				</div>
			</div>
			<div>
				<button class="btn" id="btnItemSearch" onclick="fillItemTable(0)">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-7" style="margin-top:2%;">

	<div class="tableOption" id="optionItem"></div>
	
	<div class="loaderTable divLoader"></div>

	<table id="tableItems" class="table table-bordered">
		<thead>
			<tr>
				<th>Id Item</th>
				<th>Name</th>
				<th>Type</th>
				<th>Family</th>
				<th>Price</th>
				<th>Action</th>
				<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>
			</tr>
		</thead>
		<tbody id="bodyTableItems">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ---------------------------------------------- Modals Update Item ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="UpdateItemModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un item</h4>
				</div>

				<div class="modal-body">

                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="alterNameItem">Name* :</label>
							<div class="controls">
								<input type="text" name="alterNameItem" id="alterNameItem" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterTypeItem">Type :</label><br/>
							<select id ="selectAlterTypeItem" class="search_bar">
								<option value="ARMOR">ARMOR</option>
								<option value="ENTRETIEN">ENTRETIEN</option>
								<option value="FOOD">FOOD</option>
								<option value="WEAPON">WEAPON</option>
							</select>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAlterFamilyItem">Family :</label><br/>
							<select id ="selectAlterFamilyItem">
								<option value="EQUIPMENT">EQUIPMENT</option>
								<option value="CONSUMABLE">CONSUMABLE</option>
							</select>
						</div>
						<div class="control-group">
							<label class="control-label" for="alterPriceItem">Price* :</label>
							<div class="controls">
								<input type="number" name="alterPriceItem" id="alterPriceItem" />
							</div>
						</div>
					</form>
				</div><!-- /.modal-body -->

				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesItem">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- -------------------------------------------------- Modals add Items ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="AddItemModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ajouter un item</h4>
				</div>

				<div class="modal-body">


                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="addNameItem">Name* :</label>
							<div class="controls">
								<input type="text" name="addNameItem" id="addNameItem" />
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddTypeItem">Type :</label><br/>
							<select id ="selectAddTypeItem">
								<option value="ARMOR">ARMOR</option>
								<option value="ENTRETIEN">ENTRETIEN</option>
								<option value="FOOD">FOOD</option>
								<option value="WEAPON">WEAPON</option>
							</select>
						</div>
						<div class="control-group">
							<label class="control-label" for="selectAddFamilyItem">Family :</label><br/>
							<select id ="selectAddFamilyItem">
								<option value="EQUIPMENT">EQUIPMENT</option>
								<option value="CONSUMABLE">CONSUMABLE</option>
							</select>
						</div>
						<div class="control-group">
							<label class="control-label" for="addPriceItem">Price* :</label>
							<div class="controls">
								<input type="number" name="addPriceItem" id="addPriceItem" />
							</div>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnAddItem">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>