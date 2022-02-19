<?php
namespace KSN_Site_Konstruktor\Control;

use Elementor\Control_Base_Multiple;
use Elementor\Modules\DynamicTags\Module as TagsModule;

class Custom_URL extends Control_Base_Multiple {

	const URL = 'url';

	public function get_type() {
		return 'url';
	}

	public function get_default_value() {
		return [
			'url' => '',
			'is_external' => '',
			'nofollow' => '',
			'custom_attributes' => '',
		];
	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
			'placeholder' => __( 'Вставьте URL или начните вводить название страницы сайта', 'elementor' ),
			'autocomplete' => true,
			'options' => [ 'is_external', 'nofollow', 'custom_attributes' ],
			'dynamic' => [
				'categories' => [ TagsModule::URL_CATEGORY ],
				'property' => 'url',
			],
			'custom_attributes_description' => __( 'Установите настраиваемые атрибуты для элемента ссылки. Отделяйте ключи атрибутов от значений с помощью символа | . Разделяйте пары ключ-значение запятой. Это опция для разработчиков, Вам она не нужна =)', 'elementor' )
			. ' <a href="https://go.elementor.com/panel-link-custom-attributes/" target="_blank">' . __( 'Learn More', 'elementor' ) . '</a>',
			'show_custom_attributes_setting' => false,
		];
	}

	/**
	 * Render url control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		$is_external_control_uid = $this->get_control_uid( 'is_external' );
		$nofollow_control_uid = $this->get_control_uid( 'nofollow' );
		$custom_attributes_uid = $this->get_control_uid( 'custom_attributes' );
		?>
		<div class="elementor-control-field elementor-control-url-external-{{{ ( data.options.length || data.show_external ) ? 'show' : 'hide' }}}">
			<label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper elementor-control-dynamic-switcher-wrapper">
				<i class="elementor-control-url-autocomplete-spinner eicon-loading eicon-animation-spin" aria-hidden="true"></i>
				<input id="<?php echo $control_uid; ?>" class="elementor-control-tag-area elementor-input" data-setting="url" placeholder="{{ data.placeholder }}" />
				<input id="_ajax_linking_nonce" type="hidden" value="<?php echo wp_create_nonce( 'internal-linking' ); ?>" />
				<div class="elementor-control-url-more tooltip-target elementor-control-unit-1" data-tooltip="<?php echo __( 'Link Options', 'elementor' ); ?>">
					<i class="eicon-cog" aria-hidden="true"></i>
				</div>
			</div>
			<div class="elementor-control-url-more-options">
				<div class="elementor-control-url-option" style="padding-bottom: 0;">
					<input id="<?php echo $is_external_control_uid; ?>" type="checkbox" class="elementor-control-url-option-input" data-setting="is_external">
					<label for="<?php echo $is_external_control_uid; ?>"><?php echo __( 'Open in new window', 'elementor' ); ?></label>
				</div>
				<div class="elementor-control-field-description" style="margin-top: 5px; margin-bottom: 15px;">Если включить то данная ссылка будет открываться в новой вкладке.</div>
				<div class="elementor-control-url-option" style="padding-bottom: 0;">
					<input id="<?php echo $nofollow_control_uid; ?>" type="checkbox" class="elementor-control-url-option-input" data-setting="nofollow">
					<label for="<?php echo $nofollow_control_uid; ?>"><?php echo __( 'Add nofollow', 'elementor' ); ?></label>
				</div>
				<div class="elementor-control-field-description" style="margin-top: 5px; margin-bottom: 15px;">Если включить то поисковые системы не будут переходить по этой ссылке. Это может быть полезно только в случает указание ссылки на внешний сайт. <br><span class="vazho_red">ВАЖНО:</span> не включайте эту функцию для страниц этого сайта, так как это неправильно покажет внутреннюю перелинковку в глазах поискового робота.</div>
				<# if(data.show_custom_attributes_setting){ #>
				<div class="elementor-control-url__custom-attributes">
					<label for="<?php echo $custom_attributes_uid; ?>" class="elementor-control-url__custom-attributes-label"><?php echo __( 'Custom Attributes', 'elementor' ); ?></label>
					<input type="text" id="<?php echo $custom_attributes_uid; ?>" class="elementor-control-unit-5" placeholder="key|value" data-setting="custom_attributes">
				</div>
				<# if ( ( data.options && -1 !== data.options.indexOf( 'custom_attributes' ) ) && data.custom_attributes_description ) { #>
				<div class="elementor-control-field-description">{{{ data.custom_attributes_description }}}</div>
				<# } #>
				<# } #>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
