<?php

namespace App\DataFixtures;

use App\Entity\Classroom;
use App\Entity\Promotion;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function setPromotions($start, $end)
    {
        $promotion = new Promotion();
        $promotion->setStart($start);
        $promotion->setEnd($end);
        return $promotion;
    }

    public function setClassrooms($label, $promotion)
    {
        $classroom = new Classroom();
        $classroom->setLabel($label);
        $classroom->setPromotion($promotion);
        return $classroom;
    }

    public function setStudents($firstname, $lastname, $age, $entry_date)
    {
        $student = new Student();
        $student->setFirstname($firstname);
        $student->setLastname($lastname);
        $student->setAge($age);
        $student->setEntryDate($entry_date);
        return $student;
    }

    public function setStudentsInClassrooms($student, $classroom, $promotion)
    {
        $student->setClassroom($classroom);
        $student->setPromotion($promotion);
        return $student;
    }


    public function load(ObjectManager $manager)
    {
        /**
         * Promotions : Fixtures
         * App\Entity\Promotion
         */
        $promotions = [
            1 => ['start' => 2021, 'end' => 2026],
            2 => ['start' => 2022, 'end' => 2027],
            3 => ['start' => 2023, 'end' => 2028],
            4 => ['start' => 2024, 'end' => 2029],
            5 => ['start' => 2025, 'end' => 2030]
        ];

        for ($i = 1; $i <= count($promotions); $i++) {
            $promotion = $this->setPromotions($promotions[$i]["start"], $promotions[$i]["end"]);
            $manager->persist($promotion);
        }
        $manager->flush();

        $promotionRepository = $manager->getRepository('App:Promotion')->findAll();

        /**
         * Classrooms : Fixtures
         * App\Entity\Classroom
         */
        $classrooms = [
            1 =>  ['label' => 'A1',    'promotion_id' => $promotionRepository[0]],
            2 =>  ['label' => 'A2-DW', 'promotion_id' => $promotionRepository[0]],
            3 =>  ['label' => 'A2-3D', 'promotion_id' => $promotionRepository[0]],
            4 =>  ['label' => 'A2-CD', 'promotion_id' => $promotionRepository[0]],
            5 =>  ['label' => 'A3-DW', 'promotion_id' => $promotionRepository[0]],
            6 =>  ['label' => 'A3-3D', 'promotion_id' => $promotionRepository[0]],
            7 =>  ['label' => 'A3-CD', 'promotion_id' => $promotionRepository[0]],
            8 =>  ['label' => 'A4-DW', 'promotion_id' => $promotionRepository[0]],
            9 =>  ['label' => 'A4-3D', 'promotion_id' => $promotionRepository[0]],
            10 => ['label' => 'A4-CD', 'promotion_id' => $promotionRepository[0]],
            11 => ['label' => 'A5-DW', 'promotion_id' => $promotionRepository[0]],
            12 => ['label' => 'A5-3D', 'promotion_id' => $promotionRepository[0]],
            13 => ['label' => 'A5-CD', 'promotion_id' => $promotionRepository[0]],
            14 => ['label' => 'A1',    'promotion_id' => $promotionRepository[1]],
            15 => ['label' => 'A2-DW', 'promotion_id' => $promotionRepository[1]],
            16 => ['label' => 'A2-3D', 'promotion_id' => $promotionRepository[1]],
            17 => ['label' => 'A2-CD', 'promotion_id' => $promotionRepository[1]],
            18 => ['label' => 'A3-DW', 'promotion_id' => $promotionRepository[1]],
            19 => ['label' => 'A3-3D', 'promotion_id' => $promotionRepository[1]],
            20 => ['label' => 'A3-CD', 'promotion_id' => $promotionRepository[1]],
            21 => ['label' => 'A4-DW', 'promotion_id' => $promotionRepository[1]],
            22 => ['label' => 'A4-3D', 'promotion_id' => $promotionRepository[1]],
            23 => ['label' => 'A4-CD', 'promotion_id' => $promotionRepository[1]],
            24 => ['label' => 'A5-DW', 'promotion_id' => $promotionRepository[1]],
            25 => ['label' => 'A5-3D', 'promotion_id' => $promotionRepository[1]],
            26 => ['label' => 'A5-CD', 'promotion_id' => $promotionRepository[1]],
            27 => ['label' => 'A1',    'promotion_id' => $promotionRepository[2]],
            28 => ['label' => 'A2-DW', 'promotion_id' => $promotionRepository[2]],
            29 => ['label' => 'A2-3D', 'promotion_id' => $promotionRepository[2]],
            30 => ['label' => 'A2-CD', 'promotion_id' => $promotionRepository[2]],
            31 => ['label' => 'A3-DW', 'promotion_id' => $promotionRepository[2]],
            32 => ['label' => 'A3-3D', 'promotion_id' => $promotionRepository[2]],
            33 => ['label' => 'A3-CD', 'promotion_id' => $promotionRepository[2]],
            34 => ['label' => 'A4-DW', 'promotion_id' => $promotionRepository[2]],
            35 => ['label' => 'A4-3D', 'promotion_id' => $promotionRepository[2]],
            36 => ['label' => 'A4-CD', 'promotion_id' => $promotionRepository[2]],
            37 => ['label' => 'A5-DW', 'promotion_id' => $promotionRepository[2]],
            38 => ['label' => 'A5-3D', 'promotion_id' => $promotionRepository[2]],
            39 => ['label' => 'A5-CD', 'promotion_id' => $promotionRepository[2]],
            40 => ['label' => 'A1',    'promotion_id' => $promotionRepository[3]],
            41 => ['label' => 'A2-DW', 'promotion_id' => $promotionRepository[3]],
            42 => ['label' => 'A2-3D', 'promotion_id' => $promotionRepository[3]],
            43 => ['label' => 'A2-CD', 'promotion_id' => $promotionRepository[3]],
            44 => ['label' => 'A3-DW', 'promotion_id' => $promotionRepository[3]],
            45 => ['label' => 'A3-3D', 'promotion_id' => $promotionRepository[3]],
            46 => ['label' => 'A3-CD', 'promotion_id' => $promotionRepository[3]],
            47 => ['label' => 'A4-DW', 'promotion_id' => $promotionRepository[3]],
            48 => ['label' => 'A4-3D', 'promotion_id' => $promotionRepository[3]],
            49 => ['label' => 'A4-CD', 'promotion_id' => $promotionRepository[3]],
            50 => ['label' => 'A5-DW', 'promotion_id' => $promotionRepository[3]],
            51 => ['label' => 'A5-3D', 'promotion_id' => $promotionRepository[3]],
            52 => ['label' => 'A5-CD', 'promotion_id' => $promotionRepository[3]],
            53 => ['label' => 'A1',    'promotion_id' => $promotionRepository[4]],
            54 => ['label' => 'A2-DW', 'promotion_id' => $promotionRepository[4]],
            55 => ['label' => 'A2-3D', 'promotion_id' => $promotionRepository[4]],
            56 => ['label' => 'A2-CD', 'promotion_id' => $promotionRepository[4]],
            57 => ['label' => 'A3-DW', 'promotion_id' => $promotionRepository[4]],
            58 => ['label' => 'A3-3D', 'promotion_id' => $promotionRepository[4]],
            59 => ['label' => 'A3-CD', 'promotion_id' => $promotionRepository[4]],
            60 => ['label' => 'A4-DW', 'promotion_id' => $promotionRepository[4]],
            61 => ['label' => 'A4-3D', 'promotion_id' => $promotionRepository[4]],
            62 => ['label' => 'A4-CD', 'promotion_id' => $promotionRepository[4]],
            63 => ['label' => 'A5-DW', 'promotion_id' => $promotionRepository[4]],
            64 => ['label' => 'A5-3D', 'promotion_id' => $promotionRepository[4]],
            65 => ['label' => 'A5-CD', 'promotion_id' => $promotionRepository[4]],
        ];

        for ($i = 1; $i <= count($classrooms); $i++) {
            $classroom = $this->setClassrooms($classrooms[$i]["label"], $classrooms[$i]["promotion_id"]);
            $manager->persist($classroom);
        }
        $manager->flush();

        $classroomRepository = $manager->getRepository('App:Classroom')->findAll();

        /**
         * Students : Fixtures
         * App\Entity\Student
         */
        $students = [
            1  => ['firstname' => 'Steven',     'lastname' => 'Sperling',   'age' => '21', 'entry_date' => new \DateTime('01/09/2021')],
            2  => ['firstname' => 'Arlene',     'lastname' => 'McMillian',  'age' => '24', 'entry_date' => new \DateTime('01/09/2021')],
            3  => ['firstname' => 'Craig',      'lastname' => 'Holmes',     'age' => '23', 'entry_date' => new \DateTime('01/09/2021')],
            4  => ['firstname' => 'Dan',        'lastname' => 'Rouse',      'age' => '22', 'entry_date' => new \DateTime('01/09/2021')],
            5  => ['firstname' => 'Jason',      'lastname' => 'Sokolowski', 'age' => '20', 'entry_date' => new \DateTime('01/09/2021')],
            6  => ['firstname' => 'Jeremy',     'lastname' => 'Hines',      'age' => '25', 'entry_date' => new \DateTime('01/09/2021')],
            7  => ['firstname' => 'Fred',       'lastname' => 'Dayton',     'age' => '22', 'entry_date' => new \DateTime('01/09/2021')],
            8  => ['firstname' => 'Brian',      'lastname' => 'Murrin',     'age' => '24', 'entry_date' => new \DateTime('01/09/2021')],
            9  => ['firstname' => 'Sandra',     'lastname' => 'Hinkle',     'age' => '23', 'entry_date' => new \DateTime('01/09/2021')],
            10 => ['firstname' => 'Shirley',    'lastname' => 'Gomez',      'age' => '22', 'entry_date' => new \DateTime('01/09/2021')],
            11 => ['firstname' => 'Darlene',    'lastname' => 'Brady',      'age' => '21', 'entry_date' => new \DateTime('01/09/2021')],
            12 => ['firstname' => 'Despina',    'lastname' => 'Johnson',    'age' => '20', 'entry_date' => new \DateTime('01/09/2021')],
            13 => ['firstname' => 'Nicholas',   'lastname' => 'Jones',      'age' => '24', 'entry_date' => new \DateTime('01/09/2021')],
            14 => ['firstname' => 'Bobby',      'lastname' => 'Valenzuela', 'age' => '25', 'entry_date' => new \DateTime('01/09/2021')],
            15 => ['firstname' => 'Lacey',      'lastname' => 'Taylor',     'age' => '23', 'entry_date' => new \DateTime('01/09/2021')],
            16 => ['firstname' => 'Chris',      'lastname' => 'Lea',        'age' => '23', 'entry_date' => new \DateTime('01/09/2021')],
            17 => ['firstname' => 'Ronald',     'lastname' => 'Branham',    'age' => '22', 'entry_date' => new \DateTime('01/09/2021')],
            18 => ['firstname' => 'James',      'lastname' => 'Wolfe',      'age' => '21', 'entry_date' => new \DateTime('01/09/2021')],
            19 => ['firstname' => 'Henry',      'lastname' => 'Yu',         'age' => '24', 'entry_date' => new \DateTime('01/09/2021')],
            20 => ['firstname' => 'Stacey',     'lastname' => 'Carter',     'age' => '20', 'entry_date' => new \DateTime('01/09/2021')],
            21 => ['firstname' => 'Felicidad',  'lastname' => 'Daily',      'age' => '20', 'entry_date' => new \DateTime('01/09/2021')],
            22 => ['firstname' => 'Ricardo',    'lastname' => 'Link',       'age' => '24', 'entry_date' => new \DateTime('01/09/2021')],
            23 => ['firstname' => 'Katie',      'lastname' => 'Nathan',     'age' => '25', 'entry_date' => new \DateTime('01/09/2021')],
            24 => ['firstname' => 'Philip',     'lastname' => 'Dowdle',     'age' => '25', 'entry_date' => new \DateTime('01/09/2021')],
            25 => ['firstname' => 'Douglas',    'lastname' => 'Rush',       'age' => '22', 'entry_date' => new \DateTime('01/09/2021')],
            26 => ['firstname' => 'Blanche',    'lastname' => 'Travers',    'age' => '23', 'entry_date' => new \DateTime('01/09/2021')],
            27 => ['firstname' => 'Harold',     'lastname' => 'Barringer',  'age' => '25', 'entry_date' => new \DateTime('01/09/2021')],
            28 => ['firstname' => 'Sharon',     'lastname' => 'Murakami',   'age' => '20', 'entry_date' => new \DateTime('01/09/2021')],
            29 => ['firstname' => 'Michelle',   'lastname' => 'Rolland',    'age' => '21', 'entry_date' => new \DateTime('01/09/2021')],
            30 => ['firstname' => 'Luke',       'lastname' => 'Mohler',     'age' => '23', 'entry_date' => new \DateTime('01/09/2021')],
        ];

        // A1 - 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[0], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A2-DW 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[1], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A2-3D 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[2], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A2-CD 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[3], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A3-DW 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[4], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A3-3D 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[5], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A3-CD 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[6], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A4-DW 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[7], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A4-3D 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[8], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A4-CD 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[9], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A5-DW 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[10], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A5-3D 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[11], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();
        // A5-CD 2021/2026
        for ($i = 1; $i <= count($students); $i++) {
            $initStudent = $this->setStudents($students[$i]["firstname"], $students[$i]["lastname"], $students[$i]["age"], $students[$i]["entry_date"]);
            $student = $this->setStudentsInClassrooms($initStudent, $classroomRepository[12], $promotionRepository[0]);
            $manager->persist($student);
        }
        $manager->flush();

        /**
         * Teachers : Fixtures
         * App\Entity\Teacher
         */


        /**
         * Courses : Fixtures
         * App\Entity\Course
         */


        /**
         * Results : Fixtures
         * App\Entity\Result
         */
    }
}
