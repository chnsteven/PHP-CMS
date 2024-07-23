<?php

class IndexRenderer
{
    private $table_name;
    private $records;
    private $columns;

    public function __construct($table_name, $records)
    {
        $this->table_name = $table_name;
        $this->records = $records;
        $this->columns = $this->get_column_names();
    }

    private function get_column_names()
    {
        $field_info = mysqli_fetch_fields($this->records);
        $columns = [];
        foreach ($field_info as $field) {
            $columns[] = $field->name;
        }
        return $columns;
    }

    public function render()
    {
        $output = '';
        $output .= '<div id="content">';
        $output .= '<div class="' . $this->table_name . ' listing">';
        $output .= '<h1>' . ucfirst($this->table_name) . '</h1>';

        $output .= '<div class="actions">';
        $output .= '<a class="action" href="' . url_for('/staff/' . $this->table_name . '/new.php') . '">Create New ' . ucfirst(rtrim($this->table_name, 's')) . '</a>';
        $output .= '</div>';

        $output .= '<table class="list">';
        $output .= '<tr>';
        foreach ($this->columns as $column) {
            $output .= '<th>' . ucfirst(str_replace('_', ' ', $column)) . '</th>';
        }
        $output .= '<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>';

        // Reset the pointer of the result set
        mysqli_data_seek($this->records, 0);

        while ($record = mysqli_fetch_assoc($this->records)) {
            $output .= '<tr>';
            foreach ($this->columns as $column) {
                $output .= '<td>' . h($record[$column]) . '</td>';
            }
            $output .= '<td><a class="action" href="' . url_for('/staff/' . $this->table_name . '/show.php?id=' . h(u($record['id']))) . '">View</a></td>';
            $output .= '<td><a class="action" href="' . url_for('/staff/' . $this->table_name . '/edit.php?id=' . h(u($record['id']))) . '">Edit</a></td>';
            $output .= '<td><a class="action" href="' . url_for('/staff/' . $this->table_name . '/delete.php?id=' . h(u($record['id']))) . '">Delete</a></td>';
            $output .= '</tr>';
        }

        $output .= '</table>';
        mysqli_free_result($this->records);

        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}

class DeleteRenderer
{
}
