<?php
$page = $page ?? '';
function navlink(string $href, string $id, string $label, string $page): string {
    $cls = $id === $page ? 'link active' : 'link';
    return '<a class="' . $cls . '" href="' . $href . '">' . $label . '</a>';
}
?>

