<?php
use Page\Acceptance\LoginPage;
use Page\Acceptance\ManagerPage;
use Page\Acceptance\UserPage;
use Codeception\Util\Fixtures;

class T15_ManagerUserCest
{
    /** @var modX $modx */
    protected $modx;
    protected $countries;

    protected $usernames = array('user1','user2');

    public function _before(AcceptanceTester $I)
    {
        $this->modx = Fixtures::get('modx');
        assertTrue($this->modx instanceof modX);

        $_country_lang = array();
        include $this->modx->getOption('core_path') . 'lexicon/country/en.inc.php';
        $this->countries = $_country_lang;

        /* Make sure users are not there */
        foreach ($this->usernames as $username) {
            $user = $this->modx->getObject('modUser', array('username' => $username));
            if ($user) {
                $user->remove();
            }
        }
    }

    public function _after(AcceptanceTester $I) {
        /* Make sure users are removed */
        foreach ($this->usernames as $username) {
            $user = $this->modx->getObject('modUser', array('username' => $username));
            if ($user) {
              $user->remove();
            }
            $user = $this->modx->getObject('modUser', array('username' => $username));
            assertNull($user);
        }
    }

    // tests
    /** @throws Exception */
    public function CreateUsersTest(AcceptanceTester $I)
    {
        $I->wantTo('Log In');
        $generatedPassword = null;
        $loginPage = new LoginPage($I);
        $managerPage = new ManagerPage($I);
        $userPage = new UserPage($I);
        $loginPage->login();
        $I->see('Content');
        $I->see('Manage');

        $I->amGoingTo('Switch to User Panel');
        $I->waitForElementVisible($managerPage::$manageMenu);
        $I->moveMouseOver($managerPage::$manageMenu);
        $I->waitForElementVisible($managerPage::$manageUsersLink,30);
        $I->click($managerPage::$manageUsersLink);
        $I->wait(3);

        /* Prefix for fields with Id */
        $prefix = '#modx-user-';

        $users = $userPage::$users;
        foreach($users as $userFields) {
            $autoPassword = empty($userFields['password']);
            $I->waitForElementVisible($userPage::$newUserButton, 30);
            $I->click($userPage::$newUserButton);

            /* Fill and save user form for both users */
            foreach ($userFields as $locator => $value) {
                switch($locator) {
                    case 'country':
                        $I->click($userPage::$countryMenu);
                        $I->click("//div[contains(@class, 'x-combo-list-item') 
                            and text() = '{$value}']");
                        break;

                    case 'gender':
                        $I->click($userPage::$genderMenu);
                        $I->waitForElementVisible("//div[contains(@class,
                            'x-combo-list-item') and 
                            text() = '{$value}']", 10);
                        $I->click("//div[contains(@class, 'x-combo-list-item') 
                            and text() = '{$value}']");
                        break;

                    case 'photo':
                        $I->fillField($userPage::$photoInput, $value);
                        break;

                    case 'password':
                        if (! $autoPassword) {
                            /* Manual password */
                            $I->click($userPage::$passwordNotifyScreen);
                            $I->click($userPage::$passwordGenManual);
                            $I->waitForElementVisible($userPage::$passwordInput, 5);
                            $I->wait(2); //necessary
                            $I->fillField($userPage::$passwordInput, $value);
                            $I->fillField($userPage::$passwordConfirmInput, $value);
                            $I->wait(1); // necessary
                        }
                        break;


                    default:
                        $I->fillField($prefix . $locator, $value);
                        break;
                }
            }

            /* Save and close user form */
            $I->click($userPage::$userSaveButton);
            $I->waitForElementVisible($userPage::$userOkButton);
            if ($autoPassword) {
                $msg = $I->grabTextFrom($userPage::$autoPasswordValue);
                assertNotEmpty($msg);
                $msg = explode(':', $msg);
                $generatedPassword = trim($msg[1]);
            }
            $I->click($userPage::$userOkButton);

            /* Make sure user was saved, then close */
            $user = $this->modx->getObject('modUser',
                array('username' => $userFields['username']));
            assertInstanceOf('modUser', $user);
            $I->waitForElementVisible($userPage::$userCloseButton, 5);
            $I->wait(2); //necessary
            $I->click($userPage::$userCloseButton);
        }

        /* Test database values for both users */
        foreach($users as $userFields) {
            $autoPassword = empty($userFields['password']);
            /** @var modUser $user */
            $user = $this->modx->getObject('modUser',
                array('username'=> $userFields['username']));
            assertInstanceOf('modUser', $user);
            $profile = $user->getOne('Profile');
            assertInstanceOf('modUserProfile', $profile);
            $dbFields = $user->toArray();
            $dbFields = array_merge($dbFields,
                $profile->toArray());
            foreach($userFields as $key => $value) {
                switch($key) {
                    case 'password':
                        if ($autoPassword) {
                           $pw = $generatedPassword;
                        } else {
                            $pw = $userFields['password'];
                        }
                        assertTrue($user->passwordMatches($pw));
                        break;

                    case 'country':
                        assertEquals($value,
                            $this->countries[strtolower($dbFields[$key])]);
                        break;

                    case 'dob':
                        assertEquals(strtotime($value),
                            $dbFields[$key]);
                        break;

                    case 'gender':
                        $gender = array(
                            '1' => 'Male',
                            '2' => 'Female',
                            '3' => 'Other',
                        );
                        assertEquals($value, $gender[$dbFields['gender']]);
                        break;

                    case 'photo':
                        break;

                    default:
                        assertEquals($value, $dbFields[$key]);
                        break;
                }
            }
        }
    }
}
