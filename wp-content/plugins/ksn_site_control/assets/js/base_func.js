//создаёт новый куки
//name - имя записываемого куки
//value - значение записываемого кукки
//options - параметры для записываемых куки
//trigger - если true то заменит некоторые символы на юникод, если не задан то сохранит куки как переданы в функцию
function setCookie(name, value, options = {}, trigger = null) {
    //проверим соответсвует парметр expires объекта options формату даты unix
    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString(); //преобразуем значение expires в формат Mon, 03 Jul 2006 21:44:38 GMT
    }
    //проверим соответсвует парметр expires объекта options формату даты unix

    if (trigger) { //eсли нужно заменить некоторые символы на юникод
        var updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value); //данные для записи в куки
    } else { //записываем как передали
        var updatedCookie = name + "=" + value; //данные для записи в куки
    }

    //перебираем объект options и дописываем в данные для записи в куки
    for (let optionKey in options) {
        updatedCookie += "; " + optionKey; //дополняем данные для записи в куки новым параметром
        let optionValue = options[optionKey]; //получаем заначение для нового параметра
        updatedCookie += "=" + optionValue; //дополняем данные для записи в куки новым значение
    }
    //перебираем объект options и дописываем в данные для записи в куки

    document.cookie = updatedCookie; //записываем даннеы в куки
}
// Пример использования:
//setCookie('user', 'John', { secure: true, 'max-age': 3600 });
//создаёт новый куки

// возвращает куки с указанным name или undefined, если ничего не найдено
//name - имя куки значение которого нужно получить
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
// возвращает куки с указанным name или undefined, если ничего не найдено

//удаляем куки по имени
//name - имя куки который нужно удалить
function deleteCookie(name) {
    setCookie(name, "", {
        'max-age': -1
    })
}
//удаляем куки по имени

//получаем ключ по значению в объекте
//object - объект в котором будем выполнять поиск
//value - значение ключ которого будем искать
function ObjectGetKeyByValue(object, value) {
    for (var prop in object) {
        if (object.hasOwnProperty(prop)) {
            if (object[prop] === value)
                return prop;
        }
    }
}
//получаем ключ по значению в объекте

//получаем первый элемент в объекте
//object - объект первый элемент которого нужно получить
function GetFirstProperty(object) {
    for (var i in object) {
        return object[i];
        break;
    }
}
//получаем первый элемент в объекте

//анимация чисел и полосы в прогресс баре
//current_procent - текущий посчитаный процент
//text_block - блок в котором меняем текст прогресса
//abort - завершает все таймеры и функцию
function progres_bar(current_procent, text_block, abort = false) {
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

//фнкуия позволяет скрыть/показать элементы
//elements - элементы которые неужно скрыть/показать
//action - что нужно сделать скрыть/показать
//time_to_fade - время в миллисекундах на то чтобы скрыть/показать
//before_func - функция которая должна выполниться в самом начале скрипта
function fade_item(elements, action, time_to_fade, before_func = null, $ = jQuery) {
    if (before_func) { before_func(); } //если есть функция которую нужно выполнить перед началом

    //перебираем все переданные элементы
    elements.each(function() {
        let element = $(this); //текущий итерируемый элемент 
        element.css("transition", "opacity " + time_to_fade / 1000 + "s linear"); //устанавливаем элементу свойства transition

        //если нужно скрыть элемени и у него нет класса сообщающего что он уже скрыт
        if (action === "hide" && !element.hasClass("hide_element")) {
            element.css("opacity", "1");
            element.removeClass("show_element");
            element.addClass("hide_element");

            //после завершаения анимации даём display none
            setTimeout(() => {
                element.css("display", "none");
            }, time_to_fade);
            //после завершаения анимации даём display none
        }
        //если нужно скрыть элемени и у него нет класса сообщающего что он уже скрыт

        //если нужно показть элемени и у него нет класса сообщающего что он уже показан
        if (action === "show" && !element.hasClass("show_element")) {
            element.css({ "display": "block", "opacity": "0" });

            //выполняем только после того как применились стили display block и opacity 0
            if (element.css("display") === "block" && element.css("opacity") === "0") {
                element.removeClass("hide_element");
                element.addClass("show_element");
            }
            //выполняем только после того как применились стили display block и opacity 0
        }
        //если нужно показть элемени и у него нет класса сообщающего что он уже показан

    });
    //перебираем все переданные элементы
}
//фнкуия позволяет скрыть/показать элементы

//конвертирует переданные массивы и объекты в нужный формат и одинарным уовнем вложенности
//element - переданный для конвертации массив или объект
//convert_to - в какой формат конвертировать, в объект или в массив
function convert_objects_and_arreys(element, convert_to) {
    if (typeof element !== "object") { return "Переданный элемент не является масивом или объектом!" };

    //данная функция позволить проверять существет ли переданное свойство в объектте и если оно уже есть то записать его с другим модифицированным свойство
    //object - объект в котором производится поиск на наличие ключей схожих с key
    //key - ключ котрый нужно найти в объекте
    //value - значение которое записываем в object
    //index - индекс который нужно добавить в название key если он уже существует в object
    let give_new_key_for_object = function(object, key, value, index = 1) {
        //если данное свойство/ключ есть в object
        if (object.hasOwnProperty(key)) {
            give_new_key_for_object(object, key + "_" + index, value, index); //рекурсивно запускаем функцию с новыми параметрами
        }
        //если данное свойство/ключ есть в object 

        //если данного свойства нет в object 
        else {
            object[key] = value; //просто записываем ключ : значение в object
        }
        //если данного свойства нет в object 
        return object; //возвращаем дополненый объект object
    }
    //данная функция позволить проверять существет ли переданное свойство в объектте и если оно уже есть то записать его с другим модифицированным свойство

    //конвертируем в простой объект
    if (convert_to === "object") {
        //element - конвертируемый массив
        //result_object - итоговый объект в который будет всё записано
        //array_name - чтоб избежать замены значений в result_object мы в ключ добавляем имя массива если оно есть
        let foreach_array = function(element, result_object = {}, array_name = null) {
            let type = Array.isArray(element) ? "array" : "object"; //определяем тип переданного element

            //если переданный element массив
            if (type === "array") {
                //проходим циклом по массиву
                for (let item of element) {
                    if (typeof item === "object") { //если итерируемый item массив или объект
                        result_object = foreach_array(item, result_object); //рекурсивно запускаем функцияю foreach_array, и результат её выполненяи присваем в виде нового занчения result_object
                    } else { //если итерируемый item строка
                        let index = element.indexOf(item); //получаем индекс в массиве
                        if (array_name !== null) { //если передано имя массива
                            result_object = give_new_key_for_object(result_object, array_name + "_" + index, item, index);
                        } else { //если не передано имя массива
                            result_object = give_new_key_for_object(result_object, index, item, index);
                        }
                    }
                }
                //проходим циклом по массиву
            }
            //если переданный element массив

            //если переданный element объект
            else if (type === "object") {
                //проходим циклом по объекту
                for (let item in element) {
                    if (typeof element[item] === "object") { //если итерируемый item массив или объект
                        result_object = foreach_array(element[item], result_object, item); //рекурсивно запускаем функцияю foreach_array, и результат её выполненяи присваем в виде нового занчения result_object, так же передаём item что будет являтся названием группы данного объекта
                    } else {
                        result_object = give_new_key_for_object(result_object, item, element[item]);
                    }
                }
                //проходим циклом по объекту
            }
            //если переданный element объект

            return result_object; //вернуть полученный итоговый объект
        };
        return foreach_array(element); //вернуть результат функции
    }
    //конвертируем в простой объект

    //конвертируем в простой массив
    if (convert_to === "array") {
        //element - конвертируемый массив
        //result_array - итоговый массив в который будет всё записано
        let foreach_array = function(element, result_array = []) {
            let type = Array.isArray(element) ? "array" : "object"; //определяем тип переданного element

            //если переданный element массив
            if (type === "array") {
                //проходим циклом по массиву
                for (let item of element) {
                    if (typeof item === "object") { //если итерируемый item массив или объект
                        result_array = foreach_array(item, result_array); //рекурсивно запускаем функцияю foreach_array, и результат её выполненяи присваем в виде нового занчения result_array
                    } else { //если итерируемый item строка
                        result_array.push(item); //записываем в массив новое значение
                    }
                }
                //проходим циклом по массиву
            }
            //если переданный element массив

            //если переданный element объект
            else if (type === "object") {
                //проходим циклом по объекту
                for (let item in element) {
                    if (typeof element[item] === "object") { //если итерируемый item массив или объект
                        result_array = foreach_array(element[item], result_array, item); //рекурсивно запускаем функцияю foreach_array, и результат её выполненяи присваем в виде нового занчения result_array, так же передаём item что будет являтся названием группы данного объекта
                    } else {
                        result_array.push(element[item]); //записываем в массив новое значение
                    }
                }
                //проходим циклом по объекту
            }
            //если переданный element объект

            return result_array; //вернуть полученный итоговый объект
        };
        return foreach_array(element); //вернуть результат функции
    }
    //конвертируем в простой массив
}
//конвертирует переданные массивы и объекты в нужный формат и одинарным уовнем вложенности

//подготовливаем данные перед отправкой в нужном формате
//object - объект с данныеми которые нужно подготовить
function getFormData(object) {
    const formData = new FormData(); //данные для отправки в виде формированных данных

    //функцию для формирования пары ключ : значение и добавления из в данные формы отправки на сервер
    let foreach_object = function(object, title_data) {
        //перебираем object
        for (let key in object) {
            let title = title_data + "[" + key + "]"; // формируем имя ключа для записи в форму для отправки данных на сервер

            if (typeof object[key] === 'object') { //если элемент object тоже является объектом
                foreach_object(object[key], title); //рекурсивно вызываем функцию foreach_object
            } else {
                formData.append(title, object[key]); //если элемент object не объект то записываем его в данные для отправки ключ : значение
            }
        }
        //перебираем object
    };
    //функцию для формирования пары ключ : значение и добавления из в данные формы отправки на сервер

    //перебираем object на основании которого нужно сформировать данные для отправики на сервер
    for (let key in object) {
        if (typeof object[key] === 'object') { //если элемент object тоже является объектом
            foreach_object(object[key], key); //отправляем в функцию для формирования пары ключ : значение и добавления из в данные формы отправки на сервер
        } else {
            formData.append(key, object[key]); //если элемент object не объект то записываем его в данные для отправки ключ : значение
        }
    }
    //перебираем object на основании которого нужно сформировать данные для отправики на сервер

    return formData; //возвращаем сформированные данный для отправки на сервер
};
/*
нужный формат 
action: save_new_settings
data[site_seo_active]: yes
*/
//подготовливаем данные перед отправкой в нужном формате

//функция выводит сообщения на экран
//status_color - цвет сообщения
//text_messege - текст сообщения
//show_time - время в течении которого сообщение будет показываться в секундах, если передано false то сообщение не будет скрыто автоматически
function messege(status_color, text_messege, show_time = 3, $ = jQuery) {
    let check_messege = $(".info_messege").length; //количество информационных сообщений на экране

    //если есть сообщение на экране, нужно его убрать перед показом нового
    if (check_messege != 0) {
        $(".info_messege").remove(); //удаляем элемент из кода страницы
    }
    //если есть сообщение на экране, нужно его убрать перед показом нового

    $("#info_block").append("<div class='info_messege " + status_color + "'>" + text_messege + "</div>"); //добавляем блок с сообщением в код страницы

    let info_messege = $(".info_messege"); //блок с сообщением

    setTimeout(() => { info_messege.addClass("enabled"); }, 100); //добавляем класс enabled, чтоб плавно показать элемент

    //плавно скрывем сообщение при клике
    info_messege.on("click touchend", function(e) {
        e.preventDefault();
        let info_messege = $(this);
        info_messege.addClass("disable"); //добавляем класс disable, чтоб плавно скрыть элемент
        setTimeout(() => { info_messege.remove(); }, 1000); //удаляем элемент из кода страницы
    });
    //плавно скрывем сообщение при клике

    //плавно скрывем сообщение через определённое время, если включено автоскрытие
    if (show_time !== false) {
        setTimeout(() => {
            info_messege.addClass("disable"); //добавляем класс disable, чтоб плавно скрыть элемент
            setTimeout(() => {
                info_messege.remove(); //удаляем элемент из кода страницы
                info_messege.off("click touchend"); //удаляем обработчики для этого элемента
            }, 1000);
        }, show_time * 1000);
    }
    //плавно скрывем сообщение через определённое время, если включено автоскрытие
}
//функция выводит сообщения на экран

//функция выводит сообщения на экран
//messege_block_data - класс для блока информационного сообщения или массив с данными для данного сообщения
//status_color - цвет сообщения
//text_messege - текст сообщения
function big_top_messege(action, status_color, text_messege, dop_class = null, required_func = null, $ = jQuery) {
    let check_messege_length = $(".big_top_messege").length;
    //если нужно показать сообщение
    if (action === "enabled" && check_messege_length === 0) {
        //если переданна доп функция
        if (required_func) {
            if (required_func() === false) {
                return; //если дополнительная функция задана и она вернула false прерываем функцию
            }
        }
        //если переданна доп функция

        $("#info_block").append("<div class='big_top_messege " + status_color + " " + dop_class + "'>" + text_messege + "</div>"); //добавляем блок с сообщением в код страницы
        setTimeout(() => { $(".big_top_messege").addClass("enabled"); }, 100); //добавляем класс enabled, чтоб плавно показать элемент
    }
    //если нужно показать сообщение

    //если нужно скрыть сообщение
    if (action === "disabled") {
        $(".big_top_messege." + dop_class + "").removeClass("enabled"); //убираем класс для плавного скрытия сообщения
        setTimeout(() => { $(".big_top_messege." + dop_class + "").remove(); }, 1000); //удаляем сообщение из тела документа
    }
    //если нужно скрыть сообщение
}
//функция выводит сообщения на экран

//выпоняем запрос на сервер и возвращаем ответ с сервера
//options - объект со значениями для отправки на сервер
//time_to_out - таймаут для ответа, т.е. максимальное количество миллисикунд данное на ответ, иначер вызовется ontimeout
function request_to_server(options, time_to_out = null) {
    const request = new XMLHttpRequest(); //сам запрос

    request.open("POST", ajaxurl); //начало запроса

    if (time_to_out) {
        request.timeout = time_to_out; //время на выполнения запроса 15 сек, если не успеет то прерываем и выводим ошибку
    }

    request.send(this.getFormData(options)); //отправка запроса
    return new Promise((resolve, reject) => {
        request.onload = function() { resolve(request); };
        request.ontimeout = function() { reject("timeout"); };
        request.onerror = function() { reject(request); };
    });
}
//выпоняем запрос на сервер и возвращаем ответ с сервера

//функциия включает и отключает кнопку сохранения настроек
//action - действие которое нужно сделать с кнопкой сохраненяи настроек
function save_button_action(action, $ = jQuery) {
    let save_button = $("#knopka_sohranit");
    if (action == "disable") {
        save_button.addClass("wait_batton");
        save_button.html("<div class='upload'>Обновление</div><div class='await'></div>");
    } else if (action == "enabled") {
        save_button.removeClass("wait_batton");
        save_button.html("<div class='upload'>Обновить настройки</div>");
    }
};
//функциия включает и отключает кнопку сохранения настроек

//функция включает и отключает кнопки настроек
//button - кнопка к которой нужно пременить функцию
//action - действие которое нужно выполнить с кнопкой
//text_for_button - если задан, то текст кнопки будет изменён на него
//one_save - указывает на то что настрйока привязанная к данной кнопки может быть использованна только 1 раз
function buttons_on_off(button, action, text_for_button = null, one_save = false) {

    //если у кнопки есть класс one_save_complit значит она одноразовая и уже была нажата, занчит завершаем функцию и выводим сообщение
    if (button.hasClass("one_save_complit")) {
        messege("blue", "Данная настройка уже обновлена!"); //выводим сообщение что данная настройка уже обновлена
        return;
    }
    //если у кнопки есть класс one_save_complit значит она одноразовая и уже была нажата, занчит завершаем функцию и выводим сообщение

    //отключаем кнопку
    if (action === "disable") {
        button.addClass("disable");
        if (one_save) { button.addClass("one_save_complit"); } //если кнопка одноразовая то блокируем её для дальнейших нажатий
    }
    //отключаем кнопку

    //включаем кнопку
    if (action === "enabled") {
        setTimeout(() => { button.removeClass("v_processe"); }, 100); //делаем текст видимым
    }
    //включаем кнопку

    //кнопка в процессе ожидания
    if (action === "load") {
        button.addClass("v_processe"); //помечаем что обновление у процессе
        button.html("<div class='await_wraper'><div class='await'></div></div>"); //ставим лоадер на время выполнения запроса на сервер
    }
    //кнопка в процессе ожидания

    //если для кнопки задан новый текст, и кнопка нев режиме ожидания
    if (text_for_button && action !== "load") {
        button.html("<span>" + text_for_button + "</span>"); //вставляем новый текст в кнопку
    }
    //если для кнопки задан новый текст, и кнопка нев режиме ожидания
};
//функция включает и отключает кнопки настроек

//выставялем галочки или крестики возле названия настройки в момент загрузки страницы основываясь на сохранённых настройках
//title - заголовк title_setting возле которого нужно пеоставить галочку/крестить и/или пометить как заполненую/пустую настройку
function check_active_title_settings(title, $ = jQuery) {
    title.each(function() {
        let title = $(this),
            switch_input = title.siblings("label.switch").children("input.switch_input"),
            input_number = title.siblings("input[type='number']"),
            input_text = title.siblings("input[type='text']"),
            input_color = title.closest(".setting_blok").find("input.wp-color-picker"),
            textarea = title.siblings("textarea"),
            all_inputs = input_number.add(input_text).add(input_number).add(input_color).add(textarea);

        //если количество all_inputs больше нуля
        if (all_inputs.length) {
            all_inputs.val() ? title.addClass("zapolnena") : title.addClass("pusto"); //если содержимое текстового поля не пусто
        }
        //если количество all_inputs больше нуля

        //если количество switch_input больше нуля
        if (switch_input.length) {
            switch_input.is(':checked') ? title.addClass("zapolnena") : title.addClass("pusto"); //если он имеет атрибут checked помечаем как zapolnena
        }
        //если количество switch_input больше нуля
    });
}
//выставялем галочки или крестики возле названия настройки в момент загрузки страницы основываясь на сохранённых настройках

//функция для определяния крестика или галочки возле H2 блока настроек
//settings_wrap - блок настроек в котором нужно проверить заполненость настроек и возле h2  в этом блоке выставить крестик/галочку
function h2_check_active(settings_wrap, $ = jQuery) {
    //перебираем объект settings_wrap и для каждого выполняем проверку готовности настройки
    settings_wrap.each(function() {
        let settings_wrap = $(this),
            all_titles = settings_wrap.find(".title_setting"), //все title_setting в данном блоке настроек
            input = settings_wrap.find("input.must_have_for_active"), //все обязательные input
            textarea = settings_wrap.find("textarea.must_have_for_active"), //все обязательные textarea
            all_inputs = input.add(textarea), //все обязательные input и textarea
            h2 = settings_wrap.find("h2"), //заголовк H2 в данном блоке настроек
            kol_settings = all_inputs.length, //количество обязательных полей
            schetchik = 0; //нужен для сверки с общим количество обязательных полей для данной настройки

        all_inputs.each(function() {
            let input = $(this),
                title = input.closest(".setting_blok").find(".title_setting");
            title.hasClass("zapolnena") ? schetchik += 1 : null; //если данная настройка активна, увеличиваем на 1 количество активных настроек
        });

        //если количество активных обязательных настроек равно общему количеству обязательных настроек данного блока настроек то H2 будет с голочкой
        if (schetchik == kol_settings) {
            h2.removeClass("disable");
            h2.addClass("active");
        } else {
            h2.removeClass("active");
            h2.addClass("disable");
        }
        //если количество активных обязательных настроек равно общему количеству обязательных настроек данного блока настроек то H2 будет с голочкой
    });
    //перебираем объект settings_wrap и для каждого выполняем проверку готовности настройки
};
//функция для определяния крестика или галочки возле H2 блока настроек

//функция вызывается при каждом изменении в элементе управлении цветом
//input - текущий input настройки управления цветом
function color_input_check(input, $ = jQuery) {
    let setting_blok = input.closest(".setting_blok"),
        settings_wrap = input.closest(".settings_wrap"),
        title_setting = setting_blok.find(".title_setting"),
        title_setting_text = title_setting.html(),
        id = input.attr("id"),
        bytton_select_color = setting_blok.find("span.wp-color-result-text"), //кнопка "Выбрать цвет"
        bytton_select_color_width = bytton_select_color.width(),
        bytton_select_color_height = bytton_select_color.height();

    bytton_select_color.css("color", "transparent"); //задаём тексту прозрачность
    bytton_select_color.css({ "width": bytton_select_color_width, "height": bytton_select_color_height }); //задаём для кнопки "Выбрать цвет" явную ширину и высоту
    bytton_select_color.html("<div class='await_wraper'><div class='await'></div></div>"); //меняем текст кнопки "Выбрать цвет" на лоадер
    data_ksn.wait_before_save_settings[id] = "Дождитесь пока завершится обработка для настройки - '" + title_setting_text + "'"; //записываем в буфер что присходит обработка настройки выбора цвета
    clearTimeout(data_ksn.wait_second); //удаляем setTimeout чтоб по новой вывести лоадер и не мелькал текст "Выбрать цвет"

    //после секундной проверки мы уже точно занем есть ли ошибка или нет
    data_ksn.wait_second = setTimeout(() => {

        bytton_select_color.css("color", "#fff"); //задаём тексту чвет и в сочетани с transition  в стилях произойдёт планое появление текста
        bytton_select_color.html("Выбрать цвет"); //меняем текст кнопки выбора цвета
        delete data_ksn.wait_before_save_settings[id]; //удаляем ожидание данной настройки из буфера

        //если не было ошибок
        if (!input.hasClass("iris-error")) {

            //если пользователь ошибался в воде цвета
            if (data_ksn.errors.was_color_input_error[id]) {
                messege("green", "Цвет для настройки - '" + title_setting_text + "' введён верно =)"); //выводим сообщение что цвет введён верно
                delete data_ksn.errors.was_color_input_error[id];
            }
            //если пользователь ошибался в воде цвета

            //прповеряем пусто ли значение инпута
            if (input.val()) {
                //если пользователь ранее вводил пустое значение цвета
                if (data_ksn.errors.was_color_empty_input_error[id]) {
                    messege("green", "Цвет для настройки - '" + title_setting_text + "' введён верно =)"); //выводим сообщение что цвет введён верно
                    delete data_ksn.errors.was_color_empty_input_error[id];
                }
                //если пользователь ранее вводил пустое значение цвета
                title_setting.removeClass("pusto").addClass("zapolnena");
            } else {
                data_ksn.errors.was_color_empty_input_error[id] = "Задано пустое значение цвета, у настройки '" + title_setting_text + "'";
                messege("red", "Задано пустое значение цвета, у настройки - '" + title_setting_text + "'", false); //выводим безсрочное сообщение о том что поле цвето пустое
                title_setting.removeClass("zapolnena").addClass("pusto");
            }
            //прповеряем пусто ли значение инпута

            //делаем запрос на изменение крестика или галочки возле H2 текущего блока настроек только если данное поле ввода было оязательным для активации данной настройки
            if (input.hasClass("must_have_for_active")) {
                h2_check_active(settings_wrap);
            }
            //делаем запрос на изменение крестика или галочки возле H2 текущего блока настроек только если данное поле ввода было оязательным для активации данной настройки

            //проверяем отличается значение данного поля от значения в буфере и нет ли ошибки с пустым полем цвета
            if (data_ksn.all_inputs_data[id] !== input.val() && !data_ksn.errors.was_color_empty_input_error[id]) {
                input.addClass("chenge"); //помечаем что данное поле ввода было изменено
            } else {
                input.removeClass("chenge"); //убираем пометку о том что поле было изменено
            }
            //проверяем отличается значение данного поля от значения в буфере и нет ли ошибки с пустым полем цвета
        }
        //если не было ошибок

        //если была зафиксированна ошибка
        else {
            data_ksn.errors.was_color_input_error[id] = "Не верно введён код цвета, у настройки '" + title_setting_text + "'";
            messege("red", "Не верно введён код цвета, у настройки - '" + title_setting_text + "'", false); //выводим безсрочное сообщение о том что цвет введён с ошибкой
            input.removeClass("chenge"); //убираем пометку о том что поле было изменено
            title_setting.removeClass("zapolnena").addClass("pusto");
        }
        //если была зафиксированна ошибка

        h2_check_active(settings_wrap); //меням крестик/галоску возле заголовка h2 в данном блоке настроек
    }, 1000);
    //после секундной проверки мы уже точно занем есть ли ошибка или нет
};
//функция вызывается при каждом изменении в элементе управлении цветом

//функция проходит по всем полям ввода и записывает в буферный объект data_ksn все их значение в виде id : значение
function write_all_inputs_data($ = jQuery) {
    data_ksn.all_inputs_data = {}; //создаём объект в буфере для хранения значений полей
    let main_settings_wraper = $("#main_settings_wraper"),
        inputs = main_settings_wraper.find("input"),
        textareas = main_settings_wraper.find("textarea"),
        all_inputs = inputs.add(textareas);

    //перебираем все полля ввода
    all_inputs.each(function() {
        let input = $(this),
            id = input.attr("id"),
            type = input.attr("type");
        if (typeof id === "undefined") { return; } //если нет id  у данного поля ввода

        if (type === "checkbox") {
            var value = input.is(':checked') ? "yes" : "no";
        } else {
            var value = input.val();
        }
        data_ksn.all_inputs_data[id] = value; //записываем в буфер индетификатор и значение данного поля ввода    
    });
    //перебираем все полля ввода
}
//функция проходит по всем полям ввода и записывает в буферный объект data_ksn все их значение в виде id : значение

//обрабатываем события изменений в полях ввода, копировани, ввод текста, удаление текст и т.д.
function watch_chenge_all_inputs($ = jQuery) {
    let main_settings_wraper = $("#main_settings_wraper"),
        inputs = main_settings_wraper.find("input"),
        textareas = main_settings_wraper.find("textarea"),
        all_inputs = inputs.add(textareas);

    all_inputs.on("input", function(e) {
        let input = $(this),
            id = input.attr("id"),
            type = input.attr("type"),
            title = input.closest(".setting_blok").find(".title_setting"),
            settings_wrap = title.closest(".settings_wrap"); //верхний родительский элемент данной настройки

        input.off("blur"); //удаляем обработчик потери фокуса с данного инпута

        //для полей ввода цвета
        if (input.hasClass("wp-color-picker")) {
            input.removeClass("chenge"); //убираем пометку о том что поле было изменено
            color_input_check(input);
            return;
        }
        //для полей ввода цвета

        //для числовых полей
        if (type === "number") {
            let min = Number(input.attr("min")), //минимальное занчение
                max = Number(input.attr("max")); //максимальное занчение

            if (input.val() === "" && !isNaN(min)) { //если инпут пустой и есть минимальное значение
                input.on("blur", function() { input.val(min); }); //добавляем событие что при потери фокуса с данного инпута установить минимальное занчение
            } else if (!isNaN(min) && Number(input.val()) < min) { //если занчение инпута меньше минимального
                input.val(min); //устанавливаем занчение инпута в минимум
            } else if (!isNaN(max) && Number(input.val()) > max) { //если занчение инпута больше максимального
                input.val(max); //устанавливаем занчение инпута в максимум
            }
        }
        //для числовых полей

        $(e.target).val() ? title.removeClass("pusto").addClass("zapolnena") : title.removeClass("zapolnena").addClass("pusto"); //проверяем пусто содержимое поля ввода или нет

        //делаем запрос на изменение крестика или галочки возле H2 текущего блока настроек только если данное поле ввода было оязательным для активации данной настройки
        if (input.hasClass("must_have_for_active")) {
            h2_check_active(settings_wrap);
        }
        //делаем запрос на изменение крестика или галочки возле H2 текущего блока настроек только если данное поле ввода было оязательным для активации данной настройки

        //при потери фокуса с данного поля ввода проверяем отличаются ли новые данные поля ввода от сохранённых в буфере
        input.on("blur", function() {
            if (data_ksn.all_inputs_data[id] !== input.val()) { //если данные отличаются то добавляем данному полю ввода класс chenge
                input.addClass("chenge"); //помечаем что данное поле ввода было изменено
            } else {
                input.removeClass("chenge"); //убираем пометку о том что поле было изменено
            }
        });
        //при потери фокуса с данного поля ввода проверяем отличаются ли новые данные поля ввода от сохранённых в буфере


    });
}
//обрабатываем события изменений в полях ввода, копировани, ввод текста, удаление текст и т.д.

//обрабатываем клик по переключателю switch
function listener_click_all_switch($ = jQuery) {
    let main_settings_wraper = $("#main_settings_wraper"),
        all_switch = $("label.switch");

    all_switch.on("click touchend", function(e) {
        e.preventDefault();
        let setting_blok = $(this).closest(".setting_blok");
        //если переключатель сейчас заблокирован, скорее всего происходит обновление настроек, то вывести сообщение и остановить функцию
        if (setting_blok.hasClass("disable_input")) {
            messege("orange", "Подождите, настройки обновляются =)"); //выводим сообщения что нужно подождать
            return; //завершаем функцию
        }
        //если переключатель сейчас заблокирован, скорее всего происходит обновление настроек, то вывести сообщение и остановить функцию

        $(this).addClass("animate"); // нужно для анимации, чтоб она не начиналась автоматом при загрузке странице, а только при клеке
        let title = $(this).siblings(".title_setting"),
            input = $(this).children("input.switch_input");

        input.toggleClass("chenge"); //при каждом клике добавлем/убираем класс chenge чтоб понимать был ли данные переключатель изменён от сохранённых настроек

        //меняем крестик на галочку или наоборот в зависимости от checked даннаго input
        if (title.hasClass("zapolnena")) {
            input.prop('checked', false);
            title.removeClass("zapolnena").addClass("pusto");
        } else {
            input.prop('checked', true);
            title.removeClass("pusto").addClass("zapolnena")
        }
        //меняем крестик на галочку или наоборот в зависимости от checked даннаго input

        //делаем запрос на изменение крестика или галочки возле H2 текущего блока настроек только если данный переключатель был оязательным для активации данной настройки
        if (input.hasClass("must_have_for_active")) {
            let settings_wrap = title.closest(".settings_wrap"); //верхний родительский элемент данной настрйоки
            h2_check_active(settings_wrap);
        }
        //делаем запрос на изменение крестика или галочки возле H2 текущего блока настроек только если данный переключатель был оязательным для активации данной настройки
    });
}
//обрабатываем клик по переключателю switch

//клик по любому из полей ввода, выведет информационное сообщение когда нужно
function listener_click_all_inputs_and_textarea($ = jQuery) {
    let main_settings_wraper = $("#main_settings_wraper"),
        all_inputs_and_textarea = main_settings_wraper.find("input").add(main_settings_wraper.find("textarea")).filter(":not(.not_be_setting_for_save)");

    all_inputs_and_textarea.on("click touchend", function(e) {
        e.preventDefault();
        if ($(this).closest(".setting_blok").hasClass("disable_input")) {
            messege("orange", "Подождите, настройки обновляются =)"); //если кликнули по кнопке в мемент обновления выводим сообщения что нужно подождать
            return; //завершаем функцию
        }
    });
}
//клик по любому из полей ввода, выведет информационное сообщение когда нужно

//клик по любому из полей ввода цветов, выведет информационное сообщение когда нужно
function listener_click_all_color_wraper($ = jQuery) {
    let main_settings_wraper = $("#main_settings_wraper"),
        all_color_wraper = main_settings_wraper.find(".wp-picker-container"),
        buttons_default = main_settings_wraper.find(".wp-picker-default"); //кнопки выбора цвета по умолчанию

    all_color_wraper.on("click touchend", function(e) {
        e.preventDefault();
        if ($(this).closest(".setting_blok").hasClass("disable_input")) {
            messege("orange", "Подождите, настройки обновляются =)"); //если кликнули по кнопке в мемент обновления выводим сообщения что нужно подождать
            return; //завершаем функцию
        }
    });

    //клик по кнопке цвета по умолчанию, нужно чтоб обновлялись настройки
    buttons_default.on("click touchend", function(e) {
        e.preventDefault();
        let input = $(this).closest(".setting_blok").find("input.wp-color-picker");
        color_input_check(input);
    });
    //клик по кнопке цвета по умолчанию, нужно чтоб обновлялись настройки
}
//клик по любому из полей ввода цветов, выведет информационное сообщение когда нужно

//функция отвечает за включение и отключения полей ввода
//elements - поля ввода и другие инпуты которые нужно отключить или включить
//action - что нужно сделать включить/выключить
function inputs_disable_chenge(elements, action, $ = jQuery) {
    elements.each(function() {
        let input = $(this),
            setting_blok = input.closest(".setting_blok"),
            check_for_color_picker = setting_blok.find(".wp-picker-container").length, //проверяем есть ли эта настройка контролер с выбором цвета
            check_for_switch_input = setting_blok.find("input.switch_input").length; //проверяем есть ли эта настройка переключатель

        if (action == "disable") {
            setting_blok.addClass("disable_input"); //отключаем данную настройку
            !check_for_switch_input ? input.attr("readonly", true) : null; //блокируем все поля ввода, textarea, текствый инпуты и т.д
            check_for_color_picker ? setting_blok.find("button.button").attr("disabled", "disabled") : null; //отключаем возможность выбора цвета
        } else if (action == "enabled") {
            setting_blok.removeClass("disable_input"); //включаем данную настройку
            !check_for_switch_input ? input.attr("readonly", false) : null; //разблокируем все поля ввода, textarea, текствый инпуты и т.д
            check_for_color_picker ? setting_blok.find("button.button").removeAttr("disabled") : null; //включаем возможность выбора цвета
        }
    });
};
//функция отвечает за включение и отключения полей ввода

//скролл вверх, проверяем покрутку страници и показываем кнопку вверх, а так же прокурчиваем страницу вверх при клеке по кнопке вверх
function listener_scroll_button($ = jQuery) {
    let scrollup = $("#scrollup");
    $(window).scroll(function() {
        if ($(this).scrollTop() > 500) {
            scrollup.addClass("show").removeClass("hide");
        } else {
            scrollup.addClass("hide").removeClass("show");
        }
    });
    scrollup.on("click touchend", function() {
        $("html, body").animate({ scrollTop: 0 }, 700);
        return false;
    });
}


//скролл вверх, проверяем покрутку страници и показываем кнопку вверх, а так же прокурчиваем страницу вверх при клеке по кнопке вверх