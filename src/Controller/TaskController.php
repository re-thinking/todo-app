<?php

namespace App\Controller;

use App\Messages\CompletedTaskMessage;
use App\Messages\DeletedTaskMessage;
use App\Messages\EditedTaskMessage;
use App\Messages\NewTaskMessage;
use App\Messages\ReopenedTaskMessage;
use App\Todo\Application\Task\CompleteTask;
use App\Todo\Application\Task\CreateTask;
use App\Todo\Application\Task\DeleteTask;
use App\Todo\Application\Task\EditTask;
use App\Todo\Application\Task\ListTasks;
use App\Todo\Application\Task\RedoTask;
use App\Todo\Application\Task\ShowTask;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package App\Controller
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    private MessageBusInterface $bus;

    /**
     * TaskController constructor.
     * @param  MessageBusInterface  $bus
     */
    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @Route(name="task.list", methods={"GET"})
     * @param  ListTasks  $listTasks
     * @return JsonResponse
     */
    public function list(ListTasks $listTasks)
    {
        return new JsonResponse($listTasks->handle());
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

        $task = $createTask->handle($data['name'],
            isset($data['due_date']) ? new \DateTimeImmutable($data['due_date']) : null);

        $this->bus->dispatch(new NewTaskMessage($task->getId()));

        return new JsonResponse(
            $task,
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
        $task = $completeTask->handle($id);

        $this->bus->dispatch(new CompletedTaskMessage($task->getId()));

        return new JsonResponse(
            $task,
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
        $task = $redoTask->handle($id);

        $this->bus->dispatch(new ReopenedTaskMessage($task->getId()));

        return new JsonResponse(
            $task,
            JsonResponse::HTTP_ACCEPTED
        );
    }

    /**
     * @Route(name="task.edit", path="/{id}", methods={"PUT"})
     * @param  int  $id
     * @param  Request  $request
     * @param  EditTask  $editTask
     * @return JsonResponse
     * @throws \Exception
     */
    public function edit(int $id, Request $request, EditTask $editTask)
    {
        $data = json_decode($request->getContent(), true);
        $task = $editTask->handle($id, $data['name'],
            isset($data['due_date']) ? new \DateTimeImmutable($data['due_date']) : null);

        $this->bus->dispatch(new EditedTaskMessage($task->getId()));

        return new JsonResponse(
            $task,
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

        $this->bus->dispatch(new DeletedTaskMessage($id));

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}