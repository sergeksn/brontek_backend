<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Base_Data_Control;
use Elementor\Plugin;

class Custom_Repeater extends Base_Data_Control {

	const REPEATER = 'repeater';

	public function get_type() {
		return 'repeater';
	}

	public function get_default_value() {
		return [];
	}

	protected function get_default_settings() {
		return [
			'fields' => [],
			'title_field' => '',
			'prevent_empty' => true,
			'is_repeater' => true,
			'item_actions' => [
				'add' => true,
				'duplicate' => true,
				'remove' => true,
				'sort' => true,
			],
		];
	}

	/**
	 * Get repeater control value.
	 *
	 * Retrieve the value of the repeater control from a specific Controls_Stack.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $control  Control
	 * @param array $settings Controls_Stack settings
	 *
	 * @return mixed Control values.
	 */
	public function get_value( $control, $settings ) {
		$value = parent::get_value( $control, $settings );

		if ( ! empty( $value ) ) {
			foreach ( $value as &$item ) {
				foreach ( $control['fields'] as $field ) {
					$control_obj = Plugin::$instance->controls_manager->get_control( $field['type'] );

					// Prior to 1.5.0 the fields may contains non-data controls.
					if ( ! $control_obj instanceof Base_Data_Control ) {
						continue;
					}

					$item[ $field['name'] ] = $control_obj->get_value( $field, $item );
				}
			}
		}

		return $value;
	}

	public function on_import( $settings, $control_data = [] ) {
		if ( empty( $settings ) || empty( $control_data['fields'] ) ) {
			return $settings;
		}

		$method = 'on_import';

		foreach ( $settings as &$item ) {
			foreach ( $control_data['fields'] as $field ) {
				if ( empty( $field['name'] ) || empty( $item[ $field['name'] ] ) ) {
					continue;
				}

				$control_obj = Plugin::$instance->controls_manager->get_control( $field['type'] );

				if ( ! $control_obj ) {
					continue;
				}

				if ( method_exists( $control_obj, $method ) ) {
					$item[ $field['name'] ] = $control_obj->{$method}( $item[ $field['name'] ], $field );
				}
			}
		}

		return $settings;
	}

	public function content_template() {
		?>
		<label>
			<span class="elementor-control-title">{{{ data.label }}}</span>
		</label>
		<div class="elementor-repeater-fields-wrapper"></div>
		<# if ( itemActions.add ) { #>
			<div class="elementor-button-wrapper">
				<button class="elementor-button elementor-button-default elementor-repeater-add" type="button">
					<i class="eicon-plus" aria-hidden="true"></i><?php echo __( 'Add Item', 'elementor' ); ?>
				</button>
			</div>
		<# } #>
		<# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
		<?php
	}
}
