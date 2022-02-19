<?php 
namespace KsnPlugin\base\admin;

use KsnPlugin\KsnPlugin;

class PlaginAdminPage {

	final public function render_page(){ 
		echo KsnPlugin::$instance->moduls_meneger->render_top_script_data();//подключаем верхний код для скриптов
		?>
		<div id="page_wrap">
			<?php
			KsnPlugin::$instance->moduls_meneger->render_menu();//выводим меню
			?>
			<div id="info_block"></div>
			<div id="knopka_sohranit">
				<div class="upload">Обновить настройки</div>
			</div>
			<div id="show_wp_naw_wrap">
				<div id="show_wp_naw"></div>
			</div>
			<div id="main_settings_wraper">
			<?php
				KsnPlugin::$instance->moduls_meneger->render_modul_settings_block();//выводим все страницы натсроек модулей
			?>
			</div>
			<!-- кнопка вверх -->
		    <div id="scrollup">
		        <img src="<?php echo KSN_ASSETS_URL; ?>/img/btn_up.svg">
		    </div>
		    <!-- кнопка вверх -->
		    <div class="pop_up">
		    	<div class="pop_up_window">
		    		<div class="pop_up_content"></div>
		    	</div>
		    	<div class="pop_up_close"></div>
		    	<div class="pop_up_overlay"></div>
		    </div>
		</div>
		<?php
	}
}

?>