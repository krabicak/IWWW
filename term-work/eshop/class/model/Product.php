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
        return $this->costs[0];
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


    public function show()
    {
        $string = '<form method="post" class="product-box" onclick="javascript:document.location.href =\'' . BASE_URL . '?page=detail&product=' . $this->id . '\';return false;">';
        $string .= '<h2>' . $this->name . '</h2>';
        $string .= '<img width="60%" src="' . $this->image . '" alt="' . $this->name . '">';
        $string .= '<div class="description"><h3>' . $this->costs[0]->getCost() . ' Kč</h3>';
        $string .= '<button type = "submit" name = "add-to-basket" value = " . $product->getId() . ">Add to basket</button>';
        $string .= '</div> ';
        $string .= '</form >';
        return $string;
    }

    public function render()
    {
        $string = "<tr><form method='post'>";
        $string .= "<td>$this->id</td>";
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
            $string .= "<option value='" . $category->getCategory() . "'";
            if ($category->getCategory() == $this->category) $string .= " selected='selected'";
            $string .= ">" . $category->getCategory() . "</option>";
        }
        $string .= "</select></td>";
        $string .= "<td><input type='text' name='stock' value='$this->stock'></td>";
        $string .= "<td><input type='text' name='image-link' value='$this->image'></td>";
        $string .= "<td><input type='text' name='cost' value='" . $this->costs[0]->getCost() . "'></td>";
        $string .= "<td><button name='action' value='edit-description:$this->id' type='submit'>edit description</button>";
        $string .= "<button name='action' value='update-product:$this->id' type='submit'>update</button></td>";
        $string .= "</form></tr>";
        return $string;
    }

}
