<?php

require_once "model/User.php";

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function signup()
    {
        $data = [
            "page" => "signup",
            "title" => "Sign Up",
            "name" => "",
            "email" => "",
            "password" => "",
            "confirm_password" => "",
            "errors" => []
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data["name"] = trim($_POST["name"] ?? "");
            $data["email"] = trim($_POST["email"] ?? "");
            $data["password"] = trim($_POST["password"] ?? "");
            $data["confirm_password"] = trim($_POST["confirm_password"] ?? "");

            if (empty($data["name"])) {
                $data["errors"]["name"] = "Name is required.";
            } elseif (strlen($data["name"]) < 3) {
                $data["errors"]["name"] = "Name must be at least 3 characters.";
            }

            if (empty($data["email"])) {
                $data["errors"]["email"] = "Email is required.";
            } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                $data["errors"]["email"] = "Invalid email format.";
            } elseif ($this->userModel->emailExists($data["email"])) {
                $data["errors"]["email"] = "Email already exists.";
            }

            if (empty($data["password"])) {
                $data["errors"]["password"] = "Password is required.";
            } elseif (strlen($data["password"]) < 6) {
                $data["errors"]["password"] = "Password must be at least 6 characters.";
            }

            if (empty($data["confirm_password"])) {
                $data["errors"]["confirm_password"] = "Confirm password is required.";
            } elseif ($data["password"] !== $data["confirm_password"]) {
                $data["errors"]["confirm_password"] = "Passwords do not match.";
            }

            if (empty($data["errors"])) {
                $created = $this->userModel->createUser(
                    $data["name"],
                    $data["email"],
                    $data["password"]
                );

                if ($created) {
                    $_SESSION["success"] = "Registration successful. Please sign in.";
                    header("Location: index.php?page=signin");
                    exit;
                } else {
                    $data["errors"]["general"] = "Something went wrong. Please try again.";
                }
            }
        }

        $this->view("signup", $data);
    }

    public function signin()
    {
        $data = [
            "page" => "signin",
            "title" => "Sign In",
            "email" => "",
            "password" => "",
            "errors" => []
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data["email"] = trim($_POST["email"] ?? "");
            $data["password"] = trim($_POST["password"] ?? "");

            if (empty($data["email"])) {
                $data["errors"]["email"] = "Email is required.";
            } elseif (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                $data["errors"]["email"] = "Invalid email format.";
            }

            if (empty($data["password"])) {
                $data["errors"]["password"] = "Password is required.";
            }

            if (empty($data["errors"])) {
                $user = $this->userModel->findUserByEmail($data["email"]);

                if ($user && password_verify($data["password"], $user["password"])) {
                    session_regenerate_id(true);

                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["user_name"] = $user["name"];
                    $_SESSION["user_email"] = $user["email"];

                    header("Location: index.php?page=dashboard");
                    exit;
                } else {
                    $data["errors"]["general"] = "Invalid email or password.";
                }
            }
        }

        $this->view("signin", $data);
    }

    public function dashboard()
    {
        if (!isset($_SESSION["user_id"])) {
            header("Location: index.php?page=signin");
            exit;
        }

        $data = [
            "page" => "dashboard",
            "title" => "Dashboard"
        ];

        $this->view("dashboard", $data);
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: index.php?page=signin");
        exit;
    }

    private function view($viewName, $data = [])
    {
        extract($data);
        require "view/layout.php";
    }
}