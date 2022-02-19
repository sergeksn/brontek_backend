<?php 
namespace KsnPlugin\base\site;

use KsnPlugin\KsnPlugin;

class Header {
	public function run(){
		add_action('wp_head', [$this, 'add_code_in_head'], 99);
	}

	//поместим в header
	public function add_code_in_head(){
	// Гугл верификация 
	if( !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'google_verefi_string'))){ ?>
		<!--верификация в гугле-->
	    <?php echo KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'google_verefi_string'); ?>
		<?php echo PHP_EOL;//конец строки ?><!--верификация в гугле-->
	<?php }
	// Гугл верификация

	// Яндекс верификация
	if( !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'yandex_verefi_string'))){ ?>
	    <!--верификация в яндексе-->
	    <?php echo KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'yandex_verefi_string'); ?>
	    <?php echo PHP_EOL;//конец строки ?><!--верификация в яндексе-->
	<?php }
	// Яндекс верификация

	// Геотаргетинг
	if( !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'geo_meta_data'))){ ?>
	    <!--Геотаргетинг-->
	    <?php echo KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'geo_meta_data'); ?>
	     <?php echo PHP_EOL;//конец строки ?><!--Геотаргетинг-->
	<?php }
	// Геотаргетинг

	//в поддерживаемых браузерх доступны пользовательские глобальные настройки из плагина конструктора. Вывод переменных var(--bg-color)
	//.PHP_EOL перенос строки в php
	?>
	<!--глобальные переменные стилей-->
	<style>
	    :root {
	    	<?php if(!empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('site_settings', 'bg_color'))){ echo "--bg-color:".KsnPlugin::$instance->main_func->get_ksn_site_settings_data('site_settings', 'bg_color').";".PHP_EOL; } else { echo "--bg-color:#06131c;".PHP_EOL; } ?>
	        <?php if(!empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('site_settings', 'text_color'))){ echo "--t-color:".KsnPlugin::$instance->main_func->get_ksn_site_settings_data('site_settings', 'text_color').";".PHP_EOL; } else { echo "--t-color:#ffffff;".PHP_EOL; } ?>
	    }
	</style>
	<!--глобальные переменные стилей-->
	<?php
	//в поддерживаемых браузерх доступны пользовательские глобальные настройки из плагина конструктора. Вывод переменных var(--bg-color)
	}
	//поместим в header
}

?>