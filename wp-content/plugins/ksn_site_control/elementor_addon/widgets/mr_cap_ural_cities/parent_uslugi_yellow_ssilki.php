<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Custom_Repeater;
use KSN_Site_Konstruktor\Control\Custom_URL;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Plugin;

class parent_uslugi_yellow_ssilki extends Widget_Base {
	public function get_name() {
		return 'parent_uslugi_yellow_ssilki';
	}
	public function get_title() {
		return 'Жёлтые ссылки';
	}
	public function get_icon() {
		return 'eicon-link';
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
			'ssilki_section',
			[
				'label' => 'Ссылки',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
            'text_ssilki',
            [
                'label' => 'Текст блока ссылки',
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => 'Пример текста для ссылки',
                'placeholder' => 'текст на жёлтом блоке ссылки',
                'description' => 'Текст в жёлтом блоке который будет ссылкой',
            ]
        );
        $repeater->add_control(
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
		$repeater->add_control(
			'tip_bloka_ssilki',
			[
				'label' => 'Тип блока ссылки',
				'type' => Controls_Manager::SELECT,
				'default' => 'col-na-5 col-xs-12',
				'options' => [
					'col-na-5 col-xs-12'  => '5 в ряд',
					'col-lg-3 col-md-12' => '3 в ряд',
				],
				'description' => 'Опеределяет для каждого блока ссылки его индивидуальный размер, 5 в ряд или 3 в ряд, это 25% и 20% ширины родительского блока соответственно.',
			]
		);
		$this->add_control(
            'yelloe_ssilki_list',
            [
                'label' => 'Создайте блоки жёлтых ссылок',
                'type' => Custom_Repeater::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [],
                    [],
                    [],
                    [],
                    [],
                ],
                'description' => '<span class="vazho_red">Примечание:</span> все жёлтые блоки ссылок выравниваются по высоте самого высокого из них. Макет предусматриват максимум 1 строку этих блоков, в протимном случае могут проявиться визуальные деффекты блоков расположенных в 2+ рядах включительно.',
                'title_field' => '{{text_ssilki}}',
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
		<div class="yellow_ssilki_block <?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
			<?php if ( $settings['yelloe_ssilki_list'] ) {
                    foreach (  $settings['yelloe_ssilki_list'] as $item ) { 
                    	$target = $item['ssilka']['is_external'] ? ' target="_blank" ' : '';
						$nofollow = $item['ssilka']['nofollow'] ? ' rel="nofollow" ' : '';
                    ?>
                    <div class="<?php echo $item['tip_bloka_ssilki'];?> yellow_obolochka">
						<a href="<?php echo $item['ssilka']['url'];?>" <?php echo '' . $target . $nofollow . '';?>>
						    <div class="wrap_ssilka_block_yellow">
						        <div class="ssilka_yellow"><?php echo $item['text_ssilki']; ?></div>
						    </div>
						</a>
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
	    <div class="yellow_ssilki_block {{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
			<# if ( settings.yelloe_ssilki_list.length ) { #>
            	<# _.each( settings.yelloe_ssilki_list, function( item ) { 
            		var target = item.ssilka.is_external ? ' target="_blank"' : '';
					var nofollow = item.ssilka.nofollow ? ' rel="nofollow"' : '';
            		#>
            		<div class="{{ item.tip_bloka_ssilki }} yellow_obolochka">
						<a href="{{ item.ssilka.url }}"{{ target }}{{ nofollow }}>
						    <div class="wrap_ssilka_block_yellow">
						        <div class="ssilka_yellow">{{{ item.text_ssilki }}}</div>
						    </div>
						</a>
					</div>
            	<#});#>
            <# } #>
        </div>
	</div>
		<?php
	}

	
}	