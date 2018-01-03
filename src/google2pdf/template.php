<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <style>
        .search-result {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
<div class="page">
    <header>
        <h2>Suchergebnisse für "Search Term"</h2>
        <small>Ungefähr 34.100.000 Ergebnisse (0,58 Sekunden) </small>
    </header>
    <ol>
    <?php foreach ($this->items as $item): ?>
        <li class="search-result">
            <?php
                echo "<p><strong><a href='$item->href' target='_blank'>$item->title</a></strong><br>";
                echo "<a href='$item->href' target='_blank'>$item->href</a><br>";
                echo $item->description;
                echo "</p>";
            ?>
        </li>
    <?php endforeach; ?>
    </ol>
    <footer>X von N Seiten</footer>
</div>
</body>
</html>
