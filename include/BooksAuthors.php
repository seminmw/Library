<?php

class BooksAuthors extends AbstractEntity {

    public $page = 1;

    public $perPage = 20;

    public $authorFilter;

    public function getAll() {
        $perPage = intval($this->perPage);
        $start   = intval(($this->page - 1) * $perPage);

        $parts = $this->extendSqlWithAuthorWhereClause(
            "SELECT b.id,
                    b.title AS book_title,
                    GROUP_CONCAT(a.name) AS author
            FROM books AS b
            JOIN books_authors ba ON ba.book_id = b.id
            JOIN authors a ON a.id = ba.author_id
            WHERE 1 = 1 "
        );

        $sql    = $parts['sql'];
        $params = $parts['params'];

        $sql .= " GROUP BY b.id
                ORDER BY b.id ASC
                LIMIT $start, $perPage";

        return $this->getRows($sql, $params);
    }

    private function extendSqlWithAuthorWhereClause($sql) {
        $params = [];

        if (!empty($this->authorFilter)) {
            $sql .= " AND a.name = ?";
            $params[] = $this->authorFilter;
        }

        return [ 'sql' => $sql, 'params' => $params ];
    }

    public static function create($bookId, $authorId) {
        $sql = "INSERT INTO books_authors (book_id, author_id) VALUES (?, ?)";
        self::exec($sql, [$bookId, $authorId]);

        return Database::getActiveConnection()->lastInsertId();
    }

    public static function deleteAllBooks($bookId) {
        self::exec("DELETE FROM books_authors WHERE book_id = ?", [$bookId]);
    }

    public static function deleteAllAuthors($authorId) {
        self::exec("DELETE FROM books_authors WHERE author_id = ?", [$authorId]);
    }

    public function getResultsCount() {
        $parts = $this->extendSqlWithAuthorWhereClause(
            " SELECT COUNT(*) AS total FROM books "
        );

        return $this->getCountColumn($parts['sql'], $parts['params']);
    }

}