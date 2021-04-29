

<?php
// Author: Firdaus
// model that holds customer details and methods to edit and find customer details
require_once '../../../libs/profileDB.php';
class CustomerProfileModel
{
  private $db;
  public function __construct()
  {
    $this->db = new Database;
  }

  // // Get User by ID
  public function getUserById($id)
  {
    $this->db->query('SELECT * FROM customer WHERE CustID = :id');
    // Bind value
    $this->db->bind(':id', $id);

    $row = $this->db->single();
    // returns a single row
    return $row;
  }

  // Find user by email
  public function findUserByEmail($email)
  {
    $this->db->query('SELECT * FROM customer WHERE CustEmail = :email');
    // Bind value
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Edit User by ID
  public function editUserById($id, $data)
  {
    $this->db->query('UPDATE customer SET CustName = :name, CustEmail = :email, CustPhoneNo= :phone_number, CustPassword= :password WHERE CustID = :id');
    // Bind value
    $this->db->bind(':id', $id);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':phone_number', $data['phone_number']);
    $this->db->bind(':password', $data['password']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
