<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ads_authors".
 *
 * @property integer $id
 * @property string $seller_name
 * @property string $email
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ads_authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seller_name', 'email'], 'required'],
            [['seller_name'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 50],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seller_name' => 'Seller Name',
            'email' => 'Email',
        ];
    }
    
   public static function saveFromPost($post)
   {
       $name = $post['seller_name'];
       $email = $post['email'];
       
       if (!$author=  static::findOne(['email' => $email]))
        {
            $author = new Author ();
            $author->email = $email; 
            $author->id = NULL;
            $response['action'] = 'save';
            $response['message'] = 'Новый автор успешно сохранен';
        }
         else 
        {
            $response['action'] = 'update';
            $response['message'] = 'Автор обновлен';
        
        }
        
          
        $author->seller_name = $name;
        if ($author->save())
        {
            $id = $author->id;
            $response['id'] = ($id)? $id : static::last_id();
            $response['status'] = 'success';
        }
        else
        {
            $response['status'] = 'error';
            $response['message'] = 'Ошибка базы данных';
            $response['errorInfo'] = $author->getErrors();
        }
        return $response;
        
   }
   
   public static function findAllWithPkAsArrayKey()
   {
       $authors = static::find()->all();
               if (!$authors) return (object)NULL;
       foreach ($authors as $value)
       {
           $dataToReturn[$value->id] = $value;
       }
       return $dataToReturn;
   }
}
