<?php
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

if ($search) {
    $sql = "SELECT * FROM materi WHERE judul LIKE '%$search%' OR isi LIKE '%$search%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM materi ORDER BY id DESC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Web Native</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        function copyText(id) {
            const text = document.getElementById('isi-' + id).innerText;
            navigator.clipboard.writeText(text).then(() => {
                const btn = document.querySelector(`button[onclick="copyText(${id})"]`);
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i> Berhasil!';
                btn.style.background = 'linear-gradient(45deg, #28a745, #20c997)';

                setTimeout(() => {
                    btn.innerHTML = original;
                    btn.style.background = 'linear-gradient(45deg, #667eea, #764ba2)';
                }, 2000);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.materi').forEach((card) => {
                observer.observe(card);
            });
        });
    </script>
</head>

<body>
    <div style="text-align: right; margin-bottom: 10px; color: #f0f0f0; font-weight: 600; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        Halo, <span style="color: #ffffff;"><?php echo htmlspecialchars($_SESSION['user']); ?></span> |
        <a href="logout.php" style="color: #ff4c4c; font-weight: 700; text-decoration: none;">Logout</a>
    </div>
    <div class="container">

        <form class="search-form" method="GET" action="">
            <h1 class="blink-title"> Perpustakaan Digital</h1>
            <input type="text" name="search" placeholder=" Cari materi..." value="<?php echo htmlspecialchars($search); ?>" />
            <button type="submit"><i class="fas fa-search"></i> Cari</button>
        </form>
        <div class="add-form-container scroll-animation">
            <h2><i class="fas fa-plus-circle"></i> Tambah Materi Baru</h2>
            <form class="add-form" method="POST" action="crud.php">
                <input type="hidden" name="action" value="add" />
                <input type="text" name="judul" placeholder="Judul materi" required />
                <textarea name="isi" placeholder=" Isi materi" required></textarea>
                <input type="date" name="tanggal_baca" />
                <input type="text" name="hari_baca" placeholder=" Hari baca (misal: Senin)" />
                <input type="text" name="sampai_baca" placeholder=" Sampai mana membaca" />
                <button type="submit"><i class="fas fa-plus"></i> Tambah Materi</button>
            </form>
        </div>
        <h2 style="color: white; text-align: center; margin-bottom: 30px;" class="scroll-animation">
            <i class="fas fa-book-open"></i> Daftar Materi
        </h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="materi-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="materi scroll-animation">
                        <h3><?php echo htmlspecialchars($row['judul']); ?></h3>

                        <div class="content">
                            <p id="isi-<?php echo $row['id']; ?>"><?php echo nl2br(htmlspecialchars($row['isi'])); ?></p>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <p><strong><i class="fas fa-calendar"></i> Tanggal Baca:</strong>
                                <?php echo $row['tanggal_baca'] ? date('d M Y', strtotime($row['tanggal_baca'])) : '-'; ?>
                            </p>
                            <p><strong><i class="fas fa-clock"></i> Hari Baca:</strong>
                                <?php echo htmlspecialchars($row['hari_baca']) ?: '-'; ?>
                            </p>
                            <p><strong><i class="fas fa-map-marker-alt"></i> Sampai Baca:</strong>
                                <?php echo htmlspecialchars($row['sampai_baca']) ?: '-'; ?>
                            </p>
                        </div>

                        <div class="actions">
                            <button class="btn btn-copy" onclick="copyText(<?php echo $row['id']; ?>)">
                                <i class="fas fa-copy"></i> Salin
                            </button>
                            <a href="crud.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="crud.php?action=delete&id=<?php echo $row['id']; ?>"
                                class="btn btn-delete"
                                onclick="return confirm('Yakin ingin menghapus materi ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="materi scroll-animation" style="text-align: center;">
                <h3><i class="fas fa-book"></i> Tidak ada materi</h3>
                <p>Belum ada materi yang ditambahkan. Silakan tambah materi baru!</p>
            </div>
        <?php endif; ?>
    </div>
    <div style="position: fixed; bottom: 30px; right: 30px;">
        <a href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'});"
            class="btn btn-copy"
            style="border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>