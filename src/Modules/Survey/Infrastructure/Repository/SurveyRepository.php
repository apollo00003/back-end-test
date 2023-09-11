<?php

declare(strict_types=1);

namespace App\Modules\Survey\Infrastructure\Repository;

use App\Modules\Survey\Domain\Entity\Survey;
use App\Modules\Survey\Domain\Repository\SurveyRepositoryInterface;
use App\Modules\Survey\Domain\ValueObject\SurveyId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Survey>
 *
 * @method Survey|null find($id, $lockMode = null, $lockVersion = null)
 * @method Survey|null findOneBy(array $criteria, array $orderBy = null)
 * @method Survey[]    findAll()
 * @method Survey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SurveyRepository extends ServiceEntityRepository implements SurveyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Survey::class);
    }

    public function save(Survey $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(Survey $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @return Survey[]
     */
    public function getAllSurveys(): array
    {
        return $this->findAll();
    }

    public function findById(SurveyId $surveyId): ?Survey
    {
        return $this->findOneBy(['id' => $surveyId->getValue()]);
    }
}
