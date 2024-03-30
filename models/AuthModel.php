<?php
@session_start();

class AuthModel extends Db
{
    public function loginUser($email, $psw)
    {

        $conn = $this->connect();
        $query = "SELECT * FROM user WHERE email = :email AND stay=1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);


            if (password_verify($psw, $userData['psw'])) {

                unset($userData['psw']);
                $query = "SELECT hobby.name FROM user INNER JOIN user_hobby ON user.id = user_hobby.user_id INNER JOIN hobby ON user_hobby.hobby_id = hobby.id WHERE user.id=:id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":id", $userData["id"], PDO::PARAM_STR);
                $stmt->execute();
                $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION["user"] = $userData;
                $_SESSION["user"]['hobby'] = $hobbies;
                return true;
            } else {
                return false;
            }
        } else {

            return false;
        }
    }


    public function registerUser($firstname, $lastname, $birthday, $gender, $attraction, $city, $email, $psw, $stay = 1)
    {
        $conn = $this->connect();
        $query = "SELECT * FROM user WHERE email = :email AND stay=1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            $query = "INSERT INTO user(firstname, lastname, birthday, gender, attraction, city, email, psw, stay, profil) VALUES(:firstname, :lastname, :birthday, :gender, :attraction, :city, :email, :psw, :stay, :profil)";
            $stmt = $conn->prepare($query);
            $profil = "./uploads/default.png";
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
            $stmt->bindParam(':attraction', $attraction, PDO::PARAM_STR);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':psw', $psw, PDO::PARAM_STR);
            $stmt->bindParam(':stay', $stay, PDO::PARAM_INT);
            $stmt->bindParam(':profil', $profil, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $query = "SELECT * FROM user WHERE email = :email AND stay=1";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);
                $stmt->execute();


                if ($stmt->rowCount() > 0) {
                    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION["user"] = $userData;
                    $uid = $userData["id"];

                    $query = "INSERT INTO matchlist(user_id, accepted, refused) VALUES($uid, '', '')";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    return array("response" => true, "message" => "good");
                }
            } else {
                return array("response" => false, "message" => array($firstname, $lastname, $birthday, $gender, $attraction, $city, $email, $psw, $stay, $stmt, $stmt->execute()));
            }
        } else {

            return array("response" => false,  "message" => "This account exist");
        }
    }

    public function logoutUser()
    {
    }
}