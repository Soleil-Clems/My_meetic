<?php
require_once './models/ProfileModel.php';
require_once "utils/functions.php";
class ProfileController
{

    public function showProfile()
    {

        if (myVerify($_GET['uid'])) {
            $uid = myEncrypte($_GET['uid'], "int");

            $profileModel = new ProfileModel();

            $users = $profileModel->getProfile($uid);

            return $users;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("success" => false, "message" => "Champ vide"));
        }
    }

    public function imgProfile()
    {

        if (myVerify($_FILES["profil"])) {
            $file = $_FILES["profil"];

            if ($file['error']==0) {
                
                $fileName = $file['name'];
                $fileTmp = $file["tmp_name"];
                $extensionArr = explode(".",$file["name"]);
                $extension = strtolower(end($extensionArr));
                $allowedExtension = ['jpg', 'jpeg', 'png'];
    
                if (in_array($extension, $allowedExtension)) {
                    $uid = $_SESSION['user']["id"];
                    $newImg = md5(uniqid('',true)).".".$extension;
                    $fileDestination = "./uploads/".$newImg;
                    
                    
                    
                    $profileModel = new ProfileModel();
                    $img = $profileModel->setImgProfile($uid, $fileTmp, $fileDestination);  
                    $_SESSION['user']["profil"]=$fileDestination;
                return $img;
                }
            }
        }
    }
}
