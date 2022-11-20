function getLatLngByZipcode(zipcode) {
    var geocoder = new google.maps.Geocoder();
    var address = zipcode;
    var latitude, longitude;

    geocoder.geocode({ 'address': address }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            latitude = results[0].geometry.location.lat();
            longitude = results[0].geometry.location.lng();
        } else {
            alert("Request failed.")
        }
    });
    return [latitude, longitude];
}