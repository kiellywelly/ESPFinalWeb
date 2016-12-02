<?php 
require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isCurrent = true;
$username = $_SESSION["username"];
if (isset($_GET["u"])) {
    if ($_SESSION["username"] == $_GET["u"]) {
        Helper::redirect("http://localhost/pcparts/profile.php");
    }
    $isCurrent = false;
    $username = $_GET["u"];
}
$getUrl = "http://localhost:9999/users/{$username}";
$response = Helper::requestGet($getUrl);
$response = json_decode($response);
if ($response->status == 200) {
    $user = $response->body;
}

if ($isCurrent) {
    if (isset($_POST["deleteBuild"])) {
        $url = $getUrl."/builds/{$_POST["id"]}/delete";
        $response = Helper::requestPost($url, $_POST);
        $response = json_decode($response);
        if ($response->status == 200) {
            Helper::redirect("http://localhost/pcparts/profile.php");
        }
    }
}


include('header.php'); ?>


        <h3>User: <?php echo $username; ?></h3>
        <br>
        <div class="builds">
            <?php 
                echo "Email address: " . $user->email ."<br>";
                echo "Account Created at: " . $user->created ."<br>";
                $numBuilds = count($user->builds);
                echo "<a href='mybuilds.php'>Number of Builds: " . $numBuilds . "</a><br>";
                ?>
            
<?php include('footer.php') ?>