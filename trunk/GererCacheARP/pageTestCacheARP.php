<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Test de la classe CacheARP</title>
    </head>
    <body>
    <?php
    require ("cacheARP.php");

    $monCache = new CacheARP();
    $monCache->ajouteEntree("192.168.10.1", "A1-B2-C3-D4-E5-F6");
    $monCache->ajouteEntree("192.168.10.2", "AA-BB-CC-DD-EE-FF");
    ?>
        <pre>
        Entrées du cache ARP :
        <?php 
        $lesEntrees = $monCache->getEntrees();
        print_r($lesEntrees);
        ?>
        </pre>
    </body>
</html>
