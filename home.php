
<?php include('header.php') ?>
<?php 
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
?>
        
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

  <?php include('footer.php') ?>
