<?php

namespace BdevsElement\Widget;

use Elementor\Core\Schemes\Typography;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Utils;
use \Elementor\Group_Control_Image_Size;

defined( 'ABSPATH' ) || die();

class Heading extends BDevs_El_Widget {

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
    public function get_name() {
        return 'heading';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title() {
        return __( 'Heading', 'bdevselement' );
    }

    public function get_custom_help_url() {
        return 'http://elementor.bdevs.net/widgets/gradient-heading/';
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-t-letter';
    }

    public function get_keywords() {
        return ['gradient', 'advanced', 'heading', 'title', 'colorful'];
    }

    protected function register_content_controls() {

        //Settings
        $this->start_controls_section(
            '_section_settings',
            [
                'label' => __( 'Settings', 'bdevselement' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'design_style',
            [
                'label'              => __( 'Design Style', 'bdevselement' ),
                'type'               => Controls_Manager::SELECT,
                'options'            => [
                    'style_1' => __( 'Style 1', 'bdevselement' ),
                    'style_2' => __( 'Style 2', 'bdevselement' ),
                    'style_3' => __( 'Style 3', 'bdevselement' ),
                ],
                'default'            => 'style_1',
                'frontend_available' => true,
                'style_transfer'     => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            '_section_title',
            [
                'label' => __( 'Title & Description', 'bdevselement' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label'       => __( 'Sub Title', 'bdevselement' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Heading Sub Title',
                'placeholder' => __( 'Heading Sub Text', 'bdevselement' ),
                'dynamic'     => [
                    'active' => true,
                ],
                'condition' => [
                    'design_style' => ['style_3'],
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __( 'Title', 'bdevselement' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 4,
                'default'     => 'Heading Title',
                'placeholder' => __( 'Heading Text', 'bdevselement' ),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'description',
            [
                'label'       => __( 'Description', 'bdevselement' ),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => __( 'Heading Description Text', 'bdevselement' ),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'   => __( 'Title HTML Tag', 'bdevselement' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'h1' => [
                        'title' => __( 'H1', 'bdevselement' ),
                        'icon'  => 'eicon-editor-h1',
                    ],
                    'h2' => [
                        'title' => __( 'H2', 'bdevselement' ),
                        'icon'  => 'eicon-editor-h2',
                    ],
                    'h3' => [
                        'title' => __( 'H3', 'bdevselement' ),
                        'icon'  => 'eicon-editor-h3',
                    ],
                    'h4' => [
                        'title' => __( 'H4', 'bdevselement' ),
                        'icon'  => 'eicon-editor-h4',
                    ],
                    'h5' => [
                        'title' => __( 'H5', 'bdevselement' ),
                        'icon'  => 'eicon-editor-h5',
                    ],
                    'h6' => [
                        'title' => __( 'H6', 'bdevselement' ),
                        'icon'  => 'eicon-editor-h6',
                    ],
                ],
                'default' => 'h2',
                'toggle'  => false,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => __( 'Alignment', 'bdevselement' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'bdevselement' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'bdevselement' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'bdevselement' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            '_section_media',
            [
                'label' => __('Icon / Image', 'bdevselement'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => __('Media Type', 'bdevselement'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'icon' => [
                        'title' => __('Icon', 'bdevselement'),
                        'icon' => 'fa fa-smile-o',
                    ],
                    'image' => [
                        'title' => __('Image', 'bdevselement'),
                        'icon' => 'fa fa-image',
                    ],
                ],
                'default' => 'icon',
                'toggle' => false,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Image', 'bdevselement'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'type' => 'image'
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'none',
                'exclude' => [
                    'full',
                    'custom',
                    'large',
                    'shop_catalog',
                    'shop_single',
                    'shop_thumbnail'
                ],
                'condition' => [
                    'type' => 'image'
                ]
            ]
        );

        if (bdevs_element_is_elementor_version('<', '2.6.0')) {
            $this->add_control(
                'icon',
                [
                    'label' => __('Icon', 'bdevselement'),
                    'label_block' => true,
                    'type' => Controls_Manager::ICON,
                    'options' => bdevs_element_get_bdevs_element_icons(),
                    'default' => 'fa fa-smile-o',
                    'condition' => [
                        'type' => 'icon'
                    ]
                ]
            );
        } else {
            $this->add_control(
                'selected_icon',
                [
                    'type' => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'label_block' => true,
                    'default' => [
                        'value' => 'fas fa-smile-wink',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'type' => 'icon'
                    ]
                ]
            );
        }

        $this->end_controls_section();

    }

    protected function register_style_controls() {
        $this->start_controls_section(
            '_section_style_title',
            [
                'label' => __( 'Title & Description', 'bdevselement' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            '_heading_title',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __( 'Title', 'bdevselement' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label'      => __( 'Margin', 'bdevselement' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_padding',
            [
                'label'      => __( 'Padding', 'bdevselement' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .section-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title',
                'selector' => '{{WRAPPER}} .section-title',
                'scheme'   => Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'title',
                'label'    => __( 'Text Shadow', 'bdevselement' ),
                'selector' => '{{WRAPPER}} .section-title',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => __( 'Text Color', 'bdevselement' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .section-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label'     => __( 'Blend Mode', 'bdevselement' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => __( 'Normal', 'bdevselement' ),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .section-title' => 'mix-blend-mode: {{VALUE}};',
                ],
                'separator' => 'none',
            ]
        );

        // subtitle
        $this->add_control(
            '_heading_subtitle',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __( 'Sub Title', 'bdevselement' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'heading_subtitle_margin',
            [
                'label'      => __( 'Margin', 'bdevselement' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_subtitle_padding',
            [
                'label'      => __( 'Padding', 'bdevselement' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .sub-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle',
                'selector' => '{{WRAPPER}} .sub-title',
                'scheme'   => Typography::TYPOGRAPHY_2,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'subtitle',
                'label'    => __( 'Text Shadow', 'bdevselement' ),
                'selector' => '{{WRAPPER}} .sub-title',
            ]
        );

        $this->add_control(
            'heading_subtitle_color',
            [
                'label'     => __( 'Text Color', 'bdevselement' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // content

        $this->add_control(
            '_heading_description',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __( 'Content', 'bdevselement' ),
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'heading_desc_margin',
            [
                'label'      => __( 'Margin', 'bdevselement' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .section-heading p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_desc_padding',
            [
                'label'      => __( 'Padding', 'bdevselement' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .section-heading p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description',
                'selector' => '{{WRAPPER}} .section-heading p',
                'scheme'   => Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'description',
                'label'    => __( 'Text Shadow', 'bdevselement' ),
                'selector' => '{{WRAPPER}} .section-heading p',
            ]
        );

        $this->add_control(
            'heading_desc_color',
            [
                'label'     => __( 'Text Color', 'bdevselement' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .section-heading p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // content

        $this->add_control(
            '_back_title',
            [
                'type'      => Controls_Manager::HEADING,
                'label'     => __( 'Back Content', 'bdevselement' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'offset_toggle',
            [
                'label'        => __( 'Offset', 'bdevselement' ),
                'type'         => Controls_Manager::POPOVER_TOGGLE,
                'label_off'    => __( 'None', 'bdevselement' ),
                'label_on'     => __( 'Custom', 'bdevselement' ),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'media_offset_x',
            [
                'label'       => __( 'Offset Left', 'bdevselement' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px'],
                'condition'   => [
                    'offset_toggle' => 'yes',
                ],
                'range'       => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'media_offset_y',
            [
                'label'      => __( 'Offset Top', 'bdevselement' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'condition'  => [
                    'offset_toggle' => 'yes',
                ],
                'range'      => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors'  => [
                    // Media translate styles
                    '(desktop){{WRAPPER}} .back-title' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x.SIZE || 0}}{{UNIT}}, {{media_offset_y.SIZE || 0}}{{UNIT}});',
                    '(tablet){{WRAPPER}} .back-title'  => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_tablet.SIZE || 0}}{{UNIT}}, {{media_offset_y_tablet.SIZE || 0}}{{UNIT}});',
                    '(mobile){{WRAPPER}} .back-title'  => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}}); transform: translate({{media_offset_x_mobile.SIZE || 0}}{{UNIT}}, {{media_offset_y_mobile.SIZE || 0}}{{UNIT}});',
                    // Body text styles
                    '{{WRAPPER}} .back-title'          => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_popover();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'back_title',
                'selector' => '{{WRAPPER}} .back-title',
                'scheme'   => Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'back_title',
                'label'    => __( 'Text Shadow', 'bdevselement' ),
                'selector' => '{{WRAPPER}} .back-title',
            ]
        );

        $this->add_control(
            'back_title_color',
            [
                'label'     => __( 'Text Color', 'bdevselement' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .back-title' => '-webkit-text-stroke-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'title', 'basic' );
        $this->add_render_attribute( 'title', 'class', 'section__title section__title-4 section__title-4-p-2 section-title' );

        $title = bdevs_element_kses_basic( $settings['title'] );

        ?>

        <?php if ( $settings['design_style'] === 'style_3' ):
            $this->add_inline_editing_attributes( 'title', 'basic' );
            $this->add_render_attribute( 'title', 'class', 'section__title section__title-4 section__title-4-p-2' );

        ?>
                   
        <div class="section-heading section__title-wrapper section__title-wrapper-4 wow fadeInUp2 p-0" data-wow-delay=".3s">
            <span class="section__pre-title-img">
                <?php if ( $settings['type'] === 'image' && ( $settings['image']['url'] || $settings['image']['id'] ) ):
                    $this->get_render_attribute_string( 'image' );
                    $settings['hover_animation'] = 'disable-animation'; // hack to prevent image hover animation
                    ?>
                    <figure>
                     <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
                    </figure>
                    <?php elseif ( !empty( $settings['icon'] ) || !empty( $settings['selected_icon']['value'] ) ): ?>
                    <figure>
                        <?php bdevs_element_render_icon( $settings, 'icon', 'selected_icon' );?>
                    </figure>
                <?php endif;?>
            </span>

                <?php if ( $settings['sub_title'] ): ?>
                <span class="section__pre-title purple sub-title"><?php echo bdevs_element_kses_intermediate( $settings['sub_title'] ); ?></span>
                <?php endif;?>

            <?php printf( '<%1$s %2$s>%3$s</%1$s>',
                tag_escape( $settings['title_tag'] ),
                $this->get_render_attribute_string( 'title' ),
                $title
                );
            ?>
           <?php if ( $settings['description'] ): ?>
                <p><?php echo bdevs_element_kses_intermediate( $settings['description'] ); ?></p>
            <?php endif;?>
        </div>

        <?php elseif ( $settings['design_style'] === 'style_2' ):
            $this->add_inline_editing_attributes( 'title', 'basic' );
            $this->add_render_attribute( 'title', 'class', 'section__title section__title-3 section-title' );

         ?>

            <div class="section__title-wrapper section__title-wrapper-3 mb-45 wow fadeInUp2 section-heading p-0" data-wow-delay=".3s">
                <span class="section__pre-title-img">
                    <?php if ( $settings['type'] === 'image' && ( $settings['image']['url'] || $settings['image']['id'] ) ):
                        $this->get_render_attribute_string( 'image' );
                        $settings['hover_animation'] = 'disable-animation'; // hack to prevent image hover animation
                        ?>
                        <figure>
                         <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
                        </figure>
                        <?php elseif ( !empty( $settings['icon'] ) || !empty( $settings['selected_icon']['value'] ) ): ?>
                        <figure>
                            <?php bdevs_element_render_icon( $settings, 'icon', 'selected_icon' );?>
                        </figure>
                    <?php endif;?>
                </span>

                <?php if ( $settings['sub_title'] ): ?>
                    <span class="section__pre-title purple sub-title"><?php echo bdevs_element_kses_intermediate( $settings['sub_title'] ); ?></span>
                <?php endif;?>

                <?php printf( '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape( $settings['title_tag'] ),
                        $this->get_render_attribute_string( 'title' ),
                        $title
                    );
                ?>
               <?php if ( $settings['description'] ): ?>
                    <p><?php echo bdevs_element_kses_intermediate( $settings['description'] ); ?></p>
                <?php endif;?>
            </div>

        <?php else: 
            $this->add_inline_editing_attributes( 'title', 'basic' );
            $this->add_render_attribute( 'title', 'class', 'section__title' );
        ?>

        <div class="section__title-wrapper">
            <?php printf( '<%1$s %2$s>%3$s</%1$s>',
                tag_escape( $settings['title_tag'] ),
                $this->get_render_attribute_string( 'title' ),
                $title
                );
            ?>
            <?php if ( $settings['description'] ): ?>
                <p><?php echo bdevs_element_kses_intermediate( $settings['description'] ); ?></p>
            <?php endif;?>
        </div>

    <?php endif;?>
        <?php
    }
}
