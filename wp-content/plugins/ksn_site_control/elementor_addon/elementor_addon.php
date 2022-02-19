<?php 
namespace KSN_Site_Konstruktor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Выйти при прямом доступе.
}

//создаём единственный класс нашего плагина
final class ksn_site_konstruktor {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
	const MINIMUM_PHP_VERSION = '7.0';


 	//ksn_site_konstruktor Единственный экземпляр класса
	private static $_instance = null;

 	//Гарантирует, что только один экземпляр класса ksn_site_konstruktor загружен или может быть загружен
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	//Конструктор
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
	}

	//О загруженных плагинах.
	//Проверяет, загрузился ли Elementor, и выполняет некоторые проверки совместимости.
	//Если все проверки пройдены, запускается плагин.
	//Запускается хуком действия `plugins_loaded`.
	public function on_plugins_loaded() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
	}

	//Проверки совместимости
	//Проверяет, соответствует ли установленная версия Elementor минимальным требованиям плагина.
	//Проверяет, соответствует ли установленная версия PHP минимальным требованиям плагина.
	public function is_compatible() {

		// Проверьте, установлен ли и активирован ли Elementor
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Проверить наличие необходимой версии Elementor
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Проверить наличие необходимой версии PHP
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}

	//Уведомление администратора
	//Предупреждение, если на сайте не установлен или не активирован Elementor.
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* переводчики: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" требует плагин "%2$s" для установки и активации.', KSN_PLAGIN_NAME ),
			'<strong>' . esc_html__( 'KSN конструктор сайта', KSN_PLAGIN_NAME ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', KSN_PLAGIN_NAME ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	//Уведомление администратора
	//Предупреждение, когда на сайте отсутствует минимально необходимая версия Elementor.
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* переводчики: 1: Plugin name 2: Elementor 3: требуемая Elementor версия */
			esc_html__( '"%1$s" требует "%2$s" версии %3$s или выше.', KSN_PLAGIN_NAME ),
			'<strong>' . esc_html__( 'KSN конструктор сайта', KSN_PLAGIN_NAME ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', KSN_PLAGIN_NAME ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	//Уведомление администратора
	//Предупреждение, когда на сайте отсутствует минимально необходимая версия PHP.
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: требуемая PHP версия */
			esc_html__( '"%1$s" требует "%2$s" версии %3$s или выше.', KSN_PLAGIN_NAME ),
			'<strong>' . esc_html__( 'KSN конструктор сайта', KSN_PLAGIN_NAME ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', KSN_PLAGIN_NAME ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	//Загржаем файлы локализации плагина
	//Запускается хуком действия `init`.
	public function i18n() {
		load_plugin_textdomain( KSN_PLAGIN_NAME );
	}

	//Инициализировать плагин
	//Загружайте плагин только после загрузки Elementor (и других необходимых плагинов).
	//Загрузите файлы, необходимые для запуска плагина.
	//Запускается хуком действия `plugins_loaded`.
	public function init() {
		$this->i18n();
		//Добавить действия плагина
		//регистрируем виджеты
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		//регистрируем категории виджетов
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );
		//регистрируем элементы управления для виджетов
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
		//После постановкой клиентских скриптов в очередь editor.
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_after_enqueue_scripts' ] );
		//После постановкой клиентских стилей в очередь editor.
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_after_enqueue_styles' ] );
		//Перед постановкой клиентских скриптов в очередь frontend.
		add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'frontend_before_enqueue_scripts' ] );
		//После постановки клиентских скриптов в очередь frontend.
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_after_enqueue_scripts' ] );
		//После того, как Elementor зарегистрирует все стили frontend.
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'frontend_after_register_styles' ] );
		//После постановки в очередь стилей внешнего интерфейса frontend.
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_after_enqueue_styles' ] );
		//Для шрифтов Google frontend
		add_action( 'elementor/frontend/print_google_fonts', [ $this, 'frontend_enqueue_styles_google_fonts' ] );
		//Перед постановкой стилей предварительного просмотра в очередь preview.
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'preview_enqueue_styles' ] );
		//Перед постановкой скриптов предварительного просмотра в очередь preview.
		add_action( 'elementor/preview/enqueue_scripts', [ $this, 'preview_enqueue_scripts' ] );
		// подключает и выводид любой код в footer editor
		add_action( 'elementor/editor/footer', [ $this, 'footer_editor_inc' ] );

	}





	//регистрируем элементы управления для виджетов
	public function init_controls() {
		//подключаем все нужные элементы управления для виджетов
		require_once KSN_ELEMENTOR_ADDON_DIR.'/controls/podkluchit_controls.php';
	}

	//регистрируем категории виджетов
	public function add_elementor_widget_categories( $elements_manager ) {
		$categories['glavnaya_stranica'] =
	        [
	            'title' => 'Блоки для главной страницы',
	            'icon'  => 'fa fa-plug',
	            'active' => false,
	        ];
		$categories['contacti'] =
	        [
	            'title' => 'Страница контактов',
	            'icon'  => 'fa fa-plug',
	            'active' => false,
	        ];
		$categories['bloki_dla_stranic_saita'] =
	        [
	            'title' => 'Блоки для страниц сайта',
	            'icon'  => 'eicon-image-before-after',
	            'active' => false,
	        ];
	    $categories['shablon_sayta'] =
	        [
	            'title' => 'Шаблоны сайта',
	            'icon'  => 'fa fa-plug',
	            'active' => false
	        ];
	    $old_categories = $elements_manager->get_categories();

	    //отключаем ненужные категории
		$ubrat_categorii = ['basic','pro-elements','general','theme-elements','woocommerce-elements'];//['basic','pro-elements','general','theme-elements','woocommerce-elements'];
		foreach($old_categories as $key => $item){
		    if (in_array($key, $ubrat_categorii)){
		      unset($old_categories[$key]);
		    }
		}
		//отключаем ненужные категории
	    $categories = array_merge($categories, $old_categories);
	    $set_categories = function ( $categories ) {
	        $this->categories = $categories;
	    };

	    $set_categories->call( $elements_manager, $categories );

	    
	}

	//регистрируем виджеты
	public function init_widgets() {
		//подключаем все нужные виджеты
		require_once KSN_ELEMENTOR_ADDON_DIR.'/widgets/'.KSN_PROJEKT_FOLDER.'/podkluchit_widgets.php';
	}

	//После постановкой клиентских стилей в очередь editor.
	public function editor_after_enqueue_styles() {
		wp_enqueue_style( 'custom_editor', KSN_ELEMENTOR_ADDON_URL.'/assets/css/editor/custom_editor.css', [], '1' );
		wp_enqueue_style( 'custom_fonts', get_template_directory_uri().'/css/adminfonts.css', [], '1' );
	}

	//После постановкой клиентских скриптов в очередь editor.
	public function editor_after_enqueue_scripts() {
		wp_register_script('words_schetchik', KSN_ELEMENTOR_ADDON_URL.'/assets/js/editor/editor.js', ['elementor-editor',], '1', true );
		wp_enqueue_script( 'words_schetchik' );
		wp_register_script('all_widget_settings', KSN_ELEMENTOR_ADDON_URL.'/assets/js/all_widget_settings.js', ['elementor-editor',], '1', true );
		wp_enqueue_script( 'all_widget_settings' );

		add_filter( 'script_loader_tag', [ $this, 'editor_scripts_as_a_module' ], 10, 2 );

	}

	//меняем тег скрипта для счётчика слов
	public function editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'words_schetchik' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}
	//меняем тег скрипта для счётчика слов

	//Перед постановкой клиентских скриптов в очередь frontend.
	public function frontend_before_enqueue_scripts() {

	}

	//После постановки клиентских скриптов в очередь frontend.
	public function frontend_after_enqueue_scripts() {
		wp_dequeue_script('elementor-pro-frontend');
		wp_dequeue_script('pro-preloaded-elements-handlers');
		wp_dequeue_script('elementor-frontend');
		wp_dequeue_script('preloaded-modules');
		wp_dequeue_style( 'e-animations' );
		wp_dequeue_script('e-sticky');
	}

	//После того, как Elementor зарегистрирует все стили frontend.
	public function frontend_after_register_styles() {

	}

	//После постановки в очередь стилей внешнего интерфейса frontend.
	public function frontend_after_enqueue_styles() {

	}

	//Для шрифтов Google frontend
	public function frontend_enqueue_styles_google_fonts() {
		//wp_dequeue_style( 'google-fonts-1' );
	}

	//Перед постановкой стилей предварительного просмотра в очередь preview.
	public function preview_enqueue_styles() {
		wp_register_style( 'preview-plagin-custom-style', KSN_ELEMENTOR_ADDON_URL.'/assets/css/preview/preview_styles.css', [], '1'  );
		wp_enqueue_style( 'preview-plagin-custom-style' );
	}

	//Перед постановкой скриптов предварительного просмотра в очередь preview.
	public function preview_enqueue_scripts() {
		wp_enqueue_script('elementor-pro-frontend');
		wp_enqueue_script('pro-preloaded-elements-handlers');
		wp_enqueue_script('elementor-frontend');
		wp_enqueue_script('preloaded-modules');

		wp_dequeue_script( 'mayn-tema-script' );

		wp_register_script( 'elfsight-instagram-feed', plugins_url('/elfsight-instagram-feed-cc/assets/elfsight-instagram-feed.js'), [], '4.0.2', true );//скрипт инстаграмм галереи
		wp_enqueue_script( 'elfsight-instagram-feed' );

		wp_register_script( 'custom_previwe', KSN_ELEMENTOR_ADDON_URL.'/assets/js/custom_previwe.js', [ 'jquery', 'elfsight-instagram-feed' ], '1', true );
		wp_enqueue_script( 'custom_previwe' );
	}

	// подключает и выводид любой код в footer editor
	public function footer_editor_inc() {
		//менят вывод данных картинки при выборе её в медиатеке, данные меняются справа. ВАЖНО: менят данные не в фулскрине картинки , а просто при выборе картинки в медиатеке
		require_once KSN_PLAGIN_DIR.'/wp_custom_temp/tmpl_attachment_details_custom.php';

		//тут мы изменяем отображение данных картинок в медиатеке, когда мы открываем картинку нажав на неё , этот шаблон меняет данные её полей алт, тайт и другие
		//require_once 'wp_custom_temp/tmpl_attachment_details_two_column_custom.php';

		//когда открывается галерея, именно галерея не библиотека, вордпресс используется этот шаблон, он просто убирает подпись под картинкой
		require_once KSN_PLAGIN_DIR.'/wp_custom_temp/tmpl_media_grid_library.php';
	}
}

ksn_site_konstruktor::instance();
//создаём единственный класс нашего плагина


	

?>