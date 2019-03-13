<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\NodeData;
use Eidosmedia\Cobalt\Site\Entities\PaginatedSearchResult;
use PHPUnit\Framework\TestCase;

class PaginatedSearchResultTest extends TestCase {

    public function testMenuObject() {
		$result = [new NodeData(), new NodeData()];
		$archives = [
			[
				'year' => 2019,
				'month' => 2,
				'day' => 4,
				'name' => 'archive 1',
				'uri' => 'http://an-archive.com'
			]
		];
		$tags = [
			'tag 1' => [
				[
					'name' => 'sport',
					'count' => 1
				],
				[
					'name' => 'politics',
					'count' => 12
				]
			]
		];
		$tookMs = 32342;
		$paginatedSearch = new PaginatedSearchResult($result, $archives, $tags, $tookMs, 0, 20);
		self::assertEquals($result, $paginatedSearch->getResult());
		self::assertEquals(count($result), $paginatedSearch->getCount());
		self::assertEquals($archives, $paginatedSearch->getArchives());
		self::assertEquals($tags, $paginatedSearch->getTags());
		self::assertEquals($tookMs, $paginatedSearch->getTookMs());
    }

}
