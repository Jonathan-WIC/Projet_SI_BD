<h3>Administrer les quêtes du jeu</h3>
<div>
	<table id="tableQuest" class="table table-bordered">
		<thead><tr>
				<th>Id</th>
				<th>Fee</th>
				<th>Starting Date</th>
				<th>Durée</th>
				<th>Complete</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			/**
				get monsters informations
			**/
			$client = new MDBaseClient();
			$quests = $client->getAllQuests();

			//On boucle sur quests pour remplir le tableau
			$infosQuests = "";
			for($i = 0 ; $i < count($quests) ; ++$i){
				if($quests[$i]['IS_COMPLETED'] == 1)
					$quests[$i]['IS_COMPLETED'] = "Yes";
				else
					$quests[$i]['IS_COMPLETED'] = "No";

			    $infosQuests.= '<tr>'.
			    				'<td>'.$quests[$i]['ID_QUEST'].'</td>'.
			    				'<td>'.$quests[$i]['FEE'].'</td>'.
			    				'<td>'.$quests[$i]['DATE_DEB'].'</td>'.
			    				'<td>'.$quests[$i]['DURATION'].'</td>'.
			    				'<td>'.$quests[$i]['IS_COMPLETED'].'</td>'.
			    				'</tr>';
			}

			//On affiche enfin nos infosMonsters remplies comme il faut.
			echo $infosQuests;
		?>
		</tbody>
	</table>
</div>