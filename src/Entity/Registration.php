<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="records")
 */
class Registration{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $idAttendance;
    /**
     * @ORM\Column(type="integer")
     */
    protected $registrationTime;
    /**
     * @ORM\Column(type="string")
     */
    protected $keySubject;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student")
     * @ORM\JoinColumn(name="id_student", referencedColumnName="id_student")
     */
    protected $student;
    /**
     * @ORM\Column(type="integer")
     */
    protected $createdAt;
    /**
     * @ORM\Column(type="integer")
     */
    protected $updatedAt;

    public function getIdAttendance(){
        return $this->idAttendance;
    }
    
    public function setRegistrationTime($registrationTime){
        $this->registrationTime = $registrationTime;
    }
    public function getRegistrationTime(){
        return $this->registrationTime;
    }

    public function setKeySubject($keySubject){
        $this->keySubject = $keySubject;
    }
    public function getKeySubject(){
        return $this->keySubject;
    }

    public function setStudent(\App\Entity\Student $student){
        $this->student = $student;
    }
    public function getStudent(){
        return $this->student;
    }

    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setUpdatedAt($updatedAt){
        $this->updatedAt = $updatedAt;
    }
    public function getUpdatedAt(){
        return $this->updatedAt;
    }
}