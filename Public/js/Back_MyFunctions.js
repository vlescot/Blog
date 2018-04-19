// onclick on the button delete on page article
function deletePost(id){
  if (confirm("Êtes vous certain(e) de vouloir supprimer cet article ?")) {
    $.post(window.location.href, 'id='+id, location.reload(true), "text");
  }
}

// onclick on the radio input (validation page)
function validation (table, id, validation){
  $.post(window.location.href, 'table='+table+'&id='+id+'&validation='+validation, location.reload(true), "text");
}

// onclick on the button delete on validation page
function deleteComment (id){
  if (confirm("Êtes vous certain(e) de vouloir supprimer ce commentaire ?")) {
    // console.log(window.location.href + '/deleteComment');
    $.post(window.location.href + '/deleteComment', 'comment=delete&id='+id, location.reload(true), "text");
  }
}

$( document ).ready(function() {
  // Toggle filters on click
  $("#filter").click(function(){
      $("#date_filter").slideToggle();
  });

  // Change label's image after upload $_file
  var file = $("#file");
  file.change(function(){
    var imgLabel = $("form label img");
    imgLabel.attr('src', 'http://localhost/P5/Blog/Public/img/uploaded-img.png');
    imgLabel.attr('alt', 'image-changed');
  });

  // Adjust margin-top of header
  var nav = $('nav');
  var navbarHeight = nav.height() + parseInt(nav.css('padding-top')) + parseInt(nav.css('padding-bottom'));
  $('header').css('margin-top', navbarHeight);
});