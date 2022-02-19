<?php use KsnPlugin\KsnPlugin;
//Онлайн чат ?>
<div id="online_chat">

	<?php //Установка чата Jivosite ?>
	<div class="settings_wrap">
		<h2>Установка чата Jivosite</h2>

		<?php //Включить чат jivosite ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить чат jivosite?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'integrations', 'online_chat_active'); ?>
	 			<div class='description_setting'></div>
			</div>
		</div>
		<?php //Включить чат jivosite ?>

		<?php //Вставьте идентификатор чата jivosite ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Вставьте идентификатор чата jivosite</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['string', 'small_input'], 'integrations', 'online_chat_id', null, true, 'YCmOUmdmDv'); ?>
	 			<div class='description_setting'>
	 				Сюда необходимо вставить идентификатор Вашего чата, в примере выделен <span class="vazho_red" style="font-weight: 500;">цветом</span>: <b>&lt;script src="//code-ru1.jivosite.com/widget/<span class="vazho_red">YCmOUmdmDv</span>" async &gt;&lt;/script&gt;</b><br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> данный код Вы можете получить в личном кабинете jivosite, для этого: 
				  <ol>
				    <li>авторизуйтесь на сайте <a href="https://www.jivosite.com/" target="_blunk">jivosite.com</a></li>
				    <li>перейдите по <a href="https://app.jivosite.com/settings/channels" target="_blunk">ссылке</a></li>
				    <li>перед Вами появится список всех Ваших каналов jivosite выбрав канал нужного сайта нажмите "Настройки", данная кнопка находится слевой стороны сразу под адресом сайта канала</li>
				    <li>после появится список настроек "Опции", Вам же нужно из списка настроек, слевой стороны, выбрать "Установка"</li>
				    <li>тут Вы уже можете видеть код который Вам и нужен (пример: &lt;script src="//code-ru1.jivosite.com/widget/YCmOUmdmDv" async &gt;&lt;/script&gt;)</li>
				    <li>в нём нас интересует этот идентификатор <span class="vazho_red">YCmOUmdmDv</span> , его Вы и вставляете в поле выше.</li>
				  </ol>
	 			</div>
			</div>
		</div>
		<?php //Вставьте идентификатор чата jivosite ?>

	</div>
	<?php //Установка чата Jivosite ?>
	
</div>
<?php //Онлайн чат ?>