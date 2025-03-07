<?php

namespace App\Tests\Controller;

use App\Entity\Telephones1;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class Telephones1ControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $telephones1Repository;
    private string $path = '/telephones1/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->telephones1Repository = $this->manager->getRepository(Telephones1::class);

        foreach ($this->telephones1Repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Telephones1 index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'telephones1[numero]' => 'Testing',
            'telephones1[peres]' => 'Testing',
            'telephones1[meres]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->telephones1Repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Telephones1();
        $fixture->setNumero('My Title');
        $fixture->setPeres('My Title');
        $fixture->setMeres('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Telephones1');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Telephones1();
        $fixture->setNumero('Value');
        $fixture->setPeres('Value');
        $fixture->setMeres('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'telephones1[numero]' => 'Something New',
            'telephones1[peres]' => 'Something New',
            'telephones1[meres]' => 'Something New',
        ]);

        self::assertResponseRedirects('/telephones1/');

        $fixture = $this->telephones1Repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNumero());
        self::assertSame('Something New', $fixture[0]->getPeres());
        self::assertSame('Something New', $fixture[0]->getMeres());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Telephones1();
        $fixture->setNumero('Value');
        $fixture->setPeres('Value');
        $fixture->setMeres('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/telephones1/');
        self::assertSame(0, $this->telephones1Repository->count([]));
    }
}
