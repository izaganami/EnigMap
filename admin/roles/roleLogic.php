<?php
$role_id = 0;
$name = "";
$description = "";
$isEditting = false;
$roles = array();
$errors = array();

// ACTION: update role
if (isset($_POST['update_role'])) {
    $role_id = $_POST['role_id'];
    updateRole($role_id);
}
// ACTION: Save Role
if (isset($_POST['save_role'])) {
    saveRole();
}
// ACTION: fetch role for editting
if (isset($_GET["edit_role"])) {
    $role_id = $_GET['edit_role'];
    editRole($role_id);
}
// ACTION: Delete role
if (isset($_GET['delete_role'])) {
    $role_id = $_GET['delete_role'];
    deleteRole($role_id);
}
// Save role to database
function saveRole(){
    global $conn, $errors, $name, $description;
    $errors = validateRole($_POST, ['save_role']);
    if (count($errors) === 0) {
        // receive form values
        $name = $_POST['name'];
        $description = $_POST['description'];
        $sql = "INSERT INTO roles SET name=?, description=?";
        $result = modifyRecord($sql, 'ss', [$name, $description]);

        if ($result) {
            $_SESSION['success_msg'] = "Role created successfully";
            header("location: " . BASE_URL . "admin/roles/roleList.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save role in Database";
        }
    }
}
function updateRole($role_id){
    global $conn, $errors, $name, $isEditting; // pull in global form variables into function
    $errors = validateRole($_POST, ['update_role']); // validate form
    if (count($errors) === 0) {
        // receive form values
        $name = $_POST['name'];
        $description = $_POST['description'];
        $sql = "UPDATE roles SET name=?, description=? WHERE id=?";
        $result = modifyRecord($sql, 'ssi', [$name, $description, $role_id]);

        if ($result) {
            $_SESSION['success_msg'] = "Role successfully updated";
            $isEditting = false;
            header("location: " . BASE_URL . "admin/roles/roleList.php");
            exit(0);
        } else {
            $_SESSION['error_msg'] = "Something went wrong. Could not save role in Database";
        }
    }
}
function editRole($role_id){
    global $conn, $name, $description, $isEditting;
    $sql = "SELECT * FROM roles WHERE id=? LIMIT 1";
    $role = getSingleRecord($sql, 'i', [$role_id]);

    $role_id = $role['id'];
    $name = $role['name'];
    $description = $role['description'];
    $isEditting = true;
}
function deleteRole($role_id) {
    global $conn;
    $sql = "DELETE FROM roles WHERE id=?";
    $result = modifyRecord($sql, 'i', [$role_id]);
    if ($result) {
        $_SESSION['success_msg'] = "Role trashed!!";
        header("location: " . BASE_URL . "admin/roles/roleList.php");
        exit(0);
    }
}
function getAllRoles(){
    global $conn;
    $sql = "SELECT id, name FROM roles";
    $roles = getMultipleRecords($sql);
    return $roles;
}