<?php

namespace App\Libraries;

use Config\Email;
use CodeIgniter\Email\Email as CI_Email;

class EmailService
{
    protected $email;

    public function __construct(){
        $config = new Email(); // Cargar configuración
        $this->email = new CI_Email($config);
    }

    public function sendEmail(array $data): bool{
        // EJEMPLO DE USO DE LA FUNCION
        // $data = [
        //     'to'         => 'janto_sega5@hotmail.com',
        //     'subject'    => 'Bienvenido a nuestro sistema',
        //     'body'       => '<h1>Gracias por registrarte</h1><p>Estamos felices de tenerte.</p>',
        //     'attachments'=> [WRITEPATH . 'uploads/manual.pdf'],
        //     'cc'         => 'admin@example.com',
        //     'bcc'        => 'auditoria@example.com',
        //     'reply_to'   => 'soporte@example.com',
        // ];

        // ✅ Permitir múltiples destinatarios
        if (isset($data['to'])) {
            if (is_array($data['to'])) {
                $this->email->setTo(implode(',', $data['to']));
            } else {
                $this->email->setTo($data['to']);
            }
        }
        // ✅ Asignar encabezados opcionales
        if (!empty($data['cc'])) {
            $this->email->setCC($data['cc']);
        }
        if (!empty($data['bcc'])) {
            $this->email->setBCC($data['bcc']);
        }
        if (!empty($data['reply_to'])) {
            $this->email->setReplyTo($data['reply_to']);
        }
    
        // ✅ Configurar cuerpo y asunto
        $this->email->setFrom($this->email->fromEmail, $this->email->fromName);
        // $this->email->setFrom('no-reply@molonco.com', 'CORPORATIVO GAOLA');
        $this->email->setSubject($data['subject'] ?? 'Sin Asunto');
        $this->email->setMessage($data['body'] ?? '');
    
        // ✅ Adjuntar archivos
        if (!empty($data['attachments'])) {
            foreach ($data['attachments'] as $file) {
                if (@is_readable($file)) {
                    $this->email->attach($file);
                } else {
                    log_message('error', "Archivo adjunto inválido o no accesible: {$file}");
                }
            }
        }
    
        // ✅ Enviar correo y registrar logs
        // ✅ Usar concatenación en lugar de llaves
        $toString = is_array($data['to']) ? implode(', ', $data['to']) : $data['to'];
        if (!$this->email->send()) {
            log_message('error', "[EMAIL ERROR] {$toString} | " . $this->email->printDebugger(['headers']));
            return false;
        }
    
        log_message('info', "[EMAIL SENT] {$toString} | {$data['subject']} | " . date('Y-m-d H:i:s'));
        return true;
    }

}