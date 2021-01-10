<?php
ini_set ( 'max_execution_time', 0);
include 'pasterm.class.php';
$obj=new GoogleScraper();
echo "\033[01;32m               [Dev > Junior Hilario Jara]
__________               ___________
\______   \_____    _____\__    ___/__________  _____
 |     ___/\__  \  /  ___/ |    |_/ __ \_  __ \/     \
 |    |     / __ \_\___ \  |    |\  ___/|  | \/  Y Y  \
 |____|    (____  /____  > |____| \___  >__|  |__|_|  /
		\/     \/             \/            \/ \033[0m\n\033[01;31m                                       #SentinelSociety\033[0m\n";
$keywords = readline("Keyword: ");
echo "\033[01;36m==========================================\033[0m\n";
echo "\033[01;33mSe esta recolectando cuentas de diferentes\nservicios, esto puede tardar un tiempo\033[0m\n";
echo "\033[01;36m==========================================\033[0m\n";
$keyword = explode(",", $keywords);
for($i=0;$i<count($keyword);$i++){
//echo $keyword[$i]."\n";
//Poner keyword y/o proxy aqui.
//echo urlencode('site:pastebin.com intext:@gmail.com');
$dork="site:pastebin.com intext:".$keyword[$i];
$arr=$obj->getUrlList(urlencode("$dork"),'');
$paste_links=implode(",", $arr);
$paste_links2[]=$paste_links;
//print_r($arr);

}
//print_r($paste_links2);
$paste_links3=implode(",", $paste_links2);
$paste_final = explode(",", $paste_links3);
//print_r($paste_final);
$paste_firme=array_unique($paste_final);
//print_r($paste_firme);
/*for($i=0;$i<count($arr);$i++){
	echo $arr[$i]."\n";
}*/

for($i=0;$i<count($paste_firme);$i++){
$link=$paste_firme[$i];
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $link
));

$resp = curl_exec($curl);
curl_close($curl);
$div = explode('<textarea id="paste_code" class="paste_code" name="paste_code" onkeydown="return catchTab(this,event)">', $resp);
$div2 = explode('</textarea>', $div[1]);
$precombo=strip_tags($div2[0]);

$archivo="precombo.txt";

if (!fwrite(fopen($archivo,'a+'), $precombo)) {
        echo "\033[01;32m.";
   } else {
      echo "\033[01;32m.";
   }
}
echo "\n";
//Separado de cuentas por delimitacion
$oa = fopen($archivo, 'r');
while($linea = fgets($oa)) {
if (feof($oa)) break;
        $linea = substr( $linea, 0, -1 );

                if (strpos($linea, ':') !== false) {
                        list($email,$pass) = explode(":", $linea);
                }elseif (strpos($linea, '|') !== false) {
                        list($email,$pass) = explode("|", $linea);
                }else{}
                $emailpass="$email:$pass";
                if(substr_count($emailpass, ' ')==0){
                $cuentas_listas[]=$emailpass."\n";
                }
}
fclose($oa);
$nombre_combo = readline("Nombre del combo: ");
$cuentas_listas=array_unique($cuentas_listas);
$archivo_final = fopen("$nombre_combo.txt", "a+"); // Abrir archivo
foreach($cuentas_listas as $final) {
        fwrite($archivo_final, $final);
}
echo "\033[01;33mCombo Guardado!!\n\033[01;32mRuta del combo => $nombre_combo.txt\033[0m\n";
fclose($archivo_final); // Cerrar archivo
unlink('precombo.txt');

?>
