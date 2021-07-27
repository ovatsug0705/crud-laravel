<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\UsuarioRepositoryInterface;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{

    /**
     * Task Repository instance
     * 
     * @var App\Interfaces\TaskRepositoryInterface
     */
    private $taskRepository;

    /**
     * Usuario Repository instance
     * 
     * @var App\Interfaces\UsuarioRepositoryInterface
     */
    private $usuarioRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepositoryInterface $taskRepository, UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = new JsonResponse;

        try {
            $tasks = $this->taskRepository->all();
        } catch (Exception $e) {
            $response->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Internal server error';

            return response($response, $response->statusCode);
        }

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = new JsonResponse;

        try {
            $this->validateRequest($request);

            $data = $this->getRequestData($request);

            $user = $this->usuarioRepository->getById($data['user_id']);

            if (!empty($user)) {
                $task = $this->taskRepository->add($data);
            } else {
                $response->statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $response->message = 'Usuário não existente.';

                return response($response, $response->statusCode);
            }
        } catch (ValidationException $e) {
            $user = null;
            $response->statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $response->message = 'Unprocessable entity';
            $response->errors = $e->errors();

            return response($response, $response->statusCode);
        } catch (Exception $e) {
            $user = null;
            $response->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Internal server error';

            return response($response, $response->statusCode);
        }

        $response->statusCode = Response::HTTP_CREATED;
        return response()->json($task, $response->statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = new JsonResponse;

        try {
            $task = $this->taskRepository->getById($id);

            dd($task);
        } catch (Exception $e) {
            $user = null;
            $response->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Internal server error';

            return response($response, $response->statusCode);
        }

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $response = new JsonResponse;
        
        try {
            $this->validateRequest($request);
            
            $data = $this->getRequestData($request);

            $user = $this->usuarioRepository->getById($data['user_id']);

            if (!empty($user)) {
                $task = $this->taskRepository->update($id, $data);
            } else {
                $response->statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $response->message = 'Usuário não existente.';

                return response($response, $response->statusCode);
            }
        } catch (ValidationException $e) {
            $task = null;
            $response->statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
            $response->message = 'Unprocessable entity';
            $response->errors = $e->errors();

            return response($response, $response->statusCode);
        } catch (Exception $e) {
            $task = null;
            $response->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response->message = 'Internal server error';

            return response($response, $response->statusCode);
        }

        $response->statusCode = Response::HTTP_CREATED;
        return response()->json($task, $response->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = new JsonResponse;

        try {
            $this->taskRepository->delete($id);
        } catch (Exception $e) {
            $response->statusCode = Response::HTTP_NOT_ACCEPTABLE;
            $response->message = 'Não é possível deletar esse item.';

            return response($response, $response->statusCode);
        }

        return response($response, $response->statusCode);
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
            'title'  => 'required|string|min:3',
            'description' => 'required|string|min:10',
            'finished' => 'required|boolean',
            'user_id' => 'required|numeric',
        ],[
            'title.required' => 'O campo título é obrigatório.',
            'title.min' => 'O título deve ter no mínimo 3 letras.',
            'description.required' => 'O campo descrição é obrigatório.',
            'description.min' => 'O campo descrição deve ter no mínimo 10 caractéres.',
            'finished' => 'O campo status é obrigatório',
            'user_id.required' => 'O campo ID de usuário é obrigatório.',
            'user_id.numeric' => 'O campo ID de usuário deve ser numérico',
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
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'finished' => $request->get('finished'),
            'user_id' => $request->get('user_id'),
        ];
    }
}