<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Usuario implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    /**
     * Usuario Repository instance
     * 
     * @var array
     */
    private $usuario;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.userCreated', $this->usuario,
            function($message) {
                $message->to('to.email@email.com', 'Aplicação laravel CRUD')
                        ->subject('Usuário criado!');
            }
        );
    }
}
