<?php

namespace App\Libraries;

use Config\Email;
use CodeIgniter\Email\Email as CI_Email;

class EmailService
{
    protected $email;

    public function __construct()
    {
        $config = new Email(); // Cargar configuración
        $this->email = new CI_Email($config);
    }

    public function sendEmail($to, $subject, $message, $attachments = []){
        if (is_array($to)) {
            $this->email->setTo(implode(',', $to)); // Convierte array a lista separada por comas
        } else {
            $this->email->setTo($to);
        }

        $this->email->setFrom($this->email->fromEmail, $this->email->fromName);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);

        // Adjuntar archivos si existen
        if (!empty($attachments)) {
            foreach ($attachments as $file) {
                if (file_exists($file)) {
                    $this->email->attach($file);
                } else {
                    log_message('error', "El archivo adjunto no existe: {$file}");
                }
            }
        }
        if (!$this->email->send()) {
            log_message('error', "Error al enviar correo: " . $this->email->printDebugger(['headers']));
            return false;
        }
        
        return true;
    }

}
