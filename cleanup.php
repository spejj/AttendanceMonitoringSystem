<?php
// Files to delete
$files = [
    __DIR__ . '/database/models/ActivityLogModel.php',
    __DIR__ . '/database/models/AnnouncementModel.php',
    __DIR__ . '/database/models/ClassSectionModel.php',
    __DIR__ . '/database/models/SubjectModel.php',
    __DIR__ . '/database/models/UserModel.php',
    __DIR__ . '/database/connection.php'
];

// Delete files
foreach ($files as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "Deleted: $file\n";
    }
}

// Directories to remove
$dirs = [
    __DIR__ . '/database/models',
    __DIR__ . '/database'
];

// Remove directories
foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        rmdir($dir);
        echo "Removed directory: $dir\n";
    }
}

echo "Cleanup complete!\n";
?>