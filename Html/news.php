<h3>Voici les News du jeu</h3>
<div id="divNew">
	<?php 
		/**
			get monsters informations
		**/
		$client = new MDBaseClient();
		$news = $client->getNewsFromGame();

		//On boucle sur quests pour remplir le tableau
		$divNews = "";
		for($i = 0 ; $i < count($news) ; ++$i){

		    $divNews.= 	'<div>'.
	    				'<img alt="news picture" src="'.$news[$i]['PICTURE'].'"/>'.
	    				'<h3>'.$news[$i]['TITLE'].'</h3>'.
	    				'<p>'.$news[$i]['PUBLICATION'].'</p>'.
	    				'<p>'.$news[$i]['CONTENT'].'</p>'.
	    				'</div>';
		}

		//On affiche enfin nos infosMonsters remplies comme il faut.
		echo $divNews;
	?>
</div>