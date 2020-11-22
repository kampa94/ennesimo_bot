<?php
require 'vendor/autoload.php';
use Telegram\Bot\Api;
// creazione dell'oggetto client
$client = new Api('123456789ABCDEFGHI');
/* per l'attivazione del long polling memorizziamo
l'id dell'ultimo update elaborato */
$last_update_id=0;
while(true){
    // leggiamo gli ultimi update ottenuti
	$response = $client->getUpdates(['offset'=>$last_update_id, 'timeout'=>5]);
	if (count($response)<=0) continue;
	/* per ogni update scaricato restituiamo il messaggio
	sulla stessa chat su cui è stato ricevuto */
	foreach ($response as $r){
        $last_update_id=$r->getUpdateId()+1;
		$message=$r->getMessage();
		$chatId=$message->getChat()->getId();
		$text=$message->getText();
		$response = $client->sendMessage([
  			'chat_id' => $chatId,
  			'text' => 'Hai scritto: '.$text
		]);
	}
}
?>
