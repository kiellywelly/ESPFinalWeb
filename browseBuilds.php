

<?php require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_POST["newBuild"])) {
    $url = "http://localhost:9999/users/".$_SESSION["username"]."/builds/new";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    if ($response->status == 200) {
        Helper::redirect("build.php?id=".$response->body);
    }
}
// ALL BUILDS
$page = 0;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
}
$url = "http://localhost:9999/builds?page={$page}";
$response = Helper::requestGet($url);
$response = json_decode($response);
if ($response->status == 200) {
    $builds = $response->body;
}

include ('header.php');
?>
        <?php if (isset($_SESSION["username"])) {
            echo "<form action='' method='post' accept-charset='utf-8' class='formholder' style='width: 100%;'>
                <input type='text' name='name' value='' placeholder='Name' style='width: calc(100% - 235px); padding: 10px 5px; margin: 10px 10px; display: inline;'>
                <input type='submit' name='newBuild' value='Create Build' style='display: inline; width: 200px; margin-right: 10px;'>
            </form><br>";
        } ?>

        <h3>Browse all builds</h3>
        <div class="builds">
            <?php
            foreach ($builds as $build) {
                echo "
                <div class='parts'>";

                echo "<div class='partsright'>
                <h2>".$build->name."</h2>";
                echo $build->username;
                echo "</div>";

                echo "<p style='alignment: right; float:right;'>";
                echo "<a href='build.php?user={$build->username}&id={$build->id}'>
                    <input type='submit' value='View' class='green-sea-flat-button'>
                </a>";
                echo "</p></div>";
            }
            ?>
        </div>
        <?php if (count($builds) == 25) { ?>
        <a href="browseBuilds.php?<?php
        $page = 0;
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }
        $page+=1;
        echo "page={$page}";
        ?>">Next Page</a>
        <?php } ?>
    </div>

  <?php include('footer.php') ?>
