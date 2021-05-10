{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">


  <style>
    div.solid {border-style: solid;}
  </style>
</head>
<body> --}}

@extends('layout')
@section('content')
    


<div class="container-fluid">
  
  <div class="row">
    <h1>
      Bảng thông kê số lần bật tắt ứng dụng trong ngày
    </h1>

    <div class="col-md-12">
      <div id="myfirstchart" style="height: 250px;"></div>
    </div>

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
        <div class="form-group" >
          <label>Thời gian bật</label>
          <input type="text" id="timeOn" >
        </div>
        <div class="form-group">
          <label>Thời gian tắt</label>
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

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
</div>

<script src="https://www.gstatic.com/firebasejs/4.9.1/firebase.js"></script>
<script>

  // Your web app's Firebase configuration
var config = {
    apiKey : "AIzaSyAn7Mr-qA8ACcUSuVAessjj56IqQM7EQCo" ,   
    authDomain : "thcntt3-982e7.firebaseapp.com" ,   
    projectId : "thcntt3-982e7" ,
    databaseURL: "https://thcntt3-982e7-default-rtdb.firebaseio.com/",
    storageBucket : "thcntt3-982e7.appspot.com" ,   
    messagingSenderId : "854659235227" ,   
    appId : "1: 854659235227: web: 475287af459a45391a353e"

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
                    switc = 'Tắt';
                } else {
                    switc = 'Bật';
                }
                var color = null;
                if (value1.status == 'ON') {
                    color = 'style="color: rgb(0, 0, 255)"';
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
                <td>  ' + index1 + '</td>\
                <td id="' + index + index1 + '">' + value1.status + '</td>\
                <td class="schedule">' + value1.TimeOn + '</td>\
                <td class="schedule">' + value1.TimeOff + '</td>\
                <td><button  type="button" class="btn btn-primary" onclick="switchLight(' + index1 + ',' + location + ')">' + switc + '</button>\
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="openModal(' + index1 + ',' + location + ')">Hẹn giờ</button>\
                <button type="button" class="btn btn-info" '+colorbroken+' onclick="broken(' + index1 + ',' + location + ','+value1.broken+')">Bị hư</button>\
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
        <th>STT</th>\
        <th>Tên</th>\
        <th>Trạng thái</th>\
        <th>Lịch bật</th>\
        <th>Lịch tắt</th>\
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
//---------------------------------------------------------
$(function(){
    // Create a function that will handle AJAX requests
    function requestData(days, chart){
    $.ajax({
      type: "GET",
      url: "{{url('api/data')}}", // This is the URL to the API
      data: { days: days }
    })
    .done(function( data ) {
      // When the response to the AJAX request comes back render the chart with new data
      chart.setData(JSON.parse(data));
    })
    .fail(function() {
      // If there is no communication between the server, show an error
      alert( "error occured" );
    });
  }
  var chart = Morris.Bar({
    // ID of the element in which to draw the chart.
    element: 'myfirstchart',
    // Set initial data (ideally you would provide an array of default data)
    data: [0,0],
    xkey: 'date',
    ykeys: ['value'],
    labels: ['Value']
  });
  // Request initial data for the past 7 days:
  requestData(7, chart);
});


</script>

@endsection
{{-- </body>
</html> --}}