<?php

ob_start();
define('API_KEY','5209382677:AAEwKsNrjijnVI6xlwx_NbJFD4vKOJj0JH4');//BOT TOKEN 

$admin ="2086136108"; //ADMIN ID 
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$chat_id = $message->chat->id;
$reply_text = $message->reply_to_message->text;
$user_id = $message->from->id;
$id = $message->from->id;
$reply_menu = json_encode([
           'resize_keyboard'=>false,
            'force_reply' => true,
            'selective' => true
        ]);

if(mb_stripos($text,"/start")!==false){
   $baza=file_get_contents("azo.dat");
   if(mb_stripos($baza,$chat_id) !==false){
   }else{
   $txt="\n$chat_id";
   $file=fopen("azo.dat","a");
   fwrite($file,$txt);
   fclose($file);
   }
}


if ($text=="/stat") {
      $baza=file_get_contents("azo.dat");
      $all=substr_count($baza,"n");
      $gr=substr_count($baza,"-");
      $us=$all-$gr;
      $tx = " Bot Foydalanuvchilari
 Super Group: $gr
Userlar: $us
Jami: $all
";
  bot('sendmessage',[
   'chat_id'=>$chat_id,
   'parse_mode'=>'html',
   'text'=>$tx,
  ]);
}


if($text == "/start"){
    bot('sendMessage',[
       'chat_id'=> $chat_id,
        'text'=> "Assalomu alekum!

Sizga qanday yordam beraolishim mumkun? Savolingiz bo`lsa marhamat, sizga tez orada javob beramiz.",
        'reply_to_message_id'=>$mid,
        
    ]);
}
mkdir("mid");
if ($text==$text and $chat_id <> $admin){ 
if($text == "/start"){
}else{
    $mid5=bot('ForwardMessage',[
        'chat_id'=> $admin,
        'from_chat_id'=>$chat_id,
        'message_id'=>$message->message_id,
    ])->result->message_id;
    $mid=$message->message_id;
file_put_contents("mid/$mid5.txt","$chat_id|$mid");
    bot('sendMessage',[
       'chat_id'=>$chat_id,
       'reply_to_message_id'=>$mid,
        'text'=>"Yuborildi",
    ]);}
}

if($message->reply_to_message->message_id and $user_id == $admin){
$rchid=$message->reply_to_message->message_id;
$chid=file_get_contents("mid/$rchid.txt");
$ex=explode ("|",$chid);
    bot('SendMessage',[
       'chat_id'=>$ex[0],
        'text'=>$text,
    ]);
    bot('SendMessage',[
       'chat_id'=> $admin,
       'reply_to_message_id'=>$mid,
        'text'=> "Javob yuborildi",
    ]);
}
