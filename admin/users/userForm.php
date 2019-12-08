<?php include('../../config.php'); ?>
<?php include(INCLUDE_PATH . '/logic/common_functions.php') ?>
<?php include(ROOT_PATH . '/admin/users/userLogic.php'); ?>
<?php $roles = getAllRoles(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>UserAccounts - Create Admin user Account</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <!-- Custome styles -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<?php include(INCLUDE_PATH . "/layouts/admin_navbar.php") ?>
<div class="container" style="margin-bottom: 150px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <a href="userList.php" class="btn btn-primary" style="margin-bottom: 5px;">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Users
            </a>
            <br>

            <form class="form" action="userForm.php" method="post" enctype="multipart/form-data">
                <?php if ($isEditing === true ): ?>
                    <h2 class="text-center">Update Admin user</h2>
                <?php else: ?>
                    <h2 class="text-center">Create Admin user</h2>
                <?php endif; ?>
                <hr>
                <!-- if editting user, we need that user's id -->
                <?php if ($isEditing === true): ?>
                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                <?php endif; ?>
                <div class="form-group <?php echo isset($errors['username']) ? 'has-error' : '' ?>">
                    <label class="control-label">Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>" class="form-control">
                    <?php if (isset($errors['username'])): ?>
                        <span class="help-block"><?php echo $errors['username'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group <?php echo isset($errors['email']) ? 'has-error' : '' ?>">
                    <label class="control-label">Email Address</label>
                    <input type="email" name="email" value="<?php echo $email; ?>" class="form-control">
                    <?php if (isset($errors['email'])): ?>
                        <span class="help-block"><?php echo $errors['email'] ?></span>
                    <?php endif; ?>
                </div>
                <?php if ($isEditing === true ): ?>
                    <div class="form-group <?php echo isset($errors['passwordOld']) ? 'has-error' : '' ?>">
                        <label class="control-label">Old Password</label>
                        <input type="password" name="passwordOld" class="form-control">
                        <?php if (isset($errors['passwordOld'])): ?>
                            <span class="help-block"><?php echo $errors['passwordOld'] ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="form-group <?php echo isset($errors['password']) ? 'has-error' : '' ?>">
                    <label class="control-label">Your Password</label>
                    <input type="password" name="password" class="form-control">
                    <?php if (isset($errors['password'])): ?>
                        <span class="help-block"><?php echo $errors['password'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group <?php echo isset($errors['role_id']) ? 'has-error' : '' ?>">
                    <label class="control-label">User Role</label>
                    <select class="form-control" name="role_id">
                        <option value="" ></option>
                        <?php foreach ($roles as $role): ?>
                            <?php if ($role['id'] === $role_id): ?>
                                <option value="<?php echo $role['id'] ?>" selected><?php echo $role['name'] ?></option>
                            <?php else: ?>
                                <option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['role_id'])): ?>
                        <span class="help-block"><?php echo $errors['role_id'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group" style="text-align: center;">
                    <?php if (!empty($profile_picture)): ?>
                        <img src="<?php echo BASE_URL . '/assets/images/' . $profile_picture; ?>" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
                    <?php else: ?>
                        <img src="http://via.placeholder.com/150x150" id="profile_img" style="height: 100px; border-radius: 50%" alt="">
                    <?php endif; ?>
                    <input type="file" name="profile_picture" id="profile_input" value="" style="display: none;">
                </div>
                <div class="form-group">
                    <?php if ($isEditing === true): ?>
                        <button type="submit" name="update_user" class="btn btn-success btn-block btn-lg">Update user</button>
                    <?php else: ?>
                        <button type="submit" name="save_user" class="btn btn-success btn-block btn-lg">Save user</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include(INCLUDE_PATH . "/layouts/footer.php") ?>
<script type="text/javascript" src="../../assets/js/display_profile_image.js"></script>