<?php 
namespace KsnPlugin\moduls\caching\base;

use KsnPlugin\KsnPlugin;
use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Functions extends Plagin_Moduls_Meneger{

	public function __construct(){
		add_filter( 'cron_schedules', [$this, 'cron_add_new_interval'] );//интервал планового кеширования
		add_action( 'caching_and_new_page_list', [$this, 'planed_caching_and_new_page_list']);//плановое кеширование
		add_action( 'wp_ajax_do_cache', [$this, 'ajax_caching_all_pages'] );//запуск кеширования после нажатия кнопки начать кеширование
		add_action( 'wp_ajax_cache_current_progres', [$this, 'ksn_cache_page_progress'] );//проверяем прогресс выполнения кеширования файлов и отправляем данные клиенту
		add_action( 'wp_ajax_abort_caching', [$this, 'ksn_abort_caching'] );//прерывание кеширования
		add_action( 'save_post', [$this, 'caching_page'], 10, 3 );//запуск пересоздания страницы при обновлении её контента или удаляем при помещенни в корзину
		add_action( 'before_delete_post', [$this, 'delete_cache'] );//в момент удаления записи из корзины (на всегда), чистим файлы кеша и переносим дочерние файлы в родителя удаляемой страницы
		add_action( 'post_updated', [$this, 'check_chenge_parent_page'], 10, 3 );//срабатывает в момент когда пост обновляется и доступные его старые и новые данные, нужно для того чтоб отследить изменился ли у страницы родитель чтоб если что поменять вложенность кешированных папок
	}

	//плановое кеширование
	public function planed_caching_and_new_page_list(){
		KsnPlugin::$instance->main_func->create_page_list();//записываем все url страниц и записей в файл page_list.json

	    //если активно кеширование инициализированное пользователем то мы записываем это в лог и прерываем плановое кеширование
		if(KsnPlugin::$instance->main_func->get_redis("ksn_user_init_caching") === "yes"){
			$log = "При попытке начать плановое кеширование было зафиксированно кеширование инициализированное пользователем, плановое кеширование перенесено на следующий раз";
			$this->write_in_log_fill($log, "planned");//записываем результать кеширования в файл лога
			return;
		}
		//если активно кеширование инициализированное пользователем то мы записываем это в лог и прерываем плановое кеширование

		KsnPlugin::$instance->main_func->set_redis(["ksn_planned_caching" => "yes"]);//записываем в редис что идёт плановое кеширование

		$this->caching_all_pages_on_site("prepare", "planned");
		$this->caching_all_pages_on_site("start", "planned");
		$this->caching_all_pages_on_site("finishid", "planned");

		KsnPlugin::$instance->main_func->del_redis("ksn_planned_caching");//удаляем из редиса пометку пеланового кеширования
	}
	//плановое кеширование

	//функция отвечает за включение и отключения кеша на сайте
	public function main_caching_active($value){
	    $planned_cache_value = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_planed_update");//получаем из бд значение настройки планового кеширования
	    //если кеширование включили
	    if($value === "yes"){
	    	KsnPlugin::$instance->main_func->wp_config_fill_edit("'WP_CACHE'", 'define( \'WP_CACHE\', true ); // KSN');//включаем кеш
	        $this->active_planed_caching($planned_cache_value);//если нужно включаем плановое кеширование
	        KsnPlugin::$instance->main_func->advanced_cache_fill_action("create");//создаём файл advanced-cache.php в папке wp-content
	    }
	    //если кеширование включили

	    //если кеширование отключили
	    if($value === "no"){
	    	KsnPlugin::$instance->main_func->wp_config_fill_edit("'WP_CACHE'", 'define( \'WP_CACHE\', false ); // KSN');//выключаем кеш
	        $this->active_planed_caching("no");//отключаем планове кеширование
	        KsnPlugin::$instance->main_func->advanced_cache_fill_action("delete");//удаляем файл advanced-cache.php в папке wp-content
	    }
	    //если кеширование отключили
	}
	//функция отвечает за включение и отключения кеша на сайте

	//функция включает и отключает крон задачу caching_and_new_page_list в зависимости от того включена или отключена настройка планового кеширования
	public function active_planed_caching($value){
	    //если плановое кеширование включили
	    if($value === "yes"){
	        $this->interval_cron_ceche_update();//создаём новую крон задачу планового кеширования
	    }
	    //если плановое кеширование включили

	    //если плановое кеширование отключили
	    if($value === "no"){
	        if(wp_next_scheduled('caching_and_new_page_list')){ wp_clear_scheduled_hook( 'caching_and_new_page_list' ); }//если в кроне есть задача caching_and_new_page_list то удаляем её
	    }
	    //если плановое кеширование отключили
	}
	//функция включает и отключает крон задачу caching_and_new_page_list в зависимости от того включена или отключена настройка планового кеширования

	//функция обновляет интервал планового кеширования
	public function interval_cron_ceche_update($value = null){
	    if(wp_next_scheduled('caching_and_new_page_list')){ wp_clear_scheduled_hook('caching_and_new_page_list'); }//если в кроне есть задача caching_and_new_page_list удаляем её
	    wp_schedule_event( time(), 'caching_interval', 'caching_and_new_page_list' );//создаём её заново с новым интервалом срабатывания
	}
	//функция обновляет интервал планового кеширования

	//интервал планового кеширования
	public function cron_add_new_interval( $schedules ) {
	    $days = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_reload_iterval_days");
	    $schedules['caching_interval'] = array(
	        'interval' => DAY_IN_SECONDS * $days,
	        'display' => "Раз в $days дней"
	    );
	    return $schedules;
	}
	//интервал планового кеширования

	//получаем содержимое страницы ввиде строки
	public function curl($url, $divise = "desktop"){
	    $ch = curl_init();//инициальзируем новый сеанс cURL
	    $agent = 'KSN_site_caching_'.$divise;
	    curl_setopt($ch, CURLOPT_URL, $url);//переход по требуемому url
	    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('KSN-caching: action'));//задаём заголовк для запроса чтоб не получить кешированную страницу
	    curl_setopt($ch, CURLOPT_COOKIESESSION, true);//true для указания текущему сеансу начать новую "сессию" cookies. Это заставит libcurl проигнорировать все "сессионные" cookies, которые она должна была бы загрузить, полученные из предыдущей сессии (т.е. не учитывать авторизацию в вордпрессе)
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );//true для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер
	    curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);//true для следования любому заголовку "Location: ", отправленному сервером в своём ответе
	    $data = curl_exec($ch);//выполняем запрос cURL
	    curl_close($ch);//завершаем сеанс сеанс cURL
	    return $data;//возвращаем код страницы из $url в виде строки
	}
	//получаем содержимое страницы ввиде строки

	//преобразуем url в путь к папке с кешированными файлами для данного url
	public function convert_url_to_cache_path($url){
		$path = CACHE_DIR;//получаем путь к папке кеша E:\1SERVER\domains\peter.ru/wp-content/cache/ksn_cache
		//очищаем url от протокола и слеша в конце
		if("https" === strtolower(parse_url($url, PHP_URL_SCHEME))){
			$url = rtrim(str_replace("https://", "", $url), '/' );//удаляем '/' в конце url
		} else if("http" === strtolower(parse_url($url, PHP_URL_SCHEME))){
			$url = rtrim(str_replace("http://", "", $url), '/' );//удаляем '/' в конце url
		} else {
			$url = rtrim($url, '/' );//удаляем '/' в конце url
		}
		//очищаем url от протокола и слеша в конце

		$url_parts = explode( '/', $url ); // рзбиваем url с помощью разделителя '/' и получаем массив с вида Array([0] => peter.ru [1] => ustanovka-antigravijnoj-plenki [2] => kapot)

		foreach ( $url_parts as $dir ) { $path .= '/' . $dir; }//переопределяем $path с добавлением в его конец части адреса $dir (E:\1SERVER\domains\peter.ru/wp-content/cache/peter.ru)
		return $path;//путь к папке с кешем данного url , E:\1SERVER\domains\peter.ru/wp-content/cache/peter.ru
	}
	//преобразуем url в путь к папке с кешированными файлами для данного url










	//функция проверяет обновляет ли пользователь сейчас настройки
	public function check_user_update_settings_now($i = 1000){
		$result = KsnPlugin::$instance->main_func->get_redis("user_update_settings_now");//проверяем обновляются ли сейчас настройки
		if(!$result){
			return false;
		} else{
			if($i <= 0){
				return true;
			}
			sleep(1);
			$i--;
			$this->check_user_update_settings_now($i);
		}
	}
	//функция проверяет обновляет ли пользователь сейчас настройки










	//чистит папку от фалов и подпапок со всем их содержимым
	//$copy_folder - папка которую нужно скопировать со всеми файлами
	//$insert_folder - папка в которую мы будем копировать
	//$delete_copy_folder - удалять ли исходную папку которую мы копировали
	public function copy_all_fills_between_folders($copy_folder, $insert_folder, $delete_copy_folder = false ){
		$folder = glob($copy_folder.'/*');//массив содержимого папки
		$insert_folder = rtrim($insert_folder, '/' );//удаляем '/' в конце url
		if(!file_exists($insert_folder)) { mkdir($insert_folder);}//если папки insert_folder нет, создаём её

		//если массив не пуст
		if($folder){
			foreach($folder as $content){
				$name = basename($content);//имя файла или папки
				
				//если это обычный файл то копируем его
				if(is_file($content)){
					copy($content, $insert_folder."/".$name);

					//если нужно удалить исходную папку
					if($delete_copy_folder){
						unlink($content);//удаляем файл
					}
					//если нужно удалить исходную папку
				}
				//если это обычный файл то копируем его

				//если это папка
				if(is_dir($content)){
					if(!file_exists($insert_folder."/".$name)) { mkdir($insert_folder."/".$name);}//если папки name нет, создаём её
					$this->copy_all_fills_between_folders($content, $insert_folder."/".$name, $delete_copy_folder);//копируем содержимое папки
				}
				//если это папка
			}
		}
		//если массив не пуст

		//если нужно удалить исходную папку
		if($delete_copy_folder){
			rmdir($copy_folder);//удаляем папку
		}
		//если нужно удалить исходную папку
	}
	//чистит папку от фалов и подпапок со всем их содержимым

	//copy_all_fills_between_folders("D:\OpenServer\domains\peter.ru/wp-content/cache/ksn_cache/peter.ru/ceny", "D:\OpenServer\domains\peter.ru/wp-content/cache/ksn_cache/peter.ru/a-1-uroven/ceny");

	//чистит папку от фалов и подпапок со всем их содержимым
	public function clear_folder($folder_path){
		$inner_folder = glob($folder_path.'/*');//массив содержимого папки

		//если массив не пуст
		if($inner_folder){
			foreach($inner_folder as $content){
				if(is_file($content)){ unlink($content); }//если это обычный файл то удаляем его
				if(is_dir($content)){$this->clear_folder($content);}//если это папка запускаем рекурсивно clear_folder
			}
		}
		//если массив не пуст

		//если папка существует
		if(is_dir($folder_path)){
			rmdir($folder_path);//удаляем папку
		}
		//если папка существует
	}
	//чистит папку от фалов и подпапок со всем их содержимым

	//удаляем кеш после удаления записи
	public function delete_cache_fils($url_for_clear){
		$path = $this->convert_url_to_cache_path($url_for_clear);//преобразуем url в путь к папке с кешированными файлами для данного url
		$this->clear_folder($path);//удаляем паку и все файлы и подпапки в ней
	}
	//удаляем кеш после удаления записи

	//функция кеширует переданый url и записывает его содержимое в файл
	public function cache_url($url_for_cache){
		//очищаем url_for_cache от протокола и слеша в конце
		if("https" === strtolower(parse_url($url_for_cache, PHP_URL_SCHEME))){
			$url_for_cache_bez_http = rtrim(str_replace("https://", "", $url_for_cache), '/' );//удаляем '/' в конце url_for_cache
		} else if("http" === strtolower(parse_url($url_for_cache, PHP_URL_SCHEME))){
			$url_for_cache_bez_http = rtrim(str_replace("http://", "", $url_for_cache), '/' );//удаляем '/' в конце url_for_cache
		}
		//очищаем url_for_cache от протокола и слеша в конце

		$url_parts = explode( '/', $url_for_cache_bez_http ); // рзбиваем url_for_cache с помощью разделителя '/' и получаем массив с вида Array([0] => peter.ru [1] => ustanovka-antigravijnoj-plenki [2] => kapot)

		$path = CACHE_DIR;//получаем путь к папке кеша E:\1SERVER\domains\peter.ru/wp-content/cache/ksn_cache

		//если папка cache/ksn_cache не существует
		if (!file_exists($path)) {
			//пытаемся создать директорию, если не удалось создать дерикторию
			if (!mkdir($path)) {
				// не удалось создать деррикторию
				return "<span class='red log_messege'>Не удалось создать дирректорию $path</span>";//возвращаем результат кеширования данного url_for_cache
			}
			//пытаемся создать директорию, если не удалось создать дерикторию
		}
		//если папка cache/ksn_cache не существует

		//перебираем массив с частями адреса страницы и создаём дерриктории в папке кеша с названием соответсвующим текущему итерируемому элементу url_for_cache адреса кешируемой страницы
		foreach ( $url_parts as $dir ) {
			$path .= '/' . $dir;//переопределяем $path с добавлением в его конец части адреса $dir (E:\1SERVER\domains\peter.ru/wp-content/cache/ksn_cache/peter.ru)

			//если файл или каталог(директория) не существует
			if (!file_exists($path)) {
				//пытаемся создать директорию, если не удалось создать дерикторию
				if (!mkdir($path)) {
					// не удалось создать деррикторию
					return "<span class='red log_messege'>Не удалось создать дирректорию $path</span>";//возвращаем результат кеширования данного url_for_cache
				}
				//пытаемся создать директорию, если не удалось создать дерикторию
			}
			//если файл или каталог(директория) не существует

		}
		//перебираем массив с частями адреса страницы и создаём дерриктории в папке кеша с названием соответсвующим текущему итерируемому элементу url_for_cache адреса кешируемой страницы

		//в зависимости от того нужны ли разыне версии сайта дополняем список устройств
		$divises = ["desktop"];
		if(KsnPlugin::$instance->main_func->get_ksn_site_settings_data("site_settings", "site_mobile_version") === "yes"){ array_push($divises, "mobile"); }//если нужна мобильная версия
		if(KsnPlugin::$instance->main_func->get_ksn_site_settings_data("site_settings", "site_tablet_version") === "yes"){ array_push($divises, "tablet"); }//если нужна планшетная версия
		//в зависимости от того нужны ли разыне версии сайта дополняем список устройств

		//перебираем список поддерживаемых устройств
		foreach($divises as $divise) {
			$contents = $this->curl($url_for_cache, $divise);//получаем код страницы из $url в виде строки
			$modified_time = time(); //текущее время
			$modified_date = date("d.m.Y H:i:s", $modified_time);//дата и время модификации
			$contents .= "\n<!-- KSN ".$divise." кеш - последние изменение: " . $modified_date . " по МСК -->\n";//добавляем комментарий в конец кешируемого файла
			$contents_gzip = gzencode($contents, 9);//создаём из строки $url сжатую строку gzip
			file_put_contents( $path . '/index_'.$divise.'.gzip.html', $contents_gzip );//создаёт файл index.html и записываем данные в файл index.html
			touch( $path . '/index_'.$divise.'.gzip.html', $modified_time ); //задаём время последнего измения файла
		}
		//перебираем список поддерживаемых устройств

		$log_path = str_replace( "\\", "/", $path);//заменяем все \ на / чтоб корректно отображалось при выводе в блоке лога
		return "<span class='green'>$url_for_cache</span><span> => Файл успешно кеширован в папку $log_path</span>";//возвращаем сообщение об успешном кешировании файла
	}
	//функция кеширует переданый url и записывает его содержимое в файл

	//функция запускает кеширование страниц данные которых подготовлены в редисе urls
	public function ksn_main_cache_func(){
		$redis = KsnPlugin::$instance->main_func->connect_redis();//подключаемся к редису
		$result_cache_data = [];//массив с результатами кеширования всех url_data
		$all_url_for_cache = $redis->hGetAll('urls');//получаем все url из хеш таблицы в редис
		$length = KsnPlugin::$instance->main_func->get_redis("amount", "ksn_cache");//получаем общее количество url

		//перебираем all_url_for_cache и кешируем каждый url из него
		for($i = 0; $i < $length; $i++){
			set_time_limit(20);//продливаем выполение скрипта на 20сек каждый раз, чтоб успеть кешировать все страницы, т.е. на каждую страницу отводится максимум по 20 сек
			//если страница была обновлена, то запрос отправится но новой и нужно пропустить те url которые уже удалены
			if(!array_key_exists($i, $all_url_for_cache)){
				continue;//пропускаем текущую итерацию
			}
			//если страница была обновлена, то запрос отправится но новой и нужно пропустить те url которые уже удалены

			//если было выполнено прерывание кеширования
			if(KsnPlugin::$instance->main_func->get_redis("abort", "ksn_cache") === "yes"){
				$result_cache_data = ['abort' => 'yes'];
				return $result_cache_data;//возвращаем результат кеширования
			}
			//если было выполнено прерывание кеширования
			
			$url = $all_url_for_cache[$i];//текущий итерируемый url
			$result = $this->cache_url($url);//запускаем кеширование текущего итерируемого url
			KsnPlugin::$instance->main_func->set_redis(["$i" => "$result"], "ksn_log_caching");
			KsnPlugin::$instance->main_func->set_redis(["progress" => $i+1], "ksn_cache");//прогрес кеширования url
			KsnPlugin::$instance->main_func->del_redis("$i", "urls");
			$result_cache_data[$url] = $result;//записваем как прошло кеширование данного url
		}
		//перебираем all_url_for_cache и кешируем каждый url из него

		return $result_cache_data;//возвращаем результат кеширования
	}
	//функция запускает кеширование страниц данные которых подготовлены в редисе urls

	//проверяем изменилось ли заначение прогресса кеширования
	public function check_chenge_progres_in_redis($progress, $i = 0){
		if(KsnPlugin::$instance->main_func->get_redis("abort", "ksn_cache") === "yes"){ return "abort"; }//если во время проверки изменения значения прогресса произошло прерывание кеширования
		$redis_get_data_progress = KsnPlugin::$instance->main_func->get_redis("progress", "ksn_cache");//получаем текущее занчаение прогресса в редисе
		if($progress !== $redis_get_data_progress){//проверяем изменилось ли значение прогресса в редисе по сравнению с переданным значением прогресса
			return true;
		} else {
			if($i >= 1800){//даётся 5 минут на изменение значение в редисе, иначе будет вызвано прерывание кеширования
				return false;
			} else {
				$i++;
				usleep(100000);//пауза на 0.1 сек
				if(KsnPlugin::$instance->main_func->get_redis("progress", "ksn_cache") === false){ return "finishid";}//если в процессе мониторинга прогресса значение из редиса пропало то мы завершаем мониторинг
				return $this->check_chenge_progres_in_redis($progress, $i);
			}
		}
	}
	//проверяем изменилось ли заначение прогресса кеширования

	//функция каждую секунду проверяет каков статус планового кеширования 
	public function wait_fo_planned_caching_ended(){

		if(KsnPlugin::$instance->main_func->get_redis("status", "ksn_cache") !== false){

			//если было зафиксированно прерывание кеширования
			if(KsnPlugin::$instance->main_func->get_redis("abort", "ksn_cache") === "yes"){ 
				return "abort"; 
			}
			//если было зафиксированно прерывание кеширования

			//каждую секунду проверяем статус планового кеширования, если оно равно false значит кеширование завершилось и редис был очищен
			if(KsnPlugin::$instance->main_func->get_redis("status", "ksn_cache") === "finishid"){
				return "finishid_planned";//когда плановое кеширование будет завершено т.е. status = finishid или false (редис очищен) нам тоже подходит
			} else {
				sleep(1);
				set_time_limit(20);//каждый раз задаём время на выполение скрипта по 20 сек чтоб не вылетела ошщибка слишком долгого выполения скрипта
				return $this->wait_fo_planned_caching_ended();
			}
			//каждую секунду проверяем статус планового кеширования

		} else {
			return "finishid_planned";
		}
	}
	//функция каждую секунду проверяет каков статус планового кеширования

	//записываем результать кеширования в файл лога
	public function write_in_log_fill($data, $initiator){
		$time_w = date("d.m.Y H-i-s", time()); //текущая дата для виндовс систем
		$time_l = date("d.m.Y H:i:s", time()); //текущая дата для линукс систем

		strpos(PHP_OS, "WIN") !== false ? file_put_contents(CACHE_DIR."/logs/$time_w ".$initiator."_cache_log.txt", $data) : file_put_contents(CACHE_DIR."/logs/$time_l ".$initiator."_cache_log.txt", $data);//провеям какая операционнная система стоит на мошине где установлен сервер и в зависимости от этого называйм файл и создаём его
	}
	//записываем результать кеширования в файл лога

	//проверяет завершена ли подготовка к кешированию, т.е. есть ли в редисе запись status в таблице ksn_cache
	public function check_prepare_caching_complite(){
		if(KsnPlugin::$instance->main_func->get_redis("ksn_planned_caching") === "yes" && KsnPlugin::$instance->main_func->get_redis("status", "ksn_cache") === false){
			return $this->check_prepare_caching_complite();
		} else {
			return true;
		}
	}
	//проверяет завершена ли подготовка к кешированию, т.е. есть ли в редисе запись status в таблице ksn_cache

	//запуск кеширования после нажатия кнопки начать кеширование
	public function caching_all_pages_on_site($action, $type_init = "user_init"){
		//если параметр action сообщил о том что нужно подготовить данные для кеширования
		if($action === "prepare"){

			//если во время планового кеширования запускается кеширование инициализированное пользователем то мы сразу возвращаем что подготовка к кешированию завершена
			if(KsnPlugin::$instance->main_func->get_redis("ksn_planned_caching") === "yes" && $type_init === "user_init"){
				if($this->check_prepare_caching_complite()){ wp_die(json_encode(["prepare" => "complete"])); }//ждём завершения подготовки планового кеширования
			}
			//если во время планового кеширования запускается кеширование инициализированное пользователем то мы сразу возвращаем что подготовка к кешированию завершена

			if($type_init === "user_init"){ KsnPlugin::$instance->main_func->set_redis(["ksn_user_init_caching" => "yes"]); }//если кеширование инициализированно пользователем то мы сразу это записываем в редис

			$redis = KsnPlugin::$instance->main_func->connect_redis();//подключаемся к редису
			$typs_for_cache = ['page', 'post'];//типы записей для кеширования
			$typs_for_cache_length = count($typs_for_cache);//количество типов записей для кеширования (2)
			$json_data = json_decode(file_get_contents(KSN_PLAGIN_URL.'/data/page_list.json'), true);//страницы для кеширования берём из файла page_list.json
			$last_index;//переменная в которую мы будем записывать индекс, с которого должна начинаться следующая интерация для записи в хеш таблицу редиса

			set_time_limit(60);//возможно url  в файле page_list.json будет очень много так что заранее задаём время выполения скрипта +60 сек

			//перебираем массив с типами записей для кеширования
			for($index = 0; $index < $typs_for_cache_length; $index++) {
				$type = $typs_for_cache[$index];//текущий итерируемый тип записи для кеширования
				$length = count($json_data[$type]);//количество url записаных в page_list.json для данного итерируемого типа записей
				$last_index = $index === 0 ? $last_index = 0 : $last_index += count($json_data[$typs_for_cache[$index - 1]]);//если это первый итерируемый тип записи то мы в last_index записываем 0, чтоб следующий итерируемый тип записей сохранялся в редис под корректным номером. Если это уже не первая итерация типов записей, то мы к last_index добавляем количество элементов и предидущего итерируемого типа записей  

				//перебираем все записи для текущего итерируемого типа записей т.е.  перебираем url
				for($i = 0; $i < $length; $i++){
					$key = $last_index + $i;//порядковый номер для записи в хеш таблицу редиса
					$redis->hSet("urls", $key, $json_data[$type][$i]);//записываем url в хеш таблицу редиса
				}
				//перебираем все записи для текущего итерируемого типа записей т.е.  перебираем url
			}
			//перебираем массив с типами записей для кеширования

			$redis_data = [
				"progress" => "0", //прогрес кеширования url
				"amount" => $redis->hLen("urls"), //общее количество url для кеширования
				"complete" => "no", //триггер завершения функции кеширования
				"abort" => "no", //триггер прерывания функции кеширования
				"status" => "prepare" //текущийй статус операции кеширования
			];

			KsnPlugin::$instance->main_func->set_redis($redis_data, "ksn_cache");//записываем в хеш таблицу все необходимые значения для продолжения кеширования

			if($type_init === "user_init"){wp_die(json_encode(["prepare" => "complete"])); }//если было кеширование инициализированное пользователем, сообщаем клиенту что все необходимые для кеширования приготовления завершены
		}
		//если параметр action сообщил о том что нужно подготовить данные для кеширования

		//сам процесс кеширования
		if($action === "start"){

			//если происходит плановое кеширование, но функцию вызвал пользователь
			if(KsnPlugin::$instance->main_func->get_redis("ksn_planned_caching") === "yes" && $type_init === "user_init"){
				$result = $this->wait_fo_planned_caching_ended();//дожидаемся окончания планового кеширования
				$cache_last_update_time = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_last_update_time");
				wp_die(json_encode([ $result => "yes", "cache_last_update_time" => $cache_last_update_time]));//ждём заевршения планового кеширования, и возвращаем пользователю ответ в зависимости от того было ли прервано кеширование или всё прошло гладко
			}
			//если происходит плановое кеширование, но функцию вызвал пользователь

			$results = $this->ksn_main_cache_func();//делаем запрос на пересоздание кеша всех страниц

			//если было плановое кеширование, и кеширование НЕ было прервано
			if($type_init === "planned"){
				//проверяем было ли прервано плановое кеширование, если нет то записывает актуальные настройки в базу данных
				if(!array_key_exists("abort", $results)){ 
					KsnPlugin::$instance->main_func->set_redis(["complete" => "yes"], "ksn_cache");//фиксируем завершение кеширования
					KsnPlugin::$instance->main_func->updata_caching_settings_in_bd();
					$cache_last_update_time = time();
					KsnPlugin::$instance->main_func->set_ksn_site_settings_data("cache", "cache_last_update_time", $cache_last_update_time);
				};
				//проверяем было ли прервано плановое кеширование, если нет то записывает актуальные настройки в базу данных
				return;
			}
			//если было плановое кеширование, и кеширование НЕ было прервано

			//если было прерывание кеширования
			if(array_key_exists("abort", $results)){
				wp_die(json_encode(["abort" => "yes"])); //сообщаем клиету что кеширования прервано
			}
			//если было прерывание кеширования

			KsnPlugin::$instance->main_func->set_redis(["complete" => "yes"], "ksn_cache");//фиксируем завершение кеширования
			$results["complete"] = "yes";//помечаем что кеширование прошло успешно

			$cache_last_update_time = time();
			KsnPlugin::$instance->main_func->set_ksn_site_settings_data("cache", "cache_last_update_time", $cache_last_update_time);
			$results["cache_last_update_time"] = $cache_last_update_time;//возвращаем дату успешного кеширования
			KsnPlugin::$instance->main_func->updata_caching_settings_in_bd();//записывает актуальные кешированные версии настроек в базу данных
			wp_die(json_encode($results)); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
		}
		//сам процесс кеширования

		//после окончания кеширования чистим редис
		if($action === "finishid"){

			if(KsnPlugin::$instance->main_func->get_redis("ksn_planned_caching") === "yes"){
				sleep(3);//задержка чтоб точно было зафиксированно изменение в таблице ksn_cache сторонним слушателем
			}

			
			//если происходит плановое кеширование, но функцию вызвал пользователь
			if(KsnPlugin::$instance->main_func->get_redis("ksn_planned_caching") === "yes" && $type_init === "user_init"){
				wp_die(json_encode(["finishid_planned" => "complete"]));
			}
			//если происходит плановое кеширование, но функцию вызвал пользователь

			KsnPlugin::$instance->main_func->set_redis( ["status" => "finishid"], "ksn_cache");//записываем новое сестояние операции кеширования

			$log = "";//строка для лога
			$redis = KsnPlugin::$instance->main_func->connect_redis();//подключаемся к редису
			$length = $redis->hLen("ksn_log_caching");//получаем текущее количество url в логе
			$abort_status = KsnPlugin::$instance->main_func->get_redis("abort", "ksn_cache");//статус перерывания кеширования

			for($i = 0; $i < $length; $i++){
				$data = strip_tags(KsnPlugin::$instance->main_func->get_redis("$i", "ksn_log_caching"));//получаем значения из редис и очищаем от html тегов
				$log .= "[URL] $data \n";//записываем все строки результата в лог
			}

			$logs_dir = CACHE_DIR."/logs";//разположение файла с логом

			KsnPlugin::$instance->main_func->del_redis("urls");//чистим редис
			KsnPlugin::$instance->main_func->del_redis("ksn_cache");//чистим редис если нет слушателя
			KsnPlugin::$instance->main_func->del_redis("ksn_log_caching");//чистим редис

			//если дирректория с логом не создана создаём её
			if(!file_exists($logs_dir)){
				mkdir($logs_dir);//создаём дирректорию logs
			}
			//если дирректория с логом не создана создаём её

			//если было плановое кеширование
			if(KsnPlugin::$instance->main_func->get_redis("ksn_planned_caching") === "yes"){
				$abort_status === "yes" ? $this->write_in_log_fill($log, "abort_planned") : $this->write_in_log_fill($log, "planned");//записываем результать кеширования в файл лога
				return;
			}
			//если было плановое кеширование

			//если было кеширование инициализированное пользователем
			if(KsnPlugin::$instance->main_func->get_redis("ksn_user_init_caching") === "yes") {
				KsnPlugin::$instance->main_func->del_redis("ksn_user_init_caching");
				$abort_status === "yes" ? $this->write_in_log_fill($log, "abort_user") : $this->write_in_log_fill($log, "user");//записываем результать кеширования в файл лога
				wp_die(json_encode(["finishid_user" => "complete"])); //сообщаем клиесту что чистка завершена
			}
			//если было кеширование инициализированное пользователем
		}
		//после окончания кеширования чистим редис
	}

	//запуск кеширования после нажатия кнопки начать кеширование
	public function ajax_caching_all_pages(){
		$action = $_POST["data"]["action"];

		$cache_active_status = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_active");//получаем вклюён ли кеш или нет в настройках

		//если кеш включен
		if($cache_active_status === "yes"){
			$re_create = $_POST["data"]["re_create"] ?? "no";//проверяем была ли переданная переменная re_create если нет то приравнивает её к no
			//если поступила команда пересоздать кеш полностью, а не просто перезаписать файлы
			if($re_create === "yes"){
				$this->delete_cache_fils($_SERVER['HTTP_HOST']);//удаляем старые файлы и папки кеша
			}
			//если поступила команда пересоздать кеш полностью, а не просто перезаписать файлы

			$this->caching_all_pages_on_site($action);
		}
		//если кеш включен

		//если кеш выключен
		else {
			wp_die(json_encode(["fail" => "Нужно включить кеширование прежде чем запускать процесс создания кеша!"]));
		}
		//если кеш выключен
	}
	//запуск кеширования после нажатия кнопки начать кеширование

	//проверяем прогресс выполнения кеширования файлов и отправляем данные клиенту
	public function ksn_cache_page_progress(){
		$progress = $_POST["data"]["progress"];

		$cache_progres_data = [];//массив в который будем записывать текущий прогресс кеширования
		$cache_data_in_redis = ['amount', 'progress', 'complete', 'abort'];//параметры кеширования записанные в редис

		//если было выполнено прерывание возвращаем ответ с собщением об этом
		if(KsnPlugin::$instance->main_func->get_redis("abort", "ksn_cache") === "yes"){
			wp_die(json_encode(['abort' => "yes"]));//отправляем клиенту сообщение что кеширование было прервано
		}
		//если было выполнено прерывание возвращаем ответ с собщением об этом

		$cache_progres = $this->check_chenge_progres_in_redis($progress);//фиксируем изменение в значении прогресса кеширования

		//слишком долго пытались получить обновлённые данные из редиса
		if($cache_progres === false){
			KsnPlugin::$instance->main_func->set_redis(["abort" => "yes"], "ksn_cache");//устанавлимаем параметр для прерывания кеширования
			wp_die(json_encode([
				'abort' => 'yes',
				'messege' => "<span class='red log_messege'>Значение прогресса так и не изменилось за 5 минут, вынужены прервать кеширование =(</span>"
			]));
		}
		//слишком долго пытались получить обновлённые данные из редиса

		//операция кеширования была прервана
		if($cache_progres === "abort"){
			wp_die(json_encode([
				'abort' => 'yes',
				'messege' => "<span class='red log_messege'>При пропытке получить изменённые данные прогресса было зафиксированно принудительное прерывание кеширования!</span>"
			]));
		}
		//операция кеширования была прервана

		foreach($cache_data_in_redis as $data){
			$cache_data = KsnPlugin::$instance->main_func->get_redis($data, "ksn_cache");//получаем значения из редис
			$cache_progres_data["$data"] = $cache_data;//записываем полученные значения в массив для отправки клиенту
		}

		$redis = KsnPlugin::$instance->main_func->connect_redis();//подключаемся к редису
		$length = $redis->hLen("ksn_log_caching");//получаем текущее количество url в логе
		$log = [];//массив в который будут записываться даные лога для отправки клиенту

		//перебираем записи логов в редисе начина с $progress, т.е. с текущее проверяемого url, так как $progress при первом запросе равен нулю то мы можем быть точно уверены что мы получили все предыдущие записи лога и чтоб не тратить в пустую время мы начинаем считывать данные лога редиса со значения текущее прогресса который есть у клиента не у сервера не нужно путать
		for($i = $progress; $i < $length; $i++){
			$data = KsnPlugin::$instance->main_func->get_redis("$i", "ksn_log_caching");//получаем значения из редис
			$log[$i] = $data;//записываем данные лога в массив для отправки клиента
		}

		$cache_progres_data["log"] = $log;//записываем пассив логов в итоговый массив для отправки клиенту

		//когда количество кешированных файлов станет равным общему количеству файлов для кешироания
		if(KsnPlugin::$instance->main_func->get_redis("progress", "ksn_cache") === KsnPlugin::$instance->main_func->get_redis("amount", "ksn_cache")){
			$cache_progres_data["complete"] = "yes";
		}
		//когда количество кешированных файлов станет равным общему количеству файлов для кешироания

		wp_die(json_encode($cache_progres_data));//отправляем клиенту данные о прогрессе кеширования
	}
	//проверяем прогресс выполнения кеширования файлов и отправляем данные клиенту

	//прерывание кеширования
	public function ksn_abort_caching(){
		KsnPlugin::$instance->main_func->set_redis(["abort" => "yes"], "ksn_cache");//устанавлимаем параметр для прерывания кеширования
		wp_die(json_encode(["abort" => "yes"]));//отправляем клиенту сообщение что запрос на прерывание кеширования успешно выполнен
	}
	//прерывание кеширования



	//помещаем изи восстанавливаем файл в корзине
	public function treshed_or_restored_folder_for_cheche($url, $action){
		$path = $this->convert_url_to_cache_path($url);//получаем путь к кешированным файлам данного url

		//помечаем что страница в корзине
		if($action === "trashed"){
			$old_path = preg_replace('/__trashed$/', '', $path);//получаем название папки с кешем данного url
			rename($old_path, $path);//переименовуем папку с кешем данного url  с препиской __trashed в конце
		}
		//помечаем что страница в корзине

		//восстанавливаем файл из корзины
		if($action === "restored"){
			//если существует папка с таким же именем но с приставкой __trashed то значит файл был восстановлен из корзины
			if(is_dir($path."__trashed")){
				rename($path."__trashed", $path);//переименовуем папку в такое же название но без __trashed
			}
			//если существует папка с таким же именем но с приставкой __trashed то значит файл был восстановлен из корзины
		}
		//восстанавливаем файл из корзины
	}
	//помещаем изи восстанавливаем файл в корзине

	//запуск пересоздания страницы при обновлении её контента или удаляем при помещенни в корзину
	public function caching_page($post_id, $post_data, $update){
		$status = $post_data->post_status;//текущий статус записи
		$type = $post_data->post_type;//тип записи

		$url_for_cache = KsnPlugin::$instance->main_func->get_accurate_permalink($post_id);//получаем ссылку на запись

		//пост обновляется, создаётся
		if($status === "publish"){
			$this->cache_url($url_for_cache);
		}
		//пост обновляется, создаётся

		//файл скорее всего востановлен из корзины или не опубликован
		if($status === "draft" && $type === "page"){
			$this->treshed_or_restored_folder_for_cheche($url_for_cache, "restored");//меняем название папки всстановленной страницы
			KsnPlugin::$instance->main_func->create_page_list();//записываем все url страниц и записей в файл page_list.json
		}
		//файл скорее всего востановлен из корзины или не опубликован

		//пост помещается в корзину
		if($status === "trash" && $type === "page"){
			$this->treshed_or_restored_folder_for_cheche($url_for_cache, "trashed");//меняем название папки помещённой в корзину страницы
			KsnPlugin::$instance->main_func->create_page_list();//записываем все url страниц и записей в файл page_list.json
		}
		//пост помещается в корзину

		//если создаётся новая запись
		if(!$update){
			KsnPlugin::$instance->main_func->create_page_list();//записываем все url страниц и записей в файл page_list.json
		}
		//если создаётся новая запись
	}
	//запуск пересоздания страницы при обновлении её контента или удаляем при помещенни в корзину

	//в момент удаления записи из корзины (на всегда), чистим файлы кеша и переносим дочерние файлы в родителя удаляемой страницы
	public function delete_cache( $post_id ){
		$type = get_post_type($post_id);
		if($type === "page"){
				global $wpdb;
				$check_children = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post_id' AND post_type = 'page' AND post_status IN ('trash', 'publish', 'draft') AND post_name NOT IN ('')", ARRAY_A );//массив который мы получили после запросса в базу данных, мы запросили все страницы (page) у которых родителем является страница с id = $post_id, статус поста должен быть опубликованым (publish) или в корзине (trash) или черновик (draft), так же проверяем чтоб имя поста (post_name) не было пустым это гарантирует то что эта страница не черновик который ещё не разу не был опубликован. Если этот массив пуст то дочерних страниц нет ни в опубликованых постах не в временно черновиках не в корзине

				$url = KsnPlugin::$instance->main_func->get_accurate_permalink($post_id);//получаем ссылку на запись
				//если у страницы которую окончательно удаляем были дочерние элементы то переносим их в родителя удаляемой страницы
		        if(!empty($check_children)){
		        	$folder_to_copy = $this->convert_url_to_cache_path($url);//путь к папке содержимое которой будем копировать
					$path_parts = explode( '/', $folder_to_copy );//разбиваем строку с помощью / 
					array_pop($path_parts);//удаляем последний элемент массива, чтоб получить путь к родительской папке, текущей копируемой папки
					$folder_inner_copy = implode("/", $path_parts);//склеиваем массив в строку и получаем папку в которую будем копировать содержимое
					$this->copy_all_fills_between_folders($folder_to_copy, $folder_inner_copy, true);//копируем
		        }
		        //если у страницы которую окончательно удаляем были дочерние элементы то переносим их в родителя удаляемой страницы

		        //если не было дочених страниц
		        else {
		        	$this->delete_cache_fils($url);//удаляем папку и все файлы в ней
		        }
		        //если не было дочених страниц
		}
		
	}
	//в момент удаления записи из корзины (на всегда), чистим файлы кеша и переносим дочерние файлы в родителя удаляемой страницы

	//срабатывает в момент когда пост обновляется и доступные его старые и новые данные, нужно для того чтоб отследить изменился ли у страницы родитель чтоб если что поменять вложенность кешированных папок
	public function check_chenge_parent_page($post_id, $post_after, $post_before){
		if($post_before->post_name === "" || $post_after->post_parent === $post_before->post_parent || $post_after->post_type !== "page"){ return; }//запускаем функцию только если у записи есть предыдущее имя (т.е. если предидущего имени нет то мы её только что создали и нам не из чего будет копировать файлы т.к. этой папки ещё нет), у неё сменился родитель и она является страницей

		//получаем адреса страницы до (before_parent_url) и после (after_parent_url) смены её родителя, в случае если новым или старым родителем выступает корневой каталог его post_parent параметр будет равен 0 и функция get_accurate_permalink вернёт нам null то мы записываем в этом случае доменное имя в качестве адреса
		$before_parent_url = KsnPlugin::$instance->main_func->get_accurate_permalink($post_before->post_parent) === null ? $_SERVER['HTTP_HOST'] : KsnPlugin::$instance->main_func->get_accurate_permalink($post_before->post_parent);//до смены
		$after_parent_url = KsnPlugin::$instance->main_func->get_accurate_permalink($post_after->post_parent) === null ? $_SERVER['HTTP_HOST'] : KsnPlugin::$instance->main_func->get_accurate_permalink($post_after->post_parent);//после смены
		//получаем адреса страницы до (before_parent_url) и после (after_parent_url) смены её родителя, в случае если новым или старым родителем выступает корневой каталог его post_parent параметр будет равен 0 и функция get_accurate_permalink вернёт нам null то мы записываем в этом случае доменное имя в качестве адреса

		$before_parent_folder_path = $this->convert_url_to_cache_path($before_parent_url);//получаем путь к кешированным файлам папки старого родителя
		$after_parent_folder_path = $this->convert_url_to_cache_path($after_parent_url);//получаем путь к кешированным файлам папки нового родителя
		$folder_for_copy = $before_parent_folder_path."/".$post_before->post_name;//папка которую нужно скопировать
		$folder_inner = $after_parent_folder_path."/".$post_after->post_name;//папка в которую нужно скопировать
		$this->copy_all_fills_between_folders($folder_for_copy, $folder_inner, true);//копируем
	}
	//срабатывает в момент когда пост обновляется и доступные его старые и новые данные, нужно для того чтоб отследить изменился ли у страницы родитель чтоб если что поменять вложенность кешированных папок
}

?>