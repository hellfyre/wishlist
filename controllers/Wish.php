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
     * Wish constructor. Do not use.
     *
     * Do not use this constructor. Use the static methods {@see Wish::createNew()} and {@see Wish::loadFromDb()}
     * instead.
     *
     * @param int $id This wish's id.
     * @param int $wishlist_id The id of the wishlist this wish belongs to.
     * @param int $priority This wish's priority.
     * @param string $title This wish's title.
     * @param string|null $description This wish's description.
     * @param string|null $url This wish's URL.
     * @param string|null $price_low The lower end of this wish's price range.
     * @param string|null $price_high The upper end of this wish's price range.
     * @param int $amount This wish's amount.
     * @param string|null $reserved_key This wish's reservation key.
     * @param bool $reserved This wish's reserved status.
     */
    public function __construct($id, $wishlist_id, $priority, $title, $description = null, $url = null, $price_low = null, $price_high = null, $amount = 1, $reserved_key = null, $reserved = false) {
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

    /**
     * Create a new wish.
     *
     * Creates a new wish from the given values and instantly saves it to the database. Returns the new wish with its
     * assigned id.
     *
     * @param int $wishlist_id The id of the wishlist the new wish belongs to.
     * @param int $priority The new wish's priority.
     * @param string $title The new wish's title.
     * @param int $amount The new wish's amount.
     * @param bool $reserved The new wish's reserved status.
     * @param string|null $description The new wish's description.
     * @param string|null $url The new wish's URL.
     * @param string|null $price_low The lower end of the new wish's price range.
     * @param string|null $price_high The upper end of the new wish's price range.
     * @param string|null $reserved_key The new wish's reservation key.
     * @return Wish The new wish with its database id.
     * @throws Exception If there's an error accessing the database.
     */
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

    /**
     * Load a wish from database.
     *
     * @param $id The wish's id.
     * @return Wish The wish loaded from database.
     * @throws Exception If there's an error accessing the database.
     */
    public static function loadFromDb($id) {
        try {
            $db = getDb();
        } catch (Exception $exception) {
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
     * Get this wish's id.
     *
     * @return int This wish's id.
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the id of the wishlist this wish belongs to.
     *
     * @return int The id of the wishlist this wish belongs to.
     */
    public function getWishlistId() {
        return $this->wishlist_id;
    }

    /**
     * Assign this wish to another wishlist.
     *
     * @param int $wishlist_id The id of the new wishlist this wish is assigned to.
     */
    public function setWishlistId($wishlist_id) {
        $this->wishlist_id = $wishlist_id;
    }

    /**
     * Get this wish's priority.
     *
     * @return int This wish's priority.
     */
    public function getPriority() {
        return $this->priority;
    }

    /**
     * Update this wish's priority.
     *
     * @param int $priority The new priority.
     */
    public function setPriority($priority) {
        $this->priority = $priority;
    }

    /**
     * Get this wish's title.
     *
     * @return string This wish's title.
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Update this wish's title.
     *
     * @param int $title The new title.
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Get this wish's description.
     *
     * @return string This wish's description.
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set a (new) description.
     *
     * @param string $description The new description.
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Get this wish's URL.
     *
     * @return string This wish's URL.
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Set a (new) URL.
     *
     * @param string $url The new URL.
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * Get the lower end of this wish's price range.
     *
     * @return string The lower end of this wish's price range.
     */
    public function getPriceLow() {
        return $this->price_low;
    }

    /**
     * Set a (new) lower end of this wish's price range.
     *
     * @param string $price_low The new lower end of this wish's price range.
     */
    public function setPriceLow($price_low) {
        $this->price_low = $price_low;
    }

    /**
     * Get the upper end of this wish's price range.
     *
     * @return string The upper end of this wish's price range.
     */
    public function getPriceHigh() {
        return $this->price_high;
    }

    /**
     * Set a (new) upper end of this wish's price range.
     *
     * @param string $price_high The new upper end of this wish's price range.
     */
    public function setPriceHigh($price_high) {
        $this->price_high = $price_high;
    }

    /**
     * Get this wish's amount.
     *
     * @return int This wish's amount.
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * Set a new amount for this wish.
     *
     * @param int $amount The new amount.
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * Get the key for this wish's reservation.
     *
     * @return string The key for this wish's reservation.
     */
    public function getReservedKey() {
        return $this->reserved_key;
    }

    /**
     * Set a new key for this wish's reservation.
     *
     * @param string $reserved_key The new key for this wish's reservation.
     */
    public function setReservedKey($reserved_key) {
        $this->reserved_key = $reserved_key;
    }

    /**
     * Get the status of this wish's reservation.
     *
     * @return bool This wish's reservation status.
     */
    public function getReserved() {
        return $this->reserved;
    }

    /**
     * Update the reservation status of this wish.
     *
     * @param bool $reserved The new status of this wish's reservation.
     */
    public function setReserved($reserved) {
        $this->reserved = $reserved;
    }

    /**
     * Save this wish to database.
     *
     * @throws Exception If there's an error accessing the database.
     */
    public function save() {
        try {
            $db = getDb();
        } catch (Exception $exception) {
            throw $exception;
        }

        $statement = $db->prepare("REPLACEINTO wish (id_wishlist, title, description, url, priority, price_low, price_high, amount, reserved_key, reserved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param("isssissisi", $this->wishlist_id, $this->title, $this->description, $this->url, $this->priority, $this->price_low, $this->price_high, $this->amount, $this->reserved_key, $this->reserved);
        $statement->execute();
    }

}