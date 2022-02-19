(function($) {
    $(window).on('elementor:init', function() {
        var control_show_block_on_device = elementor.modules.controls.BaseData.extend({ //BaseMultiple для медиа, BaseData для обычных элементов
            ui: function ui() {
                var ui = elementor.modules.controls.BaseData.prototype.ui.apply(this, arguments);
                ui.wrap = '.device_select'; // родитель верхнего уровня upload_media_fill
                ui.custom_switch_wrapper = '.custom_switch_wrapper'; //тег input для записи заначения custom_input_wp_media
                return ui;
            },
            events: function events() {
                return _.extend(elementor.modules.controls.BaseData.prototype.events.apply(this, arguments), {
                    'click @ui.custom_switch_wrapper': 'chenge_devices_to_show'
                });
            },
            chenge_devices_to_show: function chenge_devices_to_show(event) {
                event.preventDefault();//отменяем стандартные функции такие как активация чекбокса
                let custom_switch_wrapper = $(event.currentTarget),//элемент по которому кликнули
                    data_switch_ckliked = custom_switch_wrapper.attr("data-switch"),//атрибут data-switch который сообщит нам какое занчение в настройке он меняет
                    input_ckliked = custom_switch_wrapper.find("input");//инпут по которому кликнули

                all_settings = {};//записываем все настройки

                //перебираем все секции переключателей чтоб записать их текущие данные
                $(this.ui.wrap).find(".custom_switch_wrapper").each(function(){
                    let data_switch = $(this).attr("data-switch"),//к какойму устройству относится текущий переключатель
                        input = $(this).find("input");//инпут настройки
                    let value = input.is(':checked') ? "yes" : "no";//записываем значение в зависимости от того активна настрйока или нет
                    all_settings[data_switch] = value;//записываем данные в объект
                });
                //перебираем все секции переключателей чтоб записать их текущие данные

                let value_ckliked = input_ckliked.is(':checked') ? "no" : "yes";//в зависимости от токо активна кликнутая настройка или нет записываем для неё новое занчеие

                //если мы отключаем настройку нужно проверить чтоб он не была последней активной
                if(value_ckliked === "no"){
                    delete all_settings[data_switch_ckliked];//удаляем из всех настроек ту настройку по которой кликнули

                    let resolution = false;//по умолчанию запрещаем дальнейшие обновление натсроек

                    let keys = Object.keys(all_settings);//получаем свойства (ключи) объекта в виде массива
                    
                    //перебираем все отавшиеся настройки
                    keys.forEach(key => {
                        if(all_settings[key] === "yes"){//если хоть одна настройка активна даём разрешение на изменение кликнутой натсрйоки
                            resolution = true;
                        }
                    });
                    //перебираем все отавшиеся настройки
                    if(!resolution){ return; }//если нет разрешение на дальнейшие изменени натсроек то завершаем функцию
                }
                //если мы отключаем настройку нужно проверить чтоб он не была последней активной

                all_settings[data_switch_ckliked] = value_ckliked;//записываем обновлённое заначение для кликнутой настройки

                this.setValue(all_settings);//передаём для сохранения объект с натсройками
                this.applySavedValue();
            },
            applySavedValue: function() {//функция должна быть имеено applySavedValue послкольку она связана с ctrl+
                all_data = this.getControlValue();//получаем все натсройки
                //перебираем все переключаели данной натсрйоки чтоб задать их инпутам необходимые параметры checked
                $(this.ui.wrap).find(".custom_switch_wrapper").each(function(){
                    let data_switch = $(this).attr("data-switch"),//к какойму устройству относится текущий переключатель
                        input = $(this).find("input"),//инпут настройки
                        value = all_data[data_switch];//активна данная настройка или нет

                        //в зависимости от того активна данная натрстройка или нет включаем и оключаем параметр checked у соответствующих инпутов
                        if(value === "yes"){
                            input.prop('checked', true);
                        } else {
                            input.prop('checked', false);
                        }
                        //в зависимости от того активна данная натрстройка или нет включаем и оключаем параметр checked у соответствующих инпутов
                });
                //перебираем все переключаели данной натсрйоки чтоб задать их инпутам необходимые параметры checked
            },
            onReady: function() {
                this.applySavedValue();
            },
            onBeforeDestroy: function onBeforeDestroy() {
                this.$el.remove();
            }

        });

        elementor.addControlView('control_show_block_on_device', control_show_block_on_device);
        
    });
})(jQuery);