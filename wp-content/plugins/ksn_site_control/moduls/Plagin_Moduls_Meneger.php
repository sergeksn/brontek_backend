<?php 
namespace KsnPlugin\moduls;

use KsnPlugin\KsnPlugin;
use KsnPlugin\core\Main_Func;

class Plagin_Moduls_Meneger {

	static public $moduls_nams = [];//тут будет харанится массив с именем всех папок модулей

	static public $top_script_data;//хранит в себе код скрипта подключаемый сверху

	static public $menu_tree = [];//массив древа меню

	//запустить модули
	public function run(){
		$this->include_all_moduls();//подключаем все стартовые файлы модулей и инициализируем их
	}

	//подключаем все модули
	private function include_all_moduls(){
		$all_fils = glob(__DIR__.DIRECTORY_SEPARATOR."*");//получаем все файлы в папке ksn_site_control\moduls
		
		//отсеиваем чтоб остались только папки
		foreach($all_fils as $fill_path){
			if(is_dir($fill_path)){//если папка
				$all_moduls_folders[] = explode(KSN_PLAGIN_NAME.DIRECTORY_SEPARATOR.'moduls'.DIRECTORY_SEPARATOR, $fill_path)[1];//записываем название папок модулей
			}
		}
		//отсеиваем чтоб остались только папки

		//перебираем все названия модулей
		foreach($all_moduls_folders as $modul){
			$modul_fill = __DIR__.DIRECTORY_SEPARATOR.$modul;//путь к папке конкретного модуля \moduls\meta_settings
			$all_modul_fils = glob($modul_fill.DIRECTORY_SEPARATOR."*");//все файлы из папки данного модуля \moduls\meta_settings\

			//перебираем всё содержимое папки \moduls\meta_settings\ текущего модуля
			foreach($all_modul_fils as $fill){
				if(is_file($fill)){//если файл
					require_once($fill);//подключаем файл модуля
					$class_name = basename($fill, '.php');//имя файла модуля это имя класса
					$class = '\KsnPlugin\moduls\\'.$modul.'\\'.$class_name;//получаем полное имя класса с пространством имён
					(new $class())->init_modul();//инициализируем класс
					$this->include_plagin_func($modul);//подключаем файлы с функциями модуля и записываем их в объект с основными функциями плагина
				}
			}
			//перебираем всё содержимое папки \moduls\meta_settings\ текущего модуля
		}
		//перебираем все названия модулей
	}
	//подключаем все модули

	//подключаем файлы с функциями модуля и записываем их в объект с основными функциями плагина
	public function include_plagin_func($modul_name){
		$file = __DIR__.DIRECTORY_SEPARATOR.$modul_name.DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.'Functions.php';//путь к файлу с функциями
		if(file_exists($file)){//если файл существует
			require_once($file);//подключаем его
			$class = '\KsnPlugin\moduls\\'.$modul_name.'\\base\Functions';//название класса
			(new $class())->add_modul_func_in_main_func();//инициализируем класс
		}
	}
	//подключаем файлы с функциями модуля и записываем их в объект с основными функциями плагина

	//добавляем функции модуля к главным функциям плагина в KsnPlugin::$instance->main_func
	public function add_modul_func_in_main_func(){

		$curent_class = new \ReflectionClass(get_class($this));//получаем информацию о классе Functions подключаемого модуля
		
		foreach ($curent_class->getMethods() as $item) {//перебираем всю информацию о методах класса
		    if ($item->class == get_class($this)) {//
		        $all_class_methods[] = $item->name;//записываем в $all_class_methods только имена методов класса Functions подключаемого модуля
		    }
		}

		$main_func = new Main_Func();//создаём новый экземпляр класса Main_Func
		if(array_search('__construct', $all_class_methods)){//проверяем есть ли __construct в массиве
			unset($all_class_methods[array_search('__construct', $all_class_methods)]);//удаляем __construct из списка методов класса для обработки
		}

		//print_r($curent_class->getMethod('work')->getAttributes()); 
		
		//перебираем массив со всеми методами данного класса
		foreach($all_class_methods as $method){
			$main_func::$added_func_data[$method] = get_class($this);//записываем данные метод и его клас в Main_Func список методов для вызова
		}
		//перебираем массив со всеми методами данного класса

        KsnPlugin::$instance->main_func = $main_func;//записываем в главный экземпляр класса нашего плагина KsnPlugin::$instance в свойство main_func новый экземпляр класса Main_Func
	}
	//добавляем функции модуля к главным функциям плагина в KsnPlugin::$instance->main_func

	//срабатывает при загрузке каждого модуля
	public function init_modul(){
		self::$top_script_data .= $this->top_script_data();//записывает в top_script_data код каждого модуля где он вызывается
		array_push(self::$moduls_nams, $this->modul);//записываем имя модуля
		$this->generete_menu_tree($this->modul_grup, $this->modul_name);//создаём массив древа меню
	}
	//срабатывает при загрузке каждого модуля

	//выводит код скрипта в верхней части блока страницы плагина
	public function render_top_script_data(){ 
		ob_start();//запуск буферизации вывода
		echo "\r\n<script>";
		echo "\r\ndata_ksn = {};";
		echo self::$top_script_data;//всё что назаписывали модули
		echo "\r\n</script>";

		$final_data = ob_get_clean();//получаем всё содержимое буфера и очищаем его
		return $final_data;//возвращаем полученый код скрипта
	}

	//создаём массив древа меню
	public function generete_menu_tree($grup_data, $name_data){
		$tree = self::$menu_tree;

		if(!array_key_exists($grup_data['index_number'], $tree)){//если группы с таким порядковым номером ещё нет
			$tree[$grup_data['index_number']] = [
				'id' => $grup_data['id'],
				'title' => $grup_data['title'],
				'items' => []
			];
		}

		ksort($tree);//сортируем в правильном порядке

		if(!array_key_exists($name_data['index_number'], $tree[$grup_data['index_number']]['items'])){//если настройки с таким порядковым номером ещё нет
			$tree[$grup_data['index_number']]['items'][$name_data['index_number']] = [
				'id' => $name_data['id'],
				'title' => $name_data['title']
			];
		}

		ksort($tree[$grup_data['index_number']]['items']);//сортируем в правильном порядке

		self::$menu_tree = $tree;
		//print_r(self::$menu_tree);
	}

	//отображаем меню
	public function render_menu(){ ?>
		<div id="menu_wrap">
			<div id="menu">
			<?php $this->create_menu(); ?>
			</div>
		</div>
	<?php
	}

	//создаём меню
	public function create_menu(){
		$menu_tree = self::$menu_tree;
		//print_r(self::$menu_tree);
		foreach($menu_tree as $menu_item){
			echo '<div class="menu_item" id="'.$menu_item['id'].'">';
				echo '<div class="menu_item_title">'.$menu_item['title'].'</div>';
				foreach($menu_item['items'] as $child){
					echo '<div class="menu_item_child" data-target="'.$child['id'].'">'.$child['title'].'</div>';
				}
			echo '</div>';
		}
	}

	//подключает файлы для отображения блока с настройками каждого модуля
	public function render_modul_settings_block(){
		//перебираем имена модулей
		foreach(self::$moduls_nams as $modul){
			$view_file = __DIR__.DIRECTORY_SEPARATOR.$modul.DIRECTORY_SEPARATOR.'view'.DIRECTORY_SEPARATOR.'block_output_settings.php';//формируем путь к файлу для отображения блока натсроек данного модуля
			include_once $view_file;//подключаем данный файл
		}
	}

}

?>