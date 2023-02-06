<?php
ob_start();
define("Root", dirname(__DIR__));
include "sidebar.php" ;
require Root . "\backend\connection.php";
require Root . "\backend\\validate.php";
$vaild = new validate();

if(isset($_GET['code'])){
    $code=$_GET['code'];
}else{
    echo "<h1 align='center'>wrong page !!!!</h1>";
    exit();
}
$std_result=$conect->query("select * from students where code=$code");
$std_data=$std_result->fetch(PDO::FETCH_ASSOC);
$dept_result=$conect->query("select * from departments");
$dept_data=$dept_result->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['edit'])){
    $name=$vaild->validation($_POST['name']);
    $email=$vaild->validation($_POST['email']);
    $code=$vaild->validation($_POST['code']);
    $age=$vaild->validation($_POST['age']);
    $phone=$vaild->validation($_POST['phone']);
    $department=$_POST['department'];


    $vaild->check_int($department, 'dept_int', "the department must be only numbers");
    if (!empty($age)) {
        $vaild->check_int($age, 'age_int', "the age must be only numbers");
    }

    //name validation
    $vaild->valid_name($name);
    $name = strtolower($name);
    $name = ucwords($name);
    // code validation
if (empty($code)) {
    $vaild->errors ['code_required'] = "please enter your code..";
}else {
    $vaild->check_int($code, 'code_int', "the code must be only numbers");
        }

    if (empty($department)) {
        $vaild->errors['department_required'] = "please enter your department..";
    }
    //email validation
  if (empty($email)) {
    $vaild->errors['email_required'] = "please enter your email..";
   }
  else{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $vaild->errors['emailErr'] = "Invalid email format";
    }
    }
    //phone validation
if (empty($phone)) {
    $vaild->errors['phone_required'] = "please enter your phone..";
}else {

    if (strlen($phone) != 11) {
        $vaild->errors['length'] = "the length must be exactly 11";
    }
}

    if (!filter_var($age, FILTER_VALIDATE_INT)) {
        $vaild->errors['age'] = "only numbers";
    }
//print_r($vaild->errors);

if (empty($vaild->errors)) {
    $result = $conect->query("UPDATE `students` SET `name`='$name',`age`=$age,`phone`='$phone',`code`=$code,`email`='$email',`dept_num`='$department' WHERE code=$code");
    if ($result) {
        header("location: index.php");
    }
}
}



?>
<div class="content">
    <div class="animated fadeIn">


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Edit Student</strong>
                    </div>
                    <div class="card-body card-block">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Code</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" name="code" placeholder="Text" class="form-control" value="<?php echo $std_data['code'] ?>">
                                    <?php if(isset($errors['code_required'])){ ?>
                                        <small class="form-text text-muted" style="color:red !important"><?php echo $errors['code_required'] ?></small>
                                    <?php } ?>
                                    <?php if(isset($errors['code_unique'])){ ?>
                                        <small class="form-text text-muted" style="color:red !important"><?php echo $errors['code_unique'] ?></small>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="text-input" name="name" placeholder="Text" class="form-control" value="<?php echo $std_data['name'] ?>">
                                    <?php if(isset($vaild->errors['letters'])){ ?>
                                        <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['letters'] ?></small>
                                    <?php } ?>

                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Age</label></div>
                                <div class="col-12 col-md-9"><input type="number" id="text-input" name="age" placeholder="Text" class="form-control" value="<?php echo $std_data['age'] ?>"><small class="form-text text-muted">This is a help text</small></div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Phone</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="text-input" name="phone" placeholder="Text" class="form-control" value="<?php echo $std_data['phone'] ?>">
                                    <?php if(isset($vaild->errors['phone_required'])){ ?>
                                        <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['phone_required'] ?></small>
                                    <?php } ?>

                                    <?php if(isset($vaild->errors['length'])){ ?>
                                    <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['length'] ?></small>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">email</label></div>
                                <div class="col-12 col-md-9"><input type="text" id="text-input" name="email" placeholder="Email" class="form-control" value="<?php echo $std_data['email'] ?>">

                                    <?php if(isset($vaild->errors['email_required'])){ ?>
                                        <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['email_required'] ?></small>
                                    <?php } ?>

                                    <?php if(isset($vaild->errors['emailErr'])){ ?>
                                        <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['emailErr'] ?></small>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="select" class=" form-control-label">Select</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="department" id="select" class="form-control">
                                        <?php foreach($dept_data as $dept){ ?>
                                            <option value="<?php echo $dept['number'] ?>" <?php if($dept['number'] == $std_data['dept_num']){ ?> selected <?php } ?>> <?php echo $dept['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm" name="edit">
                                    <i class="fa fa-dot-circle-o"></i> Edit
                                </button>
                                <button type="reset" class="btn btn-danger btn-sm">
                                    <i class="fa fa-ban"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div></div>

    <?php
    @include_once "footer.php";
    ob_end_flush();
    ?>
