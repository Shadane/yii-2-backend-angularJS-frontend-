<?php
namespace app\models;

use yii\db\ActiveRecord;

 class City extends ActiveRecord
{
//    public $city_id;
//    public $city_name;   
     public static function tableName()
    {
        return 'cities';
    }
}

