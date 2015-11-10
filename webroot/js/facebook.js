  window.fbAsyncInit = function() {
    FB.init({
      appId      : '939240762821535',
      xfbml      : true,
      version    : 'v2.5',
      oauth      : true
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/fr_FR/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

jQuery(function($){   
   $('.facebookConnect').click(function(){
       var url = $(this).attr('href');
       FB.login(function(response) {
           
         if (response.authResponse) {
             window.location = url;
           } else {
            console.log('L\'utilisateur n\'a pas accepté ');
           }
           console.log(response);
       }, {scope: 'email'});
       return false;
    });
    
}); 


//FB.login(function(response) {
//    if (response.authResponse) {
//     console.log('Welcome!  Fetching your information.... ');
//     FB.api('/me', function(response) {
//       console.log('Good to see you, ' + response.name + '.');
//     });
//    } else {
//     console.log('User cancelled login or did not fully authorize.');
//    }
//});
//});