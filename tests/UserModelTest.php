<?php

use App\Models\UserModel;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

final class UserModelTest extends TestCase
{
    protected UserModel $user;

    protected function setUp(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env');
        $this->user = new UserModel;
    }

    /**
     * @covers UserModel
     */
    public function testUserModelClassHasEmptyAttributesOnInstantiation()
    {
        $this->assertInstanceOf(UserModel::class, $this->user);

        $this->assertClassHasAttribute('id', UserModel::class);
        $this->assertClassHasAttribute('firstName', UserModel::class);
        $this->assertClassHasAttribute('lastName', UserModel::class);
        $this->assertClassHasAttribute('email', UserModel::class);
        $this->assertClassHasAttribute('password', UserModel::class);

        $this->assertEmpty($this->user->getId());
        $this->assertEmpty($this->user->getFirstName());
        $this->assertEmpty($this->user->getLastName());
        $this->assertEmpty($this->user->getEmail());
        $this->assertEmpty($this->user->getPassword());
    }

    /**
     * @covers UserModel::getId
     * @covers UserModel::setId
     */
    public function testShouldReturnValidId()
    {
        $this->user->setId(1);
        $this->assertEquals('1', $this->user->getId());

        $this->user->setId(-1);
        $this->assertEmpty($this->user->getId());
    }

    /**
     * @covers UserModel::getFirstName
     * @covers UserModel::setFirstName
     */
    public function testCanStoreAndReturnValidFirstName()
    {
        // When first name is correctely formated
        $this->user->setFirstName('Firstname');
        $this->assertEquals('Firstname', $this->user->getFirstName());

        // When first name start or end with spaces
        $this->user->setFirstName('    Firstname   ');
        $this->assertEquals('Firstname', $this->user->getFirstName());

        // When first name is not correctly formatted
        $this->user->setFirstName('FirstName');
        $this->assertEquals('Firstname', $this->user->getFirstName());

        // When first name don't start with an uppercase
        $this->user->setFirstName('firstname');
        $this->assertEquals('Firstname', $this->user->getFirstName());

        // When first name is composed with hyphen
        $this->user->setFirstName('Jean-michel');
        $this->assertEquals('Jean-Michel', $this->user->getFirstName());

        // When first name is composed with space
        $this->user->setFirstName('Jean michel');
        $this->assertEquals('Jean Michel', $this->user->getFirstName());

        // When first name contain unauthorised characters
        $this->user->setFirstName('F!rstN@me');
        $this->assertEmpty($this->user->getFirstName());

        // When first name contain quotes
        $this->user->setFirstName("O'brien");
        $this->assertEquals("O'Brien", $this->user->getFirstName());
    }

    /**
     * @covers UserModel::getLastName
     * @covers UserModel::setLastName
     */
    public function testCanStoreAndReturnValidLastName()
    {
        // When last name is correctely formated
        $this->user->setLastName('LASTNAME');
        $this->assertEquals('LASTNAME', $this->user->getLastName());

        // When last name start or end with spaces
        $this->user->setLastName('    LASTNAME   ');
        $this->assertEquals('LASTNAME', $this->user->getLastName());

        // When last name is not correctly formatted
        $this->user->setLastName('LastName');
        $this->assertEquals('LASTNAME', $this->user->getLastName());

        // When last name don't start with an uppercase
        $this->user->setLastName('lastname');
        $this->assertEquals('LASTNAME', $this->user->getLastName());

        // When last name is composed with hyphen
        $this->user->setLastName('Doe-John');
        $this->assertEquals('DOE-JOHN', $this->user->getLastName());

        // When last name is composed with apostrophe
        $this->user->setLastName("Doe'John");
        $this->assertEquals("DOE'JOHN", $this->user->getLastName());

        // When last name is composed with space
        $this->user->setLastName('Doe John');
        $this->assertEquals('DOE JOHN', $this->user->getLastName());

        // When last name contain unauthorised characters
        $this->user->setLastName('L@stN@.me');
        $this->assertEmpty($this->user->getLastName());
    }

    /**
     * @covers UserModel::getEmail
     * @covers UserModel::setEmail
     */
    public function testCanStoreAndReturnValidEmail()
    {
        // When email is correctly formated
        $this->user->setEmail('unit@test.com');
        $this->assertEquals('unit@test.com', $this->user->getEmail());

        // When email is not correctly formated
        $this->user->setEmail('UNIT@TEST.com');
        $this->assertEquals('unit@test.com', $this->user->getEmail());

        // When email is not valid
        $this->user->setEmail('not a valid email !');
        $this->assertEmpty($this->user->getEmail());
    }

    /**
     * @covers UserModel::getPassword
     * @covers UserModel::setPassword
     */
    public function testCanStoreAndReturnHashedPassword()
    {
        $this->user->setPassword('password');
        $this->assertTrue(password_verify('password', $this->user->getPassword()));
    }
}
