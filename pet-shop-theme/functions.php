<?php 

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
new JSXBlock('banner');