<?php
        use Config\Services;

if (!function_exists('tracker')){
    function tracker(){
        // Establecemos hora local
        date_default_timezone_set('America/Mazatlan');
        
        // Cargamos el servicio de session y agent
        $session = Services::session();
        $request = Services::request();
        $agent = $request->getUserAgent();
        $ip = $request->getIPAddress();
        
        // Instanciamos el modelo - table:sys_tracker
        $trackerModel = new \App\Models\SysTrackerModel();
        
        // Obtenemos la IP del usuario
        if ($agent->isBrowser()) {
            $userAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
        } elseif ($agent->isRobot()) {
            $userAgent = $agent->getRobot();
        } elseif ($agent->isMobile()) {
            $userAgent = $agent->getMobile();
        } else {
            $userAgent = 'Unidentified User Agent';
        }
        
        // Obtenemos la ubicación del usuario
        $ctx = stream_context_create([
            'http' => [
                'timeout' => 5,  // Seconds
            ]
        ]);
        
        $getloc = @json_decode(file_get_contents("http://ipinfo.io/" . $ip, false, $ctx));
        
        // Recuperamos el ID de usuario de la sesión
        $id_usuario = ($session->get('id_usuario')) ? $session->get('id_usuario') : 0;
        $id_usuario_empresa = ($session->get('id_usuario_empresa')) ? $session->get('id_usuario_empresa') : 0;
        
        // Definimos los datos a guardar
        $data = [
            'id_usuario' => $id_usuario,
            'id_usuario_empresa' => $id_usuario_empresa,
            'agent' => $userAgent,
            'platform' => $agent->getPlatform(),
            'visited' => base_url(uri_string()),
            'referrer' => $agent->getReferrer(),
            'uuid' => getUuid(),
            'ip' => $ip,
            'hostname' => (isset($getloc->hostname)) ? $getloc->hostname : '-',
            'city' => (isset($getloc->city)) ? $getloc->city : '-',
            'region' => (isset($getloc->region)) ? $getloc->region : '-',
            'country' => (isset($getloc->country)) ? $getloc->country : '-',
            'loc' => (isset($getloc->loc)) ? $getloc->loc : '-',
            'org' => (isset($getloc->org)) ? $getloc->org : '-',
            'postal' => (isset($getloc->postal)) ? $getloc->postal : '-',
        ];
        // Insertamos los datos en la base de datos
        $trackerModel->save($data);
    }
}

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

if (!function_exists('getUuid')) {
    function getUuid(): string
    {
        // Usa ramsey/uuid si lo tienes, o simplemente crea uno aleatorio
        return bin2hex(random_bytes(16));
    }
}

if (!function_exists('process_store')) {
    /**
     * Crea un nuevo registro con validación de duplicados y renderiza una vista.
     *
     * @param array $params {
     *     @type object $data            Datos a guardar.
     *     @type object $model           Instancia del modelo.
     *     @type string|array $view      Ruta de la vista o ['load' => string, 'data' => callable|array].
     *     @type string $field_name      Nombre del recurso para mensajes.
     *     @type string|array $field_check Campo(s) a validar como duplicado.
     *     @type callable|null $callback Función para preparar los datos.
     * }
     * @return string JSON con resultado.
     */
    function process_store(array $params): string {
        $data            = $params['data'] ?? null;
        $model           = $params['model'] ?? null;
        $field_check     = $params['field_check'] ?? 'name';
        $field_name      = strtoupper($params['field_name'] ?? 'REGISTRO');
        $view_path       = $params['view'] ?? '';
        $preSaveCallback = $params['precallback'] ?? null;
        $postSaveCallback = $params['postcallback'] ?? null;

        $response = [
            'response_message' => ['type' => '', 'message' => ''],
            'next' => false,
            'csrf_token' => csrf_hash()
        ];

        if (empty($data) || !$model) {
            $response['response_message'] = [
                'type' => 'error',
                'message' => 'DATOS O MODELO INVÁLIDO.'
            ];
            return json_encode($response);
        }

        // Validación de duplicado
        $builder = $model->builder()->select('*');

        if (is_array($field_check)) {
            $first = true;
            foreach ($field_check as $field) {
                if (isset($data->$field)) {
                    if ($first) {
                        $builder->where($field, $data->$field);
                        $first = false;
                    } else {
                        $builder->orWhere($field, $data->$field);
                    }
                }
            }
        } else {
            $builder->where($field_check, $data->$field_check);
        }

        $duplicado = $builder->get()->getFirstRow();

        if ($duplicado) {
            $campos = [];

            if (is_array($field_check)) {
                foreach ($field_check as $field) {
                    if (isset($data->$field)) {
                        $campos[] = "<strong>{$field}</strong>: {$data->$field}";
                    }
                }
            } else {
                $campos[] = "<strong>{$field_check}</strong>: {$data->$field_check}";
            }

            $response['response_message'] = [
                'type' => 'warning',
                'message' => 'YA EXISTE UN REGISTRO CON LOS DATOS: ' . implode(', ', $campos)
            ];
        } else {
            // Preprocesar datos si es necesario
            if (is_callable($preSaveCallback)) {
                $data = $preSaveCallback($data);
            }

            $data->id_usuario_empresa_creacion = session('id_usuario_empresa');
            $data->id_usuario_empresa_edicion  = session('id_usuario_empresa');

            // Insertamos los datos
            $model->save((array)$data);
            $insertID = $model->getInsertID();

            $response['next'] = true;
            // $response['new_id'] = $insertID;
            $response['response_message'] = [
                'type' => 'success',
                'message' => "EL {$field_name} <strong>{$data->{$field_check[0] ?? $field_check}}</strong> SE AGREGÓ CON ÉXITO."
            ];

            // Ejecutamos post-callback si se definió
            if (is_callable($postSaveCallback)) {
                $postSaveCallback($insertID, $data);
            }

            // Renderizar vista si se especificó
            if (!empty($view_path)) {
                if (is_array($view_path) && isset($view_path['load'])) {
                    // Si viene como ['load' => 'ruta', 'data' => callable|array]
                    $view_data = [];

                    if (isset($view_path['data'])) {
                        $view_data = is_callable($view_path['data'])
                            ? ['data' => $view_path['data']()]
                            : (array) $view_path['data'];
                    } else {
                        $view_data = ['data' => $model->findAll()];
                    }

                    $response['view'] = view($view_path['load'], $view_data);
                } elseif (is_string($view_path)) {
                    // Si viene como string plano
                    $response['view'] = view($view_path, [
                        'data' => $model->findAll()
                    ]);
                }
            }
        }

        return json_encode($response);
    }
}

if (!function_exists('process_edit')) {
    /**
     * Obtiene un registro por ID para ser editado, con opción a una consulta personalizada.
     *
     * @param array $params {
     *     @type object $data           Datos recibidos del request (json_decode).
     *     @type object $model          Instancia del modelo (ej. new RoleModel()).
     *     @type string $field_name     Nombre del recurso para mostrar mensajes (ej. 'Usuario').
     *     @type string $id_field       Campo identificador del registro (default: 'id').
     *     @type callable|null $custom_query Función opcional que recibe el modelo y el ID y devuelve el registro.
     * }
     *
     * @return string JSON con el resultado, mensaje y csrf_token.
     */
    function process_edit(array $params): string {
        $requestData   = $params['data'] ?? null;
        $model         = $params['model'] ?? null;
        $field_name    = strtoupper($params['field_name'] ?? 'REGISTRO');
        $custom_query  = $params['query'] ?? null;

        $response = [
            'response_message' => [
                'type' => '',
                'message' => "NO SE ENCONTRÓ EL IDENTIFICADOR PARA REALIZAR LA OPERACIÓN."
            ],
            'next' => false,
            'csrf_token' => csrf_hash()
        ];

        // Verificamos que existan datos válidos
        if (!$model || !$requestData || !isset($requestData->data->id)) {
            return json_encode($response);
        }

        $id = $requestData->data->id;

        // Usamos consulta personalizada si existe
        if (is_callable($custom_query)) {
            $registro = $custom_query($model, $id);
        } else {
            // Consulta básica por ID
            $registro = $model->where('id', $id)->first();
        }

        if ($registro) {
            $response['next'] = true;
            $response['data'] = $registro;
        } else {
            $response['response_message'] = [
                'type' => 'error',
                'message' => "NO SE ENCONTRÓ EL {$field_name} CON <strong>ID {$id}</strong> EN LA BASE DE DATOS."
            ];
        }

        return json_encode($response);
    }
}


if (!function_exists('process_update')) {
    /**
     * Actualiza un registro existente, validando duplicados y renderizando vista.
     *
     * @param array $params {
     *     @type object $data            Objeto con los datos decodificados.
     *     @type object $model           Instancia del modelo.
     *     @type string $model_name      Nombre para mensajes (ej. 'ROL').
     *     @type array  $field_check     Campos para validar duplicados. Ej: ['name' => $data->name].
     *     @type string $view       Ruta de la vista opcional.
     *     @type callable|null $preUpdateCallback Función opcional para preparar datos antes de actualizar.
     * }
     * @return string JSON
     */
    function process_update(array $params): string {
        $data       = $params['data'] ?? null;
        $model      = $params['model'] ?? null;
        $model_name = strtoupper($params['model_name'] ?? 'REGISTRO');
        $fields     = $params['field_check'] ?? [];
        $field_name = strtoupper($params['field_name'] ?? 'REGISTRO');
        $view_path  = $params['view'] ?? '';
        $preUpdateCallback = $params['precallback'] ?? null;
        $postSaveCallback = $params['postcallback'] ?? null;

        $response = [
            'response_message' => ['type' => '', 'message' => ''],
            'next' => false,
            'csrf_token' => csrf_hash()
        ];
        
        $id = $data->data->id ?? null;
        
        if (!$data || !$model || !$id) {
            $response['response_message'] = [
                'type' => 'error',
                'message' => 'DATOS, MODELO O ID INVÁLIDOS.'
            ];
            return json_encode($response);
        }
        
        // Normaliza los campos a validar (pueden venir como ['campo'], o ['campo' => valor])
        $normalizedFields = [];
        foreach ($fields as $key => $val) {
            if (is_numeric($key)) {
                // ['campo']
                $field = $val;
                if (isset($data->$field)) {
                    $normalizedFields[$field] = $data->$field;
                }
            } else {
                // ['campo' => valor]
                $normalizedFields[$key] = $val;
            }
        }
        
        // Validación de duplicados (permite múltiples campos)
        foreach ($normalizedFields as $field => $value) {
            $encontrado = $model->where($field, $value)->first();
        
            if ($encontrado && $encontrado['id'] != $id) {
                $response['response_message'] = [
                    'type' => 'warning',
                    'message' => "EL {$field_name} <strong>{$value}</strong> YA EXISTE."
                ];
                return json_encode($response);
            }
        }
        
        // Si hay función de preprocesamiento
        if (is_callable($preUpdateCallback)) {
            $data = $preUpdateCallback($data);
        }
        
        $data->id_usuario_empresa_edicion = session('id_usuario_empresa');
        
        if ($model->update($id, (array) $data)) {
            $response['next'] = true;
            $response['response_message'] = [
                'type' => 'success',
                'message' => "SE ACTUALIZÓ EL {$field_name} CON ID <strong>{$id}</strong> EXITOSAMENTE."
            ];

            // Ejecutamos post-callback si se definió
            if (is_callable($postSaveCallback)) {
                $postSaveCallback($id, $data);
            }
        
            // Renderizado de vista después del update
            if (!empty($view_path['load'])) {
                $view_data = [];
        
                if (isset($view_path['data']) && is_callable($view_path['data'])) {
                    $view_data = $view_path['data']();
                } else {
                    $view_data = $model->findAll();
                }
        
                $response['view'] = view($view_path['load'], ['data' => $view_data]);
            }
        } else {
            $response['response_message'] = [
                'type' => 'error',
                'message' => "HUBO UN PROBLEMA PARA ACTUALIZAR EL {$field_name}. VUELVA A INTENTARLO."
            ];
        }
        
        return json_encode($response);
    }
}

if (!function_exists('process_destroy')) {
    /**
     * Cambia el estado de un registro (status_alta) entre 1 y 0.
     *
     * @param array $params {
     *     @type object $data               Objeto con propiedad `data->id` (desde el frontend).
     *     @type object $model              Instancia del modelo.
     *     @type string $field_name         Nombre genérico del modelo para mensajes.
     *     @type string|array $view         Ruta de la vista (string) o ['load' => string, 'data' => array|callable].
     * }
     *
     * @return string JSON con resultado y csrf token.
     */
    function process_destroy(array $params): string {
        $requestData = $params['data'] ?? null;
        $model       = $params['model'] ?? null;
        $field_name  = strtoupper($params['field_name'] ?? 'REGISTRO');
        $view_path   = $params['view'] ?? '';

        $response = [
            'response_message' => ['type' => '', 'message' => "NO SE ENCONTRÓ EL IDENTIFICADOR PARA REALIZAR LA OPERACIÓN."],
            'next' => false,
            'csrf_token' => csrf_hash()
        ];

        $id = $requestData->data->id ?? null;

        if (empty($id) || !$model) {
            return json_encode($response);
        }

        $registro = $model->where('id', $id)->first();

        if (!$registro) {
            $response['response_message'] = [
                'type' => 'error',
                'message' => "NO SE ENCONTRÓ EL {$field_name} CON ID <strong>{$id}</strong>."
            ];
            return json_encode($response);
        }

        $nuevoEstado   = ($registro['status_alta'] ?? 1) == 1 ? 0 : 1;
        $mensajeEstado = $nuevoEstado == 1 ? 'ACTIVÓ' : 'DESACTIVÓ';

        if ($model->update($id, ['status_alta' => $nuevoEstado])) {
            $response['next'] = true;
            $response['response_message'] = [
                'type' => 'success',
                'message' => "SE <strong>{$mensajeEstado}</strong> EL {$field_name} CON ID <strong>{$id}</strong> EXITOSAMENTE."
            ];

            // Renderizar vista si se definió
            if (!empty($view_path)) {
                if (is_array($view_path) && isset($view_path['load'])) {
                    $view_data = [];

                    if (isset($view_path['data'])) {
                        $view_data = is_callable($view_path['data'])
                            ? ['data' => $view_path['data']()]
                            : (array) $view_path['data'];
                    } else {
                        $view_data = ['data' => $model->findAll()];
                    }

                    $response['view'] = view($view_path['load'], $view_data);
                } elseif (is_string($view_path)) {
                    $response['view'] = view($view_path, [
                        'data' => $model->findAll()
                    ]);
                }
            }
        } else {
            $response['response_message'] = [
                'type' => 'error',
                'message' => "NO SE PUDO ACTUALIZAR EL {$field_name} CON ID <strong>{$id}</strong>."
            ];
        }

        return json_encode($response);
    }
}