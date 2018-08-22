<?php
    session_start();
    if(isset($_SESSION["username"]))
    {
		session_unset();
        session_destroy();
        header('Location:' .'http://' . $_SERVER["HTTP_HOST"]);
    }
    else
    {
        header('Location:' .'http://' . $_SERVER["HTTP_HOST"]);
    }

?>
