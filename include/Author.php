<?php

class Author extends AbstractEntity {

    public $page = 1;

    public $perPage = 20;

    public function getAll() {
        return $this->getRows("SELECT id, name FROM authors ORDER BY id ASC");
    }

    public function getItemsPerPage() {
        $perPage = intval($this->perPage);
        $start = intval(($this->page - 1) * $perPage);

        return $this->getRows(
            "SELECT
                a.id,
                a.name,
                COUNT(b.id) AS count_books
            FROM authors AS a
            LEFT JOIN books_authors ba ON ba.author_id = a.id
            LEFT JOIN books b ON b.id = ba.book_id
            GROUP BY a.id
            ORDER BY a.id ASC
            LIMIT $perPage OFFSET $start"
        );
    }

    public function getAllRows() {
        return $this->getRows("SELECT id, name FROM authors ORDER BY id ASC");
    }

    public function getAuthor($id) {
        return $this->getRow("SELECT id, name FROM authors WHERE id = ?", [$id]);
    }

    public function getAuthorsBookById($id) {
        return $this->getRows(
            "SELECT
                a.id,
                a.name
            FROM authors AS a
            LEFT JOIN books_authors ba ON ba.author_id = a.id
            WHERE ba.book_id = ?",
            [$id]
        );
    }

    public function getSelectedBooks($id) {
        return $this->getRows(
            "SELECT
                b.id,
                b.title,
                CASE
                    WHEN a.author_id IS NOT NULL THEN true
                    ELSE false
                END AS selected
            FROM books AS b
            LEFT JOIN books_authors AS a ON b.id = a.book_id AND a.author_id = ?
            ORDER BY b.title ASC
        ", [$id]);
    }

    public function create($name) {
        $this->exec("INSERT INTO authors (name) VALUES (?)", [$name]);

        return Database::getActiveConnection()->lastInsertId();
    }

    public function update($id, $name) {
        return $this->exec("UPDATE authors SET name = ? WHERE id = ?", [$name, $id]);
    }

    public function delete($id) {
        // -- delete all books, even with multiple authors
        $this->exec("DELETE FROM books WHERE id IN (
                SELECT
                    book_id
                FROM books_authors
                WHERE author_id = ?
            )", [
            $id
        ]);

        // --
        return $this->exec("DELETE FROM authors WHERE id = ?", [$id]);
    }

    public function getResultsCount() {
        return $this->getCountColumn("SELECT COUNT(*) AS total FROM authors");
    }
}
