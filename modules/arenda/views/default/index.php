<?php
@session_start();
use app\modules\arenda\assets\arendaAsset;
use app\models\Func;
arendaAsset::register($this);
$this->title = "Список объявлений";
?>
<style>
    #map {
        width: 100%; height: 200px; padding: 0; margin: 0;
    }
</style>
<div class="row">
    <div class="col-md-1 "></div>
    <div class="col-md-3 cat_container">
        <div class="cat_block_left">
            <img src="/images/site_images/kol.png">
        </div>
        <div class="cat_block_right">
            <header>
                <a href="<?='/'.strtolower($_SESSION['city_url']).'/arenda/'?>avtotehnika"><span> Автотехника </a></span>
            </header>
            <footer>
                <a href="">Авто</a>, <a href="">спецтехника</a>, <a href="">мототехника</a>, <a href="">воздушная техника</a>
            </footer>
        </div>
    </div>
    <div class="col-md-3 cat_container">
        <div class="cat_block_left">
            <img src="/images/site_images/sid.png">
        </div>
        <div class="cat_block_right">
            <header>
                <a href="<?='/'.strtolower($_SESSION['city_url']).'/arenda/'?>mebel"><span>Мебель </span></a>
            </header>
            <footer>
                <a href="">Авто</a>, <a href="">Кейтеринг</a>, <a href="">офисная мебель</a>, <a href="">мебель для дома</a>
            </footer>
        </div>
    </div>
    <div class="col-md-3 cat_container">
        <div class="cat_block_left">
            <img src="/images/site_images/foto.png">
        </div>
        <div class="cat_block_right">
            <header>
                <a href="<?='/'.strtolower($_SESSION['city_url']).'/arenda/'?>tehnika"><span>Техника </span></a>
            </header>
            <footer>
                <a href="">Фото техника</a>, <a href="">игровые приставки</a>, <a href="">бытовая техника</a>
            </footer>
        </div>
    </div>

    <div class="col-md-1"></div>
</div>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-3 cat_container">
        <div class="cat_block_left">
            <img src="/images/site_images/str.png">
        </div>
        <div class="cat_block_right">
            <header>
                <a href="<?='/'.strtolower($_SESSION['city_url']).'/arenda/'?>remont-i-stroitelstvo"><span>Ремонт и строительство </span></a>
            </header>
            <footer>
                <a href="">Инструменты</a>, <a href="">сад/огород</a>
            </footer>
        </div>
    </div>
    <div class="col-md-3 cat_container">
        <div class="cat_block_left">
            <img src="/images/site_images/sport.png">
        </div>
        <div class="cat_block_right">
            <header>
                <a href="<?='/'.strtolower($_SESSION['city_url']).'/arenda/'?>sport-i-turizm"><span>Спорт и туризм </span></a>
            </header>
            <footer>
                <a href="">Туризм</a>, <a href="">спорт</a>, <a href="">велосипеды</a>
            </footer>
        </div>
    </div>
    <div class="col-md-3 cat_container">
        <div class="cat_block_left">
            <img src="/images/site_images/vesh.png">
        </div>
        <div class="cat_block_right">
            <header>
                <a href="<?='/'.strtolower($_SESSION['city_url']).'/arenda/'?>odezhda"><span>Одежда </span></a>
            </header>
            <footer>
                <a href="">Платья</a>, <a href="">бальная одежда</a>, <a href="">спецодежда</a>
            </footer>
        </div>
    </div>

    <div class="col-md-1"></div>
</div>

<div class="margin5"></div>
<div class="col-md-6 ads_wrap">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="btn-group">
                    <a href="?user=all" type="button" class="btn btn-default">Все</a>
                    <a href="?user=1"  class="btn btn-default">Частные</a>
                    <a href="?user=2"  class="btn btn-default">Компании</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="btn-group pull-right">
                    <a href="#" type="button" class="btn btn-default"><span class="glyphicon glyphicon-align-left"></span></a>
                    <a href="#"  type="button" class="btn btn-default"><span class="glyphicon glyphicon-align-center"></span></a>
                    <a href="#" type="button" class="btn btn-default"><span class="glyphicon glyphicon-align-right"></span></a>
                    <a href="#" type="button" class="btn btn-default"><span class="glyphicon glyphicon-align-justify"></span></a>
                </div>
            </div>

        </div>
    </div>

<?php
//Выводим объявления
if ($data){
    $functions = new Func();
    foreach ($data as $key=>$value){
        //разбираемся с датой
        $now_day = Date('d');
        $ad_day = date("d",strtotime($value['reg_date']));
        if ($value['arenda_price_km']!=-1) $km = ','.$value['arenda_price_km'].' руб./км';
        else $km = '';
        echo '

     <div class="row row_ad">
        <div class="col-md-12 ad_div">
            <div class="col-md-4 ad_image_div">

                <img src="'.(!empty($value['MAIN_IMAGE']) ? '/images/arenda/'.$value['id'].'/'.$value['MAIN_IMAGE'] : '/images/site_images/no-thumb.png').'">
            </div>

            <div class="col-md-8 ad_info_div">
                     <p><a href="/'.strtolower($_SESSION['city_url']).'/arenda'.'/'.strtolower($value['catname'][0][2]).'/'.$functions->ad_name($value).'"> '.$value['name'].'</a></p>
                     <p>'.$value['arenda_price_hour'].' руб./час,'.$value['arenda_price_day'].' руб./день  '.$km.'</p>
                     <p>Категория: '.$value['catname'][0][1].' / '.($value['person'] == 'person_ch' ? 'Частное лицо' : 'Компания').'</p>
                     <p>'.$value['city_name'].'</p>
                     <p>Дата: '.($now_day==$ad_day ? 'Сегодня' : date("d-m-Y",strtotime($value['reg_date']))).' в '.date("H:i",strtotime($value['reg_date'])).' </p>
            </div>
        </div>
    </div>

        ';
    }
}else{
    echo '
    <div class="row">
        <div class="col-md-12">
            <p>Ничего не найдено.</p>
        </div>
    </div>
    ';
}
?>

</div>
