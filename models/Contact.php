<?php
  class Contact {
    // DB Stuff
    private $conn;
    private $table = 'contacts';

    // Properties
    public $id;
    public $name;
    public $phone;
    public $address;
    public $created_at;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get categories
    public function readAll() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function read() {
      //Create query
      $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

      //Prepare stmt
      $stmt = $this->conn->prepare($query);

      //Bind ID
      $stmt->bindParam(1, $this->id);

      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      //Set properties
      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->phone = $row['phone'];
      $this->address = $row['address'];
      $this->created_at = $row['created_at'];
    }

    public function create() {
      $query = 'INSERT INTO ' . $this->table . ' SET name = :name, phone = :phone, address = :address';

      $stmt = $this->conn->prepare($query);

      //Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->phone = htmlspecialchars(strip_tags($this->phone));
      $this->address = htmlspecialchars(strip_tags($this->address));

      //Bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':phone', $this->phone);
      $stmt->bindParam(':address', $this->address);

      //Execute
      if($stmt->execute()){
        return true;
      }

      //Print error 
      printf("Error: %s.\n", $stmt->error);
      return false;

    }

    public function update() {
      $query = 'UPDATE ' . $this->table . ' SET name = :name, phone = :phone, address = :address WHERE id = :id';

      $stmt = $this->conn->prepare($query);

      //Clean data
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->phone = htmlspecialchars(strip_tags($this->phone));
      $this->address = htmlspecialchars(strip_tags($this->address));
      $this->id = htmlspecialchars(strip_tags($this->id));

      //Bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':phone', $this->phone);
      $stmt->bindParam(':address', $this->address);
      $stmt->bindParam(':id', $this->id);

      //Execute
      if($stmt->execute()){
        return true;
      }

      //Print error 
      printf("Error: %s.\n", $stmt->error);
      return false;

    }

    //Delete Contact
    public function delete() {
      //Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';

      $stmt = $this->conn->prepare($query);

      //$this->id = htmlspecialchars(strip_tags($this->id));

      $stmt->bindParam(1, $this->id);

      //Execute
      if($stmt->execute()){
        return true;
      }

      //Print error 
      printf("Error: %s.\n", $stmt->error);
      return false;
    }
  }