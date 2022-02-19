//ВАЖНО: нужно использовать имеено touchend, т.к. touchstart вызывает ошибки если элементы разположенны близко друг к другу

//ПРИМЕЧАНИЕ: $(window).width() - это ширина страницы без учёта скролбара (не путать с шириной экрана window.screen.width); $(window).height() - это высота страницы (не путать с высотой экрана window.screen.height);

//ПРИМЕЧАНИЕ: для того чтоб событие ресайз корректно обрабатывалось при разработке, в браузере выставляем модель телефона и ставим везде масштаб 100%, так не будут вызываться лишние резайзы (двойное срабатываие зачастую связанно с срабатыванием scroll для данного слушателя)

//ВАЖНО: event_listener_for_element это кастомный обработчик событий, он привязыает события к объекты jQuery
//event - массив событий которые нужно прослушивать на элементе, пример: ["touchend","click","resize"]
//element - объект jquery, пример: element = $("#touch_menu>.touch_menu_wrapper") или массив элементов
//callback - функция которую нужно вызвать при срабатывании события из миссива event, можно указать название функции, пример: touch_menu_open_close ; или указать функцию, пример: function(){console.log("Выполняем что-то, при срабатывании события из массива event")}
//options_event - сюда нужно передать объект с обциями для данного слушателя
//add_or_remove - если true то добавляет слушателя, если false то удаляет слушателя события для element
data_site.event_listener_for_element = function(add_or_remove, event, element, callback, options_event) {
    //для всех браузеров кроме Internet Explorer
    if (!document.documentMode) {
        for (let ev = 0; ev < event.length; ev++) { //перебираем события event 
            for (let i = 0; i < element.length; i++) { //перебираем массив с элементами element
                //добавляем слушатель для каждого элемента в объекте element[i]
                for (let index = 0; index < element[i].length; index++) { //перебираем каждый element[i]
                    if (add_or_remove) { //если add_or_remove = true то добавляем слушатель для element[i][index]
                        element[i][index].addEventListener(event[ev], callback, options_event);
                    } else { //если add_or_remove = false то удаляем слушатель для element[i][index]
                        element[i][index].removeEventListener(event[ev], callback);
                    }

                }
            }
        }
    }
    //для всех браузеров кроме Internet Explorer

    //для браузера Internet Explorer, так как он не поддерживает параметр options для addEventListener
    else {
        for (let ev_ie = 0; ev_ie < event.length; ev_ie++) { //перебираем события event 
            for (let i_ie = 0; i_ie < element.length; i_ie++) { //перебираем элементы element
                //добавляем слушатель для каждого элемента в объекте element
                for (let index_ie = 0; index_ie < element[i_ie].length; index_ie++) { //перебираем каждый element[i_ie]
                    if (add_or_remove) { //если add_or_remove = true то добавляем слушатель для element[i_ie][index_ie]
                        element[i_ie][index_ie].addEventListener(event[ev_ie], callback);
                    } else { //если add_or_remove = false то удаляем слушатель для element[i_ie][index_ie]
                        element[i_ie][index_ie].removeEventListener(event[ev_ie], callback);
                    }
                }
            }
        }
    }
    //для браузера Internet Explorer, так как он не поддерживает параметр options для addEventListener
}

//ВАЖНО: это кастомный обработчик событий, он привязыает события к объекты jquery

//
//
//запускается после полной загрузки DOM страницы, т.е. DOMContentLoaded произошло. ($(document).ready(function(){}))
//
//
$(document).ready(function() {
    //
    //
    //ОТЛОЖЕННАЯ ЗАГРУЗКА MEDIA
    //
    //
    let imges = $("img[data-type='img_content']"), //все картинки и svg иконки контента
        img_maket = $("img[data-type='img_maket']"), //все svg иконки и картинки которые являются только элементами макета, для них просто подставить data-src в src
        video = $(".block_video .video_wrapper .video_ytube"), //все видео
        maps = $(".block_map .map_wrapper .map_fpame"), //все карты
        insta_gallerys = $(".instagram_img_sektion .instagram_img"), // все инстаграмм галереи
        text_img_error = ". Приносим извинения, но увы изображение не удалось загрузить. Попробуйте обновить страницу. Будьте на позитиве =)", //то что дописываем к alt изображения в случае ошибки загрузки
        massiv_size = ["0", "300", "400", "500", "600", "700", "800", "900", "1000", "1100", "1200", "1300", "1400", "1600", "1800",
            "2000", "2500", "3000", "4000", "5000", "6000", "7000", "8000" //23 штуки, это все возможные ширины экранов
        ];


    data_site.win_width = $(window).width();
    data_site.win_height = $(window).height();

    //записываем стартовую ориентацию в момент загрузки страницы
    if ($(window).width() >= $(window).height()) {
        data_site.started_orientation = "gor_orient"; //горизонтальная ориентация экрана (альбомная)
    } else {
        data_site.started_orientation = "ver_orient"; //вертикальная ориентация экрана (книжная)
    }
    //записываем стартовую ориентацию в момент загрузки страницы

    data_site.orientation_chenge = false;
    data_site.check_orient = function check_orient(width, height) {
        //горизонтальная ориентация экрана (альбомная)
        if (width >= height) {
            data_site.orientation = "gor_orient";
        }
        //горизонтальная ориентация экрана (альбомная)

        //вертикальная ориентация экрана (книжная)
        else {
            data_site.orientation = "ver_orient";
        }
        //вертикальная ориентация экрана (книжная)

        //помечаем что произошла смена ориентации впервые, только если ориентация после ресайза не равна стартовой ориентации
        if (!data_site.orientation_chenge) {
            if (data_site.started_orientation != data_site.orientation) {
                data_site.orientation_chenge = true;
            }
        }
        //помечаем что произошла смена ориентации впервые, только если ориентация после ресайза не равна стартовой ориентации
    };

    data_site.check_orient(data_site.win_width, data_site.win_height); //вычисляем и записываем в объект data_site значение orientation

    data_site.media_data = {
        images: {
            gor_orient: [],
            ver_orient: [],
            skritie: [],
            skritie_check: false,
            schetchiki: {
                kolichestvo: 0,
                gor_orient: {
                    load: 0
                },
                ver_orient: {
                    load: 0
                }
            }
        },
        maps: {
            maps: [],
            skritie: [],
            skritie_check: false,
            schetchiki: {
                kolichestvo: 0,
                load: 0
            }
        },
        video: {
            video: [],
            skritie: [],
            skritie_check: false,
            schetchiki: {
                kolichestvo: 0,
                load: 0
            }
        },
        insta_gallery: {
            widgets: [],
            script: {
                insta_script: document.querySelector("script#elfsight-instagram-feed-js"),
                add_insta_script: false,
                load_insta_script: false,
                error: false
            },
            skritie: [],
            skritie_check: false,
            schetchiki: {
                kolichestvo: 0,
                load: 0
            }
        }
    };

    //при каждом ресайзе вычисляем новое заначение orientation, а так же получаем актуальные значения ширины и высоты окна браузера
    data_site.event_listener_for_element(true, ["resize"], [$(window)], function() {
        data_site.win_width = $(window).width(); //перезаписываем в объект data_site новое заначение ширины
        data_site.win_height = $(window).height(); //перезаписываем в объект data_site новое заначение высоты
        data_site.check_orient(data_site.win_width, data_site.win_height); //перезаписываем в объект data_site новое заначение ориентации orientation
    }, { passive: true });
    //при каждом ресайзе вычисляем новое заначение orientation, а так же получаем актуальные значения ширины и высоты окна браузера

    /*
    $(document).on("click touchend", function() {
        console.log(data_site);
    });
    */


    //обрабатываем ошибку при загрузке картинки
    data_site.img_erroe_load = function() {
        let img = $(this),
            src = img.attr("src"),
            data_src = img.attr("data-src"),
            original_w = Number(img.attr("data-original-w")), //ширина оригинала картинки
            original_h = Number(img.attr("data-original-h")); //высота оригинала картинки
        //если недоступны миниатюры картинки , перебор вверх по размерам
        if (src != data_src) {
            let format = data_src.split(".").pop(), //формат картинки , например jpg
                filname = data_src.split("/").pop().split(".").shift(), //название файла картинки, например 500x518
                url = data_src.replace(filname + "." + format, ""), //адрес дериктории где лежик картинка, например /wp-content/uploads/2021/02/
                size = src.split("/").pop().split("-").pop().split("x").shift(), //ширина картикни, например для файла 2-1-500x518.jpg это будет 500
                index = massiv_size.indexOf(size), //получаем под каким индексом в massiv_size лижит наш size картинки
                data_height = Math.round((original_h * Number(massiv_size[index + 1])) / original_w); //высота картинки
            //пока ширина миниатюры картинки меньше оригинальной ширины картинки
            if (size < original_w) {
                let url_new = url + filname + "-" + massiv_size[index + 1] + "x" + data_height + "." + format; //генерируем url миниатюры на 1 порядок больше
                img.attr("src", url_new); //подставляем новую миниатюру
            }
            //пока ширина миниатюры картинки меньше оригинальной ширины картинки

            //если больше то подставляем оригинал картинки
            else {
                img.attr("src", data_src);
            }
            //если больше то подставляем оригинал картинки
        }
        //если недоступны миниатюры картинки , перебор вверх по размерам

        //если недоступен даже оригинал картинки
        else {
            let alt_defult = img.attr("alt"),
                alt = alt_defult.replace(text_img_error, ""),
                img_wrapper = img.parent(".img_wrapper"),
                new_alt = alt + text_img_error; //добаляем к alt картинки текст сообщающий об ошибке загрузки картинки
            img.attr("alt", new_alt); //заполняем alt картинки с сообщением об ошибке загрузки

            //для картинок для которых явно задан атрибут width
            if (img.attr("width")) {
                var win_width = document.body.clientWidth,
                    img_width = Math.ceil(window.screen.width + img[0].offsetLeft * 2),
                    height = Number((img_width / 100) * ((original_h / original_w) * 100)); //высота которую должна занимать картинка в макете
            }
            //для картинок для которых явно задан атрибут width
            else {
                var height = Number((img.width() / 100) * ((original_h / original_w) * 100)); //высота которую должна занимать картинка в макете
            }

            img_wrapper.addClass("error_load");
            img_wrapper.css({ "height": height + "px", "transition": "height 0.5s linear" }); //задаём явно высоту чтоб её можно было анимировать с помощью transition, в случае если высота картинки т.е. блока с текстом alt больше чем высота которя зарезервированная для данной картинки в макете

            //меняем высоту прямого родителя картинки при необходимости
            img_error_height = function() {
                if (img.attr("width")) {
                    var win_width = document.body.clientWidth,
                        img_h = img.height(), //высота картинки, т.е. блока занятого текстом alt
                        width = Math.ceil(window.screen.width + img[0].offsetLeft * 2),
                        height = Number((width / 100) * ((original_h / original_w) * 100)); //высота которую должна занимать картинка в макете
                } else {
                    var img_h = img.height(), //высота картинки, т.е. блока занятого текстом alt
                        width = img.width(), //ширина картинки
                        height = Number((width / 100) * ((original_h / original_w) * 100)); //высота которую должна занимать картинка в макете 
                }



                //если это не первый раз когда пользователь видит сообщение про ошибку загрузки
                if (img_wrapper.hasClass("first_error")) {
                    //если высота картинки, т.е. высота блока с текстом alt больше или равна высоте зарезервированной в макете под картинку
                    if (height <= img_h) {
                        img_wrapper.css({ "height": img_h + "px", "transition": "" }); //назначаем прямому родителю картинки высоту картинки, т.е. высоту блока с текстом alt
                    }
                    //если высота картинки, т.е. высота блока с текстом alt больше или равна высоте зарезервированной в макете под картинку

                    //если высота картинки, т.е. высота блока с текстом alt меньше чем высота зарезервированная в макете под картинку
                    else {
                        img_wrapper.css({ "height": height + "px", "transition": "" }); //назначаем прямому родителю высоту которая зарезервированна под данную картинку в макете
                    }
                    //если высота картинки, т.е. высота блока с текстом alt меньше чем высота зарезервированная в макете под картинку
                }
                //если это не первый раз когда пользователь видит сообщение про ошибку загрузки

                //если это первый раз когда пользователь видит сообщение про ошибку загрузки, мы анимируем высоту прямого родителя кратинки если нужно
                else {
                    //если высота картинки, т.е. высота блока с текстом alt больше или равна высоте зарезервированной в макете под картинку
                    if (height <= img_h) {
                        img_wrapper.css({ "height": img_h + "px" }); //назначаем прямому родителю картинки высоту картинки, т.е. высоту блока с текстом alt
                    }
                    //если высота картинки, т.е. высота блока с текстом alt больше или равна высоте зарезервированной в макете под картинку

                    //если высота картинки, т.е. высота блока с текстом alt меньше чем высота зарезервированная в макете под картинку
                    else {
                        img_wrapper.css({ "height": height + "px" }); //назначаем прямому родителю высоту которая зарезервированна под данную картинку в макете
                    }
                    //если высота картинки, т.е. высота блока с текстом alt меньше чем высота зарезервированная в макете под картинку

                    img_wrapper.addClass("first_error"); //помечаем что плавная анимациия уже была выполнена, т.е. пользовательл уже 1 раз увидел это сообщение
                }
                //если это первый раз когда пользователь видит сообщение про ошибку загрузки, мы анимируем высоту прямого родителя кратинки если нужно
            };
            img_error_height();
            //меняем высоту прямого родителя картинки при необходимости

            //меняем высоту прямого родителя картинки при ресайзе
            data_site.event_listener_for_element(true, ["resize"], [$(window)], img_error_height, { passive: true });
            //меняем высоту прямого родителя картинки при ресайзе
        }
        //если недоступен даже оригинал картинки
    };
    //обрабатываем ошибку при загрузке картинки






    //успешная загрузка картинки img_maket
    img_maket.on("load", function() {
        $(this).parent().addClass("loaded"); //в случае успеха добавляем прямому родитею img_maket класс loaded
    });
    //успешная загрузка картинки img_maket

    img_maket.on("error", function() {}); //ошибка загрузки картинки img_maket

    //успешная загрузка картинки imges
    imges.on("load", function() {
        let imges = $(this);
        imges.parent().addClass("loaded"); //если картинка успешно загрузилась то прямому родителю картинки добавляем класс loaded
        setTimeout(function() {
            imges.siblings(".media_loader").remove(); //удяляем лоадер
        }, 1500);
    });
    //успешная загрузка картинки imges

    imges.on("error", data_site.img_erroe_load); //ошибка загрузки картинки imges




    /*$(document).on("click touchend", function(e) {
        e.preventDefault();
        console.log(data_site);
        //console.log(data_site.kartinki.load_gorisontal + " = " + data_site.kartinki.kolichestvo + " && " + data_site.kartinki.load_vertikal + " = " + data_site.kartinki.kolichestvo);
    });*/

    //вставляем закоментированный iframe в конец родительского блока
    data_site.iframe_dekoder = function(media, media_type) {
        if (media.hasClass("dobavleno")) { return };
        coment = media.contents(); //закоментированый код iftame
        media.addClass("dobavleno");
        coment.filter(function() {
            this.nodeType === 8 ? media.append(this.nodeValue) : null; //убеждаемся что там именно коментарий и вставляем в этот блок содержимое коментария, т.е. iframe
        });

        //удаляем декодированное media из массива для декодирования и увеличиваем на 1 количество загруженных media
        let index = data_site.media_data[media_type][media_type].indexOf(media[0]);
        data_site.media_data[media_type][media_type].splice(index, 1);
        data_site.media_data[media_type].schetchiki.load += 1;
        //удаляем декодированное media из массива для декодирования и увеличиваем на 1 количество загруженных media

        //если ранее эта media была в списке скрытых то удаляем её и от туда
        let skritie_media = data_site.media_data[media_type].skritie,
            skritie_index = skritie_media.indexOf(media[0]);
        if (skritie_index != -1) {
            skritie_media.splice(skritie_index, 1);
        }
        //если ранее эта media была в списке скрытых то удаляем её и от туда

        let iframe = media.find("iframe"); //iframe с media
        iframe.removeAttr("width height"); //удаляем ненужные атрибуты

        if (media_type == "video") {
            let old_src = iframe.attr("src"),
                new_src = old_src + "?rel=0";
            iframe.attr("src", new_src);
        }

        //после загрузки или ошибки загрузки iframe меняем его прозрачность, т.е. показываем его
        iframe.on("load error", function() {
            let iframe = $(this);
            iframe.css("opacity", "1");
            setTimeout(function() {
                iframe.closest(".dobavleno").siblings(".media_loader").remove(); //удяляем лоадер
            }, 1500);
        });
        //после загрузки или ошибки загрузки iframe меняем его прозрачность, т.е. показываем его
    };
    //вставляем закоментированный iframe в конец родительского блока



    //определяем ширину миниатюры, с учётом плотности пикселей устройства
    data_site.define_img_dpr_width = function(img) {
        let win_width = $(window).width(), //ширина страницы (ширина окна браузера)
            win_width_dpr = Math.ceil(win_width * data_site.dpr), //ширина экрана с учётом плотности пикселей, к примеру dpr = 2, win_width = 1368, тогда win_width_dpr = 2736 px
            data_url = img.attr("data-src"), //src оригина картинки
            original_w = Number(img.attr("data-original-w")), //ширина оригинальной картинки
            original_h = Number(img.attr("data-original-h")), //высота оригинальной картинки
            format = data_url.split(".").pop(), //получаем формат картинки, например jpg
            data_url_bez_f = data_url.replace("." + format, ""); //url отигинальной картинки картинки без её формата, например /wp-content/uploads/2021/03/1-2

        //если для картинки явно задана ширина через атрибут width то нужно использовать именно её значение для расчётатов требуемой ширины миниатюры!
        if (img.attr("width")) {
            img_width = Number(img.attr("width"));
        }
        //если для картинки явно задана ширина через атрибут width то нужно использовать именно её значение для расчётатов требуемой ширины миниатюры!

        //если не задан атрибут width, значит используем .width() для определения ширины картинки
        else {
            img_width = Math.ceil(img.width()); //получаем ширину картинки с точностью до 1 пикселя
        }
        //если не задан атрибут width, значит используем .width() для определения ширины картинки

        img_dpr_width = Math.ceil(img_width * data_site.dpr); //точная требуемая ширина картинки с учётом плотности пиксилей, с точностью до 1 пикселя

        //ПРИМЕЧАНИЕ: далее везде будет ипользоваться запрашиваемые данные для картинки С УЧЁТОМ ПЛОТНОСТИ ПИКСЕЛЕЙ! т.е. для img_dpr_width ширины картинки

        //для ширины экрана 8000 включительно и меньше, т.к. максимальная зарегистрированная миниатюра имеет ширину в 8000 пикселей
        if (win_width <= 8000) {
            //перебираем массив с доступными ширинами миниатюр massiv_size, чтоб определить какая миниатюра будет оптимальная для данной картинки
            for (let i = 1; i < 22; i++) {
                //ПРИМЕЧАНИЕ: (img_dpr_width - img_dpr_width * 0.03) это 3% погрешности, т.е. мы подбираем зарегистрированне большие ширины миниатюры для картинки на 3% уже той что у нас есть, это сделано чтоб избежать того что когда наш img_dpr_width = 2519, к примеру, мы подставляем миниатюру из massiv_size в 3000, а с погрешностью мы подставим 2500, для пользователя качество не заметна, а вот размер загружаемого файла уменьшиться
                if (img_dpr_width > massiv_size[i] && (img_dpr_width - img_dpr_width * 0.03) <= massiv_size[i + 1]) {
                    data_miniatura_width = Number(massiv_size[i + 1]); //ширина оптимальной миниатюры
                    break; //прерываем цикл когда нашли подходящую ширину миниатюры
                }
            }
            //перебираем массив с доступными ширинами миниатюр massiv_size, чтоб определить какая миниатюра будет оптимальная для данной картинки
        }
        //для ширины экрана 8000 включительно и меньше, т.к. максимальная зарегистрированная миниатюра имеет ширину в 8000 пикселей

        //для ширины экрана свыше 8000
        else {
            data_miniatura_width = 99999; //ширина миниатюры картинки которую мы будем запрашивать 99999, т.е. мы запрашиваем оригинал картинки,т.к. миниатюр более 8000 px, пока не предусмотренно
        }
        //для ширины экрана свыше 8000

        //если ширина запрашиваемой миниатюры больше или равна ширине картинки оригинала, то в src будет подставлен оригинал картинки
        if (data_miniatura_width >= original_w) {
            url = data_url;
        }
        //если ширина запрашиваемой миниатюры больше или равна ширине картинки оригинала, то в src будет подставлен оригинал картинки

        //если ширина запрашиваемой миниатюры меньше ширины оригинальной картинки, то в src подставляем оптимальную миниатюру
        else if (data_miniatura_width < original_w) {
            data_miniatura_height = Math.round((original_h * data_miniatura_width) / original_w); //используя пропорцию получаем высоту запрашиваемой миниатюры
            url = data_url_bez_f + "-" + data_miniatura_width + "x" + data_miniatura_height + "." + format; //wp-content/uploads/2021/03/1-2-2000x702.jpg к примеру
        }
        //если ширина запрашиваемой миниатюры меньше ширины оригинальной картинки, то в src подставляем оптимальную миниатюру
    };
    //определяем ширину миниатюры, с учётом плотности пикселей устройства



    //начальное декодирование заменяем src пустышку на нормальный url
    data_site.dekoder_started = function(img, orientation) {
        let gor_img_mas = data_site.media_data.images.gor_orient,
            ver_img_mas = data_site.media_data.images.ver_orient,
            skritie_img = data_site.media_data.images.skritie,
            data_type = img.attr("data-type"),
            format = img.attr("data-src").split(".").pop(); //получаем формат картинки, например jpg или svg
        //для svg картинки просто подставляем в src значение data-src
        if (format == "svg" || data_type == "img_maket") {
            img.attr("src", img.attr("data-src")); //подставляем полученный нами url в src атрибут данной картинки
            img.parent().addClass("dekoder_max"); //помечаем данную картинку как окончательно декодированную

            //для svg картинок нет миниатюр поэтому мы при её первичном декодированиии назанчаем её прямому родителю класс dekoder_max и удаляем эту картинку из массивов, горизонтальных и вертикальных ориентаций, очереди на декодирование картинок, и увеличиваем на 1 счётчик декодированных картинок горизонтальной и вертикальной ориентаций
            let index_gor = gor_img_mas.indexOf(img[0]); //получаем индекс элемента картинки в масииве для г.о.
            gor_img_mas.splice(index_gor, 1); //удаляем картинку из очереди на обработку горизонтальных картинок
            let index_ver = ver_img_mas.indexOf(img[0]); //получаем индекс элемента картинки в масииве для в.о.
            ver_img_mas.splice(index_ver, 1); //удаляем картинку из очереди на обработку вертикальных картинок

            //ВАЖНО ПРИМЕЧАНИЕ: data_site.media_data.images.schetchiki.gor_orient.load нельзя записывать в переменную, а потом пытаться делать что-то типа data_site.media_data.images.schetchiki.gor_orient.load += 1 , т.к. будет увеличиваться значение локальной переменной, а в объект ничего нового записываться не будет, это ВАЖНО!
            data_site.media_data.images.schetchiki.gor_orient.load += 1; //увеличиваем на 1 количество загруженных картинок вертикальной ориентации
            data_site.media_data.images.schetchiki.ver_orient.load += 1; //увеличиваем на 1 количество загруженных картинок горизонтальной ориентации
            //для svg картинок нет миниатюр поэтому мы при её первичном декодированиии назанчаем её прямому родителю класс dekoder_max и удаляем эту картинку из массивов, горизонтальных и вертикальных ориентаций, очереди на декодирование картинок, и увеличиваем на 1 счётчик декодированных картинок горизонтальной и вертикальной ориентаций;

            //если ранее эта картинка была в списке скрытых то удаляем её и от туда
            let skritie_index = skritie_img.indexOf(img[0]);
            if (skritie_index != -1) {
                skritie_img.splice(skritie_index, 1);
            }
            //если ранее эта картинка была в списке скрытых то удаляем её и от туда
        }
        //для svg картинки просто подставляем в src значение data-src

        //если картинка НЕ svg
        else {
            data_site.define_img_dpr_width(img); //определяем ширину миниатюры, с учётом плотности пикселей устройства
            img.attr("src", url); //подставляем полученный нами url в src атрибут данной картинки
            img.parent().addClass("dekoder"); //помечаем данную картинку как декодированную


            let index = data_site.media_data.images[orientation].indexOf(img[0]); //получаем индекс элемента картинки в масииве для текущей orientation
            data_site.media_data.images[orientation].splice(index, 1); //удаляем картинку из очереди на обработку текущей orientation картинок
            data_site.media_data.images.schetchiki[orientation].load += 1; //увеличиваем на 1 количество загруженных картинок текущей orientation

            //если ранее эта картинка была в списке скрытых то удаляем её от туда
            let skritie_index = skritie_img.indexOf(img[0]);
            if (skritie_index != -1) {
                skritie_img.splice(skritie_index, 1);
            }
            //если ранее эта картинка была в списке скрытых то удаляем её от туда
        }
        //если картинка НЕ svg
    };
    //начальное декодирование заменяем src пустышку на нормальный url




    //окончательно декодирование, получаем максимально допустимую ширину миниатюры и отключаем картинку от дальнейшей обработки, т.к. макс миниатюра уже загружена
    data_site.dekoder_finish = function(img, orientation) {
        //т.к. какртинка ранее была 100% декодированна, т.к. есть класс dekoder, мы можем получить её текущий src
        let img_width_now = Number(img.attr("src").split("/").pop().split("-").pop().split("x").shift()); //текущая ширина миниатюры картинки
        //т.к. какртинка ранее была 100% декодированна, т.к. есть класс dekoder, мы можем получить её текущий src

        data_site.define_img_dpr_width(img); //определяем ширину миниатюры, с учётом плотности пикселей устройства

        //если картинка которую мы хотим подставить шире ныненшней, то мы подставляем большую картинку в src, если меньше то оставляем прежнюю
        if (img_width_now < data_miniatura_width) {
            img.attr("src", url);
        }
        //если картинка которую мы хотим подставить шире ныненшней, то мы подставляем большую картинку в src, если меньше то оставляем прежнюю

        img.parent().removeClass("dekoder"); //удаляем у прямого родителя картинки класс dekoder
        img.parent().addClass("dekoder_max"); //помечаем данную картинку как окончательно декодированную, добавив прямому родителю класс dekoder_max

        //ПРИМЕЧАНИЕ: тут мы окончательно удаляем картинку из очереди декодиролвания массивов обеих ориентаций. По скольку функция dekoder_finish может быть вызвана только в случае если у прямого родителя картинки есть класс dekoder, а в одной и тойже ориентации этого произойти не может т.к. как кртинка сразу удаляется из массива декодирования данной ориентации, вот и получается что функция dekoder_finish может быть вызванна исключитель после ресайза (когда ширина и высота экрана поменяют значения местами). По этому мы и можем быть уверены что картинка точно удалена из предыдущей ориентации и можно смело определять максимальную миниатюру картинки помечать её прямого родителя как dekoder_max и удалять картинку из очереди декодирования оставшейся ориентации. Т.е. картинка будет полностью удалена из очереди декодирования массивов обоих ориентаций
        let index = data_site.media_data.images[orientation].indexOf(img[0]); //получаем индекс элемента картинки в масииве для текущей orientation
        data_site.media_data.images[orientation].splice(index, 1); //удаляем картинку из очереди на обработку текущей orientation картинок
        data_site.media_data.images.schetchiki[orientation].load += 1; //увеличиваем на 1 количество загруженных картинок текущей orientation
    };
    //окончательно декодирование, получаем максимально допустимую ширину миниатюры и отключаем картинку от дальнейшей обработки, т.к. макс миниатюра уже загружена


    //функия загрузки инстаграм галереи
    data_site.insta_gallery_dekoder = function(media, insta_settings_obj) {

        //добавляем div с настройками галереи и вызываем добавление галереи только после полной загрузки скрипта галереи
        insta_append = function() {
            let id = insta_settings_obj.id, //id виджета
                insta_wrap = $(insta_settings_obj.insta_wrap), //облочка instagram_img виджета
                options = insta_settings_obj.options, //options виджета
                version = insta_settings_obj.version, //version виджета
                div_insta = document.createElement("div"); //создаём элемент в котором будет постороена галерея

            //добавляем к оболочке галереи все необходимые атрибуты
            div_insta.setAttribute("class", "elfsight-widget-instagram-feed elfsight-widget");
            div_insta.setAttribute("data-elfsight-instagram-feed-options", options);
            div_insta.setAttribute("data-elfsight-instagram-feed-version", version);
            div_insta.setAttribute("data-elfsight-widget-id", id);
            //добавляем к оболочке галереи все необходимые атрибуты

            insta_wrap.append(div_insta); //добавляем наш созданый div в котором будет строится галерея в оболочку instagram_img текущего виджета
            insta_wrap.addClass("insta_naydena"); //помечаем блок галереи как insta_naydena чтоб больше его не обрабатывать при скроле

            let decode_options = JSON.parse(decodeURIComponent(options)); //декодируем параметры options
            window.eappsInstagramFeed(div_insta, decode_options); //вызываем функцию eappsInstagramFeed для постороения текущей галереи
            div_insta.removeAttribute("data-elfsight-instagram-feed-options"); //удаляем уже ненужный атрибут
            div_insta.removeAttribute("data-elfsight-instagram-feed-version"); //удаляем уже ненужный атрибут
            data_site.media_data.insta_gallery.schetchiki.load += 1; //увеличиваем количество загруженных галерей на 1

            //если ранее эта media была в списке скрытых то удаляем её и от туда
            let skritie_media = data_site.media_data.insta_gallery.skritie,
                skritie_index = skritie_media.indexOf(media[0]);
            if (skritie_index != -1) {
                skritie_media.splice(skritie_index, 1);
            }
            //если ранее эта media была в списке скрытых то удаляем её и от туда

            //настройки отслеживания изменений в instagram_img блоке
            let mutation_options = {
                    childList: true, //следим за добавлением и удаление дочерних элементов
                    subtree: true //следим за измением стояния всех потомков элемента
                },
                //настройки отслеживания изменений в instagram_img блоке

                //функция которая отслежвивает измения в instagram_img (insta_wrap) оболочке галеи и всех её дочерних элементах, чтоб поймать момент появления в ней картинок, и привязать обработчик к моменту загрузки первой картинки
                observer = new MutationObserver(function() {
                    let img_insta = insta_wrap.find("img.eapps-instagram-feed-posts-item-image"); //получаем список всех картинок галереи, когда они обнаружены

                    img_insta_load = function() {
                        observer.disconnect(); //цель достигнута останавливаем наблюдение за элементом
                        let instagram_img_sektion = insta_wrap.closest(".instagram_img_sektion"), //находим родительскую instagram_img_sektion
                            inasta_l_more_button = insta_wrap.find(".eapps-instagram-feed-posts-grid-load-more-text.eapps-instagram-feed-posts-grid-load-more-text-visible");
                        instagram_img_sektion.addClass("insta_active"); //добавляем класс insta_active к instagram_img_sektion для того чтоб скрыть лоадер
                        inasta_l_more_button.html("Загрузить ещё картинки"); //меняем стандартынй текст "Загрузить ещё" на "Загрузить ещё картинки"
                        instagram_img_sektion.css({ "padding-top": "" }); //убираем у instagram_img_sektion свойство padding-top которе задавала функция insta_prop_size, чтоб избежать скачка макета, а сейчас он нам ненужен так как будет препятсятвовать показу других картинок галереии, которые будт загржены после нажатия кнопки "Загрузить ещё картинки"
                        insta_wrap.addClass("gotova"); //добавляем класс gotova к instagram_img оболочке текущей галереи для того чтоб плавно её показать
                        data_site.event_listener_for_element(false, ["load"], [img_insta], img_insta_load); //как только одна из картинок успешно загрузилась можно удалять слушатель события загрузки для других картинок
                        setTimeout(function() {
                            insta_wrap.siblings(".media_loader").remove(); //удяляем лоадер
                        }, 1500);
                    };

                    //выполняем функцию только если картинки img_insta обнаружены в сруктуре DOM элемента instagram_img
                    if (img_insta.length > 0) {
                        //вызваем единожды при загрузке img_insta картинки
                        data_site.event_listener_for_element(true, ["load"], [img_insta], img_insta_load);
                        //вызваем единожды при загрузке img_insta картинки
                    }
                    //выполняем функцию только если картинки img_insta обнаружены в сруктуре DOM элемента instagram_img
                });
            observer.observe(insta_wrap[0], mutation_options);
            //функция которая отслежвивает измения в instagram_img (insta_wrap) оболочке галеи и всех её дочерних элементах, чтоб поймать момент появления в ней картинок, и привязать обработчик к моменту загрузки первой картинки
        };
        //добавляем div с настройками галереи и вызываем добавление галереи только после полной загрузки скрипта галереи

        //проверяем, если скрипт ранее был успешно загружен то сразу начинаем выполнять функцию insta_append
        if (data_site.media_data.insta_gallery.script.load_insta_script) {
            insta_append();
        }
        //проверяем, если скрипт ранее был успешно загружен то сразу начинаем выполнять функцию insta_append

        //проверям был ли добалени скрипт инстаграм галереи, если нет то заменяем его data-src на src
        if (!data_site.media_data.insta_gallery.script.add_insta_script) {
            let script = data_site.media_data.insta_gallery.script.insta_script, //получаем DOM элемент скрипта
                script_data_src = script.getAttribute("data-src"); //получаем data-src скрипта в котором находится url скрипта
            script.setAttribute("src", script_data_src); //подсатвляем url скрипта в src, чтоб он начал загружаться
            script.removeAttribute("data-src"); //удаляем уже ненужный атрибут
            data_site.media_data.insta_gallery.script.add_insta_script = true; //записываем что скрипт был добавлен на страницу

            //пока скрипт не сообщил об успешной загрузке или ошибке загрузки ожидаем
            let loaded_script = new Promise(function(resolve, reject) {
                //успешная загрузка скрипта
                $(script).on("load", function() {
                    resolve();
                });
                //успешная загрузка скрипта

                //если при загрузке файла скрипта произошла ошибка то в объекте галереи сообщаем об этом
                $(script).on("error", function() {
                    reject();
                });
                //если при загрузке файла скрипта произошла ошибка то в объекте галереи сообщаем об этом
            });
            //пока скрипт не сообщил об успешной загрузке или ошибке загрузки ожидаем

            //в зависимости от того успешно загрузился скрипт или была ошибка загрузки выполняем соответсвующие действия
            loaded_script.then(function() {
                //console.log("load");
                data_site.media_data.insta_gallery.script.load_insta_script = true; //помечаем что скрипт был успешно загружен
                insta_append(); //т.к. скрипт загружен его методы теперь доступны и можно смело вызывать функцию insta_append
            }, function() {
                //console.log("error");
                let insta_gallerys = $(".instagram_img_sektion .instagram_img");
                insta_gallerys.each(function() {
                    let insta_gallery = $(this);
                    insta_gallery.addClass("error");
                    insta_gallery.closest(".instagram_img_sektion").addClass("insta_active");
                    insta_gallery.html("<div>Приносим извинения инстаграм галерею не удалось загрузить =( <br> Попробуйте обновить страницу</div>")
                });
                data_site.media_data.insta_gallery.script.error = true; //помечаем что произошла ошибка при загрузке скрипта
            });
            //в зависимости от того успешно загрузился скрипт или была ошибка загрузки выполняем соответсвующие действия
        }
        //проверям был ли добалени скрипт инстаграм галереи, если нет то заменяем его data-src на src
    };
    //функия загрузки инстаграм галереи


    //проверяем позицию элемента на странице, а конкретно видит ли его пользователь или нет
    data_site.position_check = function(target_elements, media_type, func) {
        //ВАЖНО: перебор массива начинам с конца, чтоб избежать сдига в массиве когда на место только что удалённого элемента становится следующий за ним, а цикл его уже пропускает т.к. он только что итерировал элемент с таким индексом и удалил его, т.е. удалили 8 элемент, 9 элемент стал на его место (стал восьмым), а 10 стал 9 и т.д. тем самым мы пропускаем элементы при передоре. При переборе с конца элементы перебириаются как бы снизу вверх и массив сдивигается, в случае удаления элемента, вверх т.е. мы не пропускаем элементы. К примеру, мы удалили 9 элемент, 10 стал на его место (стал девятым), 11 стал 10 и т.д., но нам уже всё рано верд мы не будем запрашивать 10 после удаления 9, абудем запрашивать 8 и т.д. =)

        //перебираем массив с target_elements
        for (let i = target_elements.length - 1; i >= 0; i--) {
            //параметры для определение положенния текущего итерируемого target_elements[i] на странице
            if (media_type == "images" || media_type == "maps" || media_type == "video") {
                var elem = $(target_elements[i]); //текущий итерируемый target_elements[i]
            } else if (media_type == "insta_gallery") {
                var elem = $(target_elements[i].insta_wrap), //текущая итерируемая инстаграмм галерея
                    settings = target_elements[i]; //объект с настройками текущей галереи
            }
            let elem_top_otstup_for_top_browser_window = Math.round(elem[0].getBoundingClientRect().top), //растояние от верха текущего итерируемого target_elements[i] до верха окна браузера
                elem_bottom_otstup_for_top_browser_window = Math.round(elem[0].getBoundingClientRect().bottom), //растояние от низа текущего итерируемого target_elements[i] до верха окна браузера
                win_height = Math.round($(window).height()), //высота окна браузера
                elem_top_otstup_for_bottom_browser_window = win_height - elem_top_otstup_for_top_browser_window; //растояние от верха текущего итерируемого target_elements[i] до низа окна браузера
            //параметры для определение положенния текущего итерируемого target_elements[i] на странице

            //выполняем действия только если : текущий итерируемый target_elements[i] какой-то своей частью (верхом или низом) попадает на видимый экран пользователя, будь то порокрутка снизу или сверху
            if (elem_top_otstup_for_bottom_browser_window >= 0 && elem_bottom_otstup_for_top_browser_window >= 0) {
                if (media_type == "images" || media_type == "maps" || media_type == "video") {
                    func(elem);
                } else if (media_type == "insta_gallery") {
                    func(elem, settings);
                }
            }
            //выполняем действия только если : текущий итерируемый target_elements[i] какой-то своей частью (верхом или низом) попадает на видимый экран пользователя, будь то порокрутка снизу или сверху
        }
        //перебираем массив с target_elements
    };
    //проверяем позицию элемента на странице, а конкретно видит ли его пользователь или нет



    //функция загрузки media, проверям положение блока media и в случае необходимости декодируем его
    data_site.load_media = function(media_type) {
        let orientation = data_site.orientation; //текущая ориентация устройства

        //для media_type == "images"
        if (media_type == "images") {
            //проверяем положение текущего media элемента, видил ли его пользователь или нет
            data_site.position_check(data_site.media_data.images[orientation], media_type, function(img) {
                //выполняем первое декодирование, т.е. заменяем src пустышку на нормальный url
                if (!img.parent().hasClass("dekoder")) {
                    data_site.dekoder_started(img, orientation);
                }
                //выполняем первое декодирование, т.е. заменяем src пустышку на нормальный url

                //ПРИМЕЧАНИЕ: если у прямого родителя картинки есть класс dekoder, значит картинка уже была декодированна и у неё в src не пустышка, а реальный url, значит мы декодируя её в другой ориентации можем получить второй размер миниатюры и сравнив их можен на всегода установить максимальный размер миниатюры для обоих ориентаций, после чего удалить картинку из очереди объектов на обработку в обоих ориентациях

                //выполняем второе декодирование, если первое было выполнено, чтоб установить максимальную ширину миниатюры на постоянну и отключить обработку картинки
                else {
                    data_site.dekoder_finish(img, orientation);
                }
                //выполняем второе декодирование, если первое было выполнено, чтоб установить максимальную ширину миниатюры на постоянну и отключить обработку картинки

                let total_img_kol = data_site.media_data.images.schetchiki.kolichestvo,
                    load_gor = data_site.media_data.images.schetchiki.gor_orient.load,
                    load_ver = data_site.media_data.images.schetchiki.ver_orient.load;

                //если количество загрженных media для данной orientation равно общему количеству media, удаляем слушатели скрола для media
                if (data_site.media_data.images.schetchiki[orientation].load == total_img_kol) {
                    window.removeEventListener("scroll", data_site.media_data[media_type].load_pri_scroll);
                    //console.log("удалили scroll " + media_type + " " + orientation);
                }
                //если количество загрженных media для данной orientation равно общему количеству media, удаляем слушатели скрола для media

                //если все картинки горизонтальной и вертикальной ориентаций загружены, тогда нет смысла проверять картинки при скроле и реайзе, так что слушатели scroll и resize можно удалить
                //ПРИМЕЧАНИЕ: проверяем менялась ли ориентация документа data_site.orientation_chenge, т.к. это гарантирует что все скрытые картинки которые были проигнорированны ранее из-за нулевой высоты, т.е. их не было видно вследствии медиа стилей, теперь появились и находятся в очереди декодирования, а если всё же не появились значит они скрыты не толкьо медиа стилями и для из декодирования нужно вызывать функцию data_site.add_to_load_media уже в требуемые моменты в будущем
                if (load_gor == total_img_kol && load_ver == total_img_kol && data_site.orientation_chenge) {
                    //console.log("удалили scroll " + media_type + " " + orientation);
                    window.removeEventListener("scroll", data_site.media_data.images.load_pri_scroll);
                    //console.log("удалили resize " + media_type);
                    window.removeEventListener("resize", data_site.media_data.images.load_pri_resize);
                }
                //если все картинки горизонтальной и вертикальной ориентаций загружены, тогда нет смысла проверять картинки при скроле и реайзе, так что слушатели scroll и resize можно удалить
            });
            //проверяем положение текущего media элемента, видил ли его пользователь или нет
        }
        //для media_type == "images"

        //для media_type == "maps" или media_type == "video"
        else if (media_type == "maps" || media_type == "video") {
            //проверяем положение текущего media элемента, видил ли его пользователь или нет
            data_site.position_check(data_site.media_data[media_type][media_type], media_type, function(media) {

                data_site.iframe_dekoder(media, media_type); //отправляем media на обработку функции data_site.iframe_dekoder

                let load_kol = data_site.media_data[media_type].schetchiki.load,
                    total_kol = data_site.media_data[media_type].schetchiki.kolichestvo;

                //если количество загрженных равно общему количеству media, удаляем слушатели скрола и ресайза для media
                if (load_kol == total_kol) {
                    //console.log("удалили scroll и resize для " + media_type);
                    window.removeEventListener("scroll", data_site.media_data[media_type].load_pri_scroll);
                    window.removeEventListener("resize", data_site.media_data[media_type].load_pri_resize);
                }
                //если количество загрженных равно общему количеству media, удаляем слушатели скрола и ресайза для media
            });
            //проверяем положение текущего media элемента, видил ли его пользователь или нет
        }
        //для media_type == "maps" или media_type == "video"

        //для media_type == "insta_gallery"
        else if (media_type == "insta_gallery") {

            //если при загрузке файла скрипта инастаграм галереи произошла ошибка, мы завершаем выполнение функции и удаляем все слушаетелим для инстаграм галереи
            if (data_site.media_data.insta_gallery.script.error) {
                window.removeEventListener("scroll", data_site.media_data.insta_gallery.load_pri_scroll);
                window.removeEventListener("resize", data_site.media_data.insta_gallery.load_pri_resize);
                return;
            }
            //если при загрузке файла скрипта инастаграм галереи произошла ошибка, мы завершаем выполнение функции и удаляем все слушаетелим для инстаграм галереи

            //проверяем положение текущего media элемента, видил ли его пользователь или нет
            data_site.position_check(data_site.media_data.insta_gallery.widgets, media_type, function(media, insta_settings_obj) {
                //проверяем чтоб данная галерея не была декодированная ранее
                if (!media.hasClass("insta_naydena")) {
                    data_site.insta_gallery_dekoder(media, insta_settings_obj); //отправляем объект insta_settings_obj на обработку функции data_site.insta_gallery_dekoder
                }
                //проверяем чтоб данная галерея не была декодированная ранее

                let load_kol = data_site.media_data.insta_gallery.schetchiki.load,
                    total_kol = data_site.media_data.insta_gallery.schetchiki.kolichestvo;

                //если количество загрженных равно общему количеству media, удаляем слушатели скрола и ресайза для media
                if (load_kol == total_kol) {
                    //console.log("удалили scroll и resize для " + media_type);
                    window.removeEventListener("scroll", data_site.media_data.insta_gallery.load_pri_scroll);
                    window.removeEventListener("resize", data_site.media_data.insta_gallery.load_pri_resize);
                }
                //если количество загрженных равно общему количеству media, удаляем слушатели скрола и ресайза для media
            });
            //проверяем положение текущего media элемента, видил ли его пользователь или нет
        }
        //для media_type == "insta_gallery"
    };
    //функция загрузки media, проверям положение блока видео и в случае необходимости декодируем его



    data_site.add_to_load_media = function(target_media, media_type) {
        //если переданный объект пуст, завершаем выполнение функции
        if (target_media.length == 0) {
            return;
        }
        //если переданный объект пуст, завершаем выполнение функции

        //ВАЖНО: создаём функцию data_site.media_data[media_type].load_pri_scroll для текущего media_type ЕДИНОЖДЫ, иначе вновь созданная вункция будет считаться уже другой и её нельзя будет отключить в removeEventListener
        if (!data_site.media_data[media_type].load_pri_scroll) {
            data_site.media_data[media_type].load_pri_scroll = function() {
                //console.log("scroll");
                //выполняем проверку положения и декодирование media
                data_site.load_media(media_type);
                //выполняем проверку положения и декодирование media
            };
        }
        //ВАЖНО: создаём функцию data_site.media_data[media_type].load_pri_scroll для текущего media_type ЕДИНОЖДЫ, иначе вновь созданная вункция будет считаться уже другой и её нельзя будет отключить в removeEventListener

        //ВАЖНО: создаём функцию data_site.media_data[media_type].resize_listern_add для текущего media_type ЕДИНОЖДЫ, иначе вновь созданная вункция будет считаться уже другой и её нельзя будет отключить в removeEventListener
        if (!data_site.media_data[media_type].load_pri_resize) {
            data_site.media_data[media_type].load_pri_resize = function() {
                //console.log("resize");
                let orientation = data_site.orientation,
                    started_orientation = data_site.started_orientation;

                //если есть скрытые media, при ресайзе мы их добавляем в очередь на декодировани, т.к. они скорее всего теперь стали видны
                //ПРИМЕЧАНИЕ: если media не стали видны после смены ориентации значит они скрыты не только медиа стилями, а может просто не для этого разрешения экрана, и нам нет смысла по новой пытаться их декодировать при дальнейших ресайзах, так что мы отправляем их на декодирование только при первой смене ориентации
                if (orientation != started_orientation && !data_site.media_data[media_type].skritie_check) {
                    let skritie_media = data_site.media_data[media_type].skritie;
                    if (skritie_media.length > 0) {
                        //console.log("проверяем скрытые");
                        data_site.add_to_load_media(skritie_media, media_type); //добавляем в очередь на декодирование
                        data_site.media_data[media_type].skritie_check = true; //делаем пометку что мы уже отправляли скрытые media на декодирование после ресайза
                    }
                }
                //если есть скрытые media, при ресайзе мы их добавляем в очередь на декодировани, т.к. они скорее всего теперь стали видны

                //для media_type == "images"
                if (media_type == "images") {
                    let total_img_kol = data_site.media_data.images.schetchiki.kolichestvo,
                        load_gor = data_site.media_data.images.schetchiki.gor_orient.load,
                        load_ver = data_site.media_data.images.schetchiki.ver_orient.load;

                    if (orientation == "gor_orient") {

                        //если все картинки вертикальной ориентации были загружены, занчит слушатель scroll с функцией data_site.media_data.images.load_pri_scroll был удалён, но если для горизонтальной ориентации загрузились не все картинки, тогда для горизонтальной ориентации нам нужно его назначить по новой
                        if (load_ver == total_img_kol && load_gor < total_img_kol) {
                            //console.log("добавили прокрутка 1");
                            data_site.event_listener_for_element(true, ["scroll"], [$(window)], data_site.media_data.images.load_pri_scroll, { passive: true });
                        }
                        //если все картинки вертикальной ориентации были загружены, занчит слушатель scroll с функцией data_site.media_data.images.load_pri_scroll был удалён, но если для горизонтальной ориентации загрузились не все картинки, тогда для горизонтальной ориентации нам нужно его назначить по новой

                    } else if (orientation == "ver_orient") {

                        //если все картинки горизонтальной ориентации были загружены, занчит слушатель scroll с функцией data_site.media_data.images.load_pri_scroll был удалён, но если для вертикальной ориентации загрузились не все картинки, тогда для вертикальной ориентации нам нужно его назначить по новой
                        if (load_gor == total_img_kol && load_ver < total_img_kol) {
                            //console.log("добавили прокрутка 2");
                            data_site.event_listener_for_element(true, ["scroll"], [$(window)], data_site.media_data.images.load_pri_scroll, { passive: true });
                        }
                        //если все картинки горизонтальной ориентации были загружены, занчит слушатель scroll с функцией data_site.media_data.images.load_pri_scroll был удалён, но если для вертикальной ориентации загрузились не все картинки, тогда для вертикальной ориентации нам нужно его назначить по новой
                    }

                    //проверяем количество загруженных картинок для текущей orientation
                    if (data_site.media_data.images.schetchiki[orientation].load < total_img_kol) {
                        data_site.load_media(media_type);
                    }
                    //проверяем количество загруженных картинок для текущей orientation

                }
                //для media_type == "images"

                //для media_type == "maps" или media_type == "video" или media_type == "insta_gallery"
                else if (media_type == "maps" || media_type == "video" || media_type == "insta_gallery") {
                    //выполняем проверку положения и декодирование media
                    data_site.load_media(media_type);
                    //выполняем проверку положения и декодирование media
                }
                //для media_type == "maps" или media_type == "video" или media_type == "insta_gallery"
            };
        }
        //ВАЖНО: создаём функцию data_site.media_data[media_type].resize_listern_add для текущего media_type ЕДИНОЖДЫ, иначе вновь созданная вункция будет считаться уже другой и её нельзя будет отключить в removeEventListener

        //перебираем объект с target_media, и записываем каждый элемент в массив декодирования, попутно увиличивая счётчик количества текущего media_type для декодирования
        for (let i = 0; i < target_media.length; i++) {
            //проверяем чтоб target_media[i] элемент был именно object, т.е. это Node узел - DOM элемент
            if (typeof target_media[i] === "object") {
                //если высота target_media[i] = 0, значит элемент скрыт слилями, недоступен для данного разрешения или скрыт по другим причинам. Его мы записываем в массим скрытых элементов для данного  media_type
                if ($(target_media[i]).height() == 0) {
                    let skritie_media = data_site.media_data[media_type].skritie, //массив скрытых элементов для данного media_type
                        skritie_index = skritie_media.indexOf(target_media[i]); //индекс элемента в массиве скрытых элементов, если нет то получим -1

                    //проверяем если ли элементы в массиве скрытых media данного media_type, если нет то добавляем в конец массива
                    if (skritie_index == -1) {
                        skritie_media.push(target_media[i]); //добавляем в массив скрытых элементов для данного media_type
                    }
                    //проверяем если ли элементы в массиве скрытых media данного media_type, если нет то добавляем в конец массива
                }
                //если высота target_media[i] = 0, значит элемент скрыт слилями, недоступен для данного разрешения или скрыт по другим причинам. Его мы записываем в массим скрытых элементов для данного  media_type

                //если высота target_media[i] > 0, записываем его в конец масива элементов данного media_type и увеличим общее количество элементов для данного media_type
                else {
                    //для media_type == "images" добавляем картинку в масив г.о. и в.о
                    if (media_type == "images") {
                        data_site.media_data[media_type].gor_orient.push(target_media[i]); //добавлем target_media[i] в конец массива г.о., получаем новую длинну массива
                        data_site.media_data[media_type].ver_orient.push(target_media[i]); //добавлем target_media[i] в конец массива в.о., получаем новую длинну массива
                        data_site.media_data[media_type].schetchiki.kolichestvo += 1; //обновляем значение общего количества данного media_type на декодирование
                    }
                    //для media_type == "images" добавляем картинку в масив г.о. и в.о

                    //для media_type == "maps" или media_type == "video"
                    else if (media_type == "maps" || media_type == "video") {
                        data_site.media_data[media_type][media_type].push(target_media[i]); //добавлем target_media[i] в конец массива media_type
                        data_site.media_data[media_type].schetchiki.kolichestvo += 1; //обновляем значение общего количества данного media_type на декодирование
                    }
                    //для media_type == "maps" или media_type == "video"

                    //для media_type == "insta_gallery"
                    else if (media_type == "insta_gallery") {
                        //если браузер пользователя Internet Explorer прекращаем выполнение скрипта, т.е. инстаграм галерея в нём не работает
                        if (data_site.IE_check()) {
                            return;
                        }
                        //если браузер пользователя Internet Explorer прекращаем выполнение скрипта, т.е. инстаграм галерея в нём не работает

                        let insta_settings = target_media[i].querySelector(".elfsight-widget-instagram-feed.elfsight-widget"); //находим elfsight-widget-instagram-feed elfsight-widget в элементе instagram_img_sektion[i], массива instagram_img_sektion

                        //если insta_settings существует значит галерея не пустая и нужно записать её данные
                        if (insta_settings) {
                            let options = insta_settings.dataset.elfsightInstagramFeedOptions, //записываем данные из атрибута data-elfsight-instagram-feed-options
                                version = insta_settings.dataset.elfsightInstagramFeedVersion, //записываем данные из атрибута data-elfsight-instagram-feed-version
                                id = insta_settings.dataset.elfsightWidgetId; //записываем данные из атрибута data-elfsight-widget-id

                            insta_settings.parentNode.removeChild(insta_settings); //удаляем обработанный elfsight-widget-instagram-feed elfsight-widget из тела страницы

                            //создаём объект widgets в который запишем все данные текущей галереи
                            let widget = {};
                            widget.id = id;
                            widget.version = version;
                            widget.options = options;
                            widget.insta_wrap = target_media[i]; //записываем в widgets оболочку instagram_img для текущей галереи
                            //создаём объект widgets в который запишем все данные текущей галереи

                            target_media[i].innerHTML = ''; //удаляем всё содержимое instagram_img
                            data_site.media_data.insta_gallery.widgets.push(widget);
                            data_site.media_data[media_type].schetchiki.kolichestvo += 1; //обновляем значение общего количества данного media_type на декодирование
                        }
                        //если insta_settings существует значит галерея не пустая и нужно записать её данные
                    }
                    //для media_type == "insta_gallery"
                }
                //если высота target_media[i] > 0, записываем его в конец масива элементов данного media_type и увеличим общее количество элементов для данного media_type
            }
            //проверяем чтоб target_media[i] элемент был именно object, т.е. это Node узел - DOM элемент
        }
        //перебираем объект с target_media, и записываем каждый элемент в массив декодирования, попутно увиличивая счётчик количества текущего media_type для декодирования

        //добавляем слушатели при скроле и ресайзе, для проверки положения media, ВАЖНО: только в случае если для данного media_type он ещё не был добавлен
        data_site.event_listener_for_element(true, ["scroll"], [$(window)], data_site.media_data[media_type].load_pri_scroll, { passive: true });
        data_site.event_listener_for_element(true, ["resize"], [$(window)], data_site.media_data[media_type].load_pri_resize, { passive: true });
        //добавляем слушатели при скроле и ресайзе, для проверки положения media, ВАЖНО: только в случае если для данного media_type он ещё не был добавлен

        data_site.load_media(media_type); //запускаем проверку положения media и декодировние
    };

    data_site.add_to_load_media(img_maket, "images");
    data_site.add_to_load_media(imges, "images");
    data_site.add_to_load_media(video, "video"); //добавляем video в очередь на декодирование видео
    data_site.add_to_load_media(maps, "maps");
    data_site.add_to_load_media(insta_gallerys, "insta_gallery");

    //
    //
    //ОТЛОЖЕННАЯ ЗАГРУЗКА MEDIA
    //
    //

    //
    //
    //МЕНЮ СВЕРХУ
    //
    //
    data_site.menu_data = {}; //сюда записываем данные которые хотим хранить для меню, в данном случае тут записывается элемент chat в момент клика по бургер меню

    //вызывается после полной готовности DOM и записывает все нужные переменные для меню, а так же применяет к ним изменения, ещё данная функция вызывается при каждом resize
    open_close_menu_top = function() {
        let body = $("body"), //теле сайта
            scrollup = $(".scrollup"), //кнопка сролла вверх
            header = $("header"), //верх сайта
            logo_wrap = $("#logo_wrap"), //блок верха сайта оборачивающий логотип
            touch_menu = $("#touch_menu"), //блок верха сайта оборачивающий бургер-кнопку
            touch_menu_wrapper = $("#touch_menu>.touch_menu_wrapper"), //блок верха сайта оборачивающий бургер-линии для бургер-кнопки
            menu_block = $("#menu_block"), //nav блок верха сайта оборачивающий меню
            primary_menu = $("#primary_menu"), //ul блок оборачивающий меню
            a_all = primary_menu.find("a:not([href])"), //все ссылки a которые являются лишь пунктом меню без страницы
            b_all = primary_menu.find("div.op_cl"), //все div.op_cl находящиеся в #primary_menu
            ul_sub_menu_all = primary_menu.find("ul.sub-menu"); //все ul.sub-menu находящиеся в #primary_menu


        data_site.menu_data.orient = data_site.orientation;
        //скрываем меню при каждом resize и снова показываем все скрытые, при его открытии, элементы страницы

        if (data_site.menu_data.chat) {
            data_site.menu_data.chat.css("display", "block");
        }
        body.css("overflow-y", "");
        scrollup.css("display", "");
        touch_menu.removeClass("open_menu"); //бургер меню меняем на 3 полоски
        menu_block.slideUp(); //закрываем #menu_block
        b_all.removeClass("active_b"); //удаляем класс active_b у всех div.op_cl дочерних для #primary_menu
        ul_sub_menu_all.slideUp(); //закрываем все раскрытые ul.sub-menu
        ul_sub_menu_all.removeClass("active_menu"); //удаляем класс active_menu у всех ul.sub-menu дочерних для #primary_menu
        //скрываем меню при каждом resize и снова показываем все скрытые, при его открытии, элементы страницы

        //скрыть пункты меню и поменять крестики на стрелки если клик был за пределами header, а так же показываем все элементы которые были скрыты после клика по бургер-меню
        function menu_top_disable(e) { // отслеживаем событие клика по веб-документу
            if (!header.is(e.target) && header.has(e.target).length === 0) { // проверка условия если клик был не по нашему блоку, клик не по его дочерним элементам
                body.css("overflow-y", "");
                scrollup.css("display", "");
                if (data_site.menu_data.chat) {
                    data_site.menu_data.chat.css("display", "block");
                }
                touch_menu.removeClass("open_menu"); //бургер меню меняем на 3 полоски
                menu_block.slideUp(); //плавно скрываем #menu_block
                b_all.removeClass("active_b"); //удаляем класс active_b у всех div.op_cl дочерних для #primary_menu
                ul_sub_menu_all.slideUp(); //закрываем все раскрытые ul.sub-menu
                ul_sub_menu_all.removeClass("active_menu"); //удаляем класс active_menu у всех ul.sub-menu дочерних для #primary_menu
            }
        }
        data_site.event_listener_for_element(true, ["click", "touchend"], [$(document)], menu_top_disable, { passive: true }); //подключаем кастомный слушатель
        //скрыть пункты меню и поменять крестики на стрелки если клик был за пределами header, а так же показываем все элементы которые были скрыты после клика по бургер-меню


        if ($(window).width() >= 992) {
            //здесь мы явно задаём высоту #logo_wrap в зависимости от размера блока меню, чтоб логотип не прыгал по высоте
            let primary_menu_li_h = primary_menu.children("li.menu-item-has-children").children("a").outerHeight(); //получаем высоту блоков ссылок в первом уровне меню
            logo_wrap.height(primary_menu_li_h); //задаём высоту для логотипа равную высоте блоков ссылок первого уровня меню
            //здесь мы явно задаём высоту #logo_wrap в зависимости от размера блока меню, чтоб логотип не прыгал по высоте
        }


        //выполняем по нажатию на бургер-меню #touch_menu>.touch_menu_wrapper
        function touch_menu_open_close(e) {
            e.preventDefault(); //убираем действие по умолчанию
            e.stopPropagation(); //клик по данному элементу не будет вызывать события связанные с кликом по его родительским и дочерним элементам, только события клика по этому целевому элементу
            e.stopImmediatePropagation(); //все дальнейшие события типа event текущего слушателя будут игнорироваться, к примеру если это событие вызывалось при клике по элементу с stopImmediatePropagation то все дальнейшие функции связанны с кликом по данному элементу будут поинорированны
            data_site.menu_data.chat = $("jdiv[class^=globalClass]"); //опредляем чат при клике по бургер-меню, и записываеам его в data_site.menu_data
            menu_block.height(window.screen.height - 70); //для того чтоб меню занимало всю высоту экрана

            //если меню открыто то скрываем его
            if (touch_menu.hasClass("open_menu")) {
                b_all.removeClass("active_b"); //удаляем класс active_b у всех div.op_cl дочерних для #primary_menu
                ul_sub_menu_all.removeClass("active_menu"); //удаляем класс active_menu у всех ul.sub-menu дочерних для #primary_menu
                touch_menu.removeClass("open_menu"); //бургер меню меняем на 3 полоски
                ul_sub_menu_all.slideUp(500); //скрываем все ul.sub-menu
                menu_block.slideUp(500); //плавно скрываем #menu_block
                body.css("overflow-y", "");
                scrollup.css("display", "");
                data_site.menu_data.chat.css("display", "block"); //показываем чат, т.к. он мог быть скрыт
            }
            //если меню открыто то скрываем его

            //если меню закрыто то открываем его
            else {
                touch_menu.addClass("open_menu"); //бургер меню меняем на крестик
                menu_block.slideDown(500); //плавно открываем #menu_block
                data_site.menu_data.chat.css("display", "none"); //скрываем чат
                body.css("overflow-y", "hidden");
                scrollup.css("display", "none");
            }
            //если меню закрыто то открываем его
        }
        data_site.event_listener_for_element(true, ["click", "touchend"], [touch_menu_wrapper], touch_menu_open_close, { passive: false }); //подключаем кастомный слушатель
        //выполняем по нажатию на бургер-меню #touch_menu>.touch_menu_wrapper


        //при touchend по любому div.op_cl открываем соответсвующие меню, и скрываем другие открытые
        function b_all_touch_change(e) {
            e.preventDefault(); //убираем действие по умолчанию
            e.stopPropagation();
            e.stopImmediatePropagation();

            //если по соседству нет ul.sub-menu то завершаем функцию
            if ($(this).siblings("ul.sub-menu").length == 0) { return; }
            //если по соседству нет ul.sub-menu то завершаем функцию

            //если клик был по тегу a
            if (this.localName == "a") {
                var b = $(this).siblings("div.op_cl");
            }
            //если клик был по тегу a

            //если клик был по тегу b
            else if (this.localName == "div") {
                var b = $(this); //b на который нажали
            }
            //если клик был по тегу b

            let b_parent = b.parent("li.menu-item-has-children"), //прямой родитель li.menu-item-has-children для данного b
                ul_menu = b.siblings("ul.sub-menu"), //меню ul.sub-menu свзязанное с данным b (расположенны рядом)
                b_siblings_child_ul_menu = b_parent.siblings("li.menu-item-has-children").find("ul.sub-menu"), //находит все ul.sub-menu в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b
                b_child_ul_menu = b_parent.find("ul.sub-menu"), //находит все дочерние ul.sub-menu для прямого родителя li.menu-item-has-children данного b
                b_childrens = b.siblings("ul.sub-menu").find("div.op_cl"), //находит все дочерние div.op_cl для, связанного с данным b, элемента ul.sub-menu
                b_siblings_childrens = b_parent.siblings("li.menu-item-has-children").find("div.op_cl"); //находит все div.op_cl в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b


            //если ul.sub-menu у данного b откыто и b активен
            if (b.hasClass("active_b")) {
                b.removeClass("active_b"); //удаляем класс active_b у данного b
                if ($(window).width() < 992) { b_child_ul_menu.slideUp(500); } //для экранов меньше 992px плавно сворачиванием все дочерние ul.sub-menu для прямого родителя li.menu-item-has-children данного b
                b_child_ul_menu.removeClass("active_menu"); //удаляем класс active_menu для всех дочерних элементов ul.sub-menu, родительского элемента li.menu-item-has-children для данного b
                if ($(window).width() < 992) { ul_menu.slideUp(500); } //для экранов меньше 992px плавно сворачиванием ul.sub-menu связанное с данным b
                b_childrens.removeClass("active_b"); //удаляем класс active_b для всех дочерних div.op_cl элемента ul.sub-menu, связанного с данным b
            }
            //если ul.sub-menu у данного b откыто и b активен

            //если ul.sub-menu у данного b закрыто и b не активен
            else {
                b.addClass("active_b"); //добавляем класс active_b данному b
                if ($(window).width() < 992) { ul_menu.slideDown(500); } //для экранов меньше 992px плавно разворачиваем ul.sub-menu связанное с данным b
                ul_menu.addClass("active_menu"); //добавляем класс active_menu для ul.sub-menu связанного с данным b
            }
            //если ul.sub-menu у данного b закрыто и b не активен

            //выполняем независимо от: ширины экрана, того активен ли данный b, активно ли связанное с данным b меню ul.sub-menu
            b_siblings_childrens.removeClass("active_b"); //удаляем класс active_b для всех div.op_cl в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b
            if ($(window).width() < 992) { b_siblings_child_ul_menu.slideUp(500); } //для экранов меньше 992px плавно сворачиванием все ul.sub-menu в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b
            b_siblings_child_ul_menu.removeClass("active_menu"); //удаляем класс active_menu у всех ul.sub-menu в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b
            //выполняем независимо от: ширины экрана, того активен ли данный b, активно ли связанное с данным b меню ul.sub-menu
        }
        data_site.event_listener_for_element(true, ["touchend"], [b_all, a_all], b_all_touch_change, { passive: false }); //подключаем кастомный слушатель
        //при touchend по любому div.op_cl открываем соответсвующие меню, и скрываем другие открытые

        //при click по div.op_cl открываем соответсвующие меню, и скрываем другие открытые. ПРИМЕЧАНИЕ: данная функция сработает только для экранов меньше 992px, т.к. меню на экранах 992px включительно и больше открывается наведением курсора мышки (:hover событием), а для сенсорных экранов всех размеров есть слушатель toch с функцией которая открывает и закрывает менюшки по касанию на экране, так вот данная функция создана на случай если человек зайдёт с устройства размер которого меньше 992px и использует курсор мышки для открытия меню
        function b_all_click_change(e) { //только для нажатий мышкой
            //для экранов меньше 992px
            if ($(window).width() < 992) {
                e.preventDefault(); //убираем действие по умолчанию
                e.stopPropagation();
                e.stopImmediatePropagation();

                //если по соседству нет ul.sub-menu то завершаем функцию
                if ($(this).siblings("ul.sub-menu").length == 0) { return; }
                //если по соседству нет ul.sub-menu то завершаем функцию

                //если клик был по тегу a
                if (this.localName == "a") {
                    var b = $(this).siblings("div.op_cl");
                }
                //если клик был по тегу a

                //если клик был по тегу b
                else if (this.localName == "div") {
                    var b = $(this); //b на который нажали
                }
                //если клик был по тегу b

                let b_parent = b.parent("li.menu-item-has-children"), //прямой родитель li.menu-item-has-children для данного b
                    ul_menu = b.siblings("ul.sub-menu"), //меню ul.sub-menu свзязанное с данным b (расположенны рядом)
                    b_siblings_child_ul_menu = b_parent.siblings("li.menu-item-has-children").find("ul.sub-menu"), //находит все ul.sub-menu в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b
                    b_child_ul_menu = b_parent.find("ul.sub-menu"), //находит все дочерние ul.sub-menu для прямого родителя li.menu-item-has-children данного b
                    b_childrens = b.siblings("ul.sub-menu").find("div.op_cl"), //находит все дочерние div.op_cl для, связанного с данным b, элемента ul.sub-menu
                    b_siblings_childrens = b_parent.siblings("li.menu-item-has-children").find("div.op_cl"); //находит все div.op_cl в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b

                //если ul.sub-menu у данного b откыто и b активен
                if (b.hasClass("active_b")) {
                    b.removeClass("active_b"); //удаляем класс active_b у данного b
                    b_child_ul_menu.slideUp(500); //плавно сворачиванием все дочерние ul.sub-menu для прямого родителя li.menu-item-has-children данного b
                    b_child_ul_menu.removeClass("active_menu"); //удаляем класс active_menu для всех дочерних элементов ul.sub-menu, родительского элемента li.menu-item-has-children для данного b
                    ul_menu.slideUp(500); //плавно сворачиванием ul.sub-menu связанное с данным b
                    b_childrens.removeClass("active_b"); //удаляем класс active_b для всех дочерних div.op_cl элемента ul.sub-menu, связанного с данным b
                }
                //если ul.sub-menu у данного b откыто и b активен

                //если ul.sub-menu у данного b закрыто и b не активен
                else {
                    b.addClass("active_b"); //добавляем класс active_b данному b
                    ul_menu.slideDown(500); //плавно разворачиваем ul.sub-menu связанное с данным b
                    ul_menu.addClass("active_menu"); //добавляем класс active_menu для ul.sub-menu связанного с данным b
                }
                //если ul.sub-menu у данного b закрыто и b не активен

                //выполняем независимо от: того активен ли данный b, активно ли связанное с данным b меню ul.sub-menu
                b_siblings_childrens.removeClass("active_b"); //удаляем класс active_b для всех div.op_cl в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b
                b_siblings_child_ul_menu.slideUp(500); //плавно сворачиванием все ul.sub-menu в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b
                b_siblings_child_ul_menu.removeClass("active_menu"); //удаляем класс active_menu у всех ul.sub-menu в соседях, вида li.menu-item-has-children, прямого родительского li.menu-item-has-children для данного b
                //выполняем независимо от: того активен ли данный b, активно ли связанное с данным b меню ul.sub-menu
            }
            //для экранов меньше 992px
        }
        data_site.event_listener_for_element(true, ["click"], [b_all, a_all], b_all_click_change, { passive: false }); //подключаем кастомный слушатель
        //при click по div.op_cl открываем соответсвующие меню, и скрываем другие открытые. ПРИМЕЧАНИЕ: данная функция сработает только для экранов меньше 992px, т.к. меню на экранах 992px включительно и больше открывается наведением курсора мышки (:hover событием), а для сенсорных экранов всех размеров есть слушатель toch с функцией которая открывает и закрывает менюшки по касанию на экране, так вот данная функция создана на случай если человек зайдёт с устройства размер которого меньше 992px и использует курсор мышки для открытия меню

    };
    //вызывается после полной готовности DOM и записывает все нужные переменные для меню, а так же применяет к ним изменения, ещё данная функция вызывается при каждом resize
    open_close_menu_top(); //вызывается после полной готовности DOM

    open_close_menu_top_for_resize = function() {
        if (data_site.menu_data.orient != data_site.orientation) {
            open_close_menu_top();
        }
    };

    data_site.event_listener_for_element(true, ["resize"], [$(window)], open_close_menu_top_for_resize, { passive: true }); //подключаем кастомный слушатель
    //
    //
    //МЕНЮ СВЕРХУ
    //
    //

    //
    //
    //ОТКРЫТИЕ МОДАЛЬНОГО ОКНА ПРИ НАЖАТИИ НА АДРЕС В ФУТЕРЕ С ОТЛОЖЕННОЙ ЗАГРУЗКОЙ КАРТЫ
    //
    //
    let modal_window_all = $(".modal_form"), //все модальные окна modal_form на странице
        scrollup = $(".scrollup"), //оболочка картинки scrollup
        proverka_scrollup = 1, //устанавливаем началоное состояние для кнопки scrollup, 1 - значит что кнопка появляется при прокурутке в штатном режиме, но вот если заначение не равно 1 то кнопка появляется уже в зависимости от того что для неё устанавливает функция которая меняет этот параметр
        body = $("body"); //тело страницы body

    //кнопка прокрутки вверх

    //проверяем нужно ли показывать кнопку scrollup
    function scroll_positon_check() {
        if (proverka_scrollup == 1) { //проверяем не нужно ли менять поведение кнопки при скроле
            if ($(document).scrollTop() > 500) { //показываем кнопку scrollup только если документ прокручен более чем на 500px
                scrollup.css("opacity", ".5"); //плавно показываем кнопку вверх
                //если картинка кнопки вверх ещё не декодированна, декодируем её, разумеется после прокрутки на заданную дистанцию
                if (!scrollup.hasClass("dekoder_max")) {
                    data_site.add_to_load_media(scrollup.find("img"), "images");
                }
                //если картинка кнопки вверх ещё не декодированна, декодируем её, разумеется после прокрутки на заданную дистанцию
            } else { //в противном случае скрываем кнопку scrollup
                scrollup.css("opacity", "0"); //плавно скрываем кнопку вверх
            }
        }
    }
    //проверяем нужно ли показывать кнопку scrollup

    //поднимаемся к верху страницы после click или touchend по элементу scrollup
    function scroll_to_top() {
        $("html").animate({ scrollTop: 0 }, 700); //анимируем прокрутку страницы к верху за 700мс
    }
    //поднимаемся к верху страницы после click или touchend по элементу scrollup
    scroll_positon_check();
    data_site.event_listener_for_element(true, ["scroll"], [$(document)], scroll_positon_check, { passive: true }); //подключаем кастомный слушатель
    data_site.event_listener_for_element(true, ["click", "touchend"], [scrollup], scroll_to_top, { passive: true }); //подключаем кастомный слушатель
    //кнопка прокрутки вверх

    //устанавливает позиция модального окна на странице, пересчитывает эти данные при каждом резайзе
    function adres_map_w_h_css() {
        var win_width = $(window).width(), //ширина окна браузера
            win_height = $(window).height(), //высота окна браузера
            css_height = win_height * 0.75; //высота для модального окна в 75% от высоты окна браузера
        modal_window_all.css("height", css_height); //задаём высоту модальному окну
        modal_height = modal_window_all.outerHeight(); //получаем высоту модального окна в пикселях (с учётом паддингов), уже после того как задали высоту в 75%
        css_top = (win_height - modal_height) / 2; //растояние между верхом модального окна и верхом окна браузера
        css_left = win_width * 0.1; //растоние между левым краем модального окна и лнвым краем окна браузера в 10% от ширины окна браузера
        modal_window_all.css("left", css_left); //задаём растояние слева для модального окна
    }
    //устанавливает позиция модального окна на странице, пересчитывает эти данные при каждом резайзе
    adres_map_w_h_css();
    data_site.event_listener_for_element(true, ["resize"], [$(window)], adres_map_w_h_css, { passive: true }); //подключаем кастомный слушатель

    //открываем модальное окно
    function open_modal_window(e) {
        e.preventDefault(); //убираем действие по умолчанию
        let parent_adres_blok = $(this).closest(".futer_block_item"), //родительский блок futer_block_item нажатого trigger_open_modal
            modal_window = parent_adres_blok.find(".modal_form"), //модальное окно modal_form для данного trigger_open_modal
            overlay = parent_adres_blok.find(".overlay"), //подложка-фон под модальное окно для данного trigger_open_modal
            map_coment = modal_window.find("div.map_coment"), //блок в котором находится закоментированный iframe с картой для данного trigger_open_modal
            modal_close_img = modal_window.find(".modal_close>img");


        body.toggleClass("zatemnit_scrollbar"); //для body добавляем/убираем класс zatemnit_scrollbar, этот позволит менять цвет скролбара в цвет overlay на время открытия модального окна

        //плавно показываем overlay и по завершении появления overlay запускаем вложенную функцию которая анимирует появление модального окна
        overlay.fadeIn(400, function() {
            modal_window.css({ "display": "block" }).animate({ opacity: 1, top: css_top }, 200, function() {
                if (!modal_close_img.parent().hasClass("dekoder_max")) {
                    data_site.add_to_load_media(modal_close_img, "images"); //декодируем картинку .modal_close>img этого модального окна
                }
                if (!map_coment.hasClass("dobavleno")) {
                    data_site.add_to_load_media(map_coment, "maps"); //декодируем карту для данного modal_window
                }
            }); //показываем модальное окно
        });
        //плавно показываем overlay и по завершении появления overlay запускаем вложенную функцию которая анимирует появление модального окна
        proverka_scrollup = 2; //устанавливаем proverka_scrollup = 2 чтоб скрыть кнопку scrollup при прокрутке, пока открыто модальное окно
        scrollup.css("opacity", "0"); //скрываем кнопку scrollup

        //создаём слушатель для закрытия модального окна
        data_site.event_listener_for_element(true, ["click", "touchend"], [$(".futer_block_item .modal_close"), $(".futer_block_item .overlay")], close_modal_window, { passive: false });
        //создаём слушатель для закрытия модального окна

        //функция закрытие моального окна
        function close_modal_window(e) {
            e.preventDefault(); //убираем действие по умолчанию

            //удаляем слушатель для закрытия модального окна, данный слушатель будет снова добален при новом открытии окна, и это поможет избавиться от бага, что когда overlay постепенно скрываетсмя по нему всё ещё работают клики и он выполняет вункциию close_modal_window и блымает скролбар
            data_site.event_listener_for_element(false, ["click", "touchend"], [$(".futer_block_item .modal_close"), $(".futer_block_item .overlay")], close_modal_window);
            //удаляем слушатель для закрытия модального окна, данный слушатель будет снова добален при новом открытии окна, и это поможет избавиться от бага, что когда overlay постепенно скрываетсмя по нему всё ещё работают клики и он выполняет вункциию close_modal_window и блымает скролбар

            //анимированно скрываем модальное окно modal_form и подложку-фон overlay
            overlay.fadeOut(500); //скрываем подложку-фон overlay для модального окна modal_window
            modal_window.animate({ opacity: 0, top: 0 }, 200, function() {
                $(this).css("display", "none"); //скрываем открытое модальное окно modal_window
                body.toggleClass("zatemnit_scrollbar"); //для body добавляем/убираем класс zatemnit_scrollbar, этот позволит менять цвет скролбара в цвет overlay на время открытия модального окна
                proverka_scrollup = 1; //возвращаем scrollup в стандартный режим при скроле документа
                if ($(document).scrollTop() > 500) { scrollup.css("opacity", ".5"); } //проверяем на сколько прокручен докумен, если больше 500px то плавно показываем кнопку scrollup
            });
            //анимированно скрываем модальное окно modal_form и подложку-фон overlay
        }
        //функция закрытие моального окна
    }
    //открываем модальное окно
    data_site.event_listener_for_element(true, ["click", "touchend"], [$(".trigger_open_modal")], open_modal_window, { passive: false }); //подключаем кастомный слушатель
    //
    //
    //ОТКРЫТИЕ/ЗАКРЫТИЕ МОДАЛЬНОГО ОКНА ПРИ НАЖАТИИ НА АДРЕС В ФУТЕРЕ С ОТЛОЖЕННОЙ ЗАГРУЗКОЙ КАРТЫ
    //
    //

    //
    //
    //РАЗВОРАЧИВАЮЩИЙСЯ БЛОК ТЕКСТА НА СТРАНИЦЕ ПОЛЕЗНАЯ ИНФОРМАЦИЯ
    //
    //
    open_close_razvorot_blok = function(e) {
        e.preventDefault();
        let open_close = $(this),
            sk_text = open_close.siblings(".skritiy_text"),
            open_b = open_close.find(".open"),
            close_b = open_close.find(".close");

        if (sk_text.hasClass("vidno")) {
            sk_text.slideUp(1500, function() {
                open_b.toggleClass("none_display");
                close_b.toggleClass("none_display");
            });
            sk_text.removeClass("vidno");
        } else {
            sk_text.slideDown(1500, function() {
                open_b.toggleClass("none_display");
                close_b.toggleClass("none_display");
            });
            sk_text.addClass("vidno");
        }

    };
    data_site.event_listener_for_element(true, ["click", "touchend"], [$(".open_close")], open_close_razvorot_blok, { passive: false }); //подключаем кастомный слушатель
    //
    //
    //РАЗВОРАЧИВАЮЩИЙСЯ БЛОК ТЕКСТА НА СТРАНИЦЕ ПОЛЕЗНАЯ ИНФОРМАЦИЯ
    //
    //
    /*
    $(document).on("click touchend", function() {
        console.log(data_site);
    });
    */


    //адаптивные таблицы
    ! function(t) {
        t.fn.cardtable = function(a) {
            var s = t.extend({}, { headIndex: 0 }, a);
            return a && a.headIndex ? a.headIndex : 0, this.each(function() {
                var a = t(this);
                if (!a.hasClass("stacktable")) {
                    var d = t(this).prop("class"),
                        e = t("<div></div>");
                    void 0 !== s.myClass && e.addClass(s.myClass);
                    var l, n, r, i, o = "";
                    a.addClass("stacktable large-only"), l = a.find(">caption").clone(), n = a.find(">thead>tr,>tbody>tr,>tfoot>tr,>tr").eq(0), a.siblings().filter(".small-only").remove(), a.find(">tbody>tr").each(function() { "", r = "", i = t(this).prop("class"), t(this).find(">td,>th").each(function(a) { "" !== t(this).html() && (r += '<tr class="' + i + '">', n.find(">td,>th").eq(a).html() ? r += '<td class="st-key">' + n.find(">td,>th").eq(a).html() + "</td>" : r += '<td class="st-key"></td>', r += '<td class="st-val ' + t(this).prop("class") + '">' + t(this).html() + "</td>", r += "</tr>") }), o += '<table class=" ' + d + ' stacktable small-only"><tbody>' + r + "</tbody></table>" }), a.find(">tfoot>tr>td").each(function(a, s) { "" !== t.trim(t(s).text()) && (o += '<table class="' + d + ' stacktable small-only"><tbody><tr><td>' + t(s).html() + "</td></tr></tbody></table>") }), e.prepend(l), e.append(t(o)), a.before(e)
                }
            })
        }, t.fn.stacktable = function(a) {
            var s, d = t.extend({}, { headIndex: 0, displayHeader: !0 }, a);
            return s = a && a.headIndex ? a.headIndex : 0, this.each(function() {
                var a = t(this).prop("class"),
                    e = t('<table class="' + a + ' stacktable small-only"><tbody></tbody></table>');
                void 0 !== d.myClass && e.addClass(d.myClass);
                var l, n, r, i, o, h, c, f = "";
                (l = t(this)).addClass("stacktable large-only"), n = l.find(">caption").clone(), r = l.find(">thead>tr,>tbody>tr,>tfoot>tr").eq(0), c = void 0 === l.data("display-header") ? d.displayHeader : l.data("display-header"), l.find(">tbody>tr, >thead>tr").each(function(a) { i = "", o = "", h = t(this).prop("class"), 0 === a ? c && (f += '<tr class=" ' + h + ' "><th class="st-head-row st-head-row-main" colspan="2">' + t(this).find(">th,>td").eq(s).html() + "</th></tr>") : (t(this).find(">td,>th").each(function(a) { a === s ? i = '<tr class="' + h + '"><th class="st-head-row" colspan="2">' + t(this).html() + "</th></tr>" : "" !== t(this).html() && (o += '<tr class="' + h + '">', r.find(">td,>th").eq(a).html() ? o += '<td class="st-key">' + r.find(">td,>th").eq(a).html() + "</td>" : o += '<td class="st-key"></td>', o += '<td class="st-val ' + t(this).prop("class") + '">' + t(this).html() + "</td>", o += "</tr>") }), f += i + o) }), e.prepend(n), e.append(t(f)), l.before(e)
            })
        }, t.fn.stackcolumns = function(a) {
            var s = t.extend({}, {}, a);
            return this.each(function() {
                var a = t(this),
                    d = a.find(">caption").clone(),
                    e = a.find(">thead>tr,>tbody>tr,>tfoot>tr").eq(0).find(">td,>th").length;
                if (!(e < 3)) {
                    var l = t('<table class="stacktable small-only"></table>');
                    void 0 !== s.myClass && l.addClass(s.myClass), a.addClass("stacktable large-only");
                    for (var n = t("<tbody></tbody>"), r = 1; r < e;) a.find(">thead>tr,>tbody>tr,>tfoot>tr").each(function(a) {
                        var s = t("<tr></tr>");
                        0 === a && s.addClass("st-head-row st-head-row-main");
                        var d = t(this).find(">td,>th").eq(0).clone().addClass("st-key"),
                            e = r;
                        if (t(this).find("*[colspan]").length) {
                            var l = 0;
                            t(this).find(">td,>th").each(function() { var a = t(this).attr("colspan"); if (a ? (a = parseInt(a, 10), e -= a - 1, l + a > r && (e += l + a - r - 1), l += a) : l++, l > r) return !1 })
                        }
                        var i = t(this).find(">td,>th").eq(e).clone().addClass("st-val").removeAttr("colspan");
                        s.append(d, i), n.append(s)
                    }), ++r;
                    l.append(t(n)), l.prepend(d), a.before(l)
                }
            })
        }
    }(jQuery);

    $(".adaptiv_tabls").cardtable()
    //адаптивные таблицы


});
//
//
//запускается после полной загрузки DOM страницы, т.е. DOMContentLoaded произошло. ($(document).ready(function(){}))
//
//