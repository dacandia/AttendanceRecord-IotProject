<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Registration;
use App\Entity\Student;

class RecordController extends AbstractController{
    public function index(Request $request){
        return $this->render('BaseTemplate/base.html.twig');
    }

    /**
     * @Route("/record/registerAttendance")
     */
    public function AttendanceRecord(Request $request){
        //instance of entity manager
        $em = $this->getDoctrine()->getManager();
        //Calculate the beginning and the end of the day
        $beginningOfDay = new \DateTime();
        $beginningOfDay->setTime(0,0,0);
        //$beginningOfDay = $day->getTimestamp();
        $endOfDay =  new \DateTime();
        $endOfDay->setTime(23,59,59);
        //Message to return as response
        $message = "";
        //If is called from POST method go here
        if($request->getMethod()=="POST"){
            //decode Json Message
            $data = \json_decode($request->getContent(),true);
            //if($request->request->get('key')=="EMfRuYi5zURvvP6LR19E"){
            if($data['key']=="EMfRuYi5zURvvP6LR19E"){
                //Look for the student with the received student code
                $student = $em->getRepository(Student::class)->findOneBy(array('studentsNumber'=>$data['studentsNumber']));
                //Look if the student has a record today
                if($student){
                    $qb = $em->createQueryBuilder();
                    $qb->select('r')
                        ->from('App\Entity\Registration', 'r')
                        ->join('App\Entity\Student','s','WITH','s.idStudent=r.student')
                        ->where('r.registrationTime>=?1 AND r.registrationTime<=?2 AND r.student=?3')
                        ->setParameter(1,$beginningOfDay->getTimestamp())
                        ->setParameter(2,$endOfDay->getTimestamp())
                        ->setParameter(3,$student->getIdStudent());
                    $query = $qb->getQuery();
                    $record = $query->getResult();
                    //If the student doesn't have a record go here
                    if(!$record){
                        //instanceof DateTime to generate the timestamp date
                        $date = new \DateTime();
                        $dateTimestamp = $date->getTimestamp();
                        //instanceof an object of Registration type 
                        $registration = new Registration();
                        $registration->setStudent($student);
                        $registration->setRegistrationTime($dateTimestamp);
                        $registration->setKeySubject($data['keySubject']);
                        $registration->setCreatedAt($dateTimestamp);
                        $registration->setUpdatedAt($dateTimestamp);
                        //Reserve the space in to the db
                        $em->persist($registration);
                        //Set the object in the db
                        $em->flush();
                        $message = '<h1>Successfully Stored Information</h1>
                                    <h2>Students Number: '.$data['studentsNumber'].'</h2>
                                    <h2>key Subject: '.$data['keySubject'].'</h2>';
                    }else{
                        $message = '<h1>The student already has a record today</h1>';
                    }
                }else{
                    $message = '<h1>Student don\'t found</h1>';
                }
            }else{
                $message = '<h1>Invalid Key</h1>';
            }
        }else{
            $message = '<h1>Method not allow</h1>';
        }
        return new Response(
            '<html>
                <body>'.
                    $message
                .'</body>
            </html>'
        );
    }
    /**
     * @Route("/record/attendance_analytics")
     */
    public function AttendanceAnalitics(Request $request){
        //Instanceof Dates (initial and final date)
        //$initialDate = new \DateTime();
        $initialDate = new \DateTime();
        $finalDate = new \DateTime();
        //If the method is post go here
        if($request->getMethod()=="POST"){
            $initialDate = new \DateTime($request->request->get('initialDate'));
            $finalDate = new \DateTime($request->request->get('finalDate'));
        }
        //set a specific hour 
        $initialDate->setTime(0,0,0);
        $finalDate->setTime(23,59,59);
        //Instanceof the Entity Manager
        $em = $this->getDoctrine()->getManager();
        //Instanceof the Query Builder
        $qb = $em->createQueryBuilder();
        //Query to look for the information
        $qb->select('count(r.student) as records','s.lastname')
            ->from('App\Entity\Registration','r')
            ->join('App\Entity\Student','s','WITH','s.idStudent=r.student')
            ->where('r.registrationTime>=?1 AND r.registrationTime<=?2')
            ->groupBy('r.student')
            ->orderBy('records','DESC')
            ->setParameter(1,$initialDate->getTimestamp())
            ->setParameter(2,$finalDate->getTimestamp());
        $query = $qb->getQuery();
        $students = $query->getResult();

        //Variable to storage the lastnames
        $studentsName = array();
        //Variable to storage the records
        $studentRecords = array();
        //Foreach to add the data to the previous arrays
        foreach($students as $student){
            array_push($studentsName, $student["lastname"]);
            array_push($studentRecords, $student["records"]);
        }

        return $this->render('Analytics/analytics.html.twig',
                        array('students'=>$studentsName, 
                                'records'=>$studentRecords
                            )
                        );
    }
    /**
     * @Route("/record/attendance")
     */
    public function AttendanceTable(Request $request){
        $studentsName = null;
        $students = null;
        //Instanceof Entity Manager
        $em = $this->getDoctrine()->getManager();
        $studentsName = $request->query->get('student');
        if($studentsName){
            $qb = $em->createQueryBuilder();
            $qb->select('r')
                ->from('App\Entity\Registration','r')
                ->join('App\Entity\Student','s','WITH','s.idStudent=r.student')
                ->where('s.lastname=?1')
                ->setParameter(1,$studentsName);
            $query = $qb->getQuery();
            $students = $query->getResult(); 
        }else{
            $students = $em->getRepository(Registration::class)->findAll();
        }
        return $this->render('Analytics/analyticsTable.html.twig',array('students'=>$students));
    }
}