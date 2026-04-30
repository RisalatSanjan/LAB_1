<?php

session_start();

require_once "controller/AuthController.php";

$controller = new AuthController();

$page = $_GET["page"] ?? "signin";

switch ($page) {
    case "signup":
        $controller->signup();
        break;

    case "signin":
        $controller->signin();
        break;

    case "dashboard":
        $controller->dashboard();
        break;

    case "logout":
        $controller->logout();
        break;

    default:
        echo "<h1>404 - Page Not Found</h1>";
        break;
}