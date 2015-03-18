<h3>Administrer les monstres du jeu</h3>

	
	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------ Main Page Part -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->


	<!-- ------------------------------------ Search fields ------------------------------------ -->

<div class="col-md-2 search">
	<div id="leftSearch">
		<legend>Search</legend>
		<fieldset id="searchFields">
			<div>
				<label>Search by Name</label>
				<input class="search_bar" id="nameSearch" type="text" placeholder="Name" />
				<label>Search by specie</label><br>
				<select class="search_bar selectSpecies" id="selectSpecies"></select>
				<label>Search by sub specie</label><br>
				<select class="search_bar selectSubSpecies" id="selectSubSpecies"></select>
				<label>Search by maturity</label><br>
				<select class="search_bar selectMaturity" id="selectMaturity"></select><br>
				<label>Search by Regime</label><br>
				<select class="search_bar selectRegime" id="selectRegime"></select>
				<label>Search by Danger Scale</label><br>
				<select class="search_bar selectDanger" id="selectDanger"></select>
				<div class="control-group">
					<label class="control-label" for="searchGenderMonster">Gender :</label>
					<div class="controls">
						<select id="searchGenderAccount" name="searchGenderAccount">
							<option value="M">M</option>
							<option value="F">F</option>
						</select>
					</div>
				</div>
				<br />
				<button class="btn" id="btnMonsterSearch">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-10" style="margin-top:2%;">

	<div class="tableOption" id="optionMonster">
	</div>

	<div class="loaderTable divLoader"></div>

	<table id="tableMonsters" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Specie</th>
				<th>Family</th>
				<th>Gdr</th>
				<th>Age</th>
				<th>Maturity</th>
				<th>Weight</th>
				<th>Danger</th>
				<th>Health</th>
				<th>Hunger</th>
				<th>Clean</th>
				<th>Regime</th>
				<th>Element(s)</th>
				<?php
					if( $_SESSION['model'] == "MDBase_developpeur" OR $_SESSION['model'] == "MDBase_administrateur" )
				    	echo '<th>Owner</th>';
				?>
				<th>Action</th>
				<?php
					if( $_SESSION['model'] == "MDBase_developpeur" OR $_SESSION['model'] == "MDBase_administrateur" )
				    	echo '<th><input type="checkbox" name="selectAll" id="selectAll" onclick="selectAll();"></th>';
				?>
			</tr>
		</thead>
		<tbody id="bodyTableMonsters">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- ------------------------------------------------------------------------------------------------------------------------ -->
	<!-- ------------------------------------------------ Modals update Monsters ------------------------------------------------ -->
	<!-- ------------------------------------------------------------------------------------------------------------------------ -->

	
	<div id="UpdateMonsterModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un monstre</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

					<div class="row"> <!-- Don't forget class="row" !!!! -->
						<div class="col-md-6">
	                        <form class="form-horizontal">
								<div class="control-group">
									<label class="control-label" for="alterNameMonster">Name* :</label>
									<div class="controls">
										<input type="text" id="alterNameMonster" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAlterDangerMonster">Danger :</label>
									<div class="controls">
										<select id="selectAlterDangerMonster" class="selectDanger">
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAlterSubSpecieMonster">Sub Specie :</label>
									<div class="controls">
										<select id="selectAlterSubSpecieMonster" class="selectSubSpecies">
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAlterGenderMonster">Gender :</label>
									<div class="controls">
										<select id="selectAlterGenderMonster">
											<option value="M">M</option>
											<option value="F">F</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAlterMaturityMonster">Maturity :</label>
									<div class="controls">
										<select id="selectAlterMaturityMonster" class="selectMaturity">
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAlterRegimeMonster">Regime :</label>
									<div class="controls">
										<select id="selectAlterRegimeMonster" class="selectRegime">
										</select>
									</div>
								</div>
							</form>
	            		</div>

					<!-- ------------------------------------ Main informations col 2 ------------------------------------ -->

	            		<div class="col-md-6">
	                	    <div class="control-group">
								<label class="control-label" for="alterAgeMonster">Age* :</label>
								<div class="controls">
									<input type="number" id="alterAgeMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterWeightMonster">Weight* :</label>
								<div class="controls">
									<input type="number" id="alterWeightMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterHungerMonster">Hunger* :</label>
								<div class="controls">
									<input type="number" id="alterHungerMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterHealthMonster">Health* :</label>
								<div class="controls">
									<input type="number" id="alterHealthMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterCleanMonster">Clean* :</label>
								<div class="controls">
									<input type="number" id="alterCleanMonster"/>
								</div>
							</div>
	            		</div>
					</div>

			
					<hr>	
					
					<!-- ------------------------------------ Infos on elements ------------------------------------ -->

					<div id="elementalInfos" class="row">
						<b>Elements :</b>
						<ul id="listUpdateElement" class="checkbox-grid">
						</ul>
					</div>


				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnSaveChangesMonster">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- ------------------------------------------------------------------------------------------------------------------------ -->
	<!-- -------------------------------------------------- Modal add Monsters -------------------------------------------------- -->
	<!-- ------------------------------------------------------------------------------------------------------------------------ -->

	
	<div id="AddMonsterModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modifier un monstre</h4>
				</div>


				<div class="modal-body">
					
					<!-- ------------------------------------ Main informations col 1 ------------------------------------ -->

					<div class="row"> <!-- Don't forget class="row" !!!! -->
						<div class="col-md-6">
	                        <form class="form-horizontal">
								<div class="control-group">
									<label class="control-label" for="addNameMonster">Name* :</label>
									<div class="controls">
										<input type="text" id="addNameMonster" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAddDangerMonster">Danger :</label>
									<div class="controls">
										<select id="selectAddDangerMonster" class="selectDanger">
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAddSubSpecieMonster">Sub Specie :</label>
									<div class="controls">
										<select id="selectAddSubSpecieMonster" class="selectSubSpecies">
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAddGenderMonster">Gender :</label>
									<div class="controls">
										<select id="selectAddGenderMonster">
											<option value="M">M</option>
											<option value="F">F</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAddMaturityMonster">Maturity :</label>
									<div class="controls">
										<select id="selectAddMaturityMonster" class="selectMaturity">
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAddRegimeMonster">Regime :</label>
									<div class="controls">
										<select id="selectAddRegimeMonster" class="selectRegime">
										</select>
									</div>
								</div>
							</form>
	            		</div>

					<!-- ------------------------------------ Main informations col 2 ------------------------------------ -->

	            		<div class="col-md-6">
	                	    <div class="control-group">
								<label class="control-label" for="addAgeMonster">Age* :</label>
								<div class="controls">
									<input type="number" id="addAgeMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="addWeightMonster">Weight* :</label>
								<div class="controls">
									<input type="number" id="addWeightMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="addHungerMonster">Hunger* :</label>
								<div class="controls">
									<input type="number" id="addHungerMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="addHealthMonster">Health* :</label>
								<div class="controls">
									<input type="number" id="addHealthMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="addCleanMonster">Clean* :</label>
								<div class="controls">
									<input type="number" id="addCleanMonster"/>
								</div>
							</div>
	            		</div>
					</div>

			
					<hr>	
					
					<!-- ------------------------------------ Infos on elements ------------------------------------ -->

					<div id="addElementalInfos" class="row">
						<b>Elements :</b>
						<ul id="listAddElement" class="checkbox-grid">
						</ul>
					</div>


				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="btnAddMonster">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>
