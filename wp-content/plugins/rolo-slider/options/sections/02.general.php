<?php
namespace RoloOptions\Section;

use  \RoloOptions\Section as Section;

Class General extends Section
{

	public function __construct()
	{
		$this->set_slug('general');
		$this->hooks();
	}

	/**
	 * The section slug
	 *
	 * @since 1.0.0
	 *
	 */
	public function set_slug($slug)
	{
		$this->slug = $slug;
	}

	/**
	 * The section Title
	 *
	 * @since 1.0.0
	 *
	 */
	public function section()
	{
		return esc_html__('General Options', 'rolo');
	}

	/**
	 * Main plugin options
	 *
	 * @since 1.0.0
	 *
	 */
	public function options($options)
	{
		$section = $this->slug;

		$animations = array(
			0 => array(
				 'val' => 'fade',
				 'option' => esc_html__('Fade', 'rolo')
			),
			1 => array(
				'val' => 'fadeUp',
				'option' => esc_html__('Fade Up', 'rolo')
			),
		);
		$animations = apply_filters( 'rolo_slider_anm_ops', $animations );

		# Animation
		$options[] = array(
				'section' => $section,
				'name'    => '_rl_animation',
				'title'   => esc_html__('Slide Transition', 'rolo'),
				'desc'    => esc_html__('Choose animation that will be applied to slides transition.', 'rolo'),
				'type'    => 'select',
				'data'    => array(
					'ops' => $animations,
					'default' => 'fade'
				)
		);

		# Force Full Width
		$options[] = array(
				'section' => $section,
				'name' => '_rl_force_width',
				'title' => esc_html__('Force Full Width', 'rolo'),
				'desc' => esc_html__('Force the slider to take full width covering the width of the current screen.', 'rolo'),
				'type' => 'select',
				'data' => array(
					'ops' => array(
							0 => array(
									'val' => 'yes',
									'option' => esc_html__('Yes', 'rolo'),
							),
							1 => array(
									'val' => 'no',
									'option' => esc_html__('No', 'rolo'),
							)
					),
					'default' => 'no',
				)
		);

		# Slider Height
		$options[] = array(
				'section' => $section,
				'name'    => '_rl_height',
				'title'   => esc_html__('Slider Height', 'rolo'),
				'desc'    => __('Set the slider height. Note this will not apply to responsive images layout as Responsive images layout is taking the height of the tallest image. You can read more in our <a href="https://wordpress.org/plugins/rolo-slider/faq/">FAQ section</a>', 'rolo'),
				'type'    => 'slide',
				'data'    => array(
					'step'    => 10,
					'min'	  => 200,
					'max'	  => 1080,
					'default' => 650
				)
		);

		# Slider Speed
		$options[] = array(
				'section' => $section,
				'name'    => '_rl_speed',
				'title'   => esc_html__('Slider Speed', 'rolo'),
				'desc'    => esc_html__('Slide stransition speed, determines how fast will slides animate/scroll.', 'rolo'),
				'type'    => 'slide',
				'data'    => array(
					'step'    => 100,
					'min'	  => 200,
					'max'	  => 2500,
					'default' => 700
				)
		);

		# Show Mouse Icon
		$options[] = array(
				'section' => $section,
				'name' => '_rl_scr',
				'title' => esc_html__('Show Mouse Icon', 'rolo'),
				'desc' => esc_html__('You can choose to show the icon of the scrolling mouse.', 'rolo'),
				'type' => 'yes_no',
				'data' => array(
					'ops' => array(
						0 => array(
							'val' => 'on',
							'option' => esc_html__('On', 'rolo'),
							'id'     => 'scr',
							'show'   => '.mouse-color',
						),
						1 => array(
							'val' => 'off',
							'option' => esc_html__('Off', 'rolo'),
							'id'     => 'scroff',
							'hide'   => '.mouse-color'
						)
					),
					'default' => 'off',
				)
		);

		# Mouse Icon color
		$options[] = array(
				'section' => $section,
				'name' => '_rl_mousec',
				'rowclass' => 'mouse-color',
				'title' => esc_html__('Mouse Icon Color', 'rolo'),
				'type' => 'color'
		);

		return apply_filters("rolo_{$section}_options", $options);
	}
}
