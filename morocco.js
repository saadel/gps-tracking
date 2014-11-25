var roadmap = { 
            3: [{'x' : 3, 'y' : 3, 'img' : 'http://www.glossarium-labs.com/map/zoom3.png'}],
            4: [{'x' : 7, 'y' : 6, 'img' : 'http://www.glossarium-labs.com/map/zoom4.png'}],
            5: [
                {'x' : 14, 'y' : 13, 'img' : 'http://www.glossarium-labs.com/map/zoom5_1.png'},
                {'x' : 15, 'y' : 13, 'img' : 'http://www.glossarium-labs.com/map/zoom5_2.png'}
               ],
            6: [
                {'x' : 29, 'y' : 27, 'img' : 'http://mts0.googleapis.com/vt?lyrs=m@264000000&src=apiv3&hl=fr&x=29&y=27&z=6&apistyle=s.t%3A17%7Cs.e%3Al%7Cp.v%3Aoff'},
                {'x' : 29, 'y' : 26, 'img' : 'http://www.glossarium-labs.com/map/zoom6.png'},
                {'x' : 30, 'y' : 26, 'img' : 'http://www.glossarium-labs.com/map/zoom6_1.png'}
               ],
            7:[
                {'x' : 59, 'y' : 54, 'img' : 'https://mts0.googleapis.com/vt?lyrs=m@264000000&src=apiv3&hl=fr&x=59&y=54&z=7&style=47,37%7Csmartmaps&apistyle=s.t%3A17%7Cs.e%3Al%7Cp.v%3Aoff'},
                {'x' : 59, 'y' : 55, 'img' : 'https://mts0.googleapis.com/vt?lyrs=m@264000000&src=apiv3&hl=fr&x=59&y=55&z=7&style=47,37%7Csmartmaps&apistyle=s.t%3A17%7Cs.e%3Al%7Cp.v%3Aoff'},
                {'x' : 59, 'y' : 53, 'img' : 'http://www.glossarium-labs.com/map/zoom7.png'},
                {'x' : 60, 'y' : 53, 'img' : 'http://www.glossarium-labs.com/map/zoom7_1.png'}
              ],
            8:[
                {'x' : 118, 'y' : 107, 'img' : 'http://www.glossarium-labs.com/map/zoom8.png'},
                {'x' : 119, 'y' : 107, 'img' : 'http://www.glossarium-labs.com/map/zoom8_1.png'},
                {'x' : 120, 'y' : 107, 'img' : 'http://www.glossarium-labs.com/map/zoom8_2.png'},
                {'x' : 121, 'y' : 107, 'img' : 'http://www.glossarium-labs.com/map/zoom8_3.png'},
                {'x' : 118, 'y' : 109, 'img' : 'https://mts0.googleapis.com/vt?lyrs=m@264000000&src=apiv3&hl=fr&x=118&y=109&z=8&style=47,37%7Csmartmaps&apistyle=s.t%3A17%7Cs.e%3Al%7Cp.v%3Aoff'},
                {'x' : 118, 'y' : 110, 'img' : 'https://mts0.googleapis.com/vt?lyrs=m@264000000&src=apiv3&hl=fr&x=118&y=110&z=8&style=47,37%7Csmartmaps&apistyle=s.t%3A17%7Cs.e%3Al%7Cp.v%3Aoff'}
             ],
            9:[
                {'x' : 237, 'y' : 215, 'img' : 'http://www.glossarium-labs.com/map/zoom9.png'},
                {'x' : 238, 'y' : 215, 'img' : 'http://www.glossarium-labs.com/map/zoom9_1.png'},
                {'x' : 239, 'y' : 215, 'img' : 'http://www.glossarium-labs.com/map/zoom9_2.png'},
                {'x' : 240, 'y' : 215, 'img' : 'http://www.glossarium-labs.com/map/zoom9_3.png'},
                {'x' : 241, 'y' : 215, 'img' : 'http://www.glossarium-labs.com/map/zoom9_4.png'},
                {'x' : 242, 'y' : 215, 'img' : 'http://www.glossarium-labs.com/map/zoom9_5.png'},
                {'x' : 243, 'y' : 215, 'img' : 'http://www.glossarium-labs.com/map/zoom9_6.png'},
                
             ]
         };

  imageMapType = new google.maps.ImageMapType({
      
    getTileUrl: function(coord, zoom) {

        mapType = map.getMapTypeId()
        $doIt = false;
        $img ='';
        if (typeof  roadmap[zoom] === 'undefined') { return null; }
        
        roadmap[zoom].forEach(function(elem) {
            if (elem.x == coord.x && elem.y == coord.y ) {       
                    $doIt = true; 
                    $img = elem.img; 
                    return false;
            }
        }); 
         
        if($doIt)   
            return [$img].join('');
    },
    tileSize: new google.maps.Size(256, 256)
  });

  map.overlayMapTypes.push(imageMapType); 
  