<?php

class APBFree{
	public function __construct(){
		add_action( 'admin_menu', [$this, 'adminMenu'] );
		add_action( 'admin_enqueue_scripts', [$this, 'adminEnqueueScripts'] );
    }

	function adminMenu(){
        add_submenu_page(
			'edit.php?post_type=apb',
			__( 'Upgrade', 'b-blocks' ),
			__( 'Upgrade', 'b-blocks' ),
			'manage_options',
			'apb-upgrade',
			[$this, 'upgradePage']
		);
    }

	function adminEnqueueScripts( $hook ) {
		if( strpos( $hook, 'apb-upgrade' ) ){
			wp_enqueue_style( 'apb-upgrade-style', APB_DIR . 'dist/upgrade.css', [], APB_VERSION );
			wp_enqueue_script( 'apb-upgrade-script', APB_DIR . 'dist/upgrade.js', [ 'react', 'react-dom' ], APB_VERSION );
			wp_set_script_translations( 'apb-upgrade-script', 'advanced-post-block', APB_PATH . 'languages' );
		}
	}

	function upgradePage(){ ?>
		<div id='apbUpgradePage'></div>
	<?php }
}
new APBFree;