<h3>Administrer les quêtes du jeu</h3>
<div>
	<table id="tableQuest" class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Fee</th>
				<th>Starting Date</th>
				<th>Durée</th>
			</tr>
		</thead>
		<tbody>
		<?php
			global $page;

			/**
				get monsters informations
			**/
			$connect = new $_SESSION['model']();
			$quests = $connect->getAllQuests();

			//On boucle sur quests pour remplir le tableau
			$infosQuests = "";
			for($i = 0 ; $i < count($quests) ; ++$i){
				/*if($quests[$i]['IS_COMPLETED'] == 1)
					$quests[$i]['IS_COMPLETED'] = "Yes";
				else
					$quests[$i]['IS_COMPLETED'] = "No";*/

			    $infosQuests.=  '<tr>'.
			    				'<td>'.$quests[$i]['ID_QUEST'].'</td>'.
			    				'<td>'.$quests[$i]['FEE'].' G</td>'.
			    				'<td>'.$quests[$i]['DATE_DEB'].'</td>'.
			    				'<td>'.$quests[$i]['DURATION'].' jours</td>'.
			    				'</tr>';
			}

			//On affiche enfin nos infosMonsters remplies comme il faut.
			echo $infosQuests;
		?>
		</tbody>
	</table>
</div>