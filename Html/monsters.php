<h3>Administrer les monstres du jeu</h3>
<div>
	<table id="tableMonsters" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Specie</th>
				<th>Sub_Specie</th>
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
				$monsters = $connect->getMonsterInfos();
				$monstersElements = $connect->getMonsterElementsInfos();

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

				    $infosMonster .= '<td><button id="altMonster" idMonster="'.$monsters[$i]['ID_MONSTER'].'">Mofifier</button></td>'.
				    				 '</tr>';
				}

				//On affiche enfin nos infosMonsters remplies comme il faut.
				echo $infosMonster;
			?>
		</tbody>
	</table>
</div>