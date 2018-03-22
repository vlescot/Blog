<?php ob_start();?>
 
    <header>
    	<h1 class="text-center">Liste des commentaires</h1>
    </header>

	<section class="container">
		<a href="index.php" role="button" class="btn btn-outline-dark btn-sm">
			<i class="fas fa-undo"></i> Retour
		</a>
		<p class="h2 text-center no-comment">Aucun commentaire n'est en attente de validation</p>
		<p class="h2 text-center get-comment">Nouveau commentaire (<?= 0 ?>)</p>
	</section>

	<section class="container get-comment">
		<table id="comment-listing" class="table">
		  <tr>
		    <th>Date</th>
		    <th style="min-width: 50%;">Commentaire</th>
		    <th colspan="2">Rendre visible</th>
		    <th></th> 
		  </tr>
		  <tr>
		  	<td>10/02/2018 à 97h45</td>
		    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum omnis, natus! Inventore aperiam laudantium ducimus id. Obcaecati eligendi in, fuga molestias, explicabo tempore velit natus, nostrum dolorum nulla ratione qui.</td>
		    <td>
		    	<form action="check.php" method="post" enctype="multipart/form-data">
					<div class="form-check">
						<input class="form-check-input" type="radio" name="exampleRadios" id="visibilityOn" value="on" checked>
						<label class="form-check-label" for="visibilityOn">Oui</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="exampleRadios" id="visibilityOff" value="off">
						<label class="form-check-label" for="visibilityOff">Non</label>
					</div>
				</form>
			</td> 
		    <td><a href="" role="button" class="btn btn-delete btn-sm"><i class="far fa-trash-alt"></i> Supprimer</a></td>
		  </tr>
		  <tr>
		  	<td>10/02/2018 à 97h45</td>
		    <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Porro dolor officia assumenda vero distinctio adipisci sint! Architecto tempore vitae porro, temporibus, reiciendis esse distinctio dicta aliquid officiis consectetur iste voluptates!</td>
		    <td>
		    	<form action="check.php" method="post" enctype="multipart/form-data">
					<div class="form-check">
						<input class="form-check-input" type="radio" name="exampleRadios" id="visibilityOn" value="on" checked>
						<label class="form-check-label" for="visibilityOn">Oui</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="exampleRadios" id="visibilityOff" value="off">
						<label class="form-check-label" for="visibilityOff">Non</label>
					</div>
				</form>
			</td> 
		    <td><a href="" role="button" class="btn btn-delete btn-sm"><i class="far fa-trash-alt"></i> Supprimer</a></td>
		  </tr>
		</table>
		<div class="col-md-12 text-center">
			 <button style="width: 100px;" type="submit" class="btn btn-add btn-sm">Valider <i class="fas fa-check"></i></button>
		</div>
	</section>

<?php
// require 'check.php';
 $content = ob_get_clean(); ?>
	
<?php require 'layout.php'; ?>