<?php
require_once ('koneksi.php');

$nama_depan = isset($_REQUEST['nama_depan']) ? $_REQUEST['nama_depan'] : '';
$nama_belakang = isset($_REQUEST['nama_belakang']) ? $_REQUEST['nama_belakang'] : '';
$no_hp = isset($_REQUEST['no_hp']) ? $_REQUEST['no_hp'] : '';
$gender = isset($_REQUEST['gender']) ? $_REQUEST['gender'] : '';
$jenjang = isset($_REQUEST['jenjang']) ? $_REQUEST['jenjang'] : '';
$membaca = isset($_REQUEST['membaca']) ? $_REQUEST['membaca'] : '';
$menulis = isset($_REQUEST['menulis']) ? $_REQUEST['menulis'] : '';
$menggambar = isset($_REQUEST['menggambar']) ? $_REQUEST['menggambar'] : '';
$alamat = isset($_REQUEST['alamat']) ? $_REQUEST['alamat'] : '';
$submit = isset($_REQUEST['submit']) ? $_REQUEST['submit'] : '';

$errors = [];

    if(!empty($submit)) 
        {
            validate($nama_depan, "nama depan tidak boleh kosong", $errors);
            validate($nama_belakang, "nama depan tidak boleh kosong", $errors);
            validate($no_hp, "nama depan tidak boleh kosong", $errors);
            validate($gender, "nama depan tidak boleh kosong", $errors);
            validate($alamat, "nama depan tidak boleh kosong", $errors);

            if(empty($membaca) && empty($menulis) && empty($menggambar)) 
            {
                $errors [] = "hobi harus dipilih minimal satu";
            }


            if(empty($errors)) 
            {
                $hobies = [];

                if(!empty($membaca)) 
                { $hobies [] = $membaca;}

                if(!empty($menulis)) 
                { $hobies [] = $menulis;}

                if(!empty($menggambar)) 
                { $hobies [] = $menggambar;}

                $hobi = implode(",", $hobies);

                $sql = "INSERT INTO student VALUES (NULL, '{$nama_depan}', '{$nama_belakang}', '{$no_hp}', '{$gender}', '{$jenjang}', '{$hobi}', '{$alamat}')";

                if($conn->query($sql)){
                session_start();
                $_session['message'] = "data berhasil ditambah";
            }
            }
        }

function validate($field, $message, &$errors)
    {if(empty($field))
        {$errors[] = $message;}
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Student</title>
    <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" 
        crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <h3>Add Student</h3>
        <div class="row">
            <div class="col-md-4">
                <form id="myForm" method="POST" action="add_students.php">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nama</span>
                        </div>
                        <input name="nama_depan" value="" type="text" class="form-control" placeholder="Nama Depan" />
                        <input name="nama_belakang"  value="" type="text" class="form-control" placeholder="Nama Belakang"  />
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">No HP</span>
                        </div>
                        <input name="no_hp"  value="" type="text" class="form-control" placeholder="No HP" />
                    </div>
                    <div class="form-group">
                        <h5>Gender</h5>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio"  class="form-check-input" name="gender" value="Pria">Pria
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio"  class="form-check-input" name="gender" value="Wanita">Wanita
                            </label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Jenjang</span>
                        </div>
                        <select class="custom-select" name="jenjang" id="jenjang">
                            <option value="TK">TK</option>
                            <option  value="SD">SD</option>
                            <option  value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <h5>Hobi</h5>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input  id="membaca" type="checkbox" class="form-check-input" name="membaca" value="Mambaca">Membaca
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input  id="menulis" type="checkbox" class="form-check-input" name="menulis" value="Menulis">Menulis
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input  id="menggambar" type="checkbox" class="form-check-input" name="menggambar" value="Menggambar">Menggambar
                            </label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Alamat</span>
                        </div>
                        <textarea name="alamat" type="text" class="form-control" placeholder="Masukan Alamat" rows="4"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <a href="list_students.php" 
                                    class="btn btn-outline btn-outline-success form-control">Back</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="btn btn-primary form-control" type="submit" 
                                    value="Submit" name="submit" id="submit">
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" 
    crossorigin="anonymous"></script>