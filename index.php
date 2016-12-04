<?php

require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$rErrors = [];
if (isset($_POST["register"])) {
    $url = "http://localhost:9999/register";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    if ($response->status == 200) {
        $_SESSION["username"] = $_POST["username"];
        Helper::redirect("home.php");
    } else if ($response->body != null) {
        $rErrors = $response->body->errors;
    }
} 


include('header.php');


?>
      <!-- <div class="parts">
        <div class="partsleft">
        <img src="https://cdn.pcpartpicker.com/static/forever/images/product/614a9c530cce56d1fafbc5ba97920ab1.256p.jpg"/>
        </div>
        
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
       
      </div>   -->    

      <div class="errors">
        <ul>
          <?php foreach ($rErrors as $error) {
            echo "<li>{$error}</li>";
          } ?>
        </ul>
      </div>
      <div class="formholder" style="width: 50%; display:block; margin: auto;">
        <div class="randompad">
          <form action="" accept-charset="utf-8" method="post" id="registerForm">
            <input type="text" name="username" value="" placeholder="username">
            <input type="email" name="email" value="" placeholder="email">
            <input type="tel" name="phone" value="" placeholder="phone number">
            <input type="password" name="password" value="" placeholder="password">
            <input type="password" name="confirm_password" value="" placeholder="confirm password">
            <input type="submit" name="register" value="Register">
          </form>
        </div>
      </div>
  
  <?php include('footer.php') ?>