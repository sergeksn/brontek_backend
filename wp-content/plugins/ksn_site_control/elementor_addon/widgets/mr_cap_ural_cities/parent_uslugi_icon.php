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

class parent_uslugi_icon extends Widget_Base {
	public function get_name() {
		return 'parent_uslugi_icon';
	}
	public function get_title() {
		return 'Иконка с текстом';
	}
	public function get_icon() {
		return 'eicon-image-box';
	}
	public function get_categories() {
		return [ 'bloki_dla_stranic_saita' ];
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
				'description' => 'В положении "Да" убирает отступы (слева ) блока, данная опция может быть использованна для получения блока с картинкой на всю ширину окна браузера.',
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
				'default' => '',
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
				'default' => 'col-xl-9',
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
			'content_section',
			[
				'label' => 'Иконка с текстом',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

        $repeater->add_control(
            'image',
			[
				'label' => 'Выберете иконку',
				'type' => Custom_Media_Uploader::custom_media_uploader,
				'default' => [
					'url' => KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/25.svg',
				],
				'media_type' => 'image/svg+xml',
				'description' => 'Выберете иконку в формате svg, соотношение сторон 1:1 , ширина к высоте',
			]
        );
        $repeater->add_control(
			'dobavlyt_text_zagolovok',
			[
				'label' => 'Нужен ли заголовок под иконкой?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        $repeater->add_control(
            'text_zagolovok',
            [
                'label' => 'Заголовок под иконкой',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 4,
                'default' => 'Заголовок под иконкой',
                'placeholder' => 'Заголовок под иконкой',
                'description' => 'Заголовк под иконкой, если он не заполнен то блок будет выведен без него. <br><span class="vazho_red">ВАЖНО:</span> данный текст не является ни одним из SEO заголовков H1-H6!',
            	'condition' => [
				    'dobavlyt_text_zagolovok' => 'yes',
				],
            ]
        );
    	$repeater->add_control(
			'dobavlyt_text_description',
			[
				'label' => 'Нужно ли описание под иконкой?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => '',
			]
		);
        $repeater->add_control(
            'text_description',
            [
                'label' => 'Описание под иконкой',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 4,
                'placeholder' => 'Описание под иконкой',
                'description' => 'Текст описания под иконкой, если он не заполнен то блок будет выведен без него',
            	'condition' => [
				    'dobavlyt_text_description' => 'yes',
				],
            ]
        );
        $this->add_control(
            'icons_list',
            [
                'label' => 'Создайте блоки иконок с текстом',
                'type' => Custom_Repeater::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [],
                    [],
                    [],
                    [],
                    [],
                    [],
                ],
                'description' => '<span class="vazho_red">Примечание:</span> блоков с иконками можно добавлять сколько угодно, они будут выстраиваться в ряды, по 3 штуки в ряд.',
                'title_field' => '{{{ text_zagolovok }}}',
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
	<div class="col-12 block_type_mutation 
		<?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
		<?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
		<div class="<?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12 flex_display justify_content_center">
		    	<?php if ( $settings['icons_list'] ) {
	            foreach (  $settings['icons_list'] as $item ) { ?>
	            <div class="col-xs-12 col-sm-6 col-md-4 icon_block">
	            	<div class="icon_wrap">
				        <div class="col-12 img_wrapper">
				            <img class="img_icon img_size" data-type="img_content" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" 
				            <?php if($item['image']['id']){ ?>
				           		<?php echo 'data-src="'.wp_get_original_image_url( $item['image']['id'] ).'" alt="'.get_post_meta($item['image']['id'], '_wp_attachment_image_alt', true).'" title="'.get_the_title($item['image']['id']).'" data-original-w="'.$item['image']['original_width'].'" data-original-h="'.$item['image']['original_height'].'"';?>
				            <?php } else{ ?>
				            	data-src="<?php echo KSN_ELEMENTOR_ADDON_URL; ?>/assets/img/placeholder/25.svg" data-original-w="1" data-original-h="1"
				            <?php } ?>
				            >
				            <script>data_site.ips();</script>
				            <div class="media_loader">
				                <div class="loader"></div>
				            </div>
				            <script>data_site.l();</script>
				        </div>
			        </div>
			        <?php if ($item['text_zagolovok'] && $item['dobavlyt_text_zagolovok']) { ?>
			        <div class="icon_zagolovok"><?php echo $item['text_zagolovok']; ?></div>
			        <?php } ?>
			        <?php if ($item['text_description'] && $item['dobavlyt_text_description']) { ?>
			        <div class="icon_text"><?php echo $item['text_description']; ?></div>
			        <?php } ?>
		        </div>
		        <?php }
	            } ?>
		</div>	
	</div>	
	<?php }

	protected function content_template() {
		?>
	<div class="col-12 block_type_mutation 
	<# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#>
	<# if(settings.padding_left=='yes'){#> pl-0 <#} if(settings.padding_top=='yes'){#> pt-0 <#} if(settings.padding_right=='yes'){#> pr-0 <#} if(settings.padding_bottom=='yes'){#> pb-0 <#}#>">
	    <div class="{{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12 flex_display justify_content_center">
	        <# if ( settings.icons_list.length ) { #>
	                <# _.each( settings.icons_list, function( item ) { #>
	            <div class="col-xs-12 col-sm-6 col-md-4 icon_block">
	            	<div class="icon_wrap">
				        <# if(item.image.id){ #>
				        <img class="img_icon" src="{{item.image.url}}" alt="{{item.image.alt}}" title="{{item.image.title}}">
				        <# } else { #>
				        <img class="img_icon" src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/25.svg">
				    	<# } #>
			    	</div>
			        <# if(item.text_zagolovok && item.dobavlyt_text_zagolovok){ #>
			        <div class="icon_zagolovok">{{{ item.text_zagolovok }}}</div>
			        <# } #>
			        <# if(item.text_description && item.dobavlyt_text_description){ #>
			        <div class="icon_text">{{{ item.text_description }}}</div>
			        <# } #>
		        </div>
		        <# }); #>
	        <# } #>
		</div>
	</div>
		<?php
	}

	
}	