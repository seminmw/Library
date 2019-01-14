<?php

class Book extends AbstractEntity {

    public $page = 1;

    public $perPage = 20;

    public function getAll() {
        return $this->getRows("SELECT id, title FROM books ORDER BY id ASC");
    }

    public function getSelectedAuthors($id) {
        return $this->getRows(
            "SELECT
                a.id,
                a.name,
                CASE
                    WHEN b.book_id IS NOT NULL THEN true
                    ELSE false
                END AS selected
            FROM authors AS a
            LEFT JOIN books_authors AS b ON a.id = b.author_id AND b.book_id = ?
            ORDER BY a.name ASC
        ", [$id]);
    }

    public function getItemsPerPage() {
        $perPage = intval($this->perPage);
        $start = intval(($this->page - 1) * $perPage);

        return $this->getRows(
            "SELECT
                b.id,
                b.title,
                COUNT(a.id) AS count_authors
            FROM books AS b
            LEFT JOIN books_authors ba ON ba.book_id = b.id
            LEFT JOIN authors a ON a.id = ba.author_id
            GROUP BY b.id
            ORDER BY b.id ASC
            LIMIT $perPage OFFSET $start"
        );
    }

    public function getBook($id) {
        return $this->getRow("SELECT id, title FROM books WHERE id = ?", [$id]);
    }

    public function getBooksByAuthorId($authorId) {
        return $this->getRows(
            "SELECT
                b.id,
                b.title
            FROM books AS b
            JOIN books_authors ba ON ba.book_id = b.id
            WHERE ba.author_id = ?",
            [$authorId]
        );
    }

    public function create($title) {
        $this->exec("INSERT INTO books (title) VALUES (?)", [$title]);

        return Database::getActiveConnection()->lastInsertId();
    }

    public function update($id, $title) {
        return $this->exec("UPDATE books SET title = ? WHERE id = ?", [
            $title, $id
        ]);
    }

    public function delete($id) {
        $this->exec("DELETE FROM books WHERE id = ?", [$id]);
    }

    public function getResultsCount() {
        $sql = "SELECT COUNT(*) AS total FROM books";
        return $this->getCountColumn($sql);
    }
}