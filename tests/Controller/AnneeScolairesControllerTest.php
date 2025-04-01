<?php

namespace App\Tests\Controller;

use App\Entity\AnneeScolaires;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AnneeScolairesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $anneeScolaireRepository;
    private string $path = '/annee/scolaires/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->anneeScolaireRepository = $this->manager->getRepository(AnneeScolaires::class);

        foreach ($this->anneeScolaireRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AnneeScolaire index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'annee_scolaire[anneedebut]' => 'Testing',
            'annee_scolaire[anneeFin]' => 'Testing',
            'annee_scolaire[createdAt]' => 'Testing',
            'annee_scolaire[updatedAt]' => 'Testing',
            'annee_scolaire[createdBy]' => 'Testing',
            'annee_scolaire[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->anneeScolaireRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new AnneeScolaires();
        $fixture->setAnneedebut('My Title');
        $fixture->setAnneeFin('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AnneeScolaire');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new AnneeScolaires();
        $fixture->setAnneedebut('Value');
        $fixture->setAnneeFin('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'annee_scolaire[anneedebut]' => 'Something New',
            'annee_scolaire[anneeFin]' => 'Something New',
            'annee_scolaire[createdAt]' => 'Something New',
            'annee_scolaire[updatedAt]' => 'Something New',
            'annee_scolaire[createdBy]' => 'Something New',
            'annee_scolaire[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/annee/scolaires/');

        $fixture = $this->anneeScolaireRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getAnneedebut());
        self::assertSame('Something New', $fixture[0]->getAnneeFin());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new AnneeScolaires();
        $fixture->setAnneedebut('Value');
        $fixture->setAnneeFin('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/annee/scolaires/');
        self::assertSame(0, $this->anneeScolaireRepository->count([]));
    }
}
