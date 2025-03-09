<?php

namespace App\Tests\Controller;

use App\Entity\Eleves;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ElevesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $elefeRepository;
    private string $path = '/eleves/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->elefeRepository = $this->manager->getRepository(Eleves::class);

        foreach ($this->elefeRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Elefe index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'elefe[sexe]' => 'Testing',
            'elefe[dateInscription]' => 'Testing',
            'elefe[dateRecrutement]' => 'Testing',
            'elefe[dateNaissance]' => 'Testing',
            'elefe[dateExtrait]' => 'Testing',
            'elefe[numeroExtrait]' => 'Testing',
            'elefe[nom]' => 'Testing',
            'elefe[prenom]' => 'Testing',
            'elefe[lieuNaissance]' => 'Testing',
            'elefe[parent]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->elefeRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setSexe('My Title');
        $fixture->setDateInscription('My Title');
        $fixture->setDateRecrutement('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setDateExtrait('My Title');
        $fixture->setNumeroExtrait('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setLieuNaissance('My Title');
        $fixture->setParent('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Elefe');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setSexe('Value');
        $fixture->setDateInscription('Value');
        $fixture->setDateRecrutement('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setDateExtrait('Value');
        $fixture->setNumeroExtrait('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setParent('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'elefe[sexe]' => 'Something New',
            'elefe[dateInscription]' => 'Something New',
            'elefe[dateRecrutement]' => 'Something New',
            'elefe[dateNaissance]' => 'Something New',
            'elefe[dateExtrait]' => 'Something New',
            'elefe[numeroExtrait]' => 'Something New',
            'elefe[nom]' => 'Something New',
            'elefe[prenom]' => 'Something New',
            'elefe[lieuNaissance]' => 'Something New',
            'elefe[parent]' => 'Something New',
        ]);

        self::assertResponseRedirects('/eleves/');

        $fixture = $this->elefeRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getDateInscription());
        self::assertSame('Something New', $fixture[0]->getDateRecrutement());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
        self::assertSame('Something New', $fixture[0]->getDateExtrait());
        self::assertSame('Something New', $fixture[0]->getNumeroExtrait());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getLieuNaissance());
        self::assertSame('Something New', $fixture[0]->getParent());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setSexe('Value');
        $fixture->setDateInscription('Value');
        $fixture->setDateRecrutement('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setDateExtrait('Value');
        $fixture->setNumeroExtrait('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setParent('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/eleves/');
        self::assertSame(0, $this->elefeRepository->count([]));
    }
}
