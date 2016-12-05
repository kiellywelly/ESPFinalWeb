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
    if($_GET["u"]!= $_SESSION["username"]){
    $isCurrent = false;}
} else if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $isCurrent = true;
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
        foreach ($user->builds as $build) { ?>
            <div class="parts" style="float:left; margin-bottom: 15px; ">
                    <div style="float: left;">
                        <h2><?php echo $build->name ?></h2>
                            <?php echo $build->username ?>
                    </div>
                    <div style="alignment: right; float:right;">
                        <?php if ($isCurrent) { ?>

                        <form class="delete" action='' method='post' accept-charset='utf-8' style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $build->id ?>">
                            <input type='submit' name='deleteBuild' value='Delete' class='green-sea-flat-button'>
                        </form>
                        <?php } ?>
                        <a href='build.php?user=<?php echo $username; ?>&id=<?php echo $build->id;?>'>
                        <input type='submit' value='<?php if ($isCurrent) {
                            echo "Edit Build"; }
                            else { echo  "View"; } ?>' class='green-sea-flat-button' />
                        </a>

                        
                    </div>
                </div>
                <div style="clear:both;"></div>
        <?php
        }
        ?>
    </div>
<?php } else{
            echo "<h3>You have no builds. <a href='browseBuilds.php'>Create one.</a></h3>";

}?>
            
<?php include('footer.php') ?>