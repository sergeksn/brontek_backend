<?php

//удаляем ненужные пункты меню
function remove_menus(){

    remove_menu_page( 'index.php' );                  // Консоль
    remove_menu_page( 'edit.php' );                   // Записи
    //remove_menu_page( 'upload.php' );                 // Медиафайлы
    //remove_menu_page( 'edit.php?post_type=page' );    // Страницы
    remove_menu_page( 'edit-comments.php' );          // Комментарии
    //remove_menu_page( 'themes.php' );                 // Внешний вид
    //remove_menu_page( 'plugins.php' );                // Плагины
    //remove_menu_page( 'users.php' );                  // Пользователи
    //remove_menu_page( 'tools.php' );                  // Инструменты
    //remove_menu_page( 'options-general.php' );        // Параметры

}
add_action( 'admin_menu', 'remove_menus' );
//удаляем ненужные пункты меню






add_action('init', 'my_custom_init');
function my_custom_init(){




    /*
    register_taxonomy( 
        'marka', //Название создаваемой таксономии
        'kit', //Название типов постов, к которым будет привязана таксономия строка/массив
        [ //Аргументы, определяющие признаки таксономии
            'labels' => [ //Массив описывающий заголовки таксономии (для отображения в админке).
                'name' => 'Марки',//Имя таксономии, обычно во множественном числе, отображается на странице данной таксономии как заголовок
                'singular_name' => 'Марка',//Название для одного элемента этой таксономии
                'menu_name' => 'Марки',//Текст для названия меню
                'search_items' => 'Найти марку',//Текст для поиска элемента таксономии
                'popular_items' => 'Популярные марки',//Текст для блока популярных элементов
                'all_items' => 'Все Марки',//Текст для всех элементов
                'parent_item' => null, //Текст для родительского элемента таксономии. Этот аргумент не используется для не древовидных таксономий
                'edit_item' => 'Изменить марку',//Текст для редактирования элемента
                'update_item' => 'Обновить марку',//Текст для обновления элемента
                'add_new_item' => 'Добавить новую марку',//Текст для добавления нового элемента таксономии
                'view_item' => 'Просмотреть марку'//Текст для просмотра термина таксономии
            ],
            'public' => true,//Показывать ли эту таксономию в интерфейсе админ-панели. Это значение передается параметрам publicly_queryable, show_ui, show_in_nav_menus если для них не установлено свое значение.
            'show_ui' => true,//Показывать блок управления этой таксономией в админке.
            'show_in_menu' => true,//Показывать ли таксономию в админ-меню, таксономия будет показана как подменю у типа записи, к которой она прикреплена
            'show_in_quick_edit' => true,//Показывать ли таксономию в панели быстрого редактирования записи (в таблице, списке всех записей, при нажатии на кнопку "свойства")
            'meta_box_cb' => null,
            'show_admin_column' => false,
            'description' => '',
            'hierarchical' => true,//true - таксономия будет древовидная (как категории). false - будет не древовидная (как метки).
            'rewrite' => [
                'slug' => 'marka',
                'with_front' => false,
                'hierarchical' => true,
                'ep_mask' => EP_NONE,
            ]
    ]
    );
    */



    /*
    register_post_type('plenki', array(
        'labels'             => array(
            'name'               => 'Плёнки', // Основное название типа записи
            'singular_name'      => 'Плёнки', // отдельное название записи типа Book
            'add_new'            => 'Добавить новую плёнку',
            'add_new_item'       => 'Добавить новую плёнку',
            'edit_item'          => 'Редактировать плёнку',
            'new_item'           => 'Новая плёнка',
            'view_item'          => 'Посмотреть плёнку',
            'search_items'       => 'Найти плёнку',
            'not_found'          => 'Пёлнок не найдено',
            'not_found_in_trash' => 'В корзине плёнок не найдено',
            'parent_item_colon'  => '',
            'menu_name'          => 'Плёнки'

          ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'ksn_shop',
        'query_var'          => true,
        'rewrite'            => [
            'slug' => 'vybrat-komplekt',
            'with_front' => false
        ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title','editor','author','thumbnail','excerpt','comments')
    ) );
    */

    register_post_type(
        'product', [
        'labels'             => [
            'name'               => 'Товары', // Основное название типа записи
            'singular_name'      => 'Товар', // отдельное название записи типа Book
            'add_new'            => 'Создать новый товар',
            'add_new_item'       => 'Новый товар',
            'edit_item'          => 'Редактировать товар',
            'new_item'           => 'Новый товар',
            'view_item'          => 'Посмотреть товар',
            'search_items'       => 'Найти товар',
            'not_found'          => 'Товаров не найдено',
            'not_found_in_trash' => 'В корзине товаров не найдено',
            'menu_name'          => 'Товары'

            ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'ksn_shop',
        'query_var'          => true,
        'rewrite'            => [
            'slug' => 'vybrat-komplekt',
            'with_front' => false
        ],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => array('title','editor','page-attributes', 'elementor')
        ]
    );



    register_post_type('orders', array(
        'labels'             => array(
            'name'               => 'Заказы', // Основное название типа записи
            'singular_name'      => 'Заказы', // отдельное название записи типа Book
            'add_new'            => 'Добавить новую',
            'add_new_item'       => 'Добавить новую книгу',
            'edit_item'          => 'Редактировать книгу',
            'new_item'           => 'Новая книга',
            'view_item'          => 'Посмотреть книгу',
            'search_items'       => 'Найти книгу',
            'not_found'          => 'Книг не найдено',
            'not_found_in_trash' => 'В корзине книг не найдено',
            'parent_item_colon'  => '',
            'menu_name'          => 'Заказы'

          ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => 'ksn_shop',
        'query_var'          => true,
        'rewrite'            => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title','editor','author','thumbnail','excerpt','comments')
    ) );



}






/*   
function wpa_course_post_link( $post_link, $id = 0 ){
    $post = get_post($id);  
    if ( is_object( $post ) ){
        $terms = wp_get_object_terms( $post->ID, 'marki' );
        if( $terms ){
            return str_replace( '%marki%' , $terms[0]->slug , $post_link );
        }
    }
    return $post_link;  
}
add_filter( 'post_type_link', 'wpa_course_post_link', 1, 3 );
*/

/*
## Отфильтруем ЧПУ произвольного типа
// сам фильтр: apply_filters( 'post_type_link', $post_link, $post, $leavename, $sample );
add_filter('post_type_link', 'products_permalink', 1, 4);

function products_permalink( $permalink, $post, $leavename, $sample ){
    // выходим если это не наш тип записи: без холдера %marki%
    //print_r($post);
    if( strpos($permalink, '%marki%') === FALSE ){
        return $permalink;
    }

    // Получаем элементы таксы
    $terms = get_the_terms($post, 'marki');
    
    // если есть элемент заменим холдер
    if( ! is_wp_error($terms) && !empty($terms) && is_object($terms[0]) ){
        $taxonomy_slug = $terms[0]->slug;
    }
    // элемента нет, а должен быть...
    else {
        $taxonomy_slug = 'no-produkts';
    }

    return str_replace('%marki%', $taxonomy_slug, $permalink );
}

*/







//новый пункт админ меню вордпреса - магазин
function register_my_page(){
    add_menu_page( 
        'Настройки магазина', 
        'Магазин', 
        'manage_options', 
        'ksn_shop', 
        'rendder_shop', 
        //plugins_url( 'myplugin/images/icon.png' ), 
        '',
        6
    );

    /*add_submenu_page(
        'ksn_shop',
        'Марки',
        'Название инструмента',
        'manage_options',
        'edit-tags.php?taxonomy=marka&post_type=page'
    );*/
}
add_action( 'admin_menu', 'register_my_page', 9 );//9 нужно чтоб срабатывало раньше регистрации типа записей


function rendder_shop(){
    echo "работает";
}
//новый пункт админ меню вордпреса - магазин









//проверям статус пользователя
if ( is_user_logged_in() ) {
    if( current_user_can('manage_options') ){
        //Админ
        $prava_polzovatelya = 1;  
    } else if( current_user_can('manage_links') ){
        //Редактор
        $prava_polzovatelya = 1;
    } else if( current_user_can('upload_files') ){
        //Автор
        $prava_polzovatelya = 1;
    } else if( current_user_can('edit_posts') ){
        //Участник
        $prava_polzovatelya = 1;
    } else if( current_user_can('read') ){
        //Подписчик
        $prava_polzovatelya = 0;
    }
}
else {
    //Не зарегистрированный пользователь
    $prava_polzovatelya = 0;
}
## Отключаем стандартные виджеты WordPress
remove_action( 'init', 'wp_widgets_init', 1 );
## Отключаем стандартные виджеты WordPress
//меню
if ( ! function_exists( 'serge_produkt_setup' ) ) :
    function serge_produkt_setup() {
        register_nav_menus( array(
            'menu_header' => esc_html__( 'Primary', 'serge_produkt' ),
            'menu_footer' => esc_html__( 'Footer', 'serge_produkt' ),
        ) );
    }
endif;
add_action( 'after_setup_theme', 'serge_produkt_setup' );
//меню

/* Кастомные настройки , добавление новых миниатюр и так далее */
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'w_8000px', 8000, 0, false );
    add_image_size( 'w_7000px', 7000, 0, false );
    add_image_size( 'w_6000px', 6000, 0, false );
    add_image_size( 'w_5000px', 5000, 0, false );
    add_image_size( 'w_4000px', 4000, 0, false );
    add_image_size( 'w_3000px', 3000, 0, false );
    add_image_size( 'w_2500px', 2500, 0, false );
    add_image_size( 'w_2000px', 2000, 0, false );
    add_image_size( 'w_1800px', 1800, 0, false );
    add_image_size( 'w_1600px', 1600, 0, false );
    add_image_size( 'w_1400px', 1400, 0, false );
    add_image_size( 'w_1300px', 1300, 0, false );
    add_image_size( 'w_1200px', 1200, 0, false );
    add_image_size( 'w_1100px', 1100, 0, false );
    add_image_size( 'w_1000px', 1000, 0, false );
    add_image_size( 'w_900px', 900, 0, false );
    add_image_size( 'w_800px', 800, 0, false );
    add_image_size( 'w_700px', 700, 0, false );
    add_image_size( 'w_600px', 600, 0, false );
    add_image_size( 'w_500px', 500, 0, false );
    add_image_size( 'w_400px', 400, 0, false );
    //add_image_size( 'w_300px', 300, 0, false );// одинаковая с medium , пока проблем с ВП нет можно отключить 
    //дабы не удалять стандарные миниатюры ВП я переопределяю их в новые размеры чтоб они соответствовали уже зарегистрированным размерам и не создавали лишних файлов миниатюр
    add_image_size( '1536x1536', 1600, 0, false );
    add_image_size( '2048x2048', 2000, 0, false );
}
//отключаем ненужные скрипты в пользовательской части сайта


//подключаем свои скрипты
function tema_scripts() {
    // отменяем зарегистрированный jQuery
    wp_deregister_script('jquery-core');
    wp_deregister_script('jquery');
    // регистрируем
    wp_register_script( 'jquery-core', get_template_directory_uri().'/js/jquery.min.js', false, '3.4.0', true );
    wp_register_script( 'jquery', false, array('jquery-core'), null, true );

    wp_enqueue_script( 'mayn-tema-script', get_template_directory_uri().'/js/mayn.js', array('jquery'), '99', true);
}
add_action( 'wp_enqueue_scripts', 'tema_scripts' );
//подключаем свои стили
function tema_styles() {
    wp_enqueue_style( 'critikal-tema-style', get_template_directory_uri().'/css/critikal.css', array(), '99', 'all' );
    //wp_enqueue_style( 'tema-style', get_template_directory_uri().'/style.css', array(), '55', 'all' ); пока пустой, он не нужен
    wp_enqueue_style( 'min-w-1800-tema-style', get_template_directory_uri().'/css/min-w-1800.css', array(), '99', 'all' );
    wp_enqueue_style( 'min-w-2500-tema-style', get_template_directory_uri().'/css/min-w-2500.css', array(), '99', 'all' );
}
add_action( 'wp_enqueue_scripts', 'tema_styles' );

//шрифты для редактора вордпресс
function wpex_mce_google_fonts_array( $initArray ) {
    $theme_advanced_fonts = 'UltraLightItalic=UltraLightItalic;';
    $theme_advanced_fonts .= 'UltraLight=UltraLight;';
    $theme_advanced_fonts .= 'ThinItalic=ThinItalic;';
    $theme_advanced_fonts .= 'Thin=Thin;';
    $theme_advanced_fonts .= 'Roman=Roman;';
    $theme_advanced_fonts .= 'MediumItalic=MediumItalic;';
    $theme_advanced_fonts .= 'Medium=Medium;';
    $theme_advanced_fonts .= 'LightItalic=LightItalic;';
    $theme_advanced_fonts .= 'Light=Light;';
    $theme_advanced_fonts .= 'Italic=Italic;';
    $theme_advanced_fonts .= 'HeavyItalic=HeavyItalic;';
    $theme_advanced_fonts .= 'Heavy=Heavy;';
    $theme_advanced_fonts .= 'BoldItalic=BoldItalic;';
    $theme_advanced_fonts .= 'Bold=Bold;';
    $theme_advanced_fonts .= 'BlackItalic=BlackItalic;';
    $theme_advanced_fonts .= 'Black=Black;';
    $initArray['font_formats'] = $theme_advanced_fonts;
    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'wpex_mce_google_fonts_array' );
//шрифты для редактора вордпресс выводим
function wpex_mce_fonts_styles() {
    add_editor_style( get_template_directory_uri().'/css/adminfonts.css' );
}
add_action( 'admin_init', 'wpex_mce_fonts_styles' );
//шрифты для редактора вордпресс выводим


//сжатие кода если какие-то проблемы тот можно начать искать тут
if( !is_admin() && !is_user_logged_in() ){
    class Compress_HTML {
        protected $compress_css = true;
        protected $compress_js = true;
        protected $info_comment = false;
        protected $remove_comments = false;
        protected $html;
        public function __construct($html)
        {if (!empty($html)){$this->parseHTML($html);}}
        public function __toString()
        {return $this->html;}
        protected function bottomComment($raw, $compressed){
            $raw = strlen($raw);
            $compressed = strlen($compressed);
            $savings = ($raw-$compressed) / $raw * 100;
            $savings = round($savings, 2);
            return '<!--HTML compressed, size saved '.$savings.'%. From '.$raw.' bytes, now '.$compressed.' bytes-->';}
        protected function minifyHTML($html){
            $pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
            preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
            $overriding = false;
            $raw_tag = false;
            $html = '';
            foreach ($matches as $token) {
                $tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
                $content = $token[0];
                if (is_null($tag)){
                    if ( !empty($token['script']) ){$strip = $this->compress_js;             }
                    else if ( !empty($token['style']) )
                    {$strip = $this->compress_css;               }
                    else if ($content == '<!--wp-html-compression no compression-->')
                    {$overriding = !$overriding; continue;}
                    else if ($this->remove_comments)
                    {if (!$overriding && $raw_tag != 'textarea'){
                        $content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);}}
                } else{
                    if ($tag == 'pre' || $tag == 'textarea'){$raw_tag = $tag;}
                    else if ($tag == '/pre' || $tag == '/textarea')
                    {$raw_tag = false;}
                    else{if ($raw_tag || $overriding){$strip = false;}else{$strip = true;
                        $content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
                        $content = str_replace(' />', '/>', $content);}}}
                if ($strip){$content = $this->removeWhiteSpace($content);}
                $html .= $content;}
            return $html;}
        public function parseHTML($html) {
            $this->html = $this->minifyHTML($html);
            if ($this->info_comment){$this->html .= "\n" . $this->bottomComment($html, $this->html);}}
        protected function removeWhiteSpace($str) {
            $str = str_replace("\t", ' ', $str);
            $str = str_replace("\n",  '', $str);
            $str = str_replace("\r",  '', $str);
            while (stristr($str, '  ')){$str = str_replace('  ', ' ', $str);}
            return $str;}
    }
    function wp_html_compression_finish($html){return new Compress_HTML($html);}
    function wp_html_compression_start(){ob_start('wp_html_compression_finish');}
    add_action('get_header', 'wp_html_compression_start');  
}



//удаление aria-current в ссылках в меню
add_filter( 'nav_menu_link_attributes', 'filter_function_name_3020', 10, 4 );
function filter_function_name_3020( $atts, $item, $args, $depth ){
  $atts['aria-current'] = '';

  return $atts;
}

//качество картинок 100%
function jpeg_sgatie( $quality ) {  
    return 100;
}
add_filter( 'jpeg_quality', 'jpeg_sgatie' );
# Отменим `-scaled` размер - ограничение максимального размера картинки 
add_filter( 'big_image_size_threshold', '__return_false' );

//элементор: новые расположения частей макета сайта
function theme_prefix_register_elementor_locations( $elementor_theme_manager ) {

    $elementor_theme_manager->register_all_core_location();

}
add_action( 'elementor/theme/register_locations', 'theme_prefix_register_elementor_locations' );



/*
поместив данный код в самый низ сайта можно получить все зарегистрированные миниатюры с их размерами
function get_image_sizes( $unset_disabled = true ) {
    $wais = & $GLOBALS['_wp_additional_image_sizes'];

    $sizes = array();

    foreach ( get_intermediate_image_sizes() as $_size ) {
        if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
            $sizes[ $_size ] = array(
                'width'  => get_option( "{$_size}_size_w" ),
                'height' => get_option( "{$_size}_size_h" ),
                'crop'   => (bool) get_option( "{$_size}_crop" ),
            );
        }
        elseif ( isset( $wais[$_size] ) ) {
            $sizes[ $_size ] = array(
                'width'  => $wais[ $_size ]['width'],
                'height' => $wais[ $_size ]['height'],
                'crop'   => $wais[ $_size ]['crop'],
            );
        }

        // size registered, but has 0 width and height
        if( $unset_disabled && ($sizes[ $_size ]['width'] == 0) && ($sizes[ $_size ]['height'] == 0) )
            unset( $sizes[ $_size ] );
    }

    return $sizes;
}

die( print_r( get_image_sizes() ) );
 */

/*
это код отключиения зарегистрированных миниатюр, я его не использую так как переопредилил для зарегистрированных миниатюр такие размеры чтоб они совпадали с миниатюрами этой темы =)
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
    // размеры которые нужно удалить
    return array_diff( $sizes, [
        //'medium_large',//768 в админке поменяю на 800 и не буду делать копию в 768
        //'medium',//300 , в админке настроил чтоб ширина была фиксированно 300, а выстора маштабировалась т.е. 0 в настройках
        //'large',//1024 в админке поменяю на 1000 и не буду делать копию в 1024
        //'1536x1536',//1536 в админке поменяю на 1600 и не буду делать копию в 1536
        //'2048x2048',//2048 в админке поменяю на 2000 и не буду делать копию в 2048
    ] );
}
*/





//print_r(glob(CACHE_DIR.'/*'));

//copy_all_fills_between_folders("E:/1SERVER\domains\peter.ru/wp-content/cache/ksn_cache/peter.ru/a1", "E:/1SERVER\domains\peter.ru/wp-content/cache/ksn_cache/peter.ru/a2/b1/a1", true);//копируем


//чистим шапку сайта от вп мусора
remove_action('wp_head', 'rest_output_link_wp_head', 10);//убираем <link rel="https://api.w.org/" href="http://peter.ru/wp-json/">
remove_action('wp_head', 'wp_generator');//удаляем версию и название движка вордпрес из верха сайта
remove_action('wp_head', 'print_emoji_detection_script', 7);// Отключаем emoji
remove_action('wp_print_styles', 'print_emoji_styles');// Отключаем emoji
remove_action( 'wp_head', 'wlwmanifest_link' );//удаляем <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://peter.ru/wp-includes/wlwmanifest.xml">
remove_action( 'wp_head', 'wp_resource_hints', 2 );//отключаем dns-prefetch
remove_action( 'wp_head', 'wp_shortlink_wp_head' );//<link rel="shortlink" href="http://peter.ru/">
remove_action( 'wp_head','wp_oembed_add_discovery_links');//<link rel="alternate" type="application/json+oembed" href="http://peter.ru/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fpeter.ru%2F"> <link rel="alternate" type="text/xml+oembed" href="http://peter.ru/wp-json/oembed/1.0/embed?url=http%3A%2F%2Fpeter.ru%2F&amp;format=xml">
remove_action( 'wp_head', 'rsd_link' );//<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://peter.ru/xmlrpc.php?rsd">



//remove_action ('wp_head', 'wp_site_icon', 99);//удалит все мета теги для вывода фавикона
//чистим шапку сайта от вп мусора