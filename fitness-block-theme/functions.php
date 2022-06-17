<?php

use JSXBlock as GlobalJSXBlock;

    function theme_style(){
        wp_enqueue_style('bootstrap', get_theme_file_uri('css/bootstrap.min.css'));
        wp_enqueue_style('google-fonts-os', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
        wp_enqueue_style('google-fonts-bn', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
        wp_enqueue_style('font-awesome','//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css');
        wp_enqueue_style('slick-theme','//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
        wp_enqueue_style('slick-min-style','//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
        wp_enqueue_style('slick-min', get_theme_file_uri('css/slick.min.css'));
        
        wp_enqueue_style('theme_style', get_theme_file_uri('style.css'));
        wp_enqueue_style('theme_style_responsive', get_theme_file_uri('/css/responsive.css'));
    }
    add_action('wp_enqueue_scripts', 'theme_style');


    function theme_scripts(){
        $version=wp_get_theme()->get('Version');

        wp_register_script('bootstrap',get_theme_file_uri('/js/bootstrap.bundle.min.js'),array(),$version,true);
        wp_enqueue_script('bootstrap');

        wp_register_script('fitnessjquery',get_theme_file_uri('/js/jquery.min.js'),array(),$version,true);
        wp_enqueue_script('jquery');

        wp_register_script('slick','//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',array('fitnessjquery'),'1.8.1',true);
        wp_enqueue_script('slick');

        wp_register_script('custom',get_theme_file_uri('/js/master.js'),array('fitnessjquery'),$version,true);
        wp_enqueue_script('custom');

        wp_register_script('custom-slick',get_theme_file_uri('/js/slick-custom.js'),array('fitnessjquery'),$version,true);
        wp_enqueue_script('custom-slick');

    }
    add_action('wp_enqueue_scripts', 'theme_scripts');
    
    function theme_features(){
        add_theme_support('editor-styles');    //Adds the support for styling in theme
        add_editor_style(array(  //Adds the custom style path
                'css/bootstrap.min.css',
                'https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css',
                'css/slick.min.css',
                'style.css',
                '/css/responsive.css'
            )); 
        
        add_theme_support( 'editor-color-palette', array(
            array(
                'name'  => esc_attr__( 'strong magenta', 'themeLangDomain' ),
                'slug'  => 'strong-magenta',
                'color' => '#a156b4',
            ),
            array(
                'name'  => esc_attr__( 'light grayish magenta', 'themeLangDomain' ),
                'slug'  => 'light-grayish-magenta',
                'color' => '#d0a5db',
            ),
            array(
                'name'  => esc_attr__( 'very light gray', 'themeLangDomain' ),
                'slug'  => 'very-light-gray',
                'color' => '#eee',
            ),
            array(
                'name'  => esc_attr__( 'very dark gray', 'themeLangDomain' ),
                'slug'  => 'very-dark-gray',
                'color' => '#444',
            ),
        ) );
        add_image_size('pageBanner', 1500, 350, true);
    }
    add_action('after_setup_theme','theme_features');

    class PlaceholderBlock{
        function __construct($name)
        {
            $this->name=$name;
            add_action('init',[$this,'onInit']);
        }
        function ourRenderCallback($attributes,$content){
            ob_start();
            require get_theme_file_path("/fitness-blocks/{$this->name}.php");
            return ob_get_clean();
        }
        function onInit(){
            // Name of the js assest
            //Path of js file
            //  Array of dependencies
            wp_register_script($this->name,get_stylesheet_directory_uri()."/fitness-blocks/{$this->name}.js",array('wp-blocks','wp-editor'));
            // namespace of the block
            // array

            $ourArgs=array(
                'editor_script'=>$this->name,
                'render_callback'=>[$this,'ourRenderCallback']
            );
            
            register_block_type("fitnessblocktheme/{$this->name}",$ourArgs);
        }
    }
    new PlaceholderBlock("header");
    new PlaceholderBlock("footer");
    new PlaceholderBlock("copyright");
    new PlaceholderBlock("page");
    new PlaceholderBlock("single-post");
    new PlaceholderBlock("banner-form");


    class JSXBlock{
        function __construct($name,$renderCallback=null,$data=null)
        {
            $this->name=$name;
            $this->renderCallback=$renderCallback;
            $this->data=$data;
            add_action('init',[$this,'onInit']);
        }
        function ourRenderCallback($attributes,$content){
            ob_start();
            require get_theme_file_path("/fitness-blocks/{$this->name}.php");
            return ob_get_clean();
        }
        function onInit(){
            // Name of the js assest
            //Path of js file
            //  Array of dependencies
            wp_register_script($this->name,get_stylesheet_directory_uri()."/build/{$this->name}.js",array('wp-blocks','wp-editor'));
            // namespace of the block
            // array

            if($this->data){
                wp_localize_script($this->name,$this->name,$this->data);
            }

            $ourArgs=array(
                'editor_script'=>$this->name
            );
            if($this->renderCallback){
                $ourArgs['render_callback'] = [$this,'ourRenderCallback'];
            }
            register_block_type("fitnessblocktheme/{$this->name}",$ourArgs);
        }
    }
    new JSXBlock('fitnessbannersection',true);
    new JSXBlock('fitnessbanner',true,['fallbackImage'=>get_theme_file_uri('/images/NewProject.jpg')]);
    new JSXBlock('fitnessheading');
    new JSXBlock('fitnessbutton');

    new JSXBlock('fitnessslideshow',true,['fallbackImage'=>get_theme_file_uri('/images/wellness-health.jpg')]);
    new JSXBlock('fitnessslide',true,['fallbackImage'=>get_theme_file_uri('/images/athletedumbbells-gym.png')]);

    new JSXBlock('fitnesschoosesection',true,[
        'fallbackImage'=>get_theme_file_uri('/images/Background(2).png'),
        'headingtext'=>'WHY CHOOSE US?',
        'titletext'=>'OUR BEST FEATURES'
    ]);
    new JSXBlock('fitnesschoosecard',true,[
        'fallbackImage'=>get_theme_file_uri('/images/1-01.png'),
    ]);
    new JSXBlock('fitnesschooselink');
    new JSXBlock('fitnesschooseheading');
    new JSXBlock('fitnessslideheading');
    new JSXBlock('fitnessslidetextarea');
    new JSXBlock('fitnessslidename');
    
    new JSXBlock('fitnesstrainingsection',true,[
        'fallbackImage'=>get_theme_file_uri('/images/wellness-health.jpg'),
        'headingtext'=>'Training Session',
        'titletext'=>'Our Services'
    ]);
    new JSXBlock('fitnesstrainingcard',true,['fallbackImage'=>get_theme_file_uri('/images/image-1.jpg')]);

    new JSXBlock('fitnessexperiencesection',true,[
        'headingtext'=>'Experience Trainers',
        'titletext'=>'Our Team'
    ]);
    new JSXBlock('fitnessexperienceslide',true,['fallbackImage'=>get_theme_file_uri('/images/trainer-img1.jpg')]);