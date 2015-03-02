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
				<label>Search by specie</label>
				<select class="search_bar selectSpecies" id="selectSpecies"></select>
				<label>Search by sub specie</label>
				<select class="search_bar selectSubSpecies" id="selectSubSpecies"></select>
				<label>Search by maturity</label>
				<select class="search_bar selectMaturity" id="selectMaturity"></select>
				<label>Search by Regime</label>
				<select class="search_bar selectRegime" id="selectRegime"></select>
				<label>Search by Danger Scale</label>
				<select class="search_bar selectDanger" id="selectDanger"></select>
				<div>
					<label class="radio-inline">
						<input type="radio" name="gender" id="searchGenderM" value="M" />M
					</label>
					<label class="radio-inline">
						<input type="radio" name="gender" id="searchGenderF" value="F"/>F
					</label>
				</div>
				<br />
				<button class="btn" id="btnMonsterSearch">Search</button>
			</div>
		</fieldset>
	</div>
</div>

	<!-- ------------------------------------ Table result ------------------------------------ -->

<div class="col-md-10" style="margin-top:2%;">
	<table id="tableMonsters" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Specie</th>
				<th>Family</th>
				<th>Gender</th>
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
					if( $_SESSION['model'] == "MDBase_administrateur")
				    	echo '<th>Owner</th>';
				?>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="bodyTableMonsters">
		</tbody>
	</table>
	<nav>
		<ul id="pagination" class="pagination">
		</ul>
	</nav>


	<!-- -------------------------------------------------------------------------------------------------------------------- -->
	<!-- ------------------------------------------------  Modals elements -------------------------------------------------- -->
	<!-- -------------------------------------------------------------------------------------------------------------------- -->

	
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
									<input type="number" id="alterAgeMonster" readonly="true"/>
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
						<b>Elements* :</b>
						<ul id="listElement" class="checkbox-grid">
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

</div>
