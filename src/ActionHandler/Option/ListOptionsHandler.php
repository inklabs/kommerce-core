<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Option\ListOptionsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\OptionServiceInterface;

final class ListOptionsHandler
{
    /** @var OptionServiceInterface */
    private $tagService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(OptionServiceInterface $tagService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->tagService = $tagService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(ListOptionsQuery $query)
    {
        $paginationDTO = $query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $tags = $this->tagService->getAllOptions(
            $query->getRequest()->getQueryString(),
            $pagination
        );

        $query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($tags as $tag) {
            $query->getResponse()->addOptionDTOBuilder(
                $this->dtoBuilderFactory->getOptionDTOBuilder($tag)
            );
        }
    }
}
