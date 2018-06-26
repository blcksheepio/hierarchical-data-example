<?php

namespace App\Tests\Functional\Controller;

use App\Tests\FunctionalTester;
use Codeception\Util\HttpCode;

class SwaggerUIControllerCest
{
    public function _before(FunctionalTester $I)
    {
        $I->wantToTest('That I can navigate to the API docs');
        $I->amGoingTo('Navigate to /api/documentation');
        $I->expectTo('See the API Swagger docs load up');
        $I->amOnPage('/api/documentation');
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTestHttpStatusCode(FunctionalTester $I)
    {
        $I->expectTo('see HTTP code 200');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
