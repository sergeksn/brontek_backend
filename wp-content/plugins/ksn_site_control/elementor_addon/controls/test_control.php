<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Control_Base_Multiple;

class Test_control extends Control_Base_Multiple {

    const test_control = 'test_control';

    public function get_type() {
        return 'test_control';
    }
    public function enqueue() {
        wp_enqueue_media();
        wp_enqueue_script( 'thickbox' );
        wp_enqueue_style( 'thickbox' );
        wp_register_script( 'custom_media_uploader', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/js/custom_media_uploader.js', [ 'jquery' ], true );
        wp_enqueue_script( 'custom_media_uploader', array( 'jquery' ) );
        wp_register_style( 'custom_media_uploader', KSN_ELEMENTOR_ADDON_URL.'/controls/assets/css/custom_media_uploader.css', array(), '1', 'all');
        wp_enqueue_style( 'custom_media_uploader' );
    }

    public function get_default_value() {
        return [
            'url' => '',
            'id' => '',
        ];
    }


    protected function get_default_settings() {
        return [
            'button_text' => 'Выбрать картинку',
            'toggle' => true,
        ];
    }

    public function content_template() {
        $default_image = KSN_ELEMENTOR_ADDON_URL.'/controls/assets/img/placeholder/placeholder_1.png';
        ?>

<div class="elementor-control-title">{{{ data.label }}}</div>
<div class="conteiner_upload_media_fill">
    <div class="upload_media_fill" data-mime-types="{{{ data.media_type }}}">
        <div class="upload_image">
            <div class="add_circle" title="Добавить медиа">
                <i class="eicon-plus-circle"></i>
            </div>
            <div class="img_prewiv">
            </div>
            <div class="remove_image" title="Удалить">
                <i class="eicon-trash-o"></i>
            </div>
            <div class="wrap_text_vibor">
                <div class="text_vibor_media">{{{ data.button_text }}}</div>
            </div>
        </div>
        <input class="custom_input_wp_media" type="hidden" name="" id="" data-setting="{{ data.name }}">
    </div>
</div>
        <?php
    }

}
