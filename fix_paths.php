<?php
$dir = __DIR__;

function replacePath($dir)
{
    if (!is_dir($dir))
        return;

    $files = glob($dir . '/*');
    foreach ($files as $file) {
        if (is_dir($file)) {
            replacePath($file);
        } else {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'php') {
                $content = file_get_contents($file);
                $originalContent = $content;
                // Double Quotes
                $content = str_replace('"/doncosa/public/', '"/', $content);
                // Single Quotes
                $content = str_replace("'/doncosa/public/", "'/", $content);
                // Naked Links
                $content = str_replace(' /doncosa/public/', ' /', $content);

                // Exclude this script itself
                if ($content !== $originalContent && basename($file) !== 'fix_paths.php') {
                    file_put_contents($file, $content);
                    echo "Updated: " . str_replace(__DIR__, '', $file) . "\n";
                }
            }
        }
    }
}

replacePath($dir);
echo "All URLs rewritten for production root.";
