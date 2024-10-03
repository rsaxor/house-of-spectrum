<?php

/**
 * House of Spectrum
 *
 * @package           HOS
 * @author            rsaxor
 * @copyright         2024 House of Spectrum
 * @license           GPL-2.0
 *
 * @wordpress-plugin
 * Plugin Name:       House of Spectrum
 * Plugin URI:        https://github.com/rsaxor
 * Description:       Custom WordPress plugin for the House of Spectrum website.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            ralph@houseofspectrum.com
 * Author URI:        mailto:ralph@houseofspectrum.com
 * Text Domain:       house-of-spectrum
 * License:           GPL v2
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (! class_exists('HOS')) {

    /**
     * The main HOS class
     */
    #[AllowDynamicProperties]
    class HOS {
        /**
		 * The plugin version number.
		 *
		 * @var string
		 */
		public $version = '1.0.0';

		/**
		 * The plugin settings array.
		 *
		 * @var array
		 */
		public $settings = array();

		/**
		 * The plugin data array.
		 *
		 * @var array
		 */
		public $data = array();

		/**
		 * Storage for class instances.
		 *
		 * @var array
		 */
		public $instances = array();

		/**
		 * A dummy constructor to ensure HOS is only setup once.
		 */
		public function __construct() {
			// Do nothing.
		}

        /**
		 * Sets up the HOS plugin.
		 *
		 * @date    30/09/2023
		 * @since   1.0.0
		 */
		public function initialize() {
            // Define constants.
			$this->define( 'HOS', true );
			$this->define( 'HOS_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'HOS_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'HOS_VERSION', $this->version );

			// Register activation hook.
			register_activation_hook( __FILE__, array( $this, 'hos_plugin_activated' ) );
			register_deactivation_hook( __FILE__, array( $this, 'hos_plugin_deactivated' ) );

			// Define settings.
			// Define settings.
			$this->settings = array(
				'name'                    => __( 'House of Spectrum', 'hos' ),
				'slug'                    => dirname( HOS_BASENAME ),
				'version'                 => HOS_VERSION,
				'basename'                => HOS_BASENAME,
				'path'                    => HOS_PATH,
				'file'                    => __FILE__,
				'url'                     => plugin_dir_url( __FILE__ ),
			);

			include_once HOS_PATH . 'includes/hos-post-types.php';

        }

        /**
		 * Defines a constant if doesnt already exist.
		 *
		 * @param   string $name  The constant name.
		 * @param   mixed  $value The constant value.
		 * @return  void
		 */
		public function define( $name, $value = true ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

        /**
		 * Plugin Activation Hook
		 */
		public function hos_plugin_activated() {
            flush_rewrite_rules(); 
            // hook any function in activating
		}

        /**
		 * Plugin Deactivation Hook
		 */
		public function hos_plugin_deactivated() {
            hos_unregister_cpt();
			flush_rewrite_rules(); 
		}
    }


    /**
     * The main function responsible for returning hos Instance to functions everywhere.
     * Use this function like you would a global variable, except without needing to declare the global.
     *
     * @return  HOS
     */
    function hos()
    {
        global $hos;

        // Instantiate only once.
        if (! isset($hos)) {
            $hos = new hos();
            $hos->initialize();
        }
        return $hos;
    }

    // Instantiate.
    hos();
} // class_exists check