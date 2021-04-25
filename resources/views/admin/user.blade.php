@extends('admin.layout')
@section('content')

    <div class="container">
        <div class="row">
            <table class="table table table-striped table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">user name</th>
                    <th scope="col">email</th>
                    <th> thêm người dùng vào firebase</th>
                  </tr>
                </thead>
                <tbody>
                 
                  @foreach($users as $user)
							<tr>
								<td>{{$loop->index +1}}</td>
                                <td>{{$user->name}}</td>
								<td><a href="#">{{$user->userName}}</a> </td>		
                                <td>{{$user->email}}</td>

									
								<td>
                                    <button class="btn btn-primary add-user" onclick="add({{$user->id}})">add</button>
                                    {{-- <button class="btn btn-primary" href=>xem</button> --}}
                                    <a class="btn btn-primary" href="/admin/lightsUser/{{$user->id}}">xem</a>

                                     
								</td>
							  </tr>
								
					@endforeach
                </tbody>
              </table>
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
  
  
  // Get Data
  firebase.database().ref().on('value', function(snapshot) {
  

    var values = snapshot.val();
    var dem=0;
    
    $.each(values, function(index, value) {
        if(value!=null){          
            $('button.add-user').eq(--index).hide();
            console.log(index);

        }
        else{
            $('button.add-user').eq(--index).show();
            console.log(index+"jjjjjjjj");
        }
        



        $.each(value, function(index1, val){
            $.each(val, function(index2, valu){

                if(valu.broken=='true')//là bị hư
                {
                    dem++;
                }
            });
        });
    });
   
    console.log(dem+"ffffff" +$('#info.badge').text());
    $('#info.badge').empty();
    $('#info.badge').append(dem);
  });





function add(idUser){

    $.ajax({
        type: 'GET',
        url: '/admin/addHome',
        data: {
            route: 0,           
            location: 'locationA',
            idUser:idUser,
        },
        success: function(data) {
            console.log(data);

        }
    });

}
</script>
    
@endsection