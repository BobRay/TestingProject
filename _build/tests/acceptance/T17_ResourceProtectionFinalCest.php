<?php
use Codeception\Util\Fixtures;
use Page\Acceptance\LoginPage;
use Page\Acceptance\ManagerPage;

class T17_ResourceProtectionCest
{

    /** @var _generated\modX $modx */
    public $modx;
    private const ROLES = array('TestUser');
    private const USER_GROUPS = array('PublicUsers', 'PrivateUsers');
    private const RESOURCE_GROUPS = array('PublicResources', 'PrivateResources');

    public static function _before(\Step\Acceptance\Objects $I) {
        $users = include codecept_data_dir() . '/user_data.php';
        $resources = include codecept_data_dir() . '/resource_data.php';
        $modx = Fixtures::get('modx');
        assertTrue($modx instanceof modX);
        $I->createRoles($modx, self::ROLES);
        $I->createUserGroups($modx, self::USER_GROUPS);
        $I->createUsers($modx, $users);
        $I->createResourceGroups($modx, self::RESOURCE_GROUPS);
        $I->createResources($modx, $resources);
    }
    
    public static function _after(\Step\Acceptance\Objects $I) {
        $users = include codecept_data_dir() . '/user_data.php';
        $resources = include codecept_data_dir() . '/resource_data.php';
        $modx = Fixtures::get('modx');
        assertTrue($modx instanceof modX);
        $I->removeRoles($modx, self::ROLES);
        $I->removeUserGroups($modx, self::USER_GROUPS);
        $I->removeUsers($modx, $users);
        $I->removeResourceGroups($modx, self::RESOURCE_GROUPS);
        $I->removeResources($modx, $resources);
    }

    public function ResourceProtectionTest(AcceptanceTester $I)
    {
        assertTrue(true);
        $wait = 2;

        /* Login admin user JoeTester */
        $loginPage = new LoginPage($I);
        $loginPage->login('JoeTester', 'TesterPassword');
        $I->see('Content');
        $I->see('Manage');
        $I->wait($wait);

        /* *** Create ACL entry *** */

        /* Go to ACL panel */
        $I->wait($wait + 1);
        $I->moveMouseOver('#limenu-admin');
        $I->wait(1);
        $I->moveMouseOver('#acls');

        $I->clickWithLeftButton('#acls');
        $I->wait($wait);

        /* Update PrivateUser user group */

        $I->clickWithLeftButton("//span[starts-with(text(),'PrivateUsers')]");
        $I->wait($wait);

        $I->clickWithLeftButton("//button[contains(text(), 'Update User Group')]");
        $I->wait($wait);

        /* Select Permissions top tab */
        $I->clickWithLeftButton("//span[starts-with(@class,'x-tab-strip-text') and text()='Permissions']");
        $I->wait($wait);

        /* Select Resource Group Access left tab */
        $I->clickWithLeftButton("//span[contains(text(),'Resource Group Access')]");

        $I->wait($wait);

        /* Create actual ACL entry */

        $I->clickWithLeftButton("//button[contains(text(),'Add Resource Group')]");

        $I->wait($wait);

        /* Set Resource Group */

        $I->click("//input[starts-with(@id,'modx-crgact') and contains(@id, 'resource-group')]");
        $I->wait($wait);

        $I->click("//div[text()='PrivateResources']");

        /* Set Context */

        $I->click("//input[starts-with(@id,'modx-crgact') and contains(@id, '-context')]");
        $I->wait($wait);

        $I->clickWithLeftButton("//span[text()='(mgr)']");

        /* Set Role */

        $I->clickWithLeftButton("//input[starts-with(@id,'modx-crgact') and contains(@id, 'authority')]");

        $I->wait($wait);

        $I->clickWithLeftButton("//div[text()='TestUser - 15']");

        /* Set Policy */
        $I->clickWithLeftButton("//*[starts-with(@id,'x-form-el-modx-crg') and contains(@id,'policy')]");
        $I->wait($wait);

        $I->click("//div[text()='Resource']");

        $I->wait($wait);

        /* Save ACL entry */

        $I->click("//span[starts-with(@id,'ext-comp')]/em/button[text()='Save']");

        /* Logout JoeTester */
        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');

        /* Login PrivateUser */

        /* See if Private resource is there */

        /* Logout PrivateUser */

        /* Login PublicUser */

        /* Make sure Private resource is not there */

        /* Logout PublicUser */

    }
}
