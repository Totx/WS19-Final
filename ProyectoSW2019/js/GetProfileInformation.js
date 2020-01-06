
function onSignIn(googleUser) {
        var googleUser = gapi.auth2.getAuthInstance().currentUser.get();
        var profile = googleUser.getBasicProfile();
        /*
        console.log("ID: " + profile.getId());
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
        */

        var id_token = googleUser.getAuthResponse().id_token;
        //console.log("ID Token: " + id_token);

        $.post("../php/LogInExternal.php",
        {
          id_token : id_token
        }
      ).done(function (response) {
        alert(response);
        var local = true;
        if (local){
          URL_game = 'http://localhost/dashboard/WS19G14/ProyectoSW2019/php/Layout.php';
        } else {
          URL_game = 'https://ws19g14.000webhostapp.com/ProyectoSW2019/php/Layout.php';
        }
        window.location.replace(URL_game);
      });
}
