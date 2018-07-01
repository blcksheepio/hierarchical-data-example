<?php

namespace App\Tests\Functional\Command;

use App\Tests\FunctionalTester;

/**
 * Class AppNeo4jTruncateCommandCest
 *
 * @author blcksheep
 */
class AppNeo4jTruncateCommandCest
{
    /**
     * @param FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
    }

    /**
     * @param FunctionalTester $I
     */
    public function _after(FunctionalTester $I)
    {
    }

    /**
     * @param FunctionalTester $I
     * @group cli
     */
    public function tryToTestCommandNameIsCorrectlyDefined(FunctionalTester $I)
    {
        $I->wantToTest('that executing bin/console lists the app:neo4j:truncate command');
        $I->runShellCommand('bin/console');
        $I->expectTo('see "app:neo4j:truncate"');
        $I->seeShellOutputMatches("/app:neo4j:truncate/");
    }

    /**
     * @param FunctionalTester $I
     * @group cli
     */
    public function tryToTestCommandExecutesCorrectly(FunctionalTester $I)
    {
        $I->wantToTest('that executing the "app:neo4j:truncate" command runs as expected');
        $I->runShellCommand('bin/console app:neo4j:truncate');
        $I->seeInShellOutput('Neo4J database successfully truncated!');
    }
}
