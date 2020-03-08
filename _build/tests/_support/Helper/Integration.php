<?php
namespace Helper;

use \modX;
use \modUser;

class Integration extends \Codeception\Module {

    /**
     * @param modX $modx
     * @param array $usernames
     */
    public function removeUsers($modx, $usernames) {
        /** @var modUser $user */
        foreach ($usernames as $username) {
            $user = $modx->getObject('modUser', array('username' => $username));
            if ($user) {
                $user->remove();
            }
        }
    }
}