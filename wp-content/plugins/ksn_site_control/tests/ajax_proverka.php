<?php 

$action = $_POST['action'] ?? null;
$data = $_POST['data'] ?? null;


//создаём подключение к редису
function connect_redis(){
    $redis = new \Redis();//содаём новый объект редиса
    $redis->connect('localhost', 6379);//подключаемся к редису
    return $redis; //вернём объект редиса
}
//создаём подключение к редису

//записываем новые значения в редис
function set_redis($data, $hash = null){
    if($data === null){ return; };
    $redis = connect_redis();//подключаемся к редису

    //если задана хеш таблица
    if($hash){
        foreach($data as $key => $value){
            $redis->hSet("$hash", $key, $value);
        }
        return;
    }
    //если задана хеш таблица

    foreach($data as $key => $value){
        $redis->set("$key", $value);
    }
}
//записываем новые значения в редис

for ($i=0; $i < 5000; $i++) { 
    $data = (int)$data+1;
    set_time_limit(60);
    set_redis(["test_data" => $data]);
}


//sleep(1);
die("$data");

?>