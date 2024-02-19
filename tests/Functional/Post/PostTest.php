<?php

namespace App\Tests\Functional\Post;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function PHPUnit\Framework\assertEquals;

class PostTest extends WebTestCase
{
    public function testBlogPageWorks(): void
    {
        $client = static::createClient();
       $client->request(Request::METHOD_GET,'/');

       $this->assertResponseIsSuccessful();
       $this->assertResponseStatusCodeSame(Response::HTTP_OK);

      $this->assertSelectorExists('h1');
       $this->assertSelectorTextContains('h1','Blog créé avec Symfony');
    }

    public function testPaginationWorks():void
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/');
 
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

   

        $link = $crawler->selectLink('2')->extract(['href'])[0];
        $crawler = $client->request(Request::METHOD_GET, $link);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $posts = $crawler->filter('div.card');
        $this->assertGreaterThanOrEqual(1, count($posts));

    }
}