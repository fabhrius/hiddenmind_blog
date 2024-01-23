<?php
class APBBlock extends APBPlugin{
    function __construct(){
		add_action( 'enqueue_block_assets', [$this, 'enqueueBlockAssets'] );
		add_action( 'wp_loaded', [$this, 'onLoaded'] );
	}

    function enqueueBlockAssets(){
		wp_register_script( 'easyTicker', APB_DIR . 'assets/js/easy-ticker.min.js', [ 'jquery' ], '3.2.1', true );
	}

    function onLoaded(){
		wp_register_style( 'ap-block-posts-style', APB_DIR . 'dist/style.css', [ 'dashicons' ], APB_VERSION );

		wp_register_style( 'ap-block-posts-editor-style', APB_DIR . 'dist/editor.css', [ 'ap-block-posts-style' ], APB_VERSION );

		register_block_type( __DIR__, [
			'editor_style'		=> 'ap-block-posts-editor-style',
			'render_callback'	=> [$this, 'render']
		] ); // Register Block

		wp_set_script_translations( 'ap-block-posts-editor-script', 'advanced-post-block', APB_PATH . 'languages' );

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); // Disable emoji load as image
	} // Register

	function render( $attributes ) {
		extract( $attributes );
		global $apb_fs;

		wp_enqueue_style( 'ap-block-posts-style' );
		if( 'ticker' === $layout ){
			wp_enqueue_script( 'easyTicker' );
		}
		wp_enqueue_script( 'ap-block-posts-script', APB_DIR . 'dist/script.js', [ 'wp-api', 'wp-util', 'react', 'react-dom' ], APB_VERSION, true );
		wp_set_script_translations( 'ap-block-posts-script', 'advanced-post-block', APB_PATH . 'languages' );

		$className = $className ?? '';
		$extraClass = apbIsPremium() ? 'premium' : 'free';
		$blockClassName = "wp-block-ap-block-posts $extraClass $className align$align";

		$allPosts = get_posts( array_merge( $this->query( $attributes ), [ 'posts_per_page' => -1 ] ) );

		ob_start(); ?>
		<div
			class='<?php echo esc_attr( $blockClassName ); ?>'
			id='apbAdvancedPosts-<?php echo esc_attr( $cId ); ?>'
			data-nonce='<?php echo esc_attr( wp_json_encode( wp_create_nonce( 'wp_ajax' ) ) ); ?>'
			data-attributes='<?php echo esc_attr( wp_json_encode( $attributes ) ); ?>'
			data-extra='<?php echo esc_attr( wp_json_encode( [ 'totalPosts' => count( $allPosts ) ] ) ); ?>'
		></div>
		<?php return ob_get_clean();
	} // Render
}
new APBBlock;