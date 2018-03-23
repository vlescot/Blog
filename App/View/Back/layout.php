<!DOCTYPE html>
<html lang="fr">

  <head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
  
    <title>Titre</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="./../../Public/img/favicon.ico">
  
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Custom fonts for this template -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
  
    <!-- My styles -->
    <link href="./../../../Public/css/back_style.css" rel="stylesheet">

  </head>

  <body id="back-app">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-perso fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="./../Front/index.php">Le Blog</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php?v=posts">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php?v=comments">Commentaires</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

<?= $content; ?>

    <footer>
        <div class="row" id="my-links">
            <a class="offset-md-2 col-md-2 col-6" href="https://github.com/vlescot" target="_blank"><i class="fab fa-github fa-2x"></i></a>
            <a class="col-md-2 col-6" href="https://www.linkedin.com/in/vincent-lescot-70916959/" target="_blank"><i class="fab fa-linkedin-in fa-2x"></i></a>
            <a class="col-md-2 col-6" href="https://twitter.com/VinceLesc" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
            <a class="col-md-2 col-6" href="mailto:vincent.lescot@gmail.com" target="_blank"><i class="far fa-envelope fa-2x"></i></a>
        </div>
        <div id="copyright" class='text-center'>© 2018 - Réalisé par Vincent Lescot</div>
    </footer>
    
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $( document ).ready(function() {
            var bodyHeight = Math.round($("body").height());
            var windowHeight = Math.round($(window).height());
            
            if (windowHeight - bodyHeight > 0) {
                $("footer").css("margin-top", windowHeight - bodyHeight - 5)
            }
        });
    </script>
  </body>
</html>