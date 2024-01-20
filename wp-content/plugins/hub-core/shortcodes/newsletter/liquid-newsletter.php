<?php
/**
* Shortcode Newsletter
*/

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

/**
* LD_Shortcode
*/
class LD_Newsletter extends LD_Shortcode {

	/**
	 * [$post_type description]
	 * @var string
	 */
	public $list_id = '';

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		// Properties
		$this->slug        = 'ld_newsletter';
		$this->title       = esc_html__( 'Newsletter', 'landinghub-core' );
		$this->description = esc_html__( 'Create a newsletter.', 'landinghub-core' );
		$this->icon        = 'la la-envelope-open';
		$this->scripts     = 'liquid-mailchimp-form';
		$this->show_settings_on_create = true;

		add_action( 'wp_ajax_add_mailchimp_user', array( $this, 'add_user_to_the_list' ) );
		add_action( 'wp_ajax_nopriv_add_mailchimp_user', array( $this, 'add_user_to_the_list' ) );

		parent::__construct();

	}

	public function get_params() {
		
		$url = liquid_addons()->plugin_uri() . '/assets/img/sc-preview/newsletter/';

		$general = array(

			array(
				'type'        => 'dropdown',
				'param_name'  => 'list_id',
				'heading'     => esc_html__( 'List ID', 'landinghub-core' ),
				'description' => esc_html__( 'Select the list from mailchimp to add emails. The API Key of the Mailchimp should be added in Theme Options', 'landinghub-core' ),
				'value'       => array_merge_recursive( array( 'Select' => '' ) , array_flip( $this->get_mailchimp_lists() ) ),
				'admin_label' => true,
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'use_opt_in',
				'heading'     => esc_html__( 'Use Opt-in?', 'landinghub-core' ),
				'description' => esc_html__( 'Enable this if you checked the Opt-in in mailchimp.com settings also', 'landinghub-core' ),
				'value'       => array( esc_html__( 'Yes', 'landinghub-core' ) => 'yes'  ),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'enable_name_field',
				'heading'     => esc_html__( 'Name field?', 'landinghub-core' ),
				'description' => esc_html__( 'Enable this if you want to show name field', 'landinghub-core' ),
				'value'       => array( esc_html__( 'Yes', 'landinghub-core' ) => 'yes' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'show_inline',
				'heading'     => esc_html__( 'Inline?', 'landinghub-core' ),
				'description' => esc_html__( 'Enable this if you want to show input fields in line', 'landinghub-core' ),
				'value'       => array( esc_html__( 'Yes', 'landinghub-core' ) => 'ld-sf--inputs-inline' ),
				'dependency' => array(
					'element' => 'enable_name_field',
					'value'   => 'yes',
				),
				'edit_field_class' => 'vc_col-sm-6',
			),
			
			array(
				'type'       => 'select_preview',
				'param_name' => 'style',
				'heading'    => esc_html__( 'Input Style', 'landinghub-core' ),
				'value'      => array(

					array(
						'value' => 'bordered',
						'label' => esc_html__( 'Bordered', 'landinghub-core' ),
						'image' => $url . 'input-border.svg'
					),

					array(
						'label' => esc_html__( 'Solid', 'landinghub-core' ),
						'value' => 'solid',
						'image' => $url . 'input-solid.svg'
					),

					array(
						'label' => esc_html__( 'Underlined', 'landinghub-core' ),
						'value' => 'underlined',
						'image' => $url . 'input-underline.svg'
					),
				),
				'save_always' => true,
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'placeholder_text',
				'heading'     => esc_html__( 'Placehoder Email', 'landinghub-core' ),
				'description' => esc_html__( 'Add placeholder text for email field', 'landinghub-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'placeholder_nametext',
				'heading'     => esc_html__( 'Placehoder Name', 'landinghub-core' ),
				'description' => esc_html__( 'Add placeholder text for name field', 'landinghub-core' ),
				'dependency' => array(
					'element' => 'enable_name_field',
					'value'   => 'yes',
				),
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'use_custom_fonts_input',
				'heading'     => esc_html__( 'Custom font in inputs?', 'landinghub-core' ),
				'description' => esc_html__( 'Check to use custom font for input', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type'        => 'checkbox',
				'param_name'  => 'use_custom_fonts_label',
				'heading'     => esc_html__( 'Custom font for label?', 'landinghub-core' ),
				'description' => esc_html__( 'Check to use custom font for button label', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'inputs_size',
				'heading'    => esc_html__( 'Size', 'landinghub-core' ),
				'description' => esc_html__( 'Select input border size', 'landinghub-core' ),
				'value'      => array(
					esc_html__( 'Default', 'landinghub-core' ) => 'ld-sf--size-md',
					esc_html__( 'xSmall', 'landinghub-core' )  => 'ld-sf--size-xs',
					esc_html__( 'Small', 'landinghub-core' )  => 'ld-sf--size-sm',
					esc_html__( 'Medium', 'landinghub-core' )  => 'ld-sf--size-md',
					esc_html__( 'Large', 'landinghub-core' )   => 'ld-sf--size-lg',
					esc_html__( 'xLarge', 'landinghub-core' )   => 'ld-sf--size-xl',
				),
				'edit_field_class' => 'vc_col-sm-6',
			),

			array(
				'type'       => 'dropdown',
				'param_name' => 'inputs_radius',
				'heading'    => esc_html__( 'Border radius', 'landinghub-core' ),
				'description' => esc_html__( 'Select input border radius', 'landinghub-core' ),
				'value'      => array(
					esc_html__( 'Sharp', 'landinghub-core' )    => 'ld-sf--sharp',
					esc_html__( 'Semi Round', 'landinghub-core' ) => 'ld-sf--semi-round',
					esc_html__( 'Round', 'landinghub-core' )      => 'ld-sf--round',
					esc_html__( 'Circle', 'landinghub-core' )     => 'ld-sf--circle',
				),
				'edit_field_class' => 'vc_col-sm-6',
			),

			array(
				'type'       => 'dropdown',
				'param_name' => 'inputs_border',
				'heading'    => esc_html__( 'Border thickness', 'landinghub-core' ),
				'description' => esc_html__( 'Select input border thickness', 'landinghub-core' ),
				'value'      => array(
					esc_html__( 'Thin', 'landinghub-core' ) => 'ld-sf--border-thin',
					esc_html__( 'Thick', 'landinghub-core' )   => 'ld-sf--border-thick',
					esc_html__( 'Thicker', 'landinghub-core' ) => 'ld-sf--border-thicker',
					esc_html__( 'None', 'landinghub-core' ) => 'ld-sf--border-none',
				),
				'edit_field_class' => 'vc_col-sm-6',
			),

			array(
				'type'       => 'dropdown',
				'param_name' => 'inputs_shadow',
				'heading'    => esc_html__( 'Other', 'landinghub-core' ),
				'description' => esc_html__( 'Select input other styling', 'landinghub-core' ),
				'value'      => array(
					esc_html__( 'Default', 'landinghub-core' )      => '',
					esc_html__( 'Shadow', 'landinghub-core' )       => 'ld-sf--input-shadow',
					esc_html__( 'Inner Shadow', 'landinghub-core' ) => 'ld-sf--input-inner-shadow',
				),
				'edit_field_class' => 'vc_col-sm-6',
			),
			//Inputs Typo Options
			array(
				'type'        => 'textfield',
				'param_name'  => 'fs',
				'heading'     => esc_html__( 'Font Size', 'landinghub-core' ),
				'description' => esc_html__( 'Example: 20px', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-3 vc_column-with-padding',
				'dependency' => array(
					'element' => 'use_custom_fonts_input',
					'value'   => 'true',
				),
				'group' => esc_html__( 'Input Typo', 'landinghub-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'lh',
				'heading'     => esc_html__( 'Line-Height', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-3',
				'dependency' => array(
					'element' => 'use_custom_fonts_input',
					'value'   => 'true',
				),
				'group' => esc_html__( 'Input Typo', 'landinghub-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'fw',
				'heading'     => esc_html__( 'Font Weight', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-3',
				'dependency' => array(
					'element' => 'use_custom_fonts_input',
					'value'   => 'true',
				),
				'group' => esc_html__( 'Input Typo', 'landinghub-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'ls',
				'heading'     => esc_html__( 'Letter Spacing', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-3',
				'dependency' => array(
					'element' => 'use_custom_fonts_input',
					'value'   => 'true',
				),
				'group' => esc_html__( 'Input Typo', 'landinghub-core' ),
			),
			/*
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Use for Title theme default font family?', 'landinghub-core' ),
				'param_name'  => 'use_theme_fonts',
				'value'       => array(
					esc_html__( 'Yes', 'landinghub-core' ) => 'yes'
				),
				'description' => esc_html__( 'Use font family from the theme.', 'landinghub-core' ),
				'group' => esc_html__( 'Input Typo', 'landinghub-core' ),
				'dependency' => array(
					'element' => 'use_custom_fonts_input',
					'value'   => 'true',
				),
				'std'         => 'yes',
			),
			array(
				'type'       => 'google_fonts',
				'param_name' => 'text_font',
				'value'      => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
				'settings'   => array(
					'fields' => array(
						'font_family_description' => esc_html__( 'Select font family.', 'landinghub-core' ),
						'font_style_description'  => esc_html__( 'Select font styling.', 'landinghub-core' ),
					),
				),
				'group' => esc_html__( 'Input Typo', 'landinghub-core' ),
				'dependency' => array(
					'element'            => 'use_theme_fonts',
					'value_not_equal_to' => 'yes',
				),
			),
			*/
			//Label Typo Options
			array(
				'type'        => 'textfield',
				'param_name'  => 'label_fs',
				'heading'     => esc_html__( 'Font Size', 'landinghub-core' ),
				'description' => esc_html__( 'Example: 20px', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-3 vc_column-with-padding',
				'dependency' => array(
					'element' => 'use_custom_fonts_label',
					'value'   => 'true',
				),
				'group' => esc_html__( 'Button Typo', 'landinghub-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'label_lh',
				'heading'     => esc_html__( 'Line-Height', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-3',
				'dependency' => array(
					'element' => 'use_custom_fonts_label',
					'value'   => 'true',
				),
				'group' => esc_html__( 'Button Typo', 'landinghub-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'label_fw',
				'heading'     => esc_html__( 'Font Weight', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-3',
				'dependency' => array(
					'element' => 'use_custom_fonts_label',
					'value'   => 'true',
				),
				'group' => esc_html__( 'Button Typo', 'landinghub-core' ),
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'label_ls',
				'heading'     => esc_html__( 'Letter Spacing', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-3',
				'dependency' => array(
					'element' => 'use_custom_fonts_label',
					'value'   => 'true',
				),
				'group' => esc_html__( 'Button Typo', 'landinghub-core' ),
			),
			/*
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Use for Title theme default font family?', 'landinghub-core' ),
				'param_name'  => 'use_theme_fonts_label',
				'value'       => array(
					esc_html__( 'Yes', 'landinghub-core' ) => 'yes'
				),
				'description' => esc_html__( 'Use font family from the theme.', 'landinghub-core' ),
				'group' => esc_html__( 'Button Typo', 'landinghub-core' ),
				'dependency' => array(
					'element' => 'use_custom_fonts_label',
					'value'   => 'true',
				),
				'std'         => 'yes',
			),
			array(
				'type'       => 'google_fonts',
				'param_name' => 'label_text_font',
				'value'      => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
				'settings'   => array(
					'fields' => array(
						'font_family_description' => esc_html__( 'Select font family.', 'landinghub-core' ),
						'font_style_description'  => esc_html__( 'Select font styling.', 'landinghub-core' ),
					),
				),
				'group' => esc_html__( 'Button Typo', 'landinghub-core' ),
				'dependency' => array(
					'element'            => 'use_theme_fonts_label',
					'value_not_equal_to' => 'yes',
				),
			),
			*/
			

		);

		$button = array(

			array(
				'type'       => 'subheading',
				'param_name' => 'sh_buttons',
				'heading'    => esc_html__( 'Submit Button', 'landinghub-core' ),
			),

			array(
				'type'       => 'select_preview',
				'param_name' => 'btn_style',
				'heading'    => esc_html__( 'Submit Button Style', 'landinghub-core' ),
				'value'      => array(

					array(
						'value' => 'solid',
						'label' => esc_html__( 'Solid', 'landinghub-core' ),
						'image' => $url . 'button-solid.svg'
					),

					array(
						'label' => esc_html__( 'Bordered', 'landinghub-core' ),
						'value' => 'bordered',
						'image' => $url . 'button-border.svg'
					),

					array(
						'label' => esc_html__( 'Underlined', 'landinghub-core' ),
						'value' => 'underlined',
						'image' => $url . 'button-underline.svg'
					),

					array(
						'label' => esc_html__( 'Plain', 'landinghub-core' ),
						'value' => 'naked',
						'image' => $url . 'button-plain.svg'
					),	
				),
				'save_always' => true,
			),

			array(
				'type'       => 'dropdown',
				'param_name' => 'btn_state',
				'heading'    => esc_html( 'Button state', 'landinghub-core' ),
				'value'      => array(
					esc_html__( 'Display', 'landinghub-core' ) => 'ld-sf--button-show',
					esc_html__( 'Hidden', 'landinghub-core' )  => 'ld-sf--button-hidden',
				),
				'edit_field_class' => 'vc_col-sm-6'
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'btn_display',
				'heading'    => esc_html__( 'Button display', 'landinghub-core' ),
				'value'      => array(
					esc_html__( 'Button label', 'landinghub-core' )          => 'label',
					esc_html__( 'Icon', 'landinghub-core' )                  => 'icon',
					esc_html__( 'Button label and icon', 'landinghub-core' ) => 'label_icon',
				),
				'edit_field_class' => 'vc_col-sm-6'
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'btn_label',
				'heading'     => esc_html__( 'Button label', 'landinghub-core' ),
				'description' => esc_html__( 'Add button label', 'landinghub-core' ),
				'std'         => esc_html__( 'Subscribe', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-6',
				'dependency'  => array(
					'element' => 'btn_display',
					'value' => array( 'label', 'label_icon' )
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'btn_position',
				'heading'    => esc_html__( 'Button Position', 'landinghub-core' ),
				'value'      => array(
					esc_html__( 'Default', 'landinghub-core' )  => '',
					esc_html__( 'In input', 'landinghub-core' ) => 'ld-sf--button-inside',
					esc_html__( 'Near input' )             => 'ld-sf--button-inline',
					esc_html__( 'Under input' )            => 'ld-sf--button-block',
				),
				'dependency' => array(
					'element' => 'btn_state',
					'value_not_equal_to' => 'subscribe-minimal',
				),
				'edit_field_class' => 'vc_col-sm-6'
			),
			array(
				'type'       => 'checkbox',
				'param_name' => 'btn_eql',
				'heading'    => esc_html__( 'Button Equal Width &amp; Height', 'landinghub-core' ),
				'value'       => array( esc_html__( 'Yes', 'landinghub-core' ) => 'yes' ),
				'dependency'  => array(
					'element' => 'btn_style',
					'value' => array( 'solid', 'bordered' )
				),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type'        => 'textfield',
				'param_name'  => 'btn_padding',
				'heading'     => esc_html__( 'Button padding', 'landinghub-core' ),
				'description' => esc_html__( 'Add button padding ex. 20px', 'landinghub-core' ),
				'std'         => esc_html__( 'Padding value', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-6',
				'dependency'  => array(
					'element' => 'btn_position',
					'value' => array( 'ld-sf--button-inline' )
				),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'btn_shrink',
				'heading'    => esc_html__( 'Button Shrink', 'landinghub-core' ),
				'value'      => array(
					esc_html__( 'No', 'landinghub-core' )  => '',
					esc_html__( 'Yes', 'landinghub-core' ) => 'button-shrinked',
				),
				'dependency' => array(
					'element' => 'btn_position',
					'value'   => 'ld-sf--button-inside',
				),
				'edit_field_class' => 'vc_col-sm-6'
			),

			//Icon Box Shadow Options
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Enable button shadow?', 'landinghub-core' ),
				'param_name'  => 'enable_btn_shadowbox',
				'description' => esc_html__( 'If checked, the btn box-shadow options will be visible', 'landinghub-core' ),
				'value'       => array( esc_html__( 'Yes', 'landinghub-core' ) => 'yes' ),
				'edit_field_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'param_group',
				'heading' => esc_html__( 'Button Shadow Box Options', 'landinghub-core' ),
				'param_name' => 'btn_box_shadow',
				'dependency' => array(
					'element' => 'enable_btn_shadowbox',
					'not_empty' => true,
				),
				'params' => array(
					array(
						'type'        => 'dropdown',
						'param_name'  => 'inset',
						'heading'     => esc_html__( 'Inset', 'landinghub-core' ),
						'description' => esc_html__(  'Select if it is inset', 'landinghub-core' ),
						'value'      => array(
							esc_html__( 'No', 'landinghub-core' )  => '',
							esc_html__( 'Yes', 'landinghub-core' ) => 'inset',
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column-with-padding'
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'x_offset',
						'heading'     => esc_html__( 'Position X', 'landinghub-core' ),
						'description' => esc_html__(  'Set position X in px', 'landinghub-core' ),
						'edit_field_class' => 'vc_col-sm-6'
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'y_offset',
						'heading'     => esc_html__( 'Position Y', 'landinghub-core' ),
						'description' => esc_html__(  'Set position Y in px', 'landinghub-core' ),
						'edit_field_class' => 'vc_col-sm-6'
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'blur_radius',
						'heading'     => esc_html__( 'Blur Radius', 'landinghub-core' ),
						'description' => esc_html__(  'Add blur radius in px', 'landinghub-core' ),
						'edit_field_class' => 'vc_col-sm-6'
					),
					array(
						'type'        => 'textfield',
						'param_name'  => 'spread_radius',
						'heading'     => esc_html__( 'Spread Radius', 'landinghub-core' ),
						'description' => esc_html__(  'Add spread radius in px', 'landinghub-core' ),
						'edit_field_class' => 'vc_col-sm-6'
					),
					array(
						'type'        => 'colorpicker',
						'param_name'  => 'shadow_color',
						'heading'     => esc_html__( 'Color', 'landinghub-core' ),
						'description' => esc_html__(  'Pick a color for shadow', 'landinghub-core' ),
						'edit_field_class' => 'vc_col-sm-6'
					),

				)
			),
			


		);

		$icon = liquid_get_icon_params( true, '', array( 'fontawesome', 'linea' ),  array( 'color', 'align', 'hcolor' ), 'i_', array( 'element' => 'btn_display', 'value_not_equal_to' => 'label' ) );

		$design = array(

			//Position
			array(
				'type'       => 'liquid_responsive',
				'heading'    => esc_html__( 'Margin', 'landinghub-core' ),
				'description' => esc_html__( 'Add margins for the element, use px or %', 'landinghub-core' ),
				'css'        => 'margin',
				'param_name' => 'margin',
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
			),
			//design options
			array(
				'type'       => 'subheading',
				'param_name' => 'sh_inputs',
				'heading'    => esc_html__( 'Inputs', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
			),

			array(
				'type'       => 'liquid_colorpicker',
				'only_solid' => true,
				'param_name' => 'txt_color',
				'heading'    => esc_html__( 'Text Color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'liquid_colorpicker',
				'param_name' => 'bg_color',
				'heading'    => esc_html__( 'Background Color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'liquid_colorpicker',
				'param_name' => 'brd_color',
				'only_solid' => true,
				'heading'    => esc_html__( 'Border Color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'subheading',
				'param_name' => 'sh_inputs_f',
				'heading'    => esc_html__( 'Inputs Focus', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
			),

			array(
				'type'       => 'liquid_colorpicker',
				'only_solid' => true,
				'param_name' => 'txt_f_color',
				'heading'    => esc_html__( 'Text Color', '_s' ),
				'group'      => esc_html__( 'Design Options', '_s' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'liquid_colorpicker',
				'param_name' => 'bg_f_color',
				'heading'    => esc_html__( 'Background Color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'liquid_colorpicker',
				'only_solid' => true,
				'param_name' => 'brd_f_color',
				'heading'    => esc_html__( 'Border Color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'subheading',
				'param_name' => 'sh_buttons',
				'heading'    => esc_html__( 'Submit Button', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
			),

			array(
				'type'       => 'liquid_colorpicker',
				'only_solid' => true, 
				'param_name' => 'btn_txt_color',
				'heading'    => esc_html__( 'Label color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'liquid_colorpicker',
				'param_name' => 'btn_bg_color',
				'heading'    => esc_html__( 'Background color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'liquid_colorpicker',
				'only_solid' => true,
				'param_name' => 'btn_brd_color',
				'heading'    => esc_html__( 'Border color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'subheading',
				'param_name' => 'sh_buttons_hover',
				'heading'    => esc_html__( 'Hover Submit Button', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
			),

			array(
				'type'       => 'liquid_colorpicker',
				'only_solid' => true,
				'param_name' => 'hover_btn_txt_color',
				'heading'    => esc_html__( 'Label color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'liquid_colorpicker',
				'param_name' => 'hover_btn_bg_color',
				'heading'    => esc_html__( 'Background color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

			array(
				'type'       => 'liquid_colorpicker',
				'only_solid' => true,
				'param_name' => 'hover_btn_brd_color',
				'heading'    => esc_html__( 'Border color', 'landinghub-core' ),
				'group'      => esc_html__( 'Design Options', 'landinghub-core' ),
				'edit_field_class' => 'vc_col-sm-4',
			),

		);

		$this->params = array_merge( $general, $button, $icon, $design );

		$this->add_extras();

	}
	
	public function get_list_id() {
		
		if( !empty( $this->atts['list_id'] ) ) {
			return;
		}
		
		$this->list_id = $this->atts['list_id'];
		
		return $this->list_id;
		
	}
	
	/**
	 * Get MailChimp Lists IDs
	 * @return array
	 */
	public function get_mailchimp_lists() {
		
		if( !class_exists( 'liquid_MailChimp' ) ) {
			return array();
		}
		$api_key = liquid_helper()->get_theme_option( 'mailchimp-api-key' );
		if( empty( $api_key ) || strpos( $api_key, '-' ) === false ) {
			return array();
		}

		$MailChimp = new liquid_MailChimp( $api_key );
		
		$lists = $MailChimp->get( 'lists' );
		$items = array();
		if ( is_array( $lists ) && !is_wp_error( $lists ) ) {
			foreach ( $lists as $list ) {
				if( is_array( $list ) ) {
					foreach( $list as $l ) {
						if( isset( $l['id'] ) && isset( $l['name'] ) ) {
							$items[ $l['id'] ] = $l['name'];	
						}
					}
				}
			}
		}

		return $items;
	}
	
	protected function get_class( $style ) {

		$hash = array(
			'underlined' => 'ld-sf--input-underlined',
			'solid'      => 'ld-sf--input-solid',
			'bordered'   => 'ld-sf--input-bordered',
		);

		return $hash[ $style ];
	}

	protected function get_btn_class( $style ) {

		$hash = array(
			'solid'      => 'ld-sf--button-solid',
			'bordered'   => 'ld-sf--button-bordered',
			'underlined' => 'ld-sf--button-underlined',
			'naked'      => 'ld-sf--button-naked',
		);

		return $hash[ $style ];
	}
	
	protected function get_submit_button(){
		
		$icon = liquid_get_icon( $this->atts );
		extract( $icon );

		$submit_txt_class = 'submit-text';
		$icon = !empty ( $icon ) && 'true' === $this->atts['i_add_icon'] ? $icon : 'fa fa-long-arrow-right';
		$icon_html  = ' <span class="submit-icon"><i class="' . $icon . '"></i></span>';
		
		$btn_display = $this->atts['btn_display'];
		if( 'label' === $btn_display ) {
			$icon_html = '';	
		}
		elseif( 'icon' === $btn_display ) {
			$submit_txt_class .= ' visible-xs';	
			$icon_html  = '<span class="submit-icon"><i class="' . $icon . '"></i></span>';
		}
		
		$label = !empty( $this->atts['btn_label'] ) ? '<span class="' . esc_attr( $submit_txt_class ) . '">' . esc_html( $this->atts['btn_label'] ) . '</span>' : '';
		
		$label_html = $label . $icon_html;

		printf( '<button type="submit" class="ld_sf_submit">%s <span class="ld-sf-spinner"><span>Sending </span></span></button>', $label_html );
		
	}
	
	function get_status() {

		if( 'yes' == $this->atts['use_opt_in'] ) {
			return 'pending';
		}
		else {
			return 'subscribed';
		}
	}
	
	function add_user_to_the_list() {
		
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ld-mailchimp-form', 'security', false );

		if( !class_exists( 'liquid_MailChimp' ) ) {
			return;
		}
		
		$api_key = liquid_helper()->get_theme_option( 'mailchimp-api-key' );
		if( empty( $api_key ) || strpos( $api_key, '-' ) === false ) {
			wp_die( esc_html__( 'Please, input the MailChimp Api Key in Theme Options Panel', 'landinghub-core' ) );
		}
		$MailChimp = new liquid_MailChimp( $api_key );
		
		$list_id = $_POST['list_id'];
		$email  = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
		$fname  = isset( $_POST['fname'] ) ? sanitize_text_field( $_POST['fname'] ) : '';
		$lname  = isset( $_POST['lname'] ) ? sanitize_text_field( $_POST['lname'] ) : '';

		if( empty( $list_id ) ) {
			wp_die( esc_html__( 'Wrong List ID, please select a real one', 'landinghub-core' ) );
		}

		$result = $MailChimp->post( "lists/$list_id/members", array(
						'email_address' => $email,
						'merge_fields'  => array( 'FNAME'=> $fname, 'LNAME' => $lname ),
						'status'        => ($this->atts['use_opt_in'] == 'yes' ? 'pending' : 'subscribed'),
					) );
		if ( $MailChimp->success() ) {
			// Success message
			echo '<h4>' . esc_html__( 'Thank you, you have been added to our mailing list.', 'landinghub-core' ) . '</h4>';
		}
		else {
			// Display error
			echo $MailChimp->getLastError();
		}
		wp_die(); // Important
	}

	protected function get_btn_eql() {

		$classname = '';

		if ( ! empty($this->atts['btn_eql']) ) {
			$classname = 'ld-sf--button-eql';
		}

		return $classname;

	}
	
	protected function generate_css() {
		
		$settings = get_option( 'wpb_js_google_fonts_subsets' );
		if ( is_array( $settings ) && ! empty( $settings ) ) {
			$subsets = '&subset=' . implode( ',', $settings );
		} else {
			$subsets = '';
		}

		extract( $this->atts );
		$elements = array();
		$id = '.' .$this->get_id();
		
		$text_font_inline_style = $label_font_inline_style = '';
		/*
		if( 'yes' !== $use_theme_fonts ) {

			// Build the data array
			$text_font_data = $this->get_fonts_data( $text_font );

			// Build the inline style
			$text_font_inline_style = $this->google_fonts_style( $text_font_data );

			// Enqueue the right font
			$this->enqueue_google_fonts( $text_font_data );

		}
		*/
		$elements[ liquid_implode( '%1$s.ld-sf input' ) ] = array( $text_font_inline_style );
		$elements[ liquid_implode( '%1$s.ld-sf input' ) ]['font-size'] = !empty( $fs ) ? $fs : '';
		$elements[ liquid_implode( '%1$s.ld-sf input' ) ]['line-height'] = !empty( $lh ) ? $lh : '';
		$elements[ liquid_implode( '%1$s.ld-sf input' ) ]['font-weight'] = !empty( $fw ) ? $fw : '';
		$elements[ liquid_implode( '%1$s.ld-sf input' ) ]['letter-spacing'] = !empty( $ls ) ? $ls : '';
		/*
		if( 'yes' !== $use_theme_fonts_label ) {

			// Build the data array
			$label_font_data = $this->get_fonts_data( $label_text_font );

			// Build the inline style
			$label_font_inline_style = $this->google_fonts_style( $label_font_data );

			// Enqueue the right font
			$this->enqueue_google_fonts( $label_font_data );

		}
		*/
		$elements[ liquid_implode( '%1$s.ld-sf .ld_sf_submit' ) ] = array( $label_font_inline_style );
		$elements[ liquid_implode( '%1$s.ld-sf .ld_sf_submit' ) ]['font-size'] = !empty( $label_fs ) ? $label_fs : '';
		$elements[ liquid_implode( '%1$s.ld-sf .ld_sf_submit' ) ]['line-height'] = !empty( $label_lh ) ? $label_lh : '';
		$elements[ liquid_implode( '%1$s.ld-sf .ld_sf_submit' ) ]['font-weight'] = !empty( $label_fw ) ? $label_fw : '';
		$elements[ liquid_implode( '%1$s.ld-sf .ld_sf_submit' ) ]['letter-spacing'] = !empty( $label_ls ) ? $label_ls : '';
		$elements[liquid_implode( '%1$s .submit-icon' )]['font-size'] = !empty( $i_size ) ? $i_size : '';
		
		$elements[liquid_implode( '%1$s .ld_sf_response h4' )] = array( 'color' => $txt_color );
		$elements[liquid_implode( '%1$s.ld-sf input[type="email"], %1$s.ld-sf input[type="text"]' )] = array(
			'background'   => $bg_color,
			'color'        => $txt_color,
			'border-color' => $brd_color
		);
		$elements[liquid_implode( '%1$s.ld-sf input[type="email"]:focus, %1$s.ld-sf input[type="text"]:focus' )] = array(
			'background'   => $bg_f_color,
			'color'        => $txt_f_color,
			'border-color' => $brd_f_color
		);
		$elements[liquid_implode( '%1$s.ld-sf button.ld_sf_submit' )] = array(
			'background'   => $btn_bg_color,
			'color'        => $btn_txt_color,
			'border-color' => $btn_brd_color
		);
		$elements[liquid_implode( '%1$s.ld-sf buttont.ld_sf_submit:hover' )] = array(
			'background'   => $hover_btn_bg_color,
			'color'        => $hover_btn_txt_color,
			'border-color' => $hover_btn_brd_color
		);
		
		if( !empty( $btn_padding ) ) {
			$elements[liquid_implode( '%1$s.ld-sf p' )] = array( 'padding-inline-end' => $btn_padding );
		}
		
		$btn_box_shadow = vc_param_group_parse_atts( $btn_box_shadow );
		
		$responsive_margin = liquid_Responsive_Param::generate_css( 'margin', $margin, $this->get_id() );
		$elements['media']['margin'] = $responsive_margin;
		
		//Shadow box for button
		if( ! empty( $btn_box_shadow ) ) {
			$button_box_shadow_css = $this->get_shadow_css( $btn_box_shadow );
			$elements[liquid_implode( '%1$s [type=submit] ' )]['box-shadow'] = $button_box_shadow_css;
		}

		$this->dynamic_css_parser( $id, $elements );
	}
	

}

new LD_Newsletter;