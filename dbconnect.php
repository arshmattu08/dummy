<?php
/**
 * This file defines PDO database package. This file is included in any files that needs database connection
 * http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
 * http://php.net/manual/en/pdostatement.fetch.php
  */

function openConnection() {
    try {
        // Replace these with your actual database connection details
        $hostname = 'localhost';
        $dbname = 'as115_db';
        $username = 'as115';
        $password = 'catchier bowdlerized healthiest';

        // Create a PDO instance
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}


?>
