// onclick on the button delete 
function deletePost(id){
  if (confirm("Êtes vous certain(e) de vouloir supprimer cet article ?")) {
    $.post(window.location.href, 'id='+id, location.reload(true), "text");
  }
}

// onclick on the radio input (validation page)
function validation (table, id, validation){
  $.post(window.location.href, 'table='+table+'&id='+id+'&validation='+validation, location.reload(true), "text");
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
});