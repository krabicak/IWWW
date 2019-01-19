<?php

class Order
{

    private $id;
    private $info;
    private $address;
    private $state;
    private $users_id;
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
        return $this->users_id;
    }

    /**
     * @param mixed $usersId
     */
    public function setUsersId($usersId)
    {
        $this->users_id = $usersId;
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
        $string = "<tr><td class='id'>id: $this->id</td><td colspan='2'>$this->created</td><td colspan='2' class='right'>Adresa: $this->address</td></tr>";
        $string .= "<tr><td>id</td><td class='img'>náhled</td><td class='name'>název</td><td class='right'>skladem</td><td class='cost'>cena</td></tr>";
        foreach ($this->products as $product) {
            $string .= $product->renderInOrder($costs);
        }
        $string .= "<tr><td colspan='5'>$this->info</td></tr>";
        $string .= "<tr><td></td><td colspan='4'>stav: $this->state, Celkem: $this->cost Kč";
        $string .= "<input type='hidden' name='id' value='$this->id'>";
        if ($this->state == State::getProcessing()->getState()) {
            $string .= "&nbsp;<button name='action' value='cancel-order' type='submit'>zrušit</button>";
        }
        $string .= "</td></tr>";
        return $string;
    }

    public function render($costs, $user)
    {
        $mail = $user->getEmail();
        $string = "<form method='post'>";
        $string .= "<tr><td class='id'>id: $this->id</td><td colspan='2'>$this->created: $mail</td><td colspan='2' class='right'>Dodací adresa: $this->address</td></tr>";
        $string .= "<tr><td>id</td><td class='img'>náhled</td><td class='name'>název</td><td class='right'>skladem</td><td class='cost'>cena</td></tr>";
        $counters = array();
        $stockOk = true;
        foreach ($this->products as $product) {
            if (!isset($counters[$product->getId()])) $counters[$product->getId()] = 0;
            else $counters[$product->getId()]++;
            if ($counters[$product->getId()] >= $product->getStock()) {
                $stockOk = false;
            }
            $string .= $product->renderInOrder($costs);
        }
        $string .= "<tr><td colspan='5'>$this->info</td></tr>";
        $string .= "<tr><td colspan='2'><input type='hidden' name='id' value='$this->id'></td><td>Celkem: $this->cost Kč";
        $string .= "<input type='hidden' name='id' value='$this->id'></td>";
        if ($this->state == State::getProcessing()->getState()) {
            $string .= "<td colspan='2' class='right'><button name='action' value='cancel-order' type='submit'>zrušit</button>&nbsp;";
            $string .= "<button name='action' value='send-order' type='submit'";
            if (!$stockOk) $string .= " disabled";
            $string .= ">odeslat</button>";
            if (!$stockOk) $string .= " Nedostatek zboží na skladě";
        } else $string .= "<td colspan='2'>$this->state</td>";
        $string .= "</td></tr></form>";
        return $string;
    }
}
