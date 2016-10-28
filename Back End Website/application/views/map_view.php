<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="<? echo base_url().'files/css/display_map.css' ?>">
    <title>Maps</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
    map = null;

    //<![CDATA[
    function curr_pos()
    {
        navigator.geolocation.getCurrentPosition(show_pos);

        function show_pos(pos)
        {
             var p = new google.maps.LatLng(pos.coords.latitude.toFixed(6),
                                       pos.coords.longitude.toFixed(6));

              var marker = new google.maps.Marker({
                    position: p,
                    map: map,
                    title:"Your Current Location!"
              });


             var infowindow = new google.maps.InfoWindow({
                    map: map,
                  position: p,
                  content: 'Your Current Location!'
            });
            

            map.setCenter(p);
            map.setZoom(20);
        }
    }

    function load() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(47.6145, -122.3418),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("<? echo base_url() ?>index.php/main/generating_xml", function(data) {
        var xml = data.responseXML;
        
        var markers = xml.documentElement.getElementsByTagName("point");
        for (var i = 0; i < markers.length; i++) {
          var id = markers[i].getAttribute('id');
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("long")));
          
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
          });
          bindInfoWindow(marker, map, infoWindow, '<html><head></head><body><h1><a style="text-decoration:none" href="<? echo base_url().'index.php/main/deleting_point/' ?>'+id+'">Delete</a></h1></body></html>');
        }
      });

      curr_pos();
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>

  </script>

  </head>

  <body onload="load()">
   <!-- <button onclick="curr_pos()">My Position</button>-->
    <div id="map"></div>
  </body>

</html>