<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Base_Data_Control;

class Control_vibor_shablona_bloka extends Base_Data_Control {


	const control_vibor_shablona_bloka = 'control_vibor_shablona_bloka';

    public function get_type() {
        return 'control_vibor_shablona_bloka';
    }

	public function enqueue() {
		wp_register_script( 'control_vibor_shablona_bloka', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/js/control_vibor_shablona_bloka.js', array( 'jquery' ), true );
		wp_enqueue_script( 'control_vibor_shablona_bloka' );
		wp_register_style( 'control_vibor_shablona_bloka', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/css/control_vibor_shablona_bloka.css', array(), '1', 'all');
        wp_enqueue_style( 'control_vibor_shablona_bloka' );
	}

	public function content_template() {
		$img_url = KSN_ELEMENTOR_ADDON_URL.'/controls/assets/img';
		?>
		<# if ( data.label ) { #>
		<div class="gotovie_bloki_title">{{{ data.label }}}</div>
		<br>
		<# } #>
		<div class="elementor-control-field">
			<div id="wrap_gotovie_bloki">
				<# if ( data.spisok ) { #>
	                <# _.each( data.spisok, function( item ) { #>
	                <div class="gotovie_bloki {{item.id}}">{{{item.opisanie_id}}}</div>
					<# }); #>
            	<# } #>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>

		<?php
	}

}