<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ads_container".
 *
 * @property integer $id
 * @property integer $private
 * @property boolean $allow_mails
 * @property string $phone
 * @property string $location_id
 * @property string $category_id
 * @property string $title
 * @property string $description
 * @property string $price
 * @property integer $author_id
 */
class AdsForm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_container';
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['private', 'title', 'author_id'], 'required'],
            [['private', 'author_id'], 'integer'],
            [['allow_mails'], 'boolean'],
            [['phone'], 'string', 'max' => 11],
            [['location_id'], 'string', 'max' => 6],
            [['category_id'], 'string', 'max' => 3],
            [['title'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 500],
            [['price'], 'integer', 'max' => 999999999, 'min'=>0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'private' => 'Private',
            'allow_mails' => 'Allow Mails',
            'phone' => 'Phone',
            'location_id' => 'Location ID',
            'category_id' => 'Category ID',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'author_id' => 'Author ID',
        ];
    }
    public static function FindAllWithPkAsArrayKey()
    {
        $temp = static::find()->select('id,private,title,author_id,price')->all();
        if (!$temp) return (object)NULL;
        foreach ($temp as $value)
        {
            $arrayToReturn[$value->id] = $value;
        }
        return $arrayToReturn;
    }
    
    public static function saveFromPost($post)
    {
         if (isset($post['id']))
        {
            
            $ad = static::findOne($post['id']);
            unset($post['id']);
            $ad->attributes=$post;
            $response['action'] = 'update';
            $response['message'] = 'Объявление успешно отредактировано';
        }
        else
        {
            $ad = new AdsForm ();
            $ad->attributes = $post;
            $response['action'] = 'save';
            $response['message'] = 'Новое объявление сохранено';
        }
        
        
         if ($ad->save())
        {
             $id = $ad->id;
             $response['id'] = ($id)? $id : static::last_id();
             $response['status'] = 'success';
             
        }
         else
        {
             $response['status'] = 'error';
             $response['message'] = 'Ошибка сохранения';
             $response['errorInfo'] = $ad->getErrors();
        }

        return $response;
    }
    
    public function delete()
    {
         if (parent::delete())
        {
            $response['status'] = 'success';
            $response['message'] = 'Объявление успешно удалено';
        }
         else
        {
            $response['status'] = 'error';
            
            
        }

        return $response;
    }
}
