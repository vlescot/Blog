<?php ob_start(); ?>
 
    <header>
    	<h1 class="text-center">Édition de l'article</h1>
    </header>

	<section class="container">
		<a href="index.php?view=posts" role="button" class="btn btn-outline-dark btn-sm">
			<i class="fas fa-undo"></i> Retour
		</a>
	</section>
	

	<section class="container">
		<form action="#" method="post" enctype="multipart/form-data">
	
			<div class="form-row">
				<div class="col-md-12">
					<div class="form-row">
						<div class="col-md-8">
							<div class="form-row">
								<div class="col-md-12 form-group">
									<label for="title">Titre</label>
									<input type="text" class="form-control" id="title" placeholder="" required>
								</div>
								<div class="col-md-12 form-group">
									<label for="lede">Châpo</label>
									<input type="text" class="form-control" id="lede" placeholder="" required>								
								</div>
							</div>
						</div>
						<div class="offset-md-1 col-md-3">
							<div class="form-group">
									Rendre l'article Visible :
							</div>
							<div class="form-group">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="visibilityOn" value="on">
									<label class="form-check-label" for="visibilityOn">Oui</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="visibilityOff" value="off">
									<label class="form-check-label" for="visibilityOff">Non</label>
								</div>
							</div>	
                            <label for="file" class="form-group">
                            	Image d'en-tête <small>(format : jpg ou png)</small>
							</label>
                            <div class="form-group">
								<input type="file" class="" id="file">
                        	</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-12 form-group">
					<label for="exampleFormControlTextarea1">Contenu</label>
					<textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
				</div>
				<div class="col-md-12 form-group">
					<label for="tag">??? Tags ???</label>
					<input type="text" class="form-control" id="tag" placeholder="">
				</div>
				<div class="col-md-12 text-center">
					 <button type="submit" class="btn btn-add btn-sm">Enregistrer l'article</button>
				</div>
			</div>

		</form>
	</section>	

<?php $content = ob_get_clean(); ?>
	
<?php require 'layout.php'; ?>