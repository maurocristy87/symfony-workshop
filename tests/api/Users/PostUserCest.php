<?php

namespace Tests\Users;

use Tests\ApiTester;
use Codeception\Util\HttpCode;

class PostUserCest
{
    public function postUserSuccess(ApiTester $I): void
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost(
            'users',
            [
                'username' => 'anibal@w3itsolutions.org',
                'email' => 'anibal@w3itsolutions.org',
                'password' => '654321'
            ]
        );
        
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->canSeeResponseContainsJson([
            'username' => 'anibal@w3itsolutions.org',
            'email' => 'anibal@w3itsolutions.org',
        ]);
    }
    
    public function postUserWrongEmail(ApiTester $I): void
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost(
            'users',
            [
                'username' => 'anibal@w3itsolutions.org',
                'email' => 'anibalw3itsolutions.org',
                'password' => '654321'
            ]
        );
        
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->canSeeResponseMatchesJsonType([
            'message' => 'string',
            'errors' => [
                'email' => 'array'
            ]
        ]);
    }
    
    public function postUserDuplicated(ApiTester $I): void
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost(
            'users',
            [
                'username' => 'user1@workshop.com',
                'email' => 'user1@workshop.com',
                'password' => '654321'
            ]
        );
        
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->canSeeResponseMatchesJsonType(['message' => 'string']);
    }
}
