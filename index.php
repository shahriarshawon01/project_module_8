<?php
include 'db.php';
$result = $conn->query("SELECT * FROM photos ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
</head>

<body>
    <h1>Photo Gallery</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Photo Title" required>
        <input type="file" name="image" required>
        <button type="submit">Upload</button>
    </form>

    <h2>Uploaded Photos</h2>
    <?php if ($result->num_rows > 0): ?>
        <div>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div style="margin: 10px; display: inline-block; text-align: center;">
                    <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['title']; ?>" style="width: 150px; height: 150px;">
                    <p><?php echo $row['title']; ?></p>
                    <form action="delete.php" method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="image_path" value="<?php echo $row['image_path']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No photos uploaded yet.</p>
    <?php endif; ?>

</body>

</html>