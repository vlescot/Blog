<?php ob_start(); ?>

    <header class="masthead text-center text-white d-flex">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <strong>Titre</strong>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
            <p class="text-faded mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
          </div>
        </div>
      </div>
    </header>

    <section id="post-list">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
			<div class="row">
				<div class="jumbotron jumbotron-fluid col-md-6">
					<a class="portfolio-box" href="blogpost.php">
					  <div class="container portfolio-box-caption">
						<img class="img-fluid" src="./../../../Public/img/portfolio/thumbnails/1.jpg" alt="">
						<div class="portfolio-box-caption">
							<div class="portfolio-box-caption-content">
							    <h3 class="project-name">Titre de l'article</h3>
							    <p class="project-category">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam enim facere ratione alias nesciunt, velit, eius ea, architecto iure delectus error neque assumenda, cum repellendus nostrum molestias minus impedit consequuntur.</p>
							</div>
						</div>

					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <p class="text-right describe"><small>Crée par Auteur le 01/01/2018</small></p>
					  </div>
					</a>
				</div>
				<div class="jumbotron jumbotron-fluid col-md-6">
					<a class="portfolio-box" href="blogpost.php">
					  <div class="container portfolio-box-caption">
						<img class="img-fluid" src="./../../../Public/img/portfolio/thumbnails/1.jpg" alt="">
						<div class="portfolio-box-caption">
							<div class="portfolio-box-caption-content">
							    <h3 class="project-name">Titre de l'article</h3>
							    <p class="project-category">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam enim facere ratione alias nesciunt, velit, eius ea, architecto iure delectus error neque assumenda, cum repellendus nostrum molestias minus impedit consequuntur.</p>
							</div>
						</div>

					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <p class="text-right describe"><small>Crée par Auteur le 01/01/2018</small></p>
					  </div>
					</a>
				</div>
				<div class="jumbotron jumbotron-fluid col-md-6">
					<a class="portfolio-box" href="blogpost.php">
					  <div class="container portfolio-box-caption">
						<img class="img-fluid" src="./../../../Public/img/portfolio/thumbnails/1.jpg" alt="">
						<div class="portfolio-box-caption">
							<div class="portfolio-box-caption-content">
							    <h3 class="project-name">Titre de l'article</h3>
							    <p class="project-category">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam enim facere ratione alias nesciunt, velit, eius ea, architecto iure delectus error neque assumenda, cum repellendus nostrum molestias minus impedit consequuntur.</p>
							</div>
						</div>

					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <p class="text-right describe"><small>Crée par Auteur le 01/01/2018</small></p>
					  </div>
					</a>
				</div>
				<div class="jumbotron jumbotron-fluid col-md-6">
					<a class="portfolio-box" href="blogpost.php">
					  <div class="container portfolio-box-caption">
						<img class="img-fluid" src="./../../../Public/img/portfolio/thumbnails/1.jpg" alt="">
						<div class="portfolio-box-caption">
							<div class="portfolio-box-caption-content">
							    <h3 class="project-name">Titre de l'article</h3>
							    <p class="project-category">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam enim facere ratione alias nesciunt, velit, eius ea, architecto iure delectus error neque assumenda, cum repellendus nostrum molestias minus impedit consequuntur.</p>
							</div>
						</div>

					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <span class="badge badge-info">Catégorie</span>
					    <p class="text-right describe"><small>Crée par Auteur le 01/01/2018</small></p>
					  </div>
					</a>
				</div>

			</div>
          </div>
        </div>
      </div>
    </section>


<?php $content = ob_get_clean(); ?>
	
<?php require 'layout.php'; ?>