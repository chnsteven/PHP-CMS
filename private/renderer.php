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
        $output .= '<a class="action" href="' . url_for('/staff/' . $this->table_name .
            '/new.php') . '">Create New ' . ucfirst(rtrim($this->table_name, 's')) . '</a>';
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
            $output .= '<td><a class="action" href="' . url_for('/staff/' .
                $this->table_name . '/show.php?id=' .
                h(u($record['id']))) . '">View</a></td>';
            $output .= '<td><a class="action" href="' . url_for('/staff/' .
                $this->table_name . '/edit.php?id=' .
                h(u($record['id']))) . '">Edit</a></td>';
            $output .= '<td><a class="action" href="' . url_for('/staff/' .
                $this->table_name . '/delete.php?id=' .
                h(u($record['id']))) . '">Delete</a></td>';
            $output .= '</tr>';
        }


        mysqli_free_result($this->records);

        $output .= '</table>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}

class DeleteRenderer
{
    private $table_name;
    private $id;
    private $record;

    public function __construct($table_name, $id)
    {
        $this->table_name = $table_name;
        $this->id = $id;
        $this->record = $this->find_record();
    }

    private function find_record()
    {
        return find_by_id($this->table_name, $this->id);
    }

    public function handle_post_request()
    {
        if (is_post_request()) {
            $result = delete($this->table_name, $this->id);
            if ($result === true) {
                $_SESSION['message'] = "The record was deleted successfully.";
                redirect_to(url_for('/staff/' . $this->table_name . '/index.php'));
            }
        }
    }

    public function render()
    {
        $output = '';
        $output .= '<div id="content">';
        $output .= '<a class="back-link" href="' . url_for('/staff/' . $this->table_name . '/index.php') . '">&laquo; Back</a>';
        $output .= '<div class="' . $this->table_name . ' delete">';
        $output .= '<h1>Delete ' . ucfirst(rtrim($this->table_name, 's')) . '</h1>';
        $output .= '<p>Are you sure you want to delete this ' . rtrim($this->table_name, 's') . '?</p>';
        $output .= '<p class="item">' . h($this->record['page_name']) . '</p>';
        $output .= '<form action="' . url_for('/staff/' . $this->table_name . '/delete.php?id=' . h(u($this->record['id']))) . '" method="post">';
        $output .= '<div id="operations">';
        $output .= '<input type="submit" name="commit" value="Delete ' . ucfirst(rtrim($this->table_name, 's')) . '" />';
        $output .= '</div>';
        $output .= '</form>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}

class ShowRenderer
{
    private $table_name;
    private $id;
    private $record;

    public function __construct($table_name, $id)
    {
        $this->table_name = $table_name;
        $this->id = $id;
        $this->record = $this->find_record();
    }

    private function find_record()
    {
        return find_by_id($this->table_name, $this->id);
    }

    public function render()
    {
        $output = '';
        $output .= '<div id="content">';
        $output .= '<a class="back-link" href="' . url_for('/staff/' . $this->table_name . '/index.php') . '">&laquo; Back</a>';
        $output .= '<div class="' . $this->table_name . ' show">';
        $output .= '<h1>Page: ' . h($this->record['page_name']) . '</h1>';
        $output .= '<div class="actions">';
        $output .= '<a class="action" href="' . url_for('/index.php?id=' . h(u($this->record['id'])) . '&preview=true') . '" target="_blank">Preview</a>';
        $output .= '</div>';
        $output .= '<div class="attributes">';


        foreach ($this->record as $key => $value) {
            $output .= '<dl><dt>' . ucwords(str_replace('_', ' ', $key)) . '</dt>';
            $output .= '<dd>' . h($value) . '</dd></dl>';
        }

        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }
}
