<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

class Instagram_Galery extends Widget_Base {
	public function get_name() {
		return 'instagram_galery';
	}
	public function get_title() {
		return 'Инстаграм галерея';
	}
	public function get_icon() {
		return 'eicon-instagram-gallery';
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
			'content_section',
			[
				'label' => 'Вставить инстаграм',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'shortcode',
			[
				'label' => 'Шорткод инстаграмм галереии',
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 4,
				'placeholder' => '[elfsight_instagram_feed id="1"]',
				'description' => 'Сюда нужно вставить шорткод инстаграм галереи. Его можно найти на странице плагина инстаграм галереи, в разделе виджеты, он будет выглядет примерног так: [elfsight_instagram_feed id="1"] ',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$shortcode = $this->get_settings_for_display( 'shortcode' );

		$shortcode = do_shortcode( shortcode_unautop( $shortcode ) );//выводит шорткод, и удаляет оборачивающий его по умолчанию тег p
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
		<script>
		if (!data_site.insta_prop_size) {
		    data_site.insta_prop_size = function() {
		        var win_width = document.body.clientWidth,
		            win_height = window.innerHeight,
		            target_container = document.querySelectorAll(".instagram_img_sektion:not(.insta_prop_size_complit)")[0],
		            /*выполняем код ниже для каждой новой найденой галереи в DOM без класса insta_prop_size_complit*/
		            button_heigth = 80,
		            /*24+24+32*/
		            wrap_pagging = 30,
		            wrap_pagging_do_992 = 25;
		            if(win_width >= 1800){
		            	var button_heigth = Math.floor(win_width/100*1.6)+48+10+4;
		            }	
		            if(win_width >= 2500){
		            	var wrap_pagging = Math.floor(win_width/100*1.4);
		            }
		        if (!data_site.IE_check()) {
		            if (win_width >= 992) {
		                let insta_container_width = win_width - wrap_pagging * 2,
		                    img_heigth = insta_container_width / 4 - 2,
		                    /*делим на количество картинок в ряду*/
		                    insta_container_heigth = img_heigth * 2 + button_heigth,
		                    /*-4 так чтоб убрать погрешность т.к. высота картинки больше на 2 чем ширина*/
		                    container_p_t = (100 * insta_container_heigth) / insta_container_width;
		                target_container.style.paddingTop = container_p_t + "%";
		            } else if (win_width >= 768 && win_width < 992) {
		                let insta_container_width = win_width - wrap_pagging_do_992 * 2,
		                    img_heigth = insta_container_width / 3,
		                    /*делим на количество картинок в ряду*/
		                    insta_container_heigth = img_heigth * 2 - 4 + button_heigth,
		                    /*-4 так чтоб убрать погрешность т.к. высота картинки больше на 2 чем ширина*/
		                    container_p_t = (100 * insta_container_heigth) / insta_container_width;
		                target_container.style.paddingTop = container_p_t + "%";
		            } else if (win_width > 375 && win_width < 768) {
		                let insta_container_width = win_width - wrap_pagging_do_992 * 2,
		                    img_heigth = insta_container_width / 2,
		                    /*делим на количество картинок в ряду*/
		                    insta_container_heigth = img_heigth * 2 - 4 + button_heigth,
		                    /*-4 так чтоб убрать погрешность т.к. высота картинки больше на 2 чем ширина*/
		                    container_p_t = (100 * insta_container_heigth) / insta_container_width;
		                target_container.style.paddingTop = container_p_t + "%";
		            } else if (win_width <= 375) {
		                let insta_container_width = win_width - wrap_pagging_do_992 * 2,
		                    img_heigth = insta_container_width / 1,
		                    /*делим на количество картинок в ряду*/
		                    insta_container_heigth = img_heigth - 4 + button_heigth,
		                    /*-4 так чтоб убрать погрешность т.к. высота картинки больше на 2 чем ширина*/
		                    container_p_t = (100 * insta_container_heigth) / insta_container_width;
		                target_container.style.paddingTop = container_p_t + "%";
		            }
		        } else {
		            target_container.innerHTML = "<div class='warning'>ПРЕДУПРЕЖДЕНИЕ!!!</div><div class='warning_messege'>Сожалеем, но увы Ваш браузер не поддерживает современную Instagram галерею. Пожалуйста установить один из современных бесплатных браузеров:</br><div class='ie_browser_new_load'><a href='https://www.google.com/intl/ru/chrome/' target='_blank' rel='nofollow'>Google Chrome</a></div><div class='ie_browser_new_load'><a href='https://www.microsoft.com/ru-ru/edge' target='_blank' rel='nofollow'>Edge</a></div><div class='ie_browser_new_load'><a href='https://www.mozilla.org/ru/firefox/new/' target='_blank' rel='nofollow'>FireFox</a></div></div><div class='warning'>ПРЕДУПРЕЖДЕНИЕ!!!</div>";
		        }
		        target_container.className += " insta_prop_size_complit"; /*помечаем что под данную галерею зарезервированно пространство в документе*/
		    };
		}
		</script>
		<div class="col-12 block_type_mutation 
		<?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
		 <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
		<div class="<?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
		    	<div class="instagram_img_sektion">
		    		<div class="media_loader">
			            <div class="loader"></div>
			        </div>
			        <script>data_site.l();</script> 
		        	<div class="instagram_img"><?php echo $shortcode; ?></div>
		       </div>
		       <script>data_site.insta_prop_size();</script>
		    </div>
		</div>
		<?php
	}

	protected function content_template() {}

	
}	