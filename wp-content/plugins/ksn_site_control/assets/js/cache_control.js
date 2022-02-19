(function($) {
    //все необходимые действия с кнопками прогресс баром при изменении статуса кеширования
    //event - событие которое вызвано после нажатия
    function caching_events(event, dop_params = null) {
        let progres_cache = $("#progres_cache"), //прогрес бар
            line_progress = progres_cache.find(".line_progress"), //полоска прогрес бара
            text_progress = progres_cache.find(".text_progress"), //текст прогрес бара
            button_start_caching = $("#button_request_cache_to_server"), //кнопка начать кеширование для текущей операции
            button_abort_caching = $("#button_request_abort_caching"), //кнопка прерывания для текущей операции
            log_area = $("#caching_log").find(".log_area"), //блок с логом кеширования
            log_text = log_area.html(); //текущее содержимое блока лога

        //все необходимые действия с кнопками прогресс баром для начала кеширования
        if (event === "caching_started") {
            text_progress.html("0%");
            line_progress.css("width", "0%");
            log_area.html(""); //чистим блок лога от предидущих записей
            progres_bar(0, text_progress, true); //завершаем анимацию чисел в прогрес баре
            button_abort_caching.fadeIn(500);
        }
        //все необходимые действия с кнопками прогресс баром для начала кеширования

        //все необходимые действия с кнопками прогресс баром после успешного завешения кеширования
        if (event === "caching_success_complite") {
            progres_bar(100, text_progress, true); //завершаем анимацию чисел в прогрес баре
            text_progress.html("100%");
            line_progress.css("width", "100%");
            button_abort_caching.fadeOut(500);

            //если есть доп параметры
            if (dop_params) {
                if (dop_params["finishid_planned"]) { //доп параметр указывает на то что было завершено именно плановое кеширование
                    log_area.html(log_text + "<span class='green log_messege'>Плановое кеширование успешно завершено =)</span><br>"); //вставляем новое содержимое в блок лога
                    messege("green", "Плановое кеширование успешно завершено!");
                }
                if (dop_params["finishid_user"]) {
                    log_area.html(log_text + "<span class='green log_messege'>Кеширование успешно завершено =)</span><br>"); //вставляем новое содержимое в блок лога
                    messege("green", "Кеширование было успешно завершено!");
                }
            }
            //если есть доп параметры

            log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
            log_area.html(log_area.html() + "<span class='yellow log_messege'>Redis очищен!</span><br>"); //вставляем новое содержимое в блок лога
            log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события

            let date = new Date(data_ksn["cache_last_update_time"] * 1000),
                day = date.getDate(),
                month = String(date.getMonth() + 1).length === 2 ? String(date.getMonth() + 1) : String("0" + (date.getMonth() + 1)),
                year = date.getFullYear(),
                hour = date.getHours(),
                minute = String(date.getMinutes()).length === 2 ? String(date.getMinutes()) : String("0" + date.getMinutes()),
                seconds = String(date.getSeconds()).length === 2 ? String(date.getSeconds()) : String("0" + date.getSeconds());

            log_area.html(log_area.html() + "<span class='green log_messege'>Дата последнего успешного кеширования: " + day + "." + month + "." + year + " " + hour + ":" + minute + ":" + seconds + " по МСК</span><br>"); //вставляем новое содержимое в блок лога
            log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события

            //убедившись что кнопки точно скрыты и не будет ни каких лишних вызовов можно их разблокировать
            setTimeout(() => {
                buttons_on_off(button_start_caching, "enabled", "Начать"); //разблокируем кнопку
                buttons_on_off(button_abort_caching, "enabled", "Прервать"); //меняем состояние кнопки Прервать на "Прервать"
            }, 550);
            //убедившись что кнопки точно скрыты и не будет ни каких лишних вызовов можно их разблокировать
            data_ksn.cache = {};
        }
        //все необходимые действия с кнопками прогресс баром после успешного завешения кеширования

        //все необходимые действия с кнопками прогресс баром после прерывания кеширования
        if (event === "caching_abort_complite") {
            text_progress.html("0%");
            line_progress.css("width", "0%");
            progres_bar(0, text_progress, true); //завершаем анимацию чисел в прогрес баре
            button_abort_caching.fadeOut(500);
            log_area.html(log_text + "<span class='red log_messege'>Кеширование было принудительно прервано!</span><br>"); //вставляем новое содержимое в блок лога
            log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
            log_area.html(log_area.html() + "<span class='yellow log_messege'>Redis очищен!</span><br>"); //вставляем новое содержимое в блок лога
            log_area[0].scrollTop = log_area[0].scrollHeight; //прокручивам лог в конец чтоб видеть актуальные события
            messege("red", "Кеширование прервано!");

            //убедившись что кнопки точно скрыты и не будет ни каких лишних вызовов можно их разблокировать
            setTimeout(() => {
                buttons_on_off(button_start_caching, "enabled", "Начать"); //разблокируем кнопку
                buttons_on_off(button_abort_caching, "enabled", "Прервать"); //меняем состояние кнопки Прервать на "Прервать"
            }, 550);
            //убедившись что кнопки точно скрыты и не будет ни каких лишних вызовов можно их разблокировать
            data_ksn.cache = {};
        }
        //все необходимые действия с кнопками прогресс баром после прерывания кеширования
    }
    //все необходимые действия с кнопками прогресс баром при изменении статуса кеширования

    //поготавливаем запрос на сервер 
    //options - параметры для отправки на сервер содержат в себе php актион и сами данные, 
    //callback - имя функции которая будет вызвана после выполнения запроса, 
    //time_to_out - время которое даётся серверу на ответ
    function prepare_request_to_server(options, callback, time_to_out = null) {
        const wait_respone = request_to_server(options, time_to_out); //делаем запрос на сервер

        //выполняем действия в случае если запрос на сервер прошол успешно
        wait_respone.then((request) => {
                let progres_data = JSON.parse(request.response); //данные полученные от сервера
                callback(progres_data); //функция которая будет вызвана после успешного выполнения запроса на сервер
            })
            //выполняем действия в случае если запрос на сервер прошол успешно

            //выполняем действия в случае если запрос на сервер не выполнился из-за ошибки
            .catch((request) => {
                status = request === "timeout" ? "timeout" : request.status;
                caching_events("caching_abort_complite"); //делаем все необходимые действия при прерывании кеширования
                messege("red", "Ошибка отправки " + status + "", 5); //выводим сообщение со статусом ошибки
            });
        //выполняем действия в случае если запрос на сервер не выполнился из-за ошибки
    }
    //поготавливаем запрос на сервер

    //клик по кнопке начала кеширования
    $("#button_request_cache_to_server").on("click touchend", function(e) {
        e.preventDefault();
        let button = $(this),
            checkboxs_re_create = $("#clear_full_cache_checkbox").find("input"),
            re_create_cache_files = checkboxs_re_create.is(':checked') ? "yes" : "no";

        data_ksn.cache = { "progress": "0" }; //объект в буфере для харанения всех необходимыъ данных, записываем сразу стартовы прогресс 0

        //если кликнули по кнопке в мемент обновления
        if (button.hasClass("v_processe")) {
            messege("blue", "Файлы уже кешируются =)"); //выводим сообщения что файлы уже кешируются
            return;
        }
        //если кликнули по кнопке в мемент обновления

        buttons_on_off(button, "load"); //оключаем кнопку начала кеширования

        let options_prepare = { //параметры для запуска подготовки кеширования
            action: "do_cache", //php актион
            data: {
                "action": "prepare", //сообщаем серверу что нужно начать подготовку к кешированию
                "re_create": re_create_cache_files //сообщает серверу нужно ли послностью пересоздать папку кеша или только пререзаписать
            }
        };

        prepare_request_to_server(options_prepare, caching_prepare_complited); //когда функция вернёт ответ мы будем точно уверенны что все данные в редис записаны и можно вызывать функцию caching_prepare_complited
    });
    //клик по кнопке начала кеширования

    //клик по кнопке прерывания кеширования
    $("#button_request_abort_caching").on("click touchend", function(e) {
        e.preventDefault();
        let button = $(this);
        //если кликнули по кнопке в мемент обновления
        if (button.hasClass("v_processe")) {
            messege("orange", "Подождите запрос обрабатывается!"); //выводим сообщения что запрос на паузу/продолжение уже обрабатывается
            return;
        }
        //если кликнули по кнопке в мемент обновления

        let options = {
            action: "abort_caching" //php актион
        };
        buttons_on_off(button, "load"); //отключаем кнопку прерывания на время выполнения запроса
        prepare_request_to_server(options, abort_caching); //делаем запрос на сервер для прерывания кеширования
    });
    //клик по кнопке прерывания кеширования



    //функция будет вызвана когда сервер сообщит что успешно выполнил подготовительные действия для кеширования
    caching_prepare_complited = function(respone_server) {
        //если ошибка начала кеширования
        if (respone_server['fail']) {
            buttons_on_off($("#button_request_cache_to_server"), "enabled", "Начать"); //разблокируем кнопку
            messege("orange", respone_server['fail'], 7); //выводим сообщения что запрос на паузу/продолжение уже обрабатывается
            return;
        }
        //если ошибка начала кеширования

        caching_events("caching_started"); //делаем все необходимые действия с кнопками прогресс баром для старат кеширования
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

        prepare_request_to_server(options_start, caching_complited); //отправляем запрос на сервер с целью начать кешировать страницы опираясь на подготовленные ранее данные и после завершения кеширования вызвать функцию caching_complited
        prepare_request_to_server(options_progres, change_progres_cache); //запрос на сервер с целью отслеживать прогресс кеширования и после каждого изменения количества уже кишированных файлов возвращать ответ и вызывать функцию change_progres_cache
    }
    //функция будет вызвана когда сервер сообщит что успешно выполнил подготовительные действия для кеширования

    //после завершения процесса кеширования не важно как он был заершон
    caching_complited = function(respone_server) {
        let abort = respone_server["abort"],
            complete = respone_server["complete"],
            cache_last_update_time = respone_server["cache_last_update_time"],
            planned_finish = respone_server["finishid_planned"],
            options_finishid = {
                action: "do_cache", //php актион
                data: {
                    "action": "finishid"
                }
            };

        //если переданно время последнего кеширования
        if (cache_last_update_time) {
            data_ksn["cache_last_update_time"] = cache_last_update_time;
        }
        //если переданно время последнего кеширования

        //если было завершено плановое кеширование
        if (planned_finish === "yes") {
            data_ksn.cache["complete"] = "yes";
            data_ksn.cache["finishid"] = "yes"; //помечаем что кеширование успешно завершено
            caching_finishid_success(respone_server); //кеширование успешно завершено
        }
        //если было завершено плановое кеширование

        ///кеширование было прервано
        if (abort === "yes" && data_ksn.cache["finishid"] !== "load" && data_ksn.cache["finishid"] !== "yes") {
            data_ksn.cache["abort"] = "yes";
            data_ksn.cache["finishid"] = "load"; //помечаем что начато завершение кеширования
            setTimeout(()=>{//нужен чтоб не вылетала 502 ошибка
                prepare_request_to_server(options_finishid, caching_finishid_fail); //отправляем завпрос на сервер чтоб почистить редис от лишних данных
            }, 2000);
        }
        ///кеширование было прервано

        if (complete === "yes") { //кеширование успешно завершено
            data_ksn.cache["complete"] = "yes";
            data_ksn.cache["finishid"] = "load"; //помечаем что начато завершение кеширования
            setTimeout(()=>{//нужен чтоб не вылетала 502 ошибка
                prepare_request_to_server(options_finishid, caching_finishid_success); //отправляем завпрос на сервер чтоб почистить редис от лишних данных
            }, 2000);
        }
    }
    //после завершения процесса кеширования не важно как он был заершон

    //кеширование успешно завершено
    caching_finishid_success = function(respone_server) {
        data_ksn.cache["finishid"] = "yes"; //помечаем что кеширование успешно завершено
        big_top_messege("disabled", "", "", "nead_update_cache"); //скрываем сообщение о том что нужно обновить кеш
        big_top_messege("disabled", "", "", "nead_cache_create"); //скрываем сообщение о том что нужно создать кеш
        caching_events("caching_success_complite", respone_server); //делаем все необходимые действия при успешном завершении кеширования
    }
    //кеширование успешно завершено

    //кеширование было прервано
    caching_finishid_fail = function(respone_server) {
        data_ksn.cache["finishid"] = "yes"; //помечаем что кеширование завершено
        caching_events("caching_abort_complite"); //делаем все необходимые действия при прерывании кеширования
    }
    //кеширование было прервано

    //функция после успешного ответа сервера о прогрессе кеширования
    change_progres_cache = function(respone_server) {

        data_ksn.cache["log"] = respone_server['log']; //данные получаенны их лога редиса записываем в буфер

        let respone_log = data_ksn.cache["log"], //данные получаенны их лога редиса
            log_area = $("#caching_log").find(".log_area"); //блок с логом кеширования

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


        let progres_cache = $("#progres_cache"), //прогрес бар
            text_block = progres_cache.find(".text_progress"); //текст прогрес бара

        //все данные переданные сервером записываем в буфер data_ksn.cache
        for (let data in respone_server) {
            data_ksn.cache[data] = respone_server[data];
        }
        //все данные переданные сервером записываем в буфер data_ksn.cache

        if (data_ksn.cache["finishid"] === "yes" || data_ksn.cache["finishid"] === "load") { return; } //если кеширование в процесе завершение или уже завершено
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
            prepare_request_to_server(options_progres, change_progres_cache); //выполняем запрос на сервер чтоб узнать о новом количестве кешированных файлов и после успешного ответа снова запускаем функцию change_progres_cache
        }
        //если кеширование не завершено
    }
    //функция после успешного ответа сервера о прогрессе кеширования

    //событие после успешного ответа сервера на нажатие кнопки прервать
    abort_caching = function(respone_server) {
        data_ksn.cache["abort"] = "yes"; //записываем в буфер новое состояние прерывания кеширования
    }
    //событие после успешного ответа сервера на нажатие кнопки прервать




    //если значение data_ksn.load_pri_starte_page определено при старте страницы значить кеширование в процесе и нужно показать прогрес и отправить запрос на сервер для дальнейшего мониторинга прогресса кеширования
    if (typeof data_ksn.load_pri_starte_page !== "undefined") {
        let total = Number(data_ksn.cache["amount"]), //общее количество файлов для кеширования
            progress = Number(data_ksn.cache["progress"]), //текущее количество уже кешированных файлов
            progress_procent = Math.ceil((progress * 100) / total), //процент уже кешированных файлов
            button_start_caching = $("#button_request_cache_to_server"), //кнопка начать кеширование для текущей операции
            button_abort_caching = $("#button_request_abort_caching"), //кнопка прерывания для текущей операции
            progres_cache = $("#progres_cache"), //прогрес бар
            line_progress = progres_cache.find(".line_progress"), //полоска прогресс бара
            text_progress = progres_cache.find(".text_progress"), //текст прогресс бара
            log_area = $("#caching_log").find(".log_area"); //блок с логом кеширования

        text_progress.html("" + progress_procent + "%"); //выставляем актуальный текст прогресса
        line_progress.css("width", "" + progress_procent + "%"); //выставляем актуальную длинну линии прогресса
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

        buttons_on_off(button_start_caching, "load"); //оключаем кнопку старта кеширования

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
        prepare_request_to_server(options_start, caching_complited); //отправляем запрос на сервер с целью начать кешировать страницы опираясь на подготовленные ранее данные и после завершения кеширования вызвать функцию caching_complited
        prepare_request_to_server(options_progres, change_progres_cache); //запрос на сервер с целью отслеживать прогресс кеширования и после каждого изменения количества уже кишированных файлов возвращать ответ и вызывать функцию change_progres_cache
    }
    //если значение data_ksn.load_pri_starte_page определено при старте страницы значить кеширование в процесе и нужно показать прогрес и отправить запрос на сервер для дальнейшего мониторинга прогресса кеширования
})(jQuery);