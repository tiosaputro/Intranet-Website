<?php namespace App\Services;

class WhatsappApi
{
  protected $url;
  protected $key;
  protected $proxy;

  public function __construct($url='',$key='', $proxy='')
  {
    $this->url = env("API_WHATSAPP","https://jogja.wablas.com/api");
    $this->key = env("API_WHATSAPP_KEY","yjkgznEE4uIS0Fh7OQC7GRQaOuvV0sLCoxhKqU5FiAlEbVZHZ4By6NH1kn6x8FhK");
    // $this->proxy = "http://10.15.3.20:80";
  }

  private function sendRequest(array $incomingCurlOpt)
    {
        $curl = curl_init();
        $defaultCurlOpt = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 6000,
           CURLOPT_PROXY => $this->proxy,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "cache-control: no-cache",
                "Authorization: ".$this->key,
            ),
        ];
        $curlOpt = $incomingCurlOpt + $defaultCurlOpt;
        curl_setopt_array($curl, $curlOpt);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $jsonData = json_decode($response);
        curl_close($curl);
        if ($err) {
            abort($err);
        }
        return $jsonData;
    }

    public function sendMessage($dataPost) //method POST
    {
        $dataPost = json_encode($dataPost);
        $curlOpt = [
            CURLOPT_URL => $this->url."/send-message",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $dataPost
        ];
        $jsonData = $this->sendRequest($curlOpt);
        return $jsonData;
    }
}
