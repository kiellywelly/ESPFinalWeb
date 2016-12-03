<?php


if (isset($_POST["newBuild"])) {
    $url = "http://localhost:9999/users/".$_SESSION["username"]."/builds/new";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    if ($response->status == 200) {
        Helper::redirect("build.php?id=".$response->body);
	}
}

if (isset($_POST["login"])) {
    $url = "http://localhost:9999/login";
    $response = Helper::requestPost($url, $_POST);
    $response = json_decode($response);
    echo $response->body;
    if ($response->status == 200) {
        $_SESSION["username"] = $response->body;
        Helper::redirect("home.php");
    } else {
        $lError = "Invalid Credentials";
    }
} elseif (isset($_GET["logout"])) {
    // $response = Helper::requestGet("http://localhost:9999/logout");
    session_unset();
} elseif (isset($_GET["auth"])) {
    $error = "Please Log in first.";
}


?>