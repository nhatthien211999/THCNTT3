<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    div.solid {border-style: solid;}
  </style>
</head>
<body>



<div class="container-fluid">
  
  <div class="row">
    <div  id="data" class="col-lg-12"></div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>thời gian bật</label>
          <input type="text" >
        </div>
        <div class="form-group">
          <label>thời gian tắt</label>
          <input type="text" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="close()">Close</button>
        <button type="button" class="btn btn-primary" >Save changes</button>
      </div>
      </div>
    </div>
    </div>

  </div>
</div>
<script src="https://www.gstatic.com/firebasejs/4.9.1/firebase.js"></script>
<script src="/script/script.js"></script>

</body>
</html>