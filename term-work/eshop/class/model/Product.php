<?php

class Product
{

    private $id;
    private $name;
    private $description;
    private $image;
    private $brand;
    private $category;
    private $created;
    private $stock;
    private $disabled;

    private $categories;
    private $brands;
    private $costs;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->costs[0]->getCost();
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

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
    public function getBrands()
    {
        return $this->brands;
    }

    /**
     * @param mixed $brands
     */
    public function setBrands($brands)
    {
        $this->brands = $brands;
    }

    /**
     * @return mixed
     */
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * @param mixed $costs
     */
    public function setCosts($costs)
    {
        $this->costs = $costs;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
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


    public function show()
    {
        $string = '<form method="post" class="product-box" onclick="javascript:document.location.href =\'' . BASE_URL . '?page=detail&product=' . $this->id . '\'">';
        $string .= '<h2>' . $this->name . '</h2>';
        $string .= '<img src="' . $this->image . '" alt="' . $this->name . '">';
        $string .= '<div class="description"><h3>' . $this->costs[0]->getCost() . ' Kč</h3>';
        $string .= '<h3>skladem: ' . $this->stock . '</h3>';
        $string .= '<button type = "submit" name = "add-to-basket" value = "' . $this->id . '">Přidat do košíku</button>';
        $string .= '</div>';
        $string .= "</form>\n";
        return $string;
    }

    public function render()
    {
        $string = "<tr><form method='post'>";
        $string .= "<td><input type='hidden' name='id' value='$this->id'>$this->id</td>";
        $string .= "<td>$this->created</td>";
        $string .= "<td><input type='text' name='name' value='$this->name'></td>";
        $string .= "<td><select name='brand'>";
        foreach ($this->brands as $brand) {
            $string .= "<option value='" . $brand->getBrand() . "'";
            if ($brand->getBrand() == $this->brand) $string .= " selected='selected'";
            $string .= ">" . $brand->getBrand() . "</option>";
        }
        $string .= "</select></td>";
        $string .= "<td><select name='category'>";
        foreach ($this->categories as $category) {
            if ($category->getDisabled() == 1) continue;
            $string .= "<option value='" . $category->getCategory() . "'";
            if ($category->getCategory() == $this->category) $string .= " selected='selected'";
            $string .= ">" . $category->getCategory() . "</option>";
        }
        $string .= "</select></td>";
        $string .= "<td><input type='text' name='stock' value='$this->stock'></td>";
        $string .= "<td><input type='text' name='image-link' value='$this->image'></td>";
        $string .= "<td><input type='text' name='cost' value='" . $this->costs[0]->getCost() . "'></td>";
        $string .= "<td><input type='checkbox' name='disabled' value='1'";
        if ($this->disabled==1) $string .= "checked";
        $string .= "></td>";
        $string .= "<td><button name='action' value='edit-description' type='submit'>upravit popis</button>";
        $string .= "<button name='action' value='update-product' type='submit'>upravit</button></td>";
        $string .= "</form></tr>";
        return $string;
    }

    public function renderInBasket()
    {
        $string = "<tr><form method='post'>";
        $string .= "<input type='hidden' name='id' value='$this->id'>";
        $string .= "<td><img width='35px' src='$this->image'></td>";
        $string .= "<td><a href='" . BASE_URL . "?page=detail&product=$this->id'>$this->name</td>";
        $string .= "<td class='right'>$this->stock</td>";
        $string .= "<td class='right'>" . $this->costs[0]->getCost() . " Kč</td>";
        $string .= "<td><button name='action' value='remove-product' type='submit'>odstranit</button></td>";
        $string .= "</form></tr>";
        return $string;
    }

    public function renderInOrder($costsId)
    {
        $string = "<tr>";
        $string .= "<td><img width='35px' src='$this->image'></td>";
        $string .= "<td><a href='" . BASE_URL . "?page=detail&product=$this->id'>$this->name</a></td>";
        $string .= "<td class='right'>";
        foreach ($this->costs as $cos) {
            foreach ($costsId as $c) {
                if ($cos->getId() == $c["costs_id"]) {
                    $string .= $cos->getCost();
                    break;
                }
            }
        }
        $string .= " Kč</td>";
        $string .= "</tr>";
        return $string;
    }

}
