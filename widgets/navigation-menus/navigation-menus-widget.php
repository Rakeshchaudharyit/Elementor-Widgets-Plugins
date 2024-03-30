<?php

namespace BdevsElement\Widget;

use \Elementor\Controls_Manager;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Core\Schemes;
use \Elementor\Group_Control_Background;
use \BdevsElement\BDevs_El_Select2;

defined('ABSPATH') || die();


class Navigation_Menus extends BDevs_El_Widget
{

    /**
     * Get widget name.
     *
     * Retrieve Bdevs Element widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'navigation-menus';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('Navigation Menus', 'bdevselement');
    }

    public function get_custom_help_url()
    {
        return 'http://elementor.bdevs.net/widgets/post-list-slider/';
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-menu-toggle';
    }

    public function get_keywords()
    {
        return ['nav menu', 'navigation', 'menu', 'nav'];
    }

    /**
     * Get a list of All Post Types
     *
     * @return array
     */

    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }

        return $options;
    }


    protected function register_content_controls()
    {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__( 'Layout', 'elementor-pro' ),
            ]
        );
        $menus = $this->get_available_menus();
        if ( ! empty( $menus ) ) {
            $this->add_control(
                'menu',
                [
                    'label' => esc_html__( 'Menu', 'elementor-pro' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => $menus,
                    'default' => array_keys( $menus )[0],
                    'save_default' => true,
                    'separator' => 'after',
                    'description' => sprintf(
                        esc_html__( 'Go to the %1$sMenus screen%2$s to manage your menus.', 'elementor-pro' ),
                        sprintf( '<a href="%s" target="_blank">', admin_url( 'nav-menus.php' ) ),
                        '</a>'
                    ),
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . esc_html__( 'There are no menus in your site.', 'elementor-pro' ) . '</strong><br>' .
                        sprintf(
                        /* translators: 1: Link open tag, 2: Link closing tag. */
                            esc_html__( 'Go to the %1$sMenus screen%2$s to create one.', 'elementor-pro' ),
                            sprintf( '<a href="%s" target="_blank">', admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                            '</a>'
                        ),
                    'separator' => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        $this->add_control(
            'layout',
            [
                'label' => esc_html__( 'Layout', 'elementor-pro' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__( 'Horizontal', 'elementor-pro' ),
                    'vertical' => esc_html__( 'Vertical', 'elementor-pro' ),
                ],
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'align_items',
            [
                'label' => esc_html__( 'Align', 'elementor-pro' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'elementor-pro' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elementor-pro' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'elementor-pro' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Stretch', 'elementor-pro' ),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
            ]
        );

    }

    protected function register_style_controls()
    {

        //Content Style
        $this->start_controls_section(
            '_section_post_tab_content_list',
            [
                'label' => __( 'Menu Style', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'menu_item_wrap',
            [
                'label' => __( 'Menu', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography_list',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a',
            ]
        );

        $this->start_controls_tabs( 'cat_tabs' );
        $this->start_controls_tab(
            'menu_normal_tab',
            [
                'label' => __( 'Normal', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_item_background',
                'label' => esc_html__( 'Background', 'bdevselement' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a',
            ]
        );
        $this->add_responsive_control(
            'menu_item_padding',
            [
                'label' => __( 'Padding', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'menu_hover_tab',
            [
                'label' => __( 'Hover', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'menu_hvr_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_item_hover_background',
                'label' => esc_html__( 'Background', 'bdevselement' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a:hover',
            ]
        );
        $this->add_responsive_control(
            'menu_hover_wrap_padding',
            [
                'label' => __( 'Padding', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'menu_active_tab',
            [
                'label' => __( 'Active', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'menu_active_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li.current-menu-item a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'menu_active_wrap_padding',
            [
                'label' => __( 'Padding', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li.current-menu-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'cat_item_active_background',
                'label' => esc_html__( 'Background', 'bdevselement' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li.current-menu-item a',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'caret_options',
            [
                'label' => esc_html__( 'Caret Options', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'menu_show_caret',
            [
                'label' => esc_html__( 'Show Caret', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'your-plugin' ),
                'label_off' => esc_html__( 'Hide', 'your-plugin' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_caret__background',
                'label' => esc_html__( 'Background', 'bdevselement' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li:hover a:before, {{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li.current-menu-item a:before',
                'condition' => ['menu_show_caret' => 'yes'],
            ]
        );
        $this->add_responsive_control(
            'menu_caret_border_radius',
            [
                'label' => __( 'Border Radius', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li.current-menu-item a:before, {{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li:hover a.before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['menu_show_caret' => 'yes'],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            '_section_post_menu_icon',
            [
                'label' => __( 'Menu Icon', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,

            ]
        );
        $this->add_control(
            'show_menu_icon',
            [
                'label' => esc_html__( 'Show Icon', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'your-plugin' ),
                'label_off' => esc_html__( 'Hide', 'your-plugin' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'menu_icon_gap',
            [
                'label' => esc_html__( 'Text Indent ', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a .after-menu-image-icons' => 'margin-right: {{SIZE}}{{UNIT}};'
                ],
                'condition' => ['show_menu_icon' => 'yes'],
            ]
        );
        $this->add_control(
            'menu_icon_width',
            [
                'label' => esc_html__( 'Icon Width', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 32,
                ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a .after-menu-image-icons' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['show_menu_icon' => 'yes'],

            ]
        );

        $this->add_control(
            'menu_icon_height',
            [
                'label' => esc_html__( 'Icon Height', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 32,
                ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a .after-menu-image-icons' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['show_menu_icon' => 'yes'],

            ]
        );
        $this->add_control(
            'menu_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a .after-menu-image-icons' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['show_menu_icon' => 'yes'],

            ]
        );
        $this->add_control(
            'menu_icon_line_hight',
            [
                'label' => esc_html__( 'Icon Space', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 28,
                ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a .after-menu-image-icons ' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['show_menu_icon' => 'yes'],

            ]
        );
        $this->add_control(
            'menu_icon_radius',
            [
                'label' => esc_html__( 'Border Radius', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a .after-menu-image-icons' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['show_menu_icon' => 'yes'],
            ]
        );


        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'plugin-name' ),
                'condition' => ['show_menu_icon' => 'yes'],
            ]
        );
        $this->add_control(
            'menu_icon_bg_normal',
            [
                'label' => esc_html__( 'Background', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#EFEFEF',
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a .after-menu-image-icons' => 'background-color: {{VALUE}}',
                ],
                'condition' => ['show_menu_icon' => 'yes'],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'plugin-name' ),
                'condition' => ['show_menu_icon' => 'yes'],
            ]
        );
        $this->add_control(
            'menu_icon_bg_hover',
            [
                'label' => esc_html__( 'Background', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#EFEFEF',
                'selectors' => [
                    '{{WRAPPER}} nav.zambezi-sports-nav-menu-wrap ul li a:hover .after-menu-image-icons' => 'background-color: {{VALUE}}',
                ],
                'condition' => ['show_menu_icon' => 'yes'],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render(){

        $available_menus = $this->get_available_menus();

        if ( ! $available_menus ) {
            return;
        }

        $settings = $this->get_active_settings();

        $args = [
            'echo' => false,
            'menu' => $settings['menu'],
            'menu_class' => 'zambezi-sports-nav-menu',
            'menu_id' => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            //'fallback_cb' => '__return_empty_string',
            'container' => '',
        ];

        if ( 'vertical' === $settings['layout'] ) {
            $args['menu_class'] .= ' sm-vertical';
        }

        $menu_html = wp_nav_menu( $args );

        if ( empty( $menu_html ) ) {
            return;
        }
        ?>

        <nav class="zambezi-sports-nav-menu-wrap zambezi-sports-nav-menu__<?php echo $settings['layout'];?> <?php echo $settings['align_items'];?> <?php echo ('yes' == $settings['menu_show_caret']) ? 'menu-show-caret' : '';?> <?php echo ('yes' == $settings['show_menu_icon']) ? '' : 'hide-menu-icon';?>">
            <?php  echo $menu_html;?>
        </nav>

        <?php


    }
}
