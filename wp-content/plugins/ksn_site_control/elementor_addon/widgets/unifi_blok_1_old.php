<?php
namespace KSN_Site_Konstruktor\Widget;

use KSN_Site_Konstruktor\Control\Control_blok_typs;
use KSN_Site_Konstruktor\Control\Control_vibor_shablona_bloka;
use KSN_Site_Konstruktor\Control\Custom_Media_Uploader;
use KSN_Site_Konstruktor\Control\Custom_Popover_Toggle;
use KSN_Site_Konstruktor\Control\Custom_Repeater;
use KSN_Site_Konstruktor\Control\Custom_switcher;
use KSN_Site_Konstruktor\Control\Control_show_block_on_device;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Plugin;



class unifi_blok_1 extends Widget_Base {
	public function get_name() {
		return 'unifi_blok_1';
	}
	public function get_title() {
		return 'Унифицированный блок';
	}
	public function get_icon() {
		return 'eicon-image-before-after';
	}
	public function get_categories() {
		return [ 'glavnaya_stranica', 'bloki_dla_stranic_saita', 'contacti' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
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
				'default' => '',
				'description' => 'Если выбрано "Да" то внутренний отступ от края блока в выбранном направлении (лево-права-верх-низ) будет убран до нуля. <br><span class="vazho_red">ВАЖНО:</span> эта функция предназначена для создания эффекта картинки расположенной на всю ширину экрана. Попыти убрать отсупы лево-право для других шаблонов блоков (опция "Выберете шаблон блока"), кроме 16 шаблона (одна картинка), вызовет сбои в корректном отображении блоков на всех типах устройств! <br><span class="vazho_red">Примечание:</span> отключение отступов сверху или снизу вполне приемлемо для всех блоков и используется для регулирования отсупов между блоками.',
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
				'description' => 'Выберете ширину всего блока, занчение 75% в макете используется для блоков картинки над жёлтыми ссылками и для больших блоков видео. <br><span class="vazho_red">ВАЖНО:</span> данная функция применяется только к экранам свыше 1200px в ширину!',
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
				'default' => 'ml-auto mr-0',
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
                'value' => ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16'],
                'papka_s_img' => 'blok_img_text_video_map_setings',
                'default' => '8',
                'description' => 'Выберете шаблон данного блока. Заносить ли текст по картинку, как расположить текст и картинку относительно друг друга, как выровнять их относительно друг друга , всё это можете выбрать тут)',
            ]
        );

        $this->end_popover();

        $this->add_control(
			'show_zagolovok',
			[
				'label' => 'Нуже ли заголовок H ?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => 'Нужно ли добавлять заголовок H в этом блоке, если выбрано "Нет" то заголовок отображаться не будет.',
			]
		);

		$this->add_control(
			'popover_toggle_4',
			[
				'label' => 'Настройте заголовок H',
				'type' => Custom_Popover_Toggle::POPOVER_TOGGLE,
				'label_off' => 'Default',
				'label_on' => 'Custom',
				'return_value' => 'yes',
				'castom_type' => '2',
				'condition' => [
				    'show_zagolovok' => 'yes',
				],
				
			]
		);
		$this->start_popover();

		$this->add_control(
			'h_type',
			[
				'label' => 'Тип заголовока',
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'Заголовок H1 ',
					'h2' => 'Заголовок H2',
					'h3' => 'Заголовок H3',
					'h4' => 'Заголовок H4',
					'h5' => 'Заголовок H5',
					'h6' => 'Заголовок H6',
				],
				'default' => 'h1',
				'description' => 'Выберете тип заголовока в этом блоке. <br><span class="vazho_red">ОЧЕНЬ ВАЖНО:</span> заголовок <span class="vazho_red">H1</span> должен быть только <span class="vazho_red">1</span> на странице в самом верху перед всеми основными текстами, иначе будут проблемы с поисковыми ситемами. Для блоков которые будут располагаться ниже блокак с заголовоком H1 рекомендуется использовать тип заголовока H2.',
			]
		);
		$this->add_control(
			'zagolovok_h',
			[
				'label' => 'Заголовок H',
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 5,
				'default' => 'Заголовок H должен передавать суть содержимого текста под ним',
				'placeholder' => 'Заполните заголовок H',
				'description' => 'Заголовок H - важный элемент в оптимизации страницы, он должен содержать ключиевые слова для страницы (но не переборщите с этим), и в кратце передать содержание текста под ним',

			]
		);
		$this->add_responsive_control(
			'align_h',
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
				'tablet_default' => 'center',
				'mobile_default' => 'center',
				'description' => 'Выберете как выравнивать заголовок H, доступны 3 типа устройств для настройки.',
			]
		);
		$this->add_control(
			'zagolovok_p_b',
			[
				'label' => 'Убрать отсуп у заголовока?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => '',
				'description' => 'Если выбрано "Да" то у блока заголовока будет убран отступ снизу, полезно если нужно создать заголовок страницы или заголовок расположен над текстов в блоке рядом с картинкой.',
			]
		);
		$this->add_control(
            'zagolovok_type',
            [	
            	'label' => 'Тип блока заголовока H',
                'type' => Control_blok_typs::control_blok_typs,
                'value' => ['1','2'],
                'papka_s_img' => 'blok_img_text_video_map_h_setings',
                'default' => '1',
                'description' => 'Выберете как располагать блок заголовока, над картинкой с текстом или в блоке с текстом сверху. ВАЖНО: на 2-х картинках сверху расположение блоков картинки и текста относительно друг друга не играет ни какой роли на итоговом макете, тут играет роль положение блока с заголовоком на этих картинках!',
                'condition' => [
				    'blok_type!' => ['15','16'],
				],
            ]
        );

        $this->end_popover();

        $this->add_control(
			'img_or_video_or_map',
			[
				'label' => 'Что вставляем?',
				'type' => Controls_Manager::SELECT,
				'options' => [
					'img'  => 'Картинку',
					'map' => 'Карту',
					'video' => 'Видео',
				],
				'default' => 'img',
				'description' => 'Выберете что будем вставлять в этом блоке, картинку, карту или видео.',
				'condition' => [
				    'blok_type!' => '15',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'img_section',
			[
				'label' => 'Картинки',
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
				    'blok_type!' => '15',
				    'img_or_video_or_map' => 'img',
				],
			]
		);
		$this->add_control(
			'popover_toggle_5',
			[
				'label' => 'Тип блока картинок',
				'type' => Custom_Popover_Toggle::POPOVER_TOGGLE,
				'label_off' => 'Default',
				'label_on' => 'Custom',
				'return_value' => 'yes',
				'castom_type' => '2',
				'condition' => [
				    'blok_type!' => '16',
				],
				
			]
		);
		$this->start_popover();
		$this->add_control(
            'img_type',
            [	
            	'label' => 'Выберете тип блока картинки',
                'type' => Control_blok_typs::control_blok_typs,
                'default' => '1',
                'value' => ['1','2','3'],
                'papka_s_img' => 'type_blok_img',
                'description' => 'Выберете тип вставляемой картинки, есть 3 варианта:<br>
                	1) картинки 1:1 возле текста, могут выставлятся одна за другой в сколько угодно рядов по 2 в ряд.<br>
                	2) картинки 2:1 возле текста,  могут выставлятся одна за другой в сколько угодно рядов по 1 в ряд.<br>
                	3) картинки 1:1 возле текста, может быть только 1 в блоке',
            ]
        );
		$this->end_popover();

		$repeater = new Repeater();

        $repeater->add_control(
            'image_1',
            [
                'label' => 'Выберете изображение',
                'type' => Custom_Media_Uploader::custom_media_uploader,
                'default' => [
					'url' => KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_1.png',
				],
                'description' => 'Выберете изображение, соотношение сторон 1:1 , ширина к высоте',
            ]
        );
        
    	$this->add_control(
            'kartinki_typ_1',
            [
                'label' => 'Добавьте картинки 1:1',
                'type' => Custom_Repeater::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [],
                    [],
                ],
                'condition' => [
				    'img_type' => '1',
				    'blok_type!' => '16',
				],
				'description' => '<span class="vazho_red">Примечание:</span> картинок можно добавить больше чем 2, все последующие картинки будут выстраиваться в ряды, по 2 штуки в ряд.',
                'title_field' => '',
            ]
        );

    	$repeater = new Repeater();

        $repeater->add_control(
            'image_2',
            [
                'label' => 'Выберете изображение',
                'type' => Custom_Media_Uploader::custom_media_uploader,
                'default' => [
					'url' => KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_2.png',
				],
                'description' => 'Выберете изображение, соотношение сторон 2:1 , ширина к высоте',
            ]
        );

    	$this->add_control(
            'kartinki_typ_2',
            [
                'label' => 'Добавьте картинки 2:1',
                'type' => Custom_Repeater::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [],
                ],
                'condition' => [
				    'img_type' => '2',
				    'blok_type!' => '16',
				],
				'description' => '<span class="vazho_red">Примечание:</span> картинок можно добавить больше чем 1, все последующие картинки будут выстраиваться в ряды, по 1 штуке в ряд.',
                'title_field' => '',
            ]
        );

        $this->add_control(
			'image_3',
			[
				'label' => 'Выберете картинку',
				'type' => Custom_Media_Uploader::custom_media_uploader,
				'default' => [
					'url' => KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_1.png',
				],
				'description' => 'Выберете картинку, соотношение сторон 1:1 , ширина к высоте',
				'condition' => [
				    'img_type' => '3',
				    'blok_type!' => '16',
				],
			]
		);

		$this->add_control(
			'image_4',
			[
				'label' => 'Выберете картинку',
				'type' => Custom_Media_Uploader::custom_media_uploader,
				'default' => [
					'url' => KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_3.png',
				],
				'description' => 'Выберете картинку, соотношение сторон 3:1 , ширина к высоте для картинки типа "Картинка сверху всех страниц на всю ширину экрна".<br> Выберете картинку, соотношение сторон 7:4 , ширина к высоте для картинки типа "Картинка над жёлтыми ссылками". <br><span class="vazho_red">Примечание:</span> эта картинка становится доступной при выборе 16 типа шаблона блока (одна картинка в блоке) в разделе опций "Настройка шаблона"->"Выберете шаблон блока". Её можно использовать как для картинки сверху страницы растянув её настройками на всю ширину или же как картинку над жёлтыми ссылками применив соответствующие настройки.',
				'condition' => [
				    'blok_type' => '16',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'map_section',
			[
				'label' => 'Карта',
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
				    'blok_type!' => '15',
				    'img_or_video_or_map' => 'map',
				],
			]
		);
		$this->add_control(
			'popover_toggle_6',
			[
				'label' => 'Тип блока карты',
				'type' => Custom_Popover_Toggle::POPOVER_TOGGLE,
				'label_off' => 'Default',
				'label_on' => 'Custom',
				'return_value' => 'yes',
				'castom_type' => '2',
				
			]
		);
		$this->start_popover();
        $this->add_control(
            'map_type',
            [	
            	'label' => 'Выберете тип блока карты',
                'type' => Control_blok_typs::control_blok_typs,
                'default' => '1',
                'value' => ['1'],
                'papka_s_img' => 'type_blok_map',
                'description' => 'На данный момент доступен только один тип блока для вставки карты',
            ]
        );
		$this->end_popover();

		$this->add_control(
			'iframe_cod_map',
			[
				'label' => 'iframe код карты',
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 15,
				'placeholder' => 'Вставьте iframe код с картой',
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
			'video_section',
			[
				'label' => 'Видео',
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
				    'blok_type!' => '15',
				    'img_or_video_or_map' => 'video',
				],
			]
		);
		$this->add_control(
			'popover_toggle_7',
			[
				'label' => 'Тип блока видео',
				'type' => Custom_Popover_Toggle::POPOVER_TOGGLE,
				'label_off' => 'Default',
				'label_on' => 'Custom',
				'return_value' => 'yes',
				'castom_type' => '2',
				
			]
		);
		$this->start_popover();
        $this->add_control(
            'video_type',
            [	
            	'label' => 'Выберете тип блока видео',
                'type' => Control_blok_typs::control_blok_typs,
                'default' => '1',
                'value' => ['1'],
                'papka_s_img' => 'type_blok_video',
                'description' => 'На данный момент доступен только один тип блока для вставки видео',
            ]
        );
		$this->end_popover();

		$this->add_control(
			'iframe_cod_video',
			[
				'label' => 'iframe код видео',
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 7,
				'placeholder' => 'Вставьте iframe код видео с ютуб',
                'description' => 'Сюда нужно вставить iframe код видео, для этого:<br>
                	1. Перейдите на сайт ютуб с нужным видео.<br>
                	2. Под видео нажмите кнопку "Поделиться".<br>
                	3. Выберете пункт "Встроить".<br>
                	4. В открывшемся окне скоприруйте код вставки видео (справа).<br>
                	5. Вставьте полученный код в это текстовое поле.<br><br>
                	УРА! Вы встроили видео.',
                'default' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Z63tKU0ssIA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'text_section',
			[
				'label' => 'Текст',
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
				    'blok_type!' => '16',
				],
			]
		);
		$this->add_control(
			'text',
			[
				'label' => 'Заполните текст',
				'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [],
				'default' => '<p><span style="font-family: Thin;">С помощь этого блока Вы можете настроить более <span style="font-family: HeavyItalic;">80%</span> сайта!</span></p><p><span style="font-family: Black; color: #ff0000;">ВАЖНО:</span> <span style="font-family: MediumItalic;">при использовании в этом блоке раздела настроек "Готовые блоки" нужно быть крайне осторожным, т.к. при включённой опции <span style="color: #ff0000; font-family: Heavy;">ОЧЕНЬ ВАЖНО</span> в положение "Да" и дальнейшем выборе готового шаблона из списка предложенных, редактор соберёт конфигурацию используя значения по умолчания для каждой настройки, чтоб восстановить введённые Вами ранее данные можете нажать опцию "<span style="color: #63ff59;">Отменить всё что наклацали =)</span>", но учтите что эта опция вернёт Вам Ваши введённые данные только если Вы не покидали вкладку настроек "Готовые блоки". Если же Вы её покидали то Вам придётся нажимать "Ctrl+Z" до тех пор, пока не вернёте требуемое состояние. Или же можете выбрать историю последних изменений и отменить ненужные, но об этом подробнее в инструкции))</span></p><p><span style="font-family: Thin;">В новом редакторе Вы можете видеть все изменения в режиме реального времени, а так же смотреть как будет выглядеть сайт на различных типах устройств.</span></p><p><span style="font-family: Thin;">Так же в данном редакторе написано множество дополнительных функций, которые позволят Вам создавать более гибкие страницы в плане дизайна. И немаловажное <span style="font-family: HeavyItalic;">сайт по прежнему быстрый и адаптивный</span>, данный конструктор лишь слегка увеличил DOM вложенность элементов, но благодаря унифицированным блокам мы даже <span style="font-family: HeavyItalic;">выиграли</span> в исходном размере страницы!</span></p><p><span style="font-family: Thin;">С помощью конкретно данного блока Вы можете повторить такие старые блоки:</span></p><ul style="list-style-type: disc;"><li><span style="font-family: MediumItalic;">картинка сверху всех страниц</span></li><li><span style="font-family: MediumItalic;">блок заголовок сверху страницы под картинкой сверху всех страниц (страницы цен, контактов и.д и т.п)</span></li><li><span style="font-family: MediumItalic;">блок заголовок текст 2 картинки (в разных положениях картинки и текста)</span></li><li><span style="font-family: MediumItalic;">блок заголовок текст 1 картинка (в разных положениях картинки и текста)</span></li><li><span style="font-family: MediumItalic;">блок большая картинка с текстом сбоку (в разных положениях картинки и текста)</span></li><li><span style="font-family: MediumItalic;">блок картинка-текст для внутренних страниц услуг (в разных положениях картинки и текста)</span></li><li><span style="font-family: MediumItalic;">блок видео-текст для внутренних страниц услуг (в разных положениях видео и текста)</span></li><li><span style="font-family: MediumItalic;">блок картинка над жёлтыми ссылками</span></li><li><span style="font-family: MediumItalic;">блок большое видео</span></li><li><span style="font-family: MediumItalic;">блок текст</span></li></ul><p><span style="font-family: Thin;">А так же новые вариации:</span></p><ul><li><span style="font-family: MediumItalic;">блок карта-текст (в разных положениях карты и текста)</span></li></ul><p><span style="font-family: Thin;">Всё вышеописанные блоки так же редактируются по множеству других параметров, что даёт обширное поле для творчества в дизайне сайта, повторюсь, <span style="font-family: HeavyItalic;">не теряя в производительности</span>, а наоборот даже <span style="font-family: HeavyItalic;">выиграв</span> за счёт унифицированных блоков.</span></p><p><span style="font-family: Thin;">Если у Вас возникнут трудности с данным редактором Вы всегда можете обратиться к прилагаемым <span style="font-family: HeavyItalic;">видеоинструкциям</span> или же ко мне, в случае если инструкция не помогла с решением Вашей задачи.</span></p>',
				'placeholder' => 'Заполните текст',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'gotovie_bloki_section',
			[
				'label' => 'Готовые блоки',
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'gotovie_bloki_active',
			[
				'label' => 'Включить опцию "Готовые блоки" ?',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => '',
				'description' => 'Если выбрано "Да", то опция станет доступной.',
			]
		);
		$this->add_control(
			'default_active',
			[
				'label' => '<b style="color:#ff3131;font-size:18px;">ОЧЕНЬ ВАЖНО !!!</b>',
				'type' => Custom_switcher::custom_switcher,
				'return_value' => 'yes',
				'default' => '',
				'description' => 'Если выбрано "Да", то у готовых шаблонов блоков, ниже этой настройки, значения будут выставлены по умолчанию. Чтоб вернуть Ваши настройки нажмите эту опцию в положение "Нет", или воспользуйтесь опцией ниже "Отменить всё что наклацали =)". <br><span class="vazho_red">ВАЖНО:</span> опция "Отменить всё что наклацали =)" сработает только в случае если Вы не покидали вкладку настроек "Готовые блоки", если Вы её покинете то новые настройки запишутся и отменять их придется либо нажимая "Ctrl+Z" пока не вернётесь в нужное состояние, либо через историю изменений, более подробно будет описано в инструкции.',
				'condition' => [
				    'gotovie_bloki_active' => 'yes',
				],
			]
		);
		$this->add_control(
			'gotovie_bloki',
			[
				'label' => 'Выберете готовую заготовку из нижеперечисленных вариантов:',
				'type' => Control_vibor_shablona_bloka::control_vibor_shablona_bloka,
				'default' => '',
				'spisok' => [
					'elemnt_1' => [
						'id' => 'zagolovok_h1',
						'opisanie_id' => 'Заголовок H1',
					],
					'elemnt_2' => [
						'id' => 'img_sverhu',
						'opisanie_id' => 'Картинка сверху на весь экран',
					],
					'elemnt_3' => [
						'id' => 'h1_text',
						'opisanie_id' => 'Заголовок H1 - текст',
					],
					'elemnt_4' => [
						'id' => 'img_nad_y_ssilkami',
						'opisanie_id' => 'Картинка над жёлтыми ссылками',
					],
					'elemnt_5' => [
						'id' => 'h1_text_img',
						'opisanie_id' => 'Заголовок H1 - текст - картинка',
					],
					'elemnt_6' => [
						'id' => 'h1_text_2_img',
						'opisanie_id' => 'Заголовок H1 - текст - 2-картинки',
					],
					'elemnt_7' => [
						'id' => 'big_img_text',
						'opisanie_id' => 'Большая картинка - текст',
					],
					'elemnt_8' => [
						'id' => 'text_img',
						'opisanie_id' => 'Текст - картинка',
					],
					'elemnt_9' => [
						'id' => 'img_text',
						'opisanie_id' => 'Картинка - текст',
					],
					'elemnt_10' => [
						'id' => 'video_big',
						'opisanie_id' => 'Большой блок видео',
					],
					'elemnt_11' => [
						'id' => 'video_text',
						'opisanie_id' => 'Видео - текст',
					],
					'elemnt_12' => [
						'id' => 'default_blok_settings',
						'opisanie_id' => 'Настроки блока по умолчанию',
					],
					'elemnt_13' => [
						'id' => 'sbrosit',
						'opisanie_id' => '<span style="color: #63ff59;">Отменить всё что наклацали =)</span>',
					],
				],
				'description' => 'Эта функция создана специально на тот случай если Вы вдруг запутаетесь в настройках или случайно включите, или наоборот выключите какие-то опции, вследствие чего блок потеряет нужные визуальные данные, и захотите вернуть блок к состоянию по умолчанию. Так же она предназначена чтоб быстро собрать нужную конфигурацию блока в исходном макете, так к примеру нажав на "Заголовок H1 - текст - картинка" Вы мгновенно получите готовый для заполнения блок с заголовоком H1, блоком текста и блоком с 1 картинкой нужной конфигурации. <br><span class="vazho_red">ВАЖНО:</span> опция "Отменить всё что наклацали =)" сработает только в случае если Вы не покидали вкладку настроек "Готовые блоки", если Вы её покинете то новые настройки запишутся и отменять их придется либо нажимая "Ctrl+Z" пока не вернётесь в нужное состояние, либо через историю изменений, более подробно будет описано в инструкции.',
				'condition' => [
				    'gotovie_bloki_active' => 'yes',
				],
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

		$url_massiv = [ KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_1.png', KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_2.png', KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_3.png', KSN_ELEMENTOR_ADDON_URL.'/assets/img/placeholder/placeholder_4.png'];
		$img_mas = [];//тут хранится код тега img из цикла для текущего набора картинок

		if( $settings['kartinki_typ_1'] ){//картинки тип 1
			foreach ($settings['kartinki_typ_1'] as $item) {
				if ( $item['image_1']['id'] ) {
					$alt = get_post_meta($item['image_1']['id'], '_wp_attachment_image_alt', true);
					$title = get_the_title($item['image_1']['id']);
					$data_original_w = $item['image_1']['original_width'];
					$data_original_h = $item['image_1']['original_height'];
					$data_src_max = wp_get_original_image_url( $item['image_1']['id'] );
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
		}//картинки тип 1

		if( $settings['kartinki_typ_2'] ){//картинки тип 2
			foreach ($settings['kartinki_typ_2'] as $item) {
				if ( $item['image_2']['id'] ) {
					$alt = get_post_meta($item['image_2']['id'], '_wp_attachment_image_alt', true);
					$title = get_the_title($item['image_2']['id']);
					$data_original_w = $item['image_2']['original_width'];
					$data_original_h = $item['image_2']['original_height'];
					$data_src_max = wp_get_original_image_url( $item['image_2']['id'] );
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
		}//картинки тип 2

		if( $settings['image_3'] ){//картинка 4
				if ( $settings['image_3']['id'] ) {
					$alt = get_post_meta($settings['image_3']['id'], '_wp_attachment_image_alt', true);
					$title = get_the_title($settings['image_3']['id']);
					$data_original_w = $settings['image_3']['original_width'];
					$data_original_h = $settings['image_3']['original_height'];
					$data_src_max = wp_get_original_image_url( $settings['image_3']['id'] );
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
		}//картинка 3

		if( $settings['image_4'] ){//картинка 4
				if ( $settings['image_4']['id'] ) {
					$alt = get_post_meta($settings['image_4']['id'], '_wp_attachment_image_alt', true);
					$title = get_the_title($settings['image_4']['id']);
					$data_original_w = $settings['image_4']['original_width'];
					$data_original_h = $settings['image_4']['original_height'];
					$data_src_max = wp_get_original_image_url( $settings['image_4']['id'] );
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
		}//картинка 4
	?>

	
<div class="col-12 block_type_mutation 
<?php if ($is_elementor) { echo $show_desktop.' '.$show_tablet.' '.$show_mobile; } ?>
 <?php if($settings['padding_left']=='yes'){echo " pl-0 ";} if($settings['padding_top']=='yes'){echo " pt-0 ";} if($settings['padding_right']=='yes'){echo " pr-0 ";} if($settings['padding_bottom']=='yes'){echo " pb-0 ";} ?>">
    <div class="<?php echo $settings['shrina']; if($settings['shrina']!='col-xl-12'){echo " ".$settings['align_block']."";};?> col-xs-12">

    	<?php //блок заголовока типа 1 и для блоков шаблона типов 15 и 16 ?>
        <?php $b_t = ['15','16']; if (($settings['show_zagolovok']=='yes' && $settings['zagolovok_h'] && $settings['zagolovok_type']==1) || ($settings['show_zagolovok']=='yes' && $settings['zagolovok_h'] && in_array($settings['blok_type'], $b_t) )){ ?>
        <div class="col-12 zagolovok_uslugi<?php if($settings['zagolovok_p_b']=='yes'){echo " pb-0 ";} ?>">
            <<?php echo $settings['h_type'];?> class="<?php if($settings['align_h']){echo "text_".$settings['align_h']." ";}if($settings['align_h_tablet']){echo "text_planshet_".$settings['align_h_tablet']."";}if($settings['align_h_mobile']&&$settings['align_h_tablet']){echo " text_mobile_".$settings['align_h_mobile']."";}elseif($settings['align_h_mobile']&&!$settings['align_h_tablet']){echo "text_mobile_".$settings['align_h_mobile']."";}?>"><?php echo $settings['zagolovok_h']; ?></<?php echo $settings['h_type'];?>>
        </div>
        <?php } ?>
        <?php //блок заголовока типа 1 и для блоков шаблона типов 15 и 16 ?>


        <?php if(!$settings['img_or_video_or_map'] && $settings['blok_type']==15){//для блока 15 типа это когда img_or_video_or_map не определён?>
        	<div class="blok_wraper_img_text">
        		<div class="col-12 blok_wraper_text">
        			<?php if($settings['text']){echo $settings['text'];}//блок текста?>
        		</div>
        	</div>
        <?php }//для блока 15 типа это когда img_or_video_or_map не определён?>





	<?php if($settings['img_or_video_or_map']=='img'){//для вставки только картинок?>

        <?php if($settings['blok_type']!=16){//для блоков кроме 16 типа?>

        <?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){//для блоков кроме 7 и 8 типа?>
        <div class="blok_wraper_img_text <?php $b_t = ['1','2','3','9','10','11']; if( in_array($settings['blok_type'], $b_t) ){echo "order_img_blok_1";}?>">
        <?php } //для блоков кроме 7 и 8 типа?>
        


            <?php if($settings['img_type']==1){ // для 1 типа блока картинки?>
            <div class="col-lg-6 col-xs-12 blok_wraper_img flex_display <?php if($settings['blok_type'] == 7){echo "float_left";}elseif($settings['blok_type'] == 8){echo "float_right";}if($settings['blok_type']==2 || $settings['blok_type']==5){echo "align_items_center";}if($settings['blok_type']==3 || $settings['blok_type']==6){echo "align_items_bottom";}?>">
                <div class="col-12 flex_display">

                <?php  //картинки 1 типа ?>
            	<?php foreach ($settings['kartinki_typ_1'] as $key => $item) {
                	if($item['image_1']['id']) { ?>
                	<div class="col-sm-6 col-xs-12 blok_img">
                        <div class="img_wrapper">
                            <?php echo '<img class="img_size" data-type="img_content" '.$img_mas[$key].'>';?>
                            <script>data_site.ips();</script>
                            <div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script>
                        </div>
                    </div>  		
                	<?php } else { ?>
                	<div class="col-sm-6 col-xs-12 blok_img">
                        <div class="img_wrapper" style="padding-top: 100%;">
                        	<?php echo '<img data-type="img_maket" data-src="'.$url_massiv[0].'" >';?>
                            <div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script> 
                        </div>
                    </div>  		
                	<?php }
                } ?>
                <?php  //картинки 1 типа ?>

                </div>
            </div>
            <?php } // для 1 типа блока картинки?>

            <?php if($settings['img_type']==2){ // для 2 типа блока картинки?>
            <div class="col-lg-6 col-xs-12 img_typ_2 blok_wraper_img flex_display <?php if($settings['blok_type'] == 7){echo "float_left";}elseif($settings['blok_type'] == 8){echo "float_right";}if($settings['blok_type']==2 || $settings['blok_type']==5){echo "align_items_center";}if($settings['blok_type']==3 || $settings['blok_type']==6){echo "align_items_bottom";}?>">
            	<div class="col-12 flex_display">

            	<?php  //картинки 2 типа ?>
                <?php foreach ($settings['kartinki_typ_2'] as $key => $item) {
                	if($item['image_2']['id']) { ?>
                	<div class="col-12 blok_img">
                        <div class="img_wrapper">
                            <?php echo '<img class="img_size" data-type="img_content" '.$img_mas[$key].'>';?>
                            <script>data_site.ips();</script>
                            <div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script>
                        </div>
                    </div>   		
                	<?php } else { ?>
                	<div class="col-12 blok_img">
                        <div class="img_wrapper" style="padding-top: 50%;">
                        	<?php echo '<img data-type="img_maket" data-src="'.$url_massiv[1].'" >';?>
                            <div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script> 
                        </div>
                    </div>   		
                	<?php }
                } ?>
                <?php  //картинки 2 типа ?>

                </div>
            </div>
            <?php } // для 2 типа блока картинки?>

            <?php if($settings['img_type']==3){ // для 3 типа блока картинки?>
            <div class="col-lg-6 col-xs-12 img_typ_3 blok_wraper_img flex_display <?php if($settings['blok_type'] == 7){echo "float_left";}elseif($settings['blok_type'] == 8){echo "float_right";}if($settings['blok_type']==2 || $settings['blok_type']==5){echo "align_items_center";}if($settings['blok_type']==3 || $settings['blok_type']==6){echo "align_items_bottom";}?>">
            	<div class="col-12 flex_display">

            	<?php // картинка image_3?>  
                <?php if($settings['image_3']['id']) { ?>
                	<div class="col-12 blok_img">
                        <div class="img_wrapper">
                            <?php echo '<img class="img_size" data-type="img_content" '.$img_mas[0].'>';?>
                            <script>data_site.ips();</script>
                        	<div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script>
                        </div>
                    </div>   		
                	<?php } else { ?>
                	<div class="col-12 blok_img">
                        <div class="img_wrapper" style="padding-top: 100%;"> 
                        	<?php echo '<img data-type="img_maket" data-src="'.$url_massiv[0].'" >';?>
                        	<div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script>
                        </div>
                    </div>   		
                	<?php } ?>
                <?php // картинка image_3?>

                </div>
            </div>
            <?php } // для 3 типа блока картинки?>


            <div class="col-lg-<?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){echo "6";}else{echo "12";} ?> col-xs-12 blok_wraper_text <?php if($settings['blok_type']==10 || $settings['blok_type']==13){echo "align_items_center flex_display";}if($settings['blok_type']==11 || $settings['blok_type']==14){echo "align_items_bottom flex_display";}?>">

            	<?php //блок заголовока типа 2 ?>
		    	<?php if ($settings['show_zagolovok']=='yes' && $settings['zagolovok_h'] && $settings['zagolovok_type']==2){ ?>
		        <div class="col-12 zagolovok_uslugi<?php if($settings['zagolovok_p_b']=='yes'){echo " pb-0 ";} ?>">
		            <<?php echo $settings['h_type'];?> class="<?php if($settings['align_h']){echo "text_".$settings['align_h']." ";}if($settings['align_h_tablet']){echo "text_planshet_".$settings['align_h_tablet']."";}if($settings['align_h_mobile']&&$settings['align_h_tablet']){echo " text_mobile_".$settings['align_h_mobile']."";}elseif($settings['align_h_mobile']&&!$settings['align_h_tablet']){echo "text_mobile_".$settings['align_h_mobile']."";}?>"><?php echo $settings['zagolovok_h']; ?></<?php echo $settings['h_type'];?>>
		        </div>
		        <?php } ?>
		        <?php //блок заголовока типа 2 ?>


		        <div>
		        	<?php if($settings['text']){echo $settings['text'];}//блок текста?>	
		        </div>

            </div>





		    <?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){//для блоков кроме 7 и 8 типа?>
		    </div>
		    <?php } //для блоков кроме 7 и 8 типа?>

    	<?php } //для блоков кроме 16 типа?>

	    <?php if($settings['blok_type']==16){// картинка для 16 типа шаблона блока ?>
	    	<?php if($settings['shrina']!='col-xl-9'){ ?>

	    		<?php // картинка image_4?>  
                <?php if($settings['image_4']['id']) { ?>
                	<div class="col-12 blok_img">
                        <div class="img_wrapper">
                            <?php echo '<img class="img_size" data-type="img_content" '.$img_mas[0].'>';?>
                            <script>data_site.ips();</script>
                            <div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script> 
                        </div>
                    </div>   		
                	<?php } else { ?>
                	<div class="col-12 blok_img">
                        <div class="img_wrapper" style="padding-top: 33.33%;">
                        	<?php echo '<img data-type="img_maket" data-src="'.$url_massiv[3].'" >';?>
                        	<div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script> 
                        </div>
                    </div>  		
                <?php } ?>
	    	<?php } else { ?>
	    		<?php if($settings['image_4']['id']) { ?>
                	<div class="col-12 blok_img">
                        <div class="img_wrapper">
                           <?php echo '<img class="img_size" data-type="img_content" '.$img_mas[0].'>';?>
                            <script>data_site.ips();</script>
                            <div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script> 
                        </div>
                    </div>   		
                	<?php } else { ?>
                	<div class="col-12 blok_img">
                        <div class="img_wrapper" style="padding-top: 66.67%;">
                        	<?php echo '<img data-type="img_maket" data-src="'.$url_massiv[2].'" >';?>
                            <div class="media_loader">
                                <div class="loader"></div>
                            </div>
                            <script>data_site.l();</script> 
                        </div>
                    </div>
               	<?php } ?>
               	<?php // картинка image_4?>   	

	    	<?php } ?>
		<?php } // картинка для 16 типа шаблона блока?>

    <?php } //для вставки только картинок?>





    <?php if($settings['img_or_video_or_map']=='video'){//для вставки только видео?>

	    <?php if($settings['blok_type']!=16){//для блоков кроме 16 типа?>

	        <?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){//для блоков кроме 7 и 8 типа?>
	        <div class="blok_wraper_img_text <?php $b_t = ['1','2','3','9','10','11']; if( in_array($settings['blok_type'], $b_t) ){echo "order_img_blok_1";}?>">
	        <?php } //для блоков кроме 7 и 8 типа?>


		            <?php if($settings['video_type']==1){ // для 1 типа блока видео?>
		            <div class="col-lg-6 col-xs-12 blok_wraper_img flex_display <?php if($settings['blok_type'] == 7){echo "float_left";}elseif($settings['blok_type'] == 8){echo "float_right";}if($settings['blok_type']==2 || $settings['blok_type']==5){echo "align_items_center";}if($settings['blok_type']==3 || $settings['blok_type']==6){echo "align_items_bottom";}?>">
		                <div class="col-12 block_video">
							<div class="video_wrapper col-12">
								<div class="media_loader">
						            <div class="loader"></div>
						        </div>
						        <script>data_site.l();</script>
								<div class="video_ytube">
								    <!--<?php echo $settings['iframe_cod_video']; ?>-->
								</div>
							</div>
		                </div>
		            </div>
		            <?php } // для 1 типа блока видео?>




	            <div class="col-lg-<?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){echo "6";}else{echo "12";} ?> col-xs-12 blok_wraper_text <?php if($settings['blok_type']==10 || $settings['blok_type']==13){echo "align_items_center flex_display";}if($settings['blok_type']==11 || $settings['blok_type']==14){echo "align_items_bottom flex_display";}?>">

	            	<?php //блок заголовока типа 2 ?>
			    	<?php if ($settings['show_zagolovok']=='yes' && $settings['zagolovok_h'] && $settings['zagolovok_type']==2){ ?>
			        <div class="col-12 zagolovok_uslugi<?php if($settings['zagolovok_p_b']=='yes'){echo " pb-0 ";} ?>">
			            <<?php echo $settings['h_type'];?> class="<?php if($settings['align_h']){echo "text_".$settings['align_h']." ";}if($settings['align_h_tablet']){echo "text_planshet_".$settings['align_h_tablet']."";}if($settings['align_h_mobile']&&$settings['align_h_tablet']){echo " text_mobile_".$settings['align_h_mobile']."";}elseif($settings['align_h_mobile']&&!$settings['align_h_tablet']){echo "text_mobile_".$settings['align_h_mobile']."";}?>"><?php echo $settings['zagolovok_h']; ?></<?php echo $settings['h_type'];?>>
			        </div>
			        <?php } ?>
			        <?php //блок заголовока типа 2 ?>


			        <div>
	                	<?php if($settings['text']){echo $settings['text'];}//блок текста?>
	                </div>

	            </div>



		    <?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){//для блоков кроме 7 и 8 типа?>
		    </div>
		    <?php } //для блоков кроме 7 и 8 типа?>

	    <?php } //для блоков кроме 16 типа?>


	    <?php if($settings['blok_type']==16){// видео для 16 типа шаблона блока ?>

	    	<?php if($settings['video_type']==1){ // для 1 типа блока видео?>
		        <div class="col-12 block_video">
					<div class="video_wrapper col-12">
						<div class="media_loader">
						    <div class="loader"></div>
						</div>
						<script>data_site.l();</script>
						<div class="video_ytube">
							<!--<?php echo $settings['iframe_cod_video']; ?>-->
						</div>
					</div>
		    	</div>
			<?php } // для 1 типа блока видео?>

	    <?php } // видео для 16 типа шаблона блока?>

    <?php } //для вставки только видео?>





    <?php if($settings['img_or_video_or_map']=='map'){//для вставки только карт?>

	    <?php if($settings['blok_type']!=16){//для блоков кроме 16 типа?>

	        <?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){//для блоков кроме 7 и 8 типа?>
	        <div class="blok_wraper_img_text <?php $b_t = ['1','2','3','9','10','11']; if( in_array($settings['blok_type'], $b_t) ){echo "order_img_blok_1";}?>">
	        <?php } //для блоков кроме 7 и 8 типа?>


		            <?php if($settings['map_type']==1){ // для 1 типа блока карт?>
		            <div class="col-lg-6 col-xs-12 blok_wraper_img flex_display <?php if($settings['blok_type'] == 7){echo "float_left";}elseif($settings['blok_type'] == 8){echo "float_right";}if($settings['blok_type']==2 || $settings['blok_type']==5){echo "align_items_center";}if($settings['blok_type']==3 || $settings['blok_type']==6){echo "align_items_bottom";}?>">
						<div class="col-12 block_map">
							<div class="map_wrapper col-12">
								<div class="media_loader">
					            	<div class="loader"></div>
					            </div>
					            <script>data_site.l();</script>
					            <div class="map_fpame">
					            	<!--<?php echo $settings['iframe_cod_map']; ?>-->
					            </div>
							</div>
						</div>
		            </div>
		            <?php } // для 1 типа блока карт?>




	            <div class="col-lg-<?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){echo "6";}else{echo "12";} ?> col-xs-12 blok_wraper_text <?php if($settings['blok_type']==10 || $settings['blok_type']==13){echo "align_items_center flex_display";}if($settings['blok_type']==11 || $settings['blok_type']==14){echo "align_items_bottom flex_display";}?>">

	            	<?php //блок заголовока типа 2 ?>
			    	<?php if ($settings['show_zagolovok']=='yes' && $settings['zagolovok_h'] && $settings['zagolovok_type']==2){ ?>
			        <div class="col-12 zagolovok_uslugi<?php if($settings['zagolovok_p_b']=='yes'){echo " pb-0 ";} ?>">
			            <<?php echo $settings['h_type'];?> class="<?php if($settings['align_h']){echo "text_".$settings['align_h']." ";}if($settings['align_h_tablet']){echo "text_planshet_".$settings['align_h_tablet']."";}if($settings['align_h_mobile']&&$settings['align_h_tablet']){echo " text_mobile_".$settings['align_h_mobile']."";}elseif($settings['align_h_mobile']&&!$settings['align_h_tablet']){echo "text_mobile_".$settings['align_h_mobile']."";}?>"><?php echo $settings['zagolovok_h']; ?></<?php echo $settings['h_type'];?>>
			        </div>
			        <?php } ?>
			        <?php //блок заголовока типа 2 ?>


			        <div>
	                	<?php if($settings['text']){echo $settings['text'];}//блок текста?>
	                </div>

	            </div>



		    <?php if( ($settings['blok_type'] != 7) && ($settings['blok_type'] != 8) ){//для блоков кроме 7 и 8 типа?>
		    </div>
		    <?php } //для блоков кроме 7 и 8 типа?>

	    <?php } //для блоков кроме 16 типа?>


	    <?php if($settings['blok_type']==16){// карта для 16 типа шаблона блока ?>

	    	<?php if($settings['map_type']==1){ // для 1 типа блока карт?>
			<div class="col-12 block_map">
				<div class="map_wrapper col-12">
					<div class="media_loader">
					    <div class="loader"></div>
					</div>
					<script>data_site.l();</script>
					<div class="map_fpame">
					    <!--<?php echo $settings['iframe_cod_map']; ?>-->
					</div>
				</div>
			</div>
			<?php } // для 1 типа блока карт?>

	    <?php } // карта для 16 типа шаблона блока?>

    <?php } //для вставки только карт?>




	</div>
</div>



<?php }//render

protected function content_template() { ?>

<div class="col-12 block_type_mutation 
<# if(settings.prefer_devices.show_desktop!=='yes'){#> hide_desktop <#} if(settings.prefer_devices.show_tablet!=='yes'){#> hide_tablet <#} if(settings.prefer_devices.show_mobile!=='yes'){#> hide_mobile <#}#>
 <# if(settings.padding_left=='yes'){#> pl-0 <#} if(settings.padding_top=='yes'){#> pt-0 <#} if(settings.padding_right=='yes'){#> pr-0 <#} if(settings.padding_bottom=='yes'){#> pb-0 <#}#>">
    <div class="{{settings.shrina}}<# if ( settings.shrina != 'col-xl-12' ) { #> {{settings.align_block}}<#}#> col-xs-12">
    	<?php //блок заголовока типа 1 и для блоков шаблона типов 15 и 16 ?>
        <# var b_t_1 = ['15','16']; if( (settings.show_zagolovok == 'yes' && settings.zagolovok_h && settings.zagolovok_type == 1) || (settings.show_zagolovok == 'yes' && settings.zagolovok_h && b_t_1.includes(settings.blok_type)) ){ #>
        <div class="col-12 zagolovok_uslugi<# if(settings.zagolovok_p_b == 'yes'){#> pb-0 <# } #>">
        	<{{settings.h_type}} class="<# if(settings.align_h){#> text_{{settings.align_h}} <#} if(settings.align_h_tablet){ #> text_planshet_{{settings.align_h_tablet}} <# } if(settings.align_h_mobile){#> text_mobile_{{settings.align_h_mobile}} <#} #>">{{settings.zagolovok_h}}</{{settings.h_type}}>
        </div>
        <# } #>
        <?php //блок заголовока типа 1 и для блоков шаблона типов 15 и 16 ?>

        <?php //для блока 15 типа?>
        <# if(settings.blok_type == 15){ #>
        <div class="blok_wraper_img_text">
            <div class="col-12 blok_wraper_text">
            	<# if(settings.text){ #>
                	{{{settings.text}}}
                <# } #>
            </div>
        </div>
        <# } #>
        <?php //для блока 15 типа ?>

        <?php //для всех блоков кроме 15?>
        <# if(settings.blok_type != 15){ #>

        	<?php //для вставки только картинок ?>
        	<# if(settings.img_or_video_or_map == 'img'){ #>

        		<?php //для блоков кроме 16 типа ?>
        		<# if(settings.blok_type != 16){ #>

        			<?php //для блоков кроме 7 и 8 типа ?>
        			<# if( (settings.blok_type != 7) && (settings.blok_type != 8) ){ #>
        			<div class="blok_wraper_img_text <# var b_t_2 = ['1','2','3','9','10','11']; if(b_t_2.includes(settings.blok_type)){#>order_img_blok_1<#}#>">
        			<# } #>
        			<?php //для блоков кроме 7 и 8 типа ?>

        				<?php //для 1 типа блока картинки ?>
        				<# if(settings.img_type == 1){ #>
        				<div class="col-lg-6 col-xs-12 blok_wraper_img flex_display <# if(settings.blok_type == 7){#>float_left<#} else if(settings.blok_type == 8){#>float_right<#} if(settings.blok_type == 2 || settings.blok_type == 5){#>align_items_center<#} if(settings.blok_type == 3 || settings.blok_type == 6){#>align_items_bottom<#}#>">
        					<div class="col-12 flex_display">
        					<# if ( settings.kartinki_typ_1.length ) { #>
                                <# _.each( settings.kartinki_typ_1, function( item ) { #>
                            	<div class="col-sm-6 col-xs-12 blok_img">
                            		<# if(item.image_1.id){ #>
                            		<img src="{{ item.image_1.url }}" alt="{{ item.image_1.alt }}" title="{{ item.image_1.title }}">
                            		<# } else { #> 
                            		<img src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_1.png" >
                            		<# } #>
			                    </div> 
                            	<# }); #>
                        	<# } #>
        					</div>
        				</div>
        				<# } #>
        				<?php //для 1 типа блока картинки ?>

        				<?php //для 2 типа блока картинки ?>
        				<# if(settings.img_type == 2){ #>
        				<div class="col-lg-6 col-xs-12 img_typ_2 blok_wraper_img flex_display <# if(settings.blok_type == 7){#>float_left<#} else if(settings.blok_type == 8){#>float_right<#} if(settings.blok_type == 2 || settings.blok_type == 5){#>align_items_center<#} if(settings.blok_type == 3 || settings.blok_type == 6){#>align_items_bottom<#}#>">
        					<div class="col-12 flex_display">
        					<# if ( settings.kartinki_typ_2.length ) { #>
                                <# _.each( settings.kartinki_typ_2, function( item ) { #>
                            	<div class="col-12 blok_img">
                            		<# if(item.image_2.id){ #>
                            		<img src="{{ item.image_2.url }}" alt="{{ item.image_2.alt }}" title="{{ item.image_2.title }}">
                            		<# } else { #> 
                            		<img src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_2.png" >
                            		<# } #>
			                    </div> 
                            	<# }); #>
                        	<# } #>
        					</div>
        				</div>
        				<# } #>
        				<?php //для 2 типа блока картинки ?>

        				<?php //для 3 типа блока картинки ?>
        				<# if(settings.img_type == 3){ #>
        				<div class="col-lg-6 col-xs-12 img_typ_3 blok_wraper_img flex_display <# if(settings.blok_type == 7){#>float_left<#} else if(settings.blok_type == 8){#>float_right<#} if(settings.blok_type == 2 || settings.blok_type == 5){#>align_items_center<#} if(settings.blok_type == 3 || settings.blok_type == 6){#>align_items_bottom<#}#>">
        					<div class="col-12 flex_display">
                            	<div class="col-12 blok_img">
                            		<# if(settings.image_3.id){ #>
                            		<img src="{{ settings.image_3.url }}" alt="{{ settings.image_3.alt }}" title="{{ settings.image_3.title }}">
                            		<# } else { #> 
                            		<img src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_1.png" >
                            		<# } #>
			                    </div>
        					</div>
        				</div>
        				<# } #>
        				<?php //для 3 типа блока картинки ?>

        				<?php //блок с текстом ?>
        				<div class="col-lg-<# if((settings.blok_type != 7) && (settings.blok_type != 8)){#>6<#} else {#>12<#} #> col-xs-12 blok_wraper_text <# if(settings.blok_type == 10 || settings.blok_type == 13){#>align_items_center flex_display<#} if(settings.blok_type == 11 || settings.blok_type == 14){#>align_items_bottom flex_display<#} #>">
        					<?php //блок заголовока типа 2 ?>
        					<# if(settings.show_zagolovok == 'yes' && settings.zagolovok_h && settings.zagolovok_type == 2){ #>
        					<div class="col-12 zagolovok_uslugi<# if(settings.zagolovok_p_b == 'yes'){#> pb-0 <# } #>">
        					<{{settings.h_type}} class="<# if(settings.align_h){#> text_{{settings.align_h}} <#} if(settings.align_h_tablet){ #> text_planshet_{{settings.align_h_tablet}} <# } if(settings.align_h_mobile){#> text_mobile_{{settings.align_h_mobile}} <#} #>">{{settings.zagolovok_h}}</{{settings.h_type}}>	
        					</div>
        					<# } #>
        					<?php //блок заголовока типа 2 ?>
        					<?php //текст ?>
        					<# if(settings.text){ #>
        					<div>
			                	{{{settings.text}}}
			               	</div>
			                <# } #>
			                <?php //текст ?>
        				</div>
        				<?php //блок с текстом ?>

        			<?php //для блоков кроме 7 и 8 типа ?>
        			<# if( (settings.blok_type != 7) && (settings.blok_type != 8) ){ #>
        			</div>
        			<# } #>
        			<?php //для блоков кроме 7 и 8 типа ?>

        		<# } #>
        		<?php //для блоков кроме 16 типа ?>

        		<?php //для блоков 16 типа ?>
        		<# if(settings.blok_type == 16){ #>
        		<div class="col-12 blok_img">
        			<# if ( settings.shrina != 'col-xl-9' ){ #>
	                	<# if(settings.image_4.id){ #>
	                    <img src="{{ settings.image_4.url }}" alt="{{ settings.image_4.alt }}" title="{{ settings.image_4.title }}">
	                    <# } else { #> 
	                    <img src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_4.png" >
	                    <# } #>
	            	<# } else { #>
	                	<# if(settings.image_4.id){ #>
	                    <img src="{{ settings.image_4.url }}" alt="{{ settings.image_4.alt }}" title="{{ settings.image_4.title }}">
	                    <# } else { #> 
	                    <img src="/wp-content/plugins/ksn_site_control/elementor_addon/assets/img/placeholder/placeholder_3.png" >
	                    <# } #>
	            	<# } #>
        		</div>
        		<# } #>
        		<?php //для блоков 16 типа ?>

        	<# } #>
        	<?php //для вставки только картинок ?>

        	<?php //для вставки только видео ?>
        	<# if(settings.img_or_video_or_map == 'video'){ #>

        		<?php //для блоков кроме 16 типа ?>
        		<# if(settings.blok_type != 16){ #>

        			<?php //для блоков кроме 7 и 8 типа ?>
        			<# if( (settings.blok_type != 7) && (settings.blok_type != 8) ){ #>
        			<div class="blok_wraper_img_text <# var b_t_3 = ['1','2','3','9','10','11']; if(b_t_3.includes(settings.blok_type)){#>order_img_blok_1<#}#>">
        			<# } #>
        			<?php //для блоков кроме 7 и 8 типа ?>

	        			<?php //для 1 типа блока видео ?>
	        			<# if(settings.video_type == 1){ #>
	        			<div class="col-lg-6 col-xs-12 blok_wraper_img flex_display <# if(settings.blok_type == 7){#>float_left<#} else if(settings.blok_type == 8){#>float_right<#} if(settings.blok_type == 2 || settings.blok_type == 5){#>align_items_center<#} if(settings.blok_type == 3 || settings.blok_type == 6){#>align_items_bottom<#}#>">
	                        <div class="col-12 block_video">
	                            <div class="video_wrapper col-12">
	                                <div class="media_loader">
	                                    <div class="loader"></div>
	                                </div>
	                                <div class="video_ytube">
	                                    <!--{{{settings.iframe_cod_video}}}-->
	                                </div>
	                            </div>
	                        </div>
        				</div>
	        			<# } #>
	        			<?php //для 1 типа блока видео ?>

	        			<?php //блок с текстом ?>
        				<div class="col-lg-<# if((settings.blok_type != 7) && (settings.blok_type != 8)){#>6<#} else {#>12<#} #> col-xs-12 blok_wraper_text <# if(settings.blok_type == 10 || settings.blok_type == 13){#>align_items_center flex_display<#} if(settings.blok_type == 11 || settings.blok_type == 14){#>align_items_bottom flex_display<#} #>">
        					<?php //блок заголовока типа 2 ?>
        					<# if(settings.show_zagolovok == 'yes' && settings.zagolovok_h && settings.zagolovok_type == 2){ #>
        					<div class="col-12 zagolovok_uslugi<# if(settings.zagolovok_p_b == 'yes'){#> pb-0 <# } #>">
        					<{{settings.h_type}} class="<# if(settings.align_h){#> text_{{settings.align_h}} <#} if(settings.align_h_tablet){ #> text_planshet_{{settings.align_h_tablet}} <# } if(settings.align_h_mobile){#> text_mobile_{{settings.align_h_mobile}} <#} #>">{{settings.zagolovok_h}}</{{settings.h_type}}>	
        					</div>
        					<# } #>
        					<?php //блок заголовока типа 2 ?>
        					<?php //текст ?>
        					<# if(settings.text){ #>
			               	<div>
			                	{{{settings.text}}}
			               	</div>
			                <# } #>
			                <?php //текст ?>
        				</div>
        				<?php //блок с текстом ?>

        			<?php //для блоков кроме 7 и 8 типа ?>
        			<# if( (settings.blok_type != 7) && (settings.blok_type != 8) ){ #>
        			</div>
        			<# } #>
        			<?php //для блоков кроме 7 и 8 типа ?>

        		<# } #>
        		<?php //для блоков кроме 16 типа ?>

        		<?php //для блоков 16 типа ?>
        		<# if(settings.blok_type == 16){ #>

        			<?php //для 1 типа блока видео ?>
	        		<# if(settings.video_type == 1){ #>
	                <div class="col-12 block_video">
	                    <div class="video_wrapper col-12">
	                        <div class="media_loader">
	                            <div class="loader"></div>
	                        </div>
	                        <div class="video_ytube">
	                            <!--{{{settings.iframe_cod_video}}}-->
	                        </div>
	                    </div>
	                </div>
	        		<# } #>
	        		<?php //для 1 типа блока видео ?>

        		<# } #>
        		<?php //для блоков 16 типа ?>

        	<# } #>
        	<?php //для вставки только видео?>

        	<?php //для вставки только карт ?>
        	<# if(settings.img_or_video_or_map == 'map'){ #>

        		<?php //для блоков кроме 16 типа ?>
        		<# if(settings.blok_type != 16){ #>

        			<?php //для блоков кроме 7 и 8 типа ?>
        			<# if( (settings.blok_type != 7) && (settings.blok_type != 8) ){ #>
        			<div class="blok_wraper_img_text <# var b_t_3 = ['1','2','3','9','10','11']; if(b_t_3.includes(settings.blok_type)){#>order_img_blok_1<#}#>">
        			<# } #>
        			<?php //для блоков кроме 7 и 8 типа ?>

        			<?php //для 1 типа блока карт ?>
	        			<# if(settings.map_type == 1){ #>
	        			<div class="col-lg-6 col-xs-12 blok_wraper_img flex_display <# if(settings.blok_type == 7){#>float_left<#} else if(settings.blok_type == 8){#>float_right<#} if(settings.blok_type == 2 || settings.blok_type == 5){#>align_items_center<#} if(settings.blok_type == 3 || settings.blok_type == 6){#>align_items_bottom<#}#>">
	                        <div class="col-12 block_map">
	                            <div class="map_wrapper col-12">
	                                <div class="media_loader">
	                                    <div class="loader"></div>
	                                </div>
	                                <div class="map_fpame">
	                                	<!--{{{settings.iframe_cod_map}}}-->
	                                </div>
	                            </div>
	                        </div>
        				</div>
	        			<# } #>
	        			<?php //для 1 типа блока карт ?>

	        			<?php //блок с текстом ?>
        				<div class="col-lg-<# if((settings.blok_type != 7) && (settings.blok_type != 8)){#>6<#} else {#>12<#} #> col-xs-12 blok_wraper_text <# if(settings.blok_type == 10 || settings.blok_type == 13){#>align_items_center flex_display<#} if(settings.blok_type == 11 || settings.blok_type == 14){#>align_items_bottom flex_display<#} #>">
        					<?php //блок заголовока типа 2 ?>
        					<# if(settings.show_zagolovok == 'yes' && settings.zagolovok_h && settings.zagolovok_type == 2){ #>
        					<div class="col-12 zagolovok_uslugi<# if(settings.zagolovok_p_b == 'yes'){#> pb-0 <# } #>">
        					<{{settings.h_type}} class="<# if(settings.align_h){#> text_{{settings.align_h}} <#} if(settings.align_h_tablet){ #> text_planshet_{{settings.align_h_tablet}} <# } if(settings.align_h_mobile){#> text_mobile_{{settings.align_h_mobile}} <#} #>">{{settings.zagolovok_h}}</{{settings.h_type}}>	
        					</div>
        					<# } #>
        					<?php //блок заголовока типа 2 ?>
        					<?php //текст ?>
        					<# if(settings.text){ #>
			                <div>
			                	{{{settings.text}}}
			               	</div>
			                <# } #>
			                <?php //текст ?>
        				</div>
        				<?php //блок с текстом ?>

        			<?php //для блоков кроме 7 и 8 типа ?>
        			<# if( (settings.blok_type != 7) && (settings.blok_type != 8) ){ #>
        			</div>
        			<# } #>
        			<?php //для блоков кроме 7 и 8 типа ?>

        		<# } #>
        		<?php //для блоков кроме 16 типа ?>

        		<?php //для блоков 16 типа ?>
        		<# if(settings.blok_type == 16){ #>

        			<?php //для 1 типа блока карт ?>
	        		<# if(settings.map_type == 1){ #>
	        		<div class="col-12 block_map">
	                    <div class="map_wrapper col-12">
	                        <div class="media_loader">
	                            <div class="loader"></div>
	                        </div>
	                        <div class="map_fpame">
	                            <!--{{{settings.iframe_cod_map}}}-->
	                        </div>
	                    </div>
	                </div>
	        		<# } #>
	        		<?php //для 1 типа блока карт ?>

        		<# } #>
        		<?php //для блоков 16 типа ?>

        	<# } #>
        	<?php //для вставки только карт?>

        <# } #>
        <?php //для всех блоков кроме 15?>

	</div>
</div>
<script>data_site.l();</script>
		<?php
	}//_content_template

	
}	