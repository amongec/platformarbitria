<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnviarSmsController extends Controller
{
    public function enviarSms()
    {
        $usuarioIagente = "gruproscat@gmail.com";
        $senhaIagente = urlencode("12345678!");

        $nome = "Postea";
        $celular = "1234567898";

        // codifica os dados no formato de um formulário www
        $mensagem = urlencode("$nome, Your verification code 123.");

        // concatena a url da api com a variável carregando o conteúdo da mensagem
        $url_api = "https://api.iagentesms.com.br/webservices/http.php?metodo=envio&usuario=$usuarioIagente&senha=$senhaIagente&celular=$celular&mensagem={$mensagem}";

        // realiza a requisição http passando os parâmetros informados
        $api_http = file_get_contents($url_api);

        // imprime o resultado da requisição
        echo $api_http;
    }
}
