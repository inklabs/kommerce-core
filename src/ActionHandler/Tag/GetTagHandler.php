<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetTagHandler implements QueryHandlerInterface
{
    /** @var GetTagQuery */
    private $query;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetTagQuery $query,
        TagRepositoryInterface $tagRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->tagRepository = $tagRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $tag = $this->tagRepository->findOneById(
            $this->query->getRequest()->getTagId()
        );

        $this->query->getResponse()->setTagDTOBuilder(
            $this->dtoBuilderFactory->getTagDTOBuilder($tag)
        );
    }
}
