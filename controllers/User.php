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
     * @param int $id This user's id
     * @param string $username This user's username
     * @param string $password_hash This user's password hash
     * @param string|null $first_name This user's first name
     * @param string|null $last_name This user's last name
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
     * Creates a new user from the given values and instantly saves it to the database. Returns the new user with its
     * assigned id.
     *
     * @param string $username The new user's username
     * @param string $password_hash The new user's password hash
     * @param string|null $first_name The new user's first name
     * @param string|null $last_name The new user's last name
     * @return User The new user with its database id
     * @throws Exception If there's an error accessing the database
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
     * Load a user from database.
     *
     * @param string $username The user's username
     * @return User The user loaded from database
     * @throws Exception If there's an error accessing the database
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

    /**
     * Check if the given password matches the saved password hash.
     *
     * @param string $password_string The password to check.
     * @return bool True, if the password matches, false otherwise.
     */
    public function passwordMatches($password_string) {
        return password_verify($password_string, $this->password_hash);
    }

    /**
     * Set a new username.
     *
     * @param string $username The new username.
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * Set a new password.
     *
     * @param string $password_string The new plaintext password.
     */
    public function setPasswordHash($password_string) {
        $this->password_hash = $this->password_hash($password_string, PASSWORD_DEFAULT);
    }

    /**
     * Set a (new) first name.
     *
     * @param string $first_name The new first name.
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    /**
     * Set a (new) last name.
     *
     * @param string $last_name The new last name.
     */
    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    /**
     * Save this user to database.
     *
     * @throws Exception If there's an error accessing the database
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