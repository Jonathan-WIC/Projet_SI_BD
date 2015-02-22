<h3>Administrer les monstres du jeu</h3>
<div>
	<table id="tableMonsters" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
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
				<th>Owner</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				/**
					get monsters informations
				**/
				$admin = new MDBaseSuperAdmin();
				$monsters = $admin->getMonsterInfos();
				$monstersElements = $admin->getMonsterElementsInfos();

				$option = "";
                //Les values des options du select, les textex aux libelles des elements.
                for($i = 0 ; $i < count($monstersElements) ; ++$i)
                {
                    $option.= '<option>'.$monstersElements[$i]['LIB_ELEMENT'].'</option>';
                }


				//On boucle sur monsters pour remplir le tableau des carac
				$infosMonster = "";
				for($i = 0 ; $i < count($monsters) ; ++$i){
					if($monsters[$i]['ID_PLAYER'] == "") $monsters[$i]['ID_PLAYER'] = "N/A";
				    $infosMonster.= '<tr>'.
				    				'<td>'.$monsters[$i]['ID_MONSTER'].'</td>'.
				    				'<td>'.$monsters[$i]['NAME'].'</td>'.
				    				'<td>'.$monsters[$i]['GENDER'].'</td>'.
				    				'<td>'.$monsters[$i]['AGE'].'</td>'.
				    				'<td>'.$monsters[$i]['LIB_MATURITY'].'</td>'.
				    				'<td>'.$monsters[$i]['WEIGHT'].'</td>'.
				    				'<td>'.$monsters[$i]['DANGER_SCALE'].'</td>'.
				    				'<td>'.$monsters[$i]['HEALTH_STATE'].'</td>'.
				    				'<td>'.$monsters[$i]['HUNGER_STATE'].'</td>'.
				    				'<td>'.$monsters[$i]['CLEAN_SCALE'].'</td>'.
				    				'<td>'.$monsters[$i]['REGIME'].'</td>'.
				    				'<td><select>'.$option.'</select></td>'.
				    				'<td>'.$monsters[$i]['ID_PLAYER'].'</td>'.
				    				'</tr>';
				}

				//On affiche enfin nos infosMonsters remplies comme il faut.
				echo $infosMonster;
			?>
		</tbody>
	</table>
</div>