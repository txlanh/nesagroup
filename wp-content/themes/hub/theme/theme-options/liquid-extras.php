<?php
/*
 * Extras Section
*/

$this->sections[] = array(
	'title'  => esc_html__('Extras', 'hub'),
	'icon'   => 'el el-plus-sign'
);

// Custom Cursor Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Custom Cursor', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'enable-custom-cursor',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Custom cursor', 'hub' ),
			'subtitle' => esc_html__( 'Switch on to enable custom cursor', 'hub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'hub' ),
				'off' => esc_html__( 'Off', 'hub' )
			),
			'default' => 'off'
		),
		array(
			'id'       => 'cc-label-explore',
			'type'     => 'text',
			'title'    => esc_html__( 'Images Custom Cursor Label', 'hub' ),
			'default'  => esc_html__( 'Explore', 'hub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cc-label-drag',
			'type'     => 'text',
			'title'    => esc_html__( 'Carousels Custom Cursor Label', 'hub' ),
			'default'  => esc_html__( 'Drag', 'hub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cc-hide-outer',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Hide Outer circle cursor', 'hub' ),
			'subtitle' => esc_html__( 'Switch on to hide outer circle', 'hub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'hub' ),
				'off' => esc_html__( 'Off', 'hub' )
			),
			'default' => 'off',
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cc-inner-size',
			'type'     => 'text',
			'title'    => esc_html__( 'Custom Cursor Inner size', 'hub' ),
			'subtitle' => esc_html__( 'Define the size of the inner custom cursor, For instance, 120px', 'hub' ),
			'default'  => '7px',
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cc-outer-size',
			'type'     => 'text',
			'title'    => esc_html__( 'Custom Cursor Outer size', 'hub' ),
			'subtitle' => esc_html__( 'Define the size of the outer custom cursor, For instance, 120px', 'hub' ),
			'default'  => '35px',
			'required' => array(
				array( 'enable-custom-cursor', '=', 'on' ),
				array( 'cc-hide-outer', '=', 'off' ),
			),
		),
		array(
			'id'       => 'cc-outer-active-border-width',
			'type'     => 'text',
			'title'    => esc_html__( 'Outer Circle Active Border Width', 'hub' ),
			'subtitle' => esc_html__( 'Define the border width of outer circle when hovering over links, for instance, 3px', 'hub' ),
			'default'  => '1px',
			'required' => array(
				array( 'enable-custom-cursor', '=', 'on' ),
				array( 'cc-hide-outer', '=', 'off' ),
			),
		),
		array(
			'id'       => 'cc-blend-mode',
			'type'     => 'select',
			'title'    => esc_html__( 'Custom Cursor Blend Mode', 'archub' ),
			'subtitle'   => esc_html__( 'Try \'Difference\' and white background for inner circle and active color 😉', 'archub' ),
			'options'  => array(
				'normal' => esc_html__( 'Normal', 'archub' ),
				'multiply' => esc_html__( 'Multiply', 'archub' ),
				'screen' => esc_html__( 'Screen', 'archub' ),
				'overlay' => esc_html__( 'Overlay', 'archub' ),
				'darken' => esc_html__( 'Darken', 'archub' ),
				'lighten' => esc_html__( 'Lighten', 'archub' ),
				'color-dodge' => esc_html__( 'Color Dodge', 'archub' ),
				'color-burn' => esc_html__( 'Color Burn', 'archub' ),
				'hard-light' => esc_html__( 'Hard Light', 'archub' ),
				'soft-light' => esc_html__( 'Soft Light', 'archub' ),
				'difference' => esc_html__( 'Difference', 'archub' ),
				'exclusion' => esc_html__( 'Exclusion', 'archub' ),
				'hue' => esc_html__( 'Hue', 'archub' ),
				'saturation' => esc_html__( 'Saturation', 'archub' ),
				'color' => esc_html__( 'Color', 'archub' ),
				'luminosity' => esc_html__( 'Luminosity', 'archub' ),
			),
			'default' => 'normal',
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-inner-circle-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Inner Circle Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a color for inner circle of the custom cursor', 'hub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-outer-circle-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Outer Circle Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a color for outer circle of the custom cursor', 'hub' ),
			'required' => array(
				array( 'enable-custom-cursor', '=', 'on' ),
				array( 'cc-hide-outer', '=', 'off' ),
			),
		),
		array(
			'id'         => 'cc-active-circle-color-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Active Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a color for active of the custom cursor', 'hub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-active-circle-solid-color-txt',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Active Circle Text Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a color for the active circle of the custom cursor. The big circle when hovering over elements like carousel or portfolio.', 'hub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-active-circle-solid-color-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Active Circle Background Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a background for the active circle of the custom cursor. The big circle when hovering over elements like carousel or portfolio.', 'hub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-active-arrow-color',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Active Arrow Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a color for the active arrow of the custom cursor.', 'hub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
	)
);

// Preloader Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Preloader', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'enable-preloader',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Preloader', 'hub' ),
			'subtitle' => esc_html__( 'Switch on to enable preloader', 'hub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'hub' ),
				'off' => esc_html__( 'Off', 'hub' )
			),
			'default' => 'off'
		),
		array(
			'id'       => 'preloader-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Preloader Style', 'hub' ),
			'subtitle' => esc_html__( 'Select preloder style', 'hub' ),
			'options'  => array(
				'curtain' => esc_html__( 'Curtain', 'hub' ),
				'fade'    => esc_html__( 'Fade', 'hub' ),
				'sliding' => esc_html__( 'Sliding', 'hub' ),
				'spinner' => esc_html__( 'Spinner', 'hub' ),
				'spinner-classical' => esc_html__( 'Spinner Classic', 'hub' ),
				'dissolve' => esc_html__( 'Dissolve', 'hub' ),
			),
			'required' => array(
				'enable-preloader',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'preloader-color',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Preloader Background Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a background color for preloader', 'hub' ),
			'required' => array(
				'enable-preloader',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'preloader-color-2',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Preloader Background Color 2', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a 2 background color for preloader', 'hub' ),
			'required' => array(
				'preloader-style',
				'=',
				'curtain'
			),
		),
		array(
			'id'         => 'preloader-elements-color',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Preloader Elements Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a color for preloader elements', 'hub' ),
			'required' => array(
				'preloader-style',
				'=',
				array( 'dots', 'signal' )
			),
		),
		array(
			'id'         => 'preloader-elements-color-2',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Preloader Elements Color', 'hub' ),
			'subtitle'   => esc_html__( 'Choose a color for preloader elements', 'hub' ),
			'required' => array(
				'preloader-style',
				'=',
				array( 'spinner' )
			),
		),
	)
);

// Local Scroll Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Local Scroll', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'type'     => 'text',
			'id'       => 'pagescroll-speed',
			'title'    => esc_html__( 'Local scroll speed', 'hub' ),
			'subtitle'     => esc_html__( 'Please add scroll speed in milliseconds, works for one page websites', 'hub' ),
		),
		array(
			'type'     => 'slider',
			'id'       => 'pagescroll-offset',
			'title'    => esc_html__( 'Local scroll offset', 'hub' ),
			'subtitle'     => esc_html__( 'Set the offset for localscroll. Value is in px.', 'hub' ),
			'default'  => 0,
			'max'      => 500,
			'min'      => -500,
		),
	)
);

// Top Scroll Indicator Bar Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Top Scroll Indicator Bar', 'hub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'top-scroll-indicator',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Top Scroll Indicator Bar', 'hub' ),
			'subtitle' => esc_html__( 'Display a scroll indicator bar at top.', 'hub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'hub' ),
				'off' => esc_html__( 'Off', 'hub' )
			),
			'default' => 'off'
		),
		array(
			'type'     => 'slider',
			'id'       => 'top-scroll-indicator-height',
			'title'    => esc_html__( 'Top Scroll Indicator Bar Height', 'hub' ),
			'default'  => 5,
			'max'      => 100,
			'min'      => 2,
			'required' => array(
				'top-scroll-indicator',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'top-scroll-indicator-bg',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Top Scroll Indicator Background', 'hub' ),
			'required' => array(
				'top-scroll-indicator',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'top-scroll-indicator-bar-bg',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Top Scroll Indicator Bar Background', 'hub' ),
			'default'    => '#000',
			'required' => array(
				'top-scroll-indicator',
				'=',
				'on'
			),
		),
	)
);

// Back to Top Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Back to Top', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'footer-back-to-top',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Back To Top', 'hub' ),
			'subtitle' => esc_html__( 'Switch on to display the back to top link', 'hub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'hub' ),
				'off' => esc_html__( 'Off', 'hub' )
			),
			'default' => 'off'
		),
		array(
			'id'       => 'footer-back-to-top-scrl-ind',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Back To Top Scroll Indicator', 'hub' ),
			'subtitle' => esc_html__( 'Add a scroll indicator inside the back to top button.', 'hub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'hub' ),
				'off' => esc_html__( 'Off', 'hub' )
			),
			'default' => 'off',
			'required' => array(
				'footer-back-to-top',
				'=',
				'on'
			),
		),
	)
);

if ( !class_exists( 'Liquid_Elementor_Addons' ) && !defined( 'ELEMENTOR_VERSION' )){

	$this->sections[] = array(
		'title'  => esc_html__( 'Hub Collection', 'hub' ),
		'subsection' => true,
		'fields' => array(
			array(
				'id' => 'enable-hub-collection',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Hub Collection', 'hub' ),
				'subtitle' => esc_html__( 'Switch off to disable the Hub collection', 'hub' ),
				'options'  => array(
					'on'   => esc_html__( 'On', 'hub' ),
					'off'  => esc_html__( 'Off', 'hub' ),
				),
				'default' => 'on'
			),
		)
	);
	
}

if ( !class_exists( 'Liquid_Elementor_Addons' ) ){
	// Theme Features
	$this->sections[] = array(
		'title'      => esc_html__( 'Custom Icons', 'hub' ),
		'subsection' => true,
		'fields'     => array(

			array(
				'id'    => 'sh_theme_features',
				'type'  => 'raw',
				'class' => 'redux-sub-heading',
				'desc'  => '<h2>' . esc_html__( 'Manage Icons', 'hub' ) . '</h2>'
			),
			array(
				'id'       => 'font-icons',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__( 'Custom Icon Fonts', 'hub' ),
				'subtitle' => esc_html__( 'Choose the icon Fonts', 'hub' ),
				'options'  => array(
					'liquid-icons' => esc_html__( 'Liquid Icons', 'hub' )
				),
				'default' => array( 'liquid-icons' ),
			),
			array(
				'id' => 'custom-icons-fonts',
				'type' => 'repeater',
				'title'    => esc_html__( 'Add Custom Icons', 'hub' ),
				'desc' => esc_html__( 'NOTE: All icons files should be uploaded via FTP on your server', 'hub' ),
				'sortable' => false,
				'group_values' => false,
							'fields' => array(
					
					array(
						'id' => 'custom_icon_font_title',
						'type' => 'text',
						'title'    => esc_html__( 'Title', 'hub' ),
						'placeholder' => esc_html__( 'Awesome Font', 'hub' ),
					),
					array(
						'id'    => 'custom_icon_font_css',
						'type'  => 'text',	
						'title' => esc_html__( 'Icon Css file', 'hub' ),
					),
					array(
						'id'    => 'custom_icons_classnames',
						'type'  => 'textarea',	
						'title' => esc_html__( 'Icons classnames', 'hub' ),
						'desc'  => esc_html__( 'Icon classnames should be separated by comma,for ex: icon-classname, icon-2-classname', 'hub' ),
					),
					array(
						'id'          => 'custom_icon_prefix',
						'type'        => 'text',
						'title'       => esc_html__( 'Prefix', 'hub' ),
						'placeholder' => esc_html__( 'fa', 'hub' ),
						'subtitle'    => esc_html__( 'Add a prefix for the icon, will add as classname for all icons.', 'hub' ),
					),
				)
			),		

		)
	);
}
include_once( get_template_directory() . '/theme/theme-options/liquid-page-404.php' );

