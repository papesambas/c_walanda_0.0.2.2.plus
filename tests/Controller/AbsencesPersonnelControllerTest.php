<?php

namespace App\Tests\Controller;

use App\Entity\AbsencesPersonnel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AbsencesPersonnelControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $absencesPersonnelRepository;
    private string $path = '/absences/personnel/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->absencesPersonnelRepository = $this->manager->getRepository(AbsencesPersonnel::class);

        foreach ($this->absencesPersonnelRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('AbsencesPersonnel index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'absences_personnel[jour]' => 'Testing',
            'absences_personnel[isJustify]' => 'Testing',
            'absences_personnel[motif]' => 'Testing',
            'absences_personnel[heure]' => 'Testing',
            'absences_personnel[createdAt]' => 'Testing',
            'absences_personnel[updatedAt]' => 'Testing',
            'absences_personnel[slug]' => 'Testing',
            'absences_personnel[personnel]' => 'Testing',
            'absences_personnel[anneeScolaire]' => 'Testing',
            'absences_personnel[createdBy]' => 'Testing',
            'absences_personnel[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->absencesPersonnelRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new AbsencesPersonnel();
        $fixture->setJour('My Title');
        $fixture->setIsJustify('My Title');
        $fixture->setMotif('My Title');
        $fixture->setHeure('My Title');
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
        self::assertPageTitleContains('AbsencesPersonnel');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new AbsencesPersonnel();
        $fixture->setJour('Value');
        $fixture->setIsJustify('Value');
        $fixture->setMotif('Value');
        $fixture->setHeure('Value');
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
            'absences_personnel[jour]' => 'Something New',
            'absences_personnel[isJustify]' => 'Something New',
            'absences_personnel[motif]' => 'Something New',
            'absences_personnel[heure]' => 'Something New',
            'absences_personnel[createdAt]' => 'Something New',
            'absences_personnel[updatedAt]' => 'Something New',
            'absences_personnel[slug]' => 'Something New',
            'absences_personnel[personnel]' => 'Something New',
            'absences_personnel[anneeScolaire]' => 'Something New',
            'absences_personnel[createdBy]' => 'Something New',
            'absences_personnel[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/absences/personnel/');

        $fixture = $this->absencesPersonnelRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getJour());
        self::assertSame('Something New', $fixture[0]->getIsJustify());
        self::assertSame('Something New', $fixture[0]->getMotif());
        self::assertSame('Something New', $fixture[0]->getHeure());
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
        $fixture = new AbsencesPersonnel();
        $fixture->setJour('Value');
        $fixture->setIsJustify('Value');
        $fixture->setMotif('Value');
        $fixture->setHeure('Value');
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

        self::assertResponseRedirects('/absences/personnel/');
        self::assertSame(0, $this->absencesPersonnelRepository->count([]));
    }
}
