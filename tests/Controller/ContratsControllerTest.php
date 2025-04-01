<?php

namespace App\Tests\Controller;

use App\Entity\Contrats;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ContratsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $contratRepository;
    private string $path = '/contrats/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->contratRepository = $this->manager->getRepository(Contrats::class);

        foreach ($this->contratRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Contrat index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'contrat[dateSignature]' => 'Testing',
            'contrat[dateDebut]' => 'Testing',
            'contrat[dateFin]' => 'Testing',
            'contrat[particularites]' => 'Testing',
            'contrat[isActif]' => 'Testing',
            'contrat[tauxHoraire]' => 'Testing',
            'contrat[createdAt]' => 'Testing',
            'contrat[updatedAt]' => 'Testing',
            'contrat[slug]' => 'Testing',
            'contrat[designation]' => 'Testing',
            'contrat[personnels]' => 'Testing',
            'contrat[typeContrat]' => 'Testing',
            'contrat[createdBy]' => 'Testing',
            'contrat[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->contratRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Contrats();
        $fixture->setDateSignature('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setParticularites('My Title');
        $fixture->setIsActif('My Title');
        $fixture->setTauxHoraire('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setDesignation('My Title');
        $fixture->setPersonnels('My Title');
        $fixture->setTypeContrat('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Contrat');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Contrats();
        $fixture->setDateSignature('Value');
        $fixture->setDateDebut('Value');
        $fixture->setDateFin('Value');
        $fixture->setParticularites('Value');
        $fixture->setIsActif('Value');
        $fixture->setTauxHoraire('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setDesignation('Value');
        $fixture->setPersonnels('Value');
        $fixture->setTypeContrat('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'contrat[dateSignature]' => 'Something New',
            'contrat[dateDebut]' => 'Something New',
            'contrat[dateFin]' => 'Something New',
            'contrat[particularites]' => 'Something New',
            'contrat[isActif]' => 'Something New',
            'contrat[tauxHoraire]' => 'Something New',
            'contrat[createdAt]' => 'Something New',
            'contrat[updatedAt]' => 'Something New',
            'contrat[slug]' => 'Something New',
            'contrat[designation]' => 'Something New',
            'contrat[personnels]' => 'Something New',
            'contrat[typeContrat]' => 'Something New',
            'contrat[createdBy]' => 'Something New',
            'contrat[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/contrats/');

        $fixture = $this->contratRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateSignature());
        self::assertSame('Something New', $fixture[0]->getDateDebut());
        self::assertSame('Something New', $fixture[0]->getDateFin());
        self::assertSame('Something New', $fixture[0]->getParticularites());
        self::assertSame('Something New', $fixture[0]->getIsActif());
        self::assertSame('Something New', $fixture[0]->getTauxHoraire());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getDesignation());
        self::assertSame('Something New', $fixture[0]->getPersonnels());
        self::assertSame('Something New', $fixture[0]->getTypeContrat());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Contrats();
        $fixture->setDateSignature('Value');
        $fixture->setDateDebut('Value');
        $fixture->setDateFin('Value');
        $fixture->setParticularites('Value');
        $fixture->setIsActif('Value');
        $fixture->setTauxHoraire('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setDesignation('Value');
        $fixture->setPersonnels('Value');
        $fixture->setTypeContrat('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/contrats/');
        self::assertSame(0, $this->contratRepository->count([]));
    }
}
