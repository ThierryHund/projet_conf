$(document).ready(function(){

  initialize();
  var lat, lng, titre_event ;
  var map_;
  var marker;
  var coords = new google.maps.LatLng(49,6) ;



  function initialize(){


     $.get( "http://localhost/webprojet/projet_conf/projet_conf/server/controler.php",'getPosition',function( data ) {
        
          var response = eval(data);

          coords = new google.maps.LatLng(response.latitude, response.longitude); 


          map_ = document.getElementById('map');

           /* Déclaration des options de la map */
          options = {
            zoom: 10,
            center: coords,
            // disableDefaultUI: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          }

         map = new google.maps.Map(map_, options);
          /* Chargement de la carte centrée sur la ville souhaitée
           avec un zoom de 10 et un type ROADMAP */


          /* Création du marker */
          marker = new google.maps.Marker({
            position: coords,
            map: map,
            animation: google.maps.Animation.DROP,

            /* désactive le fait de pouvoir faire glisser la carte en maintenant le clic sur elle */
            draggable:true

          });

          
          /* affichage info-bulle */
          var infoWindow = new google.maps.InfoWindow({
            content  : '<p style="text-align: center">' + response.titre_evnt + '<br/>' + response.adresse + '</p>',
            position : coords
          });


          google.maps.event.addListener(marker, 'click', function() {
              // map.setZoom(15);
              // map.setCenter(marker.getPosition());
              toggleBounce();
              infoWindow.open(map,marker);

          });
          
     },"json");

   } 


  /* fonction qui anime le marker */
  function toggleBounce() {

    if (marker.getAnimation() != null) {
      marker.setAnimation(null);
    } else {
      marker.setAnimation(google.maps.Animation.BOUNCE);
    }
  }

  google.maps.event.addDomListener(window, 'load', initialize);


});