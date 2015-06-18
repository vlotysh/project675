<?php

// web/index.php 

/*
trait Pprint 
{
    public function whoAmI()
    {
        return get_class($this) . ': ' . (string) $this;
    }
}

trait Namer 
{
    //использование одного типажа в другом
    use Pprint;
    
    public function getMyName()
    {
        return $this->whoAmI();
    }
    
    public function getMyLastName()
    {
        return 'Unknown =(';
    }
    
    public function getMyNickname()
    {
        return preg_replace('/[^a-z]+/i', '_', strtolower($this->getMyName()));
    }
}

trait SuperNamer
{
    public function getMyLastName()
    {
        return 'Ask me';
    }
}


class Human 
{
    use SuperNamer;
    use Namer
    {
    	SuperNamer::getMyLastName insteadof Namer;
    	Namer::getMyNickname as protected _getMyLogin;
    }

    protected $_name = 'unknown';
    
    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function __toString()
    {
        return (string) $this->_name;
    }
    
    public function getLogin()
    {
        return $this->_getMyLogin();
    }
    
    
}

$a = new Human('Nikita');

echo join(', ', get_class_methods($a)), PHP_EOL;
//__construct, __toString, getLogin, getMyLastName, 
//getMyName, getMyNickname, whoAmI

echo $a->getMyName(), PHP_EOL; //Human: Nikita
echo $a->getMyLastName(), PHP_EOL; //Ask me
echo $a->getLogin(), PHP_EOL; //human_nikita
echo $a->getMyNickname(), PHP_EOL; //human_nikita

exit();
*/
require_once __DIR__ . '/../vendor/autoload.php';


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app = new Silex\Application(); // ... definitions

$app['debug'] = true;


$blogPosts = array(
    1 => array(
        'date' => '2011-03-29',
        'author' => 'igorw',
        'title' => 'Using Silex',
        'body' => '...',
    ),
);

$app->get('/feedback', function (Request $request) {
    $message = $request->get('message');
    mail('feedback@yoursite.com', '[YourSite] Feedback', $message);

    return new Response('Thank you for your feedback!', 201);
});

$app->get('/', function () use ($blogPosts) {
    $output = '';
    foreach ($blogPosts as $post) {
        $output .= $post['title'];
        $output .= '<br />';
    }

    return $output;
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});

$app->get('/blog', function () use ($blogPosts) {
    $output = '';
    foreach ($blogPosts as $post) {
        $output .= $post['title'];
        $output .= '<br />';
    }

    return $output;
});

$app->run();
