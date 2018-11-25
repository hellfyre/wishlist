<?php

require_once "DbConnection.php";

/**
 * Class User
 *
 * A representation of the user table
 */
class User {
    private $username;
    private $password_hash;
    private $first_name;
    private $last_name;

    /**
     * User constructor.
     *
     * @param $username
     * @param $password_hash
     * @param $first_name
     * @param $last_name
     */
    public function __construct($username, $password_hash, $first_name=null, $last_name=null) {
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    public static function loadFromDb($username) {
        try {
            $db = getDb();
        }
        catch (Exception $e) {
            throw $e;
        }

        $statement = $db->prepare("SELECT pwd, first_name, last_name FROM user WHERE uName = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $statement->bind_result($password_hash, $first_name, $last_name);
        $statement->fetch();

        return new User($username, $password_hash, $first_name, $last_name);
    }

    public function passwordMatches($password_string) {
        return password_verify($password_string, $this->password_hash);
    }


}