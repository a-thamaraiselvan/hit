<?php
require_once 'admin/includes/db.php';
$conn->query("TRUNCATE TABLE faculty");

$facultyData = [
    [
        'name' => 'Dr.THIRUMALAI RAMANATHAN',
        'designation' => 'Professor and Head',
        'experience' => '27 Years',
        'qualification' => 'B.E., M.E., Ph.D',
        'specialization' => 'Manufacturing',
        'joined_date' => '2024-07-24',
        'association' => 'Regular',
        'email' => 'dr.thirumalai.r@hit.edu.in',
        'image_path' => 'assets/department/AERO/faculty_image_folder/Dr_THIRUMALAI_RAMANATHAN.png',
        'about' => 'Dr. Thirumalai R, Professor and Head of Aeronautical Engineering have extensive teaching, research and administrative experience of 27 years. He is a proud alumnus of National Institute of Technology, Trichy, India. He is recognized as “TOP 2% HIGHLY CITED SCIENTIST” across the world for the year 2023 by Stanford University. He has published more than 120+ research articles indexed in Scopus / Web of Science with high impact factor in peer reviewed Journals of International repute and Conferences. He has been awarded with “Award of Excellence in Research”, “Best Research Supervisor Award”, “Best Principal Award”. He is instrumental in the establishment of Autonomous status and several accreditation processes to the institute during his tenure. He has supervised 10 Research scholars and awarded 08 Ph.D research scholars so far. He has handled several volumes in the role of Chief Editor for Elsevier Publications: Materials Today Proceedings, IOP: Journal of Physics, JCPR, and Scientific.net: Engineering Headway. He has attended many national and international conferences and presented keynote address, chaired the technical sessions and organized conferences/seminars.',
        'department' => 'aeronautical',
        'priority' => 1
    ],
    [
        'name' => 'Dr.K.P.DHANABALAKRISHNAN',
        'designation' => 'Professor',
        'experience' => '28 Years',
        'qualification' => 'B.E., ME., Ph.D',
        'specialization' => 'Composite Materials',
        'joined_date' => '2018-07-12',
        'association' => 'Regular',
        'email' => 'dhanabalakrishnan@hit.edu.in',
        'image_path' => 'assets/department/AERO/faculty_image_folder/Dr.K.P.DHANABALAKRISHNAN.png',
        'about' => 'Dr.K.P.Dhanabalakrishnan has more than 28 years of experience in Teaching and 6 years in the industry...',
        'department' => 'aeronautical',
        'priority' => 2
    ],
    [
        'name' => 'John Doe',
        'designation' => 'Assistant Professor',
        'experience' => '10 Years',
        'qualification' => 'B.E., M.E.',
        'specialization' => 'Computer Science',
        'joined_date' => '2020-01-01',
        'association' => 'Regular',
        'email' => 'johndoe@hit.edu.in',
        'image_path' => 'assets/department/cse/faculty_image_folder/John_Doe.png',
        'about' => 'Test faculty for CSE department.',
        'department' => 'cse',
        'priority' => 1
    ]
];

try {
    $stmt = $conn->prepare("INSERT INTO faculty (name, designation, experience, qualification, specialization, joined_date, association, email, image_path, about, department, priority) 
                            VALUES (:name, :designation, :experience, :qualification, :specialization, :joined_date, :association, :email, :image_path, :about, :department, :priority)");

    foreach ($facultyData as $faculty) {
        $stmt->execute($faculty);
    }
    echo "Initial faculty data inserted successfully.";
} catch(PDOException $e) {
    echo "Error inserting data: " . $e->getMessage();
}
?>
