

<?php require_once 'Helper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


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

include ('header.php');
?>
        
        <hr>
        <form action="" method="post" accept-charset="utf-8">
            <input type="text" name="name" value="" placeholder="build name">
            <input type="submit" name="newBuild" value="Create Build">
        </form><br>
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



                echo "<a href='build.php?id=".$build->id."'>
                    <input type='submit' value='View' class='green-sea-flat-button'>
                </a>";
                echo "</p></div>";

            }
            ?>
        </div>
        
    </div>

  <?php include('footer.php') ?>
