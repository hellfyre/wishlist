<?php

require_once "DbConnection.php";

/**
 * Class User
 *
 * A representation of the user table
 */
class User {
    private $id;
    private $username;
    private $password_hash;
    private $first_name;
    private $last_name;

    /**
     * User constructor. Do not use.
     *
     * Do not use this constructor. Use the static methods {@see User::createNew()} and {@see User::loadFromDb()}
     * instead.
     *
     * @param int $id
     * @param string $username
     * @param string $password_hash
     * @param string|null $first_name
     * @param string|null $last_name
     */
    private function __construct($id, $username, $password_hash, $first_name = null, $last_name = null) {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
    }

    /**
     * Create a new user.
     *
     * Creates a new user from the given values and instantly save the new user to the database. Returns the new user
     * with its assigned id.
     *
     * @param string $username
     * @param string $password_hash
     * @param string|null $first_name
     * @param string|null $last_name
     * @return User The new user with its DB id
     * @throws Exception
     */
    public static function createNew($username, $password_hash, $first_name = null, $last_name = null) {
        try {
            $db = getDb();
        } catch (Exception $exception) {
            //TODO: actually handle exceptions
            throw $exception;
        }

        $statement = $db->prepare("INSERT INTO user (uName, pwd, first_name, last_name) VALUES (?, ?, ?, ?)");
        $statement->bind_param("ssss", $username, $password_hash, $first_name, $last_name);
        $statement->execute();

        return User::loadFromDb($username);
    }

    /**
     * Loads a user from database.
     *
     * @param $username
     * @return User
     * @throws Exception
     */
    public static function loadFromDb($username) {
        try {
            $db = getDb();
        } catch (Exception $exception) {
            throw $exception;
        }

        $statement = $db->prepare("SELECT idUser, pwd, first_name, last_name FROM user WHERE uName = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $statement->bind_result($id, $password_hash, $first_name, $last_name);
        $statement->fetch();

        return new User($id, $username, $password_hash, $first_name, $last_name);
    }

    public function passwordMatches($password_string) {
        return password_verify($password_string, $this->password_hash);
    }

    /**
     * Set the user id.
     *
     * This is just to set the user id when loading a user from database.
     *
     * @param mixed $id
     */
    private function setId($id) {
        $this->id = $id;
    }

    /**
     * Set a new username.
     *
     * @param mixed $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Set a new password.
     *
     * @param mixed $password_string The plaintext password
     */
    public function setPasswordHash($password_string) {
        $this->password_hash = $this->password_hash($password_string, PASSWORD_DEFAULT);
    }

    /**
     * Set a (new) first name.
     *
     * @param null $first_name
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    /**
     * Set a (new) last name.
     *
     * @param null $last_name
     */
    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    /**
     * Save user to database.
     *
     * @throws Exception
     */
    public function save() {
        try {
            $db = getDb();
        } catch (Exception $exception) {
            throw $exception;
        }

        $statement = $db->prepare("REPLACE INTO user (uName, pwd, first_name, last_name) VALUES (?, ?, ?, ?) WHERE idUser = ?");
        $statement->bind_param(
            "ssssi",
            $this->username,
            $this->password_hash,
            $this->first_name,
            $this->last_name,
            $this->id
        );
        $statement->execute();
    }

}