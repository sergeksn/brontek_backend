<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Control_blok_typs;
use KSN_Site_Konstruktor\Control\Custom_Media_Uploader;
use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

class razvorot_block extends Widget_Base {
	public function get_name() {
		return 'razvorot_block';
	}
	public function get_title() {
		return 'Блок с разворачивающимся текстом';
	}
	public function get_icon() {
		return 'eicon-image-before-after';
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
				'default' => 'yes',
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
				'default' => 'yes',
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
				'default' => 'col-xl-11',
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

		$this->add_control(
			'popover_toggle_3',
			[
				'label' => 'Выберете шаблон блока',
				'type' => Custom_Popover_Toggle::POPOVER_TOGGLE,
				'label_off' => 'Default',
				'label_on' => 'Custom',
				'return_value' => 'yes',
				'castom_type' => '2',
			]
		);

		$this->start_popover();

		$this->add_control(
            'blok_type',
            [
                'type' => Control_blok_typs::control_blok_typs,
                'value' => ['1','2'],
                'papka_s_img' => 'glavnaya_anim_img_text',
                'default' => '1',
                'description' => 'Выберете шаблон данного блока. Тут Вы определяете как располагаются текст и картинка относительно друг друга.',
            ]
        );

        $this->end_popover();

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_1',
			[
				'label' => 'Тексты',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'text',
			[
				'label' => 'Видимый текст в блоке',
				'dynamic' => [],
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'Видимый текст',
				'placeholder' => 'Видимый текст',
				'description' => 'Видимый текст в блоке',
			]
		);
		$this->add_control(
			'dobavlyt_skritiy_text',
			[
				'label' => 'Нужен ли скрытый текст?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => 'Если выбрано "Нет" то блок будет выглядеть просто как картинка с текстом, кнопка "Далее ..." добавляться не будет.',
			]
		);
		$this->add_control(
			'text_open',
			[
				'label' => 'Текст кнопки открыть',
				'type' => Controls_Manager::TEXT,
				'default' => 'Далее ...',
				'placeholder' => 'Далее ...',
				'condition' => [
				    'dobavlyt_skritiy_text' => 'yes',
				],
			]
		);
		$this->add_control(
			'text_close',
			[
				'label' => 'Текст кнопки закрыть',
				'type' => Controls_Manager::TEXT,
				'default' => 'Свернуть',
				'placeholder' => 'Свернуть',
				'condition' => [
				    'dobavlyt_skritiy_text' => 'yes',
				],
			]
		);
		$this->add_control(
			'skritiy_text',
			[
				'label' => 'Скрытый текст',
				'dynamic' => [],
				'type' => Controls_Manager::WYSIWYG,
				'default' => '',
				'placeholder' => 'Заполните текст',
				'description' => 'Это текст который будет появлятся при разворачивании блока, после нажатия на кнопку "Далее ...". <br><span class="vazho_red">ПРИМЕЧАНИЕ:</span> если текст пустой то блок будет выглядеть просто как картинка с текстом, кнопка "Далее ..." добавляться не будет.',
				'condition' => [
				    'dobavlyt_skritiy_text' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_2',
			[
				'label' => 'Картинка',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'image',
			[
				'label' => 'Выберете картинку',
				'type' => Custom_Media_Uploader::custom_media_uploader,
				'default' => [
					'url' => KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_2.png',
				],
				'description' => 'Выберете картинку, соотношение сторон 2:1 , ширина к высоте.',
			]
		);
		$this->end_controls_section();


	}

	protected function render() {//render
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

		$img_mas = [];//тут хранится код тега img из цикла для текущего набора картинок
		if( $settings['image'] ){//картинка
				if ( $settings['image']['id'] ) {
					$alt = get_post_meta($settings['image']['id'], '_wp_attachment_image_alt', true);
					$title = get_the_title($settings['image']['id']);
					$data_original_w = $settings['image']['original_width'];
					$data_original_h = $settings['image']['original_height'];
					$data_src_max = wp_get_original_image_url( $settings['image']['id'] );
					$img_mas[] = "
					data-original-w='$data_original_w'
					data-original-h='$data_original_h'
					data-src='$data_src_max'
					src='data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'
					alt='$alt'
					title='$title'";
				} else {
					$img_mas[] = "src='data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'";
				}
		}//картинка
	?>
	<?php //оболочка блока block_type_mutation ?>
	<div class="col-12 block_type_mutation <?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
	 <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
		<div class="razvorot_block <?php if($settings['blok_type'] == '2' ){ echo "order_1"; } ?> flex_display <?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
			<?php //оболочка блока block_type_mutation ?>



					<?php //оболочка картинки ?>
				    <div class="col-lg-4 col-xs-12 img_razvorot_block">

				        	<?php //картинка с лоадером ?>
				            <?php if ($settings['image']['id']) { ?>
				            <div class="col-12 img_wrapper">
				                <?php echo '<img class="img_size" data-type="img_content" '.$img_mas[0].'>';?>
				                <script>data_site.ips();</script>
				                <div class="media_loader">
				                    <div class="loader"></div>
				                </div>
				                <script>data_site.l();</script>
				            </div>
				            <?php } else { ?>
				            <div class="col-12 img_wrapper" style="padding-top: 50%;">
				                <?php echo '<img data-type="img_maket" data-src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_2.png" >';?>
				                <script>data_site.ips();</script>
				                <div class="media_loader">
				                    <div class="loader"></div>
				                </div>
				                <script>data_site.l();</script>
				            </div>
				            <?php } ?>
				            <?php //картинка с лоадером ?>

				    </div>
				    <?php //оболочка картинки ?>

				    <?php //оболочка текста ?>
				    <div class="col-lg-8 col-xs-12 wrap_razvorot_text">
				    	<div class="viseble_text"><?php echo $settings['text']; ?></div>
						<?php if ( $settings['dobavlyt_skritiy_text'] ==='yes' && !empty( $settings['skritiy_text'] ) ) { ?>
							<div class="skritiy_text">
								<?php echo $settings['skritiy_text']; ?>
							</div>
							<div class="open_close">
								<span class="open in_line"><?php echo $settings['text_open']; ?></span>
								<span class="close none_display"><?php echo $settings['text_close']; ?></span>
							</div>
						<?php } ?>

				    </div>
				    <?php //оболочка текста ?>



			<?php //оболочка блока block_type_mutation ?>
		</div>
	</div>
	<?php //оболочка блока block_type_mutation ?>
	




<?php }//render

protected function content_template() { ?>

	<?php //оболочка блока block_type_mutation ?>
	<div class="col-12 block_type_mutation 
	<# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#>
	 <# if(settings.padding_left=='yes'){#> pl-0 <#} if(settings.padding_top=='yes'){#> pt-0 <#} if(settings.padding_right=='yes'){#> pr-0 <#} if(settings.padding_bottom=='yes'){#> pb-0 <#}#>">
	    <div class="razvorot_block <# if( settings.blok_type == '2'){ #>order_1<# } #> flex_display {{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
	<?php //оболочка блока block_type_mutation ?>



					<?php //оболочка картинки ?>
				    <div class="col-lg-4 col-xs-12 img_razvorot_block">

				        	<?php //картинка ?>
				        	<# if(settings.image.id){ #>
                            <img src="{{ settings.image.url }}" alt="{{ settings.image.alt }}" title="{{ settings.image.title }}">
                            <# } else { #> 
                            <img src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_2.png" >
                            <# } #>
				            <?php //картинка ?>

				    </div>
				    <?php //оболочка картинки ?>

				    <?php //оболочка текста ?>
				    <div class="col-lg-8 col-xs-12 wrap_razvorot_text">
				    	<?php //видимый текст ?>
				        <div class="viseble_text">{{{settings.text}}}</div>
				        <?php //видимый текст ?>

				        	<?php //скрытый текст ?>
				        	<# if( settings.dobavlyt_skritiy_text == 'yes' && settings.skritiy_text.length > 0 ){ #>
				        	<div class="skritiy_text">
								{{{settings.skritiy_text}}}
							</div>
							<div class="open_close">
								<span class="open in_line">{{{settings.text_open}}}</span>
								<span class="close none_display">{{{settings.text_close}}}</span>
							</div>
							<# } #>
							<?php //скрытый текст ?>

				    </div>
				    <?php //оболочка текста ?>

	<?php //оболочка блока block_type_mutation ?>
		</div>
	</div>
	<?php //оболочка блока block_type_mutation ?>

		<?php
	}//_content_template

	
}	