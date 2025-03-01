<?php

if (!function_exists('limpiar_cadena_texto')) {
    function limpiar_cadena_texto($cadena){
        //Reemplazamos la A y a
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );

        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );

        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );

        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );

        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena);

        //Reemplazamos la N, n, C y c
        // $cadena = str_replace(
        // array('Ñ', 'ñ', 'Ç', 'ç'),
        // array('N', 'n', 'C', 'c'),
        // $cadena
        // );

        //SEPARAMOS LAS CADENAS EN UN ARRAY - LIMPIAMOS ESPACIOS EN BLANCOS
        $tmp_separador = explode(" ", $cadena);
        foreach ($tmp_separador as $key => $value) {
            if($value != "") $tmp_string[] = $value;
        }
        
        $new_cadena = '';
        foreach ($tmp_string as $key => $value) {
            $new_cadena .= $value.' ';
        }

        
        return strtoupper(trim($new_cadena));
    }
}

if (!function_exists('select_group')) {
    function select_group($data){
        $select = '<option value="">ES NECESARIO SELECCIONAR UNA OPCION.</option>';
        $array_select = [];        
        
        if(!empty($data)){
            
            foreach ($data as $key => $value) {
                // VERIFICAMOS EL CAMPO GROUP => name
                if(array_key_exists('name', $value)) $array_select[$value['name']][] = $value;
                // VERIFICAMOS EL CAMPO GROUP => nombre
                if(array_key_exists('nombre', $value)) $array_select[$value['nombre']][] = $value;
                // VERIFICAMOS EL CAMPO GROUP => value
                if(array_key_exists('value', $value)) $array_select[$value['value']][] = $value;

            }
        
            if(!empty($array_select)){
                foreach ($array_select as $key => $value) {
                    $select .= '<optgroup label="'.$key.'">';
                    foreach ($value as $key_result => $value_result) {
                        // VERIFICAMOS EL CAMPO VALUE => route
                        if(array_key_exists('route', $value_result)) $select .= '<option value="'.$value_result['id'].'">'.$value_result['route'].' => '.$value_result['method'].'</option>';
                        
                    }
                    $select .= '</optgroup>';
                }    
            }
        }
        
        return $select;
    }
}