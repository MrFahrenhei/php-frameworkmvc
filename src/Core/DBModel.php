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
    abstract public function primaryKey(): string;
    public function save()
    {
       $tableName = $this->tableName();
       $attributes = $this->attributes();
       $params = array_map(fn($attr)=>":$attr", $attributes);
       $stmt = self::prepare("INSERT INTO $tableName 
                (".implode(',',$attributes).")
                VALUES
                (".implode(',',$params).") 
       ");
       foreach($attributes as $attribute){
           $stmt->bindValue(":$attribute", $this->{$attribute});
       }
       return $stmt->execute();
    }

    public function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach($where as $key => $value){
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }
    public function prepare($sql): false|\PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}