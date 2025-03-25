<?php

namespace App\Tests\Controller;

use App\Entity\Eleves;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ElevesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $elefeRepository;
    private string $path = '/eleves/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->elefeRepository = $this->manager->getRepository(Eleves::class);

        foreach ($this->elefeRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Elefe index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'elefe[imageName]' => 'Testing',
            'elefe[sexe]' => 'Testing',
            'elefe[dateInscription]' => 'Testing',
            'elefe[dateRecrutement]' => 'Testing',
            'elefe[dateNaissance]' => 'Testing',
            'elefe[dateExtrait]' => 'Testing',
            'elefe[numeroExtrait]' => 'Testing',
            'elefe[isActif]' => 'Testing',
            'elefe[isAllowed]' => 'Testing',
            'elefe[isAdmis]' => 'Testing',
            'elefe[isHandicap]' => 'Testing',
            'elefe[natureHandicape]' => 'Testing',
            'elefe[fullname]' => 'Testing',
            'elefe[statutFinance]' => 'Testing',
            'elefe[matricule]' => 'Testing',
            'elefe[createdAt]' => 'Testing',
            'elefe[updatedAt]' => 'Testing',
            'elefe[slug]' => 'Testing',
            'elefe[nom]' => 'Testing',
            'elefe[prenom]' => 'Testing',
            'elefe[lieuNaissance]' => 'Testing',
            'elefe[parent]' => 'Testing',
            'elefe[user]' => 'Testing',
            'elefe[classe]' => 'Testing',
            'elefe[statut]' => 'Testing',
            'elefe[scolarite1]' => 'Testing',
            'elefe[scolarite2]' => 'Testing',
            'elefe[users]' => 'Testing',
            'elefe[ecoleRecrutement]' => 'Testing',
            'elefe[ecoleAnDernier]' => 'Testing',
            'elefe[redoublement1]' => 'Testing',
            'elefe[redoublement2]' => 'Testing',
            'elefe[redoublement3]' => 'Testing',
            'elefe[createdBy]' => 'Testing',
            'elefe[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->elefeRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setImageName('My Title');
        $fixture->setSexe('My Title');
        $fixture->setDateInscription('My Title');
        $fixture->setDateRecrutement('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setDateExtrait('My Title');
        $fixture->setNumeroExtrait('My Title');
        $fixture->setIsActif('My Title');
        $fixture->setIsAllowed('My Title');
        $fixture->setIsAdmis('My Title');
        $fixture->setIsHandicap('My Title');
        $fixture->setNatureHandicape('My Title');
        $fixture->setFullname('My Title');
        $fixture->setStatutFinance('My Title');
        $fixture->setMatricule('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setLieuNaissance('My Title');
        $fixture->setParent('My Title');
        $fixture->setUser('My Title');
        $fixture->setClasse('My Title');
        $fixture->setStatut('My Title');
        $fixture->setScolarite1('My Title');
        $fixture->setScolarite2('My Title');
        $fixture->setUsers('My Title');
        $fixture->setEcoleRecrutement('My Title');
        $fixture->setEcoleAnDernier('My Title');
        $fixture->setRedoublement1('My Title');
        $fixture->setRedoublement2('My Title');
        $fixture->setRedoublement3('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Elefe');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setImageName('Value');
        $fixture->setSexe('Value');
        $fixture->setDateInscription('Value');
        $fixture->setDateRecrutement('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setDateExtrait('Value');
        $fixture->setNumeroExtrait('Value');
        $fixture->setIsActif('Value');
        $fixture->setIsAllowed('Value');
        $fixture->setIsAdmis('Value');
        $fixture->setIsHandicap('Value');
        $fixture->setNatureHandicape('Value');
        $fixture->setFullname('Value');
        $fixture->setStatutFinance('Value');
        $fixture->setMatricule('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setParent('Value');
        $fixture->setUser('Value');
        $fixture->setClasse('Value');
        $fixture->setStatut('Value');
        $fixture->setScolarite1('Value');
        $fixture->setScolarite2('Value');
        $fixture->setUsers('Value');
        $fixture->setEcoleRecrutement('Value');
        $fixture->setEcoleAnDernier('Value');
        $fixture->setRedoublement1('Value');
        $fixture->setRedoublement2('Value');
        $fixture->setRedoublement3('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'elefe[imageName]' => 'Something New',
            'elefe[sexe]' => 'Something New',
            'elefe[dateInscription]' => 'Something New',
            'elefe[dateRecrutement]' => 'Something New',
            'elefe[dateNaissance]' => 'Something New',
            'elefe[dateExtrait]' => 'Something New',
            'elefe[numeroExtrait]' => 'Something New',
            'elefe[isActif]' => 'Something New',
            'elefe[isAllowed]' => 'Something New',
            'elefe[isAdmis]' => 'Something New',
            'elefe[isHandicap]' => 'Something New',
            'elefe[natureHandicape]' => 'Something New',
            'elefe[fullname]' => 'Something New',
            'elefe[statutFinance]' => 'Something New',
            'elefe[matricule]' => 'Something New',
            'elefe[createdAt]' => 'Something New',
            'elefe[updatedAt]' => 'Something New',
            'elefe[slug]' => 'Something New',
            'elefe[nom]' => 'Something New',
            'elefe[prenom]' => 'Something New',
            'elefe[lieuNaissance]' => 'Something New',
            'elefe[parent]' => 'Something New',
            'elefe[user]' => 'Something New',
            'elefe[classe]' => 'Something New',
            'elefe[statut]' => 'Something New',
            'elefe[scolarite1]' => 'Something New',
            'elefe[scolarite2]' => 'Something New',
            'elefe[users]' => 'Something New',
            'elefe[ecoleRecrutement]' => 'Something New',
            'elefe[ecoleAnDernier]' => 'Something New',
            'elefe[redoublement1]' => 'Something New',
            'elefe[redoublement2]' => 'Something New',
            'elefe[redoublement3]' => 'Something New',
            'elefe[createdBy]' => 'Something New',
            'elefe[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/eleves/');

        $fixture = $this->elefeRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getImageName());
        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getDateInscription());
        self::assertSame('Something New', $fixture[0]->getDateRecrutement());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
        self::assertSame('Something New', $fixture[0]->getDateExtrait());
        self::assertSame('Something New', $fixture[0]->getNumeroExtrait());
        self::assertSame('Something New', $fixture[0]->getIsActif());
        self::assertSame('Something New', $fixture[0]->getIsAllowed());
        self::assertSame('Something New', $fixture[0]->getIsAdmis());
        self::assertSame('Something New', $fixture[0]->getIsHandicap());
        self::assertSame('Something New', $fixture[0]->getNatureHandicape());
        self::assertSame('Something New', $fixture[0]->getFullname());
        self::assertSame('Something New', $fixture[0]->getStatutFinance());
        self::assertSame('Something New', $fixture[0]->getMatricule());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getLieuNaissance());
        self::assertSame('Something New', $fixture[0]->getParent());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getClasse());
        self::assertSame('Something New', $fixture[0]->getStatut());
        self::assertSame('Something New', $fixture[0]->getScolarite1());
        self::assertSame('Something New', $fixture[0]->getScolarite2());
        self::assertSame('Something New', $fixture[0]->getUsers());
        self::assertSame('Something New', $fixture[0]->getEcoleRecrutement());
        self::assertSame('Something New', $fixture[0]->getEcoleAnDernier());
        self::assertSame('Something New', $fixture[0]->getRedoublement1());
        self::assertSame('Something New', $fixture[0]->getRedoublement2());
        self::assertSame('Something New', $fixture[0]->getRedoublement3());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setImageName('Value');
        $fixture->setSexe('Value');
        $fixture->setDateInscription('Value');
        $fixture->setDateRecrutement('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setDateExtrait('Value');
        $fixture->setNumeroExtrait('Value');
        $fixture->setIsActif('Value');
        $fixture->setIsAllowed('Value');
        $fixture->setIsAdmis('Value');
        $fixture->setIsHandicap('Value');
        $fixture->setNatureHandicape('Value');
        $fixture->setFullname('Value');
        $fixture->setStatutFinance('Value');
        $fixture->setMatricule('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setParent('Value');
        $fixture->setUser('Value');
        $fixture->setClasse('Value');
        $fixture->setStatut('Value');
        $fixture->setScolarite1('Value');
        $fixture->setScolarite2('Value');
        $fixture->setUsers('Value');
        $fixture->setEcoleRecrutement('Value');
        $fixture->setEcoleAnDernier('Value');
        $fixture->setRedoublement1('Value');
        $fixture->setRedoublement2('Value');
        $fixture->setRedoublement3('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/eleves/');
        self::assertSame(0, $this->elefeRepository->count([]));
    }
}
