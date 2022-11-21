<?php

class Database
{
  private string $host;
  private string $user;
  private string $pass;
  private string $dbName;
  private PDO $connexion;
  private PDOStatement $request;
  

  public function __construct(string $host, string $user, string $dbName, string $pass)
  {
    $this->host = $host;
    $this->user = $user;
    $this->dbName = $dbName;
    $this->pass = $pass;
  }

  public function connect()
  {
    $path = "mysql:host=$this->host;dbname=$this->dbName;charset=utf8";

    try
    {
      $this->connexion = new PDO($path, $this->user, $this->pass);
      $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
  }

  public function prepReq(string $query, array $array = [])
  {
      $this->request = $this->connexion->prepare($query);
      $this->request->execute($array);
      return $this->request;
  }

  /**
   * Récupère les données
   * @return bool|array
   */
  public function fetchData()

  {
    // return $this->request->fetchAll();
  }

  }
