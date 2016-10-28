<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Maps</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
    poly_toggle = 0; 
    route_toggle = 0; 

    map = null; // main map
    current_pos = null; // current location object
    garbage_array = []; // garbage location array
    garbage_path = null; // object for poliline
    
    path = null;
    service = null;
    poly = null;
    


    //show route between nodes
    function show_route(element)
    {
        if(route_toggle == 0)
        {
            route_toggle = 1;
            element.innerHTML = "Hide Route";

            var latlngbounds = new google.maps.LatLngBounds();
            latlngbounds.extend(garbage_array[0]);

         

        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);
 
        //***********ROUTING****************//
 
        //Initialize the Path Array
        var path = new google.maps.MVCArray();
 
        //Initialize the Direction Service
        var service = new google.maps.DirectionsService();
 
        //Set the Path Stroke Color
        poly = new google.maps.Polyline({ map: map, strokeColor: '#4986E7' });
 
        //Loop and Draw Path Route between the Points on MAP
        for (var i = 1; i < garbage_array.length; i++) {
             if((i+1) < garbage_array.length)
             {
                var src = garbage_array[i];
                var des = garbage_array[i+1];

                path.push(src);
                poly.setPath(path);

                service.route({
                    origin: src,
                    destination: des,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                }, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                            path.push(result.routes[0].overview_path[i]);
                        }
                    }
                });

            }
            
        }
        }
        else
        {
           route_toggle = 0;
           element.innerHTML = "Show Route";

           poly.setMap(null);
        }

    }


    //drawing polyline
    function draw_line(element)
    {
        if(poly_toggle == 0)
        {
            poly_toggle = 1;

            garbage_path = new google.maps.Polyline({
            path:garbage_array,
            strokeColor:'red',
            strokeOpacity:0.8,
            strokeWeight:2
          });

          garbage_path.setMap(map);

          element.innerHTML = "Clear Polyline";
        }
        else
        {
            garbage_path.setMap(null);
            poly_toggle = 0;

            element.innerHTML = "Draw Polyline";  
        }

    }


    // current position on the map
    function curr_pos()
    {
        navigator.geolocation.getCurrentPosition(show_pos);

        function show_pos(pos)
        {
             var p = new google.maps.LatLng(pos.coords.latitude.toFixed(6),
                                       pos.coords.longitude.toFixed(6));
              current_pos = p;

              var marker = new google.maps.Marker({
                    position: p,
                    map: map,
                    title:"You are here!"
              });


             var infowindow = new google.maps.InfoWindow({
                    map: map,
                  position: p,
                  content: 'current position'
            });
            

            map.setCenter(p);
            map.setZoom(80);
        }
    }

    //loading the map
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
          console.log(markers[i].getAttribute("lat")+","+markers[i].getAttribute("long"));
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("long")));

          garbage_array.push(point);
          
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
          });
          bindInfoWindow(marker, map, infoWindow, '<html><head></head><body><h1>Garbage</h1></body></html>');
        }
      });
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
    <button onclick="curr_pos()">My Position</button>
    <button onclick="draw_line(this)">Draw poliline</button>
    <button onclick="show_route(this)">Show Route</button>
    <div id="map" style="width: 1200px; height: 500px"></div>
  </body>

</html>