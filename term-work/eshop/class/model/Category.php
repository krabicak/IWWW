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

    public function render()
    {
        $string = "<tr><form method='post'>";
        $string .= "<td><input type='text' name='category' value='$this->category'></td>";
        $string .= "<td><button name='action' value='remove-category:$this->category' type='submit'>delete</button>";
        $string .= "<button name='action' value='update-category:$this->category' type='submit'>update</button></td>";
        $string .= "</form></tr>";
        return $string;
    }

}