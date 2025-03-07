<?php

namespace App\Tests\Controller;

use App\Entity\Meres;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class MeresControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $mereRepository;
    private string $path = '/meres/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->mereRepository = $this->manager->getRepository(Meres::class);

        foreach ($this->mereRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Mere index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'mere[fullname]' => 'Testing',
            'mere[nom]' => 'Testing',
            'mere[prenom]' => 'Testing',
            'mere[profession]' => 'Testing',
            'mere[telephone1]' => 'Testing',
            'mere[telephone2]' => 'Testing',
            'mere[ninas]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->mereRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Meres();
        $fixture->setFullname('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setProfession('My Title');
        $fixture->setTelephone1('My Title');
        $fixture->setTelephone2('My Title');
        $fixture->setNinas('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Mere');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Meres();
        $fixture->setFullname('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setProfession('Value');
        $fixture->setTelephone1('Value');
        $fixture->setTelephone2('Value');
        $fixture->setNinas('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'mere[fullname]' => 'Something New',
            'mere[nom]' => 'Something New',
            'mere[prenom]' => 'Something New',
            'mere[profession]' => 'Something New',
            'mere[telephone1]' => 'Something New',
            'mere[telephone2]' => 'Something New',
            'mere[ninas]' => 'Something New',
        ]);

        self::assertResponseRedirects('/meres/');

        $fixture = $this->mereRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFullname());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getProfession());
        self::assertSame('Something New', $fixture[0]->getTelephone1());
        self::assertSame('Something New', $fixture[0]->getTelephone2());
        self::assertSame('Something New', $fixture[0]->getNinas());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Meres();
        $fixture->setFullname('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setProfession('Value');
        $fixture->setTelephone1('Value');
        $fixture->setTelephone2('Value');
        $fixture->setNinas('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/meres/');
        self::assertSame(0, $this->mereRepository->count([]));
    }
}
