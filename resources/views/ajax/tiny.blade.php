
<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/bfr93pekxrwztnw15luq7902jvyax1aqpv75n72jlqz6qct1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
<style>
h1,h2,h3,h4,h5,h6{
font-family: Tahoma !important;
}
p,li,ol,ul,span,a,select,option,button, label{
font-family: Tahoma !important;
font-size:14px !important;
font-weight:300 !important;
}
.btn{
display:inline-block;
margin-bottom:0;
border:1px solid transparent;
cursor:pointer;
border-radius:0;
}
.btn-primary{
background-color: #2895ea;
border-color: #2895ae;
color: #fff;
}
</style>

    <form role="form" method="POST" action="{{ route('productes.update', $id) }}">
        @csrf
        @method('PUT')
  <textarea name="long_description" id="myeditorinstance">
    {!!$producte[0]['long_description']!!}
  </textarea>
</select>
<p><button class="btn btn-primary action" type="submit"><a class="action">зерегти</a></button></p>
</form>
  <script>
    tinymce.init({
      selector: 'textarea#myeditorinstance',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
   @if (session('success'))
   <div style="background-color:green;" class="alert alert-success" role="alert">

       <h2><i class="icon fa fa-check"></i> {{ session('success')}}</h2>
   </div>
   @endif
  



</body>
</html>
