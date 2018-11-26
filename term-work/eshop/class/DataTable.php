<?php

class DataTable
{
    private $dataSet;
    private $columns;

    public function __construct($dataSet)
    {
        $this->dataSet = $dataSet;
    }

    public function addColumn($databaseColumnName, $tht)
    {
        $this->columns[$databaseColumnName] = array("table-head-title" => $tht);
    }

    public function render()
    {
        echo "<table>";
        foreach ($this->dataSet as $row) {
            echo "<tr>";
            foreach ($this->columns as $key => $value) {
                echo "<td>" . $row[$key] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "Total rows: " . sizeof($this->dataSet);
    }
}

?>