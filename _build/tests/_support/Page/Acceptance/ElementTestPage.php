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

class ElementTestPage
{
    /* Elements tab */
    public static $elementsTab = "//*[@id='modx-leftbar-tabpanel__modx-tree-element']//span[contains(text(),'Elements')]";

    /* Open and close Tree nodes */

    /* Locator for expanded nodes */
    public static $openNodes = "//div[contains(@class,'tree-root-node')]//i[contains(@class, 'x-tree-elbow-minus')]";

    /* ACL creation */

    public static $systemMenu = '#limenu-admin';

    public static $acl_option = '#acls';

    public static $privateUsersGroup =
        "//span[starts-with(text(),'PrivateUsers')]";

    public static $updateUserGroupOption =
        "//span[starts-with(text(),'Update User Group')]";

    public static $permissionsTab =
        "//span[starts-with(@class,'x-tab-strip-text')
         and text()='Permissions']";

    public static $elementCategoryAccessTab =
        "//span[contains(text(),'Element Category Access')]";

    public static $addCategoryButton =
        "//button[contains(text(),'Add Category')]";

    public static $categoryInput =
        "//input[starts-with(@id,'modx-cugcat') 
        and contains(@id, 'category')]";

    public static $privateElementsOption =
        "//div[text()='PrivateElements']";

    public static $contextInput =
        "//input[starts-with(@id,'modx-cugcat') 
        and contains(@id, '-context')]";

    public static $mgrOption =
        "//span[text()='(mgr)']";

    public static $authorityInput =
        "//input[starts-with(@id,'modx-cugcat') 
        and contains(@id, 'authority')]";

    public static $testUserOption =
        "//div[text()='TestUser - 15' 
        and contains(@class,'x-combo-list-item')]";

    public static $policyInput =
        "//*[starts-with(@id,'x-form-el-modx-cug') 
        and contains(@id,'policy')]";

    public static $elementOption =
        "//div[text()='Element']";

    public static $addElementPanelSaveButton =
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
