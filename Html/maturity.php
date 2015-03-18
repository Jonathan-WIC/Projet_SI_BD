<h3>Administrer les régimes du jeu</h3>

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- -------------------------------------------------- Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-3 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div class="control-group">
				<label class="control-label" for="searchNameMaturity">Name :</label>
				<div class="controls">
					<input id="searchNameMaturity" name="searchNameMaturity" />
				</div>
			</div>
			<div>
				<button class="btn" id="btnMaturitySearch" onclick="fillMaturityTable(0)">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-offset-1 col-md-5" style="margin-top:2%;">

	<div class="tableOption" id="optionMaturity"></div>

	<div class="loaderTable divLoader"></div>

	<table id="tableMaturitys" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Action</th>
				<?php
					if( $_SESSION['model'] == "MDBase_developpeur" OR $_SESSION['model'] == "MDBase_administrateur" )
				    	echo '<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>';
				?>
			</tr>
		</thead>
		<tbody id="bodyTableMaturitys">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- ------------------------------------------------------------------------------------------------------------------ -->
	<!-- ----------------------------------------------  Modal update Maturity -------------------------------------------- -->
	<!-- ------------------------------------------------------------------------------------------------------------------ -->

	
	<div id="UpdateMaturityModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un type de maturité</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="alterNameMaturity">Name* :</label>
							<div class="controls">
								<input type="text" name="alterNameMaturity" id="alterNameMaturity" />
							</div>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesMaturity">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Modal add Maturity ------------------------------------------------ -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
	<div id="AddMaturityModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Ajouter un type de maturité</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

                    <form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="addNameMaturity">Name* :</label>
							<div class="controls">
								<input type="text" name="addNameMaturity" id="addNameMaturity" />
							</div>
						</div>
					</form>

				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnAddMaturity">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>