(function($) {
    $(document).ready(function() {

        listener_scroll_button(); //скролл вверх, проверяем покрутку страници и показываем кнопку вверх, а так же прокурчиваем страницу вверх при клеке по кнопке вверх

        //выбор цвета
        let vibor_bg_color_options = {
                // устанавливает цвет по умолчанию, также цвет по умолчанию
                // берется из атрибута value у input. Значение input приоритетнее
                defaultColor: '#06131c',

                // функция обратного вызова, срабатывающая каждый раз 
                // при выборе цвета (когда водите мышкой по палитре)
                change: function(event, ui) { //при каждом изменении цвета вфзываем функцию крестиков и галочек для title_settingи заголовка H2
                    color_input_check($(event.target));
                },

                // функция обратного вызова, срабатывающая при очистке (сбросе) цвета, т.е. поле ввода цвета пустое
                clear: function(event) {
                    color_input_check($(event.target));
                },

                // спрятать ли выбор цвета при загрузке (палитра будет появляться при клике)
                hide: true,

                // показывать ли группу стандартных цветов внизу палитры
                // можно добавить свои цвета указав их в массиве: 
                // ['#125', '#459', '#78b', '#ab0', '#de3', '#f0f']
                palettes: false

            },
            vibor_text_color_options = {
                defaultColor: '#fff',
                change: function(event, ui) { //при каждом изменении цвета вфзываем функцию крестиков и галочек для title_settingи заголовка H2
                    color_input_check($(event.target));
                },
                clear: function() {
                    color_input_check($(event.target));
                },
                hide: true,
                palettes: false
            };

        $('input#bg_color').wpColorPicker(vibor_bg_color_options);
        $('input#text_color').wpColorPicker(vibor_text_color_options);
        //выбор цвета

        let html = $("html"),
            body = $("body"),
            wp_body = $("#wpbody-content"),
            scroll_up = $("#scrollup"),
            main_settings_wraper = $("#main_settings_wraper"),
            all_settings_wrap = $(".settings_wrap"),
            save_button = $("#knopka_sohranit"),
            width_sb = save_button.width(),
            height_sb = save_button.height(),
            title = $(".title_setting");

        save_button.css({ "width": width_sb + "px", "height": height_sb + "px" }); //явно задём высоту и шируну кнопки сохранения


        write_all_inputs_data(); //записываем в буфер все значения поллей ввода чтоб мониторить изменения в них

        //если кеш включён
        if (data_ksn.all_inputs_data["cache_active"] === "yes") {
            //если в буфере есь запись data_ksn.cache_need_to_update["settings_update"] === "yes" то выводим сообщение
            if (data_ksn.cache_need_to_update["settings_update"] === "yes" && data_ksn.cache_last_update !== "") {
                big_top_messege("enabled", "orange", "Некоторые настройки были изменены, чтоб они вступили в силу необходимо пересоздать кеш!", "nead_update_cache", function() {
                    if ($(".big_top_messege.nead_cache_create").length) { return false; } //если есть сообщения о том что нужно создать кеш в первые не показываем это сообщение 
                });
            }
            //если в буфере есь запись data_ksn.cache_need_to_update["settings_update"] === "yes" то выводим сообщение

            //если в буфере есть запись data_ksn.cache_last_update === "" то выводим сообщение
            if (data_ksn.cache_last_update === "") {
                big_top_messege("enabled", "orange", "На этом сайте ещё не был создан кеш!", "nead_update_cache", function() {
                    if ($(".big_top_messege.nead_cache_create").length) { return false; } //если есть сообщения о том что нужно создать кеш в первые не показываем это сообщение 
                });
            }
            //если в буфере есть запись data_ksn.cache_last_update === "" то выводим сообщение
        }
        //если кеш включён

        check_active_title_settings(title); //выставялем галочки или крестики возле названия настройки в момент загрузки страницы основываясь на сохранённых настройках

        h2_check_active(all_settings_wrap); //выставялем галочки или крестики возле заголовка H2 каждой настройки в зависимости от must_have_for_active в момент загрузки страницы основываясь сохранённых настройках

        watch_chenge_all_inputs(); //обрабатываем события изменений в полях ввода, копировани, ввод текста, удаление текст и т.д.

        listener_click_all_switch(); //обрабатываем клик по переключателю switch

        listener_click_all_inputs_and_textarea(); //клик по любому из полей ввода, выведет информационное сообщение когда нужно

        listener_click_all_color_wraper(); //клик по любому из полей ввода цветов, выведет информационное сообщение когда нужно

        //обрабатываем события клика по кнопкам
        //button - нажатая кнопка настроек
        button_click_action = function(button) {
            //кнопка по которой нажали
            button.on("click touchend", function(e) {
                e.preventDefault();

                //если кликнули по кнопке после завершения отправки данных то показать ссобщение что данные уже были обновлены, но только если кнопка не с бесконечным обновлением
                if (button.hasClass("one_save_complit")) {
                    messege("blue", "Данная настройка уже обновлена!"); //выводим сообщение что данная настройка уже обновлена
                    return;
                }
                //если кликнули по кнопке после завершения отправки данных то показать ссобщение что данные уже были обновлены, но только если кнопка не с бесконечным обновлением

                //если кликнули по кнопке в мемент обновления
                if (button.hasClass("disable") || button.hasClass("update_wait")) {
                    messege("blue", "Подождите, настройки обновляются =)"); //выводим сообщение что данная настройка уже обновлена
                    return;
                }
                //если кликнули по кнопке в мемент обновления

                if (button.hasClass("data_input")) {
                    let input = button.siblings("input"),
                        input_val = Number(input.attr("value"));
                    input.attr("value", input_val + 1);

                    standart_update_button(button, true);
                }
            });
            //кнопка по которой нажали
        }
        //обрабатываем события клика по кнопкам

        button_click_action($("#update_css_js_versions"));


        //запрос к серверу для обновленния данных в бд
        //options - данные для отправик на сервер
        //current_inputs - поля ввода данные из которых были отправлены
        //time_to_out - таймаут для ответа, т.е. максимальное количество миллисикунд данное на ответ, иначер вызовется ontimeout
        request_update_to_server = function(options, current_inputs = null, time_to_out = null) {
            //включаем все необходимые элементы
            enabled_all_elements = function() {
                let main_settings_wraper = $("#main_settings_wraper"),
                    all_inputs_and_textarea = main_settings_wraper.find("input").add(main_settings_wraper.find("textarea")),
                    hidden_inputs_buttons = main_settings_wraper.find("input[type='hidden']").siblings(".update_hidden");

                hidden_inputs_buttons.removeClass("disable");//включаем все кнопки настроек
                inputs_disable_chenge(all_inputs_and_textarea, "enabled"); //включаем все кнопки
                save_button_action("enabled"); //включаем кнопку сохранения настроек
            }
            //включаем все необходимые элементы

            const wait_request = request_to_server(options, time_to_out); //делаем запрос на сервер

            //выполняем действия в зависимости от ответа сервера
            return wait_request.then((request) => { //успех
                let response = JSON.parse(request.response);

                //если сервер ответил что сейчас идёт кеширование
                if (response["process_caching_now"]) {
                    if (response["process_caching_now"] === "user") {
                        messege("orange", "Дождитесь завершения кеширования!"); //выводим сообщение об успешном сохранении настроек
                    } else if (response["process_caching_now"] === "planned") {
                        messege("orange", "Сейчас выполняется плановое кеширование, пожалуйста дождитесь его завершения =)", 7); //выводим сообщение об успешном сохранении настроек

                        //запускаем только в случае если ещё не отслеживается прогресс кеширования
                        if (!data_ksn.cache["amount"]) {
                            data_ksn.cache = { "progress": "0" };
                            buttons_on_off($("#button_request_cache_to_server"), "load"); //оключаем кнопку старта кеширования
                            let options_prepare = { //параметры для запуска подготовки кеширования
                                action: "do_cache", //php актион
                                data: {
                                    "action": "prepare" //сообщаем серверу что нужно начать подготовку к кешированию
                                }
                            };
                            prepare_request_to_server(options_prepare, caching_prepare_complited); //когда функция вернёт ответ мы будем точно уверенны что все данные в редис записаны и можно вызывать функцию caching_prepare_complited
                        }
                        //запускаем только в случае если ещё не отслеживается прогресс кеширования
                    }

                    enabled_all_elements(); //включаем все кнопки
                    return "fail";
                }
                //если сервер ответил что сейчас идёт кеширование

                // если всё прошло гладко т.е. код ответа 200, выводим результат
                messege("green", "Настройки успешно обновлены!"); //выводим сообщение об успешном сохранении настроек

                //если есть переданные инпуты
                if (current_inputs) {
                    current_inputs.removeClass("chenge"); //удаляем у всех инпутов класс chenge чтоб при повторном изменении он корректно добавился и настройка успешно сохранилась
                    write_all_inputs_data(); //записываем в буфер новые значение полей ввода
                }
                //если есть переданные инпуты

                //что сервер ответил, кеш нуждается в обновлении или нет
                if (response["cache_need_to_update"]["settings_update"] === "yes" && data_ksn.all_inputs_data["cache_active"] === "yes") {
                    big_top_messege("enabled", "orange", "Некоторые настройки были изменены, чтоб они вступили в силу необходимо пересоздать кеш!", "nead_update_cache", function() {
                        if ($(".big_top_messege.nead_cache_create").length) { return false; } //если есть сообщения о том что нужно создать кеш в первые не показываем это сообщение 
                    });
                } else if (response["cache_need_to_update"]["settings_update"] === "no" || data_ksn.all_inputs_data["cache_active"] === "no") {
                    big_top_messege("disabled", "", "", "nead_update_cache");
                }
                //что сервер ответил, кеш нуждается в обновлении или нет

                //если висит сообщение о том что нужно создать кеш и мы получили что кеш отключёт то скрываем это сообщение
                if ($(".big_top_messege.nead_cache_create").length && data_ksn.all_inputs_data["cache_active"] === "no") {
                    big_top_messege("disabled", "", "", "nead_cache_create");
                }
                //если висит сообщение о том что нужно создать кеш и мы получили что кеш отключёт то скрываем это сообщение

                //если в буфере есть запись data_ksn.cache_last_update === "" и кеш включён то выводим сообщение
                if (data_ksn.cache_last_update === "" && data_ksn.all_inputs_data["cache_active"] === "yes") {
                    big_top_messege("enabled", "orange", "На этом сайте ещё не был создан кеш!", "nead_cache_create");
                }
                //если в буфере есть запись data_ksn.cache_last_update === "" и кеш включён то выводим сообщение

                enabled_all_elements(); //включаем все кнопки
                return "complite";
                // если всё прошло гладко т.е. код ответа 200, выводим результат
            }).catch((request) => { //ошибка выполнения
                //если ответ "timeout" то выводим сообщение с ошибкой таймаута
                if (request == "timeout") {
                    messege("red", "Превышено время ожидания на выполнение запроса к серверу =( Попробуйте обновить ещё раз!", 5); //выводим сообщение с ошибкой таймаута
                }
                //если ответ "timeout" то выводим сообщение с ошибкой таймаута

                //получили ответ в виде request объекта
                else {
                    messege("red", "Ошибка обновления =( Код ошибки " + request.status + "", 5); //выводим сообщение об ошибке с кодом ошибки request.status
                }
                //получили ответ в виде request объекта
                enabled_all_elements(); //включаем все кнопки
                return "fail";
            });
            //выполняем действия в зависимости от ответа сервера
        };
        //запрос к серверу для обновленния данных в бд

        //функция для отправки данных на сервер через ajax
        //data_to_send - поля ввода, данные из которых нужно отправить на сервер
        send_to_server = function(data_to_send) {
            let main_settings_wraper = $("#main_settings_wraper"),
                all_inputs_and_textarea = main_settings_wraper.find("input").add(main_settings_wraper.find("textarea")),
                hidden_inputs_buttons = main_settings_wraper.find("input[type='hidden']").siblings(".update_hidden");

            //опиции для запроса на сервер
            let options = {
                action: 'save_new_settings', //php актион
                data: {}, //данные для обработки на сервере
                func: {} //дополнительные функции при сохранении настройки на сервере
            }
            //опиции для запроса на сервер

            let settings = {}; //объект с настройками для сохранения в бд

            //перебираем все инпуты с изменениями для того чтоб записать их данные в объект для обновления настроек в бд
            data_to_send.each(function() {
                let input = $(this),
                    setting_name = input.attr("id"),
                    type = input.attr("type");

                if (type == "checkbox") {
                    var value = input.prop("checked") == true ? "yes" : "no",
                        grup = input.attr("data-grup"),
                        dop_func = input.attr("data-dop-func");
                }

                if (type == "text" || type == "hidden") {
                    var value = input.prop("value"),
                        grup = input.attr("data-grup"),
                        dop_func = input.attr("data-dop-func");
                }

                if (type == "number") {
                    var value = input.prop("value"),
                        grup = input.attr("data-grup"),
                        min = input.attr("min"),
                        max = input.attr("max"),
                        dop_func = input.attr("data-dop-func");

                    if (Number(value) > Number(max) && max) {
                        value = max;
                    }

                    if (Number(value) < Number(min) && min) {
                        value = min;
                    }
                }

                if (!settings[grup]) {
                    settings[grup] = {};
                }

                settings[grup][setting_name] = value;

                if (dop_func) {
                    options['func'][setting_name] = dop_func;
                }

            });
            //перебираем все инпуты с изменениями для того чтоб записать их данные в объект для обновления настроек в бд

            //если объект settings пуст, то выводим сообщение что пользователь ничего не менял и завершаем выполнение функции
            if ($.isEmptyObject(settings)) {
                messege("blue", "Вы ничего не изменили!");
                return;
            }
            //если объект settings пуст, то выводим сообщение что пользователь ничего не менял и завершаем выполнение функции

            options["data"] = settings;

            hidden_inputs_buttons.addClass("disable");
            inputs_disable_chenge(all_inputs_and_textarea, "disable"); //отключаем поля ввода, что ничего не нажали пока не обновили данные на сервере
            save_button_action("disable"); //отключаем кнопку сохранения настроек

            //ajax запрос на сервер
            return request_update_to_server(options, data_to_send, 15000);
            //ajax запрос на сервер
        }
        //функция для отправки данных на сервер через ajax

        //функция управлет состоянием кнопок для обновления отдельных настроек
        //button - нажатая кнопка
        //one_save_complit - указывает на то является ли кнопка одноразовой
        function standart_update_button(button, one_save_complit = true, $ = jQuery) {
            button.addClass("update_wait"); //помечаем что кнопка в прецессе обновления
            button.html("<div class='await'></div>"); //ставим лоадер на кнопку

            let input = button.siblings("input"), //поле ввода настройки
                result = send_to_server(input); //что ответил нам сервер (промис)

            //ответный промис
            result.then((state) => {
                //если ошибка или дуругое припятствие сохранению настройки
                if (state == "fail") {
                    button.removeClass("update_wait");
                    button.html("<span>Обновить</span>");
                }
                //если ошибка или дуругое припятствие сохранению настройки

                //если всё успешно сохранилось
                if (state == "complite") {
                    //если настройка одноразовая
                    if (one_save_complit) {
                        button.removeClass("update_wait");
                        button.addClass("one_save_complit");
                        button.html("<span>Обновлено</span>");
                    }
                    //если настройка одноразовая

                    //если настройка может обновлятся многократно
                    else {
                        button.removeClass("update_wait");
                        button.html("<span>Обновить</span>");
                    }
                    //если настройка может обновлятся многократно
                }
                //если всё успешно сохранилось
            });
            //ответный промис
        }
        //функция управлет состоянием кнопок для обновления отдельных настроек

        //клик по кнопке сохранения настроек
        $("#knopka_sohranit").on("click", function(e) {
            e.preventDefault();
            let wp_body = $("#wpbody-content");

            //если кликнули по кнопке в мемент обновления выводим сообщения что нужно подождать
            if (save_button.hasClass("wait_batton")) {
                messege("orange", "Подождите, настройки обновляются =)");
                return; //завершаем функцию
            }
            //если кликнули по кнопке в мемент обновления выводим сообщения что нужно подождать

            let all_errors = convert_objects_and_arreys(data_ksn.errors, "object"), //проверяем наличие ошибок в настрйоках перед сохранением
                all_load_task = convert_objects_and_arreys(data_ksn.wait_before_save_settings, "object"); //проверяем на наличие незавершённых задач

            //если есть ошибки то выводим сообщение какая именно ошибка
            if (Object.keys(all_errors).length) {
                let error = GetFirstProperty(all_errors); //получаем сообщение из первой ошибки в массиве all_errors
                messege("red", error, false); //выводим безсрочное сообщение об ошибке
                return; //завершаем функцию
            }
            //если есть ошибки то выводим сообщение какая именно ошибка

            //если есть незавершённые задачи
            if (Object.keys(all_load_task).length) {
                let load_task = GetFirstProperty(all_load_task); //получаем первое из списка незавершённых задание 
                messege("orange", load_task); //выводим сообщение что есть незавершённое задание
                return; //завершаем функцию
            }
            //если есть незавершённые задачи

            let all_change_input = wp_body.find("input.chenge"), //все инпуты в которых были изменения
                all_change_textarea = wp_body.find("textarea.chenge"), //все текстовые поля в которых были изменения
                vse_polya = all_change_input.add(all_change_textarea); //инпуты и текстовые поля вместе

            send_to_server(vse_polya);
        });
        //клик по кнопке сохранения настроек



        let show_wp_naw = $("#show_wp_naw"),
            wpcontent = $("#wpcontent"),
            adminmenumain = $("#adminmenumain"),
            wpadminbar = $("#wpadminbar"),
            wpbody_content = $("#wpbody-content");

        show_wp_naw.on("click tochend", function(e) {
            e.preventDefault();
            //$("#adminmenumain").slideToggle();
            show_wp_naw.toggleClass("open_naw");
            wpcontent.toggleClass("open_naw");
            adminmenumain.toggleClass("open_naw");
            wpadminbar.toggleClass("open_naw");
            save_button.toggleClass("open_naw");
            wpbody_content.toggleClass("open_naw");
        });




        let pop_up_open = $(".pop_up_open"),
            pop_up = $(".pop_up"),
            pop_up_window = $(".pop_up_window"),
            pop_up_content = $(".pop_up_content"),
            pop_up_close = $(".pop_up_close"),
            pop_up_overlay = $(".pop_up_overlay");

        //показываем поп-ап окно
        open_popup = function(content, type) {
            save_button.fadeOut(500);
            scroll_up.fadeOut(500);
            show_wp_naw.fadeOut(500);
            pop_up.fadeIn(500);
            $(".info_messege").addClass("disable");

            //задержка для того чтоб ничего не дёргалось
            setTimeout(() => {
                html.addClass("pop_up_active");
                pop_up_overlay.fadeIn(500);

                //показываем кнопку закрытия только после полного скрытия всех мешающих элементов
                setTimeout(() => {
                    pop_up_window.fadeIn(500);
                    pop_up_close.fadeIn(500);
                }, 500);
                //показываем кнопку закрытия только после полного скрытия всех мешающих элементов
            }, 500);
            //задержка для того чтоб ничего не дёргалось

            let win_w = $(window).width(),
                win_h = $(window).height();

            if (type == "img") {
                pop_up_content.html("<img src='" + content + "'>");
                let img = pop_up_content.find("img"),
                    pop_up_w = win_w * 0.8,
                    pop_up_h = win_h * 0.8;

                //после загрузки картинки мы можем выполнять вне нужные действия
                img[0].onload = () => {
                    let n_w = img[0].naturalWidth,
                        n_h = img[0].naturalHeight;

                    if (n_w >= pop_up_w) {
                        img.css("width", "100%");
                    } else if (n_h >= pop_up_h) {
                        img.css("height", "100%");
                    }
                };
                //после загрузки картинки мы можем выполнять вне нужные действия
            }
        };
        //показываем поп-ап окно

        //скрываем поп-ап окно
        close_popup = function() {
            //промис, ждём пока не покажется скролбар
            const wait_html_scrollbar = new Promise((resolve) => {
                setTimeout(() => {
                    html.removeClass("pop_up_active");
                    resolve();
                }, 1000);
            });
            //промис, ждём пока не покажется скролбар
            pop_up_window.fadeOut(500);

            //скрываем поп-ап окно через 500 мс после того как скорется контент в окне
            setTimeout(() => {
                pop_up.fadeOut(500);
                pop_up_overlay.fadeOut(500);
                pop_up_close.fadeOut(500);
            }, 500);
            //скрываем поп-ап окно через 500 мс после того как скорется контент в окне

            //ждём выполнение промиса
            wait_html_scrollbar.then(() => {
                save_button.fadeIn(500);
                scroll_up.fadeIn(500);

                //в конце плавно показываем кнопку нтрыти меню
                setTimeout(() => {
                    show_wp_naw.fadeIn(500);
                }, 500);
                //в конце плавно показываем кнопку нтрыти меню
            });
            //ждём выполнение промиса
        };
        //скрываем поп-ап окно

        pop_up_open.on("click tochend", function(e) {
            e.preventDefault();
            let pop_up_open = $(this),
                type = pop_up_open.attr("data-type"),
                content = pop_up_open.attr("data-content");
            open_popup(content, type);
        });

        pop_up_overlay.on("click tochend", function(e) {
            e.preventDefault();
            close_popup();
        });

        pop_up_close.on("click tochend", function(e) {
            e.preventDefault();
            close_popup();
        });






        //Меню
        let menu = $("#menu"), // меню
            menu_item = menu.find(".menu_item"), //блок элемента меню
            menu_item_title = menu.find(".menu_item_title"), //заголовок элемента меню
            menu_item_child = menu.find(".menu_item_child"), //пункты элемента меню
            main_settings_wraper_item = $("#main_settings_wraper>div"), //все блоки с настройками на странице
            cookie_data_active_block = getCookie("ksn_data[current_settings_block_in_ksn_plugin]"); //куки с данными блока настроек который был у пользователя открыт в последний раз
            
        //если такая запись в куки существует
        if (cookie_data_active_block) {
            let blok_for_active = main_settings_wraper.find("div#" + cookie_data_active_block + ""), //находим блок настроек который нужно отобразить
                menu_item_child_for_active = menu_item_child.filter("[data-target='" + cookie_data_active_block + "']"); //пункт меню который нужно сделать активным
            menu_item_child_for_active.addClass("active"); //помечаем блок настроек как active
            blok_for_active.addClass("active"); //помечаем пункт в меню как active
            fade_item(blok_for_active, "show", 500); //показываем блок настроек
        }
        //если такая запись в куки существует

        //если этого куки не существует, отображеам первый блок настроек и активируем первый пункт меню
        else {
            let data_target_id = main_settings_wraper_item.first().attr("id"); //получаем id первого блока настроек
            main_settings_wraper_item.first().addClass("active"); //помечаем блок настроек как active
            fade_item(main_settings_wraper_item.first(), "show", 500); //показываем первый блок настроек
            menu_item_child.filter("[data-target='" + data_target_id + "']").addClass("active"); //активируем первый элемент в меню
        }
        //если этого куки не существует, отображеам первый блок настроек и активируем первый пункт меню

        //обрабатываем клик по элементу в меню
        menu_item_child.on("click touchend", function(e) {
            e.preventDefault();
            if ($(this).hasClass("active")) { return; } //если данный пункт меню уже активен то прерываем выполнение функции

            fade_item(main_settings_wraper_item.filter(".active"), "hide", 500, function() {
                data_ksn.menu_item_show_timer_id ? clearInterval(data_ksn.menu_item_show_timer_id) : null;
            }); //находим активный блок настроек и скрываем его
            main_settings_wraper_item.removeClass("active"); //убираем пометку active с активного блока настроек

            let item = $(this), //пункт меню на который нажали
                data_target = item.attr("data-target"), //данные атрибута data-target нажатого пункта меню
                tardet_div = main_settings_wraper.find("#" + data_target + ""); //находим блок настроек с id соответствующим data-target нажатого пункта меню

            menu_item_child.removeClass("active"); //деактивируем все пункты меню
            item.addClass("active"); //активируем нажатый пункт меню

            tardet_div.find("label.switch").removeClass("animate"); //убираем чтоб анимация не включалась при каждом переключенни вкладки

            //через 500 мс, когда скроется прежний блок настроек, отображаем новй блок с настройками
            data_ksn.menu_item_show_timer_id = setTimeout(() => {
                fade_item(tardet_div, "show", 500); //показываем новый блок с настройками
                tardet_div.addClass("active"); //помечаем новый блок настроек как active
                clearInterval(data_ksn.menu_item_show_timer_id); //чистим таймер
                delete data_ksn.menu_item_show_timer_id; //удаляем таймер из буфера
            }, 500);

            //через 500 мс, когда скроется прежний блок настроек, отображаем новй блок с настройками

            setCookie("ksn_data[current_settings_block_in_ksn_plugin]", data_target, { 'max-age': 604800, 'path': '/wp-admin/admin.php' }, false); //записываем в куки новое значение для последнего запрошенного блока настроек, для текущего пользователя, оно будут сохранено неделю и доступно только для страниц /wp-admin/admin.php
        });
        //обрабатываем клик по элементу в меню

        //переходим на нужную вкладку по id блока
        function select_menu_page(page_block){
            let block = main_settings_wraper.find("#"+page_block+"");
            if (block.hasClass("active")) { return; } //если данный пункт меню уже активен то прерываем выполнение функции
            fade_item(main_settings_wraper_item.filter(".active"), "hide", 500, function() {
                data_ksn.menu_item_show_timer_id ? clearInterval(data_ksn.menu_item_show_timer_id) : null;
            }); //находим активный блок настроек и скрываем его
            main_settings_wraper_item.removeClass("active"); //убираем пометку active с активного блока настроек

            let item_menu = menu.find("div[data-target='"+page_block+"']"); //пункт меню на который нам нужен

            menu_item_child.removeClass("active"); //деактивируем все пункты меню
            item_menu.addClass("active"); //активируем нажатый пункт меню
            block.find("label.switch").removeClass("animate"); //убираем чтоб анимация не включалась при каждом переключенни вкладки

            //через 500 мс, когда скроется прежний блок настроек, отображаем новй блок с настройками
            data_ksn.menu_item_show_timer_id = setTimeout(() => {
                fade_item(block, "show", 500); //показываем новый блок с настройками
                block.addClass("active"); //помечаем новый блок настроек как active
                clearInterval(data_ksn.menu_item_show_timer_id); //чистим таймер
                delete data_ksn.menu_item_show_timer_id; //удаляем таймер из буфера
            }, 500);

            //через 500 мс, когда скроется прежний блок настроек, отображаем новй блок с настройками

            setCookie("ksn_data[current_settings_block_in_ksn_plugin]", page_block, { 'max-age': 604800, 'path': '/wp-admin/admin.php' }, false); //записываем в куки новое значение для последнего запрошенного блока настроек, для текущего пользователя, оно будут сохранено неделю и доступно только для страниц /wp-admin/admin.php
        }
        //переходим на нужную вкладку по id блока

        //при нажатии на большие сообщения сверху переходим на вкладку кеша
        // $(".big_top_messege.nead_update_cache") заменяем на код ниже чтоб работало с динамически создаваемыми элементами, т.е. привязываем к $("#page_wrap") и в момент клика проверяем его дочерние элементы ".big_top_messege.nead_update_cache"
        $("#page_wrap").on("click touchend", ".big_top_messege.nead_update_cache", function(e) {
            e.preventDefault();
            select_menu_page("nastroyki_cecha");
        });

        $("#page_wrap").on("click touchend", ".big_top_messege.nead_cache_create", function(e) {
            e.preventDefault();
            select_menu_page("nastroyki_cecha");
        });
        //при нажатии на большие сообщения сверху переходим на вкладку кеша

        //Меню


    });
})(jQuery);