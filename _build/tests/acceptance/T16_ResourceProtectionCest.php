<?php
use Codeception\Util\Fixtures;
use Page\Acceptance\LoginPage;
use Page\Acceptance\ManagerPage;

class T16_ResourceProtectionCest
{

    /** @var _generated\modX $modx */
    public $modx;
    private const ROLES = array('TestUser');
    private const USER_GROUPS = array('PublicUsers', 'PrivateUsers');
    private const RESOURCE_GROUPS = array('PublicResources',
        'PrivateResources');

    public static function _before(\Step\Acceptance\Objects $I) {
        $users = include codecept_data_dir() .
            '/user_data.php';
        $resources = include codecept_data_dir() .
            '/resource_data.php';
        $modx = Fixtures::get('modx');
        assertTrue($modx instanceof modX);
        $I->createRoles($modx, self::ROLES);
        $I->createUserGroups($modx,
            self::USER_GROUPS);
        $I->createUsers($modx, $users);
        $I->createResourceGroups($modx,
            self::RESOURCE_GROUPS);
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
        $I->removeUserGroups($modx,
            self::USER_GROUPS);
        $I->removeUsers($modx, $users);
        $I->removeResourceGroups($modx,
            self::RESOURCE_GROUPS);
        $I->removeResources($modx, $resources);
    }
    // test

    public function ResourceProtectionTest(AcceptanceTester $I)
    {

        /* Login admin user JoeTester */


        /* Create ACL entry */

        /* Make sure JoeTester can see PublicResource
           and can't see PrivateResource */

        /* Logout JoeTester */

        /* Login PrivateUser */

        /* See if Private resource is there */

        /* Logout PrivateUser */

        /* Login PublicUser */

        /* Make sure Private resource is not there */

        /* Logout PublicUser */

    }
}
