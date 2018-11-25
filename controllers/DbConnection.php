<?php

/**
 * Establish a database connection.
 *
 * A simple wrapper to establish a database connection using the config file ../config/db.ini.
 *
 * @return mysqli Returns a mysqli object.
 * @throws Exception If the configuration file cannot be found.
 */
function getDb() {
    $db_ini = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/config/db.ini");
    if (!$db_ini) {
        throw new Exception("File db.ini not found or not parsable.");
    }

    //TODO: Secure against missing configuration parameters in db.ini

    $connection = new mysqli($db_ini["host"], $db_ini["user"], $db_ini["password"], $db_ini["database"]);
    return $connection;
}

?>