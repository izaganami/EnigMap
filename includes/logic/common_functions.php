<?php
// Accept a user ID and returns true if user is admin and false if otherwise
function isAdmin($user_id) {
    global $conn;
    $sql = "SELECT * FROM users WHERE id=? AND role_id IS NOT NULL LIMIT 1";
    $user = getSingleRecord($sql, 'i', [$user_id]); // get single user from database
    if (!empty($user)) {
        return true;
    } else {
        return false;
    }
}
function loginById($user_id) {
    global $conn;
    $sql = "SELECT u.id, u.role_id, u.username, r.name as role FROM users u LEFT JOIN roles r ON u.role_id=r.id WHERE u.id=? LIMIT 1";
    $user = getSingleRecord($sql, 'i', [$user_id]);

    if (!empty($user)) {
        // put logged in user into session array
        $_SESSION['user'] = $user;
        $_SESSION['success_msg'] = "You are now logged in";
        // if user is admin, redirect to dashboard, otherwise to homepage
        if (isAdmin($user_id)) {
            $permissionsSql = "SELECT p.name as permission_name FROM permissions as p
                            JOIN permission_role as pr ON p.id=pr.permission_id
                            WHERE pr.role_id=?";
            $userPermissions = getMultipleRecords($permissionsSql, "i", [$user['role_id']]);
            $_SESSION['userPermissions'] = $userPermissions;
            header('location: ' . BASE_URL . 'admin/dashboard.php');
        } else {
            header('location: ' . BASE_URL . 'index.php');
        }
        exit(0);
    }
}

// Accept a user object, validates user and return an array with the error messages
function validateUser($user, $ignoreFields) {
    global $conn;
    $errors = [];
    // password confirmation
    if (isset($user['passwordConf']) && ($user['password'] !== $user['passwordConf'])) {
        $errors['passwordConf'] = "The two passwords do not match";
    }
    // if passwordOld was sent, then verify old password
    if (isset($user['passwordOld']) && isset($user['user_id'])) {
        $sql = "SELECT * FROM users WHERE id=? LIMIT 1";
        $oldUser = getSingleRecord($sql, 'i', [$user['user_id']]);
        $prevPasswordHash = $oldUser['password'];
        if (!password_verify($user['passwordOld'], $prevPasswordHash)) {
            $errors['passwordOld'] = "The old password does not match";
        }
    }
    // the email should be unique for each user for cases where we are saving admin user or signing up new user
    if (in_array('save_user', $ignoreFields) || in_array('signup_btn', $ignoreFields)) {
        $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
        $oldUser = getSingleRecord($sql, 'ss', [$user['email'], $user['username']]);
        if (!empty($oldUser['email']) && $oldUser['email'] === $user['email']) { // if user exists
            $errors['email'] = "Email already exists";
        }
        if (!empty($oldUser['username']) && $oldUser['username'] === $user['username']) { // if user exists
            $errors['username'] = "Username already exists";
        }
    }

    // required validation
    foreach ($user as $key => $value) {
        if (in_array($key, $ignoreFields)) {
            continue;
        }
        if (empty($user[$key])) {
            $errors[$key] = "This field is required";
        }
    }
    return $errors;
}
// upload's user profile profile picture and returns the name of the file
function uploadProfilePicture()
{
    // if file was sent from signup form ...
    if (!empty($_FILES) && !empty($_FILES['profile_picture']['name'])) {
        // Get image name
        $profile_picture = date("Y.m.d") . $_FILES['profile_picture']['name'];
        // define Where image will be stored
        $target = ROOT_PATH . "/assets/images/" . $profile_picture;
        // upload image to folder
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
            return $profile_picture;
            exit();
        }else{
            echo "Failed to upload image";
        }
    }
}


// Accept a post object, validates post and return an array with the error messages
function validateRole($role, $ignoreFields) {
    global $conn;
    $errors = [];
    foreach ($role as $key => $value) {
        if (in_array($key, $ignoreFields)) {
            continue;
        }
        if (empty($role[$key])) {
            $errors[$key] = "This field is required";
        }
    }
    return $errors;
}