<?php
class LibraryRequest {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($name, $ticket, $genre, $ebook, $period) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO library_requests (name, ticket_number, genre, ebook, period)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$name, $ticket, $genre, $ebook, $period]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM library_requests ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}
