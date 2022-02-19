<?php use KsnPlugin\KsnPlugin;
//Настройка кеша ?>
<div id="nastroyki_cecha">
	<?php //Кеш на сайте ?>
	<div class="settings_wrap">
		<h2>Статический кеш на сайте</h2>

		<?php //Включение кеша ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить статический кеш на сайте?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'cache', 'cache_active', "main_caching_active"); ?>
	 			<div class='description_setting'>При включении данной функции страницы сайта будут отдавать статические HTML версии, которые будут хранится на сервере. Данная функция значительно ускоряет работу сайта!</div>
			</div>
		</div>
		<?php //Включение кеша ?>

		<?php //Включение планового кеширования ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить плановое кеширование?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'cache', 'cache_planed_update', "active_planed_caching", false); ?>
	 			<div class='description_setting'>Если Вы часто обновляете файлы темы, плагинов, движка, а так же настроки в других плагинах которые влияют на пользовательскую часть сайта, рекомендую включить планове кеширование чтоб, даже если Вы в ручную забудите обновить кеш, кеш автоматически был пересоздан через определённый интервал времени.</div>
			</div>
		</div>
		<?php //Включение планового кеширования ?>

		<?php //Включение планового кеширования ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class="title_setting no_status_active">Интервал планового кеширвоания:</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['number', "small_number", 'min="1" max="100"'], 'cache', 'cache_reload_iterval_days', "interval_cron_ceche_update", false, 'Дней'); ?>
	 			<div class='description_setting'>Как часто должно происходить планове кеширование? Я рекомендую каждые сутки если у Вас относитьно небольшой сайт до 100 страниц и каждые 3-5 дней если у Вас большой ресурс свыше 100 страниц. <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> если у Вас производительный сервер можно обновлять каждый день даже при 1000 страницах, но тут встаёт вопрос "а нужно ли это?", ведь кеш нужно чистить только при изменение файлов на сервере или настроек в других плагинх. Если Вы обновили содержимое страницы то её кеш будет пересоздан в этот момент, если Вы создали новую страницу то её кеш так же будет создан, если Вы измените настрйоки в данном плагине то он Вам сообщит если данная настрйока повлияна на пользовательскую часть и выведет сообщение о необходимость обновить кеш)</div>
			</div>
		</div>
		<?php //Включение планового кеширования ?>

	</div>
	<?php //Кеш на сайте ?>

	<?php //Кеширование страниц сайта ?>
	<?php
	global $wpdb;
	$table_name = KSN_DB_TABLE;//наша таблица в бд
	$cache_last_update_time = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("cache", "cache_last_update_time");//получаем значение настройки из бд
	if($cache_last_update_time != ""){
		$time = date("d.m.Y  H:i:s", $cache_last_update_time);
	}
	?>
	<div class="settings_wrap">
		<h2 class="no_triger">Кеширование страниц сайта</h2>
		<div class="setting_blok">
	  		<div class="flex_display">
	    		<div class="title_setting no_status_active">Начать кеширование страниц сайта</div>
	    		<div id="button_request_cache_to_server" class="update_hidden">Начать</div>
	    		<div id="button_request_abort_caching" class="update_hidden hide_button">Прервать</div>
	    		<div id="clear_full_cache_checkbox" class="checkbox_wrap">
				  	<label for="clear_full_cache" title="Если вы влючите данный пункт то все вайлы кеша будут не перезаписанны, а полностью посторены заново с иерархией папок!">Создать кеш с нуля, удалив все прежние файлы?</label>
				  	<input class="not_be_setting_for_save" type="checkbox" id="clear_full_cache">
				</div>
	    		<div id="progres_cache">
	    			<div class="line_progress"></div>
	    			<div class="text_progress">0%</div>
	    		</div>
	    		<div id="caching_log">
	    			<div class="log_area">
	    				<?php if($cache_last_update_time != ""){ ?>
						<span class="green log_messege">Дата последнего успешного кеширования: <?php echo $time; ?> по МСК</span>
	    				<br>
						<?php  } ?>
	    			</div>
	    		</div>
	  		</div>
	  		<div class="description_setting"></div>
	  		<?php //Обновление версии фалов стилей и скриптов для пользователя ?>
		</div>
	</div>
	<?php //Кеширование страниц сайта ?>
</div>
<?php //Настройка кеша ?>		