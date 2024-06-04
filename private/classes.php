<?php

class PageRenderer
{
    private $data_set;
    private $headers;
    private $title;

    public function __construct($data_set, $headers, $title)
    {
        $this->data_set = $data_set;
        $this->headers = $headers;
        $this->title = $title;
    }

    public function render()
    {
        // Render the page content
        echo '<div id="content">';
        echo '<div class="listing">';
        echo '<h1>' . h($this->title) . '</h1>';
        echo '<div class="actions">';
        echo '<a class="action" href="' . url_for('/staff/' . strtolower($this->title) . '/new.php') . '">Create New ' . h($this->title) . '</a>';
        echo '</div>';
        echo $this->create_table();
        echo '</div>';
        echo '</div>';
    }

    private function create_table()
    {
        // Start building the table
        $output = '<table class="list">';
        $output .= '<thead>';
        $output .= '<tr>';

        // Add the headers with formatting
        foreach ($this->headers as $header) {
            $formatted_header = ucwords(str_replace('_', ' ', $header));
            $output .= '<th>' . h($formatted_header) . '</th>';
        }
        $output .= '<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>';
        $output .= '</tr>';
        $output .= '</thead>';
        $output .= '<tbody>';

        // Add the data rows
        while ($row = mysqli_fetch_assoc($this->data_set)) {
            $output .= '<tr>';
            foreach ($this->headers as $key) {
                $output .= '<td>' . h($row[$key]) . '</td>';
            }
            $output .= '<td><a class="action" href="' . url_for('/staff/' . strtolower($this->title) . '/show.php?id=' . h(u($row['id']))) . '">View</a></td>';
            $output .= '<td><a class="action" href="' . url_for('/staff/' . strtolower($this->title) . '/edit.php?id=' . h(u($row['id']))) . '">Edit</a></td>';
            $output .= '<td><a class="action" href="' . url_for('/staff/' . strtolower($this->title) . '/delete.php?id=' . h(u($row['id']))) . '">Delete</a></td>';
            $output .= '</tr>';
        }
        $output .= '</tbody>';
        $output .= '</table>';

        // Return the table HTML
        return $output;
    }
}
