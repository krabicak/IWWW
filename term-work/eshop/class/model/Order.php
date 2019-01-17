<?php

class Order
{

    private $id;
    private $info;
    private $address;
    private $state;
    private $usersId;
    private $cost;
    private $created;

    private $products;
    private $states;

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

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
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
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
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getUsersId()
    {
        return $this->usersId;
    }

    /**
     * @param mixed $usersId
     */
    public function setUsersId($usersId)
    {
        $this->usersId = $usersId;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @param mixed $states
     */
    public function setStates($states)
    {
        $this->states = $states;
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


    public function renderInMyOrders($costs)
    {
        $string = "<tr><td>id: $this->id</td><td>$this->created</td><td>$this->address</td></tr>";
        foreach ($this->products as $product) {
            $string .= $product->renderInOrder($costs);
        }
        $string .= "<tr><td colspan='3'>$this->info</td></tr>";
        $string .= "<tr><td></td><td>stav: $this->state</td><td class='right' class='total'>Celkem: $this->cost Kč";
        $string .= "<input type='hidden' name='id' value='$this->id'></td>";
        if ($this->state == State::getProcessing()->getState()) {
            $string .= "<td><button name='action' value='cancel-order' type='submit'>zrušit</button></td>";
        }
        $string .= "</tr>";
        return $string;
    }

    public function render()
    {
        $string = "<tr><form method='post'>";
        $string .= "<td>$this->id</td>";

        $string .= "</form></tr>";
        return $string;
    }
}
