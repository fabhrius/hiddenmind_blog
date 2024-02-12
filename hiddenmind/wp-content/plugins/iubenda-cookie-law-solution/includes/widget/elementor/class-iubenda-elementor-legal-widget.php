<?php
/**
 * Iubenda elementor legal widget.
 *
 * It is used to attach, delete and render elementor legal widget.
 *
 * @package  Iubenda
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Iubenda elementor legal widget.
 */
class Iubenda_Elementor_Legal_Widget extends \Elementor\Widget_Base {

	/**
	 * Default widget title.
	 *
	 * @var string
	 */
	private $default_widget_title = 'Legal';

	/**
	 * Get widget name.
	 *
	 * Retrieve Iubenda legal widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'iub-elementor-legal-widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Iubenda legal widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Iubenda legal', 'iubenda' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Iubenda legal widget icon.
	 */
	public function get_icon() {
		wp_enqueue_style( 'iubenda-elementor-css', IUBENDA_PLUGIN_URL . '/includes/widget/elementor/style.css', array(), iubenda()->version );
		return 'iub-legal-elementor-widget-icon-class';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Iubenda legal widget belongs to.
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the Iubenda legal widget belongs to.
	 */
	public function get_keywords() {
		return array( 'oembed', 'url', 'link' );
	}

	/**
	 * Register Iubenda legal widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 */
	protected function register_controls() {
		$tab_content = property_exists( '\Elementor\Controls_Manager', 'TAB_CONTENT' ) ? \Elementor\Controls_Manager::TAB_CONTENT : 'content';
		$text        = property_exists( '\Elementor\Controls_Manager', 'TEXT' ) ? \Elementor\Controls_Manager::TEXT : 'text';

		$this->start_controls_section(
			'title_section',
			array(
				'label' => esc_html__( 'Title:', 'iubenda' ),
				'tab'   => $tab_content,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title:', 'iubenda' ),
				'type'        => $text,
				'input_type'  => 'title',
				// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
				'placeholder' => esc_html__( $this->default_widget_title, 'iubenda' ),
				// phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
				'default'     => esc_html__( $this->default_widget_title, 'iubenda' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render Iubenda legal widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$html     = '';
		$html     = apply_filters( 'before_iub_legal_elementor_widget_section', $html );
		$html    .= iub_array_get( $settings, 'title' ) . '<section>' . ( new Iubenda_Legal_Block() )->iub_legal_block_html( $html ) . '</section>';
		$html     = apply_filters( 'after_iub_legal_elementor_widget_section', $html );

		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

}
