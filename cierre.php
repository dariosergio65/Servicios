<?php
    session_start();

    if (ini_get("session.use_cookies")) {//elimina la cookie de session lado cliente
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    session_destroy(); //elimina la session lado servidor
    header("location: index.php");
    die();
?>



