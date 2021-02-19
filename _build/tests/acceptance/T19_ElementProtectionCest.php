<?php
use Codeception\Util\Fixtures;
use Page\Acceptance\LoginPage;
use Page\Acceptance\LoginPagemodx3;
use Page\Acceptance\ElementTestPage;
use Page\Acceptance\ElementTestPagemodx3;

class T19_ElementProtectionCest
 {

    /** @var _generated\modX $modx */
    public $modx;

    private const ROLES = array('TestUser');
    private const USER_GROUPS = array('PublicUsers',
        'PrivateUsers');
    private const CATEGORIES =
        array('PublicElements', 'PrivateElements');

    public static function _before(\Step\Acceptance\Objects $I) {

        /* Load data files */
        $users = include codecept_data_dir() .
            '/user_data.php';

        $elements = include codecept_data_dir() .
            '/element_data.php';


        $modx = Fixtures::get('modx');
        assertTrue($modx instanceof modX);
        $I->createRoles($modx, self::ROLES);
        $I->createUserGroups($modx, self::USER_GROUPS);
        $I->createUsers($modx, $users);
        $I->createCategories($modx, self::CATEGORIES);
        $I->wait(1);
        $I->createElements($modx, $elements);
    }

    public static function _after(\Step\Acceptance\Objects $I) {
        // return;  /* allows examination of objects and ACL */

        $users = include codecept_data_dir() .
            '/user_data.php';
        $elements = include codecept_data_dir() .
            '/element_data.php';
        $modx = Fixtures::get('modx');
        assertTrue($modx instanceof modX);
        $I->removeRoles($modx, self::ROLES);
        $I->removeUserGroups($modx, self::USER_GROUPS);
        $I->removeUsers($modx, $users);
        $I->removeElements($modx, $elements);
        $I->removeCategories($modx, self::CATEGORIES);

    }

    /** @example ["Template"]
        @example ["TV"]
        @example ["Chunk"]
        @example ["Snippet"]
        @example ["Plugin"]
     *
     * @throws Exception
     */
    public function ElementProtectionTest(AcceptanceTester $I, \Codeception\Scenario $scenario, \Codeception\Example $example)
    {
        $env = $scenario->current('env');

        if (strpos($env,'modx3') !== false) {
            $testPage = new ElementTestPagemodx3($I);
        } else {
            $testPage = new ElementTestPage($I);
        }

        $wait = 2;

        /* Login admin user JoeTester2 */
        if (strpos($env, 'modx3') !== false) {
            $loginPage = new LoginPagemodx3($I);
        } else {
            $loginPage = new LoginPage($I);
        }
        $loginPage->login('JoeTester2', 'TesterPassword');

        $I->see('Content');
        $I->see('Manage');
        $I->click($testPage::$elementsTab);
        $I->wait(1);
        $this->_closeAll($I, $testPage);
        $I->wait($wait);

        /* *** Create ACL entry *** */

        /* Go to ACL panel */
        $I->wait($wait + 1);
        $I->moveMouseOver($testPage::$systemMenu);
        $I->click($testPage::$systemMenu);
        $I->wait(1);
        $I->moveMouseOver($testPage::$acl_option);

        $I->click($testPage::$acl_option);
        $I->wait($wait);

        /* Update PrivateUser user group */
        $I->clickWithRightButton($testPage::$privateUsersGroup);
        $I->wait($wait+2);

        $I->click($testPage::$updateUserGroupOption);
        $I->wait($wait);

        /* Select Permissions top tab */
        $I->click($testPage::$permissionsTab);
        $I->wait($wait);

        /* Select Element Category Access left tab */
        $I->click($testPage::$elementCategoryAccessTab);

        $I->wait($wait);

        /* Create actual ACL entry */
        $I->waitForElementClickable($testPage::$addCategoryButton);
        $I->click($testPage::$addCategoryButton);

        $I->wait($wait);

        /* Set Category */
        $I->click($testPage::$categoryInput);
        $I->wait($wait);

        $I->click($testPage::$privateElementsOption);

        /* Set Context */
        $I->click($testPage::$contextInput);
        $I->wait($wait);

        $I->click($testPage::$mgrOption);

        /* Set Role */
        $I->click($testPage::$authorityInput);

        $I->wait($wait+2);

        $I->click($testPage::$testUserOption);

        /* Set Policy */
        $I->click($testPage::$policyInput);
        $I->wait($wait);

        $I->click($testPage::$elementOption);

        $I->wait($wait);

        /* Save ACL entry */
        $I->click($testPage::$addElementPanelSaveButton);
        $I->wait($wait);

        $I->wait($wait);

        $this->_openCurrent($I, $testPage, $example[0]);

        $I->wait($wait);


        /* Make sure JoeTester2 can see Public object
           and can't see Private Object */
        $I->see("Public" . $example[0]);
        $I->dontSee("Private" . $example[0]);

        /* Logout JoeTester2 */
        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');

        /* Login PrivateUser */
        $I->wait($wait);
        $loginPage->login('PrivateUser', 'somepassword');
        $I->see('Content');
        $I->see('Manage');
        $I->wait($wait);
        $this->_openCurrent($I, $testPage, $example[0]);

        /* Make sure Private Object is visible */
        $I->wait($wait);
        $I->see("Private" . $example[0]);
        $I->see("Public" . $example[0]);

        /* Logout PrivateUser */
        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');

        /* Login PublicUser */
        $I->wait($wait);
        $loginPage->login('PublicUser', 'somepassword');
        $I->see('Content');
        $I->see('Manage');
        $I->wait($wait+2);
        $this->_openCurrent($I, $testPage, $example[0]);

        /* Make sure Private object is not visible */
        $I->see("Public" . $example[0]);
        $I->dontSee("Private" . $example[0]);

        /* Logout PublicUser */
        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');
        $this->_closeAll($I, $testPage);
    }


    public function _closeAll(AcceptanceTester $I, $page) {

      $openNodes =   $I->grabMultiple($page::$openNodes);

      foreach($openNodes as $node) {
          $I->tryToClick($page::$openNodes . "[1]");
          $I->wait(.5);
      }
    }

    public function _openCurrent(AcceptanceTester $I,
         $page, string $name)
    {
        $x = 1;
        $this->_closeAll($I, $page);
        $I->click($page::$elementsTab);
        $I->wait(1);
        switch($name) {
            case 'Template':
                $I->click("Templates");
                $I->wait(1);
                break;

            case 'TV':
                $I->click("Template Variables");
                $I->wait(1);
                break;

            case 'Chunk':
                $I->click("Chunks");
                $I->wait(1);
                break;

            case 'Snippet':
                $I->click("Snippets");
                $I->wait(1);
                break;

            case 'Plugin':
                $I->click("Plugins");
                $I->wait(1);
                break;
        }
        $I->wait(1);
        $I->tryToClick('PublicElements');
        $I->wait(1);
        $I->tryToClick("PrivateElements");
    }
}
