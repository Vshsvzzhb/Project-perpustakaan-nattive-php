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
        <link rel="stylesheet" href="style.css">
        <style>
            .edit-form {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .edit-form label {
                font-weight: 600;
                color: #fffffdff;
                margin-bottom: 5px;
            }

            .edit-form input,
            .edit-form textarea {
                width: 100%;
                padding: 12px 15px;
                border-radius: 8px;
                border: 2px solid #444;
                background: #f5f5f5ff;
                color: #000000ff;
                font-size: 1rem;
            }

            .edit-form textarea {
                min-height: 120px;
                resize: vertical;
            }

            .tombol1 {
                padding: 20px;
                border-radius: 20px;
                background-color: #444;
                color: white;
                border: white;
                font-weight: bold;
            }

            h2 {
                text-align: center;
                padding-bottom: 10px;

            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="edit-form-container">
                <h2>Edit Materi</h2>
                <form method="POST" action="crud.php" class="edit-form">
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />

                    <input type="text" name="judul" value="<?php echo htmlspecialchars($row['judul']); ?>" required />
                    <textarea name="isi" required><?php echo htmlspecialchars($row['isi']); ?></textarea>
                    <label for="tanggal_baca">Tanggal Baca:</label>
                    <input type="date" name="tanggal_baca" value="<?php echo $row['tanggal_baca']; ?>" />
                    <label for="hari_baca">Hari Baca:</label>
                    <input type="text" name="hari_baca" value="<?php echo htmlspecialchars($row['hari_baca']); ?>" />
                    <label for="sampai_baca">Sampai Baca:</label>
                    <input type="text" name="sampai_baca" value="<?php echo htmlspecialchars($row['sampai_baca']); ?>" />

                    <button type="submit" class="tombol1">Update</button>
                </form>
                <div style="text-align:center; margin-top:15px;">
                    <a href="index.php" class="btn btn-copy">Kembali</a>
                </div>
            </div>
        </div>
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
