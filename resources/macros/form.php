<?php

Form::macro(
    'update',
    function (
        $url,
        $button_label = null,
        $form_parameters = array(),
        $button_options = array()
    ) {

        if (empty($form_parameters) === true) {
            $form_parameters = array(
                                'method' => 'GET',
                                'class'  => 'update-form',
                                'url'    => $url,
                               );
        } else {
            $form_parameters['url']    = $url;
            $form_parameters['method'] = 'GET';
        };

        if (empty($button_label) === true) {
            $button = '<button type="submit" class="btn btn-xs btn-danger ">
                        <i class="glyphicon  glyphicon-trash"></i> Editar
                    </button>';
        } else {
            $button = Form::submit($button_label, $button_options);
        }

        return Form::open($form_parameters).$button.Form::close();
    }
);

Form::macro(
    'delete',
    function (
        $url,
        $button_label = null,
        $form_parameters = array(),
        $button_options = array()
    ) {

        if (empty($form_parameters) === true) {
            $form_parameters = array(
                                'method' => 'DELETE',
                                'class'  => 'delete-form',
                                'url'    => $url,
                               );
        } else {
            $form_parameters['url']    = $url;
            $form_parameters['method'] = 'DELETE';
        };

        if (empty($button_label) === true) {
            $button = '<button 
                            name="delete-button" 
                            type="submit" 
                            class="btn btn-xs btn-danger ">
                                <i class="glyphicon  glyphicon-trash"></i> Excluir
                        </button>';
        } else {
            $button = Form::submit($button_label, $button_options);
        }

        return Form::open($form_parameters).$button.Form::close();
    }
);

Form::macro(
    'add',
    function (
        $url,
        $button_label = null,
        $form_parameters = array(),
        $button_options = array()
    ) {

        if (empty($form_parameters) === true) {
            $form_parameters = array(
                                'method' => 'POST',
                                'class'  => 'delete-form',
                                'url'    => $url,
                               );
        } else {
            $form_parameters['url']    = $url;
            $form_parameters['method'] = 'POST';
        };

        if (empty($button_label) === true) {
            $button = '<button type="submit" class="btn btn-xs btn-success ">
                        <i class="glyphicon  glyphicon-plus"></i>
                    </button>';
        } else {
            $button = Form::submit($button_label, $button_options);
        }

        return Form::open($form_parameters).$button.Form::close();
    }
);


Form::macro(
    'iconLink',
    function (
        $url,
        $title = null,
        $attributes = array(),
        $icon = null,
        $secure = null
    ) {

        $url = url($url, null, $secure);
        if (is_null($title) === true or $title === false) {
            $title = $url;
        }

        return '<a href="'.$url.'"'.HTML::attributes($attributes).'>
                <i class="'.$icon.'"></i> '.HTML::entities($title).'</a>';
    }
);

Form::macro(
    'text_static',
    function ($value, $attributes = array()) {

        if (empty($attributes) === true) {
            $attributes = array('class' => 'form-control-static');
        } else {
            if (isset($attributes['class']) === false) {
                $attributes['class'] = 'form-control-static';
            }
        }

        $ret = sprintf(
            "<p class=\"%s\">%s</p>",
            $attributes['class'],
            $value
        );

        return $ret;
    }
);

Form::macro(
    'selectLang',
    function (
        $name,
        $list = array(),
        $selected = null,
        $options = array(),
        $translator = array()
    ) {

        if (empty($translator) === true) {
            $translator['parameters'] = array();
            $translator['domain']     = "messages";
            $translator['locale']     = null;
        } else {
            if (isset($translator['parameters']) === false) {
                $translator['parameters'] = array();
            }

            if (isset($translator['domain']) === false) {
                $translator['domain'] = "messages";
            }

            if (isset($translator['locale']) === false) {
                $translator['locale'] = null;
            }
        }

        array_walk(
            $list,
            function (&$v, $k, $p) {
                $v = trans($v, $p['parameters'], $p['domain'], $p['locale']);
            },
            $translator
        );

        return Form::select($name, $list, $selected, $options);
    }
);

Form::macro(
    'actions',
    function ($attributes = array()) {

        if (isset($attributes['new']) === true) {
            $actions['new'] = sprintf(
                "<a href='%s'>
            <button type='button' class='btn btn-primary btn-sm '>
            <i class='icon wb-plus'> </i>%s</button></a>",
                $attributes['new'],
                Lang::get("general.New")
            );
        }

        return implode("", $actions);
    }
);

Form::macro(
    'buttonLink',
    function ($link, $class, $icon, $title) {
        
        return "<a href='$link'
                    class='$class mdl-color-text--primary-dark mdl-button mdl-js-button mdl-js-ripple-effect button-link' 
                    title='$title' 
                    name='$title'><i class='material-icons'>$icon</i></a>";
    }
);
