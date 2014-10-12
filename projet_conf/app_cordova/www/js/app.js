var lat, lng, titre_event;

var app = angular.module('app', ['google-maps']);

app.controller ('Maps', function($scope,$http){

    $http.get('http://localhost/~Apple/webprojet/projet_conf/projet_conf/server/controler.php?getPosition').
      success(function(data) {

    $scope.data = data;

    lat = data.latitude;
    lng = data.longitude;
    titre_event = data.titre_evnt;
    console.log(titre_event);
   });


    $scope.map = {
        center: {
            latitude: 49.121046,
            longitude: 6.162078
        },
        zoom: 10
    };

    $scope.marker = {
        coords:{
            latitude: 49.121046,
            longitude: 6.162078,
            message: 'Journée E-Commerce METZ 2014'
        }
    }


});

