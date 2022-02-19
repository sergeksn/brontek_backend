//{elementType} тип элемента на окне редактора в предпросмотре section column widget
//panel - панель управления этим {elementType} в редакторе слева
//model - все данные для вывода данного {elementType} , атрибуты, HTML, настройки ( модель этого {elementType})
/*view - этот {elementType} в окне редактора в предпросмотре, т.е. в случае {elementType} = widget, 
тут будет код виджета начиная с оболочки в которой указано data-element_type="widget" */
//{elementName} - имя виджета elementor.hooks.addAction( 'panel/open_editor/widget/parent_uslugi_icon', test_wid_f);

//$e.routes.refreshContainer('panel'); сохранит настройки и обновит виджет
//model.setSetting('img_or_video_or_map', 'map');
//model.setSetting('zagolovok_h', 'абракадабра');
//elementor.reloadPreview();

(function($) {
    $(window).on('elementor:init', function() {
        //var 
        var control_vibor_shablona_bloka_class = elementor.modules.controls.BaseData.extend({ //BaseMultiple для медиа, BaseData для обычных элементов
            objekt_data: {}, //объект в котором хранятся данные , такие как: настройки по умолчанию, занчение кнопки переключателя и пользовтаельские настройки
            ui: function ui() {
                var ui = elementor.modules.controls.BaseData.prototype.ui.apply(this, arguments);
                ui.wrap_gotovie_bloki = '#wrap_gotovie_bloki'; //перечень элементов к которым будем обращаться
                ui.zagolovok_h1 = '.zagolovok_h1';
                ui.img_sverhu = '.img_sverhu';
                ui.h1_text = '.h1_text';
                ui.img_nad_y_ssilkami = '.img_nad_y_ssilkami';
                ui.h1_text_img = '.h1_text_img';
                ui.h1_text_2_img = '.h1_text_2_img';
                ui.big_img_text = '.big_img_text';
                ui.text_img = '.text_img';
                ui.img_text = '.img_text';
                ui.video_big = '.video_big';
                ui.video_text = '.video_text';
                ui.default_blok_settings = '.default_blok_settings';
                ui.sbrosit = '.sbrosit';
                return ui;
            },
            events: function events() {
                return _.extend(elementor.modules.controls.BaseData.prototype.events.apply(this, arguments), {
                    'click @ui.zagolovok_h1': 'zagolovok_h1', //привязка события в данном случае click к функциям которые расположены ниже
                    'click @ui.img_sverhu': 'img_sverhu',
                    'click @ui.h1_text': 'h1_text',
                    'click @ui.img_nad_y_ssilkami': 'img_nad_y_ssilkami',
                    'click @ui.h1_text_img': 'h1_text_img',
                    'click @ui.h1_text_2_img': 'h1_text_2_img',
                    'click @ui.big_img_text': 'big_img_text',
                    'click @ui.text_img': 'text_img',
                    'click @ui.img_text': 'img_text',
                    'click @ui.video_big': 'video_big',
                    'click @ui.video_text': 'video_text',
                    'click @ui.default_blok_settings': 'default_blok_settings',
                    'click @ui.sbrosit': 'sbrosit',
                });
            },
            nastroyki: function() { //эта функция вызывается каждый раз когда происходит клик по блоку .gotovie_bloki
                this.objekt_data.default_active = this.container.settings.attributes.default_active; //получаем значения переключателя "ОЧЕНЬ ВАЖНО", функция nastroyki выполняется каждый раз при клике по блоку, так что мы будем получать каждый раз обновлённые заначения этого переключателя

                var svitch = this.ui.wrap_gotovie_bloki.closest(".elementor-control-gotovie_bloki").siblings(".elementor-control-default_active").find("label.switch"); //переключатель
                gotovie_bloki = this.ui.wrap_gotovie_bloki.find(".gotovie_bloki"); //список всех блоков

                gotovie_bloki.removeClass("vibran");

                svitch.on("click touchend", function(event) { //при клике по переключателю "ОЧЕНЬ ВАЖНО" убираем у всех блокв класс , чтоб оключить эффект выделения
                    //event.preventDefault();
                    event.stopPropagation();
                    //event.stopImmediatePropagation();
                    gotovie_bloki.removeClass("vibran");
                });
                if (this.objekt_data.default_active == 'yes') { //если переключатель "ОЧЕНЬ ВАЖНО" включён то передаём в objekt_data настройки по умолчанию если нет то настройки пользователя до изменений в этой категории настроек виджена
                    this.objekt_data.nastroyki = this.objekt_data.nastroyki_default;
                } else {
                    this.objekt_data.nastroyki = this.objekt_data.nastroyki_do_izmeneniy;
                }
            },
            zagolovok_h1: function() { //функция которая будет срабатывать при клике по элементу ui.zagolovok_h1
                var elsement = $(this.ui.zagolovok_h1); //сам элемент по кторому кликнули
                if (!elsement.hasClass("vibran")) { //проверям наличие класса
                    this.nastroyki(); //запускаем функцию настроек nastroyki
                    var container = this.container; //определяем контейнер виджета к которому применть settings ниже
                    nastroyki = this.objekt_data.nastroyki; //в зависимости от занчения переключателя "ОЧЕНЬ ВАЖНО" функция nastroyki передаст нам через объект objekt_data значение для настроек (по умолчанию или пользовательские)
                    elsement.addClass("vibran"); //добавляем элементу класс vibran, чтоб к нему применилась визуальная настройка выбранного блока

                    $e.run('document/elements/settings', { //задаём настройки для этого виджета
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-12',
                            'blok_type': '15',
                            'show_zagolovok': 'yes',
                            'h_type': 'h1',
                            'zagolovok_h': '' + nastroyki.zagolovok_h + '',
                            'align_h': 'left',
                            'align_h_tablet': 'center',
                            'align_h_mobile': 'center',
                            'zagolovok_p_b': 'yes',
                            'text': '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            img_sverhu: function() {
                var elsement = $(this.ui.img_sverhu);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': 'yes',
                            'padding_top': 'yes',
                            'padding_right': 'yes',
                            'padding_bottom': 'yes',
                            'shrina': 'col-xl-12',
                            'blok_type': '16',
                            'show_zagolovok': '',
                            'img_or_video_or_map': 'img',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            h1_text: function() {
                var elsement = $(this.ui.h1_text);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-9',
                            'align_block': 'm-auto',
                            'blok_type': '15',
                            'show_zagolovok': 'yes',
                            'h_type': 'h1',
                            'zagolovok_h': '' + nastroyki.zagolovok_h + '',
                            'align_h': 'left',
                            'align_h_tablet': 'center',
                            'align_h_mobile': 'center',
                            'zagolovok_p_b': '',
                            'text': '' + nastroyki.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            img_nad_y_ssilkami: function() {
                var elsement = $(this.ui.img_nad_y_ssilkami);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': 'yes',
                            'shrina': 'col-xl-9',
                            'align_block': 'm-auto',
                            'blok_type': '16',
                            'show_zagolovok': '',
                            'img_or_video_or_map': 'img',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            h1_text_img: function() {
                var elsement = $(this.ui.h1_text_img);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-11',
                            'align_block': 'ml-auto mr-0',
                            'blok_type': '8',
                            'show_zagolovok': 'yes',
                            'h_type': 'h1',
                            'zagolovok_h': '' + nastroyki.zagolovok_h + '',
                            'align_h': 'left',
                            'align_h_tablet': 'center',
                            'align_h_mobile': 'center',
                            'zagolovok_p_b': '',
                            'zagolovok_type': '1',
                            'img_or_video_or_map': 'img',
                            'img_type': '2',
                            'text': '' + nastroyki.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            h1_text_2_img: function() {
                var elsement = $(this.ui.h1_text_2_img);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-11',
                            'align_block': 'ml-auto mr-0',
                            'blok_type': '8',
                            'show_zagolovok': 'yes',
                            'h_type': 'h1',
                            'zagolovok_h': '' + nastroyki.zagolovok_h + '',
                            'align_h': 'left',
                            'align_h_tablet': 'center',
                            'align_h_mobile': 'center',
                            'zagolovok_p_b': '',
                            'zagolovok_type': '1',
                            'img_or_video_or_map': 'img',
                            'img_type': '1',
                            'text': '' + nastroyki.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            big_img_text: function() {
                var elsement = $(this.ui.big_img_text);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-11',
                            'align_block': 'mr-auto ml-0',
                            'blok_type': '5',
                            'show_zagolovok': '',
                            'img_or_video_or_map': 'img',
                            'img_type': '3',
                            'text': '' + nastroyki.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            text_img: function() {
                var elsement = $(this.ui.text_img);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-11',
                            'align_block': 'ml-auto mr-0',
                            'blok_type': '1',
                            'show_zagolovok': '',
                            'img_or_video_or_map': 'img',
                            'img_type': '2',
                            'text': '' + nastroyki.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            img_text: function() {
                var elsement = $(this.ui.img_text);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-11',
                            'align_block': 'mr-auto ml-0',
                            'blok_type': '4',
                            'show_zagolovok': '',
                            'img_or_video_or_map': 'img',
                            'img_type': '2',
                            'text': '' + nastroyki.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            video_big: function() {
                var elsement = $(this.ui.video_big);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-9',
                            'align_block': 'm-auto',
                            'blok_type': '16',
                            'show_zagolovok': '',
                            'img_or_video_or_map': 'video',
                            'video_type': '1',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            video_text: function() {
                var elsement = $(this.ui.video_text);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki = this.objekt_data.nastroyki;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-11',
                            'align_block': 'mr-auto ml-0',
                            'blok_type': '4',
                            'show_zagolovok': '',
                            'img_or_video_or_map': 'video',
                            'video_type': '1',
                            'text': '' + nastroyki.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            default_blok_settings: function() {
                var elsement = $(this.ui.default_blok_settings);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki_default = this.objekt_data.nastroyki_default;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '',
                            'padding_top': '',
                            'padding_right': '',
                            'padding_bottom': '',
                            'shrina': 'col-xl-11',
                            'align_block': 'ml-auto mr-0',
                            'blok_type': '8',
                            'show_zagolovok': 'yes',
                            'h_type': 'h1',
                            'zagolovok_h': '' + nastroyki_default.zagolovok_h + '',
                            'align_h': 'left',
                            'align_h_tablet': 'center',
                            'align_h_mobile': 'center',
                            'zagolovok_p_b': '',
                            'zagolovok_type': '1',
                            'img_or_video_or_map': 'img',
                            'img_type': '1',
                            'add_table': '',
                            'text': '' + nastroyki_default.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            sbrosit: function() {
                var elsement = $(this.ui.sbrosit);
                if (!elsement.hasClass("vibran")) {
                    this.nastroyki();
                    var container = this.container;
                    nastroyki_do_izmeneniy = this.objekt_data.nastroyki_do_izmeneniy;
                    elsement.addClass("vibran");

                    $e.run('document/elements/settings', {
                        container: container,
                        settings: {
                            'padding_left': '' + nastroyki_do_izmeneniy.padding_left + '',
                            'padding_top': '' + nastroyki_do_izmeneniy.padding_top + '',
                            'padding_right': '' + nastroyki_do_izmeneniy.padding_right + '',
                            'padding_bottom': '' + nastroyki_do_izmeneniy.padding_bottom + '',
                            'shrina': '' + nastroyki_do_izmeneniy.shrina + '',
                            'align_block': '' + nastroyki_do_izmeneniy.align_block + '',
                            'blok_type': '' + nastroyki_do_izmeneniy.blok_type + '',
                            'show_zagolovok': '' + nastroyki_do_izmeneniy.show_zagolovok + '',
                            'h_type': '' + nastroyki_do_izmeneniy.h_type + '',
                            'zagolovok_h': '' + nastroyki_do_izmeneniy.zagolovok_h + '',
                            'align_h': '' + nastroyki_do_izmeneniy.align_h + '',
                            'align_h_tablet': '' + nastroyki_do_izmeneniy.align_h_tablet + '',
                            'align_h_mobile': '' + nastroyki_do_izmeneniy.align_h_mobile + '',
                            'zagolovok_p_b': '' + nastroyki_do_izmeneniy.zagolovok_p_b + '',
                            'zagolovok_type': '' + nastroyki_do_izmeneniy.zagolovok_type + '',
                            'img_or_video_or_map': '' + nastroyki_do_izmeneniy.img_or_video_or_map + '',
                            'img_type': '' + nastroyki_do_izmeneniy.img_type + '',
                            'map_type': '' + nastroyki_do_izmeneniy.map_type + '',
                            'video_type': '' + nastroyki_do_izmeneniy.video_type + '',
                            'add_table': '',
                            'text': '' + nastroyki_do_izmeneniy.text + '',
                        },
                        options: {
                            external: true, //если true то обновит и предпросмотр и значение в панели управление слева, если false то только предпросмотр
                        },
                    });
                };
            },
            onReady: function() { //срабатывает сразу после открытия вкладки категирии виджета где этот элемент контроля используется
                this.objekt_data.nastroyki_default = this.container.settings.defaults; //единожды получаем занчения по имлчанию для виджета
                this.objekt_data.nastroyki_do_izmeneniy = Object.assign({}, this.container.settings.attributes); //получаем пользовательские настройки до того как мы что-то поменям в этом блоке и записываем из через пересоздание объекта в объект objekt_data, пересоздавать объект, с помощью Object.assign, нужно потому как если не записать эти настройки в новый объект они перезапишутся как только мы начнём менять значения выбирая блоки
            },
            onBeforeDestroy: function onBeforeDestroy() {
                this.$el.remove(); //хз зачем это) но выполяется после того как мы покидаем контроль , т.е. переключаемся на другой виджет или просто на другую вкладку категорий настроек этого виджета
            }
        });
        elementor.addControlView('control_vibor_shablona_bloka', control_vibor_shablona_bloka_class);

    });
})(jQuery);