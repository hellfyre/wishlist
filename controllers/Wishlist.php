<?php

require_once "DbConnection.php";

/**
 * Class Wishlist
 *
 * A representation of the wishlist table
 */
class Wishlist {
    private $id;
    private $user_id;
    private $title;

    /**
     * Wishlist constructor. Do not use.
     *
     * Do not use this constructor. Use the static methods {@see Wishlist::createNew()} and
     * {@see Wishlist::loadFromDb()} instead.
     *
     * @param $id
     * @param $user_id
     * @param $title
     */
    private function __construct($id, $user_id, $title) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
    }

    /**
     * Create a new wishlist.
     *
     * Creates a new wishlist from the given values and instantly saves it to the database. Returns the new wishlist
     * with its assigned id.
     *
     * @param string $title
     * @param int $user_id
     * @return Wishlist
     * @throws Exception
     */
    public static function createNew($title, $user_id) {
        try {
            $db = getDb();
        } catch (Exception $exception) {
            //TODO: actually handle exceptions
            throw $exception;
        }

        $statement = $db->prepare("INSERT INTO wishlist (id_user, title) VALUES (?, ?)");
        $statement->bind_param("is", $user_id, $title);
        $statement->execute();

        return Wishlist::loadFromDb($db->insert_id);
    }

    /**
     * Load a wishlist from database.
     *
     * @param $id
     * @return Wishlist
     * @throws Exception
     */
    public static function loadFromDb($id) {
        try {
            $db = getDb();
        } catch (Exception $exception) {
            throw $exception;
        }

        $statement = $db->prepare("SELECT title, id_user FROM wishlist WHERE id_wishlist = ?");
        $statement->bind_param("s", $id);
        $statement->execute();
        $statement->bind_result($title, $user_id);
        $statement->fetch();

        return new Wishlist($id, $user_id, $title);
    }

    /**
     * Get the associated user id.
     *
     * @return int
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Update the associated user id.
     *
     * @param int $user_id
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * Get the wishlist's title.
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Update the wishlist's title.
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    public function save() {
        try {
            $db = getDb();
        }
        catch (Exception $exception) {
            throw $exception;
        }

        $statement = $db->prepare("REPLACE INTO wishlist (id_user, title) VALUES (?, ?)");
        $statement->bind_param("is", $this->user_id, $this->title);
        $statement->execute();
    }

}