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
        return;
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

        /* Login admin user JoeTester */
        $loginPage = new LoginPage($I);
        $loginPage->login('JoeTester', 'TesterPassword');
        $I->see('Content');
        $I->see('Manage');
        $I->wait(2);

        /* Create ACL entry */

        /* Go to ACL panel */
        $I->wait(3);
        $I->moveMouseOver('#limenu-admin');
        $I->wait(1);
        $I->moveMouseOver('#acls');

        $I->clickWithLeftButton('#acls');
        $I->wait(3);

        /* Update PrivateUser user group */
        $I->moveMouseOver("//span[starts-with(text(),'PrivateUsers')]");
        $I->clickWithLeftButton("//span[starts-with(text(),'PrivateUsers')]");
        $I->wait(2);
        $I->moveMouseOver("//button[contains(text(), 'Update User Group')]");
        $I->clickWithLeftButton("//button[contains(text(), 'Update User Group')]");
        $I->wait(2);

        /* Select Permissions top tab */
        $I->moveMouseOver("//span[starts-with(@class,'x-tab-strip-text') and text()='Permissions']");
        $I->clickWithLeftButton("//span[starts-with(@class,'x-tab-strip-text') and text()='Permissions']");
        $I->wait(3);

        /* Select Resource Group Access left tab */
        $I->moveMouseOver("//span[contains(text(),'Resource Group Access')]");
        $I->clickWithLeftButton("//span[contains(text(),'Resource Group Access')]");

        $I->wait(2);

        /* Create actual ACL entry */
        $I->moveMouseOver("//button[contains(text(),'Add Resource Group')]");
        $I->clickWithLeftButton("//button[contains(text(),'Add Resource Group')]");

        $I->wait(3);

        /* Set Resource Group */
        $I->moveMouseOver("//input[starts-with(@id,'modx-crgact') and contains(@id, 'resource-group')]");
        $I->click("//input[starts-with(@id,'modx-crgact') and contains(@id, 'resource-group')]");
        $I->wait(2);
        $I->moveMouseOver("//div[text()='PrivateResources']");
        $I->click("//div[text()='PrivateResources']");

        /* Set Context */
        $I->moveMouseOver("//input[starts-with(@id,'modx-crgact') and contains(@id, '-context')]");
        $I->click("//input[starts-with(@id,'modx-crgact') and contains(@id, '-context')]");
        $I->wait(3);

        $I->moveMouseOver("//span[text()='(mgr)']");
        $I->clickWithLeftButton("//span[text()='(mgr)']");

        /* Set Role */
        $I->moveMouseOver("//input[starts-with(@id,'modx-crgact') and contains(@id, 'authority')]");
        $I->clickWithLeftButton("//input[starts-with(@id,'modx-crgact') and contains(@id, 'authority')]");

        $I->wait(2);
        $I->moveMouseOver("//div[text()='TestUser - 15']");
        $I->clickWithLeftButton("//div[text()='TestUser - 15']");

        /* Set Policy */
        $I->moveMouseOver("//*[starts-with(@id,'x-form-el-modx-crg') and contains(@id,'policy')]");
        $I->clickWithLeftButton("//*[starts-with(@id,'x-form-el-modx-crg') and contains(@id,'policy')]");
        $I->wait(2);
        $I->moveMouseOver("//div[text()='Resource']");
        $I->click("//div[text()='Resource']");

        $I->wait(5);

        /* Save ACL entry */
        $I->moveMouseOver("//span[starts-with(@id,'ext-comp')]/em/button[text()='Save']");
        $I->click("//span[starts-with(@id,'ext-comp')]/em/button[text()='Save']");

        /* Logout JoeTester */
        $I->wait(2);
        $loginPage->logout();
        $I->wait(2);
        $I->see('Password');

        /* Login PrivateUser */

        /* See if Private resource is there */

        /* Logout PrivateUser */

        /* Login PublicUser */

        /* Make sure Private resource is not there */

        /* Logout PublicUser */

    }
}
