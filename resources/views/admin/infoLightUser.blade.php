@extends('admin.layout')
@section('content')
       


<div class="container-fluid">
  
    <div class="row">
      <div  id="data" class="col-lg-12"></div>
      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Chỉnh sửa <span id="vitri"></span> ở khu <span id="khuvuc"></span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Thời gian bật</label>
            <input type="text" id="timeOn" >
          </div>
          <div class="form-group">
            <label>Thời gian tắt</label>
            <input type="text" id="timeOff" >
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
          <button type="button" class="btn btn-primary" onclick="schedule()">Save changes</button>
        </div>
        </div>
      </div>
      </div>
  
    </div>
  </div>
  <script src="https://www.gstatic.com/firebasejs/4.9.1/firebase.js"></script>
  <script>
  
    // Your web app's Firebase configuration
  var config = {
      // For Firebase JS SDK v7.20.0 and later, measurementId is optional
      apiKey: "AIzaSyDALM_5R0Urb4DqFI2Nw-MTd7mQMZC9TMY",
      authDomain: "demohung-79e75.firebaseapp.com",
      databaseURL: "https://demohung-79e75-default-rtdb.firebaseio.com",
      projectId: "demohung-79e75",
      storageBucket: "demohung-79e75.appspot.com",
      messagingSenderId: "702900136548",
      appId: "1:702900136548:web:1e2aea1895a3221c874d71",
      measurementId: "G-4LZ387LRFB"
  
  };
  // Initialize Firebase
  firebase.initializeApp(config);
  
  var database = firebase.database();
  
  var lastIndex = 0;
  
  // Get Data
  firebase.database().ref({{$idUser}}).on('value', function(snapshot) {
  
      console.log();
      var values = snapshot.val();
      var htmls = [];
      $.each(values, function(index, value) {
  
          htmls.push(headTable(index));
          var location = "'" + index + "'";
        //   console.log(value.);
  
          $.each(value, function(index1, value1) {
  
              if (value1) {
                  var switc;
                  if (value1.status == 'ON') {
                      switc = 'Tắt';
                  } else {
                      switc = 'Bật';
                  }
                  var color = null;
                  if (value1.status == 'ON') {
                      color = 'style="color: rgb(84, 255, 4)"';
                  } else {
                      color = 'style="color: brown"';
                  }
                  console.log(color);
                  htmls.push('<tr ' + color + '>\
                  <td data-id="' + index1 + '" class="light">' + index1 + '</td>\
                  <td class="Light">  ' + index1 + '</td>\
                  <td id="' + index + index1 + '">' + value1.status + '</td>\
                  <td class="schedule">' + value1.TimeOn + '</td>\
                  <td class="schedule">' + value1.TimeOff + '</td>\
                  <td><button  type="button" class="btn btn-primary" onclick="switchLight(' + index1 + ',' + location + ')">' + switc + '</button>\
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="openModal(' + index1 + ',' + location + ')">Open Modal</button>\
                  </td>\
                  </tr>');
              }
          });
          // console.log(htmls.toString());
          htmls.push(endTable());
          $('#data').html(htmls.toString());
      });
  });
  
  function headTable(NameTable) {
      console.log(NameTable);
      return '<h3>Tên khu vực ' + NameTable + '</h3>\
      <button class="btn btn-secondary" onclick=(addlight(' +"'"+NameTable+"'"+ '))> thêm ứng dụng </button>\
      <table class="table table-striped">\
      <thead>\
        <tr>\
          <th>stt</th>\
          <th>tên ứng dụng</th>\
          <th>trạng thái</th>\
          <th>lịch bật ứng dụng</th>\
          <th>lịch tắt ứng dụng</th>\
          <th></th>\
          </tr>\
        </thead>\
        <tbody id="'+NameTable+'">';
  }
  
  function endTable() {
      return '</tbody>\
      </table>\
      </div>';
  }
  
  // var route;
  // var location;
  function openModal(location,route) {
    // this.location=location;
    // this.route=route;
    console.log(location+"ffff"+route);
    $("#vitri").empty();
    $("#vitri").append(location);
    $("#khuvuc").empty();
    $("#khuvuc").append(route);
    $("#myModal").modal({ show: true });
  }
  
  // When the user clicks on <span> (x), close the modal
  // span.onclick = function() {
  // }
  function closeModal(){
    console.log("fffjjjjaaaaasss");
    $('#myModal').modal('hide');
  }
  
  //bật tắt đèn
  function switchLight(route, location) {
  
      // console.log("fffffff");
      var id = location + route;
      console.log(id);
      var status1 = document.getElementById(id).innerHTML;
  
      console.log(route + " " + location);
      ajax(route, status1, location)
  }
  
  function ajax(route, status, location) {
      $.ajax({
          type: 'GET',
          url: '/firebase/switch',
          data: {
              route: route,
              status: status,
              location: location,
          },
          success: function(data) {
              console.log(data);
          }
      });
  }
  
  
  
  //change schedule
  function schedule() {
    
    console.log($("#vitri").text()+' '+$("#khuvuc").text()+' '+$("#timeOn").val())
    $.ajax({
          type: 'GET',
          url: '/firebase/schedule',
          data: {
              route: $("#vitri").text(),
              timeon: $("#timeOn").val(),
              location: $("#khuvuc").text(),
              timeoff: $("#timeOff").val(),
          },
          success: function(data) {
            $('#myModal').modal('hide');
            console.log(data);
          }
    });
  
  }
  
    function addlight(location){
        
        $.ajax({
            type: 'GET',
          url: '/admin/addHome',
          data: {
              location: location,
              idUser: {{$idUser}},
              route:$("#locationA").find('td.light').length,
          },
          success: function(data) {
            $('#myModal').modal('hide');
            console.log(data);
          }
        });
    }


  </script>
  
    
@endsection