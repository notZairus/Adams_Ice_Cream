<?php

class Database { 

  private $connection;

  private $cmd;
  
  function __construct($config) {
    $this->connection = new PDO("mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset={$config['charset']}", $config['username'], $config['pass']);
  }

  public function query($sql, $params = []) {
    $this->cmd = $this->connection->prepare($sql);
    $this->cmd->execute($params);
    return $this;
  }

  public function find() {
    return $this->cmd->fetch();
  }

  public function fetch() {
    return $this->cmd->fetch();
  }

  public function fetchOrFail() {
    $result = $this->cmd->fetch();

    if (! $result) {
      //abort
    } 

    return $result;
  }

  public function fetchAll() {
    return $this->cmd->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchAllOrFail() {
    $result = $this->cmd->fetchAll(PDO::FETCH_ASSOC);

    if ($result == []) {
      //abort
    } 

    return $result;
  }


};