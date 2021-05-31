<?php

namespace DynamicContentForElementor\Includes\Settings;

use Elementor\Controls_Manager;
use Elementor\Core\Settings\Base\CSS_Model;
use Elementor\Scheme_Color;
use Elementor\Utils;
use DynamicContentForElementor\DCE_Helper;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Model extends CSS_Model {

    /**
     * Get model name.
     *
     * Retrieve the model name.
     *
     * @see Elementor\Controls_Stack
     *
     * @access public
     *
     * @return string model name.
     */
    public function get_name() {
        return 'dce-settings_dce';
    }

    /**
     * Get panel page settings.
     *
     * Retrieve the page setting for the current panel.
     *
     * @see Elementor\Core\Settings\Base\Model
     *
     * @access public
     *
     * @return array panel page settings
     */
    public function get_panel_page_settings() {
        return [
            'title' => __('Dynamic Content for Elementor', 'dynamic-content-for-elementor'),
            // 'menu' => [
            //     'icon' => 'icon-dyn-logo-dce',
            //     'beforeItem' => 'editor-preferences',
            // ],
        ];
    }

    /**
     * Get CSS wrapper selector.
     *
     * Retrieve the wrapper selector for the current panel.
     *
     * @see Elementor\Core\Settings\Base\CSS_Model
     *
     * @access public
     * 
     * @return string css selector
     */
    public function get_css_wrapper_selector(){
        return '';   
    }

    public static function get_controls_list() {
        $target_smoothTransition = '';
        $selector_wrapper = get_option( 'selector_wrapper' );
        if( $selector_wrapper ){
            $target_smoothTransition = ' ' . $selector_wrapper;
        }
        
        $controls = [];
        $settings = DCE_Settings_Manager::get_active_settings();
        if (!empty($settings)) {
            foreach ($settings as $skey => $name) {
                $class = DCE_Settings_Manager::$namespace . $name;
                $controls[$skey] = $class::get_controls();
            }
        }
        
        return [
            DCE_Settings_Manager::PANEL_TAB_SETTINGS => $controls,
                /*'settings_structure' => [
                    'label' => __( 'Structure of HTML pages', 'dynamic-content-for-elementor' ),

                    'controls' => [
                        'dce_settings_note' => [
                            'type' => Controls_Manager::RAW_HTML,
                            'raw' => __('<div><i class="icon-dyn-logo-dce" style="font-size: 5em; text-align: center; display: block;"></i></div>', 'dynamic-content-for-elementor'),
                            'content_classes' => '',
                        ],
                        'dce_structure_page' => [
                            'label' => __('Main structure of html pages', 'dynamic-content-for-elementor'),
                            'type' => Controls_Manager::HEADING,
                            'separator' => 'before'
                        ],
                        'dce_settings_structure' => [
                            'type' => Controls_Manager::RAW_HTML,
                            'raw' => __('<div><img src="'. DCE_URL . 'assets/img/structure.png"></div>', 'dynamic-content-for-elementor'),
                            'content_classes' => 'dce-settings-structure',
                        ],
                        'selector_wrapper' => [
                            'label' => __('Wrapper selector', 'dynamic-content-for-elementor'),
                            'type' => Controls_Manager::TEXT,
                            'default' => '',
                            'placeholder' => 'Write CSS selector (ex: #wrapper)',
                            'frontend_available' => true,
                            'dynamic' => [
                                'active' => false,
                              ],
                            ],
                        'selector_header_site' => [
                            'label' => __('Header selector', 'dynamic-content-for-elementor'),
                            'type' => Controls_Manager::TEXT,
                            'default' => '',
                            'placeholder' => 'Write CSS selector (ex: #header)',
                            'frontend_available' => true,
                            'dynamic' => [
                                'active' => false,
                              ],
                        ],
                        'selector_main_site' => [
                            'label' => __('Main Content selector', 'dynamic-content-for-elementor'),
                            'type' => Controls_Manager::TEXT,
                            'default' => '',
                            'placeholder' => 'Write CSS selector (ex: #main)',
                            'frontend_available' => true,
                            'dynamic' => [
                                'active' => false,
                              ],
                        ],
                        'selector_footer_site' => [
                            'label' => __('Footer selector', 'dynamic-content-for-elementor'),
                            'type' => Controls_Manager::TEXT,
                            'default' => '',
                            'placeholder' => 'Write CSS selector (ex: #footer)',
                            'frontend_available' => true,
                            'dynamic' => [
                                'active' => false,
                              ],
                        ],
                     ]
                ],*/
                
            /* Controls_Manager::TAB_STYLE => [

              ], */
        ];
    }
 
    /**
     * Register settings panel controls.
     *
     * Used to add new controls to settings panel.
     *
     * @see Elementor\Controls_Stack
     *
     * @access protected
     */
    protected function _register_controls() {
        $controls_list = self::get_controls_list();
        
        foreach ($controls_list as $tab_name => $sections) {
            
            foreach ($sections as $section_name => $section_data) {
                
                $this->start_controls_section(
                    $section_name, [
                        'label' => $section_data['label'],
                        'tab' => $tab_name,
                    ]
                );

                foreach ($section_data['controls'] as $control_name => $control_data) {
                    $this->add_control($control_name, $control_data);
                }

                $this->end_controls_section();
            }
        }
    }

}