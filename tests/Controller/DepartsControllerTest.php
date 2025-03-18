<?php

namespace App\Tests\Controller;

use App\Entity\Departs;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DepartsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $departRepository;
    private string $path = '/departs/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->departRepository = $this->manager->getRepository(Departs::class);

        foreach ($this->departRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Depart index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'depart[dateDepart]' => 'Testing',
            'depart[ecoleDestination]' => 'Testing',
            'depart[eleve]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->departRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Departs();
        $fixture->setDateDepart('My Title');
        $fixture->setEcoleDestination('My Title');
        $fixture->setEleve('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Depart');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Departs();
        $fixture->setDateDepart('Value');
        $fixture->setEcoleDestination('Value');
        $fixture->setEleve('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'depart[dateDepart]' => 'Something New',
            'depart[ecoleDestination]' => 'Something New',
            'depart[eleve]' => 'Something New',
        ]);

        self::assertResponseRedirects('/departs/');

        $fixture = $this->departRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateDepart());
        self::assertSame('Something New', $fixture[0]->getEcoleDestination());
        self::assertSame('Something New', $fixture[0]->getEleve());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Departs();
        $fixture->setDateDepart('Value');
        $fixture->setEcoleDestination('Value');
        $fixture->setEleve('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/departs/');
        self::assertSame(0, $this->departRepository->count([]));
    }
}
