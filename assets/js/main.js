function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#prodpreview').attr('src', e.target.result);
        
      }
      
      reader.readAsDataURL(input.files[0]);
      var filename = document.getElementById('file-name');
      filename.innerHTML = input.files[0].name;
    }

    console.log(e.target.result);
  }
  
$("#prodphoto").change(function() {
    readURL(this);
});




// shorten product titles

$('.product-bottom h4').each(function(){
  console.log($(this).text())
  if($(this).text().length > 13){
    var shortname = $(this).text().substring(0, 13) + " ...";
    $(this).replaceWith("<h4>"+shortname+"</h4>");
  }
});

// search customer product list
function search(category){
  var term = $('#term').val();
  console.log(term)
  if(category !== ''){
    console.log(term)
    window.location.href = 'productList.php?category='+ category +'&term=' + term;
  }else{
    window.location.href = 'productList.php?&term=' + term;
  }
}

function search2(category){
  var term = $('#term2').val();
  console.log(term)
  if(category !== ''){
    console.log(term)
    window.location.href = 'productList.php?category='+ category +'&term=' + term;
  }else{
    window.location.href = 'productList.php?&term=' + term;
  }
}

