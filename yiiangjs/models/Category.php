<?php
namespace app\models;

use yii\db\ActiveRecord;

 class Category extends ActiveRecord
{
//     public $cat_id;
//     public $category;
//     public $parent_id;

     
     public static function tableName()
    {
        return 'categories';
    }
    
     public static function LoadAllNested()
    {
        $temp = static::find()->asArray()->all();
        foreach ($temp as $key => $value)
        {
           if ($value['parent_id']==null)
           {
               $categories[$value['cat_id']] = $value['category'];
               unset($temp[$key]);
           }
        }
        
        foreach ($temp as $key=>$value)
        {
            
            $value['parent'] = $categories[$value['parent_id']];
            unset($value['parent_id']);
            $data['categories'][$key] = $value;
        }
        
                
        return $data['categories'];
    }
   
}