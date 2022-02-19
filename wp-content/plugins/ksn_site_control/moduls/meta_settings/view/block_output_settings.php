<?php use KsnPlugin\KsnPlugin;
//Мета-настройки ?>
<div id="seo_meta">

	<?php //Геотаргетинг сайта ?>
	<div class="settings_wrap">
		<h2>Геотаргетинг сайта</h2>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Гео-мета теги</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code(['textarea', '', 'rows="7"'], 'seo', 'geo_meta_data', null, true, "<meta name='geo.region' content='RU' >
<meta name='geo.placename' content='Екатеринбург' >
<meta name='geo.position' content='56.839104;60.60825' >
<meta name='ICBM' content='56.839104, 60.60825' >"); ?>
	 			<div class='description_setting'><span class="vazho_red">ОЧЕНЬ ВАЖНО :</span> данная настройка для веб-мастера, Вам её изменять <span class="vazho_red">НЕ НУЖНО</span> так как это негативно скажется на ранжировании сайта в целевом регионе <span class="vazho_red">!!!</span></div>
			</div>
		</div>
	</div>
	<?php //Геотаргетинг сайта ?>
	
</div>
<?php //Мета-настройки ?>