<?php 
require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$getUrl = "http://localhost:9999/users/{$_GET["user"]}/builds/". $_GET["id"];
$response = Helper::requestGet($getUrl);
$response = json_decode($response);
if ($response->status == 200) {
    $build = $response->body;
    $parts = $build->bParts;
}
$isCurrent = false;
if (isset($_SESSION["username"])) {
    $isCurrent = $_SESSION["username"] == $build->username;
}
if ($isCurrent) {
    if (isset($_POST["removePart"])) {
        $url = $getUrl."/removePart";

    } elseif (isset($_POST["editBuild"])) {
        $url = $getUrl."/edit";
    } else {
        $url = $getUrl;
    }
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    if ($response->status == 200) {
        Helper::redirect("build.php?user={$build->username}&id=".$_GET["id"]);
    }
}


 include('header.php') ?>
<?php if ($isCurrent) { ?>
<form action='' method='post' accept-charset='utf-8'>
    <input class="title" type="text" name="name" value="<?php echo $build->name ?>" placeholder="name">
    <input type='submit' name='editBuild' value='Edit Name'>
</form>
<?php } else { echo "<h2>{$build->name}</h2>";
echo "<p>Built by: <a class='link' href='profile.php?u={$build->username}'>{$build->username}</a></p>"; } ?>
<?php if (count($parts) > 0) { ?>
    <br>
    <p>Parts</p>
    <?php foreach ($parts as $part) { ?>
        <?php $part = $part->part; ?>
        <div class="parts" style="display:flex;">
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
                <p><?php echo $part->description ?></p>

                <?php if ($isCurrent) { ?>
                    <form action='' method='post' accept-charset='utf-8'>
                        <input type='hidden' name='part_id' value='<?php echo $part->id ?>'>
                        <input type='submit' name='removePart' value='Remove' class='green-sea-flat-button'>
                    </form>
                <?php } ?>
            </div>
        </div>
        <div style="clear:left;"></div>
    <?php } ?>
<?php } ?>

<?php
if ($isCurrent) { ?>
    <a href="browseParts.php?build=<?php echo $_GET["id"] ?>">Browse Parts</a>
<?php
} ?>


<?php include('footer.php') ?>