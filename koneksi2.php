<?php
session_start();

$conn = mysqli_connect("localhost","root","","inventory");

// if($conn){
//     echo 'Berhasil';
// }

//TAMBAH BARANG
if (isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) 
    values('$namabarang','$deskripsi','$stock')");
    if($addtotable){
        header('location:index2.php');
    } else {
        echo 'Gagal';
        header('location:index2.php');
    }
};

//TAMBAH BARANG MASUK
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty)
    values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' 
    WHERE idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk2.php');
    } else {
        echo 'Gagal';
        header('location:masuk2.php');
    }
}

//TAMBAH BARANG KELUAR
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty)
    values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$tambahkanstocksekarangdenganquantity' 
    WHERE idbarang='$barangnya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar2.php');
    } else {
        echo 'Gagal';
        header('location:keluar2.php');
    }
}


//HAPUS BARANG MASUK
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock 
    WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' 
    WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk2.php');
    } else {
        header('location:masuk2.php');
    }
}


//HAPUS BARANG KELUAR
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock 
    WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn, "UPDATE stock SET stock='$selisih' 
    WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");

    if($update&&$hapusdata){
        header('location:keluar.php');
    } else {
        header('location:keluar.php');
    }
}








?>