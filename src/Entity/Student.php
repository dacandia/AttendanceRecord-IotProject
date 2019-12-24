<?php
namespace App\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Students")
 */
class Student{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $idStudent;
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $firstname;
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $lastname;
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $email;
    /**
     * @ORM\Column(type="string", length=12)
     */
    protected $phoneNumber;
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $career;
    /**
     * @ORM\Column(type="string", length=9)
     */
    protected $studentsNumber;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $isActive;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $isArticle34;
    /**
     * @ORM\Column(type="integer")
     */
    protected $createdAt;
    /**
     * @ORM\Column(type="integer")
     */
    protected $updatedAt;

    public function getIdStudent(){
        return $this->idStudent;
    }

    public function setFirstname($firstname){
        $this->firstname = $firstname;
    }
    public function getFirstname(){
        return $this->firstname;
    }

    public function setLastname($lastname){
        $this->lastname = $lastname;
    }
    public function getLastname(){
        return $this->lastname;
    }

    public function getFullName(){
        return $this->lastname.", ".$this->firstname;
    }

    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }

    public function setPhoneNumber($phoneNumber){
        $this->phoneNumber = $phoneNumber;
    }
    public function getPhoneNumber(){
        return $this->phoneNumber;
    }

    public function setCareer($career){
        $this->career = $career;
    }
    public function getCareer(){
        return $this->career;
    }

    public function setStudentsNumber($studentsNumber){
        $this->studentsNumber = $studentsNumber;
    }
    public function getStudentsNumber(){
        return $this->studentsNumber;
    }

    public function setIsActive($isActive){
        $this->isActive = $isActive;
    }
    public function getIsActive(){
        return $this->isActive;
    }

    public function setIsArticle34($isArticle34){
        $this->isArticle34 = $isArticle34;
    }
    public function getIsArticle34(){
        return $this->isArticle34;
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

    public function __toString(){
        return $this->getFirstname();
    }
}