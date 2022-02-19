<?php 
if ( !is_admin()) {
	//проверяем куки пользователя что знать что он не только не в админ панели но и не авторизован на сайте
	if ( ! empty( $_COOKIE ) ) {
		$wp_cookies = array( 'wordpressuser_', 'wordpresspass_', 'wordpress_sec_', 'wordpress_logged_in_' );

		foreach ( $_COOKIE as $key => $value ) {
			foreach ( $wp_cookies as $cookie ) {
				if ( strpos( $key, $cookie ) !== false ) {
					return;//если всё же авторизован
				}
			}
		}
	}
	//проверяем куки пользователя что знать что он не только не в админ панели но и не авторизован на сайте

	//выдаём кешированный файл для каждой страницы
	function get_serve_file_cache() {
		$ksn_user_agents = ["KSN_site_caching_mobile", "KSN_site_caching_tablet", "KSN_site_caching_desktop"];//юзер агенты плагина кеширования

		//если юзер агент в списке агентов плагина кеширования, то не достаём ститичейскую версию страницы, а стороим её по новой на сервере
		foreach ($ksn_user_agents as $agent) {
			if($_SERVER['HTTP_USER_AGENT'] === $agent){
				return; //завершаем скрипт
			}
		}
		//если юзер агент в списке агентов плагина кеширования, то не достаём ститичейскую версию страницы, а стороим её по новой на сервере

		$cache_dir = rtrim(WP_CONTENT_DIR,'/').'/cache/ksn_cache';//путь к кешированным файлам

		$host = ( isset( $_SERVER['HTTP_HOST'] ) ) ? $_SERVER['HTTP_HOST'] : ''; //домен с доменной зоной (peter.ru)

		//в зависимости от типа устройства и поддерживаемых версий сайта выдавать разыне версии страниц сайта
		if(isMobile()){
			$divise = KSN_MOBILE_SITE_VERSIONS ? "mobile" : "desktop";
		} elseif(isTablet()){
			$divise = KSN_TABLET_SITE_VERSIONS ? "tablet" : "desktop";
		} elseif(isDesktop()){//если ПК или неопределённый
			$divise = "desktop";
		}
		//в зависимости от типа устройства и поддерживаемых версий сайта выдавать разыне версии страниц сайта

		$reqest_path = explode('?', $_SERVER['REQUEST_URI'], 2)[0];//запрошеный адрес без get параметров
		$html_path = $cache_dir . '/' . rtrim($host.$reqest_path, '/').'/index_'.$divise.'.gzip.html';//путь к требуемому html файлу в папке кеша

		//если файл существует и доступен для чтения
		if ( file_exists( $html_path ) && is_readable( $html_path ) ) {
			$path = $html_path;//путь к кешированному файлу
			$fill_content = file_get_contents($html_path);//берём содержимое кешированного файла
			$md5_fill_hash = md5($fill_content);//хешируем содержимое кешируемого файла для использования как триггер изменений в файле
			$modified_time = filemtime($path);//время последнего изменения файла

			header( 'Content-Type: text/html; charset=UTF-8' );//тип передаваемого контента
			header( 'Content-Encoding: gzip' );// тип сжатия gzip для переданных данных
			header( 'Cache-Control: no-cache' ); //указываем клиенту что страницу можно не кешировать

			//если дата последней модификации файла существует и клиент спрашивает последнюю дату изменения и последняя дата изменения соответсвует той что сеть у клиента
			if ( ! empty( $modified_time ) && ! empty( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) && strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) === $modified_time ) {
				header($_SERVER['SERVER_PROTOCOL']." 304 Not Modified", true, 304 );
				exit; //завершаем скрипт
			}
			//если дата последней модификации файла существует и клиент спрашивает последнюю дату изменения и последняя дата изменения соответсвует той что сеть у клиента

			//если клиент передал серверу ETag и он совпадает с текущим ETag (хешем страницы)
			If(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == '"'.$md5_fill_hash.'"') {
	    		header($_SERVER['SERVER_PROTOCOL']." 304 Not Modified", true, 304 );//отвечаем что не было изменений и можно брать версию документа из локального кеша
	    		exit; //завершаем скрипт
			}
			//если клиент передал серверу ETag и он совпадает с текущим ETag (хешем страницы)

			header( 'ETag: "'.$md5_fill_hash.'"' ); //хеш страницы для проверки изменений
			header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s', $modified_time ) . ' GMT' );//время последнего изменения файла

			readfile( $path );//выводить содержимое файла в кеше

			exit; //завершаем скрипт
		}
		//если файл существует и доступен для чтения
	}
	get_serve_file_cache();
	//выдаём кешированный файл для каждой страницы
}
 ?>