<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <style>
        body {
            counter-reset: results;
            font-family:sans-serif;
            font-size:14px;
        }
        .search-result {
            page-break-inside: avoid;
            margin-bottom:20px;
            margin-left:40px;
            position: relative;
        }
        .search-result:before {
            content: attr(data-number);
            position: absolute;
            top: 0;
            left: -30px;
            color:#AAA;
            font-size:16px;
            font-weight:bold;
        }
        .search-result p {
            margin-top:0px;
        }

        .search-result:last-child { page-break-after: never; }
        .break {
            page-break-before: always;
        }

        @page {
            size: A4;
            margin: 50px;
        }
        header {
           margin-bottom:50px;
            margin-top:-25px;
        }
        footer {
            position: fixed;
            bottom: -20px;
            left: 0px;
            right: 0px;
            z-index:9999;
            height: 50px;
            width:100%;
            border-top:1px solid #CCC;
            text-align:center;
            font-size:12px;
            color:#888;
            padding-top:10px;
        }


        footer .pagenum:before {
            content: counter(page);
        }

    </style>
</head>
<body>
    <header>
        <?php
            // Header mit Überschrift und Stats
            echo "<h2>Suchergebnisse für \"$this->searchTerm\"</h2>";
            echo "<small>Zeige maximal $this->maxItems von ".lcfirst($this->stats)."</small>";
        ?>
    </header>

    <!-- Der Footer *muss* hier sein, damit er auch auf der 1. Seite ausgegeben wird! -->
    <footer>
        Seite <span class="pagenum"></span> von <?php echo ceil(count($this->items) / 8); ?>
    </footer>


    <?php
        // Über die Ergebnisse loopen und ausgeben
        foreach ($this->items as $index => $item): ?>
        <div class="search-result <?php echo ($index > 0 and $index % 8 === 0) ? 'break' : null; ?>" data-number="<?php echo $index + 1; ?>">
            <?php
                echo "<p><strong><a href='$item->href' target='_blank'>$item->title</a></strong><br>";
                echo "<a href='$item->href' target='_blank'>$item->href</a><br>";
                echo $item->description;
                echo "</p>";
            ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
