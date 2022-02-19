<?php 
namespace KsnPlugin\base\site;

use KsnPlugin\KsnPlugin;

class Footer {
	public function run(){
		add_action('wp_footer', [$this, 'add_code_in_footer'], 99);
	}

	//поместим в footer
	public function add_code_in_footer(){
	//определяем плотность пикселей
	if( KsnPlugin::$instance->main_func->get_ksn_site_settings_data('site_settings', 'retina_active') == "yes" ){ ?>
		<!--определяем плотность пикселей-->
		<script>data_site.dpr = window.devicePixelRatio ? window.devicePixelRatio : 1;</script>
		<!--определяем плотность пикселей-->
	<?php } else { ?>
		<!--определяем плотность пикселей-->
		<script>data_site.dpr = 1;</script>
		<!--определяем плотность пикселей-->
	<?php }
	//определяем плотность пикселей

	//Онлайн чат
	if( KsnPlugin::$instance->main_func->get_ksn_site_settings_data('integrations', 'online_chat_active') == "yes" && !empty(KsnPlugin::$instance->main_func->get_ksn_site_settings_data('integrations', 'online_chat_id')) ){ ?>
	<!--Онлайн чат-->
	<script>
	(function(){ document.jivositeloaded=0;var widget_id = '<?php echo KsnPlugin::$instance->main_func->get_ksn_site_settings_data('integrations', 'online_chat_id'); ?>';var d=document;var w=window;function l(){var s = d.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
	function zy(){
	    if(w.detachEvent){
	        w.detachEvent('onscroll',zy);
	        w.detachEvent('onmousemove',zy);
	        w.detachEvent('ontouchmove',zy);
	        w.detachEvent('onresize',zy);
	    }else {
	        w.removeEventListener("scroll", zy, false);
	        w.removeEventListener("mousemove", zy, false);
	        w.removeEventListener("touchmove", zy, false);
	        w.removeEventListener("resize", zy, false);
	    }
	    if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}
	    var cookie_date = new Date ( );
	    cookie_date.setTime ( cookie_date.getTime()+60*60*28*1000);
	    d.cookie = "JivoSiteLoaded=1;path=/;expires=" + cookie_date.toGMTString();
	}
	if (d.cookie.search ( 'JivoSiteLoaded' )<0){
	    if(w.attachEvent){
	        w.attachEvent('onscroll',zy);
	        w.attachEvent('onmousemove',zy);
	        w.attachEvent('ontouchmove',zy);
	        w.attachEvent('onresize',zy);
	    }else {
	        w.addEventListener("scroll", zy, {capture: false, passive: true});
	        w.addEventListener("mousemove", zy, {capture: false, passive: true});
	        w.addEventListener("touchmove", zy, {capture: false, passive: true});
	        w.addEventListener("resize", zy, {capture: false, passive: true});
	    }
	}else {zy();}
	})();</script>
	<!--Онлайн чат-->
	<?php }
	//Онлайн чат
	}
	//поместим в footer
}

?>