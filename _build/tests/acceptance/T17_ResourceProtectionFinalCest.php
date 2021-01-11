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
        // return;  /* allows examination of objects and ACL */

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

        $I->click('#acls');
        $I->wait($wait);

        /* Update PrivateUser user group */

        $I->click("//span[starts-with(text(),'PrivateUsers')]");
        $I->wait($wait);

        $I->click("//button[contains(text(), 'Update User Group')]");
        $I->wait($wait);

        /* Select Permissions top tab */
        $I->click("//span[starts-with(@class,'x-tab-strip-text') and text()='Permissions']");
        $I->wait($wait);

        /* Select Resource Group Access left tab */
        $I->click("//span[contains(text(),'Resource Group Access')]");

        $I->wait($wait);

        /* Create actual ACL entry */

        $I->click("//button[contains(text(),'Add Resource Group')]");

        $I->wait($wait);

        /* Set Resource Group */

        $I->click("//input[starts-with(@id,'modx-crgact') and contains(@id, 'resource-group')]");
        $I->wait($wait);

        $I->click("//div[text()='PrivateResources']");

        /* Set Context */

        $I->click("//input[starts-with(@id,'modx-crgact') and contains(@id, '-context')]");
        $I->wait($wait);

        $I->click("//span[text()='(mgr)']");

        /* Set Role */

        $I->click("//input[starts-with(@id,'modx-crgact') and contains(@id, 'authority')]");

        $I->wait($wait+2);

        $I->click("//div[text()='TestUser - 15' and contains(@class,'x-combo-list-item')]");

        /* Set Policy */
        $I->click("//*[starts-with(@id,'x-form-el-modx-crg') and contains(@id,'policy')]");
        $I->wait($wait);

        $I->click("//div[text()='Resource']");

        $I->wait($wait);

        /* Save ACL entry */

        $I->click("//span[starts-with(@id,'ext-comp')]/em/button[text()='Save']");
        $I->wait($wait);
        $I->reloadPage();

        /* Make sure JoeTester can see PublicResource
           and can't see PrivateResource */
        $I->wait($wait);
        $I->see("PublicResource");
        $I->dontSee("PrivateResource");

        /* Logout JoeTester */
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

        /* See if Private resource is there */
        $I->wait($wait);
        $I->see("PublicResource");
        $I->see("PrivateResource");


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
        $I->wait($wait);

        /* Make sure Private resource is not there */

        $I->see("PublicResource");
        $I->dontSee("PrivateResource");

        /* Logout PublicUser */

        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');
    }
}
