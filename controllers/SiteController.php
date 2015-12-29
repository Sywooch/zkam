<?php

namespace app\controllers;

use app\models\User;
use app\modules\arenda\models\GeobaseCity;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\modules\regions\models\ModArendaCities;




class SiteController extends Controller
{


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {

        @session_start();
        if (!isset($_SESSION['city'])){
            $_SESSION['city'] = 'Набережные Челны';
            $_SESSION['city_url'] = 'Naberezhnye-Chelny';
        }
        if (isset($_SESSION['city_url'])){
            return $this->redirect('/'.strtolower($_SESSION['city_url']).'/arenda');
        }
        return $this->render('index');
    }
    public function actionGetcities(){
        $query = 'SELECT GC.*,GR.name AS GR_name
            from geobase_city AS GC
            LEFT JOIN geobase_region AS GR ON (GC.region_id=GR.id)
            ORDER BY name ASC
            ';
        $result = Yii::$app->db
            ->createCommand($query)
            ->queryAll();
        foreach ($result as $key => $value) {
            $res[] = [
                'value'=>''.$value["name"].'',
                'label'=>''.$value["name"].' ('.$value['GR_name'].')'.''
            ];
        }

        echo json_encode($res);

    }

    public function actionSetcity(){
        @session_start();
        if (Yii::$app->request->post('country')) {
            if ($city = GeobaseCity::findOne(['name'=>Yii::$app->request->post('country')]))
            {
                $_SESSION['city'] = $city->name;
                $_SESSION['city_url'] = $city->url;
                return $this->redirect('/'.strtolower($city->url).'/arenda');
            }
        }

    }


    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionRegister()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password = md5($model->password);
            if ($model->save()){
                return $this->redirect('login?register=1');
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }


}
