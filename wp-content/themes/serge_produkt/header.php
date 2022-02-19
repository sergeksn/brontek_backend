<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name='viewport' content='width=device-width,initial-scale=1'/>
    <?php // Возможность соранять сайт как приложение в iOS ?>
    <meta content='yes' name='apple-mobile-web-app-capable'/>
    <?php // Возможность соранять сайт как приложение в iOS ?>
    <?php wp_head(); ?>
<script>
data_site = {};
data_site.media_data = {};
/*проверяем является ли браузер Internet Explorer*/
data_site.IE_check = function(){
    check = document.documentMode ? true : false;
    return check;
};
/*проверяем является ли браузер Internet Explorer*/

/*скрипт менят атрибут data-href на href у подключаемого файла стилей min-w- чтоб он подключался только для экранов выше 1800px*/
data_site.style_min_w_check = {};
data_site.style_min_w_check.resize = 0;
data_site.style_min_w = function() {
    let w_s_w = window.screen.width,
        links = document.querySelectorAll("link[id^='min-w-']");
    for (let i = 0; i < links.length; i++) {
        let width = links[i].getAttribute("id").split("min-w-").pop().split("-tema-style-css").shift();
        if (!data_site.style_min_w_check[width + "_check"]) {
            data_site.style_min_w_check[width + "_check"] = false;
            if (w_s_w >= width) {
                let data_href = links[i].getAttribute("data-src");
                links[i].href = data_href;
                links[i].removeAttribute("data-src");
                data_site.style_min_w_check[width + "_check"] = true;
            }
        }
    }
    data_site.style_min_w_check.resize += 1;
    if(data_site.style_min_w_check.resize > 1){
        window.removeEventListener("resize", data_site.style_min_w);
    }
};
data_site.style_min_w();
window.addEventListener("resize", data_site.style_min_w, { passive: true });
/*скрипт менят атрибут data-href на href у подключаемого файла стилей min-w- чтоб он подключался только для экранов выше 1800px*/

/*скрипт управляет размерами всех круговых лоадеров*/
data_site.l = function() {
    let win_width = document.body.clientWidth,
        win_height = window.innerHeight,
        mas = document.querySelectorAll(".loader:not(.complit)");
    for (let i = 0; i < mas.length; i++) {
        let loader = mas[i];
        if (screen.width <= 1200) {
            loader.style.cssText = "width: 75px; height: 75px;";
        } else {
            if (win_width >= win_height) {
                load_w_h = Math.ceil(win_width / 15) + "px";
                margin = Math.ceil((win_width / 15) / 2) + "px";
            } else if (win_width < win_height) {
                load_w_h = Math.ceil(win_height / 15) + "px";
                margin = Math.ceil((win_height / 15) / 2) + "px";
            }
            loader.style.cssText = "width: " + load_w_h + "; height: " + load_w_h + ";";
        }
        loader.className += " complit";
    }
};
/*скрипт управляет размерами всех круговых лоадеров*/

/*скрипт задаёт размер фона лоадера до загрузки изображения чтоб страница не прыгала по высоте*/
data_site.ips =  function() {
    let mas = document.querySelectorAll("img.img_size:not(.complit)");
    for (let i = 0; i < mas.length; i++) {
        let img = mas[i],
            img_o_w = Number(img.getAttribute("data-original-w")),
            img_o_h = Number(img.getAttribute("data-original-h")),
            p_top = (img_o_h / img_o_w) * 100,
            img_wrapper = img.parentNode;
        img_wrapper.style.cssText += "padding-top:" + p_top + "%;";
        img.className += " complit";
    }
};
/*скрипт задаёт размер фона лоадера до загрузки изображения чтоб страница не прыгала по высоте*/
</script>
</head>
<body id="body_page" <?php body_class(); ?>>





<noscript>Сожалеем, но Ваш браузер не поддерживает скрипты или они в нём просто отключены =(</noscript>

<?php
// Elementor `header` location
elementor_theme_do_location( 'header' );





//получаем содержимое страницы ввиде строки
function curl($url, $header, $method = "POST"){
    $ch = curl_init();//инициальзируем новый сеанс cURL
    curl_setopt($ch, CURLOPT_URL, $url);//переход по требуемому url

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    if($method === "POST"){
        curl_setopt($ch, CURLOPT_POST, true);
    }


    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('KSN-caching: action'));//задаём заголовк для запроса чтоб не получить кешированную страницу
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);//true для указания текущему сеансу начать новую "сессию" cookies. Это заставит libcurl проигнорировать все "сессионные" cookies, которые она должна была бы загрузить, полученные из предыдущей сессии (т.е. не учитывать авторизацию в вордпрессе)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );//true для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);//true для следования любому заголовку "Location: ", отправленному сервером в своём ответе
    $data = curl_exec($ch);//выполняем запрос cURL
    curl_close($ch);//завершаем сеанс сеанс cURL
    return $data;//возвращаем код страницы из $url в виде строки
}
//получаем содержимое страницы ввиде строки

$url_token = "https://online.moysklad.ru/api/remap/1.2/security/token";
$log_pas_64 = base64_encode("admin@coolkudry:K12569101");
$header = ["Authorization: Basic $log_pas_64"];


//$test = curl($url_token, $header);//генерируем токен

//print_r($test);



$url_assortment = "https://online.moysklad.ru/api/remap/1.2/entity/assortment";
$token = "bcd6fc0a132b992ba6ca1cc02b533ac049ef3790";
$header_token = ["Authorization: Bearer $token"];


/*
$order_data = '{
            "name": "00003",
            "organization": {
              "meta": {
                "href": "https://online.moysklad.ru/api/remap/1.2/entity/organization/8c3308b2-3c8b-11ec-0a80-0942000ae312",
                "type": "organization",
                "mediaType": "application/json"
              }
            },
            "agent": {
              "meta": {
                "href": "https://online.moysklad.ru/api/remap/1.2/entity/counterparty/8cdf7f49-3c8b-11ec-0a80-0942000ae337",
                "type": "counterparty",
                "mediaType": "application/json"
              }
            }
          }';

        $test_2 = '{
            "name": "000034",
            "shared": false,
            "organization": {
              "meta": {
                "href": "https://online.moysklad.ru/api/remap/1.2/entity/organization/8c3308b2-3c8b-11ec-0a80-0942000ae312",
                "type": "organization",
                "mediaType": "application/json"
              }
            },
            "code": "1243521",
            "moment": "2016-04-19 13:50:24",
            "applicable": false,
            "vatEnabled": false,
            "agent": {
              "meta": {
                "href": "https://online.moysklad.ru/api/remap/1.2/entity/counterparty/8cdf7f49-3c8b-11ec-0a80-0942000ae337",
                "type": "counterparty",
                "mediaType": "application/json"
              }
            },
            "shipmentAddressFull":{  
              "postalCode":"125009",
              "country":{  
                "meta":{  
                  "href":"https://online.moysklad.ru/api/remap/1.2/entity/country/9df7c2c3-7782-4c5c-a8ed-1102af611608",
                  "metadataHref":"https://online.moysklad.ru/api/remap/1.2/entity/country/metadata",
                  "type":"country",
                  "mediaType":"application/json"
                }
              },
              "region":{  
                "meta":{  
                  "href":"https://online.moysklad.ru/api/remap/1.2/entity/region/00000000-0000-0000-0000-000000000077",
                  "metadataHref":"https://online.moysklad.ru/api/remap/1.2/entity/region/metadata",
                  "type":"region",
                  "mediaType":"application/json"
                }
              },
              "city":"Москва",
              "street":"ул Тверская",
              "house":"1",
              "apartment":"123",
              "addInfo":"addinfo",
              "comment":"some words about address"
            }
          }';


$curl = curl_init();//инициальзируем новый сеанс cURL
curl_setopt($curl, CURLOPT_URL, "https://online.moysklad.ru/api/remap/1.2/entity/customerorder");//переход по требуемому url

curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token", "Content-Type: application/json"]);



    curl_setopt($curl, CURLOPT_POST, true);


curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );//true для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);//true для следования любому заголовку "Location: ", отправленному сервером в своём ответе

curl_setopt($curl, CURLOPT_POSTFIELDS, $test_2);

$data = curl_exec($curl);//выполняем запрос cURL
curl_close($curl);//завершаем сеанс сеанс cURL


print_r($data);
*/

$assortment = curl($url_assortment, $header_token, "GET");
//file_put_contents("D:\OpenServer\domains\shop.loc\wp-content/themes\serge_produkt/data_test/assortment_2.json", $assortment);




$assortment = json_decode($assortment);
//produkt_insert($assortment->rows);//записываем и обновляем товары в базе данных, $assortment->rows это массив с объектами всех товаров

//produkt_post_insert();

//создаёт или обновляет посты (страницы) товаров
function produkt_post_insert(){

    $item = array(
        //'ID'             => <post id>,                                                     // Вы обновляете существующий 
        'post_name'      => 'chpu_name',// Альтернативное название записи (slug) будет использовано в УРЛе.
        //'post_parent'    => <post ID>,                                                     // ID родительской записи, если нужно.                                                           // Пароль для просмотра записи.
        'post_status'    => 'draft',// Статус создаваемой записи.                                                 // Заголовок (название) записи.
        'post_type'      => 'product', // Тип записи.                                // Метки поста (указываем ярлыки, имена или ID).
        //'tax_input'      => array( 'taxonomy_name' => array( 'term', 'term2', 'term3' ) ), // К каким таксам прикрепить запись (указываем ярлыки, имена или ID).                                                          //?
        //'meta_input'     => [ 'meta_key'=>'meta_value' ],                             // добавит указанные мета поля. По умолчанию: ''. с версии 4.4.
    );
    wp_insert_post(  wp_slash($item));
}
//создаёт или обновляет посты (страницы) товаров

//записываем данные товаров в базу
function produkt_insert($data){
    global $wpdb;

    //перебирам все товары из $data = $assortment->rows
    foreach($data as $produkt){

        if(!isset($produkt->attributes)){ continue; }//если у данного товара не указаны атрибуты то мы его пропускаем

        $add_in_shop = null;//нужно ли добавлять данный товар в магазин
        $name = null;//название товара
        $description = null;//описание товара
        $marka = null;//марка
        $model = null;//модель
        $komplekt = null;//является ли данный овар комплектом

        //перебираем массив $produkt->attributes
        foreach($produkt->attributes as $attribut){

            if($attribut->name === "Экспорт в магазин"){
                $add_in_shop = $attribut->value;//проверяем нужно ли добавлять данный товар в магазин
                if($add_in_shop === false){ break;}//если товар не нужно добавлять в магазин пропускаем дальнейшиее действия
            }

            if($attribut->name === "Текст для ссылки товара"){
                $chpu = $attribut->value;//текст для чпу сслки товара
            }
            
            if($attribut->name === "Марка"){
                $marka = $attribut->value;//марка товара
            }

            if($attribut->name === "Модель"){
                $model = $attribut->value;//модель товара
            }

            if($attribut->name === "Комплект"){
                $komplekt_status = $attribut->value;//является ли данный товар комплектом
                $komplekt = $komplekt_status ? "yes" : "no";
            }

            if($attribut->name === "Описание"){
                $description = $attribut->value;//описание товара
            }
        }
        //перебираем массив $produkt->attributes

        $name = $produkt->name;//название товара 

        $mc_id = $produkt->id;//id товара в МС
        
        $sale_prices = $produkt->salePrices[0]->value/100;//цена продажи в руб

        $last_update = strtotime($produkt->updated);//дата последнего обновления данных данного товара в МС

        $tovar = $wpdb->get_row("SELECT * FROM wp_ksn_shop_products WHERE mc_id = '$mc_id'");//данный товар в базе данных

        //если данного товара ещё нет в базе
        if(!isset($tovar)){
            //записываем новую строку в базу данных
            $wpdb->insert( 'wp_ksn_shop_products', [
                'mc_id' => $mc_id, 
                'nead_update' => 'yes',
                'name' => $name, 
                'description' => $description, 
                'prices' => $sale_prices, 
                'last_update' => $last_update, 
                'marka' => $marka, 
                'model' => $model, 
                'komplekt' => $komplekt 
            ]);
            //записываем новую строку в базу данных
        }
        //если данного товара ещё нет в базе

        //товар есть в базе
        else {
            if($tovar->last_update == $last_update){ continue; }//если дата последнего обновления товара не изменилась то ничего не обновляем в базе данных
        
            //обновляем запись в базе данных
            $wpdb->update( 'wp_ksn_shop_products', [
                'mc_id' => $mc_id, 
                'nead_update' => 'yes',
                'name' => $name, 
                'description' => $description, 
                'prices' => $sale_prices, 
                'last_update' => $last_update, 
                'marka' => $marka, 
                'model' => $model, 
                'komplekt' => $komplekt 
                ],
                ['mc_id' => $mc_id]
            );
            //обновляем запись в базе данных
        }
        //товар есть в базе
    }
    //перебирам все товары из $data = $assortment->rows
}
//записываем данные товаров в базу


//echo strtotime("2021-11-03 13:02:26.169");




/*
if ( isMobile() ) {
    echo "мобильный";
} elseif(isTablet()){
    echo "планшетный";
} elseif(isDesktop()){
    echo "пк";
}

echo "<br>";
*/
