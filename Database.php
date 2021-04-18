<?php
class Database
{
    private  $_connection;
    private static $_instance; //The single instance
    private $_host = "localhost";
    private $_username = "root";
    private $_password = "root";
    private $_database = "classicmodels";

    /**
     * return one instance of the Database object
     *@return Database 
     */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    // Constructor
    private function __construct()
    {
        $this->_connection = new mysqli(
            $this->_host,
            $this->_username,
            $this->_password,
            $this->_database
        );

        // Error handling
        if (mysqli_connect_error()) {
            trigger_error(
                "Failed to connect to MySQL: " . mysqli_connect_error(),
                E_USER_ERROR
            );
        }
    }

    //Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }

    /**
     * return mysqli connection
     *@return mysqli
     */
    public function getConnection()
    {
        return $this->_connection;
    }
}
