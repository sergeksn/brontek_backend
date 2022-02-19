<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<div id="schetchik">0</div>
	<script>
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
//выпоняем запрос на сервер и возвращаем ответ с сервера
//options - объект со значениями для отправки на сервер
//time_to_out - таймаут для ответа, т.е. максимальное количество миллисикунд данное на ответ, иначер вызовется ontimeout
function request_to_server(options, time_to_out = null) {
    const request = new XMLHttpRequest(); //сам запрос

    request.open("POST", "/wp-content/plugins/ksn_site_control/ajax_proverka.php"); //начало запроса

    if (time_to_out) {
        request.timeout = time_to_out; //время на выполнения запроса 15 сек, если не успеет то прерываем и выводим ошибку
    }

    request.send(getFormData(options)); //отправка запроса

    return new Promise((resolve, reject) => {
        request.onload = function() { resolve(request); };
        request.ontimeout = function() { reject("timeout"); };
        request.onerror = function() { reject(request); };
    });
}
//выпоняем запрос на сервер и возвращаем ответ с сервера

function goo(){
	let div = document.querySelector("#schetchik"),
		schet = div.innerHTML;
	
	let zapros = request_to_server({
		action: "start",
		data: schet
	});
	zapros.then((request) => {
		//console.log(request.response);
		div.innerHTML = request.response;
		goo();
	});
	
}
//goo();

	</script>
</body>
</html>