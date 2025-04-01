<?php

namespace App\Tests\Controller;

use App\Entity\Absences;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AbsencesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $absenceRepository;
    private string $path = '/absences/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->absenceRepository = $this->manager->getRepository(Absences::class);

        foreach ($this->absenceRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Absence index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'absence[jour]' => 'Testing',
            'absence[isJustify]' => 'Testing',
            'absence[motif]' => 'Testing',
            'absence[createdAt]' => 'Testing',
            'absence[updatedAt]' => 'Testing',
            'absence[slug]' => 'Testing',
            'absence[eleve]' => 'Testing',
            'absence[anneeScolaire]' => 'Testing',
            'absence[createdBy]' => 'Testing',
            'absence[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->absenceRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Absences();
        $fixture->setJour('My Title');
        $fixture->setIsJustify('My Title');
        $fixture->setMotif('My Title');
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
        self::assertPageTitleContains('Absence');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Absences();
        $fixture->setJour('Value');
        $fixture->setIsJustify('Value');
        $fixture->setMotif('Value');
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
            'absence[jour]' => 'Something New',
            'absence[isJustify]' => 'Something New',
            'absence[motif]' => 'Something New',
            'absence[createdAt]' => 'Something New',
            'absence[updatedAt]' => 'Something New',
            'absence[slug]' => 'Something New',
            'absence[eleve]' => 'Something New',
            'absence[anneeScolaire]' => 'Something New',
            'absence[createdBy]' => 'Something New',
            'absence[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/absences/');

        $fixture = $this->absenceRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getJour());
        self::assertSame('Something New', $fixture[0]->getIsJustify());
        self::assertSame('Something New', $fixture[0]->getMotif());
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
        $fixture = new Absences();
        $fixture->setJour('Value');
        $fixture->setIsJustify('Value');
        $fixture->setMotif('Value');
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

        self::assertResponseRedirects('/absences/');
        self::assertSame(0, $this->absenceRepository->count([]));
    }
}
