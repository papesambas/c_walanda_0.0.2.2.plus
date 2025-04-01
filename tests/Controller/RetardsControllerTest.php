<?php

namespace App\Tests\Controller;

use App\Entity\Retards;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RetardsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $retardRepository;
    private string $path = '/retards/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->retardRepository = $this->manager->getRepository(Retards::class);

        foreach ($this->retardRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Retard index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'retard[jour]' => 'Testing',
            'retard[heure]' => 'Testing',
            'retard[duree]' => 'Testing',
            'retard[isJustify]' => 'Testing',
            'retard[motif]' => 'Testing',
            'retard[createdAt]' => 'Testing',
            'retard[updatedAt]' => 'Testing',
            'retard[slug]' => 'Testing',
            'retard[eleves]' => 'Testing',
            'retard[anneeScolaire]' => 'Testing',
            'retard[createdBy]' => 'Testing',
            'retard[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->retardRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Retards();
        $fixture->setJour('My Title');
        $fixture->setHeure('My Title');
        $fixture->setDuree('My Title');
        $fixture->setIsJustify('My Title');
        $fixture->setMotif('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setEleves('My Title');
        $fixture->setAnneeScolaire('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Retard');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Retards();
        $fixture->setJour('Value');
        $fixture->setHeure('Value');
        $fixture->setDuree('Value');
        $fixture->setIsJustify('Value');
        $fixture->setMotif('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setEleves('Value');
        $fixture->setAnneeScolaire('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'retard[jour]' => 'Something New',
            'retard[heure]' => 'Something New',
            'retard[duree]' => 'Something New',
            'retard[isJustify]' => 'Something New',
            'retard[motif]' => 'Something New',
            'retard[createdAt]' => 'Something New',
            'retard[updatedAt]' => 'Something New',
            'retard[slug]' => 'Something New',
            'retard[eleves]' => 'Something New',
            'retard[anneeScolaire]' => 'Something New',
            'retard[createdBy]' => 'Something New',
            'retard[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/retards/');

        $fixture = $this->retardRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getJour());
        self::assertSame('Something New', $fixture[0]->getHeure());
        self::assertSame('Something New', $fixture[0]->getDuree());
        self::assertSame('Something New', $fixture[0]->getIsJustify());
        self::assertSame('Something New', $fixture[0]->getMotif());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getEleves());
        self::assertSame('Something New', $fixture[0]->getAnneeScolaire());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Retards();
        $fixture->setJour('Value');
        $fixture->setHeure('Value');
        $fixture->setDuree('Value');
        $fixture->setIsJustify('Value');
        $fixture->setMotif('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setEleves('Value');
        $fixture->setAnneeScolaire('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/retards/');
        self::assertSame(0, $this->retardRepository->count([]));
    }
}
