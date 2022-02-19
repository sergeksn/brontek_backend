<?php 
namespace KsnPlugin\base\posts_srttings;

class Rus_To_Lat {
	 public function __construct(){
	 	add_filter( 'wp_insert_post_data', [$this, 'chenge_rus_letters_to_lat'], 10, 1 );//меняет символы кирилоицы на английские в названиях страниц
	 }

	 //меняет символы кирилоицы на английские в названиях страниц
	public function chenge_rus_letters_to_lat( $data ) {
		//если пост опубликован
	    if($data["post_status"] === "publish"){
	    	$rus_to_lat = json_decode(file_get_contents(KSN_PLAGIN_DIR."/data/rus_to_lat.json"), true);//файл json с переводом руских символов в английские
			$default = $rus_to_lat["default"];//замена символов из наборпа по умолчанию
	    	$post_name = $data["post_name"];//получаем имя поста
			$all_letters = preg_split('/(?<!^)(?!$)/u', urldecode($post_name));//все буквы и символы url в виде массива предварительно декодировав строку
			$chenge_leters = [];//сюда будем записывать уже заменённые буквы по порядку

			//перебираем все буквы и заменяем на английские
			for ($i=0; $i < count($all_letters); $i++) { 
				$letter = $all_letters[$i];//текущая итерируемая буква
				
				if(array_key_exists($letter, $default)) {
				    $chenge_leters[$i] = $default[$letter];//заменяем текущую букву на ту что соответсвует ей в файле замены
				} else {
					$chenge_leters[$i] = $letter;//если данного символа нет в файле для замены то оставляем его как есть
				}
			}
			//перебираем все буквы и заменяем на английские

			$new_post_name = implode("", $chenge_leters);//объединяем массив со всеми буквами в строку

			$data["post_name"] = $new_post_name;
	    }
	    //если пост опубликован
		return $data;
	}
	//меняет символы кирилоицы на английские в названиях страниц
}

?>