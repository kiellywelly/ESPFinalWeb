<?php session_start();
require_once 'Helper.php';
$isCurrent = true;
$username = $_SESSION["username"];
if (isset($_GET["u"])) {
    if ($_SESSION["username"] == $_GET["u"]) {
        Helper::redirect("http://localhost:8000/profile.php");
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
            Helper::redirect("http://localhost:8000/profile.php");
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <div class="container">
        <span>User: <?php echo $username; ?></span>
        <br>
        Builds:
        <div class="builds">
            <?php
            foreach ($user->builds as $build) {
                echo "<a class='link' href='build.php"
                ."?id={$build->id}'>{$build->name}</a> | ";
                if ($isCurrent) {
            ?>
                <form class="delete" action='' method='post' accept-charset='utf-8'>
                    <input type="hidden" name="id" value="<?php echo $build->id ?>">
                    <input type='submit' name='deleteBuild' value='Delete'>
                </form>
             <?php } echo "<br>"; } ?>
        </div>
        <br>
    </div>
</body>
</html>