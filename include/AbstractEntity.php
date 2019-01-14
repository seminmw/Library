<?php

abstract class AbstractEntity {

    abstract function getAll();
    //abstract function create($data);
    //abstract function update($id, $data);
    //abstract function delete($id);

    public function setPage(int $page) {
        $this->page = $page;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPerPage(int $perPage) {
        $this->perPage = $perPage;
    }

    public function getPerPage() {
        return $this->perPage;
    }


    public function exec($sql, $params = []) {
        return Database::exec($sql, $params);
    }

    public function getRows($sql, $params = []) {
        return $this->exec($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRow($sql, $params = []) {
        $results = $this->getRows($sql, $params);
        return empty($results) ? [] : $results[0];
    }

    public function getCountColumn($sql, $params = []) {
        $results = $this->getRow($sql, $params);
        return empty($results) ? 0 : intval($results['total']);
    }
}