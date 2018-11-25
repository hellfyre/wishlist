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
    private $reserved_by;
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
     * @param $reserved_by
     * @param $reserved
     */
    public function __construct($id, $wishlist_id, $priority, $title, $description, $url, $price_low, $price_high, $amount, $reserved_by, $reserved) {
        $this->id = $id;
        $this->wishlist_id = $wishlist_id;
        $this->priority = $priority;
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->price_low = $price_low;
        $this->price_high = $price_high;
        $this->amount = $amount;
        $this->reserved_by = $reserved_by;
        $this->reserved = $reserved;
    }

    public static function createNew($wishlist_id, $priority, $title, $amount, $reserved, $description = null, $url = null, $price_low = null, $price_high = null, $reserved_key = null) {

    }


}