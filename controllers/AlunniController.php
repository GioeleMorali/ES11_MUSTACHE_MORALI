<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
    /**
     * Metodo per l'accesso alla home page
     * @link /alunni
     * @method GET
     */
    function index(Request $request, Response $response, $args) {
        $classe = new Classe();
        //$arrayy = $classe->getArray();
        
        $view = new AlunniPage();
        $view->setData($classe);
        $mainPage = new MainPage();
        $mainPage->set("body", $view->render());
        $response->getBody()->write($mainPage->render());
        return $response;
    }
    /**
     * Metodo per l'accesso alla home page per nome alunno
     * @link /alunni/search[/{nome}]
     * @method GET
     */
    function findByName(Request $request, Response $response, $args) {
        $params = isset($_GET['nome'])?$_GET:null;
        $nome = isset($args['nome'])?$args['nome']:$params['nome'];
        $classe = new Classe();
        $data['Alunno'] = $classe->findByName($nome);
        //$arrayy = $classe->getArray();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
    function json_alunni(Request $request, Response $response, $args)
    {
        $classe = new Classe();
        $response->getBody()->write(json_encode($classe));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
}