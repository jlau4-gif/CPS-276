<?php

require_once 'Db_conn.php'; 

class Date_time {
    
    // Starting method that routes the forms //
    public function checkSubmit() {
        if (isset($_POST['addNote'])) {
            return $this->addNote();
        } elseif (isset($_POST['getNotes'])) {
            return $this->getNotes();
        }
        return ""; 
    }

    private function addNote() {
        if (empty($_POST['dateTime']) || empty($_POST['note'])) {
            return "<div class='text-danger mb-3'>You must enter a date, time, and note.</div>";
        }

        // Convert HTML datetime-local to timestamp
        $timestamp = strtotime($_POST['dateTime']);
        $noteText = $_POST['note'];

        try {
            $db = new DatabaseConn(); 
            $pdo = $db->dbOpen(); // Assuming your DatabaseConn has a dbOpen() or similar method to return the PDO object

            $sql = "INSERT INTO note (date_time, note) VALUES (:dateTime, :note)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':dateTime', $timestamp, PDO::PARAM_INT);
            $stmt->bindParam(':note', $noteText, PDO::PARAM_STR);
            $stmt->execute();

            return "<div class='text-success mb-3'>The note has been added.</div>";
            
        } catch (PDOException $e) {
            return "<div class='text-danger mb-3'>There was an error adding the note.</div>";
        }
    }

    private function getNotes() {
        // Check if dates are empty
        if (empty($_POST['begDate']) || empty($_POST['endDate'])) {
            return "<div class='mb-3'> No notes found for the date range selected</div>";
        }

        // Convert the input dates to timestamps
        $begDate = strtotime($_POST['begDate']);
        $endDate = strtotime($_POST['endDate']);

        try {
            $db = new DatabaseConn();
            $pdo = $db->dbOpen();

            $sql = "SELECT date_time, note FROM note WHERE date_time BETWEEN :begDate AND :endDate ORDER BY date_time DESC";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':begDate', $begDate, PDO::PARAM_INT);
            $stmt->bindParam(':endDate', $endDate, PDO::PARAM_INT);
            $stmt->execute();

            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // If no notes are found
            if (count($records) == 0) {
                return "<div class='mb-3'>No notes found for the date range selected</div>";
            }

            // Build the table string
            $html = "<table class='table table-bordered'>";
            $html .= "<thead><tr><th>Date and Time</th><th>Note</th></tr></thead><tbody>";

            foreach ($records as $row) {
                // Convert timestamp back to human readable mm/dd/yyyy HH:MM AM/PM
                $readableDate = date("m/d/Y h:i A", $row['date_time']);
                $html .= "<tr><td>{$readableDate}</td><td>{$row['note']}</td></tr>";
            }

            $html .= "</tbody></table>";
            return $html;

        } catch (PDOException $e) {
            return "<div class='text-danger mb-3'>There was an error retrieving notes.</div>";
        }
    }
}
?>
