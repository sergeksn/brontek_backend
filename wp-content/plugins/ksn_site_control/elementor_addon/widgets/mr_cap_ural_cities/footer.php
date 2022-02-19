<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Custom_Media_Uploader;
use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Custom_Repeater;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Plugin;

class footer_widget extends Widget_Base {
    public function get_name() {
        return 'footer_widget';
    }
    public function get_title() {
        return 'Низ сайта';
    }
    public function get_icon() {
        return 'eicon-footer';
    }
    public function get_categories() {
        return [ 'shablon_sayta' ];
    }
    
    protected function register_controls() {

        $this->start_controls_section(
            'setting_blok_section',
            [
                'label' => 'Настройка шаблона',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'popover_toggle_1',
            [
                'label' => 'Типы устройств',
                'type' => Custom_Popover_Toggle::POPOVER_TOGGLE,
                'label_off' => 'Default',
                'label_on' => 'Custom',
                'return_value' => 'yes',
                'castom_type' => '2',
                'description' => 'Задаёт для каких устройств блок будет отображаться.',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'prefer_devices',
            [
                'type' => Control_show_block_on_device::control_show_block_on_device,
                'default' => [],
                'description' => 'Для каких устройств блок будет отображаться?<br><span class="vazho_red">ПРИМЕЧАНИЕ:</span> если устройство не определено оно будет считаться компьютером! Так же блок будет доступен как минимум для 1 типа устройств!',
            ]
        );

        $this->end_popover();

        $this->add_control(
            'popover_toggle_2',
            [
                'label' => 'Отсупы у блока',
                'type' => Custom_Popover_Toggle::POPOVER_TOGGLE,
                'label_off' => 'Default',
                'label_on' => 'Custom',
                'return_value' => 'yes',
                'castom_type' => '2',
                'description' => 'Убирает отсупы с выбранной стороны (лево-права-верх-низ) у блока',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'padding_left',
            [
                'label' => 'Убрать отсупы блока слева?',
                'type' => Custom_switcher::custom_switcher,
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->add_control(
            'padding_top',
            [
                'label' => 'Убрать отсупы блока сверху?',
                'type' => Custom_switcher::custom_switcher,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'padding_right',
            [
                'label' => 'Убрать отсупы блока справа?',
                'type' => Custom_switcher::custom_switcher,
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->add_control(
            'padding_bottom',
            [
                'label' => 'Убрать отсупы блока снизу?',
                'type' => Custom_switcher::custom_switcher,
                'return_value' => 'yes',
                'default' => '',
                'description' => 'Если выбрано "Да" то внутренний отступ от края блока в выбранном направлении (лево-права-верх-низ) будет убран до нуля. <br><span class="vazho_red">Примечание:</span> отключение отступов сверху или снизу вполне приемлемо для всех блоков и используется для регулирования отсупов между блоками.',
            ]
        );

        $this->end_popover();

        $this->add_control(
            'shrina',
            [
                'label' => 'Ширина блока',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'col-xl-9' => '75%',
                    'col-xl-11' => '90%',
                    'col-xl-12' => '100%',
                ],
                'default' => 'col-xl-12',
                'description' => 'Выберете ширину всего блока. <br><span class="vazho_red">ВАЖНО:</span> данная функция применяется только к экранам свыше 1200px в ширину!',
            ]
        );
        $this->add_control(
            'align_block',
            [
                'label' => 'Выравнивание блока',
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'mr-auto ml-0' => 'Слева',
                    'm-auto' => 'По центру',
                    'ml-auto mr-0' => 'Справа',
                ],
                'default' => 'm-auto',
                'description' => 'Выберете выравнивание блока относительно левой и правой сторон экрана браузера. <br><span class="vazho_red">ВАЖНО:</span> данная функция применяется только к экранам свыше 1200px в ширину!',
                'condition' => [
                    'shrina!' => 'col-xl-12',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'uslugi_section',
            [
                'label' => 'Услуги',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'uslugi_title',
            [
                'label' => 'Заголовк блока услуги',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 1,
                'default' => '',
                'placeholder' => 'НАШИ УСЛУГИ',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'adresa_section',
            [
                'label' => 'Адреса',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'adresa_title',
            [
                'label' => 'Заголовк блока адресов',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 1,
                'default' => '',
                'placeholder' => 'НАШИ АДРЕСА',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'adres',
            [
                'label' => 'Адрес',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'description' => 'Перенос строки с помощью &lt;br&gt;',
                'default' => '',
                'placeholder' => '',
            ]
        );
        $repeater->add_control(
            'phone',
            [
                'label' => 'Телефон',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 1,
                'default' => '',
                'placeholder' => '',
            ]
        );
        $repeater->add_control(
            'map',
            [
                'label' => 'Карта (iframe)',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 15,
                'placeholder' => 'iframe код с картой',
                'description' => '
                    <ol>
                        <li>1. Перейдите в <a href="//maps.google.com" target="_blank">Google Карты</a>.</li>
                        <li>2 .Откройте карту или панораму из «Просмотра улиц», которую нужно добавить на сайт.</li>
                        <li>3. Нажмите на значок главного меню <img style="vertical-align: middle;margin:0;box-shadow:none;" src="//lh3.ggpht.com/9DpHdseRn4uZvj3XKoyEV4f3BlVSV4-1ta1WInvaqykX0a8KVvv3Z7FWGHlsKlOab58=w19" alt="" class="illustration"> в левом верхнем углу экрана.</li>
                        <li>4. Выберите «Ссылка/код».</li>
                        <li>5. В открывшемся окне перейдите на вкладку «Встраивание карт».</li>
                        <li>6. Скопируйте код, для этого нажмине на кнопку «Копировать HTML», после вставьте его в это текстовое поле.</li><br>
                        <li>УРА! Вы добавили карту!</li>
                    </ol>
                    ',
            ]
        );
        $this->add_control(
            'adres_list',
            [
                'label' => 'Добавьте адрес',
                'type' => Custom_Repeater::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [],
                ],
                'title_field' => '{{{ adres }}}',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'socseti_section',
            [
                'label' => 'Соцсети',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'socseti_title',
            [
                'label' => 'Заголовк блока соцсетей',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 1,
                'default' => '',
                'placeholder' => 'МЫ В СОЦСЕТЯХ',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => 'Выберете изображение соцсети в формате svg, соотношение сторон 1:1 , ширина к высоте',
                'type' => Custom_Media_Uploader::custom_media_uploader,
                'default' => [
                    'url' => get_theme_root_uri().'/serge_produkt/img/ytube.svg',
                ],
                'media_type' => 'image/svg+xml',
            ]
        );
        $repeater->add_control(
            'set_url_open',
            [
                'label' => 'Открывать в новой вкладке?',
                'type' => Custom_switcher::custom_switcher,
                'label_on' => 'ДА',
                'label_off' => 'НЕТ',
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $repeater->add_control(
            'set',
            [
                'label' => 'Название соцсети',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 1,
                'default' => '',
                'placeholder' => '',
            ]
        );
        $repeater->add_control(
            'set_url',
            [
                'label' => 'Ссылка для соцсети',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'default' => '',
                'placeholder' => '',
            ]
        );
        $this->add_control(
            'set_list',
            [
                'label' => 'Добавьте соцсети',
                'type' => Custom_Repeater::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [],
                ],
                'title_field' => '{{{ set }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'maket_img_section',
            [
                'label' => 'Картинки макета',
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'back_top_image',
            [
                'label' => 'Кнопка вверх',
                'type' => Custom_Media_Uploader::custom_media_uploader,
                'default' => [
                    'url' => get_theme_root_uri().'/serge_produkt/img/btn_up.svg',
                ],
                'media_type' => 'image/svg+xml',
                'description' => 'Выберете изображение кнопки вверх в формате svg, соотношение сторон 1:1 , ширина к высоте',
            ]
        );
        $this->add_control(
            'triger_map_image',
            [
                'label' => 'Иконка триггера карты',
                'type' => Custom_Media_Uploader::custom_media_uploader,
                'default' => [
                    'url' => get_theme_root_uri().'/serge_produkt/img/map.svg',
                ],
                'media_type' => 'image/svg+xml',
                'description' => 'Выберете изображение триггера карты возле адреса в формате svg, соотношение сторон 1:2 , ширина к высоте',
            ]
        );
        $this->add_control(
            'close_map_image',
            [
                'label' => 'Иконка закрыть окно с картой',
                'type' => Custom_Media_Uploader::custom_media_uploader,
                'default' => [
                    'url' => get_theme_root_uri().'/serge_produkt/img/close.svg',
                ],
                'media_type' => 'image/svg+xml',
                'description' => 'Выберете изображение закрытия всплывающего окна с картой в формате svg, соотношение сторон 1:1 , ширина к высоте',
            ]
        );
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes( 'uslugi_title', 'none' );
        $this->add_inline_editing_attributes( 'adresa_title', 'none' );
        $this->add_inline_editing_attributes( 'socseti_title', 'none' );

        $is_elementor = (!Plugin::$instance->preview->is_preview_mode() && !Plugin::$instance->editor->is_edit_mode()) ? false : true;//проверяет что мы в редакторе элементора или в его предпросмотре

        if (!$is_elementor) {//вне элементора

            //если пк устройство и для них блок отключён
            if(isDesktop() && $settings['prefer_devices']['show_desktop'] !== 'yes'){
                return;
            }
            //если пк устройство и для них блок отключён

            //если планшетное устройство и для них блок отключён
            if(isTablet() && $settings['prefer_devices']['show_tablet'] !== 'yes'){
                return;
            }
            //если планшетное устройство и для них блок отключён

            //если мобильное устройство и для них блок отключён
            if(isMobile() && $settings['prefer_devices']['show_mobile'] !== 'yes'){
                return;
            }
            //если мобильное устройство и для них блок отключён
        } else {//при работе с элементором
            $show_desktop = $settings['prefer_devices']['show_desktop'] === 'yes' ? null : 'hide_desktop';
            $show_tablet = $settings['prefer_devices']['show_tablet'] === 'yes' ?  null : 'hide_tablet';
            $show_mobile = $settings['prefer_devices']['show_mobile'] === 'yes' ?  null : 'hide_mobile';
        }

    ?>
    <footer class="col-12 block_type_mutation 
    <?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
     <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
        <div class="<?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
            <div class="col-12 foot_wrap flex_display">
                <div class="col-xs-12 col-md-4 col-lg-4">
                    <div class="footer_zagolovok">
                        <span <?php echo $this->get_render_attribute_string( 'uslugi_title' ); ?>><?php echo $settings['uslugi_title']; ?></span>
                    </div>
                    <div class="footer_line_yllow"></div>
                    <?php
                        wp_nav_menu( array(
                            'menu'            => 'menu_footer',              /* (string) Название выводимого меню (указывается в админке при создании меню, приоритетнее чем указанное местоположение theme_location - если указано, то параметр theme_location игнорируется) */
                            'container'       => 'div',           // (string) Контейнер меню. Обворачиватель ul. Указывается тег контейнера (по умолчанию в тег div)
                            'container_class' => '',              // (string) class контейнера (div тега)
                            'container_id'    => 'container_menu_footer',              // (string) id контейнера (div тега)
                            'menu_class'      => '',          // (string) class самого меню (ul тега)
                            'menu_id'         => 'menu_footer',              // (string) id самого меню (ul тега)
                            'echo'            => true,            // (boolean) Выводить на экран или возвращать для обработки
                            'fallback_cb'     => 'wp_page_menu',  // (string) Используемая (резервная) функция, если меню не существует (не удалось получить)
                            'before'          => '',              // (string) Текст перед <a> каждой ссылки
                            'after'           => '',              // (string) Текст после </a> каждой ссылки
                            'link_before'     => '',              // (string) Текст перед анкором (текстом) ссылки
                            'link_after'      => '',              // (string) Текст после анкора (текста) ссылки
                            'depth'           => 0,               // (integer) Глубина вложенности (0 - неограничена, 2 - двухуровневое меню)
                            'walker'          => '',              // (object) Класс собирающий меню. Default: new Walker_Nav_Menu
                            'theme_location'  => 'Footer'               // (string) Расположение меню в шаблоне. (указывается ключ которым было зарегистрировано меню в функции register_nav_menus)
                        ) );
                    ?>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-3">
                    <div class="footer_zagolovok">
                        <span <?php echo $this->get_render_attribute_string( 'adresa_title' ); ?>><?php echo $settings['adresa_title']; ?></span>
                    </div>
                    <div class="footer_line_yllow"></div>
                    <?php if ( $settings['adres_list'] ) {
                            foreach (  $settings['adres_list'] as $item ) { ?>
                                <div class="futer_block_item">
                                    <div class="adres_footer">
                                        <div class="trigger_open_modal"><?php echo $item['adres']; ?></div>
                                        <div class="img_addres trigger_open_modal">
                                            <div class="img_wrapper">
                                                <img class="img_size" data-type="img_maket" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo wp_get_original_image_url( $settings['triger_map_image']['id'] );?>" alt="<?php echo get_post_meta($settings['triger_map_image']['id'], '_wp_attachment_image_alt', true);?>" data-original-w="<?php echo $settings['triger_map_image']['original_width'];?>" data-original-h="<?php echo $settings['triger_map_image']['original_height'];?>">
                                                <script>data_site.ips();</script>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="phon_footer">
                                        <a href="tel:+<?php $phone_1 = preg_replace('![^0-9]+!', '', $item['phone']); echo $phone_1; ?>"><?php echo $item['phone']; ?></a>
                                    </div>

                                    <?php //окно с картой ?>
                                    <div class="modal_form"> 
                                        <span class="modal_close">
                                            <img data-type="img_maket" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo wp_get_original_image_url( $settings['close_map_image']['id'] );?>" alt="<?php echo get_post_meta($settings['close_map_image']['id'], '_wp_attachment_image_alt', true);?>">
                                        </span>
                                        <div class="modal_map_wraper">
                                          <div class="media_loader">
                                              <div class="loader"></div>
                                          </div>
                                          <div class="map_coment"><!--<?php echo $item['map']; ?>--></div>
                                        </div>
                                    </div>
                                    <div class="overlay"></div>
                                    <?php //окно с картой ?>

                                </div>
                            <?php }
                        } ?>
                <script>data_site.l();</script>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-3">
                    <div class="footer_zagolovok">
                        <span <?php echo $this->get_render_attribute_string( 'socseti_title' ); ?>><?php echo $settings['socseti_title']; ?></span>
                    </div>
                    <div class="footer_line_yllow soc"></div>
                        <?php if ( $settings['set_list'] ) {
                            foreach (  $settings['set_list'] as $item ) { ?>
                                <div class="item_soc">
                                    <div class="item_soc_img_wrap">
                                        <div class="img_wrapper">
                                            <img class="img_size" data-type="img_maket" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo wp_get_original_image_url( $item['image']['id'] );?>" alt="<?php echo get_post_meta($item['image']['id'], '_wp_attachment_image_alt', true);?>" title="<?php echo get_the_title($item['image']['id']);?>" data-original-w="<?php echo $item['image']['original_width'];?>" data-original-h="<?php echo $item['image']['original_height'];?>">
                                            <script>data_site.ips();</script>
                                        </div>
                                    </div>
                                    <a href="<?php echo $item['set_url'];?>" <?php if ( $item['set_url_open'] === 'yes') { ?>target="_blank"<?php } ?> rel="noopener">
                                        <span class="set_name"><?php echo $item['set']; ?></span>
                                    </a>
                                </div>
                            <?php }
                        } ?>
                </div>
            </div>
        </div>
        <?php //кнопка вверх ?>
        <div class="scrollup">
            <div class="img_wrapper">
                <img class="img_size" data-type="img_maket" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo wp_get_original_image_url( $settings['back_top_image']['id'] );?>" alt="<?php echo get_post_meta($settings['back_top_image']['id'], '_wp_attachment_image_alt', true);?>" data-original-w="<?php echo $item['image']['original_width'];?>" data-original-h="<?php echo $item['image']['original_height'];?>">
                <script>data_site.ips();</script>
            </div>
        </div>
        <?php //кнопка вверх ?>
    </footer>



    <?php }

    protected function content_template() {
        ?>
    <style>
        .foot_wrap img {
            opacity: 1;
        }
        .scrollup img{
            position: relative;
            opacity: 1;
        }
    </style>
    <footer class="col-12 block_type_mutation 
    <# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#> 
     <# if(settings.padding_left=='yes'){#> pl-0 <#} if(settings.padding_top=='yes'){#> pt-0 <#} if(settings.padding_right=='yes'){#> pr-0 <#} if(settings.padding_bottom=='yes'){#> pb-0 <#}#>">
        <div class="{{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
            <div class="col-12 foot_wrap flex_display">
                <div class="col-xs-12 col-md-4 col-lg-4">
                    <div class="footer_zagolovok">
                        <#
                        view.addInlineEditingAttributes( 'uslugi_title', 'none' );
                        view.addInlineEditingAttributes( 'adresa_title', 'none' );
                        view.addInlineEditingAttributes( 'socseti_title', 'none' );
                        #>
                        <span {{{ view.getRenderAttributeString( 'uslugi_title' ) }}}>{{{ settings.uslugi_title }}}</span>
                    </div>
                    <div class="footer_line_yllow"></div>
                    <?php
                        wp_nav_menu( array(
                            'menu'            => 'menu_footer',              /* (string) Название выводимого меню (указывается в админке при создании меню, приоритетнее чем указанное местоположение theme_location - если указано, то параметр theme_location игнорируется) */
                            'container'       => 'div',           // (string) Контейнер меню. Обворачиватель ul. Указывается тег контейнера (по умолчанию в тег div)
                            'container_class' => '',              // (string) class контейнера (div тега)
                            'container_id'    => 'container_menu_footer',              // (string) id контейнера (div тега)
                            'menu_class'      => '',          // (string) class самого меню (ul тега)
                            'menu_id'         => 'menu_footer',              // (string) id самого меню (ul тега)
                            'echo'            => true,            // (boolean) Выводить на экран или возвращать для обработки
                            'fallback_cb'     => 'wp_page_menu',  // (string) Используемая (резервная) функция, если меню не существует (не удалось получить)
                            'before'          => '',              // (string) Текст перед <a> каждой ссылки
                            'after'           => '',              // (string) Текст после </a> каждой ссылки
                            'link_before'     => '',              // (string) Текст перед анкором (текстом) ссылки
                            'link_after'      => '',              // (string) Текст после анкора (текста) ссылки
                            'depth'           => 0,               // (integer) Глубина вложенности (0 - неограничена, 2 - двухуровневое меню)
                            'walker'          => '',              // (object) Класс собирающий меню. Default: new Walker_Nav_Menu
                            'theme_location'  => 'Footer'               // (string) Расположение меню в шаблоне. (указывается ключ которым было зарегистрировано меню в функции register_nav_menus)
                        ) );
                    ?>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-3">
                    <div class="footer_zagolovok">
                        <span {{{ view.getRenderAttributeString( 'adresa_title' ) }}}>{{{ settings.adresa_title }}}</span>
                    </div>
                    <div class="footer_line_yllow"></div>
                        <# if ( settings.adres_list.length ) { #>
                            <# _.each( settings.adres_list, function( item ) { #>
                                <div class="futer_block_item">
                                    <div class="adres_footer">
                                        <div class="trigger_open_modal">{{{ item.adres }}}</div>
                                        <div class="img_addres trigger_open_modal">
                                            <img src="{{ settings.triger_map_image.url }}">
                                        </div>
                                    </div>
                                    <div class="phon_footer">
                                        <a href="#">{{{ item.phone }}}</a>
                                    </div>
                                    <div class="modal_form"> 
                                        <span class="modal_close">
                                            <img src="{{ settings.close_map_image.url }}">
                                        </span>
                                        <div class="modal_map_wraper">
                                          <div class="media_loader">
                                              <div class="loader"></div>
                                          </div>
                                          <div class="map_coment"><!--{{{ item.map }}}--></div>
                                        </div>
                                    </div>
                                    <div class="overlay"></div>
                                </div>
                                <# }); #>
                            <# } #>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-3">
                    <div class="footer_zagolovok">
                        <span {{{ view.getRenderAttributeString( 'socseti_title' ) }}}>{{{ settings.socseti_title }}}</span>
                    </div>
                    <div class="footer_line_yllow soc"></div>
                        <# if ( settings.set_list.length ) { #>
                            <# _.each( settings.set_list, function( item ) { #>
                            <div class="item_soc">
                                <div class="item_soc_img_wrap">
                                    <img class="col-12" src="{{ item.image.url }}">
                                </div>
                                <a href="{{ item.set_url }}" <# if ( 'yes' === item.set_url_open ) { #>target="_blank"<# } #>>
                                    <span class="set_name">{{{ item.set }}}</span>
                                </a>
                            </div>
                            <# }); #>
                        <# } #>
                </div>
            </div>
        </div>
        <?php //кнопка вверх ?>
        <div class="scrollup">
            <div class="img_wrapper">
                <img src="{{ settings.back_top_image.url }}">
            </div>
        </div>
        <?php //кнопка вверх ?>
    </footer>

    <script>data_site.l();</script>
        <?php
    }

    
}   