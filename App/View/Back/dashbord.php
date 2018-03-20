<?php ob_start(); ?>

    <header>
    	<h1 class="text-center">Tableau de bord</h1>
    </header>

	<div style="height: 40px;"></div>
	<!-- Dashboard -->
	<section class="container text-center">
		<div class="row justify-content-center">
			<div class="col-md-6 col-sm-12">
				<div class="jumbotron">
				  <h3 class="">Articles</h3>
				  <hr>
				  <p>Description de l'action</p>
				  <hr>
				  <p class="lead">
				    <a href="index.php?view=posts" class="btn btn-outline-primary btn-sm" role="button">Administrer</a>
				  </p>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="jumbotron">
				  <h3 class="">Commentaires</h3>
				  <hr>
				  <p>Description de l'action</p>
				  <hr>
				  <p class="lead">
				    <a class="btn btn-outline-primary btn-sm" href="index.php?view=comments" role="button">Administrer</a>
				  </p>
				</div>
			</div>
		</div>		
	</section>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php'); ?>