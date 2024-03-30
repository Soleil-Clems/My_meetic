<?php
@session_start();
require_once 'config/Db.php';
require_once "./utils/functions.php";

class UserModel extends Db
{
    public function getAllUsers()
    {
        $db = new Db();
        $conn = $db->connect();
        $uid = $_SESSION['user']['id'];

        $query = "SELECT * FROM matchlist WHERE user_id = :iud";
        $stmt = $conn->prepare($query);
        $stmt->bindParam("iud", $uid);
        $exec = $stmt->execute();
        $allIds = '';
        if ($exec) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {

                if (!empty($result['accepted'])) {
                    $allIds .= $result['accepted'];
                }

                if (!empty($result['refused'])) {
                    if ($allIds !== '') {
                        $allIds .= ',';
                    }
                    $allIds .= $result['refused'];
                }
            }
        }

        $query = "SELECT user.id, user.firstname, user.lastname, user.birthday, user.city, user.gender, user.attraction, user.profil, GROUP_CONCAT(hobby.name) as hobbies FROM user INNER JOIN user_hobby ON user.id = user_hobby.user_id INNER JOIN hobby ON user_hobby.hobby_id = hobby.id WHERE stay=1 AND user.id !=$uid GROUP BY user.id";
        if (empty($allIds)) {
        }else{
            $query = "SELECT user.id, user.firstname, user.lastname, user.birthday, user.city, user.gender, user.attraction, user.profil, GROUP_CONCAT(hobby.name) as hobbies FROM user INNER JOIN user_hobby ON user.id = user_hobby.user_id INNER JOIN hobby ON user_hobby.hobby_id = hobby.id WHERE stay=1 AND user.id !=$uid AND user.id NOT IN ($allIds)  GROUP BY user.id";

        }
        $stmt = $conn->query($query);
        $users = $stmt->fetchAll();

        
        return $users;
    }


    public function filterUser($city, $dance, $skate, $manga, $game, $cuisiner, $age, $gender)
    {
        $db = new Db();
        $conn = $db->connect();
        $userId = $_SESSION['user']["id"];
        $stmt = $conn->query("SELECT * FROM user WHERE id = $userId AND stay=1");
        $user = $stmt->fetch();
        if (myVerify($game) || myVerify($dance) || myVerify($cuisiner) || myVerify($skate) || myVerify($manga)) {
            $distraction = ", GROUP_CONCAT(hobby.name) as hobbies";
            $inner = "INNER JOIN user_hobby ON user.id = user_hobby.user_id INNER JOIN hobby ON user_hobby.hobby_id = hobby.id";
        } else {
            $distraction = "";
            $inner = "";
        }
        $uid = $_SESSION['user']['id'];
        $query = "SELECT user.id, user.firstname, user.lastname, user.birthday, user.city, user.gender, user.attraction, user.profil $distraction FROM user $inner WHERE user.id !=$uid AND ";

        if (myVerify($city) && $city != "all") {
            $query .= "user.city LIKE '$city' AND ";
        }
        if (myVerify($gender) && $gender != "both") {
            $query .= "user.gender LIKE '$gender' AND ";
        }

        if (myVerify($age)) {
            $tranche = explode("-", $age);
            $currentYear = date('Y');
            $begin = ($currentYear - $tranche[0]) - 1;
            $end = ($currentYear - $tranche[1]) + 1;

            $query .= "YEAR(user.birthday) BETWEEN $end AND  $begin AND ";
        }

        $conditions = array();

        if (myVerify($dance)) {
            $conditions[] = "hobby.name LIKE '$dance'";
        }

        if (myVerify($skate)) {
            $conditions[] = "hobby.name LIKE '$skate'";
        }

        if (myVerify($manga)) {
            $conditions[] = "hobby.name LIKE '$manga'";
        }

        if (myVerify($cuisiner)) {
            $conditions[] = "hobby.name LIKE '$cuisiner'";
        }

        if (myVerify($game)) {
            $conditions[] = "hobby.name LIKE '$game'";
        }

        if (count($conditions) > 0) {
            $query .= "(" . implode(" OR ", $conditions) . ")";
        }


        $query = rtrim($query, 'AND ');

        if (myVerify($game) || myVerify($dance) || myVerify($cuisiner) || myVerify($skate) || myVerify($manga)) {
            $query .= " AND stay=1 GROUP BY user.id";
        } else {
            $query .= " AND stay=1";
        }

        $stmt = $conn->prepare($query);


        $exec = $stmt->execute();

        if ($exec) {
            $users = $stmt->fetchAll();
            return  $users;
        } else {
            return "Erreur lors de la requette sql $exec $query";
        }
    }


    public function updateUser($firstname, $lastname, $email, $city, $actualPass, $psw)
    {
        $db = new Db();
        $conn = $db->connect();
        $userId = $_SESSION['user']["id"];
        $stmt = $conn->query("SELECT * FROM user WHERE id = $userId AND stay=1");
        $user = $stmt->fetch();

        if (count($user) > 0) {
            if (password_verify($actualPass, $user["psw"])) {
                $query = "UPDATE user SET ";

                if ($firstname !== $user['firstname']) {
                    $query .= "firstname = :firstname, ";
                    $params[':firstname'] = $firstname;
                }

                if ($lastname !== $user['lastname']) {
                    $query .= "lastname = :lastname, ";
                    $params[':lastname'] = $lastname;
                }

                if ($city !== $user['city']) {
                    $query .= "city = :city, ";
                    $params[':city'] = $city;
                }

                if ($email !== $user['email']) {
                    $query .= "email = :email, ";
                    $params[':email'] = $email;
                }

                if (!empty($psw)) {

                    if ($psw !== $user['psw']) {
                        $query .= "psw = :psw, ";
                        $params[':psw'] = $psw;
                    }
                }

                $query = rtrim($query, ', ');
                $query .= " WHERE id = :userId";

                $params[':userId'] = $userId;
                $stmt = $conn->prepare($query);

                foreach ($params as $param => &$value) {
                    $stmt->bindParam($param, $value);
                }

                $exec = $stmt->execute();

                if ($exec) {
                    return array("response" => true,  "message" => "It work, Congratilations");
                } else {
                    return array("response" => false,  "message" => $exec);
                }
            } else {
                return array("response" => false,  "message" => "Ancien mot de passe incorrect");
            }
        } else {
            return array("response" => false,  "message" => "Aucun utilisateur trouve");
        }
    }

    public function setAllHobby($posts)
    {
        $db = new Db();
        $conn = $db->connect();
        $userId = $_SESSION["user"]["id"];
        foreach ($posts as $key => $value) {
            $query = "INSERT INTO user_hobby(user_id, hobby_id) VALUES($userId, $value)";
            $stmt = $conn->prepare($query);
            $stmt->execute();
        }
        $stmt = $conn->query("SELECT hobby.name FROM user INNER JOIN user_hobby ON user.id = user_hobby.user_id INNER JOIN hobby ON user_hobby.hobby_id = hobby.id WHERE user.id=$userId");
        $hobbies = $stmt->fetchAll();
        $_SESSION["user"]['hobby'] = $hobbies;
        return $hobbies;
    }


    public function match($uid, $targetId, $option)
    {
        $conn = $this->connect();
        $uid = $_SESSION['user']['id'];
        $query = "SELECT * FROM matchlist WHERE user_id= $uid";
        $stmt = $conn->prepare($query);
        $exec = $stmt->execute();
        if ($exec) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                if ($option == "refused") {
                    $all = explode(',', $result['refused']);
                    
                    
                    if (!in_array($targetId, $all)) {

                        array_push($all, $targetId);
                        $all = implode(",", $all);
                        $all = ltrim($all, ",");
                        $query = "UPDATE matchlist SET refused = :refused WHERE user_id = :iud";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam("iud", $uid);
                        $stmt->bindParam("refused", $all);
                        $stmt->execute();
                        return  $all;
                    } else {
                        return "deja exist";
                    }
                } else {
                    $all = explode(',', $result['accepted']);
                    if (!in_array($targetId, $all)) {

                        array_push($all, $targetId);

                        $all = implode(",", $all);
                        $all = ltrim($all, ",");
                        $query = "UPDATE matchlist SET accepted = :accepted WHERE user_id = :iud";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam("iud", $uid);
                        $stmt->bindParam("accepted", $all);
                        $stmt->execute();
                        return  $all;
                    } else {
                        return "deja exist";
                    }
                    return "update";
                }
            } 
        
        }
    }

    public function disableAccount()
    {
        $db = new Db();
        $conn = $db->connect();
        $userId = $_SESSION['user']['id'];
        $query = "UPDATE user SET stay = 0 WHERE id = $userId";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }

    public function sendMessage($sender, $msg){
        $userId = $_SESSION['user']['id'];
        $db = new Db();
        $conn = $db->connect();
        $query = "INSERT INTO message(me_id, sender_id, msg) VALUES(:me, :sender, :msg)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam("me", $userId, PDO::PARAM_INT);
        $stmt->bindParam("sender", $sender, PDO::PARAM_INT);
        $stmt->bindParam("msg", $msg, PDO::PARAM_STR);
        $exec= $stmt->execute();
        
        if ($exec) {
            $query = "SELECT * FROM message WHERE (me_id = $userId AND sender_id = $sender) OR (me_id=$sender AND sender_id=$userId) ORDER BY id";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $messages;
        }else{
            return $exec;
        }
    }

    public function conversation($sender){
        $db = new Db();
        $conn = $db->connect();
        $userId = $_SESSION['user']['id'];
        $query = "SELECT * FROM message WHERE (me_id = $userId AND sender_id = $sender) OR (me_id=$sender AND sender_id=$userId) ORDER BY id";

        $stmt = $conn->query($query);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $messages;
    }

    public function messages (){
        $db = new Db();
        $conn = $db->connect();
        $userId = $_SESSION['user']['id'];
        $query = "SELECT * FROM matchlist WHERE user_id = $userId";
        $stmt = $conn->query($query);
        $users = $stmt->fetch();
        
        $accepted = $users['accepted'];
        if ($accepted) {
            $query = "SELECT user.firstname, user.lastname, user.id, user.profil FROM user WHERE user.id IN ($accepted)";
            $stmt = $conn->query($query);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }else{
            return [];
        }

    }
    public function likes (){
        $db = new Db();
        $conn = $db->connect();
        $userId = $_SESSION['user']['id'];
        $query = "SELECT user.id,user.profil, user.firstname, user.lastname FROM user INNER JOIN matchlist ON user.id = matchlist.user_id WHERE FIND_IN_SET($userId, matchlist.accepted)";
        $stmt = $conn->query($query);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        return $users;
    }

}
