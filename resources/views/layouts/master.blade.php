<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="" sizes="76x76" href="">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
      Address Book | @yield('title')
  </title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" /> -->
  
</head>

<body>
  <div class="container-fluid">
      <nav class="navbar navbar-inverse">
          <div class="navbar-header">
              <a class="navbar-brand" href="{{ url('/list-address') }}"><i class="fa fa-address-book-o" aria-hidden="true"></i>  ADDRESS BOOK</a>
          </div>
      </nav>
      <!-- <div class="main-panel"> -->
      @yield('content')
    <div class="footer"></div>
  </div>

  <!--   Core JS Files   -->

</body>
<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function() {
    $('#products').DataTable(

      {
        "aLengthMenu": [
          [5, 10, 25, -1],
          [5, 10, 25, "All"]
        ],
        "iDisplayLength": 5
      }
    );
  });


  function checkAll(bx) {
    var cbs = document.getElementsByTagName('input');
    for (var i = 0; i < cbs.length; i++) {
      if (cbs[i].type == 'checkbox') {
        cbs[i].checked = bx.checked;
      }
    }
  }

  function parentCategory() {

    var x = $("#parent_category").val();
    if (x == '--select--') {
      $('#sub_category').empty();
      $('#child_category').empty();
    }

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: 'post',
      data: {
        'id': x
      },
      url: "{{ url('get-sub-child')}}",
      success: function(result) {

        $('#sub_category').empty();
        $('#sub_category').append($("<option>--select--</option>").attr({
          "value": ''
        }));
        for (var i = 0; i < result.length; i++) {
          var id = result[i].id;
          var s_cat = result[i].s_cat;
          $('#sub_category').append($("<option></option>").attr({
            "value": id
          }).text(s_cat)).trigger("chosen:updated");
        }
      }
    });
  }

  // Read Url of image file and show the content.
  function readURL(input) {

  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
          $('#product_image').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
  }
}

$("#file").change(function(e) {

        var ext = $('#file').val().split('.').pop().toLowerCase();

        if($.inArray(ext, ['png','jpg','jpeg','gif','webp','svg']) == -1) {
            alert('Please upload a valid image file (ex. jpg, png, jpeg, gif, webp, svg)!');
            var url = "https://www.centrik.in/wp-content/uploads/2017/02/user-image-.png";
            $("#product_image").prop("src", url);
            $("#file").val("");
            return false;
        }

        // Get size of file.
        const size = (this.files[0].size / 1024 / 1024).toFixed(2);
        
        var realFileSize = this.files[0].size / 1024;
        
        //Validate for size 300KB.
        if(realFileSize > 300)
        {
            alert("File must be between the size of 1-300 KB");
            var url = "https://www.centrik.in/wp-content/uploads/2017/02/user-image-.png";
            $("#product_image").prop("src", url);
            $("#file").val("");
            return false;
        }

        //Validate for dimension 150x150.
        var u = URL.createObjectURL(this.files[0]);
        var img = new Image;

        img.onload = function() {
         
          if(  (img.width != 150)  && (img.height != 150) ) 
          {
              alert("Image dimension 150 x 150 size allowed only.");
              var url = "https://www.centrik.in/wp-content/uploads/2017/02/user-image-.png";
              $("#product_image").prop("src", url);
              $("#file").val("");
              return false;
          }
        };
        
        img.src = u;

        readURL(this);
});
</script>

<script>
  $("#complexConfirm").confirm({
    title:"Delete confirmation",
    text:"This is very dangerous, you shouldn't do it! Are you really really sure?",
    confirm: function(button) {
        alert("You just confirmed.");
    },
    cancel: function(button) {
        alert("You aborted the operation.");
    },
    confirmButton: "Yes I am",
    cancelButton: "No"
});
</script>

</html>