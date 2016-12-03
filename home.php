<?php require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"])) {
    Helper::redirect("index.php");
}
$username = $_SESSION["username"];
if (isset($_POST["newBuild"])) {
    $url = "http://localhost:9999/users/{$username}/builds/new";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    if ($response->status == 200) {
        Helper::redirect("build.php?user={$username}&id=".$response->body);
    }
}

include ('header.php');
?>
    <h2 style="text-align: center">Create Your Build Now!</h2>
    <br>
    <div class="formholder" style="width: 50%; display:block; margin: auto;">
        <div class="randompad">
            <form action="" method="post" accept-charset="utf-8">
                <input type="text" name="name" value="" placeholder="build name">
                <input type="submit" name="newBuild" value="Create Build">
            </form>
        </div>
    </div>

<?php include('footer.php') ?>
