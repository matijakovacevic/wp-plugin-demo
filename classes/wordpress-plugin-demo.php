<?php

if (! class_exists('WordPress_Plugin_Demo')) {

    /**
     * Main / front controller class
     *
     * WordPress_Plugin_Demo is an object-oriented/MVC base for building WordPress plugins
     */
    class WordPress_Plugin_Demo
    {
        const VERSION    = '0.1';
        const PREFIX     = 'wpd_';

        protected $shortcodes = array();

        /*
         * Magic methods
         */

        /**
         * Constructor
         *
         * @mvc Controller
         */
        public function __construct()
        {
            $this->registerHookCallbacks();
        }

        /*
         * Instance methods
         */

        /**
         * Activation procedures
         *
         * @mvc Controller
         *
         * @param bool $network_wide
         */
        public function activate()
        {
        }

        /**
         * Rolls back activation procedures when de-activating the plugin
         *
         * @mvc Controller
         */
        public function deactivate()
        {
        }

        /**
         * Register callbacks for actions and filters
         *
         * @mvc Controller
         */
        public function registerHookCallbacks()
        {
            add_action('init', array( $this, 'init' ));
            add_action('widgets_init', array(&$this, 'registerCalculatorWidget'));
        }

        /**
         * Register the widget
         */
        public function registerCalculatorWidget()
        {
            register_widget('WPD_Widget');
        }

        public function generateShortcodes(array $shortcodesConfig)
        {
            foreach ($shortcodesConfig as $shortcode) {
                // check for all attributes
                if (!isset($shortcode['name'])
                    && !isset($shortcode['content'])
                    && !isset($shortcode['action']))
                {
                    throw new InvalidArgumentException();
                }

                add_shortcode($shortcode['name'], $shortcode['action']);
            }
        }

        /**
         * Initializes variables
         *
         * @mvc Controller
         */
        public function init()
        {
        }
    } // end WordPress_Plugin_Demo
}
