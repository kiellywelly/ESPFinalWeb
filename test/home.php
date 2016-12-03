<?php session_start();
require_once 'Helper.php';
if (isset($_POST["newBuild"])) {
    $url = "http://localhost:9999/users/".$_SESSION["username"]."/builds/new";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    if ($response->status == 200) {
        Helper::redirect("build.php?id=".$response->body);
    }
}
// ALL BUILDS
$url = "http://localhost:9999/builds";
$response = Helper::requestGet($url);
$response = json_decode($response);
if ($response->status == 200) {
    $builds = $response->body;
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
        <span>User: <?php echo $_SESSION["username"]; ?></span>
        <a href="profile.php">Profile</a>
        <a href="index.php?logout=true">Logout</a>
        <hr>
        <form action="" method="post" accept-charset="utf-8">
            <input type="text" name="name" value="" placeholder="build name">
            <input type="submit" name="newBuild" value="Create Build">
        </form>
        browse all builds
        <div class="builds">
            <?php
            foreach ($builds as $build) {
                echo "<a class='link' href='build.php"
                ."?id={$build->id}'>{$build->name} | {$build->username}</a><br>";
            }
            ?>
        </div>
        <br>
        browse parts
    </div>
</body>
</html>