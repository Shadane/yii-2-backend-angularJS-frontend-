<?php
namespace app\controllers;

use Yii;
use app\models\City;
use app\models\Category;

use app\models\AdsForm;
use app\models\Author;



use yii\web\Response;
use yii\rest\Controller;

class ApiController extends Controller
{

    
    
    public function actionLoad()
    {
        
        $data['cities'] = City::find()->all();
        
        $data['authors'] = Author::findAllWithPkAsArrayKey();
        
        $data['ads']= AdsForm::FindAllWithPkAsArrayKey();
//        $data['ads']['private'] = PrivateAds::find()->where('private = 0')->all();
//        $data['ads']['company'] = CompanyAds::find()->where('private = 1')->all();
        
        $data['categories'] = Category::LoadAllNested();
        return $data;
    }
    
    public function actionSave()
    {
        
        $post = Yii::$app->request->post();
        $response['author'] = Author::saveFromPost($post);
        
        $post['author_id'] = $response['author']['id'];
        $response['ad'] = AdsForm::saveFromPost($post);
       
        return $response;
        
    }
    
    public function actionDelete()
    {
        $get = Yii::$app->request->get();
        $ad = AdsForm::findOne($get['id']);
        
        $response = $ad->delete();
        return $response;
    }
    
    public function actionEdit()
    {
        $get = Yii::$app->request->get();
        $response['ad'] = AdsForm::findOne($get['id']);
        $response['author'] = Author::findOne($response['ad']->author_id);
        
        return $response;
    }

}
