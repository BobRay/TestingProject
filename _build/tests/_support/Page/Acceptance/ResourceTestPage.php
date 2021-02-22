<?php
namespace Page\Acceptance;

/**
 * Declare UI map for this page here. CSS or XPath allowed.
 * Examples:
 * public static $usernameField = '#username';
 * public static $formSubmitButton = "#mainForm input[type=submit]";
 *
 * IMPORTANT - Be sure not to put a carriage return
 * in a quoted section inside an identifier.
 */

class ResourceTestPage
{
    /* Resources tab */
    public static $resourcesTab = "//li[@id='modx-leftbar-tabpanel__modx-resource-tree']";

    public static $systemMenu = '#limenu-admin';

    public static $acl_option = '#acls';

    public static $privateUsersGroup =
        "//span[starts-with(text(),'PrivateUsers')]";

    public static $updateUserGroupOption =
        // "//button[contains(text(), 'Update User Group')]";
    "//span[starts-with(text(),'Update User Group')]";

    public static $permissionsTab =
        "//span[starts-with(@class,'x-tab-strip-text')
         and text()='Permissions']";

    public static $resourceGroupAccessTab =
        "//span[contains(text(),'Resource Group Access')]";

    public static $addResourceGroupButton =
        "//button[contains(text(),'Add Resource Group')]";

    public static $resourceGroupInput =
        "//input[starts-with(@id,'modx-crgact') 
        and contains(@id, 'resource-group')]";

    public static $privateResourcesOption =
        "//div[text()='PrivateResources']";

    public static $contextInput =
        "//input[starts-with(@id,'modx-crgact') 
        and contains(@id, '-context')]";

    public static $mgrOption =
        "//span[text()='(mgr)']";

    public static $authorityInput =
        "//input[starts-with(@id,'modx-crgact') 
        and contains(@id, 'authority')]";

    public static $testUserOption =
        "//div[text()='TestUser - 15' 
        and contains(@class,'x-combo-list-item')]";

    public static $policyInput =
        "//*[starts-with(@id,'x-form-el-modx-crg') 
        and contains(@id,'policy')]";

    public static $resourceOption =
        "//div[text()='Resource']";

    public static $addResourcePanelSaveButton =
        "//span[starts-with(@id,'ext-comp')]/em/button[text()='Save']";

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }
}
