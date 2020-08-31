<?php

namespace App\Controller;

use App\Todo\Application\Task\CompleteTask;
use App\Todo\Application\Task\CreateTask;
use App\Todo\Application\Task\DeleteTask;
use App\Todo\Application\Task\RedoTask;
use App\Todo\Application\Task\ShowTask;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package App\Controller
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route(name="task.list", methods={"GET"})
     */
    public function list()
    {
        return new JsonResponse(['text' => 'Hello111']);
    }

    /**
     * @Route(name="task.create", methods={"POST"})
     * @param  Request  $request
     * @param  CreateTask  $createTask
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(Request $request, CreateTask $createTask)
    {
        $data = json_decode($request->getContent(), true);
        return new JsonResponse(
            $createTask->handle($data['name'], isset($data['due_date']) ? new \DateTimeImmutable($data['due_date']) : null),
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route(name="task.show", methods={"GET"})
     * @param  int  $id
     * @param  ShowTask  $showTask
     * @return JsonResponse
     */
    public function show(int $id, ShowTask $showTask)
    {
        return new JsonResponse(
            $showTask->handle($id),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route(name="task.complete", path="/{id}/complete", methods={"PUT"})
     * @param  int  $id
     * @param  CompleteTask  $completeTask
     * @return JsonResponse
     */
    public function complete(int $id, CompleteTask $completeTask)
    {
        return new JsonResponse(
            $completeTask->handle($id),
            JsonResponse::HTTP_ACCEPTED
        );
    }

    /**
     * @Route(name="task.redo", path="/{id}/complete", methods={"DELETE"})
     * @param  int  $id
     * @param  RedoTask  $redoTask
     * @return JsonResponse
     */
    public function redo(int $id, RedoTask $redoTask)
    {
        return new JsonResponse(
            $redoTask->handle($id),
            JsonResponse::HTTP_ACCEPTED
        );
    }

    /**
     * @Route(name="task.delete", path="/{id}", methods={"DELETE"})
     * @param  int  $id
     * @param  DeleteTask  $deleteTask
     * @return JsonResponse
     */
    public function delete(int $id, DeleteTask $deleteTask)
    {
        $deleteTask->handle($id);

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}