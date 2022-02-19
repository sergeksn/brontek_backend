<?php 
namespace KsnPlugin\moduls\seo_metrics\base;

use KsnPlugin\KsnPlugin;
use KsnPlugin\moduls\Plagin_Moduls_Meneger;

class Functions extends Plagin_Moduls_Meneger{

	public static $analitics_active = [];

	public static $standart_load_analitics = [];//сюда записываем аналитики для стандартной загрузки

	public static $lazy_load_analitics = [];//сюда записываем аналитики для отложеной загрузки

	public function __construct(){
		self::$analitics_active['google'] = (KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'google_analitica_active') == "yes" && !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'google_analitica_id'))) ? "yes" : "no";
		self::$analitics_active['yandex'] = (KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'yandex_metrika_active') == "yes" && !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'yandex_metrika_id'))) ? "yes" : "no";
		self::$analitics_active['facebook'] = (KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'facebook_pixel_active') == "yes" && !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'facebook_pixel_id'))) ? "yes" : "no";
		self::$analitics_active['vk'] = (KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'vk_pixel_active') == "yes" && !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'vk_pixel_id'))) ? "yes" : "no";

		//распределяем аналитики в отложенную или в обычную загрузку и записываем функции для рендера кода во фронтенд
		foreach(self::$analitics_active as $analitic => $active){
			if($active === "yes"){
				KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', $analitic.'_lazy_load') == "yes" ? self::$lazy_load_analitics[$analitic] = "add_".$analitic : self::$standart_load_analitics[$analitic] = "add_".$analitic;
			}
		}
		//распределяем аналитики в отложенную или в обычную загрузку и записываем функции для рендера кода во фронтенд

		//если в массиве стандартной загрузки аналитик есть элементы то создаём действие
		if(self::$standart_load_analitics){
			add_action('wp_head', [$this, 'add_standart_analitics_on_page'], 99);
		}
		//если в массиве стандартной загрузки аналитик есть элементы то создаём действие

		//если в массиве отложеной загрузки аналитик есть элементы то создаём действие
		if(self::$lazy_load_analitics){
			add_action('wp_footer', [$this, 'add_lazy_analitics_on_page'], 99);
		}
		//если в массиве отложеной загрузки аналитик есть элементы то создаём действие
	}

	//добавляем код метрик стандартно
	public function add_standart_analitics_on_page(){
		global $post;
		$postid = $post->ID;
		$post_status = get_post_status($postid);
		// проверяем опубликована ли страница
		if ( $post_status === 'publish' ) {
			echo "<!--Блок с метриками-->
			<script>";
			//перебираем массив с аналитиками
			foreach(self::$standart_load_analitics as $render_func){
				$this->$render_func();
			}
			//перебираем массив с аналитиками
			echo "</script>
			<!--Блок с метриками-->";
			echo PHP_EOL;//конец строки
		}
		// проверяем опубликована ли страница
	}
	//добавляем код метрик стандартно

	//добавляем код метрик в низ сайта через wp_footer
	public function add_lazy_analitics_on_page(){
		global $post;
		$postid = $post->ID;
		$post_status = get_post_status($postid);
		// проверяем опубликована ли страница
		if ( $post_status === 'publish' ) {
			echo "<!--Блок с метриками-->
			<script>
			(function() {
			    var check_load_analitiks = false,
			        timerId;
			    if (navigator.userAgent.indexOf('YandexMetrika') > -1) {
			        load_analitics();
			    } else {
			        window.addEventListener('scroll', load_analitics, { passive: true });
			        window.addEventListener('touchstart', load_analitics, { passive: true });
			        document.addEventListener('mouseenter', load_analitics, { passive: true });
			        document.addEventListener('click', load_analitics, { passive: true });
			        document.addEventListener('DOMContentLoaded', automatic_load_analitics, { passive: true });
			    }

			    function automatic_load_analitics() {
			        timerId = setTimeout(load_analitics, 5000);
			    }

			    function load_analitics(e) {

			        if (check_load_analitiks) {
			            return;
			        }

			        setTimeout( function() {\n";
		    	//перебираем массив с аналитиками
				foreach(self::$lazy_load_analitics as $render_func){
					$this->$render_func();
				}
				//перебираем массив с аналитиками
				echo "}, 100 );

			        check_load_analitiks = true;
			        clearTimeout(timerId);
			        window.removeEventListener('scroll', load_analitics, { passive: true });
			        window.removeEventListener('touchstart', load_analitics, { passive: true });
			        document.removeEventListener('mouseenter', load_analitics, { passive: true });
			        document.removeEventListener('click', load_analitics, { passive: true });
			        document.removeEventListener('DOMContentLoaded', automatic_load_analitics, { passive: true });
			    }
			})();
			</script>
			<!--Блок с метриками-->";
		}
		// проверяем опубликована ли страница
	}
	//добавляем код метрик в низ сайта через wp_footer

	//гугл аналитика
	public function add_google() { 
		$id = KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'google_analitica_id');
	?>	
	/*гугл аналитика*/			
	var analyticsId = "<?php echo $id; ?>";
	var a = document.createElement("script");
	function e() {
	    dataLayer.push(arguments);
	}
	(a.src = "https://www.googletagmanager.com/gtag/js?id=" + analyticsId),
	(a.async = !0),
	document.getElementsByTagName("head")[0].appendChild(a),
	    (window.dataLayer = window.dataLayer || []),
	    e("js", new Date()),
	    e("config", analyticsId);
	    /*гугл аналитика*/			
	<?php
	}
	//гугл аналитика

	//яндекс метрика
	public function add_yandex() {
		$id = KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'yandex_metrika_id');
		$webvisor_check = KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'yandex_metrika_webvisor');
		$webvisor = $webvisor_check == "yes" ? 'webvisor:true, ' : null;
	?>
	/*яндекс метрика*/
	var metricaId = "<?php echo $id; ?>";
	(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");
	ym( metricaId, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, <?php echo $webvisor; ?>triggerEvent:true });
	/*яндекс метрика*/		
	<?php
	}
	//яндекс метрика

	//фейсбук пиксель
	public function add_facebook() {
		$id = KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'facebook_pixel_id');
	?>
	/*фейсбук пиксель*/
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};
	if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
	n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];
	s.parentNode.insertBefore(t,s)}(window, document,'script',
	'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '<?php echo $id; ?>');
	fbq('track', 'PageView');
	/*фейсбук пиксель*/	
	<?php
	}
	//фейсбук пиксель

	//вк пиксель
	public function add_vk() {
		$id = KsnPlugin::$instance->main_func->get_ksn_site_settings_data('seo', 'vk_pixel_id');
	?>
	/*вк пиксель*/
	!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?162",t.onload=function(){VK.Retargeting.Init("<?php echo $id; ?>"),VK.Retargeting.Hit()},document.head.appendChild(t)}();
	/*вк пиксель*/
	<?php
	}
	//вк пиксель
}

?>