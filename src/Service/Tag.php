<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\EntityRepository as EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validation;

class Tag extends Lib\ServiceManager
{
    /* @var EntityRepository\Tag */
    private $tagRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->tagRepository = $entityManager->getRepository('kommerce:Tag');
    }

    /* @return Entity\View\Tag */
    public function find($id)
    {
        /* @var Entity\Tag $entityTag */
        $entityTag = $this->tagRepository->find($id);

        if ($entityTag === null or ! $entityTag->getIsActive()) {
            return null;
        }

        return $entityTag->getView()
            ->export();
    }

    /**
     * @throws ValidatorException
     */
    public function edit($id, Entity\View\Tag $viewTag)
    {
        /* @var Entity\Tag $tag */
        $tag = $this->tagRepository->find($id);

        if ($tag === null) {
            throw new \LogicException('Missing Tag');
        }

        $tag->loadFromView($viewTag);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errors = $validator->validate($tag);

        if (count($errors) > 0) {
            $exception = new ValidatorException;
            $exception->errors = $errors;
            throw $exception;
        }

        $this->entityManager->flush();
    }

    /**
     * @return Entity\Tag
     * @throws ValidatorException
     */
    public function create(Entity\View\Tag $viewTag)
    {
        /* @var Entity\Tag $tag */
        $tag = new Entity\Tag;

        $tag->loadFromView($viewTag);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errors = $validator->validate($tag);

        if (count($errors) > 0) {
            $exception = new ValidatorException;
            $exception->errors = $errors;
            throw $exception;
        }

        $this->entityManager->persist($tag);
        $this->entityManager->flush();
    }

    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository
            ->getAllTags($queryString, $pagination);

        return $this->getViewTags($tags);
    }

    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository
            ->getTagsByIds($tagIds);

        return $this->getViewTags($tags);
    }

    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository
            ->getAllTagsByIds($tagIds);

        return $this->getViewTags($tags);
    }

    /**
     * @param Entity\Tag[] $tags
     * @return Entity\View\Tag[]
     */
    private function getViewTags($tags)
    {
        $viewTags = [];
        foreach ($tags as $tag) {
            $viewTags[] = $tag->getView()
                ->export();
        }

        return $viewTags;
    }
}
