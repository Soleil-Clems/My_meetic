<?php
@session_start();
require "./models/AuthModel.php";
require_once "./utils/functions.php";

class AuthController
{
    public function login()
    {

        if (myVerify($_POST['email'], $_POST['psw'])) {
            $email = myEncrypte($_POST['email'], "mail");
            $psw = filter_var($_POST['psw'], FILTER_SANITIZE_SPECIAL_CHARS);


            $authModel = new AuthModel();

            $success = $authModel->loginUser($email, $psw);

            header('Content-Type: application/json');
            echo json_encode(array("success" => $success));
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("success" => false, "message" => "Champ vide"));
        }
    }

    public function register()
    {
        if (myVerify($_POST["firstname"], $_POST["lastname"], $_POST["birthday"], $_POST["gender"], $_POST["attraction"],  $_POST["city"], $_POST["email"], $_POST["psw"], $_POST['cPsw'])) {

            $firstname = myEncrypte($_POST["firstname"], 'str');
            $lastname = myEncrypte($_POST["lastname"], 'str');
            $birthday = myEncrypte($_POST["birthday"], "str");
            $gender = myEncrypte($_POST["gender"], "str");
            $attraction = myEncrypte($_POST["attraction"], "str");
            $city = myEncrypte($_POST["city"], "str");
            $email = myEncrypte($_POST["email"], "mail");
            $psw = myEncrypte($_POST["psw"], "pass");
            $cPsw = myEncrypte($_POST["psw"], "str");

            $age = date_diff(date_create($birthday), date_create('now'))->y;

            if ($age >=18) {
            
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    
                    if (password_verify($cPsw, $psw)) {
    
                        $authModel = new AuthModel();
                        $success = $authModel->registerUser($firstname, $lastname, $birthday, $gender, $attraction, $city, $email, $psw);
    
                        header('Content-Type: application/json');
                        echo json_encode(array("success" => $success['response'], "message" => $success["message"]));
                    }else{
    
                        header('Content-Type: application/json');
                        echo json_encode(array("success" => false, "message" => "Les mots de passes doivent etre similaires!"));
                    }
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(array("success" => false, "message" => "Email non valide!"));
                }
            }else{
                header('Content-Type: application/json');
                echo json_encode(array("success" => false, "message" => "L'age dois etre 18+"));

            }

        } else {
            header('Content-Type: application/json');
            echo json_encode(array("success" => false, "message" => "Tous les champs doivent etre remplis!"));
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }
}
