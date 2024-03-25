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
    function json_findByName(Request $request, Response $response, $args) {
        $params = isset($_GET['nome'])?$_GET:null;
        $nome = isset($args['nome'])?$args['nome']:$params['nome'];
        $classe = new Classe();
        $data['Alunno'] = $classe->findByName($nome);
        //$arrayy = $classe->getArray();
        $response->getBody()->write(json_encode($data));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
    function findByName(Request $request, Response $response, $args) {
        $params = isset($_GET['nome'])?$_GET:null;
        $nome = isset($args['nome'])?$args['nome']:$params['nome'];
        $classe = new Classe();
        $data['Alunno'] = $classe->findByName($nome);
        //$arrayy = $classe->getArray();
        
        $view = new AlunnoPage();
        $view->setData($data);

        $mainPage = new MainPage();
        $mainPage->set("body", $view->render());
        $response->getBody()->write($mainPage->render());
        return $response;
    }
    function json_alunni(Request $request, Response $response, $args)
    {
        $classe = new Classe();
        $response->getBody()->write(json_encode($classe));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
    }
    function post_alunni(Request $request, Response $response, $args)
    {
        $dati = json_decode($request->getBody()->getContents(), true);
        $classe = new Classe();
        $alunno = new Alunno($dati["nome"], $dati["cognome"], $dati["eta"]);
        $classe->addAlunno($alunno);
        $response->getBody()->write(json_encode($classe));
        return $response->withHeader("Content-type", "application/json")->withStatus(201);
    }
    function put_alunno(Request $request, Response $response, $args)
    {
        $dati = json_decode($request->getBody()->getContents(), true);
        $classe = new Classe();
        $alunno = new Alunno($args["nome"], $dati["cognome"], $dati["eta"]);
        $alunnoModificato = $classe->modificaAlunno($alunno);
        if($alunnoModificato == null)
        {
            $response->getBody()->write("Alunno non presente");
            return $response->withHeader("Content-type", "application/json")->withStatus(404);
        }
        $response->getBody()->write(json_encode("Alunno modificato: " . $alunnoModificato->getNome() . " " . $alunnoModificato->getCognome()." ". $alunnoModificato->getEta()));
        return $response->withHeader("Content-type", "application/json")->withStatus(201);
    }
    function delete_alunno(Request $request, Response $response, $args)
    {
        $dati = json_decode($request->getBody()->getContents(), true);
        $classe = new Classe();
        $alunno = new Alunno($args["nome"], $dati["cognome"], $dati["eta"]);
        $alunnoCancellato = $classe->cancellaAlunno($alunno);
        if($alunnoCancellato == null)
        {
            $response->getBody()->write("Alunno non presente");
            return $response->withHeader("Content-type", "application/json")->withStatus(404);
        }
        $response->getBody()->write(json_encode("Alunno cancellato: " . $alunno->getNome() . " " . $alunno->getCognome()." ". $alunno->getEta()));
        return $response->withHeader("Content-type", "application/json")->withStatus(201);
    }

}