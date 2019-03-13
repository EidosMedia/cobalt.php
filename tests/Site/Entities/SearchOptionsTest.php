<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\SearchOptions;
use PHPUnit\Framework\TestCase;

class SearchOptionsTest extends TestCase {

    public function testSearchOptionsObject() {
		$query = '';
		$tagsFamilies = [];
		$kinds = ['', ''];
		$baseType = '';
		$baseTypes = ['', ''];
		$type = '';
		$startDate = '20/03/2019';
		$endDate = '20/03/2019';
		$limit = 20;
		$offset = 0;
		$sorting = 'ascending';
		$section = '/sports';
		$aggregator = [''];
		$searchOptions = new SearchOptions();
		self::assertNull($searchOptions->getQuery());
		$searchOptions->setQuery($query);
		self::assertEquals($query, $searchOptions->getQuery());
		self::assertNull($searchOptions->getTagsFamilies());
		$searchOptions->setTagsFamilies($tagsFamilies);
		self::assertEquals($tagsFamilies, $searchOptions->getTagsFamilies());
		self::assertNull($searchOptions->getKinds());
		$searchOptions->setKinds($kinds);
		self::assertEquals($kinds, $searchOptions->getKinds());
		self::assertNull($searchOptions->getBaseType());
		$searchOptions->setBaseType($baseType);
		self::assertEquals($baseType, $searchOptions->getBaseType());
		self::assertNull($searchOptions->getType());
		$searchOptions->setType($type);
		self::assertEquals($type, $searchOptions->getType());
		self::assertNull($searchOptions->getBaseTypes());
		$searchOptions->setBaseTypes($baseTypes);
		self::assertEquals($baseTypes, $searchOptions->getBaseTypes());
		self::assertNull($searchOptions->getStartDate());
		$searchOptions->setStartDate($startDate);
		self::assertEquals($startDate, $searchOptions->getStartDate());
		self::assertNull($searchOptions->getEndDate());
		$searchOptions->setEndDate($endDate);
		self::assertEquals($endDate, $searchOptions->getEndDate());
		self::assertNull($searchOptions->getLimit());
		$searchOptions->setLimit($limit);
		self::assertEquals($limit, $searchOptions->getLimit());
		self::assertNull($searchOptions->getOffset());
		$searchOptions->setOffset($offset);
		self::assertEquals($offset, $searchOptions->getOffset());
		self::assertNull($searchOptions->getSorting());
		$searchOptions->setSorting($sorting);
		self::assertEquals($sorting, $searchOptions->getSorting());
		self::assertNull($searchOptions->getSection());
		$searchOptions->setSection($section);
		self::assertEquals($section, $searchOptions->getSection());
		self::assertNull($searchOptions->getAggregator());
		$searchOptions->setAggregator($aggregator);
		self::assertEquals($aggregator, $searchOptions->getAggregator());
    }

}
