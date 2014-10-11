$(document).ready(function()
{

  geolocalise();

});

  var geocoder = new google.maps.Geocoder();
  var addr, latitude, longitude;

   /* Fonction chargée de géolocaliser l'adresse */ 
   function geolocalise(){
    /* Récupération du champ "adresse" */ 
    addr = document.getElementById('lieu_evenement').value;
    /* Tentative de géocodage */ 
    geocoder.geocode( { 'address': addr}, function(results, status) {
     /* Si géolocalisation réussie */ 
     if (status == google.maps.GeocoderStatus.OK) {
      /* Récupération des coordonnées */ 
      latitude = results[0].geometry.location.lat();
      longitude = results[0].geometry.location.lng();
      /* Insertion des coordonnées dans les input text */ 
      document.getElementById('lat').value = latitude;
      document.getElementById('lng').value = longitude;
      /* Appel AJAX pour insertion en BDD */ 
      var sendAjax = $.ajax({
       type: "POST",
       url: 'insert-in-bdd.php',
       data: 'lat='+latitude+'&lng='+longitude+'&adr='+addr,
       success: handleResponse
      });
     }

     function handleResponse(){
      $('#answer').get(0).innerHTML = sendAjax.responseText;
     }
    });

   }
