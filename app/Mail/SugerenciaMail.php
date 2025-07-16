<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SugerenciaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $usuario;

    public function __construct($usuario, $mensaje)
    {
        $this->usuario = $usuario;
        $this->mensaje = $mensaje;
    }

    public function build()
{
    return $this->from($this->usuario->email, $this->usuario->name)  // <-- aquí usas el correo del usuario
                ->subject('Nueva sugerencia de usuario')
                ->view('emails.sugerencia');
}

}
