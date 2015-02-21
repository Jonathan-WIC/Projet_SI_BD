<h3>Administrer les monstres du jeu</h3>
<div>
	<table id="tableMonsters" class="table table-bordered">
		<thead></thead>
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Gender</th>
			<th>Age</th>
			<th>Weight</th>
			<th>Danger Level</th>
			<th>Health Status</th>
			<th>Hunger Status</th>
			<th>Clean Status</th>
			<th>Regime</th>
			<th>Owner</th>
		</tr>
		<tbody>
			<?php 
/**
	TODO
**/
				$admin = new MDBaseSuperAdmin();
				$monsters = $admin->getAllMonsters();
				$infosMonster = "";
				
				//On boucle sur monsters pour remplir le tableau des carac
				for($i = 0 ; $i < count($monsters) ; ++$i){
					if($monsters[$i]['ID_PLAYER'] == "") $monsters[$i]['ID_PLAYER'] = "N/A";
				    $infosMonster.= '<tr>'.
				    				'<td>'.$monsters[$i]['ID_MONSTER'].'</td>'.
				    				'<td>'.$monsters[$i]['NAME'].'</td>'.
				    				'<td>'.$monsters[$i]['GENDER'].'</td>'.
				    				'<td>'.$monsters[$i]['AGE'].'</td>'.
				    				'<td>'.$monsters[$i]['WEIGHT'].'</td>'.
				    				'<td>'.$monsters[$i]['DANGER_SCALE'].'</td>'.
				    				'<td>'.$monsters[$i]['HEALTH_STATE'].'</td>'.
				    				'<td>'.$monsters[$i]['HUNGER_STATE'].'</td>'.
				    				'<td>'.$monsters[$i]['CLEAN_SCALE'].'</td>'.
				    				'<td>'.$monsters[$i]['REGIME'].'</td>'.
				    				'<td>'.$monsters[$i]['ID_PLAYER'].'</td>'.
				    				'</tr>';
				}

				//On affiche enfin nos infosMonsters remplies comme il faut.
				echo $infosMonster;
			?>
		</tbody>
	</table>
</div>