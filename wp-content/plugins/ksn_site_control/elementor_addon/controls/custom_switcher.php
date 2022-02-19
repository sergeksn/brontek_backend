<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Base_Data_Control;

class Custom_switcher extends Base_Data_Control {


	const custom_switcher = 'custom_switcher';

    public function get_type() {
        return 'custom_switcher';
    }

	public function enqueue() {
        wp_register_style( 'custom_switcher', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/css/custom_switcher.css', array(), '1', 'all');
        wp_enqueue_style( 'custom_switcher' );
    }

	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="custom_switch_wrapper">
			<div style="max-width: 70%;">{{{ data.label }}}</div>
			<label class="switch">
			  <input class="switch_input" type="checkbox" data-setting="{{ data.name }}" value="{{ data.return_value }}">
			  <span class="slider round"></span>
			  <span class="switch_yes">Да</span>
			  <span class="switch_no">Нет</span>
			</label>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	protected function get_default_settings() {
		return [
			'return_value' => 'yes',
		];
	}
}
