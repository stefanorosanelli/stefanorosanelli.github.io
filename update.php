#!/usr/bin/php
<?php
/**
 * COVID-19 data from Italy's  Dipartimento della Protezione Civile
 * 
 * Source: https://github.com/pcm-dpc/COVID-19/blob/master/dati-json/dpc-covid19-ita-regioni.json
 * 
 */

define('ROOT', __DIR__);
require_once ROOT . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(ROOT);
$twig = new \Twig\Environment($loader, [
    'cache' => ROOT . '/tmp',
    'debug' => true,
]);

$covid = json_decode(file_get_contents(ROOT . '/dpc-covid19-ita-regioni.json'), true);

$data = [];
foreach ($covid as $region) {
    $k = $region['denominazione_regione'];
    if (empty($data[$k])) {
        $data[$k]['type'] = 'bar';
    }
    $d = date_create_from_format('Y-m-d' , substr($region['data'], 0, 10)); 
    $data[$k]['x'][] = $d->format('M d'); 
    $data[$k]['y'][] = (int)$region['terapia_intensiva'];    
}

$out = $twig->render('covid-19-ita.twig', compact('data'));

$file = ROOT . '/covid-19-ita.html';
file_put_contents($file, $out);

?>