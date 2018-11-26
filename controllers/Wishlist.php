<?php

require_once "DbConnection.php";
require_once "Wish.php";

/**
 * Class Wishlist
 *
 * A representation of the wishlist table
 */
class Wishlist {
    private $id;
    private $user_id;
    private $title;
    private $wishes;

    /**
     * Wishlist constructor. Do not use.
     *
     * Do not use this constructor. Use the static methods {@see Wishlist::createNew()} and
     * {@see Wishlist::loadFromDb()} instead.
     *
     * @param int $id This wishlist's id.
     * @param int $user_id The id of the user this wishlist belongs to.
     * @param string $title This wishlist's title.
     */
    private function __construct($id, $user_id, $title) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->wishes = array();
    }

    /**
     * Create a new wishlist.
     *
     * Creates a new wishlist from the given values and instantly saves it to the database. Returns the new wishlist
     * with its assigned id.
     *
     * @param string $title The new wishlist's title.
     * @param int $user_id The id of the user the new wishlist belongs to.
     * @return Wishlist The new wishlist with its database id.
     * @throws Exception If there's an error accessing the database.
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
     * @param int $id The wishlist's id.
     * @return Wishlist The wishlist loaded from database.
     * @throws Exception If there's an error accessing the database.
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

        $wishlist = new Wishlist($id, $user_id, $title);

        $statement = $db->prepare("SELECT id_wish FROM wish WHERE id_wishlist = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->bind_result($wish_id);


        while ($statement->fetch()) {
            $wishlist->addWish(Wish::loadFromDb($wish_id));
        }

        return $wishlist;
    }

    /**
     * Get the associated user id.
     *
     * @return int The id of the user this wishlist belongs to.
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Update the associated user id.
     *
     * @param int $user_id The id of the user this wishlist belongs to.
     */
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    /**
     * Get the wishlist's title.
     *
     * @return string This wishlist's title.
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Update the wishlist's title.
     *
     * @param string $title The new title.
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get all wishes belonging to this wishlist.
     *
     * @return array All wishes belonging to this wishlist as an array.
     */
    public function getWishes() {
        return $this->wishes;
    }

    /**
     * Add a wish.
     *
     * @param Wish $wish The new wish.
     */
    public function addWish($wish) {
        $this->wishes[$wish->getId()] = $wish;
    }

    /**
     * Save this wishlist to database.
     *
     * @throws Exception If there's an error accessing the database.
     */
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