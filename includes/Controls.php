<?php

namespace Kirki;

use Kirki;
use Kirki\Controls\CustomControl;
use Kirki\Controls\EditorControl;
use Kirki\Controls\MultiCheckControl;
use Kirki\Controls\NumberControl;
use Kirki\Controls\PaletteControl;
use Kirki\Controls\RadioButtonSetControl;
use Kirki\Controls\RadioImageControl;
use Kirki\Controls\SliderControl;
use Kirki\Controls\SortableControl;
use Kirki\Controls\SwitchControl;
use Kirki\Controls\ToggleControl;
use Kirki\Controls\ColorAlphaControl;

class Controls {

	/**
	 * Add our fields.
	 * We use the default WordPress Core Customizer fields when possible
	 * and only add our own custom controls when needed.
	 */
	public function add( $wp_customize, $field ) {

		$i18n  = Kirki::i18n();
		$setting_type = 'theme_mod';
		$option_name  = 'kirki';

		switch ( $field['type'] ) {

			case 'color' :
				$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'color-alpha' :
				$wp_customize->add_control( new ColorAlphaControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'image' :
				$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'upload' :
				$wp_customize->add_control( new \WP_Customize_Upload_Control( $wp_customize, $field['id'], $field ) );
				break;

			case 'switch' :
				$wp_customize->add_control( new SwitchControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'toggle' :
				$wp_customize->add_control( new ToggleControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'radio-buttonset' :
				$wp_customize->add_control( new RadioButtonSetControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'radio-image' :
				$wp_customize->add_control( new RadioImageControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'sortable' :
				$wp_customize->add_control( new SortableControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'slider' :
				$wp_customize->add_control( new SliderControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'number' :
				$wp_customize->add_control( new NumberControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'multicheck' :
				$wp_customize->add_control( new MultiCheckControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'palette' :
				$wp_customize->add_control( new PaletteControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'custom' :
				$wp_customize->add_control( new CustomControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'editor' :
				$wp_customize->add_control( new EditorControl( $wp_customize, $field['id'], $field ) );
				break;

			case 'background' :
				/**
				 * The background control is a multi-control element
				 * so it requires extra steps to be created
				 */
				if ( isset( $field['default']['color'] ) ) {
					$option_name = ( 'option' == $setting_type ) ? $option_name . '[' . $field['settings'] . '_color]' : $field['settings'] . '_color';
					$wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, $field['id'] . '_color', array(
						'label'       => isset( $field['label'] ) ? $field['label'] : '',
						'section'     => $field['section'],
						'settings'    => $option_name,
						'priority'    => $field['priority'],
						'help'        => $field['help'],
						'description' => $i18n['background-color'],
						'required'    => $field['required'],
						'transport'   => $field['transport']
					) ) );
				}

				if ( isset( $field['default']['image'] ) ) {
					$option_name = ( 'option' == $setting_type ) ? $option_name . '[' . $field['settings'] . '_image]' : $field['settings'] . '_image';
					$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, $field['id'] . '_image', array(
						'label'       => '',
						'section'     => $field['section'],
						'settings'    => $option_name,
						'priority'    => $field['priority'] + 1,
						'help'        => '',
						'description' => $i18n['background-image'],
						'required'    => $field['required'],
						'transport'   => $field['transport']
					) ) );
				}

				if ( isset( $field['default']['repeat'] ) ) {
					$option_name = ( 'option' == $setting_type ) ? $option_name . '[' . $field['settings'] . '_repeat]' : $field['settings'] . '_repeat';
					$wp_customize->add_control( $field['id'] . '_repeat', array(
						'type'        => 'select',
						'label'       => '',
						'section'     => $field['section'],
						'settings'    => $option_name,
						'priority'    => $field['priority'] + 2,
						'choices'     => array(
							'no-repeat' => $i18n['no-repeat'],
							'repeat'    => $i18n['repeat-all'],
							'repeat-x'  => $i18n['repeat-x'],
							'repeat-y'  => $i18n['repeat-y'],
							'inherit'   => $i18n['inherit'],
						),
						'help'        => '',
						'description' => $i18n['background-repeat'],
						'required'    => $field['required'],
						'transport'   => $field['transport']
					) );
				}

				if ( isset( $field['default']['size'] ) ) {
					$option_name = ( 'option' == $setting_type ) ? $option_name . '[' . $field['settings'] . '_size]' : $field['settings'] . '_size';
					$wp_customize->add_control( $field['id'] . '_size', array(
						'type'        => 'radio',
						'label'       => '',
						'section'     => $field['section'],
						'settings'    => $option_name,
						'priority'    => $field['priority'] + 3,
						'choices'     => array(
							'inherit' => $i18n['inherit'],
							'cover'   => $i18n['cover'],
							'contain' => $i18n['contain'],
						),
						'help'        => '',
						'mode'        => 'buttonset',
						'description' => $i18n['background-size'],
						'required'    => $field['required'],
						'transport'   => $field['transport']
					) );
				}

				if ( isset( $field['default']['attach'] ) ) {
					$option_name = ( 'option' == $setting_type ) ? $option_name . '[' . $field['settings'] . '_attach]' : $field['settings'] . '_attach';
					$wp_customize->add_control( $field['id'] . '_attach', array(
						'label'       => '',
						'type'        => 'radio',
						'section'     => $field['section'],
						'settings'    => $option_name,
						'priority'    => $field['priority'] + 4,
						'choices'     => array(
							'inherit' => $i18n['inherit'],
							'fixed'   => $i18n['fixed'],
							'scroll'  => $i18n['scroll'],
						),
						'help'        => '',
						'mode'        => 'buttonset',
						'description' => $i18n['background-attachment'],
						'required'    => $field['required'],
						'transport'   => $field['transport']
					) );
				}

				if ( isset( $field['default']['position'] ) ) {
					$option_name = ( 'option' == $setting_type ) ? $option_name . '[' . $field['settings'] . '_position]' : $field['settings'] . '_position';
					$wp_customize->add_control( $field['id'] . '_position', array(
						'type'        => 'select',
						'label'       => '',
						'section'     => $field['section'],
						'settings'    => $option_name,
						'priority'    => $field['priority'] + 5,
						'choices'     => array(
							'left-top'      => $i18n['left-top'],
							'left-center'   => $i18n['left-center'],
							'left-bottom'   => $i18n['left-bottom'],
							'right-top'     => $i18n['right-top'],
							'right-center'  => $i18n['right-center'],
							'right-bottom'  => $i18n['right-bottom'],
							'center-top'    => $i18n['center-top'],
							'center-center' => $i18n['center-center'],
							'center-bottom' => $i18n['center-bottom'],
						),
						'help'        => '',
						'description' => $i18n['background-position'],
						'required'    => $field['required'],
						'transport'   => $field['transport']
					) );
				}

				if ( isset( $field['default']['opacity'] ) && $field['default']['opacity'] ) {
					$option_name = ( 'option' == $setting_type ) ? $option_name . '[' . $field['settings'] . '_opacity]' : $field['settings'] . '_opacity';
					$wp_customize->add_control( new SliderControl( $wp_customize, $field['id'] . '_opacity', array(
						'label'       => '',
						'section'     => $field['section'],
						'settings'    => $option_name,
						'priority'    => $field['priority'] + 6,
						'choices'     => array(
							'min'     => 0,
							'max'     => 100,
							'step'    => 1,
						),
						'help'        => '',
						'description' => $i18n['background-opacity'],
						'required'    => $field['required'],
						'transport'   => $field['transport']
					) ) );

				}
				break;

			default :
				$wp_customize->add_control( new \WP_Customize_Control( $wp_customize, $field['id'], $field ) );
				break;

		}

	}

}
