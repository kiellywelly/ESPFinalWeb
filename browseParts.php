<?php session_start();
require_once 'Helper.php';
$getUrl = "http://localhost:9999/parts";
$response = Helper::requestGet($getUrl);
$response = json_decode($response);
if ($response->status == 200) {
    $parts = $response->body;

}
if (isset($_GET["build"])) {
    $build = $_GET["build"];
}
if (isset($_POST["addPart"])) {
    $url = "http://localhost:9999/users/".$_SESSION["username"]."/builds/".$build."/addPart";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    if ($response->status == 200) {
        Helper::redirect("http://localhost/build.php?id=".$_GET["id"]);
    }
}
?>



<?php include('header.php') ?>

<a href="build.php?id=<?php echo $build; ?>">Back to Build</a>
        
            <?php foreach ($parts as $part) {
                echo "
        <div class='parts'>
        <div class='partsleft'> 
                <img src='".$part->imagePath."'> </div>";

                echo "<div class='partsright'>
                <h2>".$part->name."</h2>";

                echo $part->description;

                echo "<p style='margin-top:20px'>";
                echo "<form action='' method='post' accept-charset='utf-8'>
                    <input type='hidden' name='part_id' value='{$part->id}'>
                    <input type='submit' name='addPart' value='Add' class='green-sea-flat-button'>
                </form>
                </p>";
                echo "</p></div></div>";
            } ?>
        </div>

<?php include('footer.php') ?>