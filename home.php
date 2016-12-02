

<?php require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = false;
if(isset($_SESSION["username"])){

$login = true;
    if (isset($_POST["newBuild"])) {
        $url = "http://localhost:9999/users/".$_SESSION["username"]."/builds/new";
        $response = Helper::requestPost($url, $_POST);
        $response = json_decode($response);
        if ($response->status == 200) {
            Helper::redirect("http://localhost/pcparts/build.php?id=".$response->body);
        }
    }
    // ALL BUILDS
    $url = "http://localhost:9999/builds";
    $response = Helper::requestGet($url);
    $response = json_decode($response);
    if ($response->status == 200) {
        $builds = $response->body;
    }


    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    $isCurrent = true;
    $username = $_SESSION["username"];
    if (isset($_GET["u"])) {
        if ($_SESSION["username"] == $_GET["u"]) {
            Helper::redirect("http://localhost/pcparts/mybuilds.php");
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
                Helper::redirect("http://localhost/pcparts/mybuilds.php");
            }
        }
    }
} else {
    Helper::redirect("http://localhost/pcparts/index.php");
}

include ('header.php');
?>
        
        <hr>
        <form action="" method="post" accept-charset="utf-8">
            <input type="text" name="name" value="" placeholder="build name">
            <input type="submit" name="newBuild" value="Create Build">
        </form><br>
        <h3>My Builds</h3>

        <div class="builds">
            <?php 

            foreach ($user->builds as $build) { ?>
            <div class="parts" style="float:left">
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
                        <a href='build.php?id=<?php echo $build->id ?>'>
                        <input type='submit' value='Edit Build' class='green-sea-flat-button' />
                        </a>

                        
                    </div>
                </div>
                <div style="clear:both;"></div>

                <?php } ?>

    </div>

  <?php include('footer.php') ?>
