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
firebase.database().ref().on('value', function(snapshot) {
    var values = snapshot.val();
    var dem = 10;


    $.each(values, function(index, value) {


        $.each(value, function(index1, value1) {

            // if (value1.broken == 'false') {
            //     dem++;
            // }
            console.log('file js');


        });

    });

    $('#info').append(dem);
});