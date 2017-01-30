<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagsByIdsQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetTagsByIdsHandler implements QueryHandlerInterface
{
    /** @var GetTagsByIdsQuery */
    private $query;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetTagsByIdsQuery $query,
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
        $tags = $this->tagRepository->getTagsByIds(
            $this->query->getRequest()->getTagIds()
        );

        foreach ($tags as $tag) {
            $this->query->getResponse()->addTagDTOBuilder(
                $this->dtoBuilderFactory->getTagDTOBuilder($tag)
            );
        }
    }
}
