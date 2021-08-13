<?php

namespace app\database;

use PDO;

class Connection
{
    public static function connect()
    {
        return new PDO("mysql:host=localhost;dbname=laravel", "root", "", [
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
      ]);
    }
}
