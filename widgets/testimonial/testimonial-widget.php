<?php
namespace BdevsElement\Widget;

use BdevsElement\BDevs_El_Select2;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Typography;
Use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Background;
use BdevsElementor\Controls\Select2;
use Elementor\Icons_Manager;

defined( 'ABSPATH' ) || die();

class Testimonial extends BDevs_El_Widget {

    /**
     * Get widget name.
     *
     * Retrieve Bdevs Element widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'testimonial_ev';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title () {
        return __( 'Testimonials', 'bdevselement' );
    }

    public function get_custom_help_url () {
        return 'http://elementor.plagaddons.com//widgets/post-tab/';
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon () {
        return 'eicon-post-slider';
    }

    public function get_keywords () {
        return [ 'testimonial', 'testimonials' ];
    }

    protected function register_content_controls () {

        $this->start_controls_section(
            '_section_testimonial',
            [
                'label' => __( 'Testimonial', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'list_title', [
                'label' => esc_html__( 'Title', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'List Title' , 'bdevselement' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'badge', [
                'label' => esc_html__( 'Badge', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Badge' , 'bdevselement' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'badge_bg', [
                'label' => esc_html__( 'Badge background', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'name', [
                'label' => esc_html__( 'Name', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Name' , 'bdevselement' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__( 'Repeater List', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__( 'Title #1', 'bdevselement' ),
                        'badge' => esc_html__( 'Badge', 'bdevselement' ),
                        'image' => esc_html__( 'Image', 'bdevselement' ),
                        'name' => esc_html__( 'Name', 'bdevselement' ),
                    ]
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );


        $this->end_controls_section();


    }

    protected function register_style_controls () {

        //Content Style
        $this->start_controls_section(
            '_section_post_tab_content',
            [
                'label' => __( 'Testimonial Style', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'title_margin_btm',
            [
                'label' => __( 'Margin', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],

                'selectors' => [
                    '{{WRAPPER}} .single-video-related-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'to-title_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-video-related-title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title-top_typography',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .single-video-related-title',
            ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
            '_section_post_tab_content_box',
            [
                'label' => __( 'Box', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow', 'bdevselement' ),
                'selector' => '{{WRAPPER}} .post_item',
            ]
        );


        $this->add_responsive_control(
            'post_content_title',
            [
                'label' => __( 'Title', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'post_content_margin_btm',
            [
                'label' => __( 'Margin', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],

                'selectors' => [
                    '{{WRAPPER}} .post__content .post__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .post__content .post__title',
            ]
        );

        $this->start_controls_tabs( 'title_tabs' );
        $this->start_controls_tab(
            'title_normal_tab',
            [
                'label' => __( 'Normal', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post__content .post__title a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_hover_tab',
            [
                'label' => __( 'Hover', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'title_hvr_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post__content .post__title a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'post_meta_list',
            [
                'label' => __( 'Meta', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'post_meta_bg',
                'label' => esc_html__( 'Background', 'bdevselement' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .post__content',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'post_meta_typography',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .post-views, {{WRAPPER}} .post-date',
            ]
        );
        $this->add_control(
            'post_meta_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-views, {{WRAPPER}} .post-date' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'post_content_radius',
            [
                'label' => __( 'Radius', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .item_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'meta_icon_options',
            [
                'label' => esc_html__( 'Icon Options', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'post_meta_icon_view',
            [
                'label' => __( 'View Icon', 'bdevselement' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'post_meta_icon_time',
            [
                'label' => __( 'Time Icon', 'bdevselement' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fa-thin fa-clock',
                    'library' => 'solid',
                ],
            ]
        );
        $this->add_control(
            'post_meta_space',
            [
                'label' => esc_html__( 'Space Between', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
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
                    '{{WRAPPER}} .post-views' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'post_meta_icon_color',
            [
                'label' => __( 'Icon Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-meta i, {{WRAPPER}} .post-meta i:before' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'post_meta_icon_margin',
            [
                'label' => esc_html__( 'Text Indent', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
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
                    '{{WRAPPER}} .post-views i, {{WRAPPER}} .post-date i' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            '_section_post_tab_navigations',
            [
                'label' => __( 'Navigation', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'post_navigation_size',
            [
                'label' => esc_html__( 'Navigation Size', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 45,
                ],
                'selectors' => [
                    '{{WRAPPER}} .flickfeed .slick-arrow svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'post_navigation_space',
            [
                'label' => esc_html__( 'Space Between', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .flickfeed .slick-arrow.slick-prev' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'post_navigation_margin',
            [
                'label' => esc_html__( 'Margin', 'bdevselement' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -65,
                ],
                'selectors' => [
                    '{{WRAPPER}} .flickfeed .slick-arrow' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'post_navigation_color',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button.slick-arrow svg path' => 'stroke: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'post_navigation_hover_color',
            [
                'label' => __( 'Hover Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .flickfeed .slick-arrow:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'post_navigation_hover_stroke_color',
            [
                'label' => __( 'Hover Stroke Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .flickfeed .slick-arrow:hover svg path' => 'stroke: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render () {

        $settings = $this->get_settings_for_display(); ?>
        <div class="flickfeed sp-testimonial">

            <?php foreach ( $settings['list'] as $inx => $item ) {?>
                <div class="slide-list">
                    <div class="slide-list-img">
                        <?php
                        // Get image HTML
                        $this->add_render_attribute( 'image', 'src', $item['image']['url'] );
                        $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $item['image'] ) );
                        $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $item['image'] ) );
                        $this->add_render_attribute( 'image', 'class', 'my-custom-class' );
                        echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $item, 'thumbnail', 'image' );
                        ?>
                    </div>
                    <div class="slide-list-info">
                        <span><?php echo esc_html($item['badge']);?></span>
                        <h3><?php echo esc_html($item['title']);?></h3>
                        <p><?php echo esc_html($item['name']);?></p>
                    </div>
                </div>
            <?php };?>
        </div>

    <?php
    }
}
