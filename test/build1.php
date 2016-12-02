<?php session_start();
require_once 'Helper.php';
$getUrl = "http://localhost:9999/users/{$_SESSION["username"]}/builds/{$_GET["id"]}";
$response = Helper::requestGet($getUrl);
$response = json_decode($response);
if ($response->status == 200) {
    $build = $response->body;

}
$isCurrent = $_SESSION["username"] == $build->username;
if ($isCurrent) {
    if (isset($_POST["removePart"])) {
        $url = $getUrl."/removePart";

    } elseif (isset($_POST["editBuild"])) {
        $url = $getUrl."/edit";
        $response = Helper::requestPost($url, $_POST);
        $response = json_decode($response);
        if ($response->status == 200) {
            Helper::redirect("http://localhost:8000/build.php?id=".$_GET["id"]);
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Build</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <div class="container">
        <?php if ($isCurrent) { ?>
            <form action='' method='post' accept-charset='utf-8'>
                <input class="title" type="text" name="name" value="<?php echo $build->name ?>" placeholder="name">
                <input type='submit' name='editBuild' value='Edit Name'>
            </form>
        <?php } else { echo "<h2>{$build->name}</h2>";
            echo "<p>Built by: <a class='link' href='profile.php?u={$build->username}'>{$build->username}</a></p>"; } ?>

        <?php foreach ($parts as $part) {
            echo "<p>{$part->name} | ";
            if ($isCurrent) {
                echo "<form action='' method='post' accept-charset='utf-8'>
                    <input type='submit' name='removePart' value='Remove'>
                </form>
                </p>";
            }
            
        } ?>
        
        <?php if ($isCurrent) { ?>
        <a href="browseParts.php?build=<?php echo $_GET["id"]?>">Browse Parts</a>
        <?php } ?>
    </div>
</body>
</html>