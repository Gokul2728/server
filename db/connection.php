<?php

function db()
{
    $config = parse_ini_file('db.ini');
    $username = $config['username'];
    $password = $config['password'];
    $server = $config['server'];
    $dbName = $config['db'];
    $port = $config['port'];

    try {
        $db = mysqli_connect($server, $username, $password, $dbName, $port);
        if ($db) {
            return $db;
        } else {
            return "Connection Failed";
        }
    } catch (Exception $error) {
        return json_encode($error);
    }
}