<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Custom_Media_Uploader;
use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

class header_widget extends Widget_Base {
	public function get_name() {
		return 'header_widget';
	}
	public function get_title() {
		return 'Верх сайта';
	}
	public function get_icon() {
		return 'eicon-header';
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
				'default' => 'yes',
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
			'header_section',
			[
				'label' => 'Логотип',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'logo',
			[
				'label' => 'Выберете картинку логотипа',
				'type' => Custom_Media_Uploader::custom_media_uploader,
				'default' => [
                    'url' => get_theme_root_uri().'/serge_produkt/img/logo.svg',
                ],
				'media_type' => 'image/svg+xml',
				'description' => 'Выберете логотип в формате svg, соотношение сторон 15:4 , ширина к высоте',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'header_phone_section',
			[
				'label' => 'Телефон',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'phone_mobi',
			[
				'label' => 'Введите телефон',
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 1,
				'placeholder' => '+79999999999',
				'description' => 'Введите телефон для "звонилки" в верху сайта в мобильной версии',
			]
		);
		$this->add_control(
			'phone_mobi_img',
			[
				'label' => 'Картинка "звонилки"',
				'type' => Custom_Media_Uploader::custom_media_uploader,
				'default' => [
                    'url' => get_theme_root_uri().'/serge_produkt/img/phone.svg',
                ],
                'description' => 'Выберете какртинку для "звонилки", в формате svg, соотношение сторон 1:1 , ширина к высоте',
			]
		);
		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
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
	<header class="col-12 block_type_mutation 
	<?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
	 <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
        <div id="top_menushka" class="<?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
                <div id="logo_wrap" class="col-xl-2 col-lg-1 col-xs-6 item_top_menu">
                	<a href="/">
                		<div class="img_wrapper">
                			<img id="custom_logo_img" class="img_size" data-type="img_maket" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo wp_get_original_image_url( $settings['logo']['id'] );?>" alt="<?php echo get_post_meta($settings['logo']['id'], '_wp_attachment_image_alt', true);?>" title="<?php echo get_the_title($settings['logo']['id']);?>" data-original-w="<?php echo $settings['logo']['original_width'];?>" data-original-h="<?php echo $settings['logo']['original_height'];?>">
                			<script>data_site.ips();</script>
                		</div>
                	</a>
                </div>
                <div id="touch_menu" class="col-xs-5 touch_menu_block item_top_menu">
                    <div class="touch_menu_wrapper">
                        <div class="burger-line first"></div>
                        <div class="burger-line second"></div>
                        <div class="burger-line third"></div>
                        <div class="burger-line fourth"></div>
                    </div>
                </div>
                <div id="zvonilka" class="col-xs-1 item_top_menu">
                    <a href="tel:+<?php $phone = preg_replace('![^0-9]+!', '', $settings['phone_mobi']); echo $phone; ?>">
                    	<div class="img_wrapper">
                            <img class="img_size" data-type="img_maket" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="<?php echo wp_get_original_image_url( $settings['phone_mobi_img']['id'] );?>" alt="<?php echo get_post_meta($settings['phone_mobi_img']['id'], '_wp_attachment_image_alt', true);?>" data-original-w="<?php echo $settings['phone_mobi_img']['original_width'];?>" data-original-h="<?php echo $settings['phone_mobi_img']['original_height'];?>">
                            <script>data_site.ips();</script>
                    	</div>
                    </a>
                </div>
                <?php
                wp_nav_menu( array(
                    'menu'            => 'menu_header',              // (string) Название выводимого меню (указывается в админке при создании меню, приоритетнее 
                                                          // чем указанное местоположение theme_location - если указано, то параметр theme_location игнорируется)
                    'container'       => 'nav',           // (string) Контейнер меню. Обворачиватель ul. Указывается тег контейнера (по умолчанию в тег div)
                    'container_class' => 'menu_wrap col-xl-10 col-lg-11 item_top_menu',              // (string) class контейнера (div тега)
                    'container_id'    => 'menu_block',              // (string) id контейнера (div тега)
                    'menu_class'      => 'topmenu',          // (string) class самого меню (ul тега)
                    'menu_id'         => 'primary_menu',              // (string) id самого меню (ul тега)
                    'echo'            => true,            // (boolean) Выводить на экран или возвращать для обработки
                    'fallback_cb'     => 'wp_page_menu',  // (string) Используемая (резервная) функция, если меню не существует (не удалось получить)
                    'before'          => '',              // (string) Текст перед <a> каждой ссылки
                    'after'           => '<div class="op_cl">
                    						<div class="wrap_lb">
												<div class="lb_1"></div>
												<div class="lb_2"></div>
												<div class="lb_center"></div>
											</div>
										  </div>',              // (string) Текст после </a> каждой ссылки
                    'link_before'     => '',              // (string) Текст перед анкором (текстом) ссылки
                    'link_after'      => '',              // (string) Текст после анкора (текста) ссылки
                    'depth'           => 0,               // (integer) Глубина вложенности (0 - неограничена, 2 - двухуровневое меню)
                    'walker'          => '',              // (object) Класс собирающий меню. Default: new Walker_Nav_Menu
                    'theme_location'  => 'Primary'               // (string) Расположение меню в шаблоне. (указывается ключ которым было зарегистрировано меню в функции register_nav_menus)
                ) );
                ?>
        </div>
    </header>
<?php }
	protected function content_template() {
		?>
		<style>
			#logo_wrap img {
			    opacity: 1;
			}
		</style>	
		<header class="col-12 block_type_mutation 
		<# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#>
		 <# if(settings.padding_left=='yes'){#> pl-0 <#} if(settings.padding_top=='yes'){#> pt-0 <#} if(settings.padding_right=='yes'){#> pr-0 <#} if(settings.padding_bottom=='yes'){#> pb-0 <#}#>">
        <div id="top_menushka" class="{{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
                <div id="logo_wrap" class="col-xl-2 col-lg-1 col-xs-6 item_top_menu">
                	<a href="/">
                		<div class="img_wrapper">
                			<img id="custom_logo_img" src="{{ settings.logo.url }}">
                		</div>
                	</a>
                </div>
                <div id="touch_menu" class="col-xs-5 touch_menu_block item_top_menu">
                    <div class="touch_menu_wrapper">
                        <div class="burger-line first"></div>
                        <div class="burger-line second"></div>
                        <div class="burger-line third"></div>
                        <div class="burger-line fourth"></div>
                    </div>
                </div>
                <div id="zvonilka" class="col-xs-1 item_top_menu">
                    <a href="#">
                    	<img src="{{ settings.phone_mobi_img.url }}">
                    </a>
                </div>
                <?php
                wp_nav_menu( array(
                    'menu'            => 'menu_header',              // (string) Название выводимого меню (указывается в админке при создании меню, приоритетнее 
                                                          // чем указанное местоположение theme_location - если указано, то параметр theme_location игнорируется)
                    'container'       => 'nav',           // (string) Контейнер меню. Обворачиватель ul. Указывается тег контейнера (по умолчанию в тег div)
                    'container_class' => 'menu_wrap col-xl-10 col-lg-11 item_top_menu',              // (string) class контейнера (div тега)
                    'container_id'    => 'menu_block',              // (string) id контейнера (div тега)
                    'menu_class'      => 'topmenu',          // (string) class самого меню (ul тега)
                    'menu_id'         => 'primary_menu',              // (string) id самого меню (ul тега)
                    'echo'            => true,            // (boolean) Выводить на экран или возвращать для обработки
                    'fallback_cb'     => 'wp_page_menu',  // (string) Используемая (резервная) функция, если меню не существует (не удалось получить)
                    'before'          => '',              // (string) Текст перед <a> каждой ссылки
                    'after'           => '<div class="op_cl">
                    						<div class="wrap_lb">
												<div class="lb_1"></div>
												<div class="lb_2"></div>
												<div class="lb_center"></div>
											</div>
										  </div>',              // (string) Текст после </a> каждой ссылки
                    'link_before'     => '',              // (string) Текст перед анкором (текстом) ссылки
                    'link_after'      => '',              // (string) Текст после анкора (текста) ссылки
                    'depth'           => 0,               // (integer) Глубина вложенности (0 - неограничена, 2 - двухуровневое меню)
                    'walker'          => '',              // (object) Класс собирающий меню. Default: new Walker_Nav_Menu
                    'theme_location'  => 'Primary'               // (string) Расположение меню в шаблоне. (указывается ключ которым было зарегистрировано меню в функции register_nav_menus)
                ) );
                ?>
        </div>
    </header>
	<?php
	}
	
}	