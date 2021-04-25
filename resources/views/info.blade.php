{{-- <!DOCTYPE html>
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
<body> --}}

@extends('layout')
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
          Chỉnh sửa đèn <span id="vitri"></span> ở khu <span id="khuvuc"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group" >
          <label>thời gian bật</label>
          <input type="text" id="timeOn" >
        </div>
        <div class="form-group">
          <label>thời gian tắt</label>
          <input type="text" id="timeOff" >
        </div>
      </div>
      <div class="modal-footer" >
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
firebase.database().ref({{ Auth::user()->id}}).on('value', function(snapshot) {

    console.log();
    var values = snapshot.val();
    var htmls = [];
    $.each(values, function(index, value) {

        htmls.push(headTable(index));
        var location = "'" + index + "'";

        $.each(value, function(index1, value1) {

            if (value1) {
                var switc;
                if (value1.status == 'ON') {
                    switc = 'Tắt đèn';
                } else {
                    switc = 'bật đèn';
                }
                var color = null;
                if (value1.status == 'ON') {
                    color = 'style="color: rgb(84, 255, 4)"';
                } else {
                    color = 'style="color: brown"';
                }
                if(value1.broken=='true')
                  colorbroken = 'style="color: rgb(29, 4, 255)"';
                else
                colorbroken = 'style="color: rgb(255, 255, 255)"';

                // console.log(color);
                htmls.push('<tr class="light"' + color + '>\
                <td data-id="' + index1 + '" >' + index1 + '</td>\
                <td> đèn ' + index1 + '</td>\
                <td id="' + index + index1 + '">' + value1.status + '</td>\
                <td class="schedule">' + value1.TimeOn + '</td>\
                <td class="schedule">' + value1.TimeOff + '</td>\
                <td><button  type="button" class="btn btn-primary" onclick="switchLight(' + index1 + ',' + location + ')">' + switc + '</button>\
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="openModal(' + index1 + ',' + location + ')">Open Modal</button>\
                <button type="button" class="btn btn-info" '+colorbroken+' onclick="broken(' + index1 + ',' + location + ','+value1.broken+')">đèn bị hư</button>\
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
    <table class="table table-striped">\
    <thead>\
      <tr>\
        <th>stt</th>\
        <th>tên đèn</th>\
        <th>trạng thái</th>\
        <th>lịch bật đèn</th>\
        <th>lịch tắt đèn</th>\
        <th></th>\
        </tr>\
      </thead>\
      <tbody>';
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

function broken(route, location, status) { 

  $.ajax({
        type: 'GET',
        url: '/firebase/broken',
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
</script>

@endsection
{{-- </body>
</html> --}}