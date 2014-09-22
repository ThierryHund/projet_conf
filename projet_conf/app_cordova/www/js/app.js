// document.addEventListener('deviceready', function(){

// //Ici code au lancement de l'appli

// }, false);


var app = angular.module('app', ['google-maps']);

// app.config(function($routeProvider){
// 	$routeProvider
// 		.when('/home', {templateUrl: 'home.html'})
// 		.when('/about', {templateUrl: 'about.html'})
// 		.when('/contact', {templateUrl: 'contact.html'})
// 		.otherwhise((redirectTo: '/home'))

// });

app.controller ('Maps', function($scope){


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
        message: 'Universite de Lorraine, Ile du Saulcy, Metz'
	}


}

});

