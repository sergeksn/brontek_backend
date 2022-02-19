<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Control_blok_typs;
use KSN_Site_Konstruktor\Control\Custom_Media_Uploader;
use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Custom_URL;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

class animate_img_text extends Widget_Base {
	public function get_name() {
		return 'animate_img_text';
	}
	public function get_title() {
		return 'Анимированные картинка - текст';
	}
	public function get_icon() {
		return 'eicon-image-before-after';
	}
	public function get_categories() {
		return [ 'glavnaya_stranica' ];
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
			'ssilka',
			[
				'label' => 'Ссылка',
				'type' => Custom_URL::URL,
				'placeholder' => 'https://your-link.com',
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'description' => 'Вставьте ссылку для этого блока. Чтобы вставить адрес существующей страницы с этого сайта начните вводить её название',
			]
		);
		$this->add_control(
			'block_tip',
			[
				'label' => 'Тип блока',
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => 'Весь блок ссылка',
					'2' => 'Текст "подробнее" ссылка',
				],
				'default' => '1',
				'description' => 'Выберите тип блока. Как Вы хотите сформировать блок, чтоб ссылкой был весь блок включая картинку и блок с текстом, или же Вы хотите чтоб ссылкой был только текст "подробнее" в блоке с текстом.',
			]
		);
		$this->add_control(
			'podrobnee_text',
			[
				'label' => 'Текст "подробнее"',
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 2,
				'default' => 'подробнее',
				'placeholder' => 'Текст "подробнее"',
				'description' => 'Здесь Вы указываете какой должен быть текст ссылки "подробнее", или как-то по другомы к примеру "далее...".',
				'condition' => [
				    'block_tip' => '2',
				],
			]
		);
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
				'label' => 'Текст в блоке',
				'dynamic' => [],
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<p style="text-align: center;">Антигравийная <br />плёнка</p><p> Данный текст рекомендуется заполнять. Для каждого блока данного типа добавьте небольшой текст который вкратце будет описывать страницу на которую ведёт ссылка этого блока. Так же <span style="font-family: Bold; color: #ff0000;">ВАЖНО</span> не нужно писать тут слишком много текста, так как это вызовет нежелательное расширение блока на экранах в ройное 992 px. <span style="font-family: Bold; color: #ff9900;">Максимум 350 символов, включая пробелы!</span></p>',
				'placeholder' => 'Заполните текст',
				'description' => 'Заполните текст в блоке рядом с картинкой. <br><span class="vazho_red">ПРИМЕЧАНИЕ:</span> первый абзац в этом блоке автоматически станет большим текстом, чем-то вроде заголовка. Остальной текст будет располагаться под этим "заголовком". <br><span class="vazho_red">ВАЖНО:</span> после заполнения текста обязательно проверьте чтоб он не выходил за пределы блока на планшетных устройствах, это можно сделать с помощью предпросмотра на нужных размерах экранов снизу панели.',
			]
		);
		$this->add_control(
			'dobavlyt_text_vsplivaushiy',
			[
				'label' => 'Нужен ли высплывающий текст на картинке?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'text_vsplivaushiy',
			[
				'label' => 'Текст на картинке',
				'dynamic' => [],
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<p>Как защитить ваш автомобиль от сколов и царапин?</p><p>Llumar, SunTec, 3M - какую пленку выбрать?</p><p>Из скольки слоев состоит антигравийная пленка?</p>',
				'placeholder' => 'Заполните текст',
				'description' => 'Это текст появляется на картинке, при наведении на весь блок.',
				'condition' => [
				    'dobavlyt_text_vsplivaushiy' => 'yes',
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
					'url' => KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_3.png',
				],
				'description' => 'Выберете картинку, соотношение сторон 3:2 , ширина к высоте. <br><span class="vazho_red">ВАЖНО:</span> для нормального отображения блоков, все картинки в блоках типа "Анимированные картинка - текст", на одной странице, должны быть одинаковых пропорций вплоть до 1 пикселя, чтоб блоки не прыгали по высоте.',
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
		$target = $settings['ssilka']['is_external'] ? ' target="_blank" ' : '';
		$nofollow = $settings['ssilka']['nofollow'] ? ' rel="nofollow" ' : '';
	?>
	<?php //оболочка блока block_type_mutation ?>
	<div class="col-12 block_type_mutation 
	<?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
	 <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
		<div class="<?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
			<?php //оболочка блока block_type_mutation ?>

			<?php //ссылка на весь блок если задана ?>
			<?php if( $settings['block_tip'] == "1" && $settings['ssilka']['url'] ){ ?>
			<a href="<?php echo $settings['ssilka']['url'];?>" <?php echo '' . $target . $nofollow . '';?>>
			<?php } ?>
			<?php //ссылка на весь блок если задана ?>

				<?php //оболочка анимированного блока ?>
				<div class="col-12 mayn_hover_efekt_block flex_display">
				<?php //оболочка анимированного блока ?>

					<?php //оболочка картинки ?>
				    <div class="col_2iz3 <?php if($settings['blok_type'] == '2' ){ echo "order_1"; } ?>">
				        <div class="effect_milo">

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

				            <?php //всплывающий текст ?>
				            <?php if ( $settings['dobavlyt_text_vsplivaushiy'] === 'yes') { ?>
				            <div class="vsplivaushiy_block">
				                <div class="vsplivaushiy_text ml-auto mr-0">
				                	<?php echo $settings['text_vsplivaushiy']; ?>
				                </div>
				            </div>
				            <?php } ?>
				            <?php //всплывающий текст ?>

				        </div>
				    </div>
				    <?php //оболочка картинки ?>

				    <?php //оболочка текста ?>
				    <div class="col_1iz3">
				        <div class="col-12 text_block">

				            <?php //текст ?>
				        	<?php echo $settings['text']; ?>
				        	<?php //текст ?>

				        	<?php //блок текста с сылкой подробнее если заданы?>
							<?php if( $settings['block_tip'] == "2" && !empty($settings['podrobnee_text']) && $settings['ssilka']['url'] ){ ?>

							<a href="<?php echo $settings['ssilka']['url'];?>" <?php echo '' . $target . $nofollow . '';?>>	
		                        <div class="siilka_anim_blok"><?php echo $settings['podrobnee_text']; ?></div>
	                        </a>

	                        <?php } ?>
	                        <?php //блок текста с сылкой подробнее если заданы?>

				        </div>
				    </div>
				    <?php //оболочка текста ?>

				<?php //оболочка анимированного блока ?>
				</div>
				<?php //оболочка анимированного блока ?>

			<?php //ссылка на весь блок если задана ?>
			<?php if( $settings['block_tip'] == "1" && $settings['ssilka']['url'] ){ ?>
	        </a>
			<?php } ?>
			<?php //ссылка на весь блок если задана ?>

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
	    <div class="{{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
	<?php //оболочка блока block_type_mutation ?>

			<?php //ссылка на весь блок если задана ?>
			<# if( settings.block_tip == '1' && settings.ssilka.url ){ 
				var target = settings.ssilka.is_external ? ' target="_blank"' : '';
				var nofollow = settings.ssilka.nofollow ? ' rel="nofollow"' : '';
			#>
			<a href="{{settings.ssilka.url}}"{{ target }}{{ nofollow }}>
			<# } #>
			<?php //ссылка на весь блок если задана ?>

				<?php //оболочка анимированного блока ?>
				<div class="col-12 mayn_hover_efekt_block flex_display">
				<?php //оболочка анимированного блока ?>

					<?php //оболочка картинки ?>
				    <div class="col_2iz3 <# if( settings.blok_type == '2'){ #>order_1<# } #>">
				        <div class="effect_milo">

				        	<?php //картинка с лоадером ?>
				        	<# if(settings.image.id){ #>
                            <img src="{{ settings.image.url }}" alt="{{ settings.image.alt }}" title="{{ settings.image.title }}">
                            <# } else { #> 
                            <img src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_3.png" >
                            <# } #>
				            <?php //картинка с лоадером ?>

				            <?php //всплывающий текст ?>
				            <# if( settings.dobavlyt_text_vsplivaushiy == 'yes' ){ #>
				            <div class="vsplivaushiy_block">
				                <div class="vsplivaushiy_text ml-auto mr-0">
				                	{{{settings.text_vsplivaushiy}}}
				                </div>
				            </div>
				            <# } #>
				            <?php //всплывающий текст ?>

				        </div>
				    </div>
				    <?php //оболочка картинки ?>

				    <?php //оболочка текста ?>
				    <div class="col_1iz3">
				        <div class="col-12 text_block">

				            <?php //текст ?>
				        	{{{settings.text}}}
				        	<?php //текст ?>

				        	<?php //блок текста с сылкой подробнее если заданы?>
							<# if( settings.block_tip == '2' && settings.podrobnee_text.length > 0 && settings.ssilka.url ){ 
								var target = settings.ssilka.is_external ? ' target="_blank"' : '';
								var nofollow = settings.ssilka.nofollow ? ' rel="nofollow"' : '';
							#>

							<a href="{{settings.ssilka.url}}"{{ target }}{{ nofollow }}>	
		                        <div class="siilka_anim_blok">{{settings.podrobnee_text}}</div>
	                        </a>

	                        <# } #>
	                        <?php //блок текста с сылкой подробнее если заданы?>

				        </div>
				    </div>
				    <?php //оболочка текста ?>

				<?php //оболочка анимированного блока ?>
				</div>
				<?php //оболочка анимированного блока ?>

			<?php //ссылка на весь блок если задана ?>
			<# if( settings.block_tip == '1' && settings.ssilka.url ){ #>
			</a>
			<# } #>
			<?php //ссылка на весь блок если задана ?>

	<?php //оболочка блока block_type_mutation ?>
		</div>
	</div>
	<?php //оболочка блока block_type_mutation ?>

		<?php
	}//_content_template

	
}	