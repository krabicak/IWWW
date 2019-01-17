<?php

class User
{

    private $id;
    private $email;
    private $created;
    private $role;
    private $first_name;
    private $last_name;
    private $address;
    private $roles;
    private $disabled;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param mixed $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }


    public function render()
    {
        $string = "<tr><form method='post'>";
        $string .= "<td><input type='hidden' name='id' value='$this->id'>$this->id</td>";
        $string .= "<td><input type='email' name='email' value='$this->email'></td>";
        $string .= "<td><input type='text' name='first-name' value='$this->first_name'></td>";
        $string .= "<td><input type='text' name='last-name' value='$this->last_name'></td>";
        $string .= "<td><input type='text' name='address' value='$this->address'></td>";
        $string .= "<td><select name='role'>";
        foreach ($this->roles as $role) {
            $string .= "<option value='" . $role->getRole() . "'";
            if ($role->getRole() == $this->role) $string .= " selected='selected'";
            $string .= ">" . $role->getRole() . "</option>";
        }
        $string .= "</select></td>";
        $string .= "<td><input type='checkbox' name='disabled' value='1' ";
        if ($this->disabled == 1) {
            $string .= "checked";
        }
        $string .= "></td>";
        $string .= "<td><button name='action' value='update-user' type='submit'>upravit</button></td>";
        $string .= "</form></tr>";
        return $string;
    }

}
