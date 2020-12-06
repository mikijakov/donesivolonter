var map, infoWindow, marker;
//if ($('#pleaselogin').length) {request_location();}
request_location();
// Requesting location from user
var haveLocation = true;
function request_location()
{
  // only start location update process if browser supports it
  if (navigator.geolocation) 
  {
    setTimeout(request_location, 1000*60*30);
    navigator.geolocation.getCurrentPosition(update_location);
  }
  else {
    haveLocation = false;
  }
}

// Sending location to server via POST request
function update_location(position)
{
  $('#loader').show();
    $.ajax({
      type: "POST",
      url: "../includes/card.php",
      data: {
          "mylat": position.coords.latitude,
          "mylng": position.coords.longitude
      },
      success: function (data) {
          $('#loader').hide();
          $("#cards-stack").html(data);
      }
    });
    var pos = {
      lat: position.coords.latitude,
      lng: position.coords.longitude
    }
    localStorage.setItem('currentPosition', JSON.stringify(pos));
}

$(".card-login").click(function(){
  $('#loader').show();
    $.ajax({
        type: 'POST',
        url: '../prijavljivanje.php',
        success: function(data) {
            $('#loader').hide();
            $("#cards-stack").html(data);
            $("#pleaselogin").remove();
        }
    });
});

$(".card-register").click(function(){
  $('#loader').show();
    $.ajax({
        type: 'POST',
        url: '../registracija.php',
        success: function(data) {
            $('#loader').hide();
            $("#cards-stack").html(data);
            $("#pleaselogin").remove();
        }
    });
});

$(document).ready(function() {
  $(document).on('click', '.delete_delivery', function(){
    let buttonID = this.id;
    $('#staticBackdrop').modal('hide');
        $.ajax({
            type: 'POST',
            url: '../includes/enddelivery.php',
            data: {
              "delete": true,
              "brt": true,
              "id": buttonID
            },
            success: function(data) {
                $("#cards-stack").html(data);
            }
      });
  });
});

$(document).ready(function() {
  $(document).on('click', '.success_delivery', function(){
    let buttonID = this.id;
    $('#staticBackdrop').modal('hide');
        $.ajax({
            type: 'POST',
            url: '../includes/enddelivery.php',
            data: {
              "success": true,
              "brt": true,
              "id": buttonID
            },
            success: function(data) {
                $("#cards-stack").html(data);
            }
      });
  });
});

$(document).ready(function() {
  $(document).on('click', '.unsuccessful_delivery', function(){
    let buttonID = this.id;
    $('#staticBackdrop').modal('hide');
        $.ajax({
            type: 'POST',
            url: '../includes/enddelivery.php',
            data: {
              "unsuccessful": true,
              "brt": true,
              "id": buttonID
            },
            success: function(data) {
                $("#cards-stack").html(data);
            }
      });
  });
});

$(document).ready(function() {
  $(document).on('click', '.end_delivery', function(){
    let buttonID = this.id;
        $.ajax({
            type: 'POST',
            url: '../includes/enddelivery.php',
            data: {
              "end": true,
              "brt": true,
              "id": buttonID
            },
            success: function(data) {
                $("#cards-stack").html(data);
            }
      });
  });
});
$(document).ready(function() {
  $(document).on('click', '.show_map', function(){
    let buttonID = this.id;
    if ($(window).width() > 767) {
      $('#loader').show();
      $.ajax({
          type: 'POST',
          url: '../includes/getcoords.php',
          data: {
            "id": extractID(buttonID)
          },
          dataType: "JSON",
          success: function(data) {
              $('#loader').hide();
              if(data)
              {
                let latlng = new google.maps.LatLng(data.latitude, data.longitude);
                marker = new google.maps.Marker({
                position: latlng,
                title: "Lokacija korinika",
                map: map
                });
              }
              //marker.setMap(map);
          }
    });
    } else {
      $.ajax({
        type: 'POST',
        url: '../includes/getcoords.php',
        data: {
          "id": extractID(buttonID)
        },
        dataType: "JSON",
        success: function(data) {
            $('#loader').hide();
            if(data)
            {
              let url = "https://www.google.com/maps/dir/?api=1&destination="+data.latitude+","+data.longitude+"&travelmode=driving";
              window.open(url, '_blank');
            }
        }
      });
    }
  });
});

$(document).ready(function() {
  $(document).on('click', '.accept_delivery', function(){
    let buttonID = this.id;
    var position = JSON.parse(localStorage.getItem('currentPosition'));
    $('#loader').show();
        $.ajax({
            type: 'POST',
            url: '../includes/card.php',
            data: {
              "mylat": position.lat,
              "mylng": position.lng,
              "postID": extractID(buttonID),
              "acceptDel": true
            },
            success: function(data) {
                $('#loader').hide();
                $("#cards-stack").html(data);
            }
      });
    
  });
});

function appendCoordsForm() {
  return new Promise(function(resolve, reject) {
    if (clickedLocatedSuccessful == true) {

      var position = JSON.parse(localStorage.getItem('currentPosition'));
      
      resolve(position);
    } else {
      let inputAddress = document.getElementById("address-delivery").value;

      geocodeAddress(inputAddress).then(function (addr) {
        var position = {
          latitude: addr.lat,
          longitude: addr.lng
        };

        resolve(position);
      });
    }
  });
}

$(document).ready(function(e) {
  $(document).on('submit', '#delivery-form', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('submit-delivery', true);
    appendCoordsForm().then(function(position) {
      formData.append('lat', position.latitude);
      formData.append('lng', position.longitude);
      $.ajax({
        type: 'POST',
        url: '../includes/add-inc.php',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data) {
          $("#cards-stack").html(data);
        }
      });  
    });
      
  });
});

function extractID(clickedButton) {
  let num = parseInt(clickedButton.match(/\d+$/)[0], 10);
  return num;
}

/* $(function () {

  $('.delivery-form').on('submit', function (e) {

    //e.preventDefault();

    $.ajax({
      type: 'post',
      url: '..includes/add-inc.php',
      data: $('.delivery-form').serialize(),
      success: function () {
        alert('form was submitted');
      }
    });

  });

}); 

$(document).ready(function() {
  $("#submit-delivery").click(function(e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: 'includes/add-inc.php',
        data: $('.delivery-form').serialize(),
        success: function() {
          console.log("Signup was successful");
        },
        error: function() {
          console.log("Signup was unsuccessful");
        }
  });
  });
})*/
//Bootstrap tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


function createCookie(name, value, minutes) { 
  var expires; 
    
  if (minutes) { 
      var date = new Date(); 
      date.setTime(date.getTime() + (minutes * 60 * 1000)); 
      expires = "; expires=" + date.toGMTString(); 
  } 
  else { 
      expires = ""; 
  } 
    
  document.cookie = escape(name) + "=" +  
      escape(value) + expires + "; path=/"; 
} 

//Google maps geolocation for main page


if ($(window).width() > 767) {
  
  function initMap() {
    map = new google.maps.Map(document.getElementById('main-map'), {
      center: {lat: 44.829590, lng: 20.451046},
      zoom: 13
    });
    infoWindow = new google.maps.InfoWindow;
    let positionOptions = {
      enableHighAccuracy : true
    };
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        localStorage.setItem('currentPosition', JSON.stringify(pos));
        //searchLocationsNear(pos);
        infoWindow.setPosition(pos);
        infoWindow.setContent('Trenutna lokacija');
        infoWindow.open(map);
        map.setCenter(pos);
      }, function() {
        handleMapLocationError(true, infoWindow, map.getCenter());
      }, positionOptions);
    } else {
      // Browser doesn't support Geolocation
      handleMapLocationError(false, infoWindow, map.getCenter());
    }
  }
}

//Error handler for geolocation
function handleMapLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Greska: geolokacija nije uspela' :
                        'Greska: pretrazivac ne podrzava geolokaciju');
  infoWindow.open(map);
}

function casualLocationError(browserHasGeolocation, infoWindow) {
  infoWindow.innerHTML = browserHasGeolocation ?
                        'Greska: geolokacija nije uspela' :
                        'Greska: pretrazivac ne podrzava geolokaciju';
  infoWindow.classList.remove("hidden");
}
// Geolocation
var clickedLocatedSuccessful = false;

$(document).ready(function() {
  $(document).on('click', '#locateme', function() {
    var errorWindow = document.getElementById("locationerror");

    if (navigator.geolocation) {
      let positionOptions = {
        enableHighAccuracy : true
      };

      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        errorWindow.classList.remove("alert-danger");
        errorWindow.classList.add("alert-success");
        errorWindow.innerHTML = "Uspešno ste locirani!";
        errorWindow.classList.remove("hidden");

        let accuracy = position.coords.accuracy;
        if (accuracy < 200) {
          let geocoder = new google.maps.Geocoder();
          var addrInput = document.getElementById("address-delivery");
          geocodeLatLng(geocoder, pos, errorWindow, addrInput);

          localStorage.setItem('currentPosition', JSON.stringify(pos));

          clickedLocatedSuccessful = true;
        } else {
          errorWindow.classList.add("alert-danger");
          errorWindow.classList.remove("alert-success");
          errorWindow.innerHTML = "Nađena lokacija nije dovoljno precizna, molimo Vas unesite ručno adresu."
        }
        
      }, function() {
        casualLocationError(true, errorWindow);
      }, positionOptions);
    } else {
      // Browser doesn't support Geolocation
      casualLocationError(false, errorWindow);
    }
  });
});

const geocodeAddress = address => {
  return new Promise((resolve, reject) => {
      const geocoder = new google.maps.Geocoder();
      geocoder.geocode({address: address}, (results, status) => {
          if (status === 'OK') {
              let obj = {
                lat: results[0].geometry.location.lat(),
                lng: results[0].geometry.location.lng()
              };
              resolve(obj);
          } else {
              reject(status);
          }    
      });    
  });
};

function geocodeLatLng(geocoder, latlng, errorWindow, input) {
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === 'OK') {
      if (results[0]) {
        input.setAttribute("value", results[0].formatted_address);
      } else {
        errorWindow.classList.add("alert-danger");
        errorWindow.classList.remove("alert-success");
        errorWindow.innerHTML = 'Nije nađena adresa, koristite ručni unos da napišete adresu stanovanja';
        return null;
      }
    } else {
      errorWindow.classList.add("alert-danger");
      errorWindow.classList.remove("alert-success");
      errorWindow.innerHTML = 'Žao nam je nismo uspeli da nađemo adresu greška: ' + status;
      return null;
    }
  });
}

/* $("#delivery-form").submit(function(){
  if (clickedLocatedSuccessful !== true) {
    let inputAddress = document.getElementById("address-delivery").value;

    //var check = false;

    geocodeAddress(inputAddress).then(function (addr) {
      createCookie("lat", addr.lat, 0);
      createCookie("lng", addr.lng, 0);
      //check = true;
      return true;
    });

  } else {
    return true;
  }
}); */

function downloadUrl(url,callback) {
  var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;
 
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request.responseText, request.status);
    }
  };
 
  request.open('GET', url, true);
  request.send(null);
 }

 function searchLocationsNear(center) {
  //clearLocations();

  var searchUrl = '../includes/getmarker.php?lat=' + center.lat() + '&lng=' + center.lng();
  downloadUrl(searchUrl, function(data) {
  var xml = parseXml(data);
  var markerNodes = xml.documentElement.getElementsByTagName("marker");
  var bounds = new google.maps.LatLngBounds();

  for (var i = 0; i < markerNodes.length; i++) {
    var id = markerNodes[i].getAttribute("id");
    var latlng = new google.maps.LatLng(
        parseFloat(markerNodes[i].getAttribute("lat")),
        parseFloat(markerNodes[i].getAttribute("lng")));

    createMarker(latlng);
    bounds.extend(latlng);
  }
  map.fitBounds(bounds);
 });
}

function createMarker(latlng) {
  var marker = new google.maps.Marker({
    map: map,
    position: latlng
  });
  markers.push(marker);
}

function clearLocations() {
  infoWindow.close();
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }
  markers.length = 0;
}

