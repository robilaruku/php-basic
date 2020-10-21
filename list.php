<?php
    require_once ('koneksi.php');

    $page = isset ($_GET ['page'])?$_GET ['page']:1;
    $jenjang = isset ($_GET ['jenjang'])?$_GET ['jenjang']:'';
    $gender = isset ($_GET ['gender'])?$_GET ['gender']:'';
    $keyword = isset ($_GET ['keyword'])?$_GET ['keyword']:'';
    $sor = isset ($_GET ['sort'])?$_GET ['sort']:'';

    const NUM_ROWS = 5;
    $offset = ($page - 1) *NUM_ROWS;

    $where = [];

    if(!empty($jenjang)) {
    $where[]="jenjang= '{$jenjang}'";
    }

    if(!empty($gender)) {
    $where[]="gender= '{$gender}'";
    }
    
    if(!empty($keyword)) {
    $where[]="nama_depan LIKE '%{$keyword}%' OR nama_belakang LIKE '%{$keyword}%' OR no_hp LIKE '%{$keyword}%' OR alamat LIKE '%{$keyword}%'";
    }

    $total_rows = getTotalRows($where);
    $number_of_pages = ceil ($total_rows / NUM_ROWS);

    


    $sql = "select * From Student";
    if (!empty($where)){
        $sql = $sql.'WHERE' .implode("AND", $where);
    }
    if (!empty($sort)) {
        $sql=$sql."Order by {$sort} ASC";
    }
    $sql=$sql."LIMIT {$offset},".NUM_ROWS;

    $result = $conn->query($sql);

    $student = [];

    while($row = $result->fetch_assoc()) {
        $student[] = $row;
    }

    session_start();
    if(isset($_SESSION['message'])){
        session_unset();
        session_destroy();
    }

    function getTotalRows($where) {
        global $conn;
        $sql = "SELECT COUNT(*) total FROM student";

        if(!empty($where)) {
            $sql = $sql." WHERE ".implode(" AND ", $where);
        }

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        
        return $row['total'];
    }



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"
        integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
</head>

<body>
    <div class="container-fluid" >
        <div class="row">
            <div class="col-md-6">
                <h3>Student List</h3>
                <div class="row" style="margin-bottom:16px;">
                    <div class="col-md-12">
                        <a href="add_student.php" class="btn btn-sm btn-outline btn-outline-primary float-right">
                            <i class="fas fa-plus"></i>&nbsp;Add Student
                        </a>
                    </div>
                </div>

                <hr>

                <form action="list_student.php" method="get">
                    <input type="hidden" name="sort" value="<?php echo $sort; ?>">
                    <div class="row" style="margin-bottom:10px;">
                        <div class="col-md-3">
                            <select class="form-control" name="jenjang" id="jenjang">
                                <option value="">Pilih Jenjang</option>
                                <option value="TK" <?php echo $jenjang=='TK'?'selected':'';?>>TK</option>
                                <option value="SD" <?php echo $jenjang=='SD'?'selected':'';?>>SD</option>
                                <option value="SMP" <?php echo $jenjang=='SMP'?'selected':'';?>>SMP</option>
                                <option value="SMA" <?php echo $jenjang=='SMA'?'selected':'';?>>SMA</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" name="gender" id="gender">
                                <option value="">Pilih Gender</option>
                                <option value="Pria" <?php echo $gender=='Pria'?'selected':'';?>>Pria</option>
                                <option value="Wanita" <?php echo $gender=='Wanita'?'selected':'';?>>Wanita</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input name="keyword" value="<?php echo $keyword?>" placeholder="Search here..." 
                                type="text" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn btn-info w-100" value="Search">
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:10px;">
                        <div class="col-md-12"><a href="list_student.php">Reset</a></div>
                    </div>
                </form>

                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</a></th>
                            <th width="20%">No_HP</a></th>
                            <th width="10%">Gender</th>
                            <th width="15%">Jenjang</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($student as $student) { ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['nama_depan'].' '.$student['nama_belakang']; ?></td>
                            <td><?php echo $student['no_hp']; ?></td>
                            <td><?php echo $student['gender']; ?></td>
                            <td><?php echo $student['jenjang']; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info btn-sm" href=""><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-success btn-sm" href="#"><i class="fas fa-pencil-alt"></i></a>
                                    <a class="btn btn-danger btn-sm" href="#"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12">
                        <?php if($total_rows > 0){ ?>
                        <span>Showing <?php echo $offset + 1; ?> to <?php echo $offset + sizeof($student); ?> from <?php echo $total_rows; ?> entries</span>
                        <?php } else { ?>
                        <span>No result</span>
                        <?php }?>
                        <ul class="pagination float-right">
                            <?php
                                $prev = 1;
                                $next = $number_of_pages;

                                if($page > 1) {
                                    $prev = $page - 1;
                                }

                                if($page < $number_of_pages) {
                                    $next = $page + 1;
                                }
                            ?>

                            <li class="page-item <?php echo $page==1?'disabled':'' ?>">
                                <a class="page-link" href="list_student.php?jenjang=<?php echo $jenjang?>&gender=<?php echo $gender?>&keyword=<?php echo $keyword?>&sort=<?php echo $sort;?>&page=<?php echo $prev?>">Previous</a>
                            </li>

                            <?php for($i = 0; $i < $number_of_pages; $i++) {?>
                                <li class="page-item <?php echo $page==($i+1)?'active':'' ?>">
                                    <a class="page-link" href="list_student.php?jenjang=<?php echo $jenjang?>&gender=<?php echo $gender?>&keyword=<?php echo $keyword?>&sort=<?php echo $sort;?>&page=<?php echo $i+1?>"><?php echo $i+1?></a>
                                </li>
                            <?php }?>
                            
                            <li class="page-item  <?php echo $page==$number_of_pages?'disabled':'' ?>">
                                <a class="page-link" href="list_student.php?jenjang=<?php echo $jenjang?>&gender=<?php echo $gender?>&keyword=<?php echo $keyword?>&sort=<?php echo $sort;?>&page=<?php echo $next?>">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
</script>