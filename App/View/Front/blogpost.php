<?php ob_start(); ?>

    <header class="masthead masthead-post text-center text-white d-flex" style="background-image: url(1.jpg);">
		<div class="cover">
	      <div class="container my-auto">
	        <div class="row">
	          <div class="col-lg-10 mx-auto">
	            <h1 class="text-uppercase">
	              <strong>Titre</strong>
	            </h1>
	            <hr>
	          </div>
	          <div class="col-lg-8 mx-auto">
	            <p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</strong></p>
	          </div>
	        </div>
	      </div>
		</div>
    </header>

    <section id="post">
      <div class="container">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 mx-auto">
            <a href="blog.php" class="btn btn-back"><i class="fas fa-undo"></i> Retour</a>
            <p class="post-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio necessitatibus voluptas suscipit, exercitationem at accusantium quae quidem fugit veniam, dicta iure consequatur eius ducimus voluptatibus labore dolor. Similique, dolores, laboriosam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque ipsam suscipit quae et impedit aliquid culpa ea repudiandae sequi deleniti! Dolorem earum sequi ducimus, enim a autem magni iusto impedit.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio necessitatibus voluptas suscipit, exercitationem at accusantium quae quidem fugit veniam, dicta iure consequatur eius ducimus voluptatibus labore dolor. Similique, dolores, laboriosam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque ipsam suscipit quae et impedit aliquid culpa ea repudiandae sequi deleniti! Dolorem earum sequi ducimus, enim a autem magni iusto impedit.</p>
            <p class="text-right infos"><strong>Par Auteur,</br>le Lundi 02 février 2018</strong></p>
          </div>
        </div>
      </div>
    </section>
    
    <hr class="break-post">

    <section id="comments">
      <div class="container">
        <div class="row">
          <div class="col-md-8 offset-md-4 col-lg-6 offset-lg-6 mx-auto">
            <h2 class="section-heading">Commentaires :</h2>
            <div class="comment-content">
              <p class="comment">Super !</p>
              <p class="text-right infos"><strong>Par Auteur, le Lundi 02 février 2018 à 21h02</strong></p>
            </div>
            <div class="comment-content">
              <p class="comment">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio necessitatibus voluptas suscipit, exercitationem at accusantium quae quidem fugit veniam, dicta iure consequatur eius ducimus voluptatibus labore dolor. Similique, dolores, laboriosam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque ipsam suscipit quae et impedit aliquid culpa ea repudiandae sequi deleniti! Dolorem earum sequi ducimus, enim a autem magni iusto impedit.</p>
              <p class="text-right infos"><strong>Par Auteur, le Lundi 02 février 2018 à 21h02</strong></p>
            </div> 
            <form action="#" method="post" class="form-inline">
                <div class="form-group">
                  <input type="text" placeholder="Votre nom" class="form-control col-3" required>
                  <textarea class="form-control col-7" rows="3" placeholder="Écrire un commentaire..." required></textarea>
                  <button type="submit" class="btn btn-primary col-2">Poster</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
<?php $content = ob_get_clean(); ?>
	
<?php require 'layout.php'; ?>