<?php

Form::macro('delete',function($url, $button_label=null,$form_parameters = array(),$button_options=array()){
 
    if(empty($form_parameters)){
        $form_parameters = array(
            'method'=>'DELETE',
            'class' =>'delete-form',
            'url'   =>$url
            );
    }else{
        $form_parameters['url'] = $url;
        $form_parameters['method'] = 'DELETE';
    };
         
    if(empty($button_label)) {
        $button = '<button type="submit" class="btn btn-xs btn-danger ">
                        <i class="glyphicon  glyphicon-trash"></i>
                    </button>';
    }
    else {
        $button = Form::submit($button_label, $button_options);
    }
 
    return Form::open($form_parameters) . $button . Form::close();
});

Form::macro('add',function($url, $button_label=null,$form_parameters = array(),$button_options=array()){
 
    if(empty($form_parameters)){
        $form_parameters = array(
            'method'=>'POST',
            'class' =>'delete-form',
            'url'   =>$url
            );
    }else{
        $form_parameters['url'] = $url;
        $form_parameters['method'] = 'POST';
    };
         
    if(empty($button_label)) {
        $button = '<button type="submit" class="btn btn-xs btn-success ">
                        <i class="glyphicon  glyphicon-plus"></i>
                    </button>';
    }
    else {
        $button = Form::submit($button_label, $button_options);
    }
 
    return Form::open($form_parameters) . $button . Form::close();
});


Form::macro('iconLink', function($url, $title = null, $attributes = array(), $icon = null, $secure = null) {
  $url = url($url,NULL,$secure);
  if (is_null($title) or $title === false) $title = $url;
  return '<a href="'.$url.'"'.HTML::attributes($attributes).'><i class="'. $icon .'"></i> '. HTML::entities($title).'</a>';
});

Form::macro('text_static', function($value, $attributes = array()) {  
    
    if(empty($attributes)) {
        $attributes = array(
            'class' => 'form-control-static'
        );
    }
    else {
        if(!isset($attributes['class'])) {
            $attributes['class'] = 'form-control-static';
        }
    }
    
    $ret = sprintf("<p class=\"%s\">%s</p>",$attributes['class'],
            $value);
    
    return $ret;
});

Form::macro('selectLang', function($name, $list = array(), $selected = null, 
        $options = array(), $translator = array()) {  

    if(empty($translator)) {
        $translator['parameters'] = array();
        $translator['domain']     = "messages";        
        $translator['locale']     = null;        
    }
    else {
        if(!isset($translator['parameters'])) $translator['parameters'] = array();
        if(!isset($translator['domain'])) $translator['domain'] = "messages";        
        if(!isset($translator['locale'])) $translator['locale'] = null;  
    }
   // dd($translator);
    array_walk($list, function(&$v, $k, $p){
       $v = trans($v, $p['parameters'], $p['domain'], $p['locale']);
    }, $translator);
    
    return Form::select($name, $list, $selected, $options);
});