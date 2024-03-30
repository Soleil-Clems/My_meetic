<?php
require_once 'controllers/UserController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProfileController.php';

class Router
{
    public static function route($method, $url)
    {
        if ($method == "GET") {
            switch ($url) {
                case "welcome":
                    if (isset($_SESSION['user'])) {

                        header('Location: homepage');
                    } else {
                        include './views/welcome.php';
                    }
                    break;
                case "":
                    if (isset($_SESSION['user'])) {
                        $controller = new UserController();
                        $users = $controller->getUsers();

                        include './views/homepage.php';
                    } else {
                        header('Location: welcome');
                    }

                    break;

                case "logout":
                    $controller = new AuthController();
                    $controller->logout();
                    header('Location: welcome');
                    break;

                case "disable":
                    $controller = new UserController();
                    $controller->disable();
                    header('Location: logout');
                    break;
                case "update":
                    include './views/update.php';
                    break;
                case "messages":
                    $controller = new UserController();
                    $users = $controller->allMessages();
                    include './views/messages.php';
                    break;
                case "likes":
                    $controller = new UserController();
                    $users = $controller->allLikes();
                    include './views/likes.php';
                    break;

                case "profile":
                    if (isset($_SESSION['user'])) {
                        if (isset($_GET["uid"])) {
                            $controller = new ProfileController();
                            $users = $controller->showProfile();
                            include './views/profile.php';
                        } else {
                            $users = $_SESSION["user"];
                            include './views/profile.php';
                        }
                    } else {
                        header('Location: welcome');
                    }


                    break;
                default:
                    include "./views/error.php";
                    break;
            }
        } elseif ($method == "POST") {
            switch ($url) {
                case "login":
                    $controller = new AuthController();
                    return $controller->login();


                    break;
                case "register":
                    $controller = new AuthController();
                    $controller->register();

                    break;
                case "select":
                    $controller = new UserController();
                    $conversations = $controller->allConversation();
                    break;
                case "update":
                    $controller = new UserController();
                    $controller->updateUserInfo();

                    break;
                case "loisir":
                    $controller = new UserController();
                    $controller->setHobby();

                    break;
                case "logout":
                    $controller = new AuthController();
                    $controller->logout();

                    break;
                case "filter":
                    $controller = new UserController();
                    $users = $controller->filterAll();

                    break;
                case "picture":
                    $controller = new ProfileController();
                    $img = $controller->imgProfile();
                    break;
                case "option":
                    $controller = new UserController();
                    $controller->matchedUser();
                    break;
                case "send":
                    $controller = new UserController();
                    $controller->sendAllMessage();
                    break;

                default:
                    include "./views/error.php";

                    break;
            }
        }
    }
}
