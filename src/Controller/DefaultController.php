<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Student;

class DefaultController extends AbstractController{
    
    public function index(){
        return $this->render("BaseTemplate/body.html.twig");
    }
    
    /**
     * @Route("/iot/registerStudent")
     */
    public function registerForm(Request $request){
        //If the route is called by POST method go here
        if($request->getMethod()=="POST"){
            //Instantiate an object of DateTime type
            $date = new \DateTime();
            //Create a Student Object to persist into the database
            $student = new Student();
            $student->setFirstname($request->request->get('txtFirstName'));
            $student->setLastname($request->request->get('txtLastName'));
            $student->setEmail($request->request->get('txtEmail'));
            $student->setPhoneNumber($request->request->get('txtPhone'));
            $student->setCareer($request->request->get('txtCareer'));
            $student->setStudentsNumber($request->request->get('txtStudentsNumber'));
            $student->setIsActive($request->request->get('isActive'));
            $student->setIsArticle34($request->request->get('isArticle34'));
            $student->setCreatedAt($date->getTimestamp());
            $student->setUpdatedAt($date->getTimestamp());
            //Instantiate of Entity manager
            $em = $this->getDoctrine()->getManager();
            //Tell Doctrine you want to save the Product (reserve the space)
            $em->persist($student);
            //Executes the querie
            $em->flush();
        }
        return $this->render("CRUD/register.html.twig");
    }
    /**
     * @Route("/iot/searchStudent")
     */
    public function searchForm(Request $request){
        return $this->render("CRUD/searchStudent.html.twig");
    }
    /**
     * @Route("/iot/tableStudent")
     */
    public function tableStudent(Request $request){
        $idStudent = $request->query->get('txtLastName');
        //instanceof the entity manager
        $em = $this->getDoctrine()->getManager();
        //instanceof the query builder object
        $qb = $em->createQueryBuilder();
        //Query syntax
        $qb->select('s')
            ->from('App\Entity\Student','s')
            ->where('s.lastname = ?1')
            ->setParameter(1,$idStudent);
        //istance of Query Object
        $query = $qb->getQuery();
        //Execute the Query
        $result = $query->getResult();
        return $this->render('CRUD/infoTable.html.twig',array('students'=>$result));
    }

    /**
     * @Route("/iot/formStudent")
     */
    public function formStudent(Request $request){
        $lastnameStudent = $request->query->get('studentOption');
        //Instanceof the entity manager
        $em = $this->getDoctrine()->getManager();
        //Instanceof the query builder object
        $qb = $em->createQueryBuilder();
        //Query syntax
        $qb->select('s')
            ->from('App\Entity\Student','s')
            ->where('s.lastname = ?1')
            ->setParameter(1,$lastnameStudent);
        //Instanceof Query Object
        $query = $qb->getQuery();
        //Execute the Query
        $result = $query->getResult();
        //Render the formStudent.html and send to it the result of the query builder
        return $this->render('CRUD/formStudent.html.twig',array('student'=>$result));
    }

    /**
     * @Route("/iot/listStudents")
     */
    public function listAllStudents(){
        $students = $this->getDoctrine()
                    ->getRepository(Student::class)
                    ->findAll();
        return $this->render('CRUD/listStudentTable.html.twig',array('students'=>$students));
    }

    /**
     * @Route("/iot/chageStudent")
     */
    public function changeStudent(Request $request){
        if($request->getMethod()=="POST"){
            //Instantiate an object of DateTime type
            $date = new \DateTime();
            //look for the object in the database
            $em = $this->getDoctrine()->getManager();
            $student = $em->getRepository(Student::class)->find($request->request->get('txtIdStudent'));
            $student->setFirstname($request->request->get('txtFirstName'));
            $student->setLastname($request->request->get('txtLastName'));
            $student->setEmail($request->request->get('txtEmail'));
            $student->setPhoneNumber($request->request->get('txtPhone'));
            $student->setCareer($request->request->get('txtCareer'));
            $student->setStudentsNumber($request->request->get('txtStudentsNumber'));
            $student->setIsActive($request->request->get('isActive'));
            $student->setIsArticle34($request->request->get('isArticle34'));
            $student->setUpdatedAt($date->getTimestamp());
            $em->flush();
        }
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('CRUD/updateStudent.html.twig',array('students'=>$students));
    }

    /**
     * @Route("/iot/deleteStudent")
     */
    public function deleteStudent(Request $request){
        if($request->getMethod() == "POST"){
            $em = $this->getDoctrine()->getManager();
            $student = $em->getRepository(Student::class)->find($request->request->get('studentOption'));
            $em->remove($student);
            $em->flush();
        }
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('CRUD/deleteStudent.html.twig',array('students'=>$students));
    }
}