
<?php include "sidebar.php"?>
<?php define("Root", dirname(__DIR__)); require_once Root."\backend\student.php"; ?>
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
                                    <li class="active">View Data</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="animated fadeIn">
                            
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Student Data</strong>
                        </div>
                        <div class="card-body">
                        <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">address</th>
      <th scope="col">gender</th>
      <th scope="col">code</th>
      <th scope="col">department</th>
      <th scope="col">skills</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($students)){ foreach($students as $value) {static $count=1; ?>
    <tr>
      <th scope="row"><?php echo $count;  $count++;?></th>
      <td><?=$value['name'] ?></td>
      <td><?=$value['address'] ?></td>
      <td><?=$value['gender'] ?></td>
      <td><?=$value['code'] ?></td>
      <td><?=$value['department'] ?></td>
      <td> <?php $code=$value['code'];$s=$conect->query("SELECT skill FROM skills where std_code=$code"); 
      $skills=$s->fetchAll(PDO::FETCH_ASSOC);  foreach($skills as $skill) { echo $skill['skill']."<br>";}?>
    </td>
    </tr>
    <?php  } }?>
  </tbody>
</table>
                        </table>

                    </div>
                </div>
            </div>
          
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<div class="clearfix"></div>

<?php  @include_once "footer.php" ?>