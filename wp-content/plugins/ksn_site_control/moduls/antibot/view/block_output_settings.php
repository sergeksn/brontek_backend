<?php use KsnPlugin\KsnPlugin;
//Антибот ?>
<div id="antibot">
	<div class="settings_wrap">
		<h2>Антибот</h2>

		<?php //Включение кеша ?>
		<div class="setting_blok">
			<div class="flex_display">
				<div class='title_setting'>Включить антибот на сайте?</div>
				<?php KsnPlugin::$instance->main_func->setting_output_code('switch', 'security', 'antibot_active', "antibot_include"); ?>
	 			<div class='description_setting'>Тут Вы можете включить антибот на сайте, вход в админку антиботать <a href="<?php echo ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']."/ksn_antibot/admin.php" ?>" target="blank" rel="noopener">здесь</a><br><span class="vazho_red">ПРИМЕЧАНИЕ :</span> антибот позволит Вам блокировать колосальную часть вредоносных ботов которые могут выполнять массу вредоносных задач, таких как:
	 			<ol>
				    <li>накрутка поведенческих факторов;</li>
				    <li>попытка взлома админки;</li>
				    <li>нагрузка на Ваш сервер;</li>
				    <li>искажение статистики в метриках;</li>
				    <li>увеличение показателей отказов;</li>
				  </ol>
				   <br><span class="vazho_red">ВАЖНО :</span> антибот не является защитой от DDOS, для этих целей рекомендую использовать <a href="https://www.cloudflare.com/" target="blank" rel="noopener">Cloudflare</a>, то для чего предназначен антибот можете почитать на сайте разработчика <a href="https://antibot.cloud/" target="blank" rel="noopener">здесь</a> =)</div>
			</div>
		</div>
		<?php //Включение кеша ?>

	</div>
</div>
<?php //Антибот ?>