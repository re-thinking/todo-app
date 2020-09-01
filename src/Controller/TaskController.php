<?php

namespace App\Controller;

use App\Messages\CompletedTaskMessage;
use App\Messages\DeletedTaskMessage;
use App\Messages\EditedTaskMessage;
use App\Messages\NewTaskMessage;
use App\Messages\ReopenedTaskMessage;
use App\Todo\Application\Task\Command;
use App\Todo\Application\Task\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

    private Command $command;

    /**
     * TaskController constructor.
     * @param  Command  $command
     * @param  MessageBusInterface  $bus
     */
    public function __construct(Command $command, MessageBusInterface $bus)
    {
        $this->bus = $bus;
        $this->command = $command;
    }

    /**
     * @Route(name="task.list", methods={"GET"})
     * @param  Query  $query
     * @return JsonResponse
     */
    public function list(Query $query)
    {
        return new JsonResponse($query->listTasks());
    }

    /**
     * @Route(name="task.create", methods={"POST"})
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('Json is not well formed');
        }

        if (!isset($data['name'])) {
            throw new BadRequestHttpException('Name is required field');
        }

        $name = $data['name'];
        $dueDate = null;

        if (isset($data['due_date'])) {
            $dueDate = \DateTime::createFromFormat('Y-m-d', $data['due_date']);
            if (!$dueDate) {
                throw new BadRequestHttpException('Due date is not well formed');
            }
        }

        $task = $this->command->createTask($name, $dueDate);

        $this->bus->dispatch(new NewTaskMessage($task->getId()));

        return new JsonResponse(
            $task,
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route(name="task.show", path="/{id}", methods={"GET"})
     * @param  int  $id
     * @param  Query  $query
     * @return JsonResponse
     */
    public function show(int $id, Query $query)
    {
        return new JsonResponse(
            $query->showTask($id),
            JsonResponse::HTTP_OK
        );
    }

    /**
     * @Route(name="task.complete", path="/{id}/completed", methods={"PUT"})
     * @param  int  $id
     * @return JsonResponse
     */
    public function complete(int $id)
    {
        $task = $this->command->completeTask($id);

        $this->bus->dispatch(new CompletedTaskMessage($task->getId()));

        return new JsonResponse(
            $task,
            JsonResponse::HTTP_ACCEPTED
        );
    }

    /**
     * @Route(name="task.open", path="/{id}/completed", methods={"DELETE"})
     * @param  int  $id
     * @return JsonResponse
     */
    public function open(int $id)
    {
        $task = $this->command->openTask($id);

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
     * @return JsonResponse
     */
    public function edit(int $id, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('Json is not well formed');
        }

        if (!isset($data['name'])) {
            throw new BadRequestHttpException('Name is required field');
        }

        $name = $data['name'];
        $dueDate = null;

        if (isset($data['due_date'])) {
            $dueDate = \DateTime::createFromFormat('Y-m-d', $data['due_date']);
            if (!$dueDate) {
                throw new BadRequestHttpException('Due date is not well formed');
            }
        }

        $task = $this->command->editTask($id, $name, $dueDate);

        $this->bus->dispatch(new EditedTaskMessage($task->getId()));

        return new JsonResponse(
            $task,
            JsonResponse::HTTP_ACCEPTED
        );
    }

    /**
     * @Route(name="task.delete", path="/{id}", methods={"DELETE"})
     * @param  int  $id
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        $this->command->deleteTask($id);

        $this->bus->dispatch(new DeletedTaskMessage($id));

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT
        );
    }
}