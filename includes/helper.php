<?php 
namespace BdevsElement;

class Helper {

    /** 
    * Get widgets list
    */
    public static function get_widgets() {

        return [


            'post-list' => [
                'title' => __( 'Post List', 'bdevselement' ),
                'icon' => 'fa fa-post-list',
            ],

             'post-tab' => [
                 'title' => __( 'Post Tab', 'bdevselement' ),
                 'icon' => 'fa fa-post-tab',
             ],
            'post-slider' => [
                 'title' => __( 'Post Slider', 'bdevselement' ),
                 'icon' => 'fab fa-usps',
             ],
            'post-list-slider' => [
                 'title' => __( 'Post List Slider', 'bdevselement' ),
                 'icon' => 'fa fa-post-tab',
             ],
            'breadcrumb' => [
                 'title' => __( 'Breadcrumb', 'bdevselement' ),
                 'icon' => 'fas fa-adjust',
             ],
            'related-post-slider' => [
                 'title' => __( 'Related Post List Slider', 'bdevselement' ),
                 'icon' => 'fas fa-sliders-h',
             ],
            'post-video' => [
                 'title' => __( 'Post Video', 'bdevselement' ),
                 'icon' => 'fa fa-post-tab',
             ],
             'post-hero-section' => [
                'title' => __( 'Post Hero Section', 'bdevselement' ),
                'icon' => 'fa fa-post-tab',
            ],
			 'post-category-list' => [
                 'title' => __( 'Category List', 'bdevselement' ),
                 'icon' => 'eicon-product-categories',
             ],

        ];
    }


}


