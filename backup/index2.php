<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<title>HTML5, CSS3 and JavaScript demo</title>
  <link href="http://fonts.googleapis.com/css?family=Ubuntu:300,400,700,400italic" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Oswald:400,300,700" rel="stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="css/style.css"/>
</head>
<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '776280359192760',
      xfbml      : true,
      version    : 'v2.8'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Start your code here -->
 <header>
    <div id="title" class="content">
        <h1>PC Parts Philippines</h1>
        <h2>Sobrang lapit na tayo matapos fam. Konting push na lang.</h2>
    </div>
</header>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<? php

//next example will insert new conversation
$service_url = 'http://localhost:9999/login';
$curl = curl_init($service_url);
$curl_post_data = array(
        'username_or_email' => 'dwarren0@unc.edu',
        'password' => 'N1QsCK7TKB7G'
);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}
echo 'response ok!';
var_export($decoded->response);


?>
<nav>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Parts</a></li>
        <li><a href="#">Builds</a></li>
        <li><a href="#"> <div id="wrap">
             <div id="regbar">
               <div id="navthing">
                 <a href="#" id="loginform">Login</a>
                 <div class="login">
                   <div class="arrow-up"></div>
                   <div class="formholder">
                     <div class="randompad">
                       <form class="form" method="post" action="http://localhost:3306/login">

                         <!-- <input type="submit" value="Login with Facebook"> -->
                         <label name="email" id="email">Email</label>
                         <input type="email" value="dwarren0@unc.edu" />
                         <label name="password" id="password">Password</label>
                         <input type="password" />
                         <input type="submit" name="login" id="login" value="Login" />
                       </form>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
          </div>
          </a></li>
    </ul>
</nav>
  <div id="main">
    <div class="content">
<script>
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

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '776280359192760',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.8' // use graph api version 2.8
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Facebook id: ' + response.id + "<br> Facebook name: " + response.name + " email: " + response.email;
    });
  }
</script>
<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>


      <div class="parts">
        <div class="partsleft">
        <img src="https://cdn.pcpartpicker.com/static/forever/images/product/614a9c530cce56d1fafbc5ba97920ab1.256p.jpg"/>
        </div>
        <? php
$service_url = 'http://localhost:9999/login';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}
echo 'response ok!';
var_export($decoded->response);


?>
        <div class="partsright">
          <h2>Intel iCore i7</h2>
          
          This is a description of how amazing I am. Cause diz iz d shit.
          This is a description of how amazing I am. Cause diz iz d shit.
          This is a description of how amazing I am. Cause diz iz d shit.
          This is a description of how amazing I am. Cause diz iz d shit.
          This is a description of how amazing I am. Cause diz iz d shit.
          This is a description of how amazing I am. Cause diz iz d shit.
          This is a description of how amazing I am. Cause diz iz d shit.
          <p style="margin-top:20px;">
            <input type="submit" value="Add to Cart" class="green-sea-flat-button">
            <input type="submit" value="Share" class="green-sea-flat-button">
          </p>
        </div>
       
        <!-- <p style="clear:both; position: relative;">Hey</p> -->
      
      </div>
      
      <div class="formholder" style="width: 50%; display:block; margin: auto;">
                     <div class="randompad">
                       <fieldset>
                         <label name="fullname">Full Name</label>
                         <input type="text"/>
                         <label name="username">Username</label>
                         <input type="text"/>
                         <label name="email">Email</label>
                         <input type="email" value="example@example.com" />
                         <label name="password">Password</label>
                         <input type="password" />
                         <!--<input type="submit" value="Register" />!-->

                       </fieldset>
                     </div>
                   </div>
    </div>
</div>
<!-- End your code here -->
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>