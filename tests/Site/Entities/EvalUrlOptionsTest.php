<?php

namespace Eidosmedia\Tests\Cobalt\Site\Entities;

use Eidosmedia\Cobalt\Site\Entities\EvalUrlOptions;
use PHPUnit\Framework\TestCase;

class EvalUrlOptionsTest extends TestCase {

    public function testEvalUrlOptionsObject() {
		$viewStatus = 'LIVE';
		$format = 'raw';
		$urlIntent = 'HOST_RELATIVE';
		$resolutionType = 'CONTENT';
		$view = 'amp';
		$page = 1;
		$evalUrlOptions = new EvalUrlOptions();
		self::assertNull($evalUrlOptions->getViewStatus());
		$evalUrlOptions->setViewStatus($viewStatus);
		self::assertEquals($viewStatus, $evalUrlOptions->getViewStatus());
		self::assertNull($evalUrlOptions->getFormat());
		$evalUrlOptions->setFormat($format);
		self::assertEquals($format, $evalUrlOptions->getFormat());
		self::assertNull($evalUrlOptions->getUrlIntent());
		$evalUrlOptions->setUrlIntent($urlIntent);
		self::assertEquals($urlIntent, $evalUrlOptions->getUrlIntent());
		self::assertNull($evalUrlOptions->getResolutionType());
		$evalUrlOptions->setResolutionType($resolutionType);
		self::assertEquals($resolutionType, $evalUrlOptions->getResolutionType());
		self::assertNull($evalUrlOptions->getView());
		$evalUrlOptions->setView($view);
		self::assertEquals($view, $evalUrlOptions->getView());
		self::assertNull($evalUrlOptions->getPage());
		$evalUrlOptions->setPage($page);
		self::assertEquals($page, $evalUrlOptions->getPage());
    }

}
