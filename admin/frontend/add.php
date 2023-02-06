<?php
ob_start();
include "sidebar.php" ?>

<?php define("Root", dirname(__DIR__));

require  Root. "\backend\connection.php";
require  Root. "\backend\\validate.php";
$vaild=new validate();
$dept_result=$vaild->conect->query("select * from departments");
$dept_data=$dept_result->fetchAll(PDO::FETCH_ASSOC);

//data
if (isset($_POST['add'])) {
    $name = $vaild->validation($_POST['name']);
    $email =$vaild->validation($_POST['email']);
    $password = $_POST['password'];
    $code = $vaild->validation($_POST['code']);
    $age  =$vaild->validation($_POST['age']);
    $phone  =$vaild->validation($_POST['phone']);
    $department = $_POST['department'];
    $skills=$_POST['skills'];
    $image_name=$_FILES['image']['name'];
    $image_temp=$_FILES['image']['tmp_name'];
    $image_name=$code.$image_name;
    $image_path="upload/images/$image_name";
    $allowed_ext=['png','jpg','jpeg'];
    $str_arr=explode('.',$image_name);
   $ext=end($str_arr);
//   echo  "<pre>";
//   print_r($skills);
   if(! in_array($ext,$str_arr)){
       $vaild->errors['image']="not allowed ext...";
   }


    $vaild->check_int($department, 'dept_int', "the department must be only numbers");
    if (!empty($age)) {
        $vaild->check_int($age, 'age_int', "the age must be only numbers");
    }

     //name validation
    $vaild->valid_name($name);
    $name = strtolower($name);
    $name = ucwords($name);
    // code validation
    $vaild->valid_code($code);
   // password validation
    $vaild->valid_pass($password);
    $password = sha1($password);
    if (empty($department)) {
        $vaild->errors['department_required'] = "please enter your department..";
    }
    //email validation
    $vaild->valid_email($email);
    //phone validation
    $vaild->valid_phone($phone);

    if (!filter_var($age, FILTER_VALIDATE_INT)) {
        $vaild->errors['age'] = "only numbers";
    }




    if (empty($vaild->errors)) {
        foreach ($skills as $skill){
            $vaild->conect->query("INSERT INTO skills (`std_code`,`skill`) VALUES ('$code','$skill' )");
        }

        move_uploaded_file($image_temp,$image_path);
        $result = $vaild->conect->query("INSERT INTO `students`(`name`, `age`, `phone`, `code`, `dept_num`,`email`,`password`,`image`) VALUES ('$name',$code,'$phone','$code','$department','$email','$password','$image_path')");
   header('location:index.php');
    }

}
//print_r($vaild->errors)

?>
    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>college</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">college</a></li>
                                <li><a href="#">student</a></li>
                                <li class="active">insert Data</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="animated fadeIn">


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Add Student</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Code</label></div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="code" placeholder="Text" class="form-control">
                                        <?php if(isset($vaild->errors['code_required'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['code_required'] ?></small>
                                        <?php } ?>
                                        <?php if(isset($vaild->errors['code_int'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['code_int'] ?></small>
                                        <?php } ?>
                                        <?php if(isset($vaild->errors['code_unique'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['code_unique'] ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="text-input" name="name" placeholder="Text" class="form-control"> <?php if(isset($vaild->errors['letters'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['letters'] ?></small>
                                        <?php } ?>


                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Age</label></div>
                                    <div class="col-12 col-md-9"><input type="number" id="text-input" name="age" placeholder="Text" class="form-control">
                                        <?php if(isset($vaild->errors['age'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['age'] ?></small>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Phone</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="text-input" name="phone" placeholder="Text" class="form-control">     <?php if(isset($vaild->errors['phone_required'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['phone_required'] ?></small>
                                        <?php } ?>
                                        <?php if(isset($vaild->errors['phone_unique'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['phone_unique'] ?></small>
                                        <?php } ?>
                                        <?php if(isset($vaild->errors['length'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['length'] ?></small>
                                        <?php } ?>
                                    </div>

                                </div>


                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">email</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="text-input" name="email" placeholder="Email" class="form-control"> <?php if(isset($vaild->errors['email_required'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['email_required'] ?></small>
                                        <?php } ?>
                                        <?php if(isset($vaild->errors['email_unique'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['email_unique'] ?></small>
                                        <?php } ?>
                                        <?php if(isset($vaild->errors['emailErr'])){ ?>
                                            <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['emailErr'] ?></small>
                                        <?php } ?>

                                    </div>


                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Password</label></div>
                                    <div class="col-12 col-md-9"><input type="password" id="text-input" name="password" placeholder="Text" class="form-control">

                                        <?php if(isset($vaild->errors['pass_invalid'])){ ?>
                                        <small class="form-text text-muted" style="color:red !important"><?php echo $vaild->errors['pass_invalid'] ?></small>
                                        <?php } ?>

                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">image</label></div>
                                    <div class="col-12 col-md-9"><input type="file" id="text-input" name="image" placeholder="Text" class="form-control">
                                        <?php if(isset($errors['image'])){ ?>
                                            <small class="form-text text-muted"><?php echo $errors['image'] ?></small>
                                        <?php } ?>
                                    </div>
                                    </div>

                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">skills</label></div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault" name="skills[]"  value="mysql">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        MYSQL
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckChecked"  name="skills[]" value="php">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        PHP
                                    </label>
                                </div>


                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  id="flexCheckChecked" name="skills[]" value="laravel">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Laravel
                                    </label>
                                </div>
                                </div>




                                    <div class="row form-group">
                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Select</label></div>
                                    <div class="col-12 col-md-9">
                                        <select name="department" id="select" class="form-control">
                                            <?php foreach($dept_data as $dept){ ?>
                                                <option value="<?php echo $dept['number'] ?>"><?php echo $dept['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm" name="add">
                                        <i class="fa fa-dot-circle-o"></i> Submit
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
    </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>

<?php @include_once "footer.php" ;
   ob_end_flush();?>