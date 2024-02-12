<?php
/**
 * Iubenda sync script handler.
 *
 * It is used to attach scripts into head directly.
 *
 * @package Iubenda
 */
class Auto_Blocking_Script_Appender {

    /**
     * Script URL
     *
     * @var string
     */
    const URL = 'https://cs.iubenda.com/autoblocking/%s.js';

    /**
     * @var Iubenda_Code_Extractor
     */
    private $code_extractor;

    /**
     * @param Iubenda_Code_Extractor $code_extractor
     */
    public function __construct( Iubenda_Code_Extractor $code_extractor) {
        $this->code_extractor = $code_extractor;
    }

    /**
     * Handle the script.
     */
    public function handle() {
        if ( $this->code_extractor->is_auto_blocking_enabled() ) {
	        // phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedScript
			?>
			<script class="_iub_cs_skip" src="<?php echo esc_url( $this->url() ); ?>"></script>
            <?php
	        // phpcs:enable WordPress.WP.EnqueuedResources.NonEnqueuedScript
        }
    }

    /**
     * Build the sync script url.
     *
     * @return string
     */
    private function url()
    {
        return sprintf(static::URL, $this->code_extractor->get_site_id());
    }
}
