<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

class Glavnaya_gorod_text extends Widget_Base {
	public function get_name() {
		return 'glavnaya_gorod_text';
	}
	public function get_title() {
		return 'Текст лозунг-город';
	}
	public function get_icon() {
		return 'eicon-animation-text';
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
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => 'Тексты',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_responsive_control(
			'align',
			[
				'label' => 'Выравнивание заголовока H',
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
				'tablet_default' => '',
				'mobile_default' => '',
				'description' => 'Выберете как выравнивать заголовок H, доступны 3 типа устройств для настройки.',
			]
		);
		$this->add_control(
			'text',
			[
				'label' => 'Текст лозунга',
				'dynamic' => [],
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<p>ВАШ АВТОМОБИЛЬ</p><p>ВСЕГДА КАК НОВЫЙ</p>',
				'placeholder' => 'Заполните текст',
				'description' => 'Заполните текст лозунга',
			]
		);
		$this->add_control(
			'text_gorod',
			[
				'label' => 'Текст города',
				'type' => Controls_Manager::TEXT,
				'default' => 'Город',
				'placeholder' => 'Текст города',
				'description' => 'Текст название города',
			]
		);
		$this->add_control(
			'swap_text',
			[
				'label' => 'Поменять местами ?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => '',
				'description' => 'Если выбрано "Да" то текст лозунга поменяется местами с текстом города.',
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
	?>
	<div class="blok_gorod col-12 block_type_mutation 
	<?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
	 <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
		<div class="<?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
			<div class="col-12 wraper_glavnaya_gorod flex_display <?php if($settings['swap_text']==='yes'){echo "swap_text";}?>">
			    <div class="col-lg-6 col-xs-12 text_top_glavnaya">
			        <?php echo $settings['text']; ?>
			    </div>
			    <div class="col-lg-6 col-xs-12">
			        <div class="gradient_text_gorod"><?php echo $settings['text_gorod']; ?></div>
			    </div>
			</div>
		</div>
	</div>
	




<?php }//render

protected function content_template() { ?>
	<div class="blok_gorod col-12 block_type_mutation 
	<# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#>
	 <# if(settings.padding_left=='yes'){#> pl-0 <#} if(settings.padding_top=='yes'){#> pt-0 <#} if(settings.padding_right=='yes'){#> pr-0 <#} if(settings.padding_bottom=='yes'){#> pb-0 <#}#>">
	    <div class="{{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
	    	<div class="col-12 wraper_glavnaya_gorod flex_display <# if(settings.swap_text==='yes'){#>swap_text<#}#>">
			    <div class="col-lg-6 col-xs-12 text_top_glavnaya">
			        {{{settings.text}}}
			    </div>
			    <div class="col-lg-6 col-xs-12">
			        <div class="gradient_text_gorod">{{{settings.text_gorod}}}</div>
			    </div>
			</div>
		</div>
	</div>
		<?php
	}//_content_template

	
}	