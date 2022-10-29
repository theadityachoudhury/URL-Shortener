<?php
/** 
 * Quixel Core Version 1.0.5
 * @author Léo Berteloot <leo.berteloot@gmail.com>
 * @copyright Copyright (c) 2020, Léo Berteloot
**/ 

class Core
{

    protected static $usertable = "short_users";
    protected $pdo;
    protected $timestamp;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function DeclareConfigDefine(){
        /* Get all Configuration information from the database */
        $query = "SELECT * FROM short_config";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        
        return $result;

    }

    public function GetGeneratedLink(){
        /* Return number of generated link in table short_url */
        $query = "SELECT count(*) FROM short_urls";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
        
    }

    public function GetAllUsers(){
        /* Return number of users registered on the website */
        $query =  "SELECT count(*) FROM short_users";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }
    
    public function GetAllHits(){
        /* Return number of hits redirection */
        $query =  "SELECT SUM(hits) FROM short_urls";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if($result){
            return $result;
        }else{
            return "0";
        }
    }

    /* Register user */
    public function RegisterUser($post){
        if(empty($post['pass']) || empty($post['rpass'])){
        echo "Please enter a password !";
        
        }else{
            if($post['pass'] != $post['rpass']){
                echo "Password did not match !";
            }else{
                $query1 = "SELECT * FROM ".self::$usertable." WHERE email = :email";
                $stmt1 = $this->pdo->prepare($query1);
                $params1 = array(
                    "email" => $post['mail']
                );
                $stmt1->execute($params1);
                $result = $stmt1->fetch();
                if(!empty($result['email'])){
                    echo "An account already exist with this email.";
                }else{
                    $query2 = "SELECT * FROM ".self::$usertable." WHERE name = :username";
                    $stmt2 = $this->pdo->prepare($query2);
                    $params2 = array(
                        "username" => $post['username']
                    );
                    $stmt2->execute($params2);
                    $result2 = $stmt2->fetch();
                    if(!empty($result2['name'])){
                        echo "An account already exist with this username.";
                    }else{
                        $query = "INSERT INTO ".self::$usertable." (id, email, name, password, rank) VALUES (NULL, :email, :name, :password, :rank)";
                        $stmt = $this->pdo->prepare($query);
                        $params = array(
                            "email" => $post['mail'],
                            "name" => $post['username'],
                            "password" => sha1($post['pass']),
                            "rank" => "users"
                        );
                        $stmt->execute($params);
                        if($stmt){
                            header('Location:login.php');
                        }
                    }
                }
            }
        }
    }

    /* Login User */
    public function LoginUser($post){
        if(empty($post['password'])){
            echo "Please enter a password";
        }else{
            $query = "SELECT * FROM ".self::$usertable." WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $params = array(
                "email" => $post['mail']
            );
            $stmt->execute($params);
            $result = $stmt->fetch();
            if($result['password'] == sha1($post['password'])){
                if($result){
                    session_start();
                    $_SESSION = array(
                        "email" => $result['email'],
                        "name" => $result['name'],
                        "rank" => $result['rank']
                    );
                    header('Location:account.php');
                }else{
                    echo "Email are incorrect. ";
                }
            }else{
                echo "Password incorrect.";
            }

        }
        
    }
    /**
     * USER ACCOUNT MANAGEMENT
     */
    /* Return number of generated link in table short_url by users */

        public function CheckUserIsAdmin($email){
            $query = "SELECT rank FROM short_users WHERE email = :email";
            $stmt = $this->pdo->prepare($query);
            $params = array(
                "email" => $email
            );
            $stmt->execute($params);
            $result = $stmt->fetch();
            if($result['rank'] == "admin"){
                return true;
            }else{
                return false;
            }
        }

        public function GetNbLinkOfUsers($name){
            $query = "SELECT count(*) FROM short_urls WHERE users = :uname";
            $stmt = $this->pdo->prepare($query);
            $params = array(
                "uname" => $name
            );
            $stmt->execute($params);
            $result = $stmt->fetchColumn();
            return $result;
        }

        public function GetLinkFromUsers($name){
            $query = "SELECT * FROM short_urls WHERE users = :uname";
            $stmt = $this->pdo->prepare($query);
            $params = array(
                "uname" => $name
            );
            $stmt->execute($params);
            while($result = $stmt->fetch()){
                echo '<tr>
                <th>'.$result['id'].'</th>
                <th><a href="'.$result['long_url'].'" target="_blank">'.$result['long_url'].'</a></th>
                <th><a href="//'.QB_SHORTURL.'/'.$result['short_code'].'" target="_blank">'.$result['short_code'].'</a></th>
                <th>'.$result['hits'].'</th>
                <th>'.$result['created'].'</th>
                </tr>
                ';
            }
        }

        public function GetNbLinkOfAllUsers(){
            $query = "SELECT count(*) FROM short_urls";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        }

        public function GetLinkFromAllUsers(){
            $query = "SELECT * FROM short_urls";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            while($result = $stmt->fetch()){
                echo '<tr>
                <th>'.$result['id'].'</th>
                <th><a href="'.$result['long_url'].'" target="_blank">'.$result['long_url'].'</a></th>
                <th><a href="//'.QB_SHORTURL.'/'.$result['short_code'].'" target="_blank">'.$result['short_code'].'</a></th>
                <th>'.$result['hits'].'</th>
                <th>'.$result['users'].'</th>
                <th>'.$result['created'].'</th>
                <th><a class="button is-danger" href="admin.php?remove='.$result['id'].'" target="_blank">Remove</a></th>
                </tr>
                ';
            }
        }
        public function RemoveLinkById($id){
            $query = "DELETE FROM short_urls WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $params = array(
                "id" => $id
            );
            $stmt->execute($params);
            if($stmt){
                return true;
            }else{
                return false;
            }
        }

}