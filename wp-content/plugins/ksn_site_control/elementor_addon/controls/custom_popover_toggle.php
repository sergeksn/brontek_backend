<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Base_Data_Control;

class Custom_Popover_Toggle extends Base_Data_Control {

    const POPOVER_TOGGLE = 'popover_toggle';

    public function get_type() {
        return 'popover_toggle';
    }

    public function enqueue() {
        wp_register_style( 'custom_popover_toggle', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/css/custom_popover_toggle.css', array(), '1', 'all');
        wp_enqueue_style( 'custom_popover_toggle' );
    }

    protected function get_default_settings() {
        return [
            'return_value' => 'yes',
            'castom_type' => '1',
        ];
    }

    public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
        <# if ( data.castom_type == 1 ) { #>
        <div class="elementor-control-field">
            <label class="elementor-control-title" for="<?php echo $control_uid; ?>-custom">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <input id="<?php echo $control_uid; ?>-custom" class="elementor-control-popover-toggle-toggle" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ data.return_value }}">
                <label class="elementor-control-popover-toggle-toggle-label elementor-control-unit-1" for="<?php echo $control_uid; ?>-custom">
                    <i class="eicon-edit" aria-hidden="true"></i>
                    <span class="elementor-screen-only"><?php echo __( 'Edit', 'elementor' ); ?></span>
                </label>
                <input id="<?php echo $control_uid; ?>-default" class="elementor-control-popover-toggle-reset" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="">
                <label class="elementor-control-popover-toggle-reset-label tooltip-target" for="<?php echo $control_uid; ?>-default" data-tooltip="<?php echo __( 'Back to default', 'elementor' ); ?>" data-tooltip-pos="s">
                    <i class="eicon-undo" aria-hidden="true"></i>
                    <span class="elementor-screen-only"><?php echo __( 'Back to default', 'elementor' ); ?></span>
                </label>
            </div>
        </div>
        <# } else if ( data.castom_type == 2 ) { #>
        <div class="elementor-control-field custom_popover">
            <label class="elementor-control-title castom_label" for="<?php echo $control_uid; ?>-custom">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <input id="<?php echo $control_uid; ?>-custom" class="elementor-control-popover-toggle-toggle" type="radio" name="elementor-choose-{{ data.name }}-{{ data._cid }}" value="{{ data.return_value }}">
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <# } #>
        <?php
    }
}
