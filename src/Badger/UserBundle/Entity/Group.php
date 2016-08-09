<?php

namespace Badger\UserBundle\Entity;

use FOS\UserBundle\Model\GroupInterface;

/**
 * @author    Adrien Pétremann <adrien.petremann@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class Group implements GroupInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /**
     * @param string $role
     *
     * @return self
     */
    public function addRole($role)
    {
        // TODO: Implement addRole() method.
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        // TODO: Implement hasRole() method.
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    /**
     * @param string $role
     *
     * @return self
     */
    public function removeRole($role)
    {
        // TODO: Implement removeRole() method.
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles)
    {
        // TODO: Implement setRoles() method.
    }
}
