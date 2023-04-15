<?php

function redirect_to_index(string $utype)
{
    session_start();
    if (!isset($_SESSION['loggedin'])) {
        session_destroy();
        header("Location : http://localhost/tpc_miniproj/index.php");
        exit;
    } else {
        if ($_SESSION['loggedin'] == false) {
            session_destroy();
            header("Location: http://localhost/tpc_miniproj/index.php");
            exit;
        } else {
            if (!isset($_SESSION['utype'])) {
                session_destroy();
                header("Location: http://localhost/tpc_miniproj/index.php");
                exit;
            } else {
                if ($_SESSION['utype'] != $utype) {
                    session_destroy();
                    header("Location: http://localhost/tpc_miniproj/index.php");
                    exit;
                }
            }
        }
    }
}

function auto_logout()
{
    session_start();
    if (isset($_SESSION['loggedin'])) {
        session_destroy();
        header("Location: http://localhost/tpc_miniproj/index.php");
        exit;
    }
}
