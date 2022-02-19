<?php use KsnPlugin\KsnPlugin;
//Настройка CSS, JS файлов ?>
<div id="nastroyki_css_js">
	<?php //Обновление версии фалов стилей и скриптов для пользователя ?>
	<?php 
	global $wpdb;
	$table_name = KSN_DB_TABLE;//наша таблица в бд
	$value = KsnPlugin::$instance->main_func->get_ksn_site_settings_data("dop_options", "update_css_js");//получаем значение настройки из бд
	?>
	<div class="settings_wrap">
		<h2 class="no_triger">Обновление версии файлов CSS и JS</h2>
		<div class="setting_blok">
	  		<div class="flex_display">
	    		<div class="title_setting no_status_active">Обновить версию css и js?</div>
	    		<div class="update_hidden data_input" id="update_css_js_versions"><span>Обновить</span></div>
	    		<input type="hidden" data-grup="dop_options" id="update_css_js" value="<?php echo $value; ?>" />
	  		</div>
	  		<div class="description_setting">Эта опция для удобства вебмастера, Вам она не нужна =) <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> данная опция обновляет версию css и js файлов темы на более новую. Это делается с той целью, чтоб у пользователей на устройствах обновились кешированные версии этих файлов. Простыми словами пользователь увидить измения на сайта (дизайна или функционала) без очистки кеша на своём устройстве.</div>
	  		<?php //Обновление версии фалов стилей и скриптов для пользователя ?>
		</div>
	</div>
</div>
<?php //Настройка CSS, JS файлов ?>	