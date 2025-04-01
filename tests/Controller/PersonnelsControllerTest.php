<?php

namespace App\Tests\Controller;

use App\Entity\Personnels;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PersonnelsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $personnelRepository;
    private string $path = '/personnels/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->personnelRepository = $this->manager->getRepository(Personnels::class);

        foreach ($this->personnelRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Personnel index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'personnel[imageName]' => 'Testing',
            'personnel[dateNaissance]' => 'Testing',
            'personnel[sexe]' => 'Testing',
            'personnel[referenceDiplome]' => 'Testing',
            'personnel[isActif]' => 'Testing',
            'personnel[isAllowed]' => 'Testing',
            'personnel[createdAt]' => 'Testing',
            'personnel[updatedAt]' => 'Testing',
            'personnel[slug]' => 'Testing',
            'personnel[nom]' => 'Testing',
            'personnel[prenom]' => 'Testing',
            'personnel[lieuNaissance]' => 'Testing',
            'personnel[telephone1]' => 'Testing',
            'personnel[telephone2]' => 'Testing',
            'personnel[nina]' => 'Testing',
            'personnel[specialites]' => 'Testing',
            'personnel[niveauEtudes]' => 'Testing',
            'personnel[poste]' => 'Testing',
            'personnel[createdBy]' => 'Testing',
            'personnel[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->personnelRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Personnels();
        $fixture->setImageName('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setSexe('My Title');
        $fixture->setReferenceDiplome('My Title');
        $fixture->setIsActif('My Title');
        $fixture->setIsAllowed('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setLieuNaissance('My Title');
        $fixture->setTelephone1('My Title');
        $fixture->setTelephone2('My Title');
        $fixture->setNina('My Title');
        $fixture->setSpecialites('My Title');
        $fixture->setNiveauEtudes('My Title');
        $fixture->setPoste('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Personnel');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Personnels();
        $fixture->setImageName('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setSexe('Value');
        $fixture->setReferenceDiplome('Value');
        $fixture->setIsActif('Value');
        $fixture->setIsAllowed('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setTelephone1('Value');
        $fixture->setTelephone2('Value');
        $fixture->setNina('Value');
        $fixture->setSpecialites('Value');
        $fixture->setNiveauEtudes('Value');
        $fixture->setPoste('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'personnel[imageName]' => 'Something New',
            'personnel[dateNaissance]' => 'Something New',
            'personnel[sexe]' => 'Something New',
            'personnel[referenceDiplome]' => 'Something New',
            'personnel[isActif]' => 'Something New',
            'personnel[isAllowed]' => 'Something New',
            'personnel[createdAt]' => 'Something New',
            'personnel[updatedAt]' => 'Something New',
            'personnel[slug]' => 'Something New',
            'personnel[nom]' => 'Something New',
            'personnel[prenom]' => 'Something New',
            'personnel[lieuNaissance]' => 'Something New',
            'personnel[telephone1]' => 'Something New',
            'personnel[telephone2]' => 'Something New',
            'personnel[nina]' => 'Something New',
            'personnel[specialites]' => 'Something New',
            'personnel[niveauEtudes]' => 'Something New',
            'personnel[poste]' => 'Something New',
            'personnel[createdBy]' => 'Something New',
            'personnel[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/personnels/');

        $fixture = $this->personnelRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getImageName());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getReferenceDiplome());
        self::assertSame('Something New', $fixture[0]->getIsActif());
        self::assertSame('Something New', $fixture[0]->getIsAllowed());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getLieuNaissance());
        self::assertSame('Something New', $fixture[0]->getTelephone1());
        self::assertSame('Something New', $fixture[0]->getTelephone2());
        self::assertSame('Something New', $fixture[0]->getNina());
        self::assertSame('Something New', $fixture[0]->getSpecialites());
        self::assertSame('Something New', $fixture[0]->getNiveauEtudes());
        self::assertSame('Something New', $fixture[0]->getPoste());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Personnels();
        $fixture->setImageName('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setSexe('Value');
        $fixture->setReferenceDiplome('Value');
        $fixture->setIsActif('Value');
        $fixture->setIsAllowed('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setTelephone1('Value');
        $fixture->setTelephone2('Value');
        $fixture->setNina('Value');
        $fixture->setSpecialites('Value');
        $fixture->setNiveauEtudes('Value');
        $fixture->setPoste('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/personnels/');
        self::assertSame(0, $this->personnelRepository->count([]));
    }
}
