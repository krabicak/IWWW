<?php

class Brand
{
    private $brand;

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    public function render()
    {
        $string = "<tr><form method='post'>";
        $string .= "<td><input type='text' name='brand' value='$this->brand'></td>";
        $string .= "<input type='hidden' name='id' value='$this->brand'>";
        $string .= "<td><button name='action' value='remove-brand' type='submit'>odstranit</button>";
        $string .= "<button name='action' value='update-brand' type='submit'>upravit</button></td>";
        $string .= "</form></tr>";
        return $string;
    }

}
