<?php 
require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET["user"])){
$getUrl = "http://localhost:9999/users/{$_GET["user"]}/builds/". $_GET["id"];
} else {
    $getUrl = "http://localhost:9999/users/{$_SESSION["username"]}/builds/". $_GET["id"];
}
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
$text="";
if (isset($_POST["textBuild"])) {
    $url = $getUrl."/sendText";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    if ($response->status == 200) {
        $text = "Sent";
    } else {
        $text = "Failed";
    }
    alert($text);
}


 include('header.php');

  ?>
<script type="text/javascript"> 

function showDiv() {
   document.getElementById('editName').style.display = "block";
    document.getElementById("buildNameDisplay").style.display="none";
    }
</script>


<?php if ($isCurrent) { ?>
<h2 id="buildNameDisplay" style="visibility: visible; display: inline;">
<img src="images/edit.png" onclick="showDiv()" class="editIcon" />
<?php echo $build->name ?></h2>
<div class="formholder randompad" id="editName" style="display: none; width: 100%">
    <form action='' method='post' accept-charset='utf-8' style="width: 100%;">
        <input type="text" name="name" value="<?php echo $build->name ?>" placeholder="name" style="width: calc(100% - 235px); display: inline; padding: 10px 5px; margin: 0px 5px;">
        <input type='submit' name='editBuild' value='Edit Name' style="display: inline; width: 200px; margin: 0px 10px;">
    </form>
</div>
<?php } else { echo "<h2>{$build->name}</h2>";
echo "<p>Built by: <a class='link' href='profile.php?u={$build->username}'>{$build->username}</a></p>"; } ?>
<br>

<?php if (count($parts) > 0) { ?>
    <br>
    <h3>Parts</h3>
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
<?php } else  { ?>


<h3>There are currently no added parts.</h2>

 <?php   } ?>
<div style="margin-top:30px; float: right;"
<?php
if ($isCurrent) { ?>
    <a href="browseParts.php?build=<?php echo $_GET["id"] ?>">
         <input type='submit' name='addPartsBtn' value='Add Parts' class='green-sea-flat-button' style="display: inline;">
    </a>
<?php
} ?>

<form action='' method='post' accept-charset='utf-8' style="display: inline;">
    <input type='submit' name='textBuild' value='Send to Phone' class='green-sea-flat-button'>
</form>
</div>
<div style="clear:both;"></div>

<?php include('footer.php') ?>