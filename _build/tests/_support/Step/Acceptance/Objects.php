<?php
namespace Step\Acceptance;

class Objects extends \AcceptanceTester
{
    protected $categoriesArray = array();

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
        // user->joinGroup() crashes with no $_SESSION set
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
        $I = $this;

        $template = (int) $modx->getOption('default_template',
            null, 0, true);

        foreach($resources as $resource) {
            $r = $modx->getObject('modResource',
                array('alias' => $resource['alias']));
            if ($r) {
                $r->remove();
            }
            $modx->runProcessor('resource/create',
                $resource);

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

    public function createCategories($modx, $categories)
    {
        $I = $this;
        foreach ($categories as $category) {
            $o = $modx->getObject('modCategory',
                array('category' => $category));
            if ($o) {
                $o->remove();
            }
            $c = $modx->newObject('modCategory');
            $c->set('category', $category);
            $success = $c->save();
            assertTrue($success, 'Failed to save Category');
            /* Set ID of category in $this->categoriesArray */
            $cat = $modx->getObject('modCategory',
                array('category' => $category));
            if ($cat) {
                $this->categoriesArray[$category] = $cat->get('id');
            }
        }
    }

    public function removeCategories($modx, $categories)
    {
        $I = $this;
        foreach( $categories as $category) {
            $c = $modx->getObject('modCategory', array('category' => $category));
            if ($c) {
                $c->remove();
            }
        }
    }

    public function createElements($modx, $elements) {
        $I = $this;
        foreach($elements as $element) {
            $nameField = 'name';
            if ($element['class_key'] === 'modTemplate') {
                $nameField = 'templatename';
                $element[$nameField] = $element['name'];
                unset($element['name']);
            }
            $o = $modx->getObject($element['class_key'],
                array($nameField => $element[$nameField]));
            if ($o) {
                $o->remove();
            }
            $element['category'] =
                $this->categoriesArray[$element['category']];
            $object = $modx->newObject($element['class_key']);
            $object->fromArray($element);
            $object->set('category',$element['category']);
            assertInstanceOf($element['class_key'], $object);
            $success = $object->save();
            assertTrue($success);
        }
    }

    public function removeElements ($modx, $elements) {
        $I = $this;
        foreach($elements as $element) {
            $nameField = $element['class_key'] == 'modTemplate'
                ? 'templatename'
                : 'name';
            $e = $modx->getObject($element['class_key'],
                array($nameField => $element['name']));
            if ($e) {
                $e->remove();
            }
        }
    }
}