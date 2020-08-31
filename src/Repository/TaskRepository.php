<?php

namespace App\Repository;

use App\Todo\Domain\Repository\RepositoryInterface;
use App\Todo\Domain\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class TaskRepository
 * @package App\Repository
 * @method Task find($id, $lockMode = null, $lockVersion = null)
 */
class TaskRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @param  int  $id
     * @return Task
     * @throws \Exception
     */
    public function findOne(int $id): Task
    {
        $task = $this->find($id);

        if ($task === null) {
            throw new \Exception("Cannot find task with id $id");
        }

        return $task;
    }

    /**
     * @param  Task  $task
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Task $task): void
    {
        try {
            $this->getEntityManager()->persist($task);
            $this->getEntityManager()->flush();
        } catch (ORMInvalidArgumentException|OptimisticLockException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function findCompleted(): array
    {
        $query = $this->getEntityManager()
            ->createQuery(<<<DQL
                SELECT c FROM App\Todo\Domain\Completed c 
            DQL);
        return $query->getArrayResult();
    }

    public function findOpened(): array
    {
        $query = $this->getEntityManager()
            ->createQuery(<<<DQL
                SELECT c FROM App\Todo\Domain\Opened c 
            DQL);
        return $query->getArrayResult();
    }

    public function destroy(int $id): void
    {
        $query = $this->getEntityManager()
            ->createQuery(<<<DQL
                DELETE FROM App\Todo\Domain\Task t WHERE t.id = :id
        DQL);
        $query->setParameter(':id', $id);
        $query->execute();
    }
}