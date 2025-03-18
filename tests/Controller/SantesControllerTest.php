<?php

namespace App\Tests\Controller;

use App\Entity\Santes;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SantesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $santeRepository;
    private string $path = '/santes/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->santeRepository = $this->manager->getRepository(Santes::class);

        foreach ($this->santeRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sante index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'sante[maladie]' => 'Testing',
            'sante[medecin]' => 'Testing',
            'sante[numeroUrgence]' => 'Testing',
            'sante[centreSante]' => 'Testing',
            'sante[eleve]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->santeRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Santes();
        $fixture->setMaladie('My Title');
        $fixture->setMedecin('My Title');
        $fixture->setNumeroUrgence('My Title');
        $fixture->setCentreSante('My Title');
        $fixture->setEleve('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sante');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Santes();
        $fixture->setMaladie('Value');
        $fixture->setMedecin('Value');
        $fixture->setNumeroUrgence('Value');
        $fixture->setCentreSante('Value');
        $fixture->setEleve('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'sante[maladie]' => 'Something New',
            'sante[medecin]' => 'Something New',
            'sante[numeroUrgence]' => 'Something New',
            'sante[centreSante]' => 'Something New',
            'sante[eleve]' => 'Something New',
        ]);

        self::assertResponseRedirects('/santes/');

        $fixture = $this->santeRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getMaladie());
        self::assertSame('Something New', $fixture[0]->getMedecin());
        self::assertSame('Something New', $fixture[0]->getNumeroUrgence());
        self::assertSame('Something New', $fixture[0]->getCentreSante());
        self::assertSame('Something New', $fixture[0]->getEleve());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Santes();
        $fixture->setMaladie('Value');
        $fixture->setMedecin('Value');
        $fixture->setNumeroUrgence('Value');
        $fixture->setCentreSante('Value');
        $fixture->setEleve('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/santes/');
        self::assertSame(0, $this->santeRepository->count([]));
    }
}
