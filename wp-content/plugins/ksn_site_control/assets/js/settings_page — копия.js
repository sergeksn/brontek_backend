(function($) {
    $(document).ready(function() {

        const Base = new Base_Funcsionality_In_Plugin();

        Base.listener_scroll_button(); //скролл вверх, проверяем покрутку страници и показываем кнопку вверх, а так же прокурчиваем страницу вверх при клеке по кнопке вверх

        //выбор цвета
        let vibor_bg_color_options = {
                // устанавливает цвет по умолчанию, также цвет по умолчанию
                // берется из атрибута value у input. Значение input приоритетнее
                defaultColor: '#06131c',

                // функция обратного вызова, срабатывающая каждый раз 
                // при выборе цвета (когда водите мышкой по палитре)
                change: function(event, ui) { //при каждом изменении цвета вфзываем функцию крестиков и галочек для title_settingи заголовка H2
                    Base.color_input_check($(event.target));
                },

                // функция обратного вызова, срабатывающая при очистке (сбросе) цвета, т.е. поле ввода цвета пустое
                clear: function(event) {
                    Base.color_input_check($(event.target));
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
                    Base.color_input_check($(event.target));
                },
                clear: function() {
                    Base.color_input_check($(event.target));
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

        //если в буфере есь запись data_ksn.cache_need_to_update === "yes" то выводим сообщение
        if (data_ksn.cache_need_to_update === "yes") {
            Base.messege(["big_top_messege", "enabled"], "orange", "Некоторые настройки были изменены, чтоб они вступили в силу необходимо пересоздать кеш!");
        }
        //если в буфере есь запись data_ksn.cache_need_to_update === "yes" то выводим сообщение

        save_button.css({ "width": width_sb + "px", "height": height_sb + "px" }); //явно задём высоту и шируну кнопки сохранения

        Base.write_all_inputs_data(); //записываем в буфер все значения поллей ввода чтоб мониторить изменения в них

        Base.check_active_title_settings(title); //выставялем галочки или крестики возле названия настройки в момент загрузки страницы основываясь на сохранённых настройках

        Base.h2_check_active(all_settings_wrap); //выставялем галочки или крестики возле заголовка H2 каждой настройки в зависимости от must_have_for_active в момент загрузки страницы основываясь сохранённых настройках

        Base.watch_chenge_all_inputs(); //обрабатываем события изменений в полях ввода, копировани, ввод текста, удаление текст и т.д.

        Base.listener_click_all_switch(); //обрабатываем клик по переключателю switch

        Base.listener_click_all_inputs_and_textarea(); //клик по любому из полей ввода, выведет информационное сообщение когда нужно

        Base.listener_click_all_color_wraper(); //клик по любому из полей ввода цветов, выведет информационное сообщение когда нужно

        Base.listener_click_on_save_button(); //клик по кнопке сохранения настроек

        //анимация чисел и полосы в прогресс баре
        //current_procent - текущий посчитаный процент
        //text_block - блок в котором меняем текст прогресса
        //abort - завершает все таймеры и функцию
        progres_bar = function(current_procent, text_block, abort = false) {
            let line_progress = text_block.siblings(".line_progress");

            //если содержимое text_block в числовом выражении рано 0, то прогрес выполняется сначала
            if (Number(text_block.html().replace("%", "")) === 0) {
                var text_progress = 0;
            }
            //если содержимое text_block в числовом выражении рано 0, то прогрес выполняется сначала

            //если не равно нулю то это как минимум второй вызов этого скрипта
            else {
                var text_progress = data_ksn.progres_in_bar; //получаем занчение предыдущего процента из буфера
                clearInterval(data_ksn.timerId); //сбрасываем предыдущий таймер и отключаем его калбек функцию соответственно
            }
            //если не равно нулю то это как минимум второй вызов этого скрипта

            data_ksn.progres_in_bar = current_procent; //записываем в буфер значение текущего процента

            text_block.html(text_progress + "%"); //задаём текст прогрес бара новым актуальным занчением, вставляем занчение прошлого процента прогреса если оно есть, чтоб продолжить анимировать с более актуального значения и поспевать за плосой прогрес бара

            line_progress.css("width", text_progress + "%"); //длинна линиии прогресса в зависимости от количества кешированных файлов

            //сбрасываем таймер и завершаем функцию
            if (abort) {
                clearInterval(data_ksn.timerId); //сбрасываем таймер и отключаем его калбек функцию соответственно
                return;
            }
            //сбрасываем таймер и завершаем функцию

            //таймер отвечающий за анимацию текста прогресс бара
            data_ksn.timerId = setInterval(() => {
                if (text_progress == current_procent) {
                    text_block.html(current_procent + "%");
                    line_progress.css("width", current_procent + "%"); //длинна линиии прогресса в зависимости от количества кешированных файлов
                    clearInterval(data_ksn.timerId);
                } else {
                    text_block.html(text_progress + "%");
                    line_progress.css("width", text_progress + "%"); //длинна линиии прогресса в зависимости от количества кешированных файлов
                    text_progress++;
                }
            }, 100);
            //таймер отвечающий за анимацию текста прогресс бара
        }
        //анимация чисел и полосы в прогрес баре

        //все необходимые действия с кнопками прогресс баром при изменении статуса кеширования
        //button - нажатая кнопка из раздела кеширвоания
        //event - событие которое вызвано после нажатия на данную button
        caching_events = function(button, event) {
            let progres_cache = button.siblings(".progres_cache"), //прогрес бар
                line_progress = progres_cache.find(".line_progress"), //полоска прогрес бара
                text_progress = progres_cache.find(".text_progress"), //текст прогрес бара
                button_start_caching = progres_cache.siblings(".button_request_cache_to_server"), //кнопка начать кеширование для текущей операции
                button_paused_caching = progres_cache.siblings(".button_request_paused_caching"), //кнопка паузы для текущей операции
                button_abort_caching = progres_cache.siblings(".button_request_abort_caching"), //кнопка прерывания для текущей операции
                log_area = button.siblings(".caching_log").find(".log_area"), //блок с логом кеширования
                log_text = log_area.html(); //текущее содержимое блока лога

            //все необходимые действия с кнопками прогресс баром для начала кеширования
            if (event === "caching_started") {
                text_progress.html("0%");
                line_progress.css("width", "0%");
                log_area.html(""); //чистиб блок лога от предидущих записей
                progres_bar(0, text_progress, true); //завершаем анимацию чисел в прогрес баре
                button_abort_caching.fadeIn(500);
                button_paused_caching.fadeIn(500);
            }
            //все необходимые действия с кнопками прогресс баром для начала кеширования

            //все необходимые действия с кнопками прогресс баром после успешного завешения кеширования
            if (event === "caching_success_complite") {
                progres_bar(100, text_progress, true); //завершаем анимацию чисел в прогрес баре
                text_progress.html("100%");
                line_progress.css("width", "100%");
                button_abort_caching.fadeOut(500);
                button_paused_caching.fadeOut(500);
                log_area.html(log_text + "<span class='green log_messege'>Кеширование успешно завершено =)</span><br>"); //вставляем новое содержимое в блок лога
                log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
                log_area.html(log_area.html() + "<span class='yellow log_messege'>Redis очищен!</span><br>"); //вставляем новое содержимое в блок лога
                log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
                Base.messege("info_messege", "green", "Кеширование было успешно завершено!");

                //убедившись что кнопки точно скрыты и не будет ни каких лишних вызовов можно их разблокировать
                setTimeout(() => {
                    Base.buttons_on_off(button_start_caching, "enabled", "Начать"); //разблокируем кнопку
                    Base.buttons_on_off(button_paused_caching, "enabled", "Пауза"); //меняем состояние кнопки паузы на "ПАУЗА"
                    Base.buttons_on_off(button_abort_caching, "enabled", "Прервать"); //меняем состояние кнопки Прервать на "Прервать"
                }, 550);
                //убедившись что кнопки точно скрыты и не будет ни каких лишних вызовов можно их разблокировать
            }
            //все необходимые действия с кнопками прогресс баром после успешного завешения кеширования

            //все необходимые действия с кнопками прогресс баром после прерывания кеширования
            if (event === "caching_abort_complite") {
                text_progress.html("0%");
                line_progress.css("width", "0%");
                progres_bar(0, text_progress, true); //завершаем анимацию чисел в прогрес баре
                button_abort_caching.fadeOut(500);
                button_paused_caching.fadeOut(500);
                log_area.html(log_text + "<span class='red log_messege'>Кеширование было принудительно прервано!</span><br>"); //вставляем новое содержимое в блок лога
                log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
                log_area.html(log_area.html() + "<span class='yellow log_messege'>Redis очищен!</span><br>"); //вставляем новое содержимое в блок лога
                log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
                Base.messege("info_messege", "red", "Кеширование прервано!");

                //убедившись что кнопки точно скрыты и не будет ни каких лишних вызовов можно их разблокировать
                setTimeout(() => {
                    Base.buttons_on_off(button_start_caching, "enabled", "Начать"); //разблокируем кнопку
                    Base.buttons_on_off(button_paused_caching, "enabled", "Пауза"); //меняем состояние кнопки паузы на "ПАУЗА"
                    Base.buttons_on_off(button_abort_caching, "enabled", "Прервать"); //меняем состояние кнопки Прервать на "Прервать"
                }, 550);
                //убедившись что кнопки точно скрыты и не будет ни каких лишних вызовов можно их разблокировать
            }
            //все необходимые действия с кнопками прогресс баром после прерывания кеширования

            //все необходимые действия с кнопками прогресс баром после включения паузы
            if (event === "caching_paused_enable") {
                let total = Number(data_ksn.cache["amount"]), //общее количество файлов для кеширования
                    progress = Number(data_ksn.cache["progress"]), //текущее количество уже кешированных файлов
                    progress_procent = Math.ceil((progress * 100) / total); //процент уже кешированных файлов

                log_area.html(log_text + "<span class='yellow log_messege'>Кеширование было приостановлено!</span><br>"); //вставляем новое содержимое в блок лога
                log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события

                progres_bar(progress_procent, text_progress); //анимация чисел в прогрес баре
                button_paused_caching.addClass("paused_active"); //класс чтоб отслеживать в каком состоянии кнопка
                Base.buttons_on_off(button_paused_caching, "enabled", "Продолжить"); //меняем состояние кнопки паузы на "ПРОДОЛЖИТЬ"
                Base.buttons_on_off(button_abort_caching, "enabled", "Прервать"); //меняем состояние кнопки Прервать на "Прервать"
                Base.messege("info_messege", "blue", "Пауза кеширования!");
            }
            //все необходимые действия с кнопками прогресс баром после включения паузы

            //все необходимые действия с кнопками прогресс баром после отключаения паузы
            if (event === "caching_paused_disabled") {
                log_area.html(log_text + "<span class='yellow log_messege'>Кеширование было продолжено!</span><br>"); //вставляем новое содержимое в блок лога
                log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
                button_paused_caching.removeClass("paused_active"); //класс чтоб отслеживать в каком состоянии кнопка
                Base.buttons_on_off(button_paused_caching, "enabled", "Пауза"); //меняем состояние кнопки паузы на "ПАУЗА"
                Base.buttons_on_off(button_abort_caching, "enabled", "Прервать"); //меняем состояние кнопки Прервать на "Прервать"
                Base.messege("info_messege", "blue", "Кеширование продолжено");
            }
            //все необходимые действия с кнопками прогресс баром после отключаения паузы
        }
        //все необходимые действия с кнопками прогресс баром при изменении статуса кеширования

        //обрабатываем события клика по кнопкам
        //button - нажатая кнопка настроек
        button_click_action = function(button) {

            //кнопка по которой нажали
            button.on("click touchend", function(e) {
                e.preventDefault();

                //если кликнули по кнопке после завершения отправки данных то показать ссобщение что данные уже были обновлены, но только если кнопка не с бесконечным обновлением
                if (button.hasClass("one_save_complit")) {
                    Base.messege("info_messege", "blue", "Данная настройка уже обновлена!"); //выводим сообщение что данная настройка уже обновлена
                    return;
                }
                //если кликнули по кнопке после завершения отправки данных то показать ссобщение что данные уже были обновлены, но только если кнопка не с бесконечным обновлением

                if (button.hasClass("data_input")) {
                    //если кликнули по кнопке в мемент обновления
                    if (button.hasClass("v_processe")) {
                        Base.messege("info_messege", "blue", "Подождите, настройки обновляются =)"); //выводим сообщения что нужно подождать
                        return;
                    }
                    //если кликнули по кнопке в мемент обновления

                    Base.buttons_on_off(button, "disable", "", true); //оключаем кнопку

                    let h_input = button.siblings('input[type="hidden"]'),
                        h_input_val = Number(h_input.attr("value"));

                    h_input.attr("value", h_input_val + 1);
                    Base.send_to_server(h_input);
                    return;
                }

                //клик по кнопке начала кеширования
                if (button.hasClass("button_request_cache_to_server")) {
                    data_ksn.cache = { "progress": "0" }; //объект в буфере для харанения всех необходимыъ данных, записываем сразу стартовы прогресс 0
                    //если кликнули по кнопке в мемент обновления
                    if (button.hasClass("v_processe")) {
                        Base.messege("info_messege", "blue", "Файлы уже кешируются =)"); //выводим сообщения что файлы уже кешируются
                        return;
                    }
                    //если кликнули по кнопке в мемент обновления

                    Base.buttons_on_off(button, "loaded"); //оключаем кнопку начала кеширования

                    let options_prepare = { //параметры для запуска подготовки кеширования
                        action: "do_cache", //php актион
                        data: {
                            "action": "prepare" //сообщаем серверу что нужно начать подготовку к кешированию
                        }
                    };

                    prepare_request_to_server(options_prepare, button, caching_prepare_complited); //когда функция вернёт ответ мы будем точно уверенны что все данные в редис записаны и можно вызывать функцию caching_prepare_complited
                }
                //клик по кнопке начала кеширования

                //клик по кнопке паузы
                if (button.hasClass("button_request_paused_caching")) {
                    //если кликнули по кнопке в мемент обновления
                    if (button.hasClass("v_processe")) {
                        Base.messege("info_messege", "orange", "Подождите запрос обрабатывается!"); //выводим сообщения что запрос на паузу/продолжение уже обрабатывается
                        return;
                    }
                    //если кликнули по кнопке в мемент обновления

                    let options = {
                        action: "paused_caching" //php актион
                    };
                    Base.buttons_on_off(button, "loaded"); //отключаем кнопку паузы на время выполнения запроса
                    Base.buttons_on_off(button.siblings(".button_request_abort_caching"), "loaded"); //отключаем кнопку прерывания на время выполнения запроса
                    prepare_request_to_server(options, button, paused_caching); //делаем запрос на сервер для изменения состояния паузы
                }
                //клик по кнопке паузы

                //клик по кнопке прерывания кеширования
                if (button.hasClass("button_request_abort_caching")) {
                    //если кликнули по кнопке в мемент обновления
                    if (button.hasClass("v_processe")) {
                        Base.messege("info_messege", "orange", "Подождите запрос обрабатывается!"); //выводим сообщения что запрос на паузу/продолжение уже обрабатывается
                        return;
                    }
                    //если кликнули по кнопке в мемент обновления

                    let options = {
                        action: "abort_caching" //php актион
                    };
                    Base.buttons_on_off(button, "loaded"); //отключаем кнопку прерывания на время выполнения запроса
                    Base.buttons_on_off(button.siblings(".button_request_paused_caching"), "loaded"); //отключаем кнопку паузы на время выполнения запроса
                    prepare_request_to_server(options, button, abort_caching); //делаем запрос на сервер для прерывания кеширования
                }
                //клик по кнопке прерывания кеширования
            });
            //кнопка по которой нажали
        }
        //обрабатываем события клика по кнопкам



        button_click_action($(".button_request_cache_to_server")); //кнопка начала кеширования

        button_click_action($(".button_request_paused_caching")); //кнопка паузы и возобновления кеширования

        button_click_action($(".button_request_abort_caching")); //кнопка прерывания кеширования


        //функция будет вызвана когда сервер сообщит что успешно выполнил подготовительные действия для кеширования
        caching_prepare_complited = function(options, button, respone_server, status = null) {

            caching_events(button, "caching_started"); //делаем все необходимые действия с кнопками прогресс баром для старат кеширования
            let progress = data_ksn.cache["progress"],
                options_start = { //параметры для запуска кеширования
                    action: "do_cache", //php актион
                    data: {
                        "action": "start"
                    }
                },
                options_progres = { //параметры для запуска мониторинга процесса кеширования
                    action: "cache_current_progres", //php актион
                    data: {
                        "progress": progress
                    }
                };

            prepare_request_to_server(options_start, button, caching_complited); //отправляем запрос на сервер с целью начать кешировать страницы опираясь на подготовленные ранее данные и после завершения кеширования вызвать функцию caching_complited
            prepare_request_to_server(options_progres, button, change_progres_cache); //запрос на сервер с целью отслеживать прогресс кеширования и после каждого изменения количества уже кишированных файлов возвращать ответ и вызывать функцию change_progres_cache
        }
        //функция будет вызвана когда сервер сообщит что успешно выполнил подготовительные действия для кеширования

        //после завершения процесса кеширования не важно как он был заершон
        caching_complited = function(options, button, respone_server, status = null) {
            let abort = respone_server["abort"],
                paused = respone_server["paused"],
                complete = respone_server["complete"],
                options_finishid = {
                    action: "do_cache", //php актион
                    data: {
                        "action": "finishid"
                    }
                };

            if (abort === "yes" && data_ksn.cache["finishid"] !== "load" && data_ksn.cache["finishid"] !== "yes") { ///кеширование было прервано
                data_ksn.cache["abort"] = "yes";
                data_ksn.cache["finishid"] = "load"; //помечаем что начато завершение кеширования
                prepare_request_to_server(options_finishid, button, caching_finishid_fail); //отправляем завпрос на сервер чтоб почистить редис от лишних данных
            } else if (paused === "on") { //кеширование было поставлено на паузу
                data_ksn.cache["paused"] = "on";
                caching_events(button, "caching_paused_enable"); //делаем все необходимые действия при паузе
            } else if (complete === "yes") { //кеширование успешно завершено
                data_ksn.cache["complete"] = "yes";
                data_ksn.cache["finishid"] = "load"; //помечаем что начато завершение кеширования
                prepare_request_to_server(options_finishid, button, caching_finishid_success); //отправляем завпрос на сервер чтоб почистить редис от лишних данных
            }
        }
        //после завершения процесса кеширования не важно как он был заершон

        //кеширование успешно завершено
        caching_finishid_success = function(options, button, respone_server, status = null) {
            data_ksn.cache["finishid"] = "yes"; //помечаем что кеширование успешно завершено
            Base.messege(["big_top_messege", "disabled"], "orange", ""); //скрываем сообщение о том что нужно обновить кеш
            caching_events(button, "caching_success_complite"); //делаем все необходимые действия при успешном завершении кеширования
        }
        //кеширование успешно завершено

        //кеширование было прервано
        caching_finishid_fail = function(options, button, respone_server, status = null) {
            data_ksn.cache["finishid"] = "yes"; //помечаем что кеширование завершено
            caching_events(button, "caching_abort_complite"); //делаем все необходимые действия при прерывании кеширования
        }
        //кеширование было прервано

        //функция после успешного ответа сервера о прогрессе кеширования
        change_progres_cache = function(options, button, respone_server, status = null) {

            data_ksn.cache["log"] = respone_server['log']; //данные получаенны их лога редиса записываем в буфер

            let respone_log = data_ksn.cache["log"], //данные получаенны их лога редиса
                log_area = button.siblings(".caching_log").find(".log_area"); //блок с логом кеширования

            //перебираем логи из ответа
            for (let i in data_ksn.cache["log"]) {
                let log_text = log_area.html(), //текущее содержимое блока лога
                    text = log_text + respone_log[i] + "<br>"; //новоё содержимое для блока лога
                log_area.html(text); //вставляем новое содержимое в блок лога
                log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
            }
            //перебираем логи из ответа

            //если с сервера было передано сообщение
            if (respone_server["messege"]) {
                let log_text = log_area.html(), //текущее содержимое блока лога
                    text = log_text + respone_server["messege"] + "<br>"; //новоё содержимое для блока лога с вставленым сообщением
                log_area.html(text); //вставляем новое содержимое в блок лога
                log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
            }
            //если с сервера было передано сообщение


            let progres_cache = button.siblings(".progres_cache"), //прогрес бар
                text_block = progres_cache.find(".text_progress"); //текст прогрес бара

            //все данные переданные сервером записываем в буфер data_ksn.cache
            for (let data in respone_server) {
                data_ksn.cache[data] = respone_server[data];
            }
            //все данные переданные сервером записываем в буфер data_ksn.cache

            if (data_ksn.cache["finishid"] === "yes" || data_ksn.cache["finishid"] === "load") { return; } //если кеширование в процесе завершение или уже завершено
            if (respone_server['paused'] === "on") { return; } //кеширование приостановлено
            if (respone_server['abort'] === "yes") { return; } //кеширование прервано
            if (respone_server['complete'] === "yes") { return; } //кеширование завершено

            let total = Number(data_ksn.cache["amount"]), //общее количество файлов для кеширования
                progress = Number(data_ksn.cache["progress"]), //текущее количество уже кешированных файлов
                progress_procent = Math.ceil((progress * 100) / total); //процент уже кешированных файлов
            progres_bar(progress_procent, text_block); //анимация чисел в прогрес баре

            //параметры нового запроса, чтоб получить дальнейшии значения прогресса кеширования
            let options_progres = {
                action: "cache_current_progres", //php актион
                data: {
                    "progress": progress
                }
            };
            //параметры нового запроса, чтоб получить дальнейшии значения прогресса кеширования

            //если кеширование не завершено
            if (data_ksn.cache["complete"] !== "yes") {
                prepare_request_to_server(options_progres, button, change_progres_cache); //выполняем запрос на сервер чтоб узнать о новом количестве кешированных файлов и после успешного ответа снова запускаем функцию change_progres_cache
            }
            //если кеширование не завершено
        }
        //функция после успешного ответа сервера о прогрессе кеширования

        //событие после успешного ответа сервера на нажатие кнопки паузы
        paused_caching = function(options, button, respone_server, status = null) {
            data_ksn.cache["paused"] = respone_server["paused"]; //записываем в буфер новое состояние паузы
            //если пауза была активна деактивируем её
            if (button.hasClass("paused_active")) {
                caching_events(button, "caching_paused_disabled"); //делаем все необходимые действия при отключении паузы
                let progress = data_ksn.cache["progress"],
                    button_start_caching = button.siblings(".button_request_cache_to_server"),
                    options_progres = {
                        action: "cache_current_progres", //php актион
                        data: {
                            "progress": progress
                        }
                    },
                    options_continue = { //параметры для продолжения кеширования
                        action: "do_cache", //php актион
                        data: {
                            "action": "start"
                        }
                    };

                prepare_request_to_server(options_continue, button, caching_complited); //отправляем запрос на сервер с целью продолжить кешировать страницы опираясь на данные которые остались в редисе до прерывания паузой кеширования
                prepare_request_to_server(options_progres, button_start_caching, change_progres_cache); //делаем запрос на сервер что продолжить мониторить прогресса кеширования
            }
            //если пауза была активна деактивируем её
        }
        //событие после успешного ответа сервера на нажатие кнопки паузы

        //событие после успешного ответа сервера на нажатие кнопки прервать
        abort_caching = function(options, button, respone_server, status = null) {
            //если мы получили ответ от сервера после нажатия кнопки прерывания и в буфере не записано состояние data_ksn.cache["abort"] = yes значит стоит пауза и функция мониторинга прогресса точно не работает (ведь только она обновляла данные в буфере) значит записываем в буфер новое заначение прерывания и выполняем запрос на сервер что подчистить все данные
            if (data_ksn.cache["abort"] === "no") {
                data_ksn.cache["abort"] = "yes"; //записываем в буфер новое состояние прерывания кеширования

                let options_abort = { //параметры для запуска кеширования
                    action: "do_cache", //php актион
                    data: {
                        "action": "start"
                    }
                };

                prepare_request_to_server(options_abort, button, caching_complited); //отправляем запрос на сервер с запустить попытку кеширования увидить что в редисе записано прерывание и прервать операции с соответсвующим сообщением и очесткой редиса
            }
        }
        //событие после успешного ответа сервера на нажатие кнопки прервать

        //поготавливаем запрос на сервер options - параметры для отправки на сервер содержат в себе php актион и сами данные, button - кнопка инициализировавшая этот запрос, callback - имя функции которая будет вызвана после выполнения запроса, time_to_out - время которое даётся серверу на ответ
        prepare_request_to_server = function(options, button, callback, time_to_out = null) {
            const wait_respone = Base.request_to_server(options, time_to_out); //делаем запрос на сервер

            //выполняем действия в случае если запрос на сервер прошол успешно
            wait_respone.then((request) => {
                    let progres_data = JSON.parse(request.response); //данные полученные от сервера
                    callback(options, button, progres_data, request.status); //функция которая будет вызвана после успешного выполнения запроса на сервер
                })
                //выполняем действия в случае если запрос на сервер прошол успешно

                //выполняем действия в случае если запрос на сервер не выполнился из-за ошибки
                .catch((request) => {
                    status = request === "timeout" ? "timeout" : request.status;
                    caching_events(button, "caching_abort_complite"); //делаем все необходимые действия при прерывании кеширования
                    Base.messege("info_messege", "red", "Ошибка отправки " + status + ""); //выводим сообщение со статусом ошибки
                });
            //выполняем действия в случае если запрос на сервер не выполнился из-за ошибки
        }
        //поготавливаем запрос на сервер options - параметры для отправки на сервер содержат в себе php актион и сами данные, button - кнопка инициализировавшая этот запрос, callback - имя функции которая будет вызвана после выполнения запроса, time_to_out - время которое даётся серверу на ответ


        //если значение data_ksn.load_pri_starte_page определено при старте страницы значить кеширование в процесе или на паузе и нужно показать прогрес и отправить запрос на сервер для дальнейшего мониторинга прогресса кеширования
        if (typeof data_ksn.load_pri_starte_page !== "undefined") {
            let total = Number(data_ksn.cache["amount"]), //общее количество файлов для кеширования
                progress = Number(data_ksn.cache["progress"]), //текущее количество уже кешированных файлов
                progress_procent = Math.ceil((progress * 100) / total), //процент уже кешированных файлов
                button_start_caching = $(".button_request_cache_to_server"), //кнопка начать кеширование для текущей операции
                button_paused_caching = button_start_caching.siblings(".button_request_paused_caching"), //кнопка паузы для текущей операции
                button_abort_caching = button_start_caching.siblings(".button_request_abort_caching"), //кнопка прерывания для текущей операции
                progres_cache = button_start_caching.siblings(".progres_cache"), //прогрес бар
                line_progress = progres_cache.find(".line_progress"), //полоска прогресс бара
                text_progress = progres_cache.find(".text_progress"), //текст прогресс бара
                log_area = button_start_caching.siblings(".caching_log").find(".log_area"); //блок с логом кеширования

            text_progress.html("" + progress_procent + "%"); //выставляем актуальный текст прогресса
            line_progress.css("width", "" + progress_procent + "%"); //выставляем актуальную длинну линии прогресса
            button_paused_caching.fadeIn(500); //плавно показывам кнопку паузы
            button_abort_caching.fadeIn(500); //плавно показывам кнопку прерывания

            //заполняем блок лога строками из лога редиса
            for (let i in data_ksn.cache.log) {
                let log_text = log_area.html(), //текущее содержимое блока лога
                    text = log_text + data_ksn.cache.log[i] + "<br>"; //новоё содержимое для блока лога
                log_area.html(text); //вставляем новое содержимое в блок лога
            }
            log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
            //заполняем блок лога строками из лога редиса


            data_ksn.progres_in_bar = progress_procent; //записываем в буфер стартовое значение для прогресс бара

            Base.buttons_on_off(button_start_caching, "loaded"); //оключаем кнопку старта кеширования

            //если data_ksn.cache["paused"] === "on" значить процесс кеширования стоит на паузе и при старете нужно отключить кнопку чтоб не было мелькания пауза/продолжить, а был лоадер с дальнейшим переходои в слово продолжить
            if (data_ksn.cache["paused"] === "on") {
                Base.buttons_on_off(button_paused_caching, "loaded"); //оключаем кнопку
            }

            let options_start = { //параметры для запуска кеширования
                    action: "do_cache", //php актион
                    data: {
                        "action": "start"
                    }
                },
                options_progres = { //параметры для запуска мониторинга процесса кеширования
                    action: "cache_current_progres", //php актион
                    data: {
                        "progress": progress
                    }
                };
            prepare_request_to_server(options_start, button_start_caching, caching_complited); //отправляем запрос на сервер с целью начать кешировать страницы опираясь на подготовленные ранее данные и после завершения кеширования вызвать функцию caching_complited
            prepare_request_to_server(options_progres, button_start_caching, change_progres_cache); //запрос на сервер с целью отслеживать прогресс кеширования и после каждого изменения количества уже кишированных файлов возвращать ответ и вызывать функцию change_progres_cache
        }
        //если значение data_ksn.load_pri_starte_page определено при старте страницы значить кеширование в процесе или на паузе и нужно показать прогрес и отправить запрос на сервер для дальнейшего мониторинга прогресса кеширования





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
            cookie_data_active_block = Base.getCookie("ksn_data[current_settings_block_in_ksn_plugin]"); //куки с данными блока настроек который был у пользователя открыт в последний раз




        //если такая запись в куки существует
        if (cookie_data_active_block) {
            let blok_for_active = main_settings_wraper.find("div#" + cookie_data_active_block + ""), //находим блок настроек который нужно отобразить
                menu_item_child_for_active = menu_item_child.filter("[data-target='" + cookie_data_active_block + "']"); //пункт меню который нужно сделать активным
            menu_item_child_for_active.addClass("active"); //помечаем блок настроек как active
            blok_for_active.addClass("active"); //помечаем пункт в меню как active
            Base.fade_item(blok_for_active, "show", 500); //показываем блок настроек
        }
        //если такая запись в куки существует

        //если этого куки не существует, отображеам первый блок настроек и активируем первый пункт меню
        else {
            let data_target_id = main_settings_wraper_item.first().attr("id"); //получаем id первого блока настроек
            Base.fade_item(main_settings_wraper_item.first(), "show", 500); //показываем первый блок настроек
            menu_item_child.filter("[data-target='" + data_target_id + "']").addClass("active"); //активируем первый элемент в меню
        }
        //если этого куки не существует, отображеам первый блок настроек и активируем первый пункт меню

        //обрабатываем клик по элементу в меню
        menu_item_child.on("click touchend", function(e) {
            e.preventDefault();
            if ($(this).hasClass("active")) { return; } //если данный пункт меню уже активен то прерываем выполнение функции

            Base.fade_item(main_settings_wraper_item.filter(".active"), "hide", 500, function() {
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
                Base.fade_item(tardet_div, "show", 500); //показываем новый блок с настройками
                tardet_div.addClass("active"); //помечаем новый блок настроек как active
                clearInterval(data_ksn.menu_item_show_timer_id); //чистим таймер
                delete data_ksn.menu_item_show_timer_id; //удаляем таймер из буфера
            }, 500);

            //через 500 мс, когда скроется прежний блок настроек, отображаем новй блок с настройками

            Base.setCookie("ksn_data[current_settings_block_in_ksn_plugin]", data_target, { 'max-age': 604800, 'path': '/wp-admin/admin.php' }, false); //записываем в куки новое значение для последнего запрошенного блока настроек, для текущего пользователя, оно будут сохранено неделю и доступно только для страниц /wp-admin/admin.php
        });
        //обрабатываем клик по элементу в меню

        //Меню





    });
})(jQuery);