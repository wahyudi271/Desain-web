<?php
$server 	= "localhost";
$user		= "root";
$pass		= "";
$db			= "dblatihan";

$koneksi	= mysqli_connect($server,$user,$pass,$db);

if (!$koneksi) {
	die("Gagal Menghubungkan dengan Database");
}else{
	// echo "Berhasil Menghubungkan dengan Database";
}

$succes	=	"";
$error	= 	"";
if (isset($_GET['op'])) {
	$op = $_GET['op'];
}else {
	$op = "";
}
if ($op == 'edit') {
	$id 		= $_GET['id'];
	$sql		= "select*from tmhs where Id_mhs = '$id'";
	$q1			= mysqli_query($koneksi,$sql);
	$r1			= mysqli_fetch_array($q1);
	$tnim		= $r1['Nim'];
	$tnama		= $r1['Nama'];
	$talamat	= $r1['Alamat'];
	$tprodi		= $r1['Prodi'];
	if ($tnim == "") {
		$error = "Data tidak ditemukan";
	}
}elseif ($op == 'hapus') {
	$id 		= $_GET['id'];
	$sql	 	= "delete from tmhs where Id_mhs = '$id'";
	$q1 		= mysqli_query($koneksi,$sql);
	if ($q1) {
		$succes = "Berhasil Menghapus Data";
	}else {
		$error = "Gagal Menghapus Data";
	}
}
// jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {
	$tnim		= $_POST['tnim'];
	$tnama		= $_POST['tnama'];
	$talamat	= $_POST['talamat'];
	$tprodi		= $_POST['tprodi'];

	if ($tnim&&$tnama&&$talamat&&$tprodi) {
		if ($op == 'edit') {
			$sql1 		= "update thms set nim = '$tnim', nama = '$tnama', alamat = '$talamat', prodi='$tprodi' where Id_mhs='$id'";
			$q1 = mysqli_query($koneksi,$sql1);
			if ($q1) {
				$error = "Berhasil Mengubah Data";
			}else {
				$error = "Gagal Mengubah Data";
			}
		}else {
			$sql 		= "insert into tmhs(Nim, Nama, Alamat, Prodi) values('$tnim','$tnama','$talamat','$tprodi')";
			$q 			= mysqli_query($koneksi,$sql);
			if ($q) {
				$succes = "Berhasil Menambahkan data Baru";
			}else{
				$error	= "Gagal Menambahkan data Baru";
			}
		}	
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CRUD 2021 PHP & MYSQL +Bootstrap 4</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>

	<div class="container">
		<h1 class="text"align="center">CRUD PHP & MySQL + Bootstrap 4</h1>
		<h2 align="center">@Mencoba Hal Baru</h2>

		<!-- Awal card Form -->
		<div class="card mt-3">
			<div class="card-header bg-primary text-white ">
				Form Input Data Mahasiswa 
			</div>
			<?php
			if($error){
				?>
				<div class="alert alert-danger" role="alert">
					<?php echo $error ?>
				</div>
				<?php
			}
			?>
			<?php
			if($succes){
				?>
				<div class="alert alert-success" role="alert">
					<?php echo $succes ?>
				</div>
				<?php
			}
			?>
			<div class="card-body">
				<form method="POST" action="">
					<div class="form-group">
						<label>Nim</label>
						<input type="text" name="tnim" class="form-control" placeholder="Masukan Nim Anda " required>
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="tnama" class="form-control" placeholder="Masukan Nama Anda" required>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<textarea class="form-control" name="talamat" placeholder="Masukan Alamat Anda" required></textarea>
					</div>
					<div class="form-group" >
						<label>Program Studi</label>
						<select class="form-contr_ol" name="tprodi">
							<option>--Pilih--</option>
							<option>D3-Tps</option>
							<option>D3-Ppm</option>
							<option>D3-Tif</option>
							<option>D4-Abi</option>
						</select>
					</div>
					<button type="submit" class=" btn btn-success" name="bsimpan">Simpan</button>
					<button type="reset" class=" btn btn-danger" name="breset">kosongkan</button>
				</form>
			</div>
		</div>
		<!-- Akhir card From -->

		<!-- Awal card tabel -->
		<div class="card mt-3">
			<div class="card-header bg-success text-white">
				Daftar Mahasiswa 
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<tr>
						<th>No.</th>
						<th>Nim</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Program Studi</th>
						<th>Aksi</th>

					</tr>
					<?php
					$no =1;
					$tampil=mysqli_query($koneksi,"SELECT* from tmhs order by id_mhs desc");
					while($data = mysqli_fetch_array($tampil)):
						$id = $data['Id_mhs'];
						
						?>
						<tr>	
							<td><?=$no++?></td>
							<td><?=$data['Nim']?></td>
							<td><?=$data['Nama']?></td>
							<td><?=$data['Alamat']?></td>
							<td><?=$data['Prodi']?></td>
							<td>
								<a href="index.php?op=edit&id=<?php echo $id?>">
									<button type="button" class="btn btn-warning">Edit</button>
								</a>
								<a href="index.php?op=hapus&id=<?php echo $id?>" onclick="return confirm ('Yakin?')">
									<button type ='button' class="btn btn-danger">Hapus</button>
								</a>
							</td>
						</tr>
					<?php endwhile;//penutup Perulangan while?>
				</table>
			</div>
		</div>
		<!-- Akhir card tabel -->
	</div>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>