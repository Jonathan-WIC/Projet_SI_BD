<h1>Bienvenue sur Monster Park !</h1>
<nav class="navbar navbar-default">
	<div class="container-fluid">
	<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-header">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		  <a class="navbar-brand" href="index.php?EX=home">Home</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="#navbar-header">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ma page<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="index.php?EX=myParks">Mes park</a></li>
						<li><a href="index.php?EX=myMonsters">Mes monstres</a></li>
						<li><a href="index.php?EX=myItems">Mon inventaire</a></li>
					</ul>
				</li>
				<li><a href="index.php?EX=quest">Quêtes</a></li>
				<li><a href="index.php?EX=store">Magasins</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<form class="navbar-form navbar-left" role="search">
			        <div class="form-group">
			        	<input type="text" id="headerUsername" class="form-control headerUsername" placeholder="UserName">
			        	<input type="password" id="headerPassword" class="form-control headerPassword" placeholder="Password">
			        </div>
			        <button type="submit" class="btn btn-default">Log in</button>
			    </form>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mon compte<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Mes informations</a></li>
						<li><a href="#">Mes transactions</a></li>
						<li class="divider"></li>
						<li><a href="#">Se déconnecter</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>