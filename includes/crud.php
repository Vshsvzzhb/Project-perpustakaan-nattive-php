<?php
include 'db.php';

$action = $_REQUEST['action'] ?? '';

if ($action == 'add') {
    $judul = $conn->real_escape_string($_POST['judul']);
    $isi = $conn->real_escape_string($_POST['isi']);
    $tanggal_baca = $_POST['tanggal_baca'] ?: NULL;
    $hari_baca = $conn->real_escape_string($_POST['hari_baca']);
    $sampai_baca = $conn->real_escape_string($_POST['sampai_baca']);

    $sql = "INSERT INTO materi (judul, isi, tanggal_baca, hari_baca, sampai_baca) VALUES ('$judul', '$isi', " . ($tanggal_baca ? "'$tanggal_baca'" : "NULL") . ", '$hari_baca', '$sampai_baca')";
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} elseif ($action == 'delete') {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM materi WHERE id = $id");
    header("Location: index.php");
    exit;
} elseif ($action == 'edit') {
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM materi WHERE id = $id");
    if ($res->num_rows == 0) {
        echo "Materi tidak ditemukan";
        exit;
    }
    $row = $res->fetch_assoc();
?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8" />
        <title>Edit Materi</title>
    </head>

    <body>
        <h1>Edit Materi</h1>
        <form method="POST" action="crud.php">
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
            <input type="text" name="judul" value="<?php echo htmlspecialchars($row['judul']); ?>" required /><br />
            <textarea name="isi" required><?php echo htmlspecialchars($row['isi']); ?></textarea><br />
            <input type="date" name="tanggal_baca" value="<?php echo $row['tanggal_baca']; ?>" /><br />
            <input type="text" name="hari_baca" value="<?php echo htmlspecialchars($row['hari_baca']); ?>" /><br />
            <input type="text" name="sampai_baca" value="<?php echo htmlspecialchars($row['sampai_baca']); ?>" /><br />
            <button type="submit">Update</button>
        </form>
        <a href="index.php">Kembali</a>
    </body>

    </html>

<?php
} elseif ($action == 'update') {
    $id = intval($_POST['id']);
    $judul = $conn->real_escape_string($_POST['judul']);
    $isi = $conn->real_escape_string($_POST['isi']);
    $tanggal_baca = $_POST['tanggal_baca'] ?: NULL;
    $hari_baca = $conn->real_escape_string($_POST['hari_baca']);
    $sampai_baca = $conn->real_escape_string($_POST['sampai_baca']);

    $sql = "UPDATE materi SET judul='$judul', isi='$isi', tanggal_baca=" . ($tanggal_baca ? "'$tanggal_baca'" : "NULL") . ", hari_baca='$hari_baca', sampai_baca='$sampai_baca' WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: index.php");
    exit;
}
?>