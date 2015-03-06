<?php
namespace Matijakovacevic;

class WPDWidget extends \WP_Widget
{
    const PREFIX     = 'wpd_';
    const VERSION    = '0.1';

    /**
     * Sets up the widgets name etc
     */
    public function __construct()
    {
        parent::__construct(
            'calculator_widget', // Base ID
            __('Calculator widget', 'text_domain'), // Name
            array( 'description' => __('Simple JS calculator widget', 'text_domain')) // Args
        );

        add_action('init', array(&$this, 'loadResources'));
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance)
    {
        $this->loadResources();

        $template = realpath(dirname(__FILE__).'/../views/calculator-widget.php');

        if (file_exists($template)) {
            require_once $template;
        }
    }

    /**
     * Enqueues CSS, JavaScript, etc
     */
    public function loadResources()
    {
        // only enqueue if widget is active
        if (is_active_widget(false, false, $this->id_base, true)) {
            wp_register_script(
                self::PREFIX.'calculator-widget',
                plugins_url('javascript/calculator-widget.js', dirname(__FILE__)),
                array(),
                self::VERSION,
                true
            );

            wp_register_style(
                self::PREFIX.'calculator-widget',
                plugins_url('css/calculator-widget.css', dirname(__FILE__)),
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_style(self::PREFIX.'calculator-widget');
            wp_enqueue_script(self::PREFIX.'calculator-widget');
        }
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form($instance)
    {
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update($new_instance, $old_instance)
    {
    }
}
