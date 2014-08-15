<?php

/**
 * Connect to our database.
 */
$DB_CONN = new mysqli("localhost", "jhuston", "NicePass", "jhuston");

/**
 * Make sure we didn't get a connection error, bail if we did.
 */
if ($DB_CONN->connect_errno) {
    print_f("Failed to connect to DB: %s", $DB_CONN->connect_error);
    exit();
}

