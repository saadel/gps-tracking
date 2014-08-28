<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>PHP/MySQL & Google Maps Example</title>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      ios: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      android: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
      }
    };

    var marker = xml.documentElement.getElementsByTagName("marker");
    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(35.7545, -5.8418),
        zoom: 7,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;
  
      downloadUrl("genxml.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("phoneNumber");
          var time = markers[i].getAttribute("LastUpdate");
          var type = markers[i].getAttribute("eventType");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("Latitude")),
              parseFloat(markers[i].getAttribute("Longitude")));
          var html = "<b>" + name + "</b> <br/>" + type + "<br/>"+ time;
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
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
    <div id="map" style="width: 700px; height: 500px"></div>
  </body>

</html>