<?php
namespace Core;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

class Database{

  protected $pdo;

  public function __construct(array $config){
    try{


      $dsn = $this->createDsn($config);
      $username = $config['username'] ?? null;
      $password = $config['password'] ?? null;
      $options = $config['options'] ?? null;
      //$dsn data source name
      //In sqlite database name is just the path of sqlite file
      $this->pdo = new PDO($dsn, $username, $password, $options);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e){

      throw new Exception("Could not cannot to the database");
    }
  }

  protected function createDsn(array $config) : string{
    //var_dump($config); die('config');

    $driver = $config['driver'];
    $dbname = $config['dbname'];
    return match($driver){
      'sqlite' => "sqlite:$dbname",
      default => throw new Exception("Unsupported database driver"),
    };
  }

  public function query(string $sql, array $params = []):PDOStatement{

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;

    
/* Execute a prepared statement by passing an array of values */
//https://www.php.net/manual/en/pdo.prepare.php
/*
    $sql = 'SELECT name, colour, calories
    FROM fruit
    WHERE calories < :calories AND colour = :colour';
    $sth = $dbh->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $sth->execute(['calories' => 150, 'colour' => 'red']);
    $red = $sth->fetchAll();

    // Array keys can be prefixed with colons ":" too (optional) 

    $sth->execute([':calories' => 175, ':colour' => 'yellow']);
    $yellow = $sth->fetchAll();
    */

  }

  public function fetchAll(string $sql, $params =[]):array{

    return $this->query($sql, $params)->fetchAll(PDO::FETCH_OBJ);
  }

  public function fecth(string $sql, array $params = []) : object|false{

    return  $this->query($sql, $params)->fetch(PDO::FETCH_OBJ);
  }

  public function lastInsertId():string|false{
    return $this->pdo->lastInsertId();
  }


}