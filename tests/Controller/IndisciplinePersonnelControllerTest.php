<?php

namespace App\Tests\Controller;

use App\Entity\IndisciplinePersonnel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class IndisciplinePersonnelControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $indisciplinePersonnelRepository;
    private string $path = '/indiscipline/personnel/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->indisciplinePersonnelRepository = $this->manager->getRepository(IndisciplinePersonnel::class);

        foreach ($this->indisciplinePersonnelRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('IndisciplinePersonnel index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'indiscipline_personnel[jour]' => 'Testing',
            'indiscipline_personnel[description]' => 'Testing',
            'indiscipline_personnel[isSanction]' => 'Testing',
            'indiscipline_personnel[sanction]' => 'Testing',
            'indiscipline_personnel[createdAt]' => 'Testing',
            'indiscipline_personnel[updatedAt]' => 'Testing',
            'indiscipline_personnel[slug]' => 'Testing',
            'indiscipline_personnel[personnel]' => 'Testing',
            'indiscipline_personnel[anneeScolaire]' => 'Testing',
            'indiscipline_personnel[createdBy]' => 'Testing',
            'indiscipline_personnel[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->indisciplinePersonnelRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new IndisciplinePersonnel();
        $fixture->setJour('My Title');
        $fixture->setDescription('My Title');
        $fixture->setIsSanction('My Title');
        $fixture->setSanction('My Title');
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
        self::assertPageTitleContains('IndisciplinePersonnel');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new IndisciplinePersonnel();
        $fixture->setJour('Value');
        $fixture->setDescription('Value');
        $fixture->setIsSanction('Value');
        $fixture->setSanction('Value');
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
            'indiscipline_personnel[jour]' => 'Something New',
            'indiscipline_personnel[description]' => 'Something New',
            'indiscipline_personnel[isSanction]' => 'Something New',
            'indiscipline_personnel[sanction]' => 'Something New',
            'indiscipline_personnel[createdAt]' => 'Something New',
            'indiscipline_personnel[updatedAt]' => 'Something New',
            'indiscipline_personnel[slug]' => 'Something New',
            'indiscipline_personnel[personnel]' => 'Something New',
            'indiscipline_personnel[anneeScolaire]' => 'Something New',
            'indiscipline_personnel[createdBy]' => 'Something New',
            'indiscipline_personnel[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/indiscipline/personnel/');

        $fixture = $this->indisciplinePersonnelRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getJour());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getIsSanction());
        self::assertSame('Something New', $fixture[0]->getSanction());
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
        $fixture = new IndisciplinePersonnel();
        $fixture->setJour('Value');
        $fixture->setDescription('Value');
        $fixture->setIsSanction('Value');
        $fixture->setSanction('Value');
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

        self::assertResponseRedirects('/indiscipline/personnel/');
        self::assertSame(0, $this->indisciplinePersonnelRepository->count([]));
    }
}
