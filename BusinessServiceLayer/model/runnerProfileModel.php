
<?php
// Author: Firdaus
// model that holds runner details and methods to edit and find runner details
require_once '../../../libs/profileDB.php';
class runnerProfileModel
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  // Find user by email
  public function findUserByEmail($email)
  {
    $this->db->query('SELECT * FROM runner WHERE RunnerEmail = :email');
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
    $this->db->query('SELECT * FROM runner WHERE RunnerID = :id');
    // Bind value
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }

  // // Get All Users
  public function getAllRunners()
  {
    $this->db->query('SELECT * FROM runner ORDER BY RunnerID DESC');
    // Bind value

    $row = $this->db->resultSet();

    return $row;
  }

  // Edit User by ID
  public function editUserById($id, $data)
  {
    $this->db->query('UPDATE runner SET RunnerName = :name, RunnerEmail = :email, RunnerPhoneNo= :phone_number, RunnerPassword = :password, RunnerAddress = :address, RunnerPlateNo=:plate_number, RunnerICNo=:ic_no WHERE RunnerID = :id');

    // Bind value
    $this->db->bind(':id', $id);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':phone_number', $data['phone_number']);
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':address', $data['address']);
    $this->db->bind(':plate_number', $data['plate_number']);
    $this->db->bind(':ic_no', $data['ic_no']);

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
    $this->db->query('UPDATE runner SET RunnerName = :name, RunnerEmail = :email, RunnerPhoneNo= :phone_number, RunnerPassword = :password, RunnerAddress = :address, RunnerPlateNo=:plate_number, RunnerICNo=:ic_no, RunnerRegStatus =:status, RunnerRegComment=:comment  WHERE RunnerID = :id');

    // Bind value
    $this->db->bind(':id', $id);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':phone_number', $data['phone_number']);
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':address', $data['address']);
    $this->db->bind(':plate_number', $data['plate_number']);
    $this->db->bind(':ic_no', $data['ic_no']);
    $this->db->bind(':status', "PENDING");
    $this->db->bind(':comment', "Please wait 1-2 days for us to validate your account");

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function validateRunnerByID($id, $data)
  {
    $this->db->query('UPDATE runner SET RunnerRegStatus = :status, RunnerRegComment = :comment WHERE RunnerID = :id');
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
