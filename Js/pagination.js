
// Pagination
function pagination(nbPage, page, method){
	endPagin2 = nbPage - 4;
	endPagin1 = nbPage - 3;

	var previousPage = parseInt(page - 1);
	var nextPage = parseInt(page) + 1;

	$('#pagination').empty();
	$('#pagination').append('<li id="previousArrow" onclick="'+method+'('+ previousPage +')">'+
								'<a href="#" aria-label="Previous">'+
									'<span aria-hidden="true">&laquo;</span>'+
								'</a>'+
							'</li>');

	if (previousPage == 0){
		$('#previousArrow').attr('class', 'disabled');
		$('#previousArrow').removeAttr('onclick');
	}
	
	//Si le nombre de page est limité, 12 pages reste très correct, on affiche simplement la pagination
	if(nbPage <= 12){
		for (var i = 1; i <= nbPage; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="'+method+'('+i+')">'+i+'</a></li>');
			if (i == page) {
				$('#page'+i).attr('class', 'active');
			}
		}
	//Sinon on coupe la pagination au milieu et on fait une navigation dynamique.
	} else{

		//On affiche les 3 premiers liens normalement
		for (var i = 1; i < 4; i++) {
			$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="'+method+'('+i+')">'+i+'</a></li>');
			if (i == page) {
				$('#page'+i).attr('class', 'active');
			}
		}

		//Si la page active est soit dans les 3 premiers, soit dans les 3 derniers, on coupe au milieu et on affiche '...'
		if(page < 3 || page > (nbPage-2)){
			$('#pagination').append('<li class="disabled"><a href="#">...</a></li>');

		} else if(page == 3){
			$('#pagination').append('<li id="page'+4+'"><a href="#" onclick="'+method+'('+4+')">'+4+'</a></li>');
			$('#pagination').append('<li class="disabled"><a href="#">...</a></li>');
		} else if(page == 4){
			$('#pagination').append('<li id="page'+4+'"><a href="#" onclick="'+method+'('+4+')">'+4+'</a></li>');
			$('#pagination').append('<li id="page'+5+'"><a href="#" onclick="'+method+'('+5+')">'+5+'</a></li>');
			$('#pagination').append('<li class="disabled"><a href="#">...</a></li>');
			$('#page'+page).attr('class', 'active');
		} else if(page > 4 && page < nbPage - 3){
			$('#pagination').append('<li class="disabled"><a href="#">...</a></li>');
			$('#pagination').append('<li id="page'+previousPage+'"><a href="#" onclick="'+method+'('+previousPage+')">'+previousPage+'</a></li>');
			$('#pagination').append('<li id="page'+page+'"><a href="#" onclick="'+method+'('+page+')">'+page+'</a></li>');
			$('#pagination').append('<li id="page'+nextPage+'"><a href="#" onclick="'+method+'('+nextPage+')">'+nextPage+'</a></li>');
			$('#pagination').append('<li class="disabled"><a href="#">...</a></li>');
			$('#page'+page).attr('class', 'active');
		} else if(page == nbPage - 3){
			$('#pagination').append('<li class="disabled"><a href="#">...</a></li>');
			$('#pagination').append('<li id="page'+endPagin2+'"><a href="#" onclick="'+method+'('+endPagin2+')">'+endPagin2+'</a></li>');
			$('#pagination').append('<li id="page'+endPagin1+'"><a href="#" onclick="'+method+'('+endPagin1+')">'+endPagin1+'</a></li>');
			$('#page'+page).attr('class', 'active');
		} else if(page == nbPage - 2){
			$('#pagination').append('<li class="disabled"><a href="#">...</a></li>');
			$('#pagination').append('<li id="page'+endPagin1+'"><a href="#" onclick="'+method+'('+endPagin1+')">'+endPagin1+'</a></li>');
		}

		for (var i = nbPage - 2; i <= nbPage; ++i) {
				$('#pagination').append('<li id="page'+i+'"><a href="#" onclick="'+method+'('+i+')">'+i+'</a></li>');
				if (i == page) {
					$('#page'+i).attr('class', 'active');
				}
			}
	}

	$('#pagination').append('<li id="nextArrow" onclick="'+method+'('+nextPage+')">'+
								'<a href="#" aria-label="Next">'+
									'<span aria-hidden="true">&raquo;</span>'+
								'</a>'+
							'</li>');

	if (nextPage > nbPage){
		$('#nextArrow').attr('class', 'disabled');
		$('#nextArrow').removeAttr('onclick');
	}		
};
