<?php 
namespace KsnPlugin\base\site;

use KsnPlugin\KsnPlugin;
use KsnPlugin\base\site\Header;
use KsnPlugin\base\site\Footer;

class Site_Settings {
	
	public function run(){
		(new Header)->run();
		(new Footer)->run();
		add_action( 'wp_enqueue_scripts', [$this, 'udalit_nenuznie_css_js'], 99999 );//удаляем ненужные стили скрипты
		add_action( 'wp_print_styles', [$this, 'udalit_nenuznie_css_js'], 99999 );//удаляем ненужные стили скрипты
		add_action( 'wp_print_scripts', [$this, 'udalit_nenuznie_css_js'], 99999 );//удаляем ненужные стили скрипты
		add_action( 'wp_print_head_scripts', [$this, 'udalit_nenuznie_css_js'], 99999 );//удаляем ненужные стили скрипты
		add_action( 'wp_print_footer_scripts', [$this, 'udalit_nenuznie_css_js'], 99999 );//удаляем ненужные стили скрипты
		remove_action( 'wp_head', [$this, 'wp_print_head_scripts'], 9);//функция управляет переносим стилей и скриптов в хедер и в футер
		add_filter( 'wp_print_styles', [$this, 'css_js_head'], 1 );//функция управляет переносим стилей и скриптов в хедер и в футер
		add_filter( 'wp_print_footer_scripts', [$this, 'css_js_footer'], 1 );//функция управляет переносим стилей и скриптов в хедер и в футер
		add_filter ( 'style_loader_tag', [$this, 'modify_style_tag'], 10, 4 );//меням код вывода стилей
		add_filter( 'script_loader_tag', [$this, 'modify_scripts_tag'], 10, 3);//меням код вывода скриптов
	}

	//удаляем ненужные стили скрипты
	public function udalit_nenuznie_css_js() {
	    wp_dequeue_style('wp-block-library');
	    wp_deregister_script( 'wp-embed' );
	}
	//удаляем ненужные стили скрипты

	public static $stili_na_vivod = [];

	public static $scripti_na_vivod =[];

	public static $top_style = ['critikal-tema-style', 'min-w-1800-tema-style', 'min-w-2500-tema-style'];

	public static $bot_style = [];

	public static $top_script = [];

	public static $bot_script = [
	    //0 => 'mayn-tema-script'
	];

	//функция управляет переносим стилей и скриптов в хедер и в футер
	public function css_js_head() {
	    global $wp_styles, $wp_scripts;
	    //стили
	    //print_r($wp_styles->queue);
	    $style_arr = $wp_styles->queue;//все стили поставленые на вывод в хуке wp_print_styles
	    if ( !\Elementor\Plugin::$instance->preview->is_preview_mode() && !\Elementor\Plugin::$instance->editor->is_edit_mode() ) { //если мы в предпросмотре элементор то выводим стили elementor
	        foreach ($style_arr as $key => $value) {
	            if (strpos($value,'elementor') !== false) { //удаляем из очереди все стили elementor
	                unset($style_arr[$key]);
	            }
	        }
	    }
	    

	    $stili_ostalis = array_values(array_diff($style_arr, self::$top_style));//здесь остаются те стили которые не нужны в верху, их нет $top_style

	    self::$stili_na_vivod = array_merge(self::$stili_na_vivod, $stili_ostalis);//здесь мы записывам в глобальный массив $stili_na_vivod те стили которые не нужны в верху
	    $wp_styles->queue = self::$top_style;//здесь мы ставим на вывод вверху наши стили из $top_style
	    //print_r($stili_ostalis);
	    //скрипты
	    //print_r($wp_scripts->queue);
	    //$scripts_arr = $wp_scripts->queue;
	    //$scripts_ostalis = array_values(array_diff($scripts_arr, self::$bot_script));
	    //$scripti_na_vivod = array_merge(self::$scripti_na_vivod, $scripts_ostalis);
	    //$wp_scripts->queue = $scripti_na_vivod;

	}
	//функция управляет переносим стилей и скриптов в хедер и в футер

	//функция управляет переносим стилей и скриптов в хедер и в футер
	public function css_js_footer() {
	    global $wp_styles, $wp_scripts;
	    //стили
	    //print_r($wp_styles->queue);
	    $style_arr = $wp_styles->queue;//все стили поставленые на вывод в хуке wp_print_footer_scripts
	    //print_r($style_arr);
	    if ( !\Elementor\Plugin::$instance->preview->is_preview_mode() && !\Elementor\Plugin::$instance->editor->is_edit_mode() ) { //если мы в предпросмотре элементор то выводим стили elementor
	        foreach ($style_arr as $key => $value) {
	            if (strpos($value,'elementor') !== false) { //удаляем из очереди все стили elementor
	                unset($style_arr[$key]);
	            }
	        }
	    }
	    //print_r($style_arr);
	    $style_bez_top = array_values(array_diff($style_arr, self::$top_style));//убираем те стили кторые уже вывели вверху
	    
	    $vse_ostavshiesa_stili = array_unique(array_merge(self::$stili_na_vivod, $style_bez_top));//все стили которые ещё не выведены, удаляем повоторяющиеся
	    //print_r($vse_ostavshiesa_stili);
	    $wp_styles->queue = $vse_ostavshiesa_stili;
	    //print_r($vse_ostavshiesa_stili);
	    //скрипты
	    //print_r($wp_scripts->queue);
	    //$scripts_arr = $wp_scripts->queue;
	    //$resArrScripts = array_diff($scripts_arr, $transport_scripts);
	    //print_r($resArrScripts);

	}
	//функция управляет переносим стилей и скриптов в хедер и в футер

	//меням код вывода стилей
	public function modify_style_tag ( $html, $handle, $href, $media ){
	    $control_css_up_ver = ['critikal-tema-style','min-w-1800-tema-style', 'min-w-2500-tema-style'];//скрипты которым нужно динамически менять версию
	    $version = !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data("dop_options", "update_css_js")) ? KsnPlugin::$instance->main_func->get_ksn_site_settings_data("dop_options", "update_css_js") : "1";//переменная = условие ? true : false;

	    // Страница wp-login.php
	    if( $GLOBALS['pagenow'] === 'wp-login.php' ){
	        return $html;
	    }
	    // Страница wp-login.php

	    if ( FALSE === strpos( $html, '.css' ) ){
	        return $html; 
	    };
	    //тут мы меням версию файлов темы
	    if(in_array($handle, $control_css_up_ver)){
	        //меняем атрибут href на data-href чтоб подкючать этот файл только для нужных размеров экранов через js
	        if ($handle=='min-w-1800-tema-style' || $handle=='min-w-2500-tema-style') {
	            $html = str_replace( "?ver=99", "?ver=".$version, $html );
	            $html = str_replace( ' href', ' data-src', $html );
	            return $html;
	        };
	        //меняем атрибут href на data-href чтоб подкючать этот файл только для нужных размеров экранов через js
	        $html = str_replace( "?ver=99", "?ver=".$version, $html );
	        return $html;
	    } 
	    //тут мы меням версию файлов темы
	    else {
	        return $html;
	    }
	}
	//меням код вывода стилей
	
	//меням код вывода скриптов
	//\Elementor\Plugin::$instance->editor->is_edit_mode() для страниц редактора элементора
	//\Elementor\Plugin::$instance->preview->is_preview_mode() для страниц предпростмотра элементора
	public function modify_scripts_tag($tag, $handle, $src) {
	    $control_js_up_ver = ['mayn-tema-script'];//скрипты которым нужно динамически менять версию
	    $version = !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data("dop_options", "update_css_js")) ? KsnPlugin::$instance->main_func->get_ksn_site_settings_data("dop_options", "update_css_js") : "1";//переменная = условие ? true : false;

	    // Страница wp-login.php
	    if( $GLOBALS['pagenow'] === 'wp-login.php' ){
	        return $tag;
	    }
	    // Страница wp-login.php
	    if( is_admin() || \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() || is_user_logged_in() ){
	        if ( strpos( $src, 'elfsight-instagram-feed.js' ) ) {
	            return str_replace( ' src', ' data-src', $tag );
	        };
	        return $tag;
	    };
	    if ( FALSE === strpos( $tag, '.js' ) ){
	        return $tag; 
	    };
	    //для всех скриптов убираем type='text/javascript'
	    if ( true === strpos( $tag, '.js' ) ){
	       $tag = str_replace( "type='text/javascript'", 'defer', $tag );
	    };
	    //для всех скриптов убираем type='text/javascript'
	    //тут мы меням версию файлов темы
	    if (in_array($handle, $control_js_up_ver)){
	        $tag = str_replace( "type='text/javascript'", 'defer', $tag );
	        $tag = str_replace( "?ver=99", "?ver=".$version, $tag );
	        return $tag; 
	    }
	    //тут мы меням версию файлов темы
	    //меняем вывод скрипта инстаграмм галереи
	    else if ( strpos( $src, 'elfsight-instagram-feed.js' ) ) {
	        $tag = str_replace( "type='text/javascript'", '', $tag );
	        $tag = str_replace( " src", " data-src", $tag );
	        return $tag;
	    }
	    //меняем вывод скрипта инстаграмм галереи
	    else {
	        return str_replace("type='text/javascript'", 'defer', $tag); 
	    };
	}
	//меням код вывода скриптов
}

?>