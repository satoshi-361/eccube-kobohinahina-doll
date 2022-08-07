<?php

namespace Plugin\ProductDisplayRank4\Repository;

use Eccube\Doctrine\Query\OrderByClause;
use Eccube\Doctrine\Query\OrderByCustomizer;
use Eccube\Doctrine\Query\WhereClause;
use Eccube\Repository\QueryKey;
use Plugin\ProductDisplayRank4\Entity\Config;

class ProductDisplayCustomizer extends OrderByCustomizer
{
    /**
     * @var ConfigRepository
     */
    private $configRepository;

    public function __construct(
        ConfigRepository $configRepository
    ) {
        $this->configRepository = $configRepository;
    }

    /**
     * @param array $params
     * @param $queryKey
     *
     * @return OrderByClause[]
     */
    protected function createStatements($params, $queryKey)
    {
        $ProductListOrderBy = $params['orderby'];

        if ($ProductListOrderBy) {
            $Config = $this->configRepository->findOneBy([
                'product_list_order_by_id' => $ProductListOrderBy->getId(),
            ]);

            if ($Config) {
                if ($Config->getType() == Config::ORDER_BY_DESCENDING) {
                    return [new OrderByClause('p.display_rank', 'desc')];
                } elseif ($Config->getType() == Config::ORDER_BY_ASCENDING) {
                    return [new OrderByClause('p.display_rank', 'asc')];
                }
            }
        }

        return [];
    }

    /**
     * カスタマイズ対象のキーを返します。
     *
     * @return string
     */
    public function getQueryKey()
    {
        return QueryKey::PRODUCT_SEARCH;
    }
}
