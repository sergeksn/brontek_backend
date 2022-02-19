<?php 

//создаём подключение к редису
    function connect_redis(){

        $redis = new \Redis();//содаём новый объект редиса
        //$redis->connect('localhost', 6379);//подключаемся к редису

        if($redis->connect('localhost', 6379) === false){
        	file_put_contents("D:\OpenServer\domains\peter.ru\wp-content\plugins\ksn_site_control/redis_error.txt", "yes");
        }


        $data = $redis->get("test_data") ?? 0;

        $redis->set("test_data",  $data+1);

        return $redis; //вернём объект редиса
    }
    //создаём подключение к редису
    connect_redis();
?>