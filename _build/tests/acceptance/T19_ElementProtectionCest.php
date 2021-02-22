<?php
use Codeception\Util\Fixtures;
use Page\Acceptance\LoginPage;
use Page\Acceptance\LoginPagemodx3;
use Page\Acceptance\ElementTestPage;
use Page\Acceptance\ElementTestPagemodx3;

class T19_ElementProtectionCest
 {

    /** @var _generated\modX $modx */
    public static $modx;
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
        $I->wait(1);
        $I->removeCategories($modx, self::CATEGORIES);

    }

    /** @example ["template"]
        @example ["tv"]
        @example ["chunk"]
        @example ["snippet"]
        @example ["plugin"]
     *
     * @throws Exception
     */
    public function ElementProtectionTest(AcceptanceTester $I, \Codeception\Scenario $scenario, \Codeception\Example $example)
    {
        $env = $scenario->current('env');
        $wait = 1;

        if (strpos($env,'modx3') !== false) {
            $testPage = new ElementTestPagemodx3($I);
        } else {
            $testPage = new ElementTestPage($I);
        }

       

        /* Login admin user JoeTester2 */
        if (strpos($env, 'modx3') !== false) {
            $loginPage = new LoginPagemodx3($I);
        } else {
            $loginPage = new LoginPage($I);
        }
        $loginPage->login('JoeTester2', 'TesterPassword');
        $I->wait($wait);
        $I->see('Content');
        $I->see('Manage');
        $I->click($testPage::$elementsTab);
        $this->_closeAll($I, $testPage, $example[0]);

       /* *** Create ACL entry *** */

        /* Go to ACL panel */
        $I->wait($wait);
        $I->click($testPage::$systemMenu);
        $I->wait($wait);
        $I->click($testPage::$acl_option);
        $I->wait($wait);

        /* Update PrivateUser user group */
        $I->wait($wait);
        $I->clickWithRightButton($testPage::$privateUsersGroup);

        $I->wait($wait);
        $I->click($testPage::$updateUserGroupOption);

        /* Select Permissions top tab */
        $I->wait($wait);
        $I->click($testPage::$permissionsTab);

        /* Select Element Category Access left tab */
        $I->wait($wait);
        $I->click($testPage::$elementCategoryAccessTab);

        /* Create actual ACL entry */
        $I->wait($wait);
        $I->click($testPage::$addCategoryButton);

        /* Set Category */
        $I->wait($wait);
        $I->click($testPage::$categoryInput);
        $I->wait($wait);
        $I->scrollTo($testPage::$privateElementsOption);
        $I->click($testPage::$privateElementsOption);

        /* Set Context */
        $I->wait($wait);
        $I->click($testPage::$contextInput);

        $I->wait($wait);
        $I->click($testPage::$mgrOption);

        /* Set Role */
        $I->wait($wait);
        $I->click($testPage::$authorityInput);

        $I->wait($wait);
        $I->click($testPage::$testUserOption);

        /* Set Policy */
        $I->wait($wait);
        $I->click($testPage::$policyInput);
        $I->wait($wait);
        $I->click($testPage::$elementOption);

        /* Save ACL entry */
        $I->wait($wait);
        $I->wait($wait);
        $I->click($testPage::$addElementPanelSaveButton);
        $I->wait($wait);

        $this->_openCurrent($I, $testPage, $example[0]);

        /* Make sure JoeTester2 can see Public object
           and can't see Private Object */
        $I->wait($wait);
        $I->see("Public" . $example[0]);
        $I->dontSee("Private" . $example[0]);

        /* Logout JoeTester2 */
        $this->_closeCurrent($I, $testPage, $example[0]);
        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');

        /* Login PrivateUser */
        $I->wait($wait);
        $loginPage->login('PrivateUser', 'somepassword');
        $I->wait($wait);
        $I->see('Content');
        $I->see('Manage');
        $I->click($testPage::$elementsTab);
        $this->_closeAll($I, $testPage, $example[0]);
        $this->_openCurrent($I, $testPage, $example[0]);

        /* Make sure Private Object is visible */
        $I->wait($wait);
        $I->see("Private" . $example[0]);
        $I->see("Public" . $example[0]);

        /* Logout PrivateUser */
        $this->_closeCurrent($I, $testPage, $example[0]);
        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');

        /* Login PublicUser */
        $I->wait($wait);
        $loginPage->login('PublicUser', 'somepassword');
        $I->wait($wait);
        $I->see('Content');
        $I->see('Manage');
        $I->click($testPage::$elementsTab);
        $this->_closeAll($I, $testPage, $example[0]);
        $this->_openCurrent($I, $testPage, $example[0]);

        /* Make sure Private object is not visible */
        $I->wait($wait);
        $I->see("Public" . $example[0]);
        $I->dontSee("Private" . $example[0]);

        /* Logout PublicUser */
        $this->_closeCurrent($I, $testPage, $example[0]);
        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');
    }

/** @throws Exception */
    public function _closeAll(AcceptanceTester $I, $page, $currentElement) {

        try {
            $openNodes = $I->grabTextFrom("//i[contains(@class,'tree-elbow-minus')]");
        } catch (\Exception $e) {
            return;
        }
        $count = count($openNodes);
        $elementTypes = array(
            'template',
            'tv',
            'chunk',
            'snippet',
            'plugin',
        );
        foreach ($elementTypes as $elementType) {
            /* Don't close current element */
            if ($elementType == $currentElement) {
                continue;
            }
            $success = $I->tryToClick("//div/i[contains(@class, 'x-tree-elbow-minus')]/parent::div[@*[name()='ext:tree-node-id'] = 'n_type_{$elementType}']");
            if ($success) {
                $count--;
            }
            if ($count <= 0) {
                return;
            }
        }
    }

    public function _openCurrent(AcceptanceTester $I,
         $page, string $elementType)
    {
        $wait = 1;
        $I->wait($wait);
        $I->click($page::$elementsTab);
        $I->wait($wait + 1);
        $I->tryToClick("//div/i[contains(@class, 'x-tree-elbow-plus')]/parent::div[@*[name()='ext:tree-node-id'] = 'n_type_{$elementType}']");

        $I->wait($wait);

        $I->tryToClick("//div[@*[name()='ext:tree-node-id'] = 'n_type_{$elementType}']/following-sibling::ul//i[contains(@class,'-plus')]/following-sibling::a/span[contains(text(),'PrivateElements')]");

        $I->wait($wait);
        $I->tryToClick("//div[@*[name()='ext:tree-node-id'] = 'n_type_{$elementType}']/following-sibling::ul//i[contains(@class,'-plus')]/following-sibling::a/span[contains(text(),'PublicElements')]");
    }

    public function _closeCurrent(AcceptanceTester $I,
        $page, string $elementType) {
        $I->tryToClick("//div/i[contains(@class, 'x-tree-elbow-minus')]/parent::div[@*[name()='ext:tree-node-id'] = 'n_type_{$elementType}']");
    }
}
