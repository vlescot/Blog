<?php ob_start(); ?>
 
    <header>
    	<h1 class="text-center">Liste des articles</h1>
    </header>

	<section>
		<div class="container">
			<a href="index.php" role="button" class="btn btn-outline-dark btn-sm">
				<i class="fas fa-undo"></i> Retour
			</a>
			<a href="index.php?view=addPost" role="button" class="btn btn-add float-right btn-sm">
				<i class="fas fa-plus-circle"></i> Ajouter un Article
			</a>
		</div>
	</section>

	<section>
		<div class="container">
			<table id="post-listing" class="table">
			  <tr>
			    <th>Voir</th>
			    <th>Image</th>
			    <th>Titre</th> 
			    <th>Dernière Modification</th>
			    <th>Auteur</th>
			    <th>Validé</th>
			    <th>Action</th>
			  </tr>
			  <tr>
			  	<td>
			  		<a href="https://google.fr" style="font-size:2em;">
	  					<i class="fas fa-share-square"></i>
					</a>
				</td>
			    <td>
			    	<div class="post-img">
			    		<img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="image-post">
			    	</div>
			    </td>
			    <td>La vie doit être vécu<small class="form-text text-muted">Parce que sinon c'est mal</small></td> 
			    <td>Le 05 mars 2018 à 18h30</td>
			    <td>Root</td>
			    <td>Oui</td>
			    <td>
			    	<a href="" role="button" class="btn btn-update btn-sm"><i class="far fa-edit"></i> Modifier</a>
			    	<a href="" role="button" class="btn btn-delete btn-sm"><i class="far fa-trash-alt"></i> Supprimer</a>
				</td>
			  </tr>
			  <tr>
			  	<td>
			  		<a href="https://google.fr" style="font-size:2em;">
	  					<i class="fas fa-share-square"></i>
					</a>
				</td>
			    <td>
			    	<div class="post-img">
			    		<img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="image-post">
			    	</div>
			    </td>
			    <td>La vie doit être vécu<small class="form-text text-muted">Parce que sinon c'est mal</small></td> 
			    <td>Le 05 mars 2018 à 18h30</td>
			    <td>Root</td>
			    <td>Oui</td>
			    <td>
			    	<a href="" role="button" class="btn btn-update btn-sm"><i class="far fa-edit"></i> Modifier</a>
			    	<a href="" role="button" class="btn btn-delete btn-sm"><i class="far fa-trash-alt"></i> Supprimer</a>
				</td>
			  </tr>
			</table>
		</div>
	</section>

<?php $content = ob_get_clean(); ?>
	
<?php require 'layout.php'; ?>