<?php use KsnPlugin\KsnPlugin;
//Метрики ?>
<div id="seo_metrics">

	<?php //Гугл аналитика ?>
	<div class="settings_wrap">
		<h2>Google Analytics</h2>

		<?php //Включить гугл аналитику ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить Google Analytics?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'google_analitica_active'); ?>
	 			<div class='description_setting'></div>
			</div>
		</div>
		<?php //Включить гугл аналитику ?>

		<?php //Индентификатор гугл аналитики ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Индентификатор Google Analytics</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['string', 'small_input'], 'seo', 'google_analitica_id', null, true, 'UA-143753537-1'); ?>
	 			<div class='description_setting'>Найти индентификатор Google Analytics можно следующим образом:
				  <ol>
				    <li>авторизуйтесь в свойм аккаунте <a href="https://myaccount.google.com/" target="blank" rel="noopener">Google</a></li>
				    <li>далее перейдите по <a href="https://analytics.google.com/" target="blank" rel="noopener">ссылке</a> чтобы попасть в Google Analytics . <span class="vazho_red">ПРИМЕЧАНИЕ :</span> должен быть авторизован именно тот аккаунт на ктором зарегистрированна Google Analytics иначе Вас просто перебросит на страницу, на которой Вам предложат зарегистрировать новый сайт в Google Analytics</li>
				    <li>на открывшейся странице Google Analytics, в левом нижнем углу, жмёмте кнопку "Администратор"</li>
				    <li>если сайтов на аккаунте более одного можете выбрать требуемый сайт нажав на "Все данные по веб-сайту" сверху</li>
				    <li>затем в центральной колонке ищем пункт "< > Отслеживание", нажимаем на него</li>
				    <li>далее в открывшемся списке нажимаем "Код отслеживания"</li>
				    <li>немного подождав, появится блок в котором и будет требуемый код</li>
				    <li>теперь откройте <div class="pop_up_open metrik_instr_scrin" data-type="img" data-content="<?php echo KSN_ASSETS_URL.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR; ?>google.jpg">скриншот</div>, на нём показан пример кода который Вы должны найти (в пункте 7) и идентификатор выделенный синим цветом</li>
				    <li>вставьте индентификатор в поле выше, теперь Google Analytics атоматически будет помещена в верхнюю часть кода сайта или будет загружена отложенно, вот и всё =)</li>
				  </ol>
				</div>
			</div>
		</div>
		<?php //Индентификатор гугл аналитики ?>

		<?php //Отложенная загрузка Google Analytics ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Запускать Google Analytics отложено?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'google_lazy_load', null, false); ?>
	 			<div class='description_setting'>Если данная настройка включена, все ресурсы Google Analytics на сайте будут грузиться отложенно, а не в момент загрузки страницы. Тем самым мы отсеим визиты с нулевой длительностью, часть запросов ботов и теоритечески уменьшим показатель отказов =)</div>
			</div>
		</div>
		<?php //Отложенная загрузка Google Analytics ?>

		<?php //Код верефикации в гугл консоли ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Код верификации в Google вебмастере (не обязательно)</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['string', 'big_input'], 'seo', 'google_verefi_string', null, false, "<meta name='google-site-verification' content='1f87a5abf78dd43d'>"); ?>
	 			<div class='description_setting'>Это код для поддтверждения сайта в Google вебмастере. На фоне поля выше показа образец необходимой строки. Это требуется чтоб подтвердить Ваше право собственности на данный сайт. <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> это нужно не всегда, но часто это функция будет Вам полезна =)</div>
			</div>
		</div>
		<?php //Код верефикации в гугл консоли ?>

	</div>
	<?php //Гугл аналитика ?>

	<?php //Яндекс метрика ?>
	<div class="settings_wrap">
		<h2>Yandex Метрика</h2>

		<?php //Включить яндекс метрику ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить Yandex метрику?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'yandex_metrika_active'); ?>
	 			<div class='description_setting'></div>
			</div>
		</div>
		<?php //Включить яндекс метрику ?>

		<?php //Индентификатор яндекс метрики ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Индентификатор Yandex метрики</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['string', 'small_input'], 'seo', 'yandex_metrika_id', null, true, '55963306'); ?>
	 			<div class='description_setting'>Найти индентификатор Yandex метрики можно следующим образом:
				  <ol>
				    <li>авторизуйтесь в свойм аккаунте <a href="https://passport.yandex.ru/profile" target="blank" rel="noopener">Yandex</a></li>
				    <li>далее перейдите по <a href="https://metrika.yandex.ru/list/" target="blank" rel="noopener">ссылке</a> чтобы попасть в Yandex метрику. <span class="vazho_red">ПРИМЕЧАНИЕ :</span> должен быть авторизован именно тот аккаунт на ктором зарегистрированна Yandex метрика иначе Вас просто перебросит на страницу, на которой Вам предложат зарегистрировать новый сайт в Yandex метрике</li>
				    <li>на открывшейся странице Yandex метрики выберете сайт который нужен и справой стороны нажмите на шестерёнку</li>
				    <li>откроется страница настроек, по умолчанию открыта вкладка настроек "Счётчик", полистываем страницу ниже</li>
				    <li>добираемся до тёмного блока "Код счетчика"</li>
				    <li>теперь открываем <div class="pop_up_open metrik_instr_scrin" data-type="img" data-content="<?php echo KSN_ASSETS_URL.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR; ?>ym.jpg">скриншот</div> , на нём показан пример кода который Вы увдите, а так же синим цветом выделен идентификатор</li>
				    <li>копируем идентификатор и вставляем в вышестояшие поле, теперь Yandex метрика атоматически будет помещена в верхнюю часть кода сайта или будет загружена отложенно, вот и всё =)</li>
				  </ol>
				</div>
			</div>
		</div>
		<?php //Индентификатор яндекс метрики ?>

		<?php //Включение вебвизора ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить вебвизор?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'yandex_metrika_webvisor', null, false); ?>
	 			<div class='description_setting'><span class="vazho_red">ПРИМЕЧАНИЕ :</span> вебвизор немного замедляет работу сайта, но совесем незначительно. Так что можно его смело использовать, особенно если включена отложенная загрузка метрик!</div>
			</div>
		</div>
		<?php //Включение вебвизора ?>

		<?php //Отложенная загрузка Yandex метрики ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Запускать Yandex метрику отложено?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'yandex_lazy_load', null, false); ?>
	 			<div class='description_setting'>Если данная настройка включена, все ресурсы Yandex метрики на сайте будут грузиться отложенно, а не в момент загрузки страницы. Тем самым мы отсеим визиты с нулевой длительностью, часть запросов ботов и теоритечески уменьшим показатель отказов =)</div>
			</div>
		</div>
		<?php //Отложенная загрузка Yandex метрики ?>

		<?php //Код верефикации в яндекс вебмастере ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Код верификации в Yandex вебмастере (не обязательно)</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['string', 'big_input'], 'seo', 'yandex_verefi_string', null, false, "<meta name='yandex-verification' content='1f87a5abf78dd43d' />"); ?>
	 			<div class='description_setting'>Это код для поддтверждения сайта в Yandex вебмастере. На фоне поля выше показа образец необходимой строки. Это требуется чтоб подтвердить Ваше право собственности на данный сайт. <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> это нужно не всегда, но часто это функция будет Вам полезна =)</div>
			</div>
		</div>
		<?php //Код верефикации в яндекс вебмастере ?>

	</div>
	<?php //Яндекс метрика ?>

	<?php //Facebook пиксель ?>
	<div class="settings_wrap">
		<h2>Facebook пиксель</h2>

		<?php //Включить Facebook пиксель ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Вкючить Facebook пиксель?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'facebook_pixel_active'); ?>
	 			<div class='description_setting'><span class="vazho_red">ВАЖНО :</span> если Вы НЕ пользуетесь Facebook пикселем то отключите его, так как он необоснованно будет тормозить загрузку сайта!</div>
			</div>
		</div>
		<?php //Включить Facebook пиксель ?>

		<?php //Индентификатор Facebook пикселя ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Индентификатор Facebook пикселя</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['string', 'small_input'], 'seo', 'facebook_pixel_id', null, true, '189120724977942'); ?>
	 			<div class='description_setting'>В расположенном выше текстовом поле втавьте идентификатор Facebook пикселя. На фоне этого поля есть пример идентификатора который нужно вставить. <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> где взять идентификатор Facebook пикселя уточните у Вашего специалиста по социальным сетям, так как предоставленная мною информация может быть не актуальна со временем =)</div>
			</div>
		</div>
		<?php //Индентификатор Facebook пикселя ?>

		<?php //Отложенная загрузка Facebook пикселя ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Запускать Facebook пиксель отложено?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'facebook_lazy_load', null, false); ?>
	 			<div class='description_setting'>Если данная настройка включена, все ресурсы Facebook пикселя на сайте будут грузиться отложенно, а не в момент загрузки страницы.</div>
			</div>
		</div>
		<?php //Отложенная загрузка Facebook пикселя ?>

	</div>
	<?php //Facebook пиксель ?>

	<?php //ВК пиксель ?>
	<div class="settings_wrap">
		<h2>ВК пиксель</h2>

		<?php //Включить ВК пиксель ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Вкючить ВК пиксель?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'vk_pixel_active'); ?>
	 			<div class='description_setting'><span class="vazho_red">ВАЖНО :</span> если Вы НЕ пользуетесь ВК пикселем то отключите его, так как он необоснованно будет тормозить загрузку сайта!</div>
			</div>
		</div>
		<?php //Включить ВК пиксель ?>

		<?php //Индентификатор ВК пикселя ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Индентификатор ВК пикселя</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['string', 'small_input'], 'seo', 'vk_pixel_id', null, true, 'VK-RTRG-426442-43Io9'); ?>
	 			<div class='description_setting'>В расположенном выше текстовом поле втавьте идентификатор ВК пикселя. На фоне этого поля есть пример идентификатора который нужно вставить. <br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> где взять идентификатор ВК пикселя уточните у Вашего специалиста по социальным сетям, так как предоставленная мною информация может быть не актуальна со временем =)</div>
			</div>
		</div>
		<?php //Индентификатор ВК пикселя ?>

		<?php //Отложенная загрузка ВК пикселя ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Запускать ВК пиксель отложено?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'seo', 'vk_lazy_load', null, false); ?>
	 			<div class='description_setting'>Если данная настройка включена, все ресурсы ВК пикселя на сайте будут грузиться отложенно, а не в момент загрузки страницы.</div>
			</div>
		</div>
		<?php //Отложенная загрузка ВК пикселя ?>

	</div>
	<?php //ВК пиксель ?>
	
</div>
<?php //Метрики ?>