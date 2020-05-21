<?php
$title = "Test Rest 1";
$cssFile = '';

ob_start();

//Test

$parisData = 'https://opendata.paris.fr/api/records/1.0/search/?dataset=sites-disposant-du-service-paris-wi-fi&q=&rows=300&facet=cp&facet=nom_site&facet=arc_adresse&facet=geo_point_2d&facet=etat2&q=cp%3D75014';
$curlData = curl_init($parisData);

//Validation SSL
//curl_setopt($curlData, CURLOPT_SSL_VERIFYPEER,false); // Validation SSL. Méthode non recommandé car pas sécurisé, utiliser plutot les certificat

//curl_setopt($curlData, CURLOPT_SSL_VERIFYPEER,__DIR__.DIRECTORY_SEPARATOR.'C:\wamp64\www\1\WifiSpotsParis\certifParisData');
//curl_setopt($curlData,CURLOPT_RETURNTRANSFER,true);

//Racourcis pour limiter le nombre d'appel de "curl_setopt"
curl_setopt_array($curlData,[
    CURLOPT_SSL_VERIFYPEER => __DIR__.DIRECTORY_SEPARATOR.'C:\wamp64\www\1\WifiSpotsParis\certifParisData',
    CURLOPT_RETURNTRANSFER =>true,
    CURLOPT_TIMEOUT => 1
]);

$data= curl_exec($curlData);
if ($data == false){
    var_dump(curl_error($curlData));
}else{
    if(curl_getinfo($curlData,CURLINFO_HTTP_CODE) === 200){
        $data = json_decode($data,true);
        //var_dump($data['records'][0]['fields']);
        $spots = [];
        foreach($data['records'] as $record){
            $row = [
                "cp" => $record['fields']['cp'],
                "nom_site" => $record['fields']['nom_site'],
                "arc_adresses" => $record['fields']['arc_adresse'],
                "etat2" => $record['fields']['etat2']
            ];
            $spots['Spots WiFi'][] = $row;
        }
        echo json_encode($spots);
    }
}




/*
//Template Test

$parisData = 'https://opendata.paris.fr/api/records/1.0/search/?dataset=sites-disposant-du-service-paris-wi-fi&q=&rows=300';
$curlData = curl_init($parisData);

//Validation SSL
//curl_setopt($curlData, CURLOPT_SSL_VERIFYPEER,false); // Validation SSL. Méthode non recommandé car pas sécurisé, utiliser plutot les certificat

//curl_setopt($curlData, CURLOPT_SSL_VERIFYPEER,__DIR__.DIRECTORY_SEPARATOR.'C:\wamp64\www\1\WifiSpotsParis\certifParisData');
//curl_setopt($curlData,CURLOPT_RETURNTRANSFER,true);

//Racourcis pour limiter le nombre d'appel de "curl_setopt"
curl_setopt_array($curlData,[
    CURLOPT_SSL_VERIFYPEER => __DIR__.DIRECTORY_SEPARATOR.'C:\wamp64\www\1\WifiSpotsParis\certifParisData',
    CURLOPT_RETURNTRANSFER =>true,
    CURLOPT_TIMEOUT => 1
]);

$data= curl_exec($curlData);
if ($data == false){
    var_dump(curl_error($curlData));
}else{
    if(curl_getinfo($curlData,CURLINFO_HTTP_CODE) === 200){
        $data = json_decode($data,true);
        var_dump($data[records][0]);
        var_dump($data);
    }
}
*/
curl_close($curlData);
$content = ob_get_clean();
require('template.php');?>
