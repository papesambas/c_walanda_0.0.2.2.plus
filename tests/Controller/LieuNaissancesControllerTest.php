<?php

namespace App\Tests\Controller;

use App\Entity\LieuNaissances;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LieuNaissancesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $lieuNaissanceRepository;
    private string $path = '/lieu/naissances/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->lieuNaissanceRepository = $this->manager->getRepository(LieuNaissances::class);

        foreach ($this->lieuNaissanceRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LieuNaissance index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'lieu_naissance[designation]' => 'Testing',
            'lieu_naissance[commune]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->lieuNaissanceRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new LieuNaissances();
        $fixture->setDesignation('My Title');
        $fixture->setCommune('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LieuNaissance');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new LieuNaissances();
        $fixture->setDesignation('Value');
        $fixture->setCommune('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'lieu_naissance[designation]' => 'Something New',
            'lieu_naissance[commune]' => 'Something New',
        ]);

        self::assertResponseRedirects('/lieu/naissances/');

        $fixture = $this->lieuNaissanceRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getCommune());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new LieuNaissances();
        $fixture->setDesignation('Value');
        $fixture->setCommune('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/lieu/naissances/');
        self::assertSame(0, $this->lieuNaissanceRepository->count([]));
    }
}
