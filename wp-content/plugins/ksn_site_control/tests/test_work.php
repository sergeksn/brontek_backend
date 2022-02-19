<?php 
use KsnPlugin\KsnPlugin;
use KsnPlugin\moduls\caching\base\Functions;

require_once 'D:\OpenServer\domains\peter.ru/wp-load.php';

//запуск кеширования после нажатия кнопки начать кеширование
function do_cache($action){
	$c_fn = new Functions();
	$cache_active_status = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_active");//получаем вклюён ли кеш или нет в настройках

	//если кеш включен
	if($cache_active_status === "yes"){
		$re_create = $_POST["data"]["re_create"] ?? "no";//проверяем была ли переданная переменная re_create если нет то приравнивает её к no
		//если поступила команда пересоздать кеш полностью, а не просто перезаписать файлы
		if($re_create === "yes"){
			$c_fn->delete_cache_fils($_SERVER['HTTP_HOST']);//удаляем старые файлы и папки кеша
		}
		//если поступила команда пересоздать кеш полностью, а не просто перезаписать файлы

		return $c_fn->caching_all_pages_on_site($action);
	}
	//если кеш включен

	//если кеш выключен
	else {
		wp_die(json_encode(["fail" => "Нужно включить кеширование прежде чем запускать процесс создания кеша!"]));
	}
	//если кеш выключен
}
//запуск кеширования после нажатия кнопки начать кеширование


$prepare = json_decode(do_cache("prepare"), true);
//print_r($prepare);
if($prepare['prepare'] === 'complete'){
	$start = json_decode(do_cache("start"), true);

	if($start['complete'] === 'yes'){
		$finishid = json_decode(do_cache("finishid"), true);
		if($finishid['finishid_user'] === 'complete'){
			echo "СРАБОТАЛО!";
		}
	}
}















//проверяем прогресс выполнения кеширования файлов и отправляем данные клиенту
function cache_current_progres(){
	$c_fn = new Functions();
	$progress = $_POST["data"]["progress"];

	$cache_progres_data = [];//массив в который будем записывать текущий прогресс кеширования
	$cache_data_in_redis = ['amount', 'progress', 'complete', 'abort'];//параметры кеширования записанные в редис

	//если было выполнено прерывание возвращаем ответ с собщением об этом
	if(KsnPlugin::$instance->main_func->get_redis("abort", "ksn_cache") === "yes"){
		die(json_encode(['abort' => "yes"]));//отправляем клиенту сообщение что кеширование было прервано
	}
	//если было выполнено прерывание возвращаем ответ с собщением об этом

	$cache_progres = $c_fn->check_chenge_progres_in_redis($progress);//фиксируем изменение в значении прогресса кеширования

	//слишком долго пытались получить обновлённые данные из редиса
	if($cache_progres === false){
		KsnPlugin::$instance->main_func->set_redis(["abort" => "yes"], "ksn_cache");//устанавлимаем параметр для прерывания кеширования
		die(json_encode([
			'abort' => 'yes',
			'messege' => "<span class='red log_messege'>Значение прогресса так и не изменилось за 5 минут, вынужены прервать кеширование =(</span>"
		]));
	}
	//слишком долго пытались получить обновлённые данные из редиса

	//операция кеширования была прервана
	if($cache_progres === "abort"){
		die(json_encode([
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

	die(json_encode($cache_progres_data));//отправляем клиенту данные о прогрессе кеширования
}
//проверяем прогресс выполнения кеширования файлов и отправляем данные клиенту




//прерывание кеширования
function abort_caching(){
	KsnPlugin::$instance->main_func->set_redis(["abort" => "yes"], "ksn_cache");//устанавлимаем параметр для прерывания кеширования
	die(json_encode(["abort" => "yes"]));//отправляем клиенту сообщение что запрос на прерывание кеширования успешно выполнен
}
//прерывание кеширования

//(new Functions())->test();

//KsnPlugin::$instance->main_func->set_redis(["test" => "good!"]);//записываем в редис что идёт плановое кеширование

?>