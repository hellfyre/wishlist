<?php

require_once "DbConnection.php";

class Wish {
    private $id;
    private $wishlist_id;
    private $priority;
    private $title;
    private $description;
    private $url;
    private $price_low;
    private $price_high;
    private $amount;
    private $reserved_key;
    private $reserved;

    /**
     * Wish constructor.
     *
     * @param $id
     * @param $wishlist_id
     * @param $priority
     * @param $title
     * @param $description
     * @param $url
     * @param $price_low
     * @param $price_high
     * @param $amount
     * @param $reserved_key
     * @param $reserved
     */
    public function __construct($id, $wishlist_id, $priority, $title, $description, $url, $price_low, $price_high, $amount, $reserved_key, $reserved) {
        $this->id = $id;
        $this->wishlist_id = $wishlist_id;
        $this->priority = $priority;
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->price_low = $price_low;
        $this->price_high = $price_high;
        $this->amount = $amount;
        $this->reserved_key = $reserved_key;
        $this->reserved = $reserved;
    }

    public static function createNew($wishlist_id, $priority, $title, $amount, $reserved, $description = null, $url = null, $price_low = null, $price_high = null, $reserved_key = null) {
        try {
            $db = getDb();
        } catch (Exception $exception) {
            //TODO: actually handle exceptions
            throw $exception;
        }

        $statement = $db->prepare("INSERT INTO wish (id_wishlist, title, description, url, priority, price_low, price_high, amount, reserved_key, reserved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param("isssissisi", $wishlist_id, $title, $description, $url, $priority, $price_low, $price_high, $amount, $reserved_key, $reserved);
        $statement->execute();

        return Wish::loadFromDb($db->insert_id);
    }

    public static function loadFromDb($id) {
        try {
            $db = getDb();
        }
        catch (Exception $exception) {
            throw $exception;
        }

        $statement = $db->prepare("SELECT id_wishlist, title, description, url, priority, price_low, price_high, amount, reserved_key, reserved FROM wish WHERE id_wish = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $statement->bind_result($wishlist_id, $title, $description, $url, $priority, $price_low, $price_high, $amount, $reserved_key, $reserved);
        $statement->fetch();

        return new Wish($id, $wishlist_id, $priority, $title, $description, $url, $price_low, $price_high, $amount, $reserved_key, $reserved);

    }

    /**
     * @return mixed
     */
    public function getWishlistId() {
        return $this->wishlist_id;
    }

    /**
     * @param mixed $wishlist_id
     */
    public function setWishlistId($wishlist_id) {
        $this->wishlist_id = $wishlist_id;
    }

    /**
     * @return mixed
     */
    public function getPriority() {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority) {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getPriceLow() {
        return $this->price_low;
    }

    /**
     * @param mixed $price_low
     */
    public function setPriceLow($price_low) {
        $this->price_low = $price_low;
    }

    /**
     * @return mixed
     */
    public function getPriceHigh() {
        return $this->price_high;
    }

    /**
     * @param mixed $price_high
     */
    public function setPriceHigh($price_high) {
        $this->price_high = $price_high;
    }

    /**
     * @return mixed
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getReservedKey() {
        return $this->reserved_key;
    }

    /**
     * @param mixed $reserved_key
     */
    public function setReservedKey($reserved_key) {
        $this->reserved_key = $reserved_key;
    }

    /**
     * @return mixed
     */
    public function getReserved() {
        return $this->reserved;
    }

    /**
     * @param mixed $reserved
     */
    public function setReserved($reserved) {
        $this->reserved = $reserved;
    }

    public function save() {
        try {
            $db = getDb();
        }
        catch (Exception $exception) {
            throw $exception;
        }

        $statement = $db->prepare("REPLACEINTO wish (id_wishlist, title, description, url, priority, price_low, price_high, amount, reserved_key, reserved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param("isssissisi", $this->wishlist_id, $this->title, $this->description, $this->url, $this->priority, $this->price_low, $this->price_high, $this->amount, $this->reserved_key, $this->reserved);
        $statement->execute();
    }

}