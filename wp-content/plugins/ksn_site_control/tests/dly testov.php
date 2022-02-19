<?php 
		require_once "D:\OpenServer\domains\peter.ru\wp-content\plugins\ksn_site_control\moduls\caching\base/functions.php";
		$test = new \KsnPlugin\moduls\caching\base\Functions;
		$path = "D:\OpenServer\domains\peter.ru\wp-content\plugins\ksn_site_control\moduls\caching\base";
		$divises = ["desktop"];// "mobile", "tablet"

		$parser = new \simple_html_dom();

		foreach($divises as $divise) {
			$contents = $test->curl("http://peter.ru/mojka-avtomobilja/", $divise);//получаем код страницы из $url в виде строки
			$parser->load($contents);
			$head = $parser->find("head");
			$body = $parser->find("body");

			$header = $body->find()


			$contents = '<html>'.$head[0].$body[0].'</html>';
			
			//$contents = $html->save();
			//print_r($collection);

			file_put_contents( $path . '/index_'.$divise.'.html', $contents );//создаёт файл index.html и записываем данные в файл index.html
		}

 ?>