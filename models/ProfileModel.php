<?php
@session_start();

class ProfileModel extends Db
{
    public function getProfile($uid)
    {

        $conn = $this->connect();
        $query = "SELECT * FROM user WHERE id = :id AND stay=1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $uid, PDO::PARAM_STR);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            unset($userData['psw']);
            $query = "SELECT hobby.name FROM user INNER JOIN user_hobby ON user.id = user_hobby.user_id INNER JOIN hobby ON user_hobby.hobby_id = hobby.id WHERE user.id=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id", $userData["id"], PDO::PARAM_STR);
            $stmt->execute();
            $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $users = $userData;
            $users['hobby'] = $hobbies;
            return $users;
        } else {

            return false;
        }
    }

    public function setImgProfile($uid, $fileTmp, $fileDestination)
    {
        $conn = $this->connect();
        $query = "UPDATE user SET profil='$fileDestination' WHERE id=$uid";
        $stmt = $conn->prepare($query);
        $exec = $stmt->execute();
        if ($exec) {
            move_uploaded_file($fileTmp, $fileDestination);
            $_SESSION['user']['profil']=$fileDestination;
        }else{
            return $query;
        }
    }
}
