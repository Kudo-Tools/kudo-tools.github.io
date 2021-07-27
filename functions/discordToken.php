<?php

function getAccessToken() {
    $discord_code = trim($_GET["code"]);
    $client_id = "799727631289155585";
    $client_secret = "JfN6NHGlpoEzatpN6G8KR6d6wsLlaypo";
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://discord.com/api/oauth2/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array(
          'client_id' => '799727631289155585',
          'client_secret' => 'JfN6NHGlpoEzatpN6G8KR6d6wsLlaypo',
          'grant_type' => 'authorization_code',
          'code' => $discord_code,
          'redirect_uri' => 'https://www.kudotools.com/dashboard',
          'scope' => 'identify'),
      CURLOPT_HTTPHEADER => array(
        'Cookie: __dcfduid=10d4ed2b9b4a4ebcaaab6d725068c90f'
      ),
    ));
    
    $response = curl_exec($curl);
    $response = escapeJsonString($response);
    $json = json_decode($response, true);
    curl_close($curl);
    echo $json;
    return getDiscordInformation($json['access_token']);
}
function getDiscordInformation($token) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://discordapp.com/api/users/@me',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '. $token,
        'Cookie: __dcfduid=b9ad8ceaa926423484408a9a305f31ba'
      ),
    ));

    $response = curl_exec($curl);
    
    curl_close($curl);
    $response = escapeJsonString($response);
    $json = json_decode($response);
    
    $values = array(
        "id" => $json['id'],
        "username" => $json['username'],
        "numbers" => $json['discriminator'],
        "avatar" =>$json['avatar']
    );
    return $values;
}
function escapeJsonString($value) { 
    $escapers = array("\'");
    $replacements = array("\\/");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}


?>