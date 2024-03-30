<?php
require_once 'models/UserModel.php';
require_once "utils/functions.php";
class UserController
{
    public function getUsers()
    {

        $userModel = new UserModel();
        $users = $userModel->getAllUsers();
        return $users;
    }

    public function filterAll()
    {
        if (myVerify($_POST["city"], $_POST["gender"], $_POST["age"])) {
            $city = myEncrypte($_POST['city'], "str");
            $gender = myEncrypte($_POST['gender'], "str");
            $age = myEncrypte($_POST['age'], "str");

            if (myVerify($_POST["dance"])) {
                $dance = myEncrypte($_POST['dance'], "str");
            } else {
                $dance = "";
            }

            if (myVerify($_POST["manga"])) {
                $manga = myEncrypte($_POST['manga'], "str");
            } else {
                $manga = "";
            }

            if (myVerify($_POST["gameplay"])) {
                $game = myEncrypte($_POST['gameplay'], "str");
            } else {
                $game = "";
            }

            if (myVerify($_POST["skateboard"])) {
                $skate = myEncrypte($_POST['skateboard'], "str");
            } else {
                $skate = "";
            }

            if (myVerify($_POST["cuisiner"])) {
                $cuisiner = myEncrypte($_POST['cuisiner'], "str");
            } else {
                $cuisiner = "";
            }

            $userModel = new UserModel();
            $users = $userModel->filterUser($city, $dance, $skate, $manga, $game, $cuisiner, $age, $gender);
            header('Content-Type: application/json');
            echo json_encode($users);
            return $users;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "message" => "Not set"));
        }
    }

    public function matchedUser(){
        if (myVerify($_POST["option"],$_POST["iud"])) {
            $uid = $_SESSION["user"]['id'];
            $targetId = myEncrypte($_POST['iud'], "int");
            $option = myEncrypte($_POST['option'], "str");

            $userModel = new UserModel();
            $result = $userModel->match($uid, $targetId, $option);
            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "message" => $result));
        }
    }

    public function updateUserInfo()
    {

        if (myVerify($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['city'], $_POST['actualPsw'])) {
            $firstname = myEncrypte($_POST["firstname"], 'str');
            $lastname = myEncrypte($_POST["lastname"], 'str');
            $city = myEncrypte($_POST["city"], "str");
            $email = myEncrypte($_POST["email"], "mail");
            $actualPass = myEncrypte($_POST["actualPsw"], "str");

            $checkpass = myVerify($_POST['cPsw'], $_POST['psw']);
            if ($checkpass) {
                $psw = myEncrypte($_POST["psw"], "pass");
                $cPsw = myEncrypte($_POST["psw"], "str");
            }

            if ($checkpass) {
                if (password_verify($cPsw, $psw)) {
                    $userModel = new UserModel();
                    $user = $userModel->updateUser($firstname, $lastname, $email, $city, $actualPass, $psw);

                    if ($user['response']) {
                        header('Content-Type: application/json');
                        echo json_encode(array("success" => true, "message" => $user['message']));
                    } else {
                        header('Content-Type: application/json');
                        echo json_encode(array("success" => false, "message" => $user['message']));
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("success" => false, "message" => "Les mots de passent doivent etre identiques"));
                }
            } else {

                $userModel = new UserModel();
                $psw = "";
                $user = $userModel->updateUser($firstname, $lastname, $email, $city, $actualPass, $psw);

                if ($user['response']) {
                    header('Content-Type: application/json');
                    echo json_encode(array("success" => true, "message" => $user['message']));
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("success" => false, "message" => $user['message']));
                }
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("success" => false, "message" => "Tous les champs doivent etre remplis"));
        }
    }

    public function setHobby()
    {
        unset($_POST['loisir']);
        $posts = [];
        foreach ($_POST as $key => $value) {
            $posts[$key] = $value;
        }

        $userModel = new UserModel();
        $success = $userModel->setAllHobby($posts);

        if ($success) {
            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "message" => $posts));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("success" => false, "message" => "Erreur dans les hobbies"));
        }
    }

    public function disable()
    {
        $userModel = new UserModel();
        $userModel->disableAccount();
    }

    public function sendAllMessage (){
        if (myVerify($_POST["sender"], $_POST["msg"])) {

            $sender = myEncrypte($_POST["sender"], "int");
            $msg = myEncrypte($_POST["msg"],"str");

            $userModel = new UserModel();
            $result = $userModel->sendMessage($sender,$msg);

            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "message" => $result));
            return $result;
        }
    }

    public function allConversation(){
        if (myVerify($_POST["msg"])) {
            $sender = myEncrypte($_POST["msg"],"int");
            $userModel = new UserModel();
            $result = $userModel->conversation($sender);
            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "message" => $result));
            return $result;
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "message" => 'error'));
        }
    }

    public function allMessages(){
        $userModel = new UserModel();
        $users = $userModel->messages();
        return $users;
    }
    public function allLikes(){
        $userModel = new UserModel();
        $users = $userModel->likes();
        return $users;
    }
}
