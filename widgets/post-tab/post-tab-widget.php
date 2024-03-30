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

class Post_Tab extends BDevs_El_Widget {

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
        return 'post_tab';
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
		return __( 'Post Category', 'bdevselement' );
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
		return 'eicon-posts-group';
	}

	public function get_keywords () {
		return [ 'posts', 'post', 'post-tab', 'tab', 'news' ];
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
				'default' => 3,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		//Settings
		$this->start_controls_section(
			'_section_settings',
			[
				'label' => __( 'Settings', 'bdevselement' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


        $this->add_responsive_control(
            'grid_column',
            [
                'label' => __( 'Column', 'bdevselement' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'one_column',
                'options' => [
                    'one_column' => __('1 Column', 'bdevselement'),
                    'two_column' => __('2 Column', 'bdevselement'),
                    'three_column' => __('3 Column', 'bdevselement'),
                    'four_column' => __('4 Column', 'bdevselement'),
                    'six_column' => __('6 Column', 'bdevselement'),
                ],
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
			'post_content_excerpt',
			[
				'label' => __( 'Excerpt', 'bdevselement' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'excerpt' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'label' => __( 'Typography', 'bdevselement' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .post_excerpt',
				'condition' => [
					'excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Color', 'bdevselement' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .post__content p' => 'color: {{VALUE}};',
				],
				'condition' => [
					'excerpt' => 'yes',
				],
			]
		);

        $this->add_responsive_control(
            'excerpt_margin_top',
            [
                'label' => __( 'Margin', 'bdevselement' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .post__content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        if ( !empty($terms_ids) && count( $posts ) !== 0 ) :
        ?>

        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="video-list-slider video-list row-clumn-<?php echo esc_attr($settings['grid_column'] ? $settings['grid_column'] : 6); ?>">
                <?php
                if ( have_posts() ) : while ( have_posts() ) : the_post();

                    $video_views = get_post_meta( get_the_ID(), 'popular_videos', true );

                    $video_thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');

                    ?>

					<div class="post_item">

						<div class="item-img">
                            <a href="<?php the_permalink();?>"><img src="<?php echo esc_url($video_thumb);?>" alt="<?php the_title();?>"></a>
                        </div>

						<div class="post__content">
							<h3 class="post__title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                            <div class="post-meta">
                                <div class="post-views"><img src="<?php echo BDEVSEL_ASSETS;?>img/view.svg" alt="view"> <?php echo  $video_views;?> views</div>
                                <div class="post-date"><img src="<?php echo BDEVSEL_ASSETS;?>img/clock.svg" alt="date"> Added <?php echo get_the_date(); ?></div>
                            </div>
                        </div>
                     
                    </div>

                <?php endwhile;
                    wp_reset_query();
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
