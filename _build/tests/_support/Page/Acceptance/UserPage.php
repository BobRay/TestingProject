<?php
namespace Page\Acceptance;

class UserPage
{

    public static $newUserButton = "//button[contains(text(), 'New User')]";
    public static $userSaveButton = "//button[contains(text(), 'Save')]";
    public static $userOkButton = "//button[contains(text(), 'OK')]";
    public static $userCloseButton = "//button[contains(text(), 'Close')]";
    public static $countryMenu = '//*[@id="modx-user-country"]/following-sibling::div';
    public static $genderMenu = '//*[@id="modx-user-gender"]/following-sibling::div';
    public static $photoInput = "//input[@type='text' and @name='photo']";
    public static $passwordNotifyScreen = '#modx-user-passwordnotifymethod-s';
    public static $passwordGenManual = '#modx-user-password-genmethod-s';
    public static $passwordInput = '#modx-user-specifiedpassword';
    public static $passwordConfirmInput = '#modx-user-confirmpassword';

    /* In the associative arrays below, the keys are the
       locators for fields in the user form. The values
        are the values to use to fill those fields.
     */

    public static $users = array(
        'user1' => array(
            'username' => 'User1',
            'fullname' => 'user1 fullname',
            'email' => 'user1@hotmail.com',
            'phone' => '555-218-1234',
            'mobilephone' => '555-218-5678',
            'fax' => '555-612-1234',
            'address' => '234 Walnut St.',
            'city' => 'Milwaukee',
            'state' => 'WI',
            'country' => 'Albania',
            'website' => 'http://bobsguides.com',
            'photo' => 'assets/images/compass-vector.jpg',
            'dob' => '03/22/1995',
            'gender' => 'Male',
            'comment' => 'Some Comment',
            'password' => 'SomePassword',

        ),
        'user2' => array(
            'username' => 'User2',
            'fullname' => 'user2 fullname',
            'email' => 'user2@hotmail.com',
            'phone' => '555-218-1234',
            'mobilephone' => '555-218-5678',
            'fax' => '555-612-1234',
            'address' => '211 Elm St.',
            'city' => 'Miami',
            'state' => 'FL',
            'country' => 'United States',
            'website' => 'http://wordsmatter.softville.com',
            'photo' => 'assets/images/flag1.jpg',
            'dob' => '02/21/1997',
            'gender' => 'Female',
            'comment' => 'Some Other Comment',
            'password' => 'SomeOtherPassword',
        ),
    );



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
