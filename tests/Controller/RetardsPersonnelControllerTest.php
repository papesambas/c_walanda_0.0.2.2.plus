<?php

namespace App\Tests\Controller;

use App\Entity\RetardsPersonnel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RetardsPersonnelControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $retardsPersonnelRepository;
    private string $path = '/retards/personnel/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->retardsPersonnelRepository = $this->manager->getRepository(RetardsPersonnel::class);

        foreach ($this->retardsPersonnelRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RetardsPersonnel index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'retards_personnel[jour]' => 'Testing',
            'retards_personnel[heure]' => 'Testing',
            'retards_personnel[duree]' => 'Testing',
            'retards_personnel[motif]' => 'Testing',
            'retards_personnel[heureClasse]' => 'Testing',
            'retards_personnel[createdAt]' => 'Testing',
            'retards_personnel[updatedAt]' => 'Testing',
            'retards_personnel[slug]' => 'Testing',
            'retards_personnel[personnel]' => 'Testing',
            'retards_personnel[anneeScolaire]' => 'Testing',
            'retards_personnel[createdBy]' => 'Testing',
            'retards_personnel[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->retardsPersonnelRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new RetardsPersonnel();
        $fixture->setJour('My Title');
        $fixture->setHeure('My Title');
        $fixture->setDuree('My Title');
        $fixture->setMotif('My Title');
        $fixture->setHeureClasse('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setPersonnel('My Title');
        $fixture->setAnneeScolaire('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('RetardsPersonnel');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new RetardsPersonnel();
        $fixture->setJour('Value');
        $fixture->setHeure('Value');
        $fixture->setDuree('Value');
        $fixture->setMotif('Value');
        $fixture->setHeureClasse('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setPersonnel('Value');
        $fixture->setAnneeScolaire('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'retards_personnel[jour]' => 'Something New',
            'retards_personnel[heure]' => 'Something New',
            'retards_personnel[duree]' => 'Something New',
            'retards_personnel[motif]' => 'Something New',
            'retards_personnel[heureClasse]' => 'Something New',
            'retards_personnel[createdAt]' => 'Something New',
            'retards_personnel[updatedAt]' => 'Something New',
            'retards_personnel[slug]' => 'Something New',
            'retards_personnel[personnel]' => 'Something New',
            'retards_personnel[anneeScolaire]' => 'Something New',
            'retards_personnel[createdBy]' => 'Something New',
            'retards_personnel[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/retards/personnel/');

        $fixture = $this->retardsPersonnelRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getJour());
        self::assertSame('Something New', $fixture[0]->getHeure());
        self::assertSame('Something New', $fixture[0]->getDuree());
        self::assertSame('Something New', $fixture[0]->getMotif());
        self::assertSame('Something New', $fixture[0]->getHeureClasse());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getPersonnel());
        self::assertSame('Something New', $fixture[0]->getAnneeScolaire());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new RetardsPersonnel();
        $fixture->setJour('Value');
        $fixture->setHeure('Value');
        $fixture->setDuree('Value');
        $fixture->setMotif('Value');
        $fixture->setHeureClasse('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setPersonnel('Value');
        $fixture->setAnneeScolaire('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/retards/personnel/');
        self::assertSame(0, $this->retardsPersonnelRepository->count([]));
    }
}
