<?php

namespace App\Tests\Controller;

use App\Entity\Ninas;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class NinasControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $ninaRepository;
    private string $path = '/ninas/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->ninaRepository = $this->manager->getRepository(Ninas::class);

        foreach ($this->ninaRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Nina index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'nina[designation]' => 'Testing',
            'nina[pere]' => 'Testing',
            'nina[mere]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->ninaRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ninas();
        $fixture->setDesignation('My Title');
        $fixture->setPere('My Title');
        $fixture->setMere('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Nina');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ninas();
        $fixture->setDesignation('Value');
        $fixture->setPere('Value');
        $fixture->setMere('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'nina[designation]' => 'Something New',
            'nina[pere]' => 'Something New',
            'nina[mere]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ninas/');

        $fixture = $this->ninaRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getPere());
        self::assertSame('Something New', $fixture[0]->getMere());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Ninas();
        $fixture->setDesignation('Value');
        $fixture->setPere('Value');
        $fixture->setMere('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/ninas/');
        self::assertSame(0, $this->ninaRepository->count([]));
    }
}
