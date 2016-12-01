
 <?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Helper.php';
require_once 'functions.php';
   

?>
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


<nav>
  <!-- <div class="nav-wrapper"> -->

    <div class="navleft">
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="#">Parts</a></li>
        <li><a href="#">Builds</a></li>

    </ul>
    </div> 
    <!-- End of navleft -->

    <div class="navright">

     <ul>
        
<?php if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) { ?>


        <li><a href="#"> <div id="wrap">
             <div id="regbar" style="clear:both;">
               <div id="navthing">
                 <a href="#" id="loginform">Login</a>
                 <div class="login">
                   <div class="arrow-up"></div>
                   <div class="formholder">
                     <div class="randompad">
                       
                       <form action="" method="post" accept-charset="utf-8">
                          <input type="text" name="username_or_email" value="" placeholder="username or email">
                          <input type="password" name="password" value="" placeholder="password">
                          <input type="submit" name="login" value="Login">
                      </form>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
          </div>
          </a></li>

 <?php } else {?>
      <li><a href="profile.php">User: <?php echo $_SESSION["username"]; ?></a></li>
      <li><a href="index.php?logout=true">Logout</a></li>
<?php } ?>
      </ul>
    </div>
    </nav>
    <!-- End of navright -->


    <!-- </div> -->
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