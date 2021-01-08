<?php
use Codeception\Util\Fixtures;
use Page\Acceptance\LoginPage;
use Page\Acceptance\ManagerPage;

class T16_ResourceProtectionCest
{

    /** @var _generated\modX $modx */
    public $modx;
    private const ROLES = array('TestUser');
    private const USER_GROUPS = array('Public', 'Private');
    private const RESOURCE_GROUPS = array('Public', 'Private');

    public static function setupBeforeClass(\Step\Acceptance\Objects $I) {
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
    
    public static function tearDownAfterClass(\Step\Acceptance\Objects $I) {
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
    // tests
    /* Make sure platform is working */
    public function platformTest(AcceptanceTester $I) {
        assertTrue(true);
    }

    /** @skip */
    public function ResourceProtectionTest(AcceptanceTester $I)
    {
        assertTrue(false);

        /* Login admin user JoeTester */


        /* Create ACL entry */

        /* Logout JoeTester */

        /* Login PrivateUser */

        /* See if Private resource is there */

        /* Logout PrivateUser */

        /* Login PublicUser */

        /* Make sure Private resource is not there */

        /* Logout PublicUser */

    }
}
