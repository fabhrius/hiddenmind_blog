<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wplegalpages.com/
 * @since      1.5.2
 *
 * @package    WP_Legal_Pages
 * @subpackage WP_Legal_Pages/admin
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Legal_Pages
 * @subpackage WP_Legal_Pages/includes
 * @author     WPEka <support@wplegalpages.com>
 */
if ( ! class_exists( 'WP_Legal_Pages_Public' ) ) {
	/**
	 * The public-facing functionality of the plugin.
	 *
	 * Defines the plugin name, version, and two examples hooks for how to
	 * enqueue the admin-specific stylesheet and JavaScript.
	 *
	 * @package    WP_Legal_Pages
	 * @subpackage WP_Legal_Pages/includes
	 * @author     WPEka <support@wplegalpages.com>
	 */
	class WP_Legal_Pages_Public {

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $plugin_name    The ID of this plugin.
		 */

		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of this plugin.
		 */
		private $version;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param      string $plugin_name       The name of the plugin.
		 * @param      string $version    The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;
			add_shortcode( 'wplegalpage', array( $this, 'wplegalpages_page_shortcode' ) );

		}

		/**
		 * Register the stylesheets for the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_styles() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Plugin_Name_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Plugin_Name_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */
			wp_register_style( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'css/wp-legal-pages-public-css' . WPLPP_SUFFIX . '.css', array(), $this->version, 'all' );
		}

		/**
		 * Register the JavaScript for the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function enqueue_scripts() {

			/**
			 * This function is provided for demonstration purposes only.
			 *
			 * An instance of this class should be passed to the run() function
			 * defined in Plugin_Name_Loader as all of the hooks are defined
			 * in that particular class.
			 *
			 * The Plugin_Name_Loader will then create the relationship
			 * between the defined hooks and the functions defined in this
			 * class.
			 */

		}

		/**
		 * Show credits.
		 *
		 * @param String $content Content.
		 * @return string
		 */
		public function wplegal_post_generate( $content ) {
			global $post;
			if ( is_page() ) {
				$is_legal = get_post_meta( $post->ID, 'is_legal', true );
				if ( isset( $is_legal ) && 'yes' === $is_legal ) {
					$generate_text = "<div style='font-size: 0.7em;'><i>" . get_the_title( $post ) . " generated by <a href='https://club.wpeka.com/product/wplegalpages/?utm_source=generated-page&utm_medium=credit-link' rel='nofollow' target='_blank'>WPLegalPages</a></i></div>";
					$content       = $content . $generate_text;
				}
			}
			return $content;
		}

		/**
		 * Shortcode callback function for All Legal Pages shortcode.
		 *
		 * @param Array $atts shortcode attributes.
		 */
		public function wplegalpages_page_shortcode( $atts ) {
			global $wpdb;
			$atts         = shortcode_atts(
				array(
					'pid' => 0,
				),
				$atts
			);
			$pid          = $atts['pid'];
			$post_tbl     = $wpdb->prefix . 'posts';
			$postmeta_tbl = $wpdb->prefix . 'postmeta';
			$page         = $wpdb->get_row( $wpdb->prepare( 'SELECT ptbl.* FROM ' . $post_tbl . ' as ptbl , ' . $postmeta_tbl . ' as pmtbl WHERE ptbl.ID = pmtbl.post_id and ptbl.ID = %d and ptbl.post_status = %s AND pmtbl.meta_key = %s', array( $pid, 'publish', 'is_legal' ) ) ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared,WordPress.DB.DirectDatabaseQuery,WordPress.DB.DirectDatabaseQuery.NoCaching
			if ( isset( $page->post_content ) ) {
				$content = $page->post_content;
			}
			if ( is_single() || is_page() ) {
				return html_entity_decode( $content );
			}
		}

		/**
		 * Function to display message in footer
		 */
		public function wp_legalpages_show_footer_message() {
			$lp_footer_options = get_option( 'lp_footer_options' );
			if ( false === $lp_footer_options || empty( $lp_footer_options ) ) {
				return;
			}
			if ( '1' !== $lp_footer_options['show_footer'] ) {
				return;
			}
			$footer_bg_color    = $lp_footer_options['footer_bg_color'];
			$footer_text_align  = $lp_footer_options['footer_text_align'];
			$footer_separator   = $lp_footer_options['footer_separator'];
			$footer_text_color  = $lp_footer_options['footer_text_color'];
			$footer_link_color  = $lp_footer_options['footer_link_color'];
			$footer_font_family = $lp_footer_options['footer_font'];
			$footer_font_id     = $lp_footer_options['footer_font_id'];
			$footer_font_size   = $lp_footer_options['footer_font_size'];
			$footer_custom_css  = $lp_footer_options['footer_custom_css'];
			$footer_new_tab     = '1' === $lp_footer_options['footer_new_tab'] ? 'target="_blank"' : '';
			$footer_pages       = $lp_footer_options['footer_legal_pages'];
			$font_family_url    = 'http://fonts.googleapis.com/css?family=' . $footer_font_id;
			if ( empty( $footer_pages ) || empty( $footer_pages[0] ) ) {
				return;
			}
			wp_enqueue_style( $this->plugin_name . '-public' );
			wp_add_inline_style( $this->plugin_name . '-public', '@import url(' . $font_family_url . ');' );
			$page_count = count( $footer_pages );
			echo '<style>' . esc_html( $footer_custom_css ) . '</style>';
			?>
			<div id="wplegalpages_footer_links_container">
			<?php
			$page_count = count( $footer_pages );
			for ( $i = 0; $i < $page_count; $i++ ) {
				$page_url = get_permalink( $footer_pages[ $i ] );
				?>
				<a class="wplegalpages_footer_link" <?php echo esc_attr( $footer_new_tab ); ?> href="<?php echo esc_attr( $page_url ); ?>" > <?php echo esc_html( get_the_title( $footer_pages[ $i ] ) ); ?></a>
				<?php
				if ( $i !== $page_count - 1 ) {
					?>
					<span class="wplegalpages_footer_separator_text">
						<?php echo esc_html( $footer_separator ); ?>
					</span>
					<?php
				}
			}
			?>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('#wplegalpages_footer_links_container').css({
						'width': '100%',
						'background-color': '<?php echo esc_attr( $footer_bg_color ); ?>',
						'text-align': '<?php echo esc_attr( $footer_text_align ); ?>',
						'font-size': '<?php echo esc_attr( $footer_font_size ) . 'px'; ?>',
						'font-family': '<?php echo esc_attr( $footer_font_family ); ?>'
					})
					jQuery('.wplegalpages_footer_link').css({
						'color': '<?php echo esc_attr( $footer_link_color ); ?>'
					})
					jQuery('.wplegalpages_footer_separator_text').css({
						'color': '<?php echo esc_attr( $footer_text_color ); ?>'
					})
				})
			</script>
			<?php
		}

		/** Show Announcement bar contents
		 */
		public function wplegal_announce_bar_content() {
			$lp_banner_options     = get_option( 'lp_banner_options' );
			$banner_cookie_options = get_option( 'banner_cookie_options' );
			$cookies_array         = array();
			if ( ! $banner_cookie_options || count( $banner_cookie_options ) === 0 ) {
				return;
			}
			foreach ( $banner_cookie_options as $cookie_option ) {
				if ( ! isset( $_COOKIE[ $cookie_option['cookie_name'] ] ) && time() < $cookie_option['cookie_end'] ) {
					$cookie_option['cookie_expire'] = $cookie_option['cookie_end'] - time();
					array_push( $cookies_array, $cookie_option );
				}
			}
			if ( count( $cookies_array ) > 0 ) {
				wp_localize_script( $this->plugin_name . 'banner-cookie', 'cookies', $cookies_array );
				wp_enqueue_script( $this->plugin_name . 'banner-cookie' );
			}
			if ( '1' === $lp_banner_options['show_banner'] || true === $lp_banner_options['show_banner'] || 'true' === $lp_banner_options['show_banner'] ) {
				foreach ( $_COOKIE as $key => $val ) {
					if ( preg_match( '/wplegalpages-update-notice-\d+/', sanitize_key( $key ) ) ) {
						$this->lp_banner_contents_display();
						break;
					}
				}
			}
		}

		/**
		 * Function to display announcement banner content
		 */
		public function lp_banner_contents_display() {
			$lp_banner_options       = get_option( 'lp_banner_options' );
			$banner_position         = $lp_banner_options['bar_position'];
			$banner_type             = $lp_banner_options['bar_type'];
			$banner_bg_color         = $lp_banner_options['banner_bg_color'];
			$banner_font             = $lp_banner_options['banner_font'];
			$banner_font_id          = $lp_banner_options['banner_font_id'];
			$banner_text_color       = $lp_banner_options['banner_text_color'];
			$banner_font_size        = $lp_banner_options['banner_font_size'];
			$banner_link_color       = $lp_banner_options['banner_link_color'];
			$bar_num_of_days         = $lp_banner_options['bar_num_of_days'];
			$banner_custom_css       = $lp_banner_options['banner_custom_css'];
			$banner_close_message    = $lp_banner_options['banner_close_message'];
			$banner_message          = $lp_banner_options['banner_message'];
			$banner_multiple_message = $lp_banner_options['banner_multiple_message'];
			$date_format             = get_option( 'date_format' );
			$font_family_url         = 'http://fonts.googleapis.com/css?family=' . $banner_font_id;
			wp_enqueue_style( $this->plugin_name . '-public' );
			wp_add_inline_style( $this->plugin_name . '-public', '@import url(' . $font_family_url . ');' );
			?>
				<div class="wplegalpages_banner_content" 
					style="background-color:red;z-index:1000; 
					<?php if ( 'top' === $banner_position ) { ?>
					top: 0px; 
						<?php
					} else {
						?>
						bottom:0px;
						<?php
					}
					?>
					width:100%;
					display:block;
					position : <?php echo esc_attr( $banner_type ); ?>;
					font-family : <?php echo esc_attr( $banner_font ); ?>;
					background-color: <?php echo esc_attr( $banner_bg_color ); ?>;
					color: <?php echo esc_attr( $banner_text_color ); ?>;
					font-size: <?php echo esc_attr( $banner_font_size ); ?>px;">
					<?php
					$page_ids    = array();
					$page_titles = '';
					$page_links  = array();
					$exp         = '/wplegalpages-update-notice-\d+/';
					foreach ( $_COOKIE as $key => $val ) {
						if ( preg_match( $exp, $key ) ) {
							$p_id = substr( $key, 27 );
							array_push( $page_ids, $p_id );
							$page_titles .= get_the_title( $p_id ) . ', ';
							array_push( $page_links, get_page_link( $p_id ) );
						}
					}
					$num_of_pages = count( $page_ids );
					if ( 1 === $num_of_pages ) {
						$banner_message = str_replace( '[wplegalpages_page_title]', $page_titles, $banner_message );
						$banner_message = str_replace( '[wplegalpages_last_updated]', get_the_modified_date( $date_format, $page_ids[0] ), $banner_message );
						$banner_message = str_replace( '[wplegalpages_page_href]', get_page_link( $page_ids[0] ), $banner_message );
						if ( strpos( $banner_message, '[wplegalpages_page_link]' ) ) {
							echo esc_html( substr( $banner_message, 0, strpos( $banner_message, '[wplegalpages_page_link]' ) ) );
							?>
							<a class="wplegalpages_banner_link" href="<?php echo esc_attr( get_page_link( $page_ids[0] ) ); ?>" > <?php echo esc_html( $page_titles ); ?> </a>
							<?php
							echo esc_html( substr( $banner_message, strpos( $banner_message, '[wplegalpages_page_link]' ) + 24 ) );
						} else {
							echo esc_attr( $banner_message );
						}
					} else {
						$page_latest_update = 0;
						$page_date          = '';
						for ( $i = 0; $i < $num_of_pages; $i++ ) {
							if ( get_post_modified_time( 'U', false, $page_ids[ $i ] ) > $page_latest_update ) {
								$page_date          = get_the_modified_date( $date_format, $page_ids[ $i ] );
								$page_latest_update = get_post_modified_time( 'U', false, $page_ids[ $i ] );
							}
						}
						$banner_multiple_message = str_replace( '[wplegalpages_page_title]', $page_titles, $banner_multiple_message );
						$banner_multiple_message = str_replace( '[wplegalpages_last_updated]', $page_date, $banner_multiple_message );
						if ( strpos( $banner_multiple_message, '[wplegalpages_page_link]' ) ) {
							echo esc_html( substr( $banner_multiple_message, 0, strpos( $banner_multiple_message, '[wplegalpages_page_link]' ) ) );
							for ( $i = 0; $i < $num_of_pages; $i++ ) {
								?>
								<a class="wplegalpages_banner_link" href=" <?php echo esc_attr( $page_links[ $i ] ); ?> "><?php echo esc_html( get_the_title( $page_ids[ $i ] ) ); ?></a>
								<?php
								if ( get_post_modified_time( 'U', false, $page_ids[ $i ] ) > $page_latest_update ) {
									$page_date          = get_the_modified_date( $date_format, $page_ids[ $i ] );
									$page_latest_update = get_post_modified_time( 'U', false, $page_ids[ $i ] );
								}
							}
							echo esc_html( substr( $banner_multiple_message, strpos( $banner_multiple_message, '[wplegalpages_page_link]' ) + 24 ) );
						} else {
							echo esc_attr( $banner_multiple_message );
						}
					}
					?>
					<a style="cursor:pointer;"> <?php echo esc_attr( $banner_close_message ); ?> </a>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery(".wplegalpages_banner_content").find("a").addClass("wplegalpages_banner_link");
						jQuery(".wplegalpages_banner_link").click(
							function() {
								var display_state = jQuery('.wplegalpages_banner_content').css('display');
								if(display_state === 'block'){
									jQuery('.wplegalpages_banner_content').css('display','none');
								}
							}
						);					
					});
				</script>
				<?php
				echo '<style>
				.wplegalpages_banner_link{
					color: ' . esc_attr( $banner_link_color ) . ';' .
				'}'
				. esc_html( $banner_custom_css ) .
				'</style>';
		}

		/**
		 * Display EU cookie message on frontend.
		 */
		public function wp_legalpages_show_eu_cookie_message() {

			$lp_eu_get_visibility = get_option( 'lp_eu_cookie_enable' );

			if ( 'ON' === $lp_eu_get_visibility ) {
				$lp_eu_theme_css         = get_option( 'lp_eu_theme_css' );
				$lp_eu_title             = get_option( 'lp_eu_cookie_title' );
				$lp_eu_message           = get_option( 'lp_eu_cookie_message' );
				$lp_eu_box_color         = get_option( 'lp_eu_box_color' );
				$lp_eu_button_color      = get_option( 'lp_eu_button_color' );
				$lp_eu_button_text_color = get_option( 'lp_eu_button_text_color' );
				$lp_eu_text_color        = get_option( 'lp_eu_text_color' );
				$lp_eu_button_text       = get_option( 'lp_eu_button_text' );
				$lp_eu_link_text         = get_option( 'lp_eu_link_text' );
				$lp_eu_link_url          = get_option( 'lp_eu_link_url' );
				$lp_eu_text_size         = get_option( 'lp_eu_text_size' );
				$lp_eu_link_color        = get_option( 'lp_eu_link_color' );
				$lp_eu_head_text_size    = $lp_eu_text_size + 4;

				if ( ! $lp_eu_button_text || '' === $lp_eu_button_text ) {
					$lp_eu_button_text = 'I agree';
					update_option( 'lp_eu_button_text', $lp_eu_button_text );
				}

				$options = array(
					'lp_eu_theme_css'         => $lp_eu_theme_css,
					'lp_eu_title'             => $lp_eu_title,
					'lp_eu_message'           => $lp_eu_message,
					'lp_eu_box_color'         => $lp_eu_box_color,
					'lp_eu_button_color'      => $lp_eu_button_color,
					'lp_eu_button_text_color' => $lp_eu_button_text_color,
					'lp_eu_text_color'        => $lp_eu_text_color,
					'lp_eu_button_text'       => $lp_eu_button_text,
					'lp_eu_link_text'         => $lp_eu_link_text,
					'lp_eu_link_url'          => $lp_eu_link_url,
					'lp_eu_text_size'         => $lp_eu_text_size,
					'lp_eu_link_color'        => $lp_eu_link_color,
					'lp_eu_head_text_size'    => $lp_eu_head_text_size,
				);
				wp_enqueue_style( $this->plugin_name . '-public' );
				wp_localize_script( $this->plugin_name . 'lp-eu-cookie', 'obj', $options );
				wp_enqueue_script( $this->plugin_name . 'lp-eu-cookie' );
				include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/views/lp-eu-cookie.php';
			}
		}
	}
}