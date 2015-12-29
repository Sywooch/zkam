<?php
@session_start();
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;


AppAsset::register($this);
@session_start();
if (isset($_SESSION['city'])){
    $city = \app\modules\arenda\models\GeobaseCity::findOne(['url'=>$_SESSION['city_url']]);
}else{
    $geobase = Yii::$app->ipgeobase->getLocation($_SERVER['REMOTE_ADDR'], false)->city;
    if (!empty($geobase)) $city = \app\modules\arenda\models\GeobaseCity::findOne(['name'=>$geobase]);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!--тут модальное окно с выбором города-->
<!-- Large modal -->
<div class="modal fade bs-example-modal-lg region_list"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <?php $form = ActiveForm::begin([
                'action'=>'/site/setcity'
            ]) ?>
            <?php
            $query = 'SELECT GC.*,GR.name AS GR_name
            from geobase_city AS GC
            LEFT JOIN geobase_region AS GR ON (GC.region_id=GR.id)
            ORDER BY name ASC
            ';
            $result = Yii::$app->db
                ->createCommand($query)
                ->queryAll();
            echo '
                <div class="form-group r_list">
                    <label for="r_list">Выберите город</label>
                        <input placeholder="Введите свой город..." class="form-control autocomplete" type="text" name="country" />
                    </div>';
            ?>
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary city_sel',]) ?>
            <?php ActiveForm::end() ?>

        </div>
    </div>
</div>


<div class="wrap">
<!--    <a href="/--><?//=strtolower($_SESSION['city_url'])?><!--/arenda">ТЕСТОВАЯ ССЫЛКА НА ВЫВОД ОБЪЯВЛЕНИЙ</a>-->
    <p><a href="/login">ТЕСТОВАЯ ССЫЛКА НА ВХОД</a></p>
    <p><a href="/admin">ТЕСТОВАЯ ССЫЛКА НА Админку</a></p>
    <nav class="navbar navbar-default navbar-static-top top_nav" role="navigation">
        <div class="container">
            <div class="row" style="margin-top:25px;margin-bottom:25px;">
                <div class="col-md-3 logo_container">
                    <a href="/"> <img class="zkam_logo" src="/images/site_images/zkam_black.png"></a>
                    <p class="logo_podtext">ПОРТАЛ АРЕНДЫ</p>
                </div>
                <div class=" col-md-3 text1_container " >
                    <p>ПЕРВЫЙ В РОССИИ</p>
                    <p>ПОРТАЛ АРЕНДЫ</p>
                </div>
                <div class="col-md-3 login_container">
                    <a href="" class="pull-right" data-toggle="modal" data-target=".region_list"><?=(isset($city) ? $city->name : 'Мой регион')?></a>
                    <a href="" class="pull-right">Войти</a>

                </div>
                <div class="col-md-3 add_ad_container">
                    <a href="/arenda/default/add" class="btn btn-default add_ad_btn">Добавить объявление</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container-fluid menu_search">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-2 col-md-1 col-sm-2 search_container" >
                    <img class="lupa" src="/images/site_images/lupa.png">
                </div>
                <div class="col-md-5 col-sm-8 input_container" >
                    <input type="text" placeholder="Поиск">
                </div>
                <div class="col-md-2 col-sm-2" >
                    <a href="" class="btn btn-default naiti_btn">Найти!</a>
                </div>
            </div>

        </div>


    </div>
    <div class="container">
        <!-- Button trigger modal -->

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <div class="row">
            <div class="col-md-12 col-lg-12  cont">
                <?= $content ?>
            </div>
        </div>
<!--        <button class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg1">Большая модаль</button>-->

        <div class="modal fade bs-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <?php
                        //Получаем список регионов
                    ?>
                </div>
            </div>
        </div>

    </div>

</div>
<footer class="footer">
    <nav class="navbar navbar-default navbar-static-top bottom_nav" role="navigation">
        <div class="container">
            <div class="row" style="margin-top:25px;margin-bottom:25px;">
                <div class="col-md-3 logo_container">
                    <a href="/"> <img class="zkam_logo" src="/images/site_images/zkam_white.png"></a>
                    <p class="logo_podtext">ПОРТАЛ АРЕНДЫ</p>
                </div>

                <div class=" col-md-4 sp_bottom" >
                    <ul class="footer_menu">
                        <li><a href=""> Легковые автомобили</a></li>
                        <li><a href="">Спецтехника</a></li>
                        <li><a href="">О проекте</a></li>
                        <li><a href="">Добавить объявление</a></li>
                        <li><a href="">Партнерское соглашение</a></li>
                        <li><a href="">Написать нам</a></li>
                        <li><a href="">размещение рекламы</a></li>
                    </ul>
                </div>

                <div class="col-md-5 footer_information_block">
                    <p>Новости портала:</p>
                    <p>14/11/2015  Теперь вы можете подписаться на рассылку</p>
                    <p>18/11/2015   Размещение объявлений стало еще удобнее</p>
                    <p>19/11/2015   К нам присоединились еще пять городов России</p>


                    <p><a href="#">© 2015 ООО «ZKAM-аренда»</a></p>

                </div>
            </div>
        </div>
    </nav>
</footer>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
