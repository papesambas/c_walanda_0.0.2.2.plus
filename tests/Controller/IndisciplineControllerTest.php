<?php

namespace App\Tests\Controller;

use App\Entity\Indiscipline;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class IndisciplineControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $indisciplineRepository;
    private string $path = '/indiscipline/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->indisciplineRepository = $this->manager->getRepository(Indiscipline::class);

        foreach ($this->indisciplineRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Indiscipline index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'indiscipline[jour]' => 'Testing',
            'indiscipline[description]' => 'Testing',
            'indiscipline[isSanction]' => 'Testing',
            'indiscipline[sanction]' => 'Testing',
            'indiscipline[createdAt]' => 'Testing',
            'indiscipline[updatedAt]' => 'Testing',
            'indiscipline[slug]' => 'Testing',
            'indiscipline[eleve]' => 'Testing',
            'indiscipline[anneeScolaire]' => 'Testing',
            'indiscipline[createdBy]' => 'Testing',
            'indiscipline[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->indisciplineRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Indiscipline();
        $fixture->setJour('My Title');
        $fixture->setDescription('My Title');
        $fixture->setIsSanction('My Title');
        $fixture->setSanction('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setEleve('My Title');
        $fixture->setAnneeScolaire('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Indiscipline');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Indiscipline();
        $fixture->setJour('Value');
        $fixture->setDescription('Value');
        $fixture->setIsSanction('Value');
        $fixture->setSanction('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setEleve('Value');
        $fixture->setAnneeScolaire('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'indiscipline[jour]' => 'Something New',
            'indiscipline[description]' => 'Something New',
            'indiscipline[isSanction]' => 'Something New',
            'indiscipline[sanction]' => 'Something New',
            'indiscipline[createdAt]' => 'Something New',
            'indiscipline[updatedAt]' => 'Something New',
            'indiscipline[slug]' => 'Something New',
            'indiscipline[eleve]' => 'Something New',
            'indiscipline[anneeScolaire]' => 'Something New',
            'indiscipline[createdBy]' => 'Something New',
            'indiscipline[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/indiscipline/');

        $fixture = $this->indisciplineRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getJour());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getIsSanction());
        self::assertSame('Something New', $fixture[0]->getSanction());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getEleve());
        self::assertSame('Something New', $fixture[0]->getAnneeScolaire());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Indiscipline();
        $fixture->setJour('Value');
        $fixture->setDescription('Value');
        $fixture->setIsSanction('Value');
        $fixture->setSanction('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setEleve('Value');
        $fixture->setAnneeScolaire('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/indiscipline/');
        self::assertSame(0, $this->indisciplineRepository->count([]));
    }
}
