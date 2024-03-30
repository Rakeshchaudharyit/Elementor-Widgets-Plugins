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


class Post_List_slider extends BDevs_El_Widget
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
        return 'post_listslider';
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
        return __('Post List Slider', 'bdevselement');
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
        return 'eicon-post-list';
    }

    public function get_keywords()
    {
        return ['posts', 'post', 'post-list-slider', 'list', 'news'];
    }

    /**
     * Get a list of All Post Types
     *
     * @return array
     */
    public function get_post_types()
    {
        $post_types = bdevs_element_get_post_types([], ['elementor_library', 'attachment']);
        return $post_types;
    }


    public function wp_init(){
        // post view count based on single page visit
        add_action( 'wp_head', array($this, 'fe_track_post_views'));
    }

    public function fe_track_post_views ($post_id) {
        if ( !is_single() ) return;
        if ( empty ( $post_id) ) {
            global $post;
            $post_id = $post->ID;
        }
        $this->fe_set_post_views($post_id);
    }


    public function fe_set_post_views($postID) {
        $count_key = 'popular_videos';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 1;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '1');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
    protected function register_content_controls()
    {

        $this->start_controls_section(
            '_section_post_list',
            [
                'label' => __('List', 'bdevselement'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => __('Source', 'bdevselement'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_post_types(),
                'default' => key($this->get_post_types()),
            ]
        );

        $this->add_control(
            'show_post_by',
            [
                'label' => __('Show post by:', 'bdevselement'),
                'type' => Controls_Manager::SELECT,
                'default' => 'recent',
                'options' => [
                    'recent' => __('Recent Post', 'bdevselement'),
                    'selected' => __('Selected Post', 'bdevselement'),
                    'popular' => __('Most popular', 'bdevselement'),
                ],

            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Item Limit', 'bdevselement'),
                'type' => Controls_Manager::NUMBER,
                'default' => 16,
                'dynamic' => ['active' => true],
                'condition' => [
                    'show_post_by' => ['recent']
                ]
            ]
        );

        $repeater = [];

        foreach ($this->get_post_types() as $key => $value) {

            $repeater[$key] = new Repeater();

            $repeater[$key]->add_control(
                'title',
                [
                    'label' => __('Title', 'bdevselement'),
                    'type' => Controls_Manager::TEXT,
                    'label_block' => true,
                    'placeholder' => __('Customize Title', 'bdevselement'),
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );

            $repeater[$key]->add_control(
                'post_id',
                [
                    'label' => __('Select ', 'bdevselement') . $value,
                    'label_block' => true,
                    'type' => BDevs_El_Select2::TYPE,
                    'multiple' => false,
                    'placeholder' => 'Search ' . $value,
                    'data_options' => [
                        'post_type' => $key,
                        'action' => 'bdevs_element_post_list_query'
                    ],
                ]
            );

            $this->add_control(
                'selected_list_' . $key,
                [
                    'label' => '',
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater[$key]->get_controls(),
                    'title_field' => '{{ title }}',
                    'condition' => [
                        'show_post_by' => 'selected',
                        'post_type' => $key
                    ],
                ]
            );
        }

        $this->end_controls_section();

        //Settings
        $this->start_controls_section(
            '_section_settings',
            [
                'label' => __('Settings', 'bdevselement'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );



        $this->add_control(
            'title_tag',
            [
                'label' => __('Title HTML Tag', 'bdevselement'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'h1' => [
                        'title' => __('H1', 'bdevselement'),
                        'icon' => 'eicon-editor-h1'
                    ],
                    'h2' => [
                        'title' => __('H2', 'bdevselement'),
                        'icon' => 'eicon-editor-h2'
                    ],
                    'h3' => [
                        'title' => __('H3', 'bdevselement'),
                        'icon' => 'eicon-editor-h3'
                    ],
                    'h4' => [
                        'title' => __('H4', 'bdevselement'),
                        'icon' => 'eicon-editor-h4'
                    ],
                    'h5' => [
                        'title' => __('H5', 'bdevselement'),
                        'icon' => 'eicon-editor-h5'
                    ],
                    'h6' => [
                        'title' => __('H6', 'bdevselement'),
                        'icon' => 'eicon-editor-h6'
                    ]
                ],
                'default' => 'h3',
                'toggle' => false,
            ]
        );



        $this->end_controls_section();
    }

    protected function register_style_controls()
    {



        //Content Style
        $this->start_controls_section(
            '_section_post_tab_content_list',
            [
                'label' => __( 'Post Style', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'post_content_title_list',
            [
                'label' => __( 'Title', 'bdevselement' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography_list',
                'label' => __( 'Typography', 'bdevselement' ),
                'scheme' => Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .post__content .post__title',
            ]
        );

        $this->start_controls_tabs( 'title_tabs_list' );
        $this->start_controls_tab(
            'title_normal_tab_list',
            [
                'label' => __( 'Normal', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'title_color_list',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post__content .post__title' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_hover_tab_list',
            [
                'label' => __( 'Hover', 'bdevselement' ),
            ]
        );

        $this->add_control(
            'title_hvr_color_list',
            [
                'label' => __( 'Color', 'bdevselement' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post__content .post__title:hover' => 'color: {{VALUE}}',
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
                'label' => esc_html__( 'Background', 'plugin-name' ),
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
                'label' => esc_html__( 'Icon Options', 'plugin-name' ),
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
                'label' => esc_html__( 'Space Between', 'plugin-name' ),
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
                'label' => esc_html__( 'Text Indent', 'plugin-name' ),
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
                'label' => esc_html__( 'Navigation Size', 'plugin-name' ),
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
                'label' => esc_html__( 'Space Between', 'plugin-name' ),
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
                'label' => esc_html__( 'Margin', 'plugin-name' ),
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

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        if (!$settings['post_type']) return;
        $args = [
            'post_status' => 'publish',
            'post_type' => $settings['post_type'],
        ];
        if ('recent' === $settings['show_post_by']) {
            $args['posts_per_page'] = $settings['posts_per_page'];
        }
        if($settings['show_post_by'] === 'popular'){
            $args['meta_key']	= 'popular_videos';
            $args['orderby'] 	= 'meta_value_num';
            $args['order']		= 'DESC';
        };

        $selected_post_type = 'selected_list_' . $settings['post_type'];

        $customize_title = [];
        $ids = [];
        if ('selected' === $settings['show_post_by']) {
            $args['posts_per_page'] = -1;
            $lists = $settings['selected_list_' . $settings['post_type']];
            if (!empty($lists)) {
                foreach ($lists as $index => $value) {
                    $post_id = !empty($value['post_id']) ? $value['post_id'] : 0;
                    $ids[] = $post_id;
                    if ($value['title']) $customize_title[$post_id] = $value['title'];
                }
            }
            $args['post__in'] = (array)$ids;
            $args['orderby'] = 'post__in';
        }

        if ('selected' === $settings['show_post_by'] && empty($ids)) {
            $posts = [];
        } else {
            $posts = get_posts($args);
        }

        $this->add_render_attribute('title', 'class', 'post__title');?>
        <div class="video-list-slider-nav"></div>
        <div class="flickfeed video-list-slider">

            <?php foreach ($posts as $inx => $post):
                $categories = get_the_terms( $post->ID, 'video_category' );
                $video_views = get_post_meta( $post->ID, 'popular_videos', true );

                ?>

                    <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>" class="item_wrap" >
                        <div class="post_item">
                            <div class="item-img">
                                <img src="<?php print get_the_post_thumbnail_url($post->ID, 'full'); ?>" alt="<?php echo get_the_title($post->ID); ?>">
                            </div>

                            <div class="post__content">
                                <?php $title = $post->post_title;
                                if ('selected' === $settings['show_post_by'] && array_key_exists($post->ID, $customize_title)) {
                                    $title = $customize_title[$post->ID];
                                }
                                printf('<%1$s %2$s>%3$s</%1$s>',
                                    tag_escape($settings['title_tag']),
                                    $this->get_render_attribute_string('title'),
                                    esc_html($title)
                                ); ?>
                                <div class="post-meta">
                                    <div class="post-date"><i class="<?php echo esc_html($settings['post_meta_icon_time']['value']);?>"></i> Added <?php echo human_time_diff( strtotime( $post->post_date ), current_time( 'timestamp' ) ).' '.__( 'ago' );?></div>
                                    <div class="post-views"><i class="<?php echo esc_html($settings['post_meta_icon_view']['value']);?>"></i> <?php echo  $video_views;?> views</div>
                                </div>
                            </div>
                        </div>
                    </a>

            <?php endforeach; ?>

        </div>

    <?php }
}