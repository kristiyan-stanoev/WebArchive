<?php

class database
{
  public $connection;
  public $dbname;
  private $servername;
  private $username;
  private $password;

  public function connect()
  {
    try
    {
      $this->connection = new PDO("mysql:host=$this->servername", $this->username, $this->password);
      // set the PDO error mode to exception
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
      exit();
    }
  }

  public function __construct()
  {
      $this->servername = "localhost";
      $this->username = "root";
      $this->password = "";
      $this->dbname = "Web_Archive";

      $this->connect();

  }

  public function useDatabase()
  {
    $this->connection->prepare("USE $this->dbname")->execute();
  }
  public function createDatabase()
  {
    $this->connection->prepare("CREATE DATABASE $this->dbname")->execute();
  }
  public function samplePopulate()
  {
    $sql = "USE $this->dbname; CREATE TABLE $this->dbname.`users` (`id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(99) NOT NULL , `username` VARCHAR(99) NOT NULL , `password` VARCHAR(255) NOT NULL , `role` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
    CREATE TABLE $this->dbname.`archives` (`id` INT NOT NULL AUTO_INCREMENT , `url` VARCHAR(255) NOT NULL , `rank` VARCHAR(99) NOT NULL , `date` DATETIME NOT NULL , `type` VARCHAR(99) NOT NULL ,  `destination` VARCHAR(2000) NOT NULL, `userId` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
    ALTER TABLE `archives` ADD CONSTRAINT `USERID_FOREIGN_KEY` FOREIGN KEY (`userId`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
    INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`) VALUES (NULL, 'admin@admin.com', 'admin', '7af2d10b73ab7cd8f603937f7697cb5fe432c7ff', 'ADMIN');
    INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`) VALUES (NULL, 'user@user.com', 'user', 'cd027069371cdb4f80c68dcfb37e6f4a1bdb0222', 'USER');
    INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`) VALUES (NULL, 'primer@primer.com', 'primer', 'd8e445a1dc2f33213d9e6e9f021f1cd23f626979', 'PREMIUM_USER');

    ";

    $stmt = $this->connection->prepare($sql)->execute();
  }

}

$db = new database();

?>
