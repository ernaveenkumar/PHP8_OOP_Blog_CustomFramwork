<?php
namespace Core;

abstract class Model{
  protected static $table;

  public static function all(){
    $db = App::get('database');
    $results = $db->query("SELECT * FROM ". static::$table)->fetchAll(PDO::FETCH_ASSOC);
    //static::class
    //Every class has this special constant that will give you the full class 
    //name, including the namespace,and after a comma.

    return array_map([static::class, 'creatFromArray'], $results);
  }
  public static function find($id):static|null{

    $db = App::get('database');
    $result = $db->query("SELECT * FROM ". $table . "  WHERE id = ? ", [$id])->fetch(PDO::FETCH_ASSOC);

    return $result ? static::createFromArray($result):null;
  }

  //@return static in its DocBlocks to indicate that the methods return the object itself, or an instance of the same class.
  //https://php.watch/versions/8.0/static-return-type#:~:text=The%20static%20return%20type%20helps,instance%20of%20the%20class%20itself.
  public static function create(array $data):static {

    $db = App::get('database');
    //Get the name of columns inside $data
    $columns = implode(', '. array_keys($data));
    //-> id, title, created_at, content

    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    $sql = "INSERT INTO ". static::$table. " ($columns) VALUES ($placeholders)";
    $db->query($sql, array_values($data));
    return static::find(($db->lastInsertId()));
    
  }


  protected static function createFromArray(array $data): static{
    $model = new static(); // current class which ever is extending it
    foreach($data as $key => $value){

      /*
        example of defined property
        class Post{
          public $id;
        }
      */
      if(property_exists($model, $key)){
        $model->$key = $value; //dynamically calculate property name
      }
    }
    return $model;
  }
}
