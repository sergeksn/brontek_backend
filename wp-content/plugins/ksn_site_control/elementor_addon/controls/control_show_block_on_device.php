<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Base_Data_Control;

class Control_show_block_on_device extends Base_Data_Control {


	const control_show_block_on_device = 'control_show_block_on_device';

    public function get_type() {
        return 'control_show_block_on_device';
    }

	public function enqueue() {
        wp_register_style( 'custom_switcher', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/css/custom_switcher.css', array(), '1', 'all');
        wp_enqueue_style( 'custom_switcher' );
       	wp_register_script( 'control_show_block_on_device', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/js/control_show_block_on_device.js', [ 'jquery' ], true );
        wp_enqueue_script( 'control_show_block_on_device', array( 'jquery' ) );
    }

	public function get_default_value() {
        return [
            'show_desktop' => 'yes',
            'show_tablet' => 'yes',
            'show_mobile' => 'yes'
        ];
    }

	public function content_template() {
		?>
		<div class="device_select">
			<div>{{{ data.label }}}</div>
			<div class="custom_switch_wrapper" data-switch="show_desktop" style="padding: 10px 0;">
				<div style="max-width: 70%;">Отображать на компьютерах?</div>
				<label class="switch">
				  <input class="switch_input" type="checkbox">
				  <span class="slider round"></span>
				  <span class="switch_yes">Да</span>
				  <span class="switch_no">Нет</span>
				</label>
			</div>
			<div class="custom_switch_wrapper" data-switch="show_tablet" style="padding: 10px 0;">
				<div style="max-width: 70%;">Отображать на планшетах?</div>
				<label class="switch">
				  <input class="switch_input" type="checkbox">
				  <span class="slider round"></span>
				  <span class="switch_yes">Да</span>
				  <span class="switch_no">Нет</span>
				</label>
			</div>
			<div class="custom_switch_wrapper" data-switch="show_mobile" style="padding: 10px 0;">
				<div style="max-width: 70%;">Отображать на мобильных?</div>
				<label class="switch">
				  <input class="switch_input" type="checkbox">
				  <span class="slider round"></span>
				  <span class="switch_yes">Да</span>
				  <span class="switch_no">Нет</span>
				</label>
			</div>
			<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
			<# } #>
		</div>
		<?php
	}
}
