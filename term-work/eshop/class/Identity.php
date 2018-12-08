<?php

class Identity
{
    private $id = null;
    private $email = null;
    private $role = null;

    public function __construct($id, $email, $role)
    {
        $this->email = $email;
        $this->id = $id;
        $this->role = $role;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param null $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }



}

?>