<?php
/**
 * Created by PhpStorm.
 * User: hotov
 * Date: 09.12.2018
 * Time: 14:40
 */

class Category
{

    private $category;
    private $disabled;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
        $string .= "<td><input type='text' name='category' value='$this->category'></td>";
        $string .= "<td><input type='hidden' name='id' value='$this->category'>";
        $string .= "<input type='checkbox' name='disabled' value='1'";
        if ($this->disabled == 1) $string .= "checked";
        $string .= "></td>";
        $string .= "<td><button name='action' value='update-category' type='submit'>upravit</button></td>";
        $string .= "</form></tr>";
        return $string;
    }

}