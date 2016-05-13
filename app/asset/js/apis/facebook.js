
window.fbAsyncInit = function() {
    FB.init({
        appId : '457031654471045',
        xfbml : true,
        version : 'v2.3'
    });
    //shareFb();
};

function shareFb(){
FB.ui({
          method: 'feed',
          link: "The link you want to share", 
          picture: 'The picture url',
          name: "The name who will be displayed on the post",
          description: "The description who will be displayed"
        }, function(response){
            console.log(response);
        }
    );
}

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/sk_SK/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// This is called with the results from from FB.getLoginStatus().		    
function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
			// The response object is returned with a status field that lets the
			// app know the current login status of the person.
			// Full docs on the response object can be found in the documentation
			// for FB.getLoginStatus().
    if (response.status === 'connected') {
	// Logged into your app and Facebook.
	testAPI();
    } else if (response.status === 'not_authorized') {
	// The person is logged into Facebook, but not your app.
	document.getElementById('status').innerHTML = 'Please log ' +
	    'into this app.';
    } else {
	// The person is not logged into Facebook, so we're not sure if
	// they are logged into this app or not.
	document.getElementById('status').innerHTML = 'Please log ' +
	    'into Facebook.';
    }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
}

// Load the SDK asynchronously
/*(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/sk_SK/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));*/

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
    FB.api('/me', function(response) {
	var user = {
	    toRegister:{
		'email' : response.email,
		'meno' : response.first_name,
		'priez' : response.last_name,
		'type' : 'facebookRegister',
		'prihlasenie' : 2
	    }
	};
	$.ajax({
	    //type: "POST",
	    url: "registerUser",//"php/cez_ajax/asynch_register_user.php",
	    data: user,
	    success: function(data){
		if(data.length === 0){
		    $('body').append('<form method="post" class="fbform">'+
					'<input name="usr_txt_n" value="'+response.email+'" />'+
					'<input name="source" value="facebook"/>'+
				     '</form>');
		    $('.fbform').submit();
		}
	    }
	});
    });
}