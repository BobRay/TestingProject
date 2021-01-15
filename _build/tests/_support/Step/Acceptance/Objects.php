<?php
namespace Step\Acceptance;

class Objects extends \AcceptanceTester
{
    public function createRoles($modx, $roles)
    {
        $I = $this;

        foreach ($roles as $name) {

            $role = $modx->getObject('modUserGroupRole',
                array('name' => $name));
            if ($role) {
                $role->remove();
            }
            $role = $modx->newObject('modUserGroupRole');
            $role->set('name', $name);
            $role->set('authority', 15);
            $success = $role->save();
            assertTrue($success);
        }
    }

    public function removeRoles($modx, $roles)
    {
        $I = $this;
        foreach($roles as $name) {
            $role = $modx->getObject('modUserGroupRole',
                array('name'=> $name));
            if ($role) {
                $role->remove();
            }
        }
    }

    public function createUserGroups($modx, $groups)
    {
        $I = $this;
        foreach($groups as $name) {
            $group = $modx->getObject('modUserGroup',
                array('name' => $name));
            if ($group) {
                $group->remove();
            }
            $group = $modx->newObject('modUserGroup');
            $group->set('name', $name);
            $success = $group->save();
            assertTrue($success);
        }
    }

    public function removeUserGroups($modx, $groups)
    {
        $I = $this;
        foreach($groups as $name) {
            $group = $modx->getObject('modUserGroup',
                array('name'=> $name));
            if ($group) {
                $group->remove();
            }
        }
    }

    public function _createUser($modx, $fields) {
        /** @var $modx modX */
        $_SESSION['dummy'] = 'x';
        $pw = $fields['password'];
        unset($fields['password']);
        $fields['specifiedpassword'] = $pw;
        $fields['confirmpassword'] = $pw;
        $fields['passwordnotifymethod'] = 'x';
        $fields['passwordgenmethod'] = 'x';

        $modx->error->reset();
        $modx->runProcessor('security/user/create', $fields);
        $user = $modx->getObject('modUser',
            array('username' => $fields['username']));
        assertInstanceOf('modUser', $user);
        if ($user) {
            $success = $user->joinGroup(
                $fields['usergroup'], $fields['role']);
            assertTrue($success);
            $user->save();
            /* Give everyone access to the Manager */
            $success = $user->joinGroup('Administrator',
                'Super User');
            assertTrue($success);
        }
    }
    public function createUsers($modx, $users)
    {
        /** @var $modx modX */
        $I = $this;
        foreach ($users as $user) {
            $userObj = $modx->getObject('modUser',
                array(
                    'username' => $user['username']
                ));
            if ($userObj) {
                $userObj->remove();
            }
            $this->_createUser($modx, $user);
        }
    }

    public function removeUsers($modx, $users)
    {
        $I = $this;
        foreach($users as $user) {
            $userObject = $modx->getObject('modUser',
                array('username' => $user['username']));
            if ($userObject) {
                $userObject->remove();
            }
        }
    }

    public function createResourceGroups($modx, $groups)
    {
        $I = $this;
        foreach($groups as $name) {
            $group = $modx->getObject('modResourceGroup', array ('name' => $name));
            if ($group) {
                $group->remove();
            }
            $group = $modx->newObject('modResourceGroup');
            $group->set('name', $name);
            $success = $group->save();
            assertTrue($success);
        }
    }

    public function removeResourceGroups($modx, $groups)
    {
        $I = $this;
        foreach ($groups as $name) {
            $group = $modx->getObject('modResourceGroup',
                array('name' => $name));
            if ($group) {
                $group->remove();
            }
        }
    }

    public function createResources($modx, $resources)
    {
        $template = (int) $modx->getOption('default_template',
            null, 0, true);
        $I = $this;
        foreach($resources as $resource) {
            $r = $modx->getObject('modResource',
                array('alias' => $resource['alias']));
            if ($r) {
                $r->remove();
            }
            $modx->runProcessor('resource/create', $resource);

            $r = $modx->getObject('modResource',
                array('alias' => $resource['alias']), false);
            assertInstanceOf('modResource', $r);
            $success = $r->joinGroup($resource['group']);
            assertTrue($success);
        }
    }

    public function removeResources($modx, $resources)
    {
        $I = $this;
        foreach ($resources as $resource) {
            $r = $modx->getObject('modResource',
                array('alias' => $resource['alias']));
            if ($r) {
                $r->remove();
            }
        }
    }

    public function createCategories($modx)
    {
        $I = $this;
    }

    public function removeCategories($modx)
    {
        $I = $this;
    }

    public function createChunks($modx)
    {
        $I = $this;
    }

    public function removeChunks($modx)
    {
        $I = $this;
    }

    public function createSnippets($modx)
    {
        $I = $this;
    }

    public function removeSnippets($modx)
    {
        $I = $this;
    }

    public function createPlugins($modx)
    {
        $I = $this;
    }

    public function removePlugins($modx)
    {
        $I = $this;
    }

    public function createTemplates($modx)
    {
        $I = $this;
    }

    public function removeTemplates($modx)
    {
        $I = $this;
    }

    public function createTVs($modx)
    {
        $I = $this;
    }

    public function removeTVs($modx)
    {
        $I = $this;
    }
}