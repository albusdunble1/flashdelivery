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
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

