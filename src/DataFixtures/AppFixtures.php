<?php

namespace App\DataFixtures;

use App\Entity\Classroom;
use App\Entity\Course;
use App\Entity\Promotion;
use App\Entity\Student;
use App\Entity\Teacher;
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

    public function setTeachers($firstname, $lastname, $entry_date) {
        $teacher = new Teacher();
        $teacher->setFirstname($firstname);
        $teacher->setLastname($lastname);
        $teacher->setEntryDate($entry_date);
        return $teacher;
    }

    public function setCourses($label, $start, $end)
    {
        $course = new Course();
        $course->setLabel($label);
        $course->setStart($start);
        $course->setEnd($end);
        return $course;
    }

    public function setCourseToTeacher($course, $teacher)
    {
        $course->setTeacher($teacher);
        return $course;
    }

    public function setCourseToClassroom($course, $classroom, $promotion)
    {
        $course->setClassroom($classroom);
        $course->setPromotion($promotion);
        return $course;
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
            3 =>  ['label' => 'A2-CD', 'promotion_id' => $promotionRepository[0]],
            4 =>  ['label' => 'A2-3D', 'promotion_id' => $promotionRepository[0]],
            5 =>  ['label' => 'A3-DW', 'promotion_id' => $promotionRepository[0]],
            6 =>  ['label' => 'A3-CD', 'promotion_id' => $promotionRepository[0]],
            7 =>  ['label' => 'A3-3D', 'promotion_id' => $promotionRepository[0]],
            8 =>  ['label' => 'A4-DW', 'promotion_id' => $promotionRepository[0]],
            9 =>  ['label' => 'A4-CD', 'promotion_id' => $promotionRepository[0]],
            10 => ['label' => 'A4-3D', 'promotion_id' => $promotionRepository[0]],
            11 => ['label' => 'A5-DW', 'promotion_id' => $promotionRepository[0]],
            12 => ['label' => 'A5-CD', 'promotion_id' => $promotionRepository[0]],
            13 => ['label' => 'A5-3D', 'promotion_id' => $promotionRepository[0]],
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
            1  => ['firstname' => 'Steven',     'lastname' => 'Sperling',   'age' => '21', 'entry_date' => new \DateTime('01-09-2021')],
            2  => ['firstname' => 'Arlene',     'lastname' => 'McMillian',  'age' => '24', 'entry_date' => new \DateTime('01-09-2021')],
            3  => ['firstname' => 'Craig',      'lastname' => 'Holmes',     'age' => '23', 'entry_date' => new \DateTime('01-09-2021')],
            4  => ['firstname' => 'Dan',        'lastname' => 'Rouse',      'age' => '22', 'entry_date' => new \DateTime('01-09-2021')],
            5  => ['firstname' => 'Jason',      'lastname' => 'Sokolowski', 'age' => '20', 'entry_date' => new \DateTime('01-09-2021')],
            6  => ['firstname' => 'Jeremy',     'lastname' => 'Hines',      'age' => '25', 'entry_date' => new \DateTime('01-09-2021')],
            7  => ['firstname' => 'Fred',       'lastname' => 'Dayton',     'age' => '22', 'entry_date' => new \DateTime('01-09-2021')],
            8  => ['firstname' => 'Brian',      'lastname' => 'Murrin',     'age' => '24', 'entry_date' => new \DateTime('01-09-2021')],
            9  => ['firstname' => 'Sandra',     'lastname' => 'Hinkle',     'age' => '23', 'entry_date' => new \DateTime('01-09-2021')],
            10 => ['firstname' => 'Shirley',    'lastname' => 'Gomez',      'age' => '22', 'entry_date' => new \DateTime('01-09-2021')],
            11 => ['firstname' => 'Darlene',    'lastname' => 'Brady',      'age' => '21', 'entry_date' => new \DateTime('01-09-2021')],
            12 => ['firstname' => 'Despina',    'lastname' => 'Johnson',    'age' => '20', 'entry_date' => new \DateTime('01-09-2021')],
            13 => ['firstname' => 'Nicholas',   'lastname' => 'Jones',      'age' => '24', 'entry_date' => new \DateTime('01-09-2021')],
            14 => ['firstname' => 'Bobby',      'lastname' => 'Valenzuela', 'age' => '25', 'entry_date' => new \DateTime('01-09-2021')],
            15 => ['firstname' => 'Lacey',      'lastname' => 'Taylor',     'age' => '23', 'entry_date' => new \DateTime('01-09-2021')],
            16 => ['firstname' => 'Chris',      'lastname' => 'Lea',        'age' => '23', 'entry_date' => new \DateTime('01-09-2021')],
            17 => ['firstname' => 'Ronald',     'lastname' => 'Branham',    'age' => '22', 'entry_date' => new \DateTime('01-09-2021')],
            18 => ['firstname' => 'James',      'lastname' => 'Wolfe',      'age' => '21', 'entry_date' => new \DateTime('01-09-2021')],
            19 => ['firstname' => 'Henry',      'lastname' => 'Yu',         'age' => '24', 'entry_date' => new \DateTime('01-09-2021')],
            20 => ['firstname' => 'Stacey',     'lastname' => 'Carter',     'age' => '20', 'entry_date' => new \DateTime('01-09-2021')],
            21 => ['firstname' => 'Felicidad',  'lastname' => 'Daily',      'age' => '20', 'entry_date' => new \DateTime('01-09-2021')],
            22 => ['firstname' => 'Ricardo',    'lastname' => 'Link',       'age' => '24', 'entry_date' => new \DateTime('01-09-2021')],
            23 => ['firstname' => 'Katie',      'lastname' => 'Nathan',     'age' => '25', 'entry_date' => new \DateTime('01-09-2021')],
            24 => ['firstname' => 'Philip',     'lastname' => 'Dowdle',     'age' => '25', 'entry_date' => new \DateTime('01-09-2021')],
            25 => ['firstname' => 'Douglas',    'lastname' => 'Rush',       'age' => '22', 'entry_date' => new \DateTime('01-09-2021')],
            26 => ['firstname' => 'Blanche',    'lastname' => 'Travers',    'age' => '23', 'entry_date' => new \DateTime('01-09-2021')],
            27 => ['firstname' => 'Harold',     'lastname' => 'Barringer',  'age' => '25', 'entry_date' => new \DateTime('01-09-2021')],
            28 => ['firstname' => 'Sharon',     'lastname' => 'Murakami',   'age' => '20', 'entry_date' => new \DateTime('01-09-2021')],
            29 => ['firstname' => 'Michelle',   'lastname' => 'Rolland',    'age' => '21', 'entry_date' => new \DateTime('01-09-2021')],
            30 => ['firstname' => 'Luke',       'lastname' => 'Mohler',     'age' => '23', 'entry_date' => new \DateTime('01-09-2021')],
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
        $teachers = [
            1  => ["firstname" => "Margaret", "lastname" => "Bruner",    "entry_date" => new \DateTime('05-08-2021')], // PHP
            2  => ["firstname" => "Jennifer", "lastname" => "Thomson",   "entry_date" => new \DateTime('12-08-2021')], // JS
            3  => ["firstname" => "Bobby",    "lastname" => "Charlton",  "entry_date" => new \DateTime('17-08-2021')], // Swift
            4  => ["firstname" => "Clint",    "lastname" => "Hennessey", "entry_date" => new \DateTime('20-08-2021')], // Photoshop
            5  => ["firstname" => "Dani",     "lastname" => "Dotson",    "entry_date" => new \DateTime('26-08-2021')], // Illustrator
            6  => ["firstname" => "Jason",    "lastname" => "Lehman",    "entry_date" => new \DateTime('22-08-2021')], // InDesign
            7  => ["firstname" => "Ray",      "lastname" => "Marquez",   "entry_date" => new \DateTime('08-08-2021')], // 3DS Max
            8  => ["firstname" => "Jewel",    "lastname" => "Bowman",    "entry_date" => new \DateTime('10-08-2021')], // Sketch Up
            9  => ["firstname" => "Helen",    "lastname" => "Berry",     "entry_date" => new \DateTime('19-08-2021')], // 3D Slash
            10 => ["firstname" => "Richard",  "lastname" => "Taylor",    "entry_date" => new \DateTime('23-08-2021')], // Découverte A1
        ];

        for ($i = 1; $i <= count($teachers); $i++) {
            $teacher = $this->setTeachers($teachers[$i]["firstname"], $teachers[$i]["lastname"], $teachers[$i]["entry_date"]);
            $manager->persist($teacher);
        }
        $manager->flush();

        $teacherRepository = $manager->getRepository('App:Teacher')->findAll();

        /**
         * Courses : Fixtures
         * App\Entity\Course
         */
        $courses = [
            1  => ["label" => "PHP : Débutant",              "start" => new \DateTime('06-09-2021'), "end" => new \DateTime('10-09-2021')],
            2  => ["label" => "PHP : Intermédiaire",         "start" => new \DateTime('13-09-2021'), "end" => new \DateTime('17-09-2021')],
            3  => ["label" => "PHP : Expert",                "start" => new \DateTime('20-09-2021'), "end" => new \DateTime('24-09-2021')],
            4  => ["label" => "Photoshop : Débutant",        "start" => new \DateTime('06-09-2021'), "end" => new \DateTime('10-09-2021')],
            5  => ["label" => "Photoshop : Intermédiaire",   "start" => new \DateTime('13-09-2021'), "end" => new \DateTime('17-09-2021')],
            6  => ["label" => "Photoshop : Expert",          "start" => new \DateTime('20-09-2021'), "end" => new \DateTime('24-09-2021')],
            7  => ["label" => "3DS Max : Débutant",          "start" => new \DateTime('06-09-2021'), "end" => new \DateTime('10-09-2021')],
            8  => ["label" => "3DS Max : Intermédiaire",     "start" => new \DateTime('13-09-2021'), "end" => new \DateTime('17-09-2021')],
            9  => ["label" => "3DS Max : Expert",            "start" => new \DateTime('20-09-2021'), "end" => new \DateTime('24-09-2021')],
            10 => ["label" => "Javascript : Débutant",       "start" => new \DateTime('27-09-2021'), "end" => new \DateTime('01-10-2021')],
            11 => ["label" => "Javascript : Intermédiaire",  "start" => new \DateTime('04-10-2021'), "end" => new \DateTime('08-10-2021')],
            12 => ["label" => "Javascript : Expert",         "start" => new \DateTime('11-10-2021'), "end" => new \DateTime('15-10-2021')],
            13 => ["label" => "Illustrator : Débutant",      "start" => new \DateTime('27-09-2021'), "end" => new \DateTime('01-10-2021')],
            14 => ["label" => "Illustrator : Intermédiaire", "start" => new \DateTime('04-10-2021'), "end" => new \DateTime('08-10-2021')],
            15 => ["label" => "Illustrator : Expert",        "start" => new \DateTime('11-10-2021'), "end" => new \DateTime('15-10-2021')],
            16 => ["label" => "Sketch Up : Débutant",        "start" => new \DateTime('27-09-2021'), "end" => new \DateTime('01-10-2021')],
            17 => ["label" => "Sketch Up : Intermédiaire",   "start" => new \DateTime('04-10-2021'), "end" => new \DateTime('08-10-2021')],
            18 => ["label" => "Sketch Up : Expert",          "start" => new \DateTime('11-10-2021'), "end" => new \DateTime('15-10-2021')],
            19 => ["label" => "Swift iOS : Débutant",        "start" => new \DateTime('18-10-2021'), "end" => new \DateTime('22-10-2021')],
            20 => ["label" => "Swift iOS : Intermédiaire",   "start" => new \DateTime('25-10-2021'), "end" => new \DateTime('29-10-2021')],
            21 => ["label" => "Swift iOS : Expert",          "start" => new \DateTime('02-11-2021'), "end" => new \DateTime('05-11-2021')],
            22 => ["label" => "InDesign : Débutant",         "start" => new \DateTime('18-10-2021'), "end" => new \DateTime('22-10-2021')],
            23 => ["label" => "InDesign : Intermédiaire",    "start" => new \DateTime('25-10-2021'), "end" => new \DateTime('29-10-2021')],
            24 => ["label" => "InDesign : Expert",           "start" => new \DateTime('02-11-2021'), "end" => new \DateTime('05-11-2021')],
            25 => ["label" => "3D Slash : Débutant",         "start" => new \DateTime('18-10-2021'), "end" => new \DateTime('22-10-2021')],
            26 => ["label" => "3D Slash : Intermédiaire",    "start" => new \DateTime('25-10-2021'), "end" => new \DateTime('29-10-2021')],
            27 => ["label" => "3D Slash : Expert",           "start" => new \DateTime('02-11-2021'), "end" => new \DateTime('05-11-2021')],
            28 => ["label" => "Découverte Web",              "start" => new \DateTime('06-09-2021'), "end" => new \DateTime('10-09-2021')],
            29 => ["label" => "Découverte 3D",               "start" => new \DateTime('13-09-2021'), "end" => new \DateTime('17-09-2021')],
            30 => ["label" => "Découverte Créa & Design",    "start" => new \DateTime('20-09-2021'), "end" => new \DateTime('24-09-2021')],
        ];

        // A1 (2021-2026)
        for ($i = 28; $i <= 30; $i++) {
            $initCourseA1    = $this->setCourses($courses[$i]["label"], $courses[$i]["start"], $courses[$i]["end"]);
            $teacherCourseA1 = $this->setCourseToTeacher($initCourseA1, $teacherRepository[9]);
            $courseA1 = $this->setCourseToClassroom($teacherCourseA1, $classroomRepository[0], $promotionRepository[0]);
            $manager->persist($courseA1);
        }
        $manager->flush();

        // A2 (2021-2026)
        for ($i = 1; $i <= 27; $i++) {
            $initCourse = $this->setCourses($courses[$i]["label"], $courses[$i]["start"], $courses[$i]["end"]);
            if ($i === 1 || $i === 2 || $i === 3 || $i === 10 || $i === 11 || $i === 12 || $i === 19 || $i === 20 || $i === 21) { // A2-DW
                if($i === 1 || $i === 2 || $i === 3) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[0]);
                } elseif ($i === 10 || $i === 11 || $i === 12) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[1]);
                } elseif ($i === 19 || $i === 20 || $i === 21) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[2]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[1], $promotionRepository[0]);
            } elseif ($i === 4 || $i === 5 || $i === 6 || $i === 13 || $i === 14 || $i === 15 || $i === 22 || $i === 23 || $i === 24) { // A2-CD
                if ($i === 4 || $i === 5 || $i == 6) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[3]);
                } elseif ($i === 13 || $i === 14 || $i === 15) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[4]);
                } elseif ($i === 22 || $i === 23 || $i === 24) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[5]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[2], $promotionRepository[0]);
            } elseif ($i === 7 || $i === 8 || $i === 9 || $i === 16 || $i === 17 || $i === 18 || $i === 25 || $i === 26 || $i === 27) { // A2-3D
                if ($i === 7 || $i === 8 || $i === 9) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[6]);
                } elseif ($i === 16 || $i === 17 || $i === 18) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[7]);
                } elseif ($i === 25 || $i === 26 || $i === 27) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[8]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[3], $promotionRepository[0]);
            }
            $manager->persist($course);
        }
        $manager->flush();

        // A3 (2021-2026)
        for ($i = 1; $i <= 27; $i++) {
            $initCourse = $this->setCourses($courses[$i]["label"], $courses[$i]["start"], $courses[$i]["end"]);
            if ($i === 1 || $i === 2 || $i === 3 || $i === 10 || $i === 11 || $i === 12 || $i === 19 || $i === 20 || $i === 21) { // A3-DW
                if($i === 1 || $i === 2 || $i === 3) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[0]);
                } elseif ($i === 10 || $i === 11 || $i === 12) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[1]);
                } elseif ($i === 19 || $i === 20 || $i === 21) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[2]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[4], $promotionRepository[0]);
            } elseif ($i === 4 || $i === 5 || $i === 6 || $i === 13 || $i === 14 || $i === 15 || $i === 22 || $i === 23 || $i === 24) { // A3-CD
                if ($i === 4 || $i === 5 || $i == 6) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[3]);
                } elseif ($i === 13 || $i === 14 || $i === 15) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[4]);
                } elseif ($i === 22 || $i === 23 || $i === 24) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[5]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[5], $promotionRepository[0]);
            } elseif ($i === 7 || $i === 8 || $i === 9 || $i === 16 || $i === 17 || $i === 18 || $i === 25 || $i === 26 || $i === 27) { // A3-3D
                if ($i === 7 || $i === 8 || $i === 9) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[6]);
                } elseif ($i === 16 || $i === 17 || $i === 18) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[7]);
                } elseif ($i === 25 || $i === 26 || $i === 27) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[8]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[6], $promotionRepository[0]);
            }
            $manager->persist($course);
        }
        $manager->flush();

        // A4 (2021-2026)
        for ($i = 1; $i <= 27; $i++) {
            $initCourse = $this->setCourses($courses[$i]["label"], $courses[$i]["start"], $courses[$i]["end"]);
            if ($i === 1 || $i === 2 || $i === 3 || $i === 10 || $i === 11 || $i === 12 || $i === 19 || $i === 20 || $i === 21) { // A4-DW
                if($i === 1 || $i === 2 || $i === 3) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[0]);
                } elseif ($i === 10 || $i === 11 || $i === 12) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[1]);
                } elseif ($i === 19 || $i === 20 || $i === 21) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[2]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[7], $promotionRepository[0]);
            } elseif ($i === 4 || $i === 5 || $i === 6 || $i === 13 || $i === 14 || $i === 15 || $i === 22 || $i === 23 || $i === 24) { // A4-CD
                if ($i === 4 || $i === 5 || $i == 6) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[3]);
                } elseif ($i === 13 || $i === 14 || $i === 15) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[4]);
                } elseif ($i === 22 || $i === 23 || $i === 24) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[5]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[8], $promotionRepository[0]);
            } elseif ($i === 7 || $i === 8 || $i === 9 || $i === 16 || $i === 17 || $i === 18 || $i === 25 || $i === 26 || $i === 27) { // A4-3D
                if ($i === 7 || $i === 8 || $i === 9) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[6]);
                } elseif ($i === 16 || $i === 17 || $i === 18) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[7]);
                } elseif ($i === 25 || $i === 26 || $i === 27) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[8]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[9], $promotionRepository[0]);
            }
            $manager->persist($course);
        }
        $manager->flush();

        // A5 (2021-2026)
        for ($i = 1; $i <= 27; $i++) {
            $initCourse = $this->setCourses($courses[$i]["label"], $courses[$i]["start"], $courses[$i]["end"]);
            if ($i === 1 || $i === 2 || $i === 3 || $i === 10 || $i === 11 || $i === 12 || $i === 19 || $i === 20 || $i === 21) { // A5-DW
                if($i === 1 || $i === 2 || $i === 3) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[0]);
                } elseif ($i === 10 || $i === 11 || $i === 12) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[1]);
                } elseif ($i === 19 || $i === 20 || $i === 21) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[2]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[10], $promotionRepository[0]);
            } elseif ($i === 4 || $i === 5 || $i === 6 || $i === 13 || $i === 14 || $i === 15 || $i === 22 || $i === 23 || $i === 24) { // A5-CD
                if ($i === 4 || $i === 5 || $i == 6) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[3]);
                } elseif ($i === 13 || $i === 14 || $i === 15) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[4]);
                } elseif ($i === 22 || $i === 23 || $i === 24) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[5]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[11], $promotionRepository[0]);
            } elseif ($i === 7 || $i === 8 || $i === 9 || $i === 16 || $i === 17 || $i === 18 || $i === 25 || $i === 26 || $i === 27) { // A5-3D
                if ($i === 7 || $i === 8 || $i === 9) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[6]);
                } elseif ($i === 16 || $i === 17 || $i === 18) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[7]);
                } elseif ($i === 25 || $i === 26 || $i === 27) {
                    $teacherCourse = $this->setCourseToTeacher($initCourse, $teacherRepository[8]);
                }
                $course = $this->setCourseToClassroom($teacherCourse, $classroomRepository[12], $promotionRepository[0]);
            }
            $manager->persist($course);
        }
        $manager->flush();

        /**
         * Results : Fixtures
         * App\Entity\Result
         */


        /**
         * Users : Fixtures
         * App\Entity\User
         */
    }
}
