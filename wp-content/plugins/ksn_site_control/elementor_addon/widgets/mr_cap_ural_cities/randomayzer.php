<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Media_Podborka;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

class randomayzer extends Widget_Base {
	public function get_name() {
		return 'randomayzer';
	}
	public function get_title() {
		return 'Рандомайзер картинок';
	}
	public function get_icon() {
		return 'eicon-image-bold';
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
		$this->end_controls_section();

		$this->start_controls_section(
			'content_section',
			[
				'label' => 'Картинки',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'random_images',
			[
				'label' => 'Выберете изображения',
				'type' => Media_Podborka::media_podborka,
				'default' => [],
				'description' => 'Рекомендуемое соотношение сторон 2:1, ширина к высоте. <br><span class="vazho_red">ВАЖНО:</span> пропорции всех картинок должны быть одинаковыми, иначе при обновлении страницы будут скачки, т.к. новая картинка может быть ниже или выше предыдущей.<br><span class="vazho_red">Примечание:</span> картинки из этой сборки будут показываться, по 1 штуке, случайным образом при кажой загрузке страницы, т.е. за 1 раз может показаться только 1 картинка, а все остальные даже не загружаются браузером до следующей перезагрузки страницы.',
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
		if( $settings['random_images'] ){//картинки рандомайзера
			foreach ($settings['random_images'] as $item) {
				if ( $item['id'] ) {
					$alt = get_post_meta($item['id'], '_wp_attachment_image_alt', true);
					$title = get_the_title($item['id']);
					$data_original_w = $item['original_width'];
					$data_original_h = $item['original_height'];
					$data_src_max = wp_get_original_image_url( $item['id'] );
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
			}
		}//картинки рандомайзера
	?>
<script>
/*для рандомайзера выбераем случайную картинку*/
if (!data_site.random_img) {
    data_site.random_img = function() {
        let randomayzer = document.querySelectorAll(".randomayzer:not(.randomed_complit)")[0],
            random_number = function(min, max) {
                return Math.floor(Math.random() * (max - min + 1) + min);
            };
        let images = randomayzer.querySelectorAll("img.random_img_item"),
            images_kol = images.length,
            random = random_number(0, images_kol - 1),
            img_random = images[random];
        img_random.classList.add("vidna");
        img_random.setAttribute("data-type", "img_content");
        randomayzer.classList.add("randomed_complit");
    };
}
/*для рандомайзера выбераем случайную картинку*/

/*скрпит управляет размером лоадера слайдера*/
if (!data_site.randomayzer_size) {
    data_site.randomayzer_size = function() {
        let win_width = document.body.clientWidth,
            win_height = window.innerHeight,
            mas = document.querySelectorAll(".randomayzer");
        for (let i = 0; i < mas.length; i++) {
            let randomayzer = mas[i],
                img_wrap = randomayzer.querySelectorAll(".img_wrapper")[0],
                img = img_wrap.querySelectorAll("img.random_img_item.vidna")[0],
                img_o_w = Number(img.getAttribute("data-original-w")),
                img_o_h = Number(img.getAttribute("data-original-h"));
            if (win_width > 900) {
                let p_top = (img_o_h / img_o_w) * 100;
                img_wrap.style.cssText += "padding-top:" + p_top + "%;";
                img.removeAttribute("width");
            } else if (win_width <= 900) {
                let img_width = Math.ceil(win_width + img.offsetLeft * 2),
                    /*реальная требуемая ширина картинки с учётом частей спрятаных за пределами экрна*/
                    h = (img_width * img_o_h) / img_o_w,
                    p_top = (h / win_width) * 100 + 35;/*35 - это поправка для того чтоб картинка становилась как надо*/
                img_wrap.style.cssText += "padding-top:" + p_top + "%;";
                img.width = img_width; /*создаём атрибут width с требуемой шириной картинки*/
            }
        }
    };
    window.addEventListener("resize", data_site.randomayzer_size, { passive: true });
}
/*скрпит управляет размером лоадера слайдера*/
</script>
	<div class="col-12 block_type_mutation 
	<?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
	 <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
		<div class="randomayzer <?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">
			<div class="img_wrapper">
				<?php foreach ( $settings['random_images'] as $key => $item ) {
					if($item['id']){
						echo '<img class="random_img_item" '.$img_mas[$key].'>';
					} else {
						echo '<img class="random_img_item" data-original-w="2" data-original-h="1" data-type="img_maket" data-src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_2.png">';
					}
				}
				?>
				<script>data_site.random_img();data_site.randomayzer_size();</script>
				<div class="media_loader">
		            <div class="loader"></div>
		        </div>
		        <script>data_site.l();</script> 
			</div>
		</div>
	</div>
<?php }//render

protected function content_template() { ?>
	<style>
		img.random_img_item.vidna{
			opacity: 1;
		}
	</style>
	<div class="col-12 block_type_mutation 
	<# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#>
	 <# if(settings.padding_left=='yes'){#> pl-0 <#} if(settings.padding_top=='yes'){#> pt-0 <#} if(settings.padding_right=='yes'){#> pr-0 <#} if(settings.padding_bottom=='yes'){#> pb-0 <#}#>">
	    <div class="randomayzer {{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
	    	<div class="img_wrapper">
	    		<div class="media_loader">
		            <div class="loader"></div>
		        </div>
		        <# if ( settings.random_images.length ) { #>
                    <# _.each( settings.random_images, function( item ) { #>
                        <img class="random_img_item" data-original-w="{{ item.original_width }}" data-original-h="{{ item.original_height }}" src="{{ item.url }}" alt="{{ item.alt }}" title="{{ item.title }}">
                    <# }); #>
            	<# } else { #>
                    <img class="random_img_item" data-original-w="2" data-original-h="1" src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_2.png">
                <# } #>
            </div>
		</div>
	</div>
<script>
/*для рандомайзера выбераем случайную картинку*/
if (!data_site.randomayzer_size) {
    data_site.randomayzer_size = function() {
        let win_width = document.body.clientWidth,
            win_height = window.innerHeight,
            mas = document.querySelectorAll(".randomayzer");
        for (let i = 0; i < mas.length; i++) {
            let randomayzer = mas[i],
                img_wrap = randomayzer.querySelectorAll(".img_wrapper")[0],
                img = img_wrap.querySelectorAll("img.random_img_item.vidna")[0],
                img_o_w = Number(img.getAttribute("data-original-w")),
                img_o_h = Number(img.getAttribute("data-original-h"));
            if (win_width > 900) {
                let p_top = (img_o_h / img_o_w) * 100;
                img_wrap.style.cssText += "padding-top:" + p_top + "%;";
                img.removeAttribute("width");
            } else if (win_width <= 900) {
                let img_width = Math.ceil(win_width + img.offsetLeft * 2),
                    /*реальная требуемая ширина картинки с учётом частей спрятаных за пределами экрна*/
                    h = (img_width * img_o_h) / img_o_w,
                    p_top = (h / win_width) * 100 + 35;/*35 - это поправка для того чтоб картинка становилась как надо*/
                img_wrap.style.cssText += "padding-top:" + p_top + "%;";
                img.width = img_width; /*создаём атрибут width с требуемой шириной картинки*/
            }
        }
    };
    window.addEventListener("resize", data_site.randomayzer_size, { passive: true });
}
/*скрпит управляет размером лоадера слайдера*/
data_site.random_img();
data_site.randomayzer_size();
data_site.l();
</script>

		<?php
	}//_content_template

	
}	