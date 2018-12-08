<?php

class UsersTable
{
    private $dataSet;
    private $columns;
    private $roles;

    public function __construct($dataSet, $roles)
    {
        $this->dataSet = $dataSet;
        $this->roles = $roles;
    }

    public function addColumn($databaseColumnName, $tht)
    {
        $this->columns[$databaseColumnName] = array("table-head-title" => $tht);
    }

    public function render()
    {
        echo "<table><form method='post'>";
        echo "<tr><td>ID</td><td>email</td><td>role</td><td>created</td><td>actions</td></tr>";
        foreach ($this->dataSet as $row) {
            echo "<tr>";
            echo "<td>" . $row[0] . "</td><td><input type='email' name='email' value='" . $row[1] . "'></td><td>";
            echo "<select name='role'>";
            foreach ($this->roles as $option) {
                echo "<option value='$option[0]'";
                if ($option[0] == $row[2]) echo " selected='selected'";
                echo ">$option[0]</option>";
            }
            echo "</select></td><td>" . $row[3] . "</td>";
            echo "<td><button name='action' value='remove-user:" . $row[0] . "' type='submit'>delete</button><button name='action' value='update-user:" . $row[0] . "' type='submit'>update</button></td>";
            echo "</tr>";
        }
        echo "</form></table>";
        echo "Total rows: " . sizeof($this->dataSet);
    }
}

?>