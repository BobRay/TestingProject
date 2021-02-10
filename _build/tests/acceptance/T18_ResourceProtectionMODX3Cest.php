<?php
use Codeception\Util\Fixtures;
use Page\Acceptance\LoginPage;
use Page\Acceptance\LoginPagemodx3;
use Page\Acceptance\ResourceTestPage;
use Page\Acceptance\ResourceTestPagemodx3;

class T18_ResourceProtectionMODX3Cest
{

    /** @var _generated\modX $modx */
    public $modx;

    private const ROLES = array('TestUser');
    private const USER_GROUPS = array('PublicUsers',
        'PrivateUsers');
    private const RESOURCE_GROUPS =
        array('PublicResources', 'PrivateResources');

    public static function _before(\Step\Acceptance\Objects $I) {

        /* Load data files */
        $users = include codecept_data_dir() .
            '/user_data.php';

        $resources = include codecept_data_dir() .
            '/resource_data.php';

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

        $users = include codecept_data_dir() .
            '/user_data.php';
        $resources = include codecept_data_dir() .
            '/resource_data.php';
        $modx = Fixtures::get('modx');
        assertTrue($modx instanceof modX);
        $I->removeRoles($modx, self::ROLES);
        $I->removeUserGroups($modx, self::USER_GROUPS);
        $I->removeUsers($modx, $users);
        $I->removeResourceGroups($modx, self::RESOURCE_GROUPS);
        $I->removeResources($modx, $resources);
    }

    public function ResourceProtectionTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $env = $scenario->current('env');

        if (strpos($env,'modx3') !== false) {
            $testPage = new ResourceTestPagemodx3($I);
        } else {
            $testPage = new ResourceTestPage($I);
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

        /* Select Resource Group Access left tab */
        $I->click($testPage::$resourceGroupAccessTab);

        $I->wait($wait);

        /* Create actual ACL entry */
        $I->click($testPage::$addResourceGroupButton);

        $I->wait($wait);

        /* Set Resource Group */
        $I->click($testPage::$resourceGroupInput);
        $I->wait($wait);

        $I->click($testPage::$privateResourcesOption);

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

        $I->click($testPage::$resourceOption);

        $I->wait($wait);

        /* Save ACL entry */
        $I->click($testPage::$addResourcePanelSaveButton);
        $I->wait($wait);
        $I->reloadPage();

        /* Make sure JoeTester2 can see PublicResource
           and can't see PrivateResource */
        $I->wait($wait+2);
        $I->see("PublicResource");
        $I->dontSee("PrivateResource");

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

        /* Make sure Private resource is visible */
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
        $I->wait($wait+2);

        /* Make sure Private resource is not visible */
        $I->see("PublicResource");
        $I->dontSee("PrivateResource");

        /* Logout PublicUser */
        $I->wait($wait);
        $loginPage->logout();
        $I->wait($wait);
        $I->see('Password');
    }
}
