<?php

namespace App\Core;
/**
 * Class DBModel
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */
abstract class DBModel extends Model
{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    public function save()
    {
       $tableName = $this->tableName();
       $attributes = $this->attributes();
       $params = array_map(fn($attr)=>":$attr", $attributes);
       $stmt = self::prepare("
                INSERT INTO 
                $tableName 
                (".implode(',',$attributes).") 
                VALUES
                (".implode(',',$params).") 
       ");
       foreach($attributes as $attribute){
           $stmt->bindValue(":$attribute", $this->{$attribute});
       }
       return $stmt->execute();
    }

    public function prepare($sql)
    {
    return Application::$app->db->pdo->prepare($sql);
    }
}