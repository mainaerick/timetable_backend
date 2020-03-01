<?php 
include 'process/connect.php';

$length="";
// for($i=1; $i<=70; $i++){
//     $activation = md5(uniqid(rand(), true));
//     $key = hash("joaat",uniqid(mt_rand(),true));
    $db->query("INSERT INTO `department` (`id`, `name`) VALUES
(1, 'Department of Agricultural Economics'),
(2, 'Department of Animal Science'),
(3, 'Department of Agricultural Sciences and Technology'),
(4, 'Department of Architecture and interior design'),
(5, 'Department of Spatial Planning and Urban Management'),
(6, 'Department of Real Estate and Construction Management'),
(7, 'Department of Business Administration'),
(8, 'Department of Management Science'),
(9, 'Department of Accounting and Finance'),
(10, 'Department of Communication, Media, Film & Theatre Studies'),
(11, 'Department of Fine Art and Design'),
(12, 'Department of Music and Dance'),
(13, 'Department of Fashion Design & Marketing '),
(14, 'Department of Applied Economics'),
(15, 'Department of Econometrics & Statistics'),
(16, 'Department of Economic Theory'),
(17, 'Department of Computing & Information Technology'),
(18, 'Department of Mechanical Engineering'),
(19, 'Department of Energy Engineering'),
(20, 'Department of Civil Engineering'),
(21, 'Department of Electrical & Electronic Engineering'),
(22, 'Department of Agricultural and Biosystems Engineering'),
(23, 'Department of Environmental Planning and Management'),
(24, 'Department of Environmental Science and Education'),
(25, 'Department of Environmental Studies and Community Development'),
(26, 'Department of Educational Psychology'),
(27, 'Department of Educational Management Policy & Curriculum Studies'),
(28, 'Department of Educational Communication & Technology'),
(29, 'Department of Educational Foundations'),
(30, 'Department of Library & Information Science'),
(31, 'Department of Early Childhood & Special Needs'),
(32, 'Department of Hospitality and Tourism Management'),
(33, 'Department of Recreation and Sports Management'),
(34, 'Department of Literature Languages And Linguistics'),
(35, 'Department of Geography'),
(36, 'Department of Sociology Gender & Development Studies'),
(37, 'Department of History, Archeology & Political Studies'),
(38, 'Department of Kiswahili and African Language'),
(39, 'Department of Philosophy and Religious Studies'),
(40, 'Department of Psychology'),
(41, 'Department of Public Policy and Administration (PPA)'),
(42, 'Department of Public Law'),
(43, 'Department of Private Law'),
(44, 'Department of Human Anatomy'),
(45, 'Department of Pathology'),
(46, 'Department of Medical Physiology'),
(47, 'Department of Medical Laboratory Sciences'),
(48, 'Department of Paediatrics and Child Health'),
(49, 'Department of Obstetrics and Gynaecology'),
(50, 'Department of Medicine, Therapeutics, Dermatology and Psychiatry'),
(51, 'Department of Surgery and Orthopaedics'),
(52, 'Department of Medical Surgical Nursing and Pre-clinical Services'),
(53, 'Department of Community and Reproductive Health Nursing'),
(54, 'Students practicum in the medicinal garden'),
(55, 'Department of Pharmacognosy, Pharmaceutical Chemistry And Pharmaceutics & Industrial Pharmacy'),
(56, 'Department Of Pharmacology And Clinical Pharmacy'),
(57, 'Department of Community Health and Epidemiology'),
(58, 'Department of Environmental & Occupational Health'),
(59, 'Department of Health Management and Informatics'),
(60, 'Department of Population, Reproductive Health & Community Resource Management'),
(61, 'Department of Food, Nutrition And Dietetics'),
(62, 'Department of Physical Education, Exercise & Sports Science'),
(63, 'Department of Conflict Resolution And International Relations'),
(64, 'Department of Security and Correction Science'),
(65, 'Department of Biochemistry, Microbiology and Biotechnology'),
(66, 'Department of Chemistry'),
(67, 'Department of Mathematics & Actuarial Science'),
(68, 'Department of Plant Sciences'),
(69, 'Department of Physics'),
(70, 'Department of Zoological Sciences');") or die(mysqli_error($db));
    // $db->query("update department set u_key='$key' where id=$i;");


    echo "The number is <br>";
    
// }


?>