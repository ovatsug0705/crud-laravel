<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\UsuarioRepositoryInterface;
use Illuminate\Validation\ValidationException;

class UsuariosController extends Controller
{
    /**
     * Usuario Repository instance
     * 
     * @var App\Interfaces\UsuarioRepositoryInterface
     */
    private $usuarioRepository;

    /**
     * Task Repository instance
     * 
     * @var App\Interfaces\TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsuarioRepositoryInterface $userRepository, TaskRepositoryInterface $taskRepository)
    {
        $this->usuarioRepository = $userRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * Show Users list
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuarios = $this->usuarioRepository->all();
        return view('usuarios.list', ['usuarios' => $usuarios]);
    }

    /**
     * Show Users list
     *
     * @param int $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detalhes($id)
    {
        $usuario = $this->usuarioRepository->getById($id);
        $tasks = $this->taskRepository->getByUser($id);

        return view('usuarios.show', compact('usuario', 'tasks'));
    }

    /**
     * Show new user form
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function novo()
    {
        return view('usuarios.novo', ['usuario' => null]);
    }

    /**
     * Show edit user page
     * 
     * @param string $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editar($id)
    {
        $usuario = $this->usuarioRepository->getById($id);
        return view('usuarios.novo', ['usuario' => $usuario]);
    }

    /**
     * Show new user page
     *
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Response|Illuminate\Contracts\Support\Renderable
     */
    public function add(Request $request)
    {
        try {
            $this->validateRequest($request);
            
            $data = $this->getRequestData($request);

            $user = $this->usuarioRepository->getByEmail($request->get('email'));
    
            if ($user == null) {
                $user = $this->usuarioRepository->add($data);
            } else {
                $message_bag = new MessageBag();
                $message_bag->add('email', 'E-mail já cadastrado!');

                return back()
                    ->withErrors($message_bag)
                    ->withInput();
            }
        } catch (ValidationException $e) {
            $messages = $e->errors();
            return back()
                ->withErrors($messages)
                ->withInput();
        }

        return redirect()
            ->route('usuarios.home')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Show new user page
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return Illuminate\Http\Response|Illuminate\Contracts\Support\Renderable
     */
    public function update($id, Request $request)
    {   
        try {
            $this->validateRequest($request);
            
            $data = $this->getRequestData($request);

            $user = $this->usuarioRepository->getByEmail($request->get('email'));
    
            if ($user == null || $user["id"] == $id) {
                $user = $this->usuarioRepository->update($id, $data);
            } else {
                $message_bag = new MessageBag();
                $message_bag->add('email', 'E-mail já cadastrado!');

                return back()
                    ->withErrors($message_bag)
                    ->withInput();
            }
        } catch (ValidationException $e) {
            $messages = $e->errors();
            return back()
                ->withErrors($messages)
                ->withInput();
        }

        return redirect()
            ->route('usuarios.home')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Delete user
     * 
     * @param int $id
     * @return string
     */
    public function delete($id)
    {
        try {
            $tasks = $this->taskRepository->getByUser($id);

            foreach ($tasks as $task) {
                $this->taskRepository->delete($task["id"]);
            }

            $this->usuarioRepository->delete($id);
        } catch (Exception $e) {
            return back()
                ->with('error', 'Não foi possível deletar esse item, tente novamente');
        }

        return redirect()
            ->route('usuarios.home')
            ->with('success', 'Usuário deletado com sucesso!');
    }

    /**
     * Validate request data
     * 
     * @param Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|min:3',
            'email' => 'required|string|email',
        ],[
            'name.required' => 'O campo nome é obrigatório.',
            'name.min' => 'O nome deve ter no mínimo 3 letras.',
            'email.required' => 'O campo e-mail é obrigatório',
            'email.email' => 'Insira um e-mail válido'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get request data
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private function getRequestData(Request $request)
    {
        return [
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ];
    }
}
