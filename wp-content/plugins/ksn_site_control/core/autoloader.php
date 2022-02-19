<?php 
namespace KsnPlugin;

if ( ! defined( 'ABSPATH' ) ) { exit; }//завершить скрипт при прямом доступе к файлу, в обход движка вордпресса

class Autoloader {
	//тут будут хранится псевдонимы для путей к файлам
	private static $aliases = [
		'KsnPlugin' => 'ksn_site_control',
        'events' => 'plagin_events'
	];

    //заменяем в строке псевдонимы
    private static function replacement_aliases($str){
        foreach(static::$aliases as $alias => $rial_name){
            //проверяем есть ли в строке текущий итерируемый псевдоним
            if(strpos($str, $alias) !== false){
                $str = str_replace($alias, $rial_name, $str);//заменяем псевдоним на имя в пути к файлу, и присваем полученное значение нашей переданной строке для нальнейшее поиска
            }
            //проверяем есть ли в строке текущий итерируемый псевдоним
        }
        return $str;//возвращаем обработанную строку
    }

	//автозагрузка классов
	public static function autoload($class){   
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);//заменяем \ на DIRECTORY_SEPARATOR текущей системы 

        $plagin_path = KSN_PLAGIN_DIR.DIRECTORY_SEPARATOR;//путь к папке плагина D:\OpenServer\domains\peter.ru\wp-content\plugins\ksn_site_control\

        $processed_class = static::replacement_aliases($class);//заменяем псевдоним на имя в пути к файлу

        $path_to_fill_in_plagin = str_replace(KSN_PLAGIN_NAME.DIRECTORY_SEPARATOR, "", $processed_class);//путь к файлу внутри плагина base\PlaginPageRender
        $path = $plagin_path.$path_to_fill_in_plagin.".php";//полный путь к файлу с указанием его расширения D:\OpenServer\domains\peter.ru\wp-content\plugins\ksn_site_control\base\PlaginPageRender.php

        //если такой файл существует
        if (file_exists($path)) {
            require $path;//подключаем его
        }
        //если такой файл существует
    }

    public static function run()
    {
        spl_autoload_register( [ __CLASS__, 'autoload' ] );//регистрируем функцию autoload расположенную в этом же классе как автозагрузчик для всех классов
    }
    //автозагрузка классов
}

?>