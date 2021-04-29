
<?php
// Author: Firdaus
// model that holds service provider details and methods to edit and find service provider details
require_once '../../../libs/profileDB.php';
class serviceProviderProfileModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }


  // Find user by email
  public function findUserByEmail($email)
  {
    $this->db->query('SELECT * FROM service_provider WHERE SpEmail = :email');
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

  // // Get User by ID
  public function getUserById($id)
  {
    $this->db->query('SELECT * FROM service_provider WHERE SpID = :id');
    // Bind value
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }

  // // Get All Users
  public function getAllServiceProviders()
  {
    $this->db->query('SELECT * FROM service_provider ORDER BY SpID DESC');
    // Bind value

    $row = $this->db->resultSet();

    return $row;
  }

  // Edit User by ID
  public function editUserById($id, $data)
  {
    $this->db->query('UPDATE service_provider SET SpName = :name, SpEmail = :email, SpPhoneNo= :phone_number, SpPassword = :password, SpAddress = :address, SpRegID=:reg_no, SpType=:type WHERE SpID = :id');

    // Bind value
    $this->db->bind(':id', $id);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':phone_number', $data['phone_number']);
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':address', $data['address']);
    $this->db->bind(':reg_no', $data['reg_no']);
    $this->db->bind(':type', $data['type']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Reapply User by ID
  public function reapplyUserById($id, $data)
  {
    $this->db->query('UPDATE service_provider SET SpName = :name, SpEmail = :email, SpPhoneNo= :phone_number, SpPassword = :password, SpAddress = :address, SpRegID=:reg_no, SpType=:type, SpRegStatus =:status, SpRegComment=:comment  WHERE SpID = :id');

    // Bind value
    $this->db->bind(':id', $id);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':phone_number', $data['phone_number']);
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':address', $data['address']);
    $this->db->bind(':reg_no', $data['reg_no']);
    $this->db->bind(':type', $data['type']);
    $this->db->bind(':status', "PENDING");
    $this->db->bind(':comment', "Please wait 1-2 days for us to validate your account");

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function validateServiceProviderByID($id, $data)
  {
    $this->db->query('UPDATE service_provider SET SpRegStatus = :status, SpRegComment = :comment WHERE SpID = :id');
    // Bind value
    $this->db->bind(':id', $id);
    $this->db->bind(':status', $data['status']);
    $this->db->bind(':comment', $data['comment']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
