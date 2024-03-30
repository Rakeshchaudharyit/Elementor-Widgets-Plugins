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

class Post_Slider extends BDevs_El_Widget {

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
        return 'post_slider';
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
        return __( 'Post Category Slider', 'bdevselement' );
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
        return [ 'posts', 'post', 'post-slider', 'tab', 'news' ];
    }

    /**
     * Get a list of All Post Types
     *
     * @return array
     */
    public static function get_post_types () {
        $diff_key = [
            'elementor_library' => '',
            'attachment' => '',
            'page' => ''
        ];
        $post_types = bdevs_element_get_post_types( [], $diff_key );
        return $post_types;
    }

    /**
     * Get a list of Taxonomy
     *
     * @return array
     */
    public static function get_taxonomies ( $post_type = '' ) {
        $list = [];
        if ( $post_type ) {
            $tax = bdevs_element_get_taxonomies( [ 'public' => true, "object_type" => [ $post_type ] ], 'object', true );
            $list[$post_type] = count( $tax ) !== 0 ? $tax : '';
        } else {
            $list = bdevs_element_get_taxonomies( [ 'public' => true ], 'object', true );
        }
        return $list;
    }

    protected function register_content_controls () {

        $this->start_controls_section(
            '_section_post_tab_query',
            [
                'label' => __( 'Query', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => __( 'Source', 'bdevselement' ),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_post_types(),
                'default' => key( $this->get_post_types() ),
            ]
        );

        foreach ( self::get_post_types() as $key => $value ) {
            $taxonomy = self::get_taxonomies( $key );
            if ( ! $taxonomy[$key] )
                continue;
            $this->add_control(
                'tax_type_' . $key,
                [
                    'label' => __( 'Taxonomies', 'bdevselement' ),
                    'type' => Controls_Manager::SELECT,
                    'options' => $taxonomy[$key],
                    'default' => key( $taxonomy[$key] ),
                    'condition' => [
                        'post_type' => $key
                    ],
                ]
            );

            foreach ( $taxonomy[$key] as $tax_key => $tax_value ) {

                $this->add_control(
                    'tax_ids_' . $tax_key,
                    [
                        'label' => __( 'Select ', 'bdevselement' ) . $tax_value,
                        'label_block' => true,
                        'type' => 'bdevselement-select2',
                        'multiple' => true,
                        'placeholder' => 'Search ' . $tax_value,
                        'data_options' => [
                            'tax_id' => $tax_key,
                            'action' => 'bdevs_element_post_tab_select_query'
                        ],
                        'condition' => [
                            'post_type' => $key,
                            'tax_type_' . $key => $tax_key
                        ],
                        'render_type' => 'template',
                    ]
                );
            }

        }
        foreach ($this->get_post_types() as $key => $value) {

            $this->add_control(
                'post_id',
                [
                    'label' => __('Exclude ', 'bdevselement') . $value,
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
        }
        $this->add_control(
            'item_limit',
            [
                'label' => __( 'Item Limit', 'bdevselement' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 12,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->end_controls_section();


    }

    protected function register_style_controls () {




        //Content Style
        $this->start_controls_section(
            '_section_post_tab_content',
            [
                'label' => __( 'Post Style', 'bdevselement' ),
                'tab' => Controls_Manager::TAB_STYLE,
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
                    '{{WRAPPER}} .post__content .post__title' => 'color: {{VALUE}}',
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

    protected function render () {

        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes( 'title', 'basic' );
        $this->add_render_attribute( 'title', 'class', 'section-title shape' );
        $this->add_render_attribute( 'title3', 'class', 'section-title d-block' );

        $title = bdevs_element_kses_basic( $settings['title' ] );

        if ( ! $settings['post_type'] )
            return;

        $taxonomy = $settings['tax_type_' . $settings['post_type']];
        $terms_ids = $settings['tax_ids_' . $taxonomy];
        $terms_args = [
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
            'include' => $terms_ids,
            'orderby' => 'term_id',
        ];
        $filter_list = get_terms( $terms_args );

        $post_args = [
            'post_status' => 'publish',
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['item_limit'],
            'post__not_in' => [$settings['post_id']],
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $terms_ids ? $terms_ids : '',
                ),
            ),
        ];

        $posts = query_posts( $post_args );

        $query_settings = [
            'post_type' => $settings['post_type'],
            'taxonomy' => $taxonomy,
            'item_limit' => $settings['item_limit'],
            'excerpt' => $settings['excerpt'] ? $settings['excerpt'] : 'no',
        ];
        $query_settings = json_encode( $query_settings, true );

        $event = 'click';
        if ( 'hover' === $settings['event'] ) {
            $event = 'hover touchstart';
        }



        $wrapper_class = [];
        $this->add_render_attribute( 'wrapper', 'class', $wrapper_class );
        $this->add_render_attribute( 'wrapper', 'data-query-args', $query_settings );
        $this->add_render_attribute( 'wrapper', 'data-event', $event );
        $this->add_render_attribute( 'project-filter', 'class', [ 'masonary-menu filter-button-group' ] );
        $this->add_render_attribute( 'project-body', 'class', [ 'row row-post' ] );


        if ( !empty($terms_ids) && count( $posts ) !== 0 ) : ?>

            <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
                <div class="flickfeed video-list-slider">
                    <?php
                    if ( have_posts() ) : 
                        
                        foreach($posts as $ixd=>$post) :
                        $video_thumb = get_the_post_thumbnail_url($post->ID, 'video_thumb');
                        $categories = get_the_terms( $post->ID, $taxonomy );
                        $video_views = get_post_meta( $post->ID, 'popular_videos', true );
                        ?>
                        <a href="<?php echo esc_url(get_the_permalink($post->ID)); ?>" class="item_wrap">
                            <div class="post_item">
                                <div class="item-img">
                                        <img src="<?php print get_the_post_thumbnail_url($post->ID, 'full'); ?>" alt="<?php echo get_the_title(); ?>">
                                </div>
                                <div class="post__content">
                                    <h3 class="post__title"><?php echo get_the_title($post->ID); ?></h3>
                                    <div class="post-meta">
                                        <div class="post-date"><i class="<?php echo esc_html($settings['post_meta_icon_time']['value']);?>"></i> Added <?php echo human_time_diff( strtotime( $post->post_date ), current_time( 'timestamp' ) ).' '.__( 'ago' );?></div>
                                        <div class="post-views"><i class="<?php echo esc_html($settings['post_meta_icon_view']['value']);?>"></i> <?php echo  $video_views;?> views</div>
                                    </div>
                                </div>
                            </div>
                        </a>



                    <?php endforeach;
                    endif; ?>
                </div>
            </div>

        <?php else:
            printf( '%1$s',
                __( 'No  Posts  Found', 'bdevselement' )
            );
        endif;



    }
}