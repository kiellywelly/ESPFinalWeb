<?php 
require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$isCurrent = isset($_GET["username"]);
if (isset($_GET["u"]) && isset($_SESSION["username"])) {
    $isCurrent = $_SESSION["username"] == $_GET["u"];
    if ($isCurrent) {
        Helper::redirect("profile.php");
    }
}
if (isset($_GET["u"])) {
    $username = $_GET["u"];
} else if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
}

if(isset($_SESSION["username"])){

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
            Helper::redirect("profile.php");
        }
    }
}

}

include('header.php'); 
// if (!isset($_SESSION["username"]) && !isset($_GET["username"])){
//     echo "<h3> Please login to view this page</h3>";
// } else {

?>




<h2>User: <?php echo $username; ?></h2>
<br>
<?php 
echo "Email address: " . $user->email ."<br>";
echo "Account Created at: " . $user->created ."<br>";
$numBuilds = count($user->builds);
echo "Number of Builds: " . $numBuilds . "<br>";
?>
<?php if ($numBuilds > 0) { ?>
    <h3>Builds</h3>
    <div class="builds">
        <?php
        foreach ($user->builds as $build) {
            echo "<div class='parts'>";
            echo "<div class='partsright'>
            <h2>".$build->name."</h2><br>";
            echo "</div>";

            echo "<p style='alignment: right; float:right;'>";
            echo "<a href='build.php?user={$username}&id={$build->id}'>
                <input type='submit' value='View' class='green-sea-flat-button'>
            </a>";
            echo "</p></div>";
        }
        ?>
    </div>
<?php } ?>
            
<?php include('footer.php') ?>