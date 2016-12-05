<?php 
require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET["search"])) {
    $getUrl = "http://localhost:9999/parts?q={$_GET["query"]}&type={$_GET["type"]}";
} else {
    $getUrl = "http://localhost:9999/parts?q=&type=0";
}
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 0;
}
$getUrl = $getUrl . "&page={$page}";

$response = Helper::requestGet($getUrl);
$response = json_decode($response);
if ($response->status == 200) {
    $parts = $response->body;
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
        Helper::redirect("build.php?user={$_SESSION["username"]}&id=".$build);
    }
}

include('header.php'); ?>

 <?php if (isset($_GET["build"])) {
            echo "<a href='build.php?user={$_SESSION["username"]}&id={$build}'>Back to Build</a>";
        } ?>
        <div class="formholder randompad" style="width: 100%;">
            <form action="" method="get" accept-charset="utf-8" >
                <?php if (isset($_GET["build"])) {
                echo "<input type='hidden' name='build' value={$build}>";
                } ?>
                <input type="text" name="query" value="<?php if (isset($_GET["query"])) {echo $_GET["query"];} ?>" placeholder="Search..." style="width: calc(100% - 230px); display: inline;">
                <select name="type" style="width: 200px; display: inline; margin: 10px;">
                    <option value="0">All</option>
                    <?php foreach ($types as $type) {
                        echo "<option value='{$type->id}'>{$type->name}</option>";
                    } ?>
                </select>
                <input type='submit' name='search' value='Search'>
            </form>
        </div>
        <br>
        <?php 
        if (count($parts) == 0){
            echo "<h3>0 results</h3>";
        }

        foreach ($parts as $part) { ?>

        <div class="parts" style="display:flex; margin-bottom: 15px;">
            <div class="partsleft">
                <img src="<?php

                    $typename = $part->type->name;
                switch (true) {
                    case stristr($typename,"fan"):
                    case stristr($typename, "cooler"):
                        echo "images/cooler.png";
                        break;
                    case stristr($typename, "hdd"):
                        echo "images/disk.png";
                        break;
                    case stristr($typename, "mb "):
                        echo "images/motherboard.png";
                        break;
                    case stristr($typename,"vga"):
                        echo "images/case.png";
                        break;
                    case stristr($typename,"casing"):
                        echo "images/video.png";
                        break;
                    case stristr($typename,"mse"):
                        echo "images/mouse.png";
                        break;
                    case stristr($typename,"cpu"):
                        echo "images/cpu.png";
                        break;
                    case stristr($typename,"speaker"):
                    case stristr($typename,"headset"):
                        echo "images/speaker.png";
                        break;
                    default:
                        echo "images/power.png";
                }
                ?>">

                <div style="clear:both;"></div>
            </div>

            <div class="partsright">
                <div>
                <h2 style="float:left;"><?php echo $part->name ?></h2>
                <p style="float:right; font-style: italic; color: #8EAE8D;"><?php echo $part->price ?></p>
                </div>
                <div style="clear:both;"></div>
                <?php echo $part->description ?>

                <?php
                if (isset($_GET["build"])) {
                    if (!in_array($part->id, $pids)) { ?>
                        <form action='' method='post' accept-charset='utf-8'>
                            <input type='hidden' name='part_id' value='<?php echo $part->id ?>'>
                            <input type='submit' name='addPart' value='Add' class='green-sea-flat-button'>
                        </form>
                        </p>
                        <?php
                }} ?>
            </div>
        </div>
        <div style="clear:left;"></div>
        <?php } ?>

        <?php if (count($parts) == 25) { ?>
        <a href="browseParts.php?<?php if (isset($_GET["search"])) {
            echo "query={$_GET["query"]}&type={$_GET["type"]}&search={$_GET["search"]}&";
        }
        $page = 0;
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }
        $page+=1;
        echo "page={$page}";
        ?>">Next Page</a>
        <?php } ?>
<?php include('footer.php') ?>
