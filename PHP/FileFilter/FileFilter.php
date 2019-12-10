<?php

/*
 |===================================================================================
 | Recursively list all files in directory and subdirectories and write to CSV file.
 |===================================================================================
 | You can use this to check what files have a certain string in their content.
 | For example, we will get a list of files that contain 'Example'.
*/

// Setup
$directory_to_search = 'path/to/directory';
$output_file = 'output.csv';
$delimiter = ';';
$string_to_find = 'Example';


// Instantiating iterators
$directories = new RecursiveDirectoryIterator($directory_to_search, RecursiveDirectoryIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator($directories);


// Filling the output array
$output = [];
foreach($files as $file){
    $output[$file->getFileName()] = $file->getPathName();
}


// Filter files here!
$output = array_filter(
    $output,
    function($file) use ($string_to_find){
        $content = file_get_contents($file);
        return (strpos($content, $string_to_find) !== false);
    }
);


// Writing to CSV
$handle = fopen($output_file, 'w');
foreach($output as $key => $value){
    fputcsv($handle, [$key, $value], $delimiter);
}
fclose($handle);


echo 'Done, the output can be found here: ' . realpath($output_file);