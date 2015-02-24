<h3>Administrer les monstres du jeu</h3>
<div>
	<table id="tableMonsters" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Specie</th>
				<th>Sub specie</th>
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
		<tbody>
			<?php 
				/**
					get monsters informations
				**/
				$connect = new $_SESSION['model']();
				$monsters = $connect->getMonstersInfos();
				$monstersElements = $connect->getMonstersElementsInfos();

				$option = "";
                //Les values des options du select, les textex aux libelles des elements.
                for($i = 0 ; $i < count($monstersElements) ; ++$i){
                    $option .= '<option>'.$monstersElements[$i]['LIB_ELEMENT'].'</option>';
                }

				//On boucle sur monsters pour remplir le tableau des carac
				$infosMonster = "";
				for($i = 0 ; $i < count($monsters) ; ++$i){
					if($monsters[$i]['ID_PLAYER'] == "") $monsters[$i]['ID_PLAYER'] = "N/A";
				    $infosMonster .= '<tr>'.
				    				 '<td>'.$monsters[$i]['ID_MONSTER'].'</td>'.
				    				 '<td>'.$monsters[$i]['NAME'].'</td>'.
				    				 '<td>'.$monsters[$i]['LIB_SUB_SPECIE'].'</td>'.
				    				 '<td>'.$monsters[$i]['LIB_SPECIE'].'</td>'.
				    				 '<td>'.$monsters[$i]['GENDER'].'</td>'.
				    				 '<td>'.$monsters[$i]['AGE'].'</td>'.
				    				 '<td>'.$monsters[$i]['LIB_MATURITY'].'</td>'.
				    				 '<td>'.$monsters[$i]['WEIGHT'].'</td>'.
				    				 '<td>'.$monsters[$i]['DANGER_SCALE'].'</td>'.
				    				 '<td>'.$monsters[$i]['HEALTH_STATE'].'</td>'.
				    				 '<td>'.$monsters[$i]['HUNGER_STATE'].'</td>'.
				    				 '<td>'.$monsters[$i]['CLEAN_SCALE'].'</td>'.
				    				 '<td>'.$monsters[$i]['REGIME'].'</td>'.
				    				 '<td><select>'.$option.'</select></td>';

				    if( $_SESSION['model'] == "MDBase_administrateur")
				    	$infosMonster .= '<td>'.$monsters[$i]['ID_PLAYER'].'</td>';

				    $infosMonster .= '<td><button class="altMonster" idMonster="'.$monsters[$i]['ID_MONSTER'].'">Mofifier</button></td>'.
				    				 '</tr>';
				}

				//On affiche enfin nos infosMonsters remplies comme il faut.
				echo $infosMonster;
			?>
		</tbody>
	</table>





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
									<label class="control-label" for="alterNameMonster">Name :</label>
									<div class="controls">
										<input type="text" id="alterNameMonster" />
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAlterSpecieMonster">Specie :</label>
									<div class="controls">
										<select id="selectAlterSpecieMonster">
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAlterSubSpecieMonster">Sub Specie:</label>
									<div class="controls">
										<select id="selectAlterSubSpecieMonster">
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
										<select id="selectAlterMaturityMonster">
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="selectAlterRegimeMonster">Regime :</label>
									<div class="controls">
										<select id="selectAlterRegimeMonster">
										</select>
									</div>
								</div>
							</form>
	            		</div>

					<!-- ------------------------------------ Main informations col 2 ------------------------------------ -->

	            		<div class="col-md-6">
	                	    <div class="control-group">
								<label class="control-label" for="alterAgeMonster">Age :</label>
								<div class="controls">
									<input type="number" id="alterAgeMonster" readonly="true"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterWeightMonster">Weight :</label>
								<div class="controls">
									<input type="number" id="alterWeightMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterHungerMonster">Hunger :</label>
								<div class="controls">
									<input type="number" id="alterHungerMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterHealthMonster">Health :</label>
								<div class="controls">
									<input type="number" id="alterHealthMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterCleanMonster">Clean :</label>
								<div class="controls">
									<input type="number" id="alterCleanMonster"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="alterDangerMonster">Danger :</label>
								<div class="controls">
									<input type="text" id="alterDangerMonster"/>
								</div>
							</div>
	            		</div>
					</div>

			
					<hr>	
					
					<!-- ------------------------------------ Infos on elements ------------------------------------ -->

					<div class="row">
						
					</div>


				</div><!-- /.modal-body --> 
				<div class="modal-footer">
					<span class="pull-left">* Required Fields</span>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>


<!--

	<div class="col-md-10">
		<label class="control-label" for="inputChildAddEvent">Child ? </label>
		<div class="controls">
			<input type="checkbox" id="inputINSEEUpEvent" checked />
		</div>
		<label class="control-label" for="inputChildAddEvent">Child ? </label>
		<div class="controls">
			<input type="checkbox" id="inputINSEEUpEvent" checked />
		</div>
		<label class="control-label" for="inputChildAddEvent">Child ? </label>
		<div class="controls">
			<input type="checkbox" id="inputINSEEUpEvent" checked />
		</div>
		<label class="control-label" for="inputChildAddEvent">Child ? </label>
		<div class="controls">
			<input type="checkbox" id="inputINSEEUpEvent" checked />
		</div>
	</div>
-->