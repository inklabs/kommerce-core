<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagQuery;
use inklabs\kommerce\ActionResponse\Tag\GetTagResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetTagHandler implements QueryHandlerInterface
{
    /** @var GetTagQuery */
    private $query;

    /** @var Pricing */
    private $pricing;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetTagQuery $query,
        Pricing $pricing,
        TagRepositoryInterface $tagRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->pricing = $pricing;
        $this->tagRepository = $tagRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $response = new GetTagResponse($this->pricing);

        $tag = $this->tagRepository->findOneById(
            $this->query->getTagId()
        );

        $response->setTagDTOBuilder(
            $this->dtoBuilderFactory->getTagDTOBuilder($tag)
        );

        return $response;
    }
}
