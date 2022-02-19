<?php
namespace KsnPlugin\core;

use KsnPlugin\KsnPlugin;

class Main_Func {

    public static $redis_connect = null;//тут будет сохранено соединение с redis

    public function __construct(){
        add_action( 'wp_ajax_save_new_settings', [$this, 'ksn_site_settings_update'] );
    }

    public static $added_func_data = [];//сюда будут записываться методы модулей для вызова из класса Main_Func которые в нём не определены

    //срабатывает когда вызывается неопределённые метод, $method - имя метода (функции), $arguments - агруметы (параметры) переданные этой функции
    public function __call($method, $arguments){
        if (isset(self::$added_func_data[$method])){//проверяем записан ли этот метод в наш список методов модулей
            $class = new self::$added_func_data[$method];//создаём экземпляр класса содержащего этот метод
            call_user_func_array([$class, $method], $arguments);//вызываем метод с агрументами
        }
    }
    //срабатывает когда вызывается неопределённые метод, $method - имя метода (функции), $arguments - агруметы (параметры) переданные этой функции

    //перебирает ассоциативный массив с кучей уровней вложенности и возвращает обычный массив со значениями взятыми из значений переданного ассоциативного массива
    public function asociativ_array_to_index_array($asociativ_array, $result_array = []){
        //перебираем массив
        foreach($asociativ_array as $item){
            //если элемент массива это ещё один массив
            if(gettype($item) === "array"){
                $result_array = $this->asociativ_array_to_index_array($item, $result_array);//присваем результирующему массиву значение которое вернула рекурсивно вызванная функция
            }
            //если элемент массива это ещё один массив

            //если элемента массив строковое занчение
            else {
                array_push($result_array, $item);//записываем заначение в массив результата
            }
            //если элемента массив строковое занчение
        }
        //перебираем массив
        return $result_array;//возвращаем наш обычный массив со значениями
    }
    //перебирает ассоциативный массив с кучей уровней вложенности и возвращает обычный массив со значениями взятыми из значений переданного ассоциативного массива

    //создаём подключение к редису
    public function connect_redis(){
        if(!is_null(self::$redis_connect)){
           return self::$redis_connect;
        }
        $redis = new \Redis();//содаём новый объект редиса
        $redis->connect('localhost', 6379);//подключаемся к редису
        self::$redis_connect = $redis;
        return self::$redis_connect; //вернём объект редиса
    }
    //создаём подключение к редису

    //удаляем и редиса ненужные данные
    public function del_redis($data, $hash = null){
        if($data === null){ return; };
        $redis = $this->connect_redis();//подключаемся к редису
        $type = gettype($data);//проверяем тип данных

        //если задана хеш таблица
        if($hash){
            if($type === "string"){
                $redis->hDel("$hash", "$data");
            } else if($type === "array"){
                foreach($data as $key => $value){
                    if(gettype($key) === "integer"){
                        $redis->hDel("$hash", "$value");//для обычногого массива значений
                    } else {
                        $redis->hDel("$hash", "$key");//для ассоциативного массива с нецифровыми индексами
                    }
                }
            }
            return;
        }
        //если задана хеш таблица

        if($type === "string"){
            $redis->del("$data");
        } else if($type === "array"){
            foreach($data as $key => $value){
                if(gettype($key) === "integer"){
                    $redis->del("$value");//для обычногого массива значений
                } else {
                    $redis->del("$key");//для ассоциативного массива с нецифровыми индексами
                }
            }
        }
    }
    //удаляем и редиса ненужные данные

    //записываем новые значения в редис
    public function set_redis($data, $hash = null){
        if($data === null){ return; };
        $redis = $this->connect_redis();//подключаемся к редису

        //если задана хеш таблица
        if($hash){
            foreach($data as $key => $value){
                $redis->hSet("$hash", $key, $value);
            }
            return;
        }
        //если задана хеш таблица

        foreach($data as $key => $value){
            $redis->set("$key", $value);
        }
    }
    //записываем новые значения в редис

    //получаем занчения из редис
    public function get_redis($data, $hash = null){
        if($data === null){ return false; };
        $redis = $this->connect_redis();//подключаемся к редису
        $type = gettype($data);//проверяем тип данных

        //если задана хеш таблица
        if($hash){
            if($type === "string"){
                $result = $redis->hGet("$hash", "$data");
                if($result !== false){
                    return $result;
                } else {
                    return false;
                }
            } else if($type === "array"){
                $data_for_return = [];
                foreach($data as $key => $value){
                    if(gettype($key) === "integer"){//для обычногого массива значений
                        $result = $redis->hGet("$hash", "$value");
                        if($result !== false){
                            array_push($data_for_return, $result);
                        } else {
                            return false;
                        }
                    } else {//для ассоциативного массива с нецифровыми индексами
                        $result = $redis->hGet("$hash", "$key");
                        if($result !== false){
                            array_push($data_for_return, $result);
                        } else {
                            return false;
                        }
                    }
                }
                return $data_for_return;
            }
        }
        //если задана хеш таблица

        if($type === "string"){
            $result = $redis->get("$data");
            if($result !== false){
                return $result;
            } else {
                return false;
            }
        } else if($type === "array"){
            $data_for_return = [];
            foreach($data as $key => $value){
                if(gettype($key) === "integer"){//для обычногого массива значений
                    $result = $redis->get("$value");
                    if($result !== false){
                        array_push($data_for_return, $result);
                    } else {
                        return false;
                    }
                } else {//для ассоциативного массива с нецифровыми индексами
                    $result = $redis->get("$key");
                    if($result !== false){
                        array_push($data_for_return, $result);
                    } else {
                        return false;
                    }
                }
            }
            return $data_for_return;
        }
    }
    //получаем занчения из редис

    //записываем все url страниц и записей в файл page_list.json
    public function create_page_list(){
        global $wpdb;
        $table_name = $wpdb->prefix.'posts';
        $result_data = [
            'page' => [],
            'post' => []
        ];
        $post_typs = ['page', 'post'];
        foreach($post_typs as $type){
            $query = $wpdb->get_results( "SELECT id FROM $table_name WHERE post_type = '$type' AND post_status = 'publish'", ARRAY_A);
            foreach($query as $item){
                $url = get_permalink($item['id']);

                //если родитель в корзине
                if(stripos($url, "__trashed") !== false){ 
                    //$url = str_replace("__trashed", "", $url);
                }
                //если родитель в корзине

                array_push($result_data[$type], $url);
            }
        }
        $data = json_encode($result_data, JSON_UNESCAPED_SLASHES);
        file_put_contents(KSN_PLAGIN_DIR.'/data/page_list.json', $data);
    }
    //записываем все url страниц и записей в файл page_list.json

    //функция отвечает за действия с файлом advanced-cache.php в папке wp-content
    public function advanced_cache_fill_action($action){
        $file = untrailingslashit( WP_CONTENT_DIR ) . '/advanced-cache.php';//находим файл advanced-cache.php

        //команда на удаление файла advanced-cache.php
        if($action === "delete"){
            $del_result = unlink($file) ? true : false;
            return $del_result;//в случае успешного удаления функция вернёт true, если произошла ошибка то false
        }
        //команда на удаление файла advanced-cache.php

        //команда на создание файла advanced-cache.php
        if($action === "create"){

            //содержимое для файла advanced-cache.php
            $content = '<?php ' .
            "\r\n" . "defined( 'ABSPATH' ) || exit;" .
            "\r\n" . "require_once __DIR__ . '/plugins/ksn_site_control/moduls/caching/base/ksn_advanced_cache.php';";
            //содержимое для файла advanced-cache.php

            $create_result = file_put_contents( $file, $content ) ? true : false;
            return $create_result;//в случае успешной записи/создания-записи файла advanced-cache.php вернёт true если была ошибка записи/создания вернёт false

        }
        //команда на создание файла advanced-cache.php
    }
    //функция отвечает за действия с файлом advanced-cache.php в папке wp-content

    //функция заменяет код в файле wp-config.php
    //$target - то что ищем для замены
    //$replacement - то на что заменяем, если пусто то найденная строка $target будет просто удалена
    public function wp_config_fill_edit($target, $replacement = null){
        $file = untrailingslashit( ABSPATH ). '/wp-config.php';//находим файл wp-config.php
        $config_file_string = file_get_contents( $file );//получаем содержимое файла wp-config.php в виде строки
        $config_file = preg_split( "/\n/", $config_file_string );//полученное строковое выражение config_file_string мы забиваем на части (разделителем будет выступать перенос строки \n) в итоге в переменно й config_file мы получим массив состоящий из всех строк файла wp-config.php
        $line_key = false;//ставим что по умолчанию нужной строки нет

        //перебираем полученный массив config_file чтоб найти индекс массива который соответствует искомому значению
        foreach ( $config_file as $key => $line ) {
            if ( !stripos( $line, $target) ) {//проверяем строку на наличиие искомого target содержимого
                continue;// если нет соответствий то идём дальше
            } else {
                $line_key = $key;
            }
        }
        //перебираем полученный массив config_file чтоб найти индекс массива который соответствует искомому значению

        //если нужная строка была найдена то мы удаляем её
        if ($line_key !== false) {
            unset( $config_file[ $line_key ] );//удаляем элемент массива по ключу
        }
        //если нужная строка была найдена то мы удаляем её

        //если есть что перезаписывать
        if($replacement !== null){
            array_shift( $config_file );//удаляем первый элемент массива config_file т.е. строку содержащую <?php
            array_unshift( $config_file, '<?php', $replacement );//добавляем в начало массива две строки
        }
        //если есть что перезаписывать

        file_put_contents($file, implode( "\n", $config_file ));//implode обыединяем элементы массива config_file в строку добавив между каждым из них \n перенос строки и записываем полученый результат в файл wp-config.php
    }
    //функция заменяет код в файле wp-config.php

    //получаем заначение поля data из базы данных по названию настройки $setting
    public function object_foreach($object, $setting, $target, $val){
        foreach($object as $key => $value){
            if($key == $setting){
                //echo $value." то что ищем";
                if($target == "get_val"){
                    return $value;
                } else if($target == "set_val"){
                    $object->$setting = $val;
                }
                
            } else if(gettype($value) == "object"){
                if($target == "get_val"){
                    $result = $this->object_foreach($value, $setting, $target, '');
                    if(!empty($result)){
                        return $result;
                    }
                } else if($target == "set_val"){
                    $this->object_foreach($value, $setting, $target, $val);
                }
            }
        }
    }

    public function get_ksn_site_settings_data($setting_grup, $setting){
        global $wpdb;
        $table_name = KSN_DB_TABLE;
        $query_result_data = json_decode($wpdb->get_var( "SELECT data FROM $table_name WHERE setting_name = '$setting_grup'" ));
        $result = $this->object_foreach($query_result_data, $setting, "get_val", "");
        return $result;
    }
    //получаем заначение поля data из базы данных по названию настройки $setting

    //задаём заначение поля data из базы данных по названию настройки $setting
    public function set_ksn_site_settings_data($setting_grup, $setting, $value){
        global $wpdb;
        $table_name = KSN_DB_TABLE;
        $data_in_bd = $wpdb->get_var( "SELECT data FROM $table_name WHERE setting_name = '$setting_grup'" );//берём все настройки для данного блока настроек из базы
        $data_in_bd = json_decode($data_in_bd); //переводим из json в объект
        $this->object_foreach($data_in_bd, $setting, "set_val", $value); //меняем в настройках заначение изменённых параметров настроек
        $data_in_bd = json_encode($data_in_bd); //переводим данные снова в формат json
        $wpdb->update( $table_name, ['data' => $data_in_bd], ['setting_name' => $setting_grup], ['%s'], ['%s'] );//обновляем данные данного блока настроек в бд
    }
    //задаём заначение поля data из базы данных по названию настройки $setting

    //Ajax отправка данных на сервер для сохранения новых настроек в базе данных
    public function ksn_site_settings_update(){

        //если сейчас идёт кеширование сообщаем об этом пользователю без сохранения настроек
        if($this->get_redis("ksn_planned_caching") === "yes"){
            wp_die(json_encode(["process_caching_now" => "planned"]));
        }

        if($this->get_redis("ksn_user_init_caching") === "yes"){
            wp_die(json_encode(["process_caching_now" => "user"]));
        }
        //если сейчас идёт кеширование сообщаем об этом пользователю без сохранения настроек

        $data = stripslashes_deep($_POST['data']);//переданные данные в массиве data так же убираем экранирующие слеши
        $dop_func = stripslashes_deep($_POST['func']);
        $update_result = $this->updata_settings_in_bd($data, $dop_func);//запускаем обновление данных в базе и выполнение доп функций
        wp_die(json_encode($update_result)); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
    }
    //в __constructor
    //Ajax отправка данных на сервер для сохранения новых настроек в базе данных

    //настройки изменение которых необходимо отслеживать для поддержания актуальной кешированной версии сайта
    public $monitoring_data = [
        "site_settings" => [ 
            "site_mobile_version",
            "site_tablet_version",
            "retina_active", 
            "bg_color", 
            "text_color" 
        ],
        "seo" => [ 
            "google_check" => [
                "active" => "google_analitica_active", 
                "mast_have_data" => "google_analitica_id",
                "dop_monitiring_settings" => [
                    "google_lazy_load"
                ]
            ],
            "google_verefi_string", 
            "yandex_check" => [
                "active" => "yandex_metrika_active", 
                "mast_have_data" => "yandex_metrika_id",
                "dop_monitiring_settings" => [
                    "yandex_metrika_webvisor",
                    "yandex_lazy_load"
                ]
            ],
            "yandex_verefi_string", 
            "facebook_check" => [
                "active" => "facebook_pixel_active", 
                "mast_have_data" => "facebook_pixel_id",
                "dop_monitiring_settings" => [
                    "facebook_lazy_load"
                ]
            ],
            "vk_check" => [
                "active" => "vk_pixel_active", 
                "mast_have_data" => "vk_pixel_id",
                "dop_monitiring_settings" => [
                    "vk_lazy_load"
                ]
            ],
            "geo_meta_data" 
        ],
        "security" => [],
        "cache" => [],
        "integrations" => [
            "online_chat_active",
            "online_chat_id"
        ],
        "dop_options" => [
            "update_css_js"
        ]
    ];
    //настройки изменение которых необходимо отслеживать для поддержания актуальной кешированной версии сайта

    //данная функция обновляет кишированные настройки в базе данных
    public function updata_caching_settings_in_bd(){
        $monitoring_data = $this->monitoring_data;//настройки изменение которых необходимо отслеживать для поддержания актуальной кешированной версии сайта
        //перебираем ассоциативный массив с отслеживаемыми настройками
        foreach($monitoring_data as $grup => $settings_block){
            $all_settings_in_grup = $this->asociativ_array_to_index_array($settings_block);//для каждой группы настроек получаем обычный массив с названием настроек

            //перебираем массив с названиями настроек для текущей группы
            foreach($all_settings_in_grup as $setting){
                $value = $this->get_ksn_site_settings_data($grup, $setting);//получаем текущее заначение из базы данных
                $this->set_ksn_site_settings_data("cache", $setting, $value);//записываем новое занчение в кешированную версию настроек
            }
            //перебираем массив с названиями настроек для текущей группы
        }
        //перебираем ассоциативный массив с отслеживаемыми настройками
        $this->set_ksn_site_settings_data("cache", "settings_update", "no");//записываем что не нужнео пересоздавать кеш и все настройки актуальны
    }
    //данная функция обновляет кишированные настройки в базе данных

    //обновляем данные в базе
    public function updata_settings_in_bd($data, $dop_func = null){
        $monitoring_data = $this->monitoring_data;//настройки изменение которых необходимо отслеживать для поддержания актуальной кешированной версии сайта

        //перебираем массив data, и обновляем нужные настройки новыми значениями
        foreach($data as $key => $item){
            //перебираем массив с настройками для изменения для данного блока настроек
            foreach($item as $setting => $value){
                $this->set_ksn_site_settings_data($key, $setting, $value); //меняем в настройках заначение изменённых параметров настроек

                //если переданно что нужно включить доп функции
                if(!empty($dop_func)){
                    //перебираем массив с доп функциями и ищем ту которая предназначенна для данной $setting настройки
                    foreach($dop_func as $key_s => $func){
                        if($key_s === $setting){
                            KsnPlugin::$instance->main_func->$func($value);//выполняем функцию пердав в неё занчении данной настройки
                        }
                    }
                    //перебираем массив с доп функциями и ищем ту которая предназначенна для данной $setting настройки
                }
                //если переданно что нужно включить доп функции
            }
            //перебираем массив с настройками для изменения для данного блока настроек
        }
        //перебираем массив data, и обновляем нужные настройки новыми значениями

        //перебираем массив с отслеживаемыми настройками чтоб понять какие из них были изменены
        foreach($monitoring_data as $grup => $settings){
            foreach($settings as $key => $item){

                //если текущий элемент массива это ещё один массив с данными
                if(gettype($item) === "array"){

                    //проверяем включена или выключена настройка после этого сохранения настроек
                    $new_active_status = ($this->get_ksn_site_settings_data($grup, $item["active"]) === "yes" && !empty($this->get_ksn_site_settings_data($grup, $item["mast_have_data"]))) ? "yes" : "no";
                    //проверяем включена или выключена настройка после этого сохранения настроек

                    //проверяем включена или выключена настройка в кешированной версии настроек
                    $old_active_status = ($this->get_ksn_site_settings_data("cache", $item["active"]) === "yes" && !empty($this->get_ksn_site_settings_data("cache", $item["mast_have_data"]))) ? "yes" : "no";
                    //проверяем включена или выключена настройка в кешированной версии настроек

                    //если состояние включения настройки отличается от сохраннённых кешированных настроек, не важно включена или выключена
                    if($new_active_status !== $old_active_status){
                        $this->set_ksn_site_settings_data("cache", "settings_update", "yes");//записываем новое значение в базу
                        return ["cache_need_to_update" => ["settings_update" => "yes"]];//возвращаем функцией что кеш нужно обновить
                    }
                    //если состояние включения настройки отличается от сохраннённых кешированных настроек, не важно включена или выключена

                    //если настройка включена и в кешированной версии настроек она тоже включена, то проверяем доп настройки которые влияют на кешированную версию на изменение
                    if($new_active_status === $old_active_status && $new_active_status === "yes"){
                        //проверяем есть ли массив с дополнительными настройками которые влияют на кешированную версию страниц
                        if ($item["dop_monitiring_settings"]) {
                            //перебираем массив с дополнительными настройками
                            foreach($item["dop_monitiring_settings"] as $value){
                                //если была кешировна включённая метрика то проверям дополнительные настройки на изменение
                                if($this->get_ksn_site_settings_data("cache", $value) != $this->get_ksn_site_settings_data($grup, $value)){
                                    $this->set_ksn_site_settings_data("cache", "settings_update", "yes");//записываем новое значение в базу
                                    return ["cache_need_to_update" => ["settings_update" => "yes"]];//возвращаем функцией что кеш нужно обновить
                                }
                                //если была кешировна включённая метрика то проверям дополнительные настройки на изменение
                            }
                            //перебираем массив с дополнительными настройками
                        }
                        //проверяем есть ли массив с дополнительными настройками которые влияют на кешированную версию страниц
                    }
                    //если настройка включена и в кешированной версии настроек она тоже включена, то проверяем доп настройки которые влияют на кешированную версию на изменение
                }
                //если текущий элемент массива это ещё один массив с данными

                //если текущий элемент массива это строка с названием отслежимваемой настройки
                else {
                    $value_new = $this->get_ksn_site_settings_data($grup, $item);//текущее значение которое установил пользователь
                    $value_old = $this->get_ksn_site_settings_data("cache", $item);//значение которое было использованно при последнем создании кеша

                    //если старое занчение и новое не совпадают, прерываем функцию и записываем в базу что нужно обновить кеш
                    if($value_new != $value_old){
                        $this->set_ksn_site_settings_data("cache", "settings_update", "yes");//записываем новое значение в базу
                        return ["cache_need_to_update" => ["settings_update" => "yes"]];//возвращаем функцией что кеш нужно обновить
                    }
                    //если старое занчение и новое не совпадают, прерываем функцию и записываем в базу что нужно обновить кеш
                }
                //если текущий элемент массива это строка с названием отслежимваемой настройки
            }
        }
        //перебираем массив с отслеживаемыми настройками чтоб понять какие из них были изменены

        $this->set_ksn_site_settings_data("cache", "settings_update", "no");//если все новые занчения настроек такие же как и те что использовались при последнем сохранении, значет пользователь вернул настройки в прежднеее состояние и нет смысла обновлять кеш, записываем это в базу
        return ["cache_need_to_update" => ["settings_update" => "no"]];//возвращаем функцией что кеш обновлять не нужно
    }
    //обновляем данные в базе

    //обновляет все настройки в базе данных опираясь на файл settings.json
    public function update_database_table(){
        global $wpdb;
        $table_name = KSN_DB_TABLE;
        $all_settings = json_decode(file_get_contents(KSN_PLAGIN_DIR."/data/settings.json"), true);//файл json с настройками по умолчанию
        $old_grups = $wpdb->get_col( "SELECT setting_name FROM $table_name" );//берём все группы настроек из базы данных
        $new_grups = [];//новые группы настроек

        foreach($all_settings as $grup => $settings){ array_push($new_grups, $grup); }//заполняем новые группы настроек

        $deleted_grups = array_diff($old_grups, $new_grups);//группы которые удалены в новых натсройках и их нужно удалить из базы
        $added_grups = array_diff($new_grups, $old_grups);//группы которые нужно добавить в базу с новыми настройками
        $nead_check_chenge_grups = array_diff($new_grups, $added_grups);//группы в которых нужно проверить наличие всех настроек

        foreach($deleted_grups as $grup){ $wpdb->delete( $table_name, [ 'setting_name' => $grup ] ); }//удаляем из базы группы настроек которые уже не нужны

        //добавляем в базу новые группы настроек
        foreach($added_grups as $grup){
            $data_insert = json_encode($all_settings[$grup]);//переводим данные в формат json
            $wpdb->insert( $table_name, [ 'setting_name' => $grup, 'data' => $data_insert ] );//вставляем новую строку в базу данных
        }
        //добавляем в базу новые группы настроек

        function check_chenge($old_data, $new_data, $result = []){
            $new_settings_name = [];//имена новых настроек

            foreach($new_data as $name => $settings){ array_push($new_settings_name, $name); }//имена новых настроек

            //перебираем все имена новых настроек, те настройки которые были в старых данных но не были в новых не записываются в итоговый результат
            foreach($new_settings_name as $settings_name){

                //если данной новой настройки ещё не было в старых настройках то мы записываем в результат значение новой настройки и пропускаем все дальнейшие действия длоя данной итерации
                if (!array_key_exists($settings_name, $old_data)) {
                    $result[$settings_name] = $new_data[$settings_name];
                    continue;
                }
                //если данной новой настройки ещё не было в старых настройках то мы записываем в результат значение новой настройки и пропускаем все дальнейшие действия длоя данной итерации

                $new_setting_type = gettype($new_data[$settings_name]);//какой тип содержимого у старой настройки
                $old_setting_type = gettype($old_data[$settings_name]);//какой тип содержимого у новой настройки

                //если тип содержимого старой и новой настройки одинаковый и строчный то мы записываем старое значение настройки в результат
                if(($new_setting_type === $old_setting_type) && ($new_setting_type === "string")){
                    $result[$settings_name] = $old_data[$settings_name];
                }
                //если тип содержимого старой и новой настройки одинаковый и строчный то мы записываем старое значение настройки в результат

                //если тип содержимого старой и новой настройки разный то мы записываем в результат значение новой настройки
                if($new_setting_type !== $old_setting_type){
                    $result[$settings_name] = $new_data[$settings_name];
                }
                //если тип содержимого старой и новой настройки разный то мы записываем в результат значение новой настройки

                //если тип содержимого старой и новой настройки одинаковый и и это массив то запускаем функцию check_chenge рекурсивно
                if(($new_setting_type === $old_setting_type) && ($new_setting_type === "array")){
                    $old_inner_data = $old_data[$settings_name];//старые данные для данной настройки
                    $new_inner_data = $new_data[$settings_name];//новые данные для данной настройки
                    $result[$settings_name] = check_chenge($old_inner_data, $new_inner_data);//запускаем функцию рекурсивно с новыми параметрами и результат записываем
                }
                //если тип содержимого старой и новой настройки одинаковый и и это массив то запускаем функцию check_chenge рекурсивно

            }
            //перебираем все имена новых настроек, те настройки которые были в старых данных но не были в новых не записываются в итоговый результат

            return $result;//возвращаем новый сформированный блок настроек
        }

        //перебираем все группы для проверок для получения новых и старых значений для дальнейшей замены старых значений на новые
        foreach($nead_check_chenge_grups as $grup){
            $old_data = json_decode($wpdb->get_var( "SELECT data FROM $table_name WHERE setting_name = '$grup'" ), true);//старые настройки данной группы
            $new_data = $all_settings[$grup];//новые настройки данныой группы
            $result = json_encode(check_chenge($old_data, $new_data));//переводим данные в формат json
            $wpdb->update( $table_name, [ 'data' => $result], [ 'setting_name' => $grup ]);//обновляем настройки в базе данных
        }
        //перебираем все группы для проверок для получения новых и старых значений для дальнейшей замены старых значений на новые   
    }
    //обновляет все настройки в базе данных опираясь на файл settings.json
    //update_database_table();

    //функция получает точную последовательную ссылку без ?=id в адресе
    public function get_accurate_permalink( $post_id ) {
        require_once ABSPATH . '/wp-admin/includes/post.php';
        list( $permalink, $postname ) = get_sample_permalink( $post_id );
        $post_type = get_post_type( $post_id );

        if($post_type === "page"){
            return str_replace( '%pagename%', $postname, $permalink );//для страниц
        }

        if($post_type === "post"){
            return str_replace( '%postname%', $postname, $permalink ); //для записей
        }
    }
    //функция получает точную последовательную ссылку без ?=id в адресе

    //$type - тип элемента ввода данных настройки, переключатель - switch, строка input - string, текстовое поле - textarea, поле выбора цвета - color
    //$setting_grup - группа к которой относится данная настройка в базе данных site_settings, seo, security, cache, integrations, dop_options
    //$setting_name - название данной настрйоки в базе данных, retina_active, bg_color и т.д.
    //$dop_func - название функции котрая будет вызвана в момент сохранения данной настройки
    //$must_have_for_active - указывает обязательна ли данная настройка для активации всего блока данной настройки
    //$placeholder - текст плейсхолдера для настроек типа string и textarea
    //$no_triger_active - если true то данная настрйока будет без галочки авктивности
    public function setting_output_code($type, $setting_grup, $setting_name, $dop_func = null, $must_have_for_active = true, $placeholder = null){
        global $wpdb;
        $table_name = KSN_DB_TABLE;//наша таблица в бд
        $value = $this->get_ksn_site_settings_data($setting_grup, $setting_name);//получаем значение настройки из бд

        if(gettype($type) === "string"){
            $control = $type;
        } else {
            $control = $type[0];
            $dop_class = $type[1];

            if(array_key_exists(2, $type)){
                $dop_data = $type[2];
            }
        }

        if($control == 'switch'){
            $checked = $this->get_ksn_site_settings_data($setting_grup, $setting_name) == "yes" ? "checked" : null;
        ?>
            <label class="switch" for="<?php echo $setting_name; ?>">
                    <input class="switch_input<?php if($must_have_for_active){echo " must_have_for_active";} ?>" data-grup="<?php echo $setting_grup; ?>" <?php if(!empty($dop_func)){ ?> data-dop-func="<?php echo $dop_func; ?>"<?php } ?> type="checkbox" id="<?php echo $setting_name; ?>" <?php echo $checked; ?> <?php if(!empty($dop_data)){ echo $dop_data; } ?> >
                    <span class="slider round"></span>
                    <span class="switch_yes">Да</span>
                    <span class="switch_no">Нет</span>
            </label>
        <?php }

        if($control == 'string'){ ?>
            <input class="<?php if($must_have_for_active){echo " must_have_for_active";} ?><?php if(!empty($dop_class)){ echo " ".$dop_class."";} ?>"<?php if(!empty($placeholder)){ ?> placeholder="<?php echo $placeholder; ?>"<?php } ?> data-grup="<?php echo $setting_grup; ?>" <?php if(!empty($dop_func)){ ?> data-dop-func="<?php echo $dop_func; ?>"<?php } ?> type="text" id="<?php echo $setting_name; ?>" value="<?php echo $value; ?>" <?php if(!empty($dop_data)){ echo $dop_data; } ?> >
        <?php }

        if($control == 'number'){ ?>
            <input class="<?php if($must_have_for_active){echo " must_have_for_active";} ?><?php if(!empty($dop_class)){ echo " ".$dop_class."";} ?>"<?php if(!empty($placeholder)){ ?> placeholder="<?php echo $placeholder; ?>"<?php } ?> data-grup="<?php echo $setting_grup; ?>" <?php if(!empty($dop_func)){ ?> data-dop-func="<?php echo $dop_func; ?>"<?php } ?> type="number" id="<?php echo $setting_name; ?>" value="<?php echo $value; ?>" <?php if(!empty($dop_data)){ echo $dop_data; } ?> >
        <?php }

        if($control == 'textarea'){ ?>
            <textarea class="<?php if($must_have_for_active){echo " must_have_for_active";} ?>"<?php if(!empty($placeholder)){ ?> placeholder="<?php echo $placeholder; ?>"<?php } ?> data-grup="<?php echo $setting_grup; ?>" <?php if(!empty($dop_func)){ ?> data-dop-func="<?php echo $dop_func; ?>"<?php } ?> type="text" id="<?php echo $setting_name; ?>" <?php if(!empty($dop_data)){ echo $dop_data; } ?> /><?php echo $value; ?></textarea>
        <?php }

        if($control == 'color'){ ?>
            <input class="<?php if($must_have_for_active){echo " must_have_for_active";} ?>" data-grup="<?php echo $setting_grup; ?>" <?php if(!empty($dop_func)){ ?> data-dop-func="<?php echo $dop_func; ?>"<?php } ?> id="<?php echo $setting_name; ?>" type="text" value="<?php echo $value; ?>" >
        <?php }
    }
    //вывод страницы настроек плагина в админке вордпресса
}



?>