<?php

namespace App\Tests\Controller;

use App\Entity\EcoleProvenances;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EcoleProvenancesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $ecoleProvenanceRepository;
    private string $path = '/ecole/provenances/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->ecoleProvenanceRepository = $this->manager->getRepository(EcoleProvenances::class);

        foreach ($this->ecoleProvenanceRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EcoleProvenance index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'ecole_provenance[adresse]' => 'Testing',
            'ecole_provenance[telephone]' => 'Testing',
            'ecole_provenance[email]' => 'Testing',
            'ecole_provenance[designation]' => 'Testing',
            'ecole_provenance[createdAt]' => 'Testing',
            'ecole_provenance[updatedAt]' => 'Testing',
            'ecole_provenance[slug]' => 'Testing',
            'ecole_provenance[createdBy]' => 'Testing',
            'ecole_provenance[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->ecoleProvenanceRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new EcoleProvenances();
        $fixture->setAdresse('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setEmail('My Title');
        $fixture->setDesignation('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('EcoleProvenance');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new EcoleProvenances();
        $fixture->setAdresse('Value');
        $fixture->setTelephone('Value');
        $fixture->setEmail('Value');
        $fixture->setDesignation('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'ecole_provenance[adresse]' => 'Something New',
            'ecole_provenance[telephone]' => 'Something New',
            'ecole_provenance[email]' => 'Something New',
            'ecole_provenance[designation]' => 'Something New',
            'ecole_provenance[createdAt]' => 'Something New',
            'ecole_provenance[updatedAt]' => 'Something New',
            'ecole_provenance[slug]' => 'Something New',
            'ecole_provenance[createdBy]' => 'Something New',
            'ecole_provenance[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/ecole/provenances/');

        $fixture = $this->ecoleProvenanceRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new EcoleProvenances();
        $fixture->setAdresse('Value');
        $fixture->setTelephone('Value');
        $fixture->setEmail('Value');
        $fixture->setDesignation('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/ecole/provenances/');
        self::assertSame(0, $this->ecoleProvenanceRepository->count([]));
    }
}
