<?php

namespace App\Tests\Controller;

use App\Entity\Redoublements1;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class Redoublements1ControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $redoublements1Repository;
    private string $path = '/redoublements1/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->redoublements1Repository = $this->manager->getRepository(Redoublements1::class);

        foreach ($this->redoublements1Repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Redoublements1 index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'redoublements1[niveau]' => 'Testing',
            'redoublements1[scolarites1]' => 'Testing',
            'redoublements1[scolarites2]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->redoublements1Repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Redoublements1();
        $fixture->setNiveau('My Title');
        $fixture->setScolarites1('My Title');
        $fixture->setScolarites2('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Redoublements1');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Redoublements1();
        $fixture->setNiveau('Value');
        $fixture->setScolarites1('Value');
        $fixture->setScolarites2('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'redoublements1[niveau]' => 'Something New',
            'redoublements1[scolarites1]' => 'Something New',
            'redoublements1[scolarites2]' => 'Something New',
        ]);

        self::assertResponseRedirects('/redoublements1/');

        $fixture = $this->redoublements1Repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNiveau());
        self::assertSame('Something New', $fixture[0]->getScolarites1());
        self::assertSame('Something New', $fixture[0]->getScolarites2());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Redoublements1();
        $fixture->setNiveau('Value');
        $fixture->setScolarites1('Value');
        $fixture->setScolarites2('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/redoublements1/');
        self::assertSame(0, $this->redoublements1Repository->count([]));
    }
}
