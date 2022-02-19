<?php 
namespace KsnPlugin\moduls\main_seo\base;

use KsnPlugin\KsnPlugin;
use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Functions extends Plagin_Moduls_Meneger{

	//для сео настроек в файле robots.txt
	public function update_robots($action){
				if( !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']) ){
				    $protokol = "https";
				  }else{
				    $protokol = "http";
				  }
				$site_url = $_SERVER['HTTP_HOST'];// "\r\n" перенос на новую строку в начало
				if( $action == "yes" ){
					$result = "User-agent: *" .
						"\r\n" . "Disallow: /wp-" .//Все связанное с WP - это: /wp-content /wp-admin wp-includes /wp-json wp-login.php wp-register.php.
						"\r\n" . "Disallow: /404.php" .//закрываем от роботов шаблон страницы 404
						"\r\n" . "Disallow: /cgi-bin" .//стандартная папка на хостинге
						"\r\n" . "Disallow: *?" .//Все GET запросы
						//"\r\n" . "Disallow: /?" .//Все параметры запроса на главной
						//"\r\n" . "Disallow: *?s=" .//Поиск
						//"\r\n" . "Disallow: *&s=" .//Поиск
						//"\r\n" . "Disallow: /search" .//Поиск
						//"\r\n" . "Disallow: /author/" .//Архив автора
						//"\r\n" . "Disallow: *?attachment_id=" .
						//"\r\n" . "Disallow: */feed" .
						//"\r\n" . "Disallow: */rss" . 
						//"\r\n" . "Disallow: */embed" .//Все встраивания
						//"\r\n" . "Disallow: */page/" .//Все виды пагинации
						"\r\n" . "Disallow: /readme.html" .//Закрываем бесполезный мануал по установке WordPress (лежит в корне)
						"\r\n" . "Disallow: /license.txt" .//Закрываем бесполезный license.txt
						"\r\n" . "Disallow: /xmlrpc.php" .//Файл WordPress API
						//"\r\n" . "Disallow: *?elementor-preview" .
						"\r\n" . "Allow: /wp-admin/admin-ajax.php" .
						"\r\n" . "Allow: */uploads" . 
						"\r\n" . "Allow: */wp-*/*.js" . 
						"\r\n" . "Allow: */wp-*/*.css" .
						"\r\n" . "Allow: */wp-*/*.png" . 
						"\r\n" . "Allow: */wp-*/*.jpg" .
						"\r\n" . "Allow: */wp-*/*.jpeg" . 
						"\r\n" . "Allow: */wp-*/*.gif" . 
						"\r\n" . "Allow: */wp-*/*.webp" . 
						"\r\n" . "Allow: */wp-*/*.svg" .  
						"\r\n" . "Allow: */wp-*/*.pdf" . "\r\n" .

						"\r\n" . "Host: ".$site_url."" .
						"\r\n" . "Sitemap: ".$protokol."://".$site_url."/sitemap.xml";
				} else if( $action == "no" ){
					$result = "User-agent: *".
						"\r\n" . "Disallow: /";
				}
				$src = $_SERVER['DOCUMENT_ROOT'];
				$filename = $src.'/robots.txt';
				$file = fopen($filename, 'w+');
				fwrite($file, $result);
				fclose($file);
	}
	//для сео настроек в файле robots.txt
}

?>