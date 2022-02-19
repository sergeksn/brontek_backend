<?php 
use KsnPlugin\KsnPlugin;

//Настройки сайта ?>
<div id="nastroyki_site">

	<?php //Разные версии сайта для мобильных, планшетов и пк ?>
	<div class="settings_wrap">
		<h2>Отдельные версии сайта для всех типов устройств</h2>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить мобильную версию?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'site_settings', 'site_mobile_version', 'switch_mobile_site_version'); ?>
	 			<div class='description_setting'>Если выключена, то сервер будет отдавать для мобильных устройств отдельную настроенную версию сайта. Саму версию Вы сможете настроить в конструкторе страниц в соответствующих настройках. <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> ПК версия сайта активна по умолчанию, и в случае если отключена мобильная версия сайта пользователю будет отдаваться версия для ПК. <br><span class="vazho_red">ВАЖНО :</span> Не путайте пожалуйста версию сайта для мобильных устройств с адаптивным дизайном =)</div>
			</div>
		</div>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить планшетную версию?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'site_settings', 'site_tablet_version', 'switch_tablet_site_version'); ?>
	 			<div class='description_setting'>Если выключена, то сервер будет отдавать для планшетных устройств отдельную настроенную версию сайта. Саму версию Вы сможете настроить в конструкторе страниц в соответствующих настройках. <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> ПК версия сайта активна по умолчанию, и в случае если отключена планшетная версия сайта пользователю будет отдаваться версия для ПК. <br><span class="vazho_red">ВАЖНО :</span> Не путайте пожалуйста версию сайта для планшетных устройств с адаптивным дизайном =)</div>
			</div>
		</div>
	</div>
	<?php //Разные версии сайта для мобильных, планшетов и пк ?>

	<?php //Поддержка Retina дисплеев ?>
	<div class="settings_wrap">
		<h2>Поддержка Retina дисплеев</h2>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить поддержку Retina?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'site_settings', 'retina_active'); ?>
	 			<div class='description_setting'>Если выключена, то не будет учитываться тип экрна (retina или нет). Так что в этом случае подходящее изображение будет подбираться основываясь исключительно на размерах экрана устройства пользователя. <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> данная функция добавлена на случай если Вы захотите отказаться от "тяжёлых" картинок на которые ругается Google PageSpeed, чтоб получить максимальную скорось загрузки сайта на мобильных устройствах. Но учитывая качество сжатия картинок и современную скорость интернета можно спокойно оставлять эту опцию во включённом положении, так как визуально смотрится лучше, а разницы в скорости загрузки пользователь почти не замечает =)</div>
			</div>
		</div>
	</div>
	<?php //Поддержка Retina дисплеев ?>

	<?php //Глобальные цвета сайта ?>
	<div class="settings_wrap">
		<h2>Глобальные цвета сайта</h2>

		<?php //Цвет фона сайта ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Цвет фона сайта</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('color', 'site_settings', 'bg_color'); ?>
	 			<div class='description_setting'>Выберете цвет фона сайта, не переживайте Вы всегда можете нажать "По умолчанию" и восстановить исходные настройки =)<br><span class="vazho_red">ПРИМЕЧАНИЕ :</span>данная опция использует CSS переменные и поэтому поддерживается не всеми браузерами. В браузерах в которых не поддерживается будет использован цвет по умолчанию!</div>
			</div>
		</div>
		<?php //Цвет фона сайта ?>

		<?php //Цвет текста на сайте ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Цвет текста на сайте</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('color', 'site_settings', 'text_color'); ?>
	 			<div class='description_setting'>Выберете цвет текстов на сайте, не переживайте Вы всегда можете нажать "По умолчанию" и восстановить исходные настройки =)<br><span class="vazho_red">ПРИМЕЧАНИЕ :</span>данная опция использует CSS переменные и поэтому поддерживается не всеми браузерами. В браузерах в которых не поддерживается будет использован цвет по умолчанию!</div>
			</div>
		</div>
		<?php //Цвет текста на сайте ?>

	</div>
	<?php //Глобальные цвета сайта ?>
	
</div>
<?php //Настройки сайта ?>			