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

class contact_map_img extends Widget_Base {
	public function get_name() {
		return 'contact_map_img';
	}
	public function get_title() {
		return 'Контакты карта-картинка';
	}
	public function get_icon() {
		return 'eicon-google-maps';
	}
	public function get_categories() {
		return [ 'contacti' ];
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

    	$this->add_control(
			'dobavlyt_yellow_line',
			[
				'label' => 'Нужна ли жёлтая линия ?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'line_type',
			[
				'label' => 'Расположение жёлтой линии',
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'default' => 'col-lg-7 mr-auto',
				'options' => [
					'col-lg-7 mr-auto' => 'Слева',
					'col-lg-7 m-auto' => 'По центру',
					'col-lg-7 ml-auto' => 'Справа',
					'col-lg-12' => 'На всю ширину'
				],
				'description' => '<br><span class="vazho_red">ПРИМЕЧАНИЕ:</span> данная настройка актуальная для экранов свыше 992px.',
				'condition' => [
				    'dobavlyt_yellow_line' => 'yes',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_section_1',
			[
				'label' => 'Карта с контактами',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'text_contact',
			[
				'label' => 'Текст контактов',
				'dynamic' => [],
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<p>Восточная, 51<br />+7 (343) 247-83-11<br />Ежедневно<br />с 09:00 до 21:00</p>',
				'placeholder' => 'Заполните текст',
				'description' => 'Заполните текст в блоке рядом с картинкой. <br><span class="vazho_red">ПРИМЕЧАНИЕ:</span> первый абзац в этом блоке автоматически станет большим текстом, чем-то вроде заголовка. Остальной текст будет располагаться под этим "заголовком". <br><span class="vazho_red">ВАЖНО:</span> после заполнения текста обязательно проверьте чтоб он не выходил за пределы блока на планшетных устройствах, это можно сделать с помощью предпросмотра на нужных размерах экранов снизу панели.',
			]
		);
		$this->add_responsive_control(
			'align_contact',
			[
				'label' => 'Выравнивание текста контактов',
				'type' => Controls_Manager::CHOOSE,
				'show_label' => true,
				'label_block' => true,
				'options' => [
					'left'    => [
						'title' => 'Слева',
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => 'По центру',
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => 'Справа',
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => 'По всей ширине',
						'icon' => 'eicon-text-align-justify',
					],
				],
				'desktop_default' => 'left',
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'description' => 'Выберете как выравнивать текст контактов, доступны 3 типа устройств для настройки.',
			]
		);
		$this->add_control(
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
                'default' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2183.5975659670407!2d60.639411715748295!3d56.81853661675982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x43c16ebb3594b1d9%3A0xc16d445fd6b609a1!2z0JLQvtGB0YLQvtGH0L3QsNGPINGD0LsuLCA1MSwg0JXQutCw0YLQtdGA0LjQvdCx0YPRgNCzLCDQodCy0LXRgNC00LvQvtCy0YHQutCw0Y8g0L7QsdC7LiwgNjIwMTAw!5e0!3m2!1sru!2sru!4v1562075950082!5m2!1sru!2sru" " frameborder="0" style="border:0" allowfullscreen></iframe>',
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
					'url' => KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_3.png',
				],
				'description' => 'Выберете картинку, соотношение сторон 3:2 , ширина к высоте.',
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
	<?php //жёлтая линия ?>
	<?php if ( $settings['dobavlyt_yellow_line'] == "yes" ) { ?>
	<div class="col-12 contakt_line_wrapper flex_display <?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>">
		<div class="<?php echo $settings['line_type']; ?> col-xs-12">
			<div class="contakt_line"></div>
		</div>
	</div>
	<?php } ?>
	<?php //жёлтая линия ?>

	<?php //оболочка блока block_type_mutation ?>
	<div class="col-12 block_type_mutation 
	<?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
	 <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
		<div class="flex_display <?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
			<?php //оболочка блока block_type_mutation ?>

					<?php //оболочка картинки ?>
				    <div class="col-lg-7 col-xs-12 contakt_img_wrap <?php if($settings['blok_type'] == '2' ){ echo "order_1"; } ?>">

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
				            <div class="col-12 img_wrapper" style="padding-top: 66.67%;">
				                <?php echo '<img data-type="img_maket" data-src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_3.png" >';?>
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

				    <?php //оболочка текста с картой ?>
				   	<div class="map_adres_block col-lg-5 col-xs-12">
						<div class="adres_block col-12 <?php if($settings['align_contact']){echo "text_".$settings['align_contact']." ";}if($settings['align_contact_tablet']){echo "text_planshet_".$settings['align_contact_tablet']."";}if($settings['align_contact_mobile']&&$settings['align_contact_tablet']){echo " text_mobile_".$settings['align_contact_mobile']."";}elseif($settings['align_contact_mobile']&&!$settings['align_contact_tablet']){echo "text_mobile_".$settings['align_contact_mobile']."";}?>">
							<?php echo $settings['text_contact']; ?>
						</div>
						<div class="col-12 block_map">
							<div class="map_wrapper col-12">
								<div class="media_loader">
					            	<div class="loader"></div>
					            </div>
					            <script>data_site.l();</script>
					            <div class="map_fpame">
									<!--<?php echo $settings['map']; ?>-->
								</div>
							</div>
						</div>
					</div>
				    <?php //оболочка текста с картой ?>

			<?php //оболочка блока block_type_mutation ?>
		</div>
	</div>
	<?php //оболочка блока block_type_mutation ?>
	




<?php }//render

protected function content_template() { ?>

	<?php //жёлтая линия ?>
	<# if( settings.dobavlyt_yellow_line == 'yes' ){ #>
	<div class="col-12 contakt_line_wrapper flex_display 
	<# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#> ">
		<div class="{{settings.line_type}} col-xs-12">
			<div class="contakt_line"></div>
		</div>
	</div>
	<# } #>
	<?php //жёлтая линия ?>

	<?php //оболочка блока block_type_mutation ?>
	<div class="col-12 block_type_mutation 
	<# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#> 
	 <# if(settings.padding_left=='yes'){#> pl-0 <#} if(settings.padding_top=='yes'){#> pt-0 <#} if(settings.padding_right=='yes'){#> pr-0 <#} if(settings.padding_bottom=='yes'){#> pb-0 <#}#>">
	    <div class="flex_display {{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
	<?php //оболочка блока block_type_mutation ?>

					<?php //оболочка картинки ?>
				    <div class="col-lg-7 col-xs-12 contakt_img_wrap <# if( settings.blok_type == '2'){ #>order_1<# } #>">

				        	<?php //картинка с лоадером ?>
				        	<# if(settings.image.id){ #>
                            <img src="{{ settings.image.url }}" alt="{{ settings.image.alt }}" title="{{ settings.image.title }}">
                            <# } else { #> 
                            <img src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_3.png" >
                            <# } #>
				            <?php //картинка с лоадером ?>

				    </div>
				    <?php //оболочка картинки ?>

				    <?php //оболочка текста с картой ?>
				    <div class="map_adres_block col-lg-5 col-xs-12">

				    	<?php //текст ?>
				    	<div class="adres_block col-12 <# if(settings.align_contact){#> text_{{settings.align_contact}} <#} if(settings.align_contact_tablet){ #> text_planshet_{{settings.align_contact_tablet}} <# } if(settings.align_contact_mobile){#> text_mobile_{{settings.align_contact_mobile}} <# } #>">
				        	{{{settings.text_contact}}}
				        </div>
				        <?php //текст ?>

				        <?php //карта ?>
				        <div class="col-12 block_map">
							<div class="map_wrapper col-12">
								<div class="media_loader">
					            	<div class="loader"></div>
					            </div>
					            <div class="map_fpame">
					            	{{{settings.map}}}
								</div>
							</div>
						</div>
						<?php //карта ?>

				    </div>
				    <?php //оболочка текста с картой ?>

	<?php //оболочка блока block_type_mutation ?>
		</div>
	</div>
	<?php //оболочка блока block_type_mutation ?>
	<script>data_site.l();</script>

		<?php
	}//_content_template

	
}	