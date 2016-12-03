<?php session_start();
require_once 'Helper.php';
if (isset($_GET["search"])) {
    $getUrl = "http://localhost:9999/parts?q={$_GET["query"]}&type={$_GET["type"]}";
} else {
    $getUrl = "http://localhost:9999/parts?q=&type=0";
}
$response = Helper::requestGet($getUrl);
$response = json_decode($response);
if ($response->status == 200) {
    $parts = $response->body;
    $c = count($parts);
    if ($c == 1) {
        $res = "There is 1 result.";
    } else {
        $res = "There are {$c} results.";
    }
}
// get types
$getUrl = "http://localhost:9999/types";
$response = Helper::requestGet($getUrl);
$response = json_decode($response);
if ($response->status == 200) {
    $types = $response->body;
}
//
if (isset($_GET["build"])) {
    $build = $_GET["build"];

    $getUrl = "http://localhost:9999/users/{$_SESSION["username"]}/builds/{$build}";
    $response = Helper::requestGet($getUrl);
    $response = json_decode($response);
    if ($response->status == 200) {
        $bParts = $response->body->bParts;
        $pids = [];
        foreach ($bParts as $part) {
            $pids[] = $part->part->id;
        }
    }
}
//
if (isset($_POST["addPart"])) {
    $url = "http://localhost:9999/users/{$_SESSION["username"]}/builds/{$build}/addPart";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    var_dump($response);
    if ($response->status == 200) {
        Helper::redirect("build.php?id=".$build);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Browse Parts</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <div class="container">
        <?php if (isset($_GET["build"])) {
            echo "<a href='build.php?id={$build}'>Back to Build</a>";
        } ?>
        <form action="" method="get" accept-charset="utf-8">
            <input type="hidden" name="build" value="<?php echo $build ?>">
            <input type="text" name="query" value="<?php echo $_GET["query"]; ?>" placeholder="Search...">
            <select name="type">
                <option value="0">All</option>
                <?php foreach ($types as $type) {
                    echo "<option value='{$type->id}'>{$type->name}</option>";
                } ?>
            </select>
            <input type='submit' name='search' value='Search'>
        </form>
        <h3><?php echo $res ?></h3>
        <div class="parts">
            <?php foreach ($parts as $part) {
                echo "<p>{$part->name} | Php {$part->price} | {$part->type->name} | {$part->description}";
                if (isset($_GET["build"])) {
                    if (!in_array($part->id, $pids)) {
                        echo "<form action='' method='post' accept-charset='utf-8'>
                            <input type='hidden' name='part_id' value='{$part->id}'>
                            <input type='submit' name='addPart' value='Add'>
                        </form>
                        </p>";
                    }
                }
            } ?>
        </div>
    </div>
</body>
</html>