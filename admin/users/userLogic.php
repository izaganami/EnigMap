<?php
// variable declaration. These variables will be used in the user form
$user_id = 0;
$role_id = NULL;
$username = "";
$email = "";
$password = "";
$passwordConf = "";
$profile_picture = "";
$score = "";
$time = "";
$isEditing = false;
$users = array();
$errors = array();

function getAllRoles(){
    global $conn;
    $sql = "SELECT id, name FROM roles";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $roles = $result->fetch_all(MYSQLI_ASSOC);
    return $roles;
}
// ACTION: update user
if (isset($_POST['update_user'])) { // if user clicked update_user button ...
    $user_id = $_POST['user_id'];
    updateUser($user_id);
}
// ACTION: Save User
if (isset($_POST['save_user'])) {  // if user clicked save_user button ...
    saveUser();
}
// ACTION: fetch user for editting
if (isset($_GET["edit_user"])) {
    $user_id = $_GET["edit_user"];
    editUser($user_id);
}
// ACTION: Delete user
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    deleteUser($user_id);
}

function updateUser($user_id) {
    global $conn, $errors, $username, $role_id, $email, $isEditing;
    $errors = validateUser($_POST, ['update_user', 'update_profile']);

    // receive all input values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypt the password before saving in the database
    $profile_picture = uploadProfilePicture();
    if (count($errors) === 0) {
        if (isset($_POST['role_id'])) {
            $role_id = $_POST['role_id'];
        }
        $sql = "UPDATE users SET username=?, role_id=?, email=?, password=?, profile_picture=? WHERE id=?";
        $result = modifyRecord($sql, 'sisssi', [$username, $role_id, $email, $password, $profile_picture, $user_id]);

        if ($result) {
            $_SESSION['success_msg'] = "User account successfully updated";
            header("location: " . BASE_URL . "admin/users/userList.php");
            exit(0);
        }
    } else {
        // continue editting if there were errors
        $isEditing = true;
    }
}
// Save user to database
function saveUser(){
    global $conn, $errors, $username, $role_id, $email, $isEditing;
    $errors = validateUser($_POST, ['save_user']);
    // receive all input values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypt the password before saving in the database
    $profile_picture = uploadProfilePicture(); // upload profile picture and return the picture name
    if (count($errors) === 0) {
        if (isset($_POST['role_id'])) {
            $role_id = $_POST['role_id'];
        }
        $sql = "INSERT INTO users SET username=?, role_id=?, email=?, password=?, profile_picture=?";
        $result = modifyRecord($sql, 'sisss', [$username, $role_id, $email, $password, $profile_picture]);

        if($result){
            $_SESSION['success_msg'] = "User account created successfully";
            header("location: " . BASE_URL . "admin/users/userList.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save user in Database";
        }
    }
}
function getAdminUsers(){
    global $conn;
    // for every user, select a user role name from roles table, and then id, role_id and username from user table
    // where the role_id on user table matches the id on roles table
    $sql = "SELECT r.name as role, u.id, u.role_id, u.username
          FROM users u
          LEFT JOIN roles r ON u.role_id=r.id
          WHERE role_id IS NOT NULL AND u.id != ?";

    $users = getMultipleRecords($sql, 'i', [$_SESSION['user']['id']]);
    return $users;
}

function editUser($user_id){
    global $conn, $user_id, $role_id, $username, $email, $isEditing, $profile_picture;

    $sql = "SELECT * FROM users WHERE id=?";
    $user = getSingleRecord($sql, 'i', [$user_id]);

    $user_id = $user['id'];
    $role_id = $user['role_id'];
    $username = $user['username'];
    $profile_picture = $user['profile_picture'];
    $email = $user['email'];
    $isEditing = true;
}
function deleteUser($user_id) {
    global $conn;
    $sql = "DELETE FROM users WHERE id=?";
    $result = modifyRecord($sql, 'i', [$user_id]);

    if ($result) {
        $_SESSION['success_msg'] = "User trashed!!";
        header("location: " . BASE_URL . "admin/users/userList.php");
        exit(0);
    }
}