<?php
namespace Tests\AuthenticationBundle\RelationshipVoter;

use Ilios\AuthenticationBundle\RelationshipVoter\AbstractVoter;
use Ilios\AuthenticationBundle\RelationshipVoter\Vocabulary as Voter;
use Ilios\AuthenticationBundle\Service\PermissionChecker;
use Ilios\CoreBundle\Entity\Vocabulary;
use Ilios\CoreBundle\Entity\DTO\VocabularyDTO;
use Ilios\CoreBundle\Entity\School;
use Mockery as m;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class VocabularyTest extends AbstractBase
{
    public function setup()
    {
        $this->permissionChecker = m::mock(PermissionChecker::class);
        $this->voter = new Voter($this->permissionChecker);
    }

    public function testAllowsRootFullAccess()
    {
        $this->checkRootAccess(Vocabulary::class, VocabularyDTO::class);
    }

    public function testCanViewDTO()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $dto = m::mock(VocabularyDTO::class);
        $dto->id = 1;
        $dto->school = 1;
        $this->permissionChecker->shouldReceive('canReadVocabulary')->andReturn(true);
        $response = $this->voter->vote($token, $dto, [AbstractVoter::VIEW]);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $response, "DTO View allowed");
    }

    public function testCanNotViewDTO()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $dto = m::mock(VocabularyDTO::class);
        $dto->id = 1;
        $dto->school = 1;
        $this->permissionChecker->shouldReceive('canReadVocabulary')->andReturn(false);
        $response = $this->voter->vote($token, $dto, [AbstractVoter::VIEW]);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $response, "DTO View denied");
    }

    public function testCanView()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $entity = m::mock(Vocabulary::class);
        $entity->shouldReceive('getId')->andReturn(1);
        $school = m::mock(School::class);
        $school->shouldReceive('getId')->andReturn(1);
        $entity->shouldReceive('getSchool')->andReturn($school);
        $this->permissionChecker->shouldReceive('canReadVocabulary')->andReturn(true);
        $response = $this->voter->vote($token, $entity, [AbstractVoter::VIEW]);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $response, "View allowed");
    }

    public function testCanNotView()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $entity = m::mock(Vocabulary::class);
        $entity->shouldReceive('getId')->andReturn(1);
        $school = m::mock(School::class);
        $school->shouldReceive('getId')->andReturn(1);
        $entity->shouldReceive('getSchool')->andReturn($school);
        $this->permissionChecker->shouldReceive('canReadVocabulary')->andReturn(false);
        $response = $this->voter->vote($token, $entity, [AbstractVoter::VIEW]);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $response, "View denied");
    }

    public function testCanEdit()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $entity = m::mock(Vocabulary::class);
        $entity->shouldReceive('getId')->andReturn(1);
        $school = m::mock(School::class);
        $school->shouldReceive('getId')->andReturn(1);
        $entity->shouldReceive('getSchool')->andReturn($school);
        $this->permissionChecker->shouldReceive('canUpdateVocabulary')->andReturn(true);
        $response = $this->voter->vote($token, $entity, [AbstractVoter::EDIT]);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $response, "Edit allowed");
    }

    public function testCanNotEdit()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $entity = m::mock(Vocabulary::class);
        $entity->shouldReceive('getId')->andReturn(1);
        $school = m::mock(School::class);
        $school->shouldReceive('getId')->andReturn(1);
        $entity->shouldReceive('getSchool')->andReturn($school);
        $this->permissionChecker->shouldReceive('canUpdateVocabulary')->andReturn(false);
        $response = $this->voter->vote($token, $entity, [AbstractVoter::EDIT]);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $response, "Edit denied");
    }

    public function testCanDelete()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $entity = m::mock(Vocabulary::class);
        $entity->shouldReceive('getId')->andReturn(1);
        $school = m::mock(School::class);
        $school->shouldReceive('getId')->andReturn(1);
        $entity->shouldReceive('getSchool')->andReturn($school);
        $this->permissionChecker->shouldReceive('canDeleteVocabulary')->andReturn(true);
        $response = $this->voter->vote($token, $entity, [AbstractVoter::DELETE]);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $response, "Delete allowed");
    }

    public function testCanNotDelete()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $entity = m::mock(Vocabulary::class);
        $entity->shouldReceive('getId')->andReturn(1);
        $school = m::mock(School::class);
        $school->shouldReceive('getId')->andReturn(1);
        $entity->shouldReceive('getSchool')->andReturn($school);
        $this->permissionChecker->shouldReceive('canDeleteVocabulary')->andReturn(false);
        $response = $this->voter->vote($token, $entity, [AbstractVoter::DELETE]);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $response, "Delete delete");
    }

    public function testCanCreate()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $entity = m::mock(Vocabulary::class);
        $school = m::mock(School::class);
        $school->shouldReceive('getId')->andReturn(1);
        $entity->shouldReceive('getSchool')->andReturn($school);
        $this->permissionChecker->shouldReceive('canCreateVocabulary')->andReturn(true);
        $response = $this->voter->vote($token, $entity, [AbstractVoter::CREATE]);
        $this->assertEquals(VoterInterface::ACCESS_GRANTED, $response, "Create allowed");
    }

    public function testCanNotCreate()
    {
        $token = $this->createMockTokenWithNonRootSessionUser();
        $entity = m::mock(Vocabulary::class);
        $school = m::mock(School::class);
        $school->shouldReceive('getId')->andReturn(1);
        $entity->shouldReceive('getSchool')->andReturn($school);
        $this->permissionChecker->shouldReceive('canCreateVocabulary')->andReturn(false);
        $response = $this->voter->vote($token, $entity, [AbstractVoter::CREATE]);
        $this->assertEquals(VoterInterface::ACCESS_DENIED, $response, "Create denied");
    }
}