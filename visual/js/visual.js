/**
 * APEX Learning Hub — Visual Core JavaScript
 * Handles Global Search, English/Filipino Language Switcher, Guide Cards,
 * Mobile Navigation, and Interactive Picture Containers.
 */

// Comprehensive Search Index across all visual pages & portal
const SEARCH_INDEX = [
    { title: "Home — Welcome to APEX Learning Hub", page: "Homepage", url: "homepage.php" },
    { title: "Academic Programs & Offerings", page: "Offerings", url: "homepage.php#offerings" },
    { title: "Digital Library & Learning Resources", page: "Offerings", url: "homepage.php#offerings" },
    { title: "Interactive Coursework Tracker", page: "Offerings", url: "homepage.php#offerings" },
    { title: "Campus Bulletins & Announcements Preview", page: "Announcements", url: "homepage.php#announcements" },
    { title: "Campus Essentials & Student Guide (FAQ)", page: "FAQ & Guide", url: "homepage.php#essentials" },
    { title: "About APEX Learning Hub", page: "About", url: "homepage.php#about" },

    { title: "All Campus Announcements & Advisories", page: "Announcements", url: "announcement.php" },
    { title: "Midterm Examination Schedule Released", page: "Announcements", url: "announcement.php" },
    { title: "Scheduled Maintenance Advisory", page: "Announcements", url: "announcement.php" },
    { title: "Second Semester Enrollment Deadline", page: "Announcements", url: "announcement.php" },
    { title: "Student Leadership Summit 2026", page: "Announcements", url: "announcement.php" },
    { title: "Updated Academic Integrity Guidelines", page: "Announcements", url: "announcement.php" },

    { title: "Student Code of Conduct", page: "Policies", url: "policies.php#code-of-conduct" },
    { title: "Academic Integrity Policy", page: "Policies", url: "policies.php#academic-integrity" },
    { title: "Attendance & Participation Rules", page: "Policies", url: "policies.php#attendance" },
    { title: "Grading System & Evaluation Scale", page: "Policies", url: "policies.php#grading" },
    { title: "Data Privacy Notice & Protection", page: "Policies", url: "policies.php#privacy" },
    { title: "Acceptable Digital Use Policy", page: "Policies", url: "policies.php#digital-use" },

    { title: "Contact Us & Administration Directory", page: "Contact Us", url: "contact.php" },
    { title: "Registrar & Admissions Office Hours", page: "Contact Us", url: "contact.php#info" },
    { title: "Send Inquiries to Academic Support", page: "Contact Us", url: "contact.php#info" },
    { title: "Frequently Asked Questions", page: "Contact Us", url: "contact.php#faq" },

    { title: "APEX Academic Portal — Sign In", page: "Portal Sign In", url: "../auth/login.php" },
    { title: "Student Account Registration", page: "Portal Register", url: "../auth/register.php" },
    { title: "Reset Portal Password", page: "Password Recovery", url: "../auth/forgot-password.php" }
];

const UI_TRANSLATIONS = {
    'Search courses, announcements, policies…': 'Maghanap ng mga kurso, anunsyo, at patakaran…',
    'Search site content': 'Maghanap sa nilalaman ng site',
    'Clear search query': 'I-clear ang paghahanap',
    'Change language': 'Palitan ang wika',
    'Change Language': 'Palitan ang Wika',
    'Main Site Navigation': 'Pangunahing Nabigasyon ng Site',
    'Toggle Navigation Menu': 'Buksan o isara ang menu ng nabigasyon',
    'Sign In': 'Mag-sign in',
    'Register': 'Magrehistro',
    'Sign Out': 'Mag-sign out',
    'Sign out of your session': 'Mag-sign out sa iyong account',
    'All Rights Reserved.': 'Nakalaan ang lahat ng karapatan.',
    'Connected to XAMPP • PHP': 'Nakakonekta sa XAMPP • PHP',
    'Search by course code, title, or professor...': 'Maghanap ayon sa code o pangalan ng kurso, o pangalan ng guro...',
    'Search courses or codes...': 'Maghanap ng kurso o code...',
    'Search user by name or email...': 'Maghanap ng user ayon sa pangalan o email...',
    'Search student or course...': 'Maghanap ng mag-aaral o kurso...',
    'Search student roster...': 'Maghanap sa talaan ng mga mag-aaral...',
    'Search courses, announcements, policies…': 'Maghanap ng mga kurso, anunsyo, at patakaran…',
    'Search results': 'Mga resulta ng paghahanap',
    'No matching pages found for': 'Walang nahanap na pahinang tumutugma sa',
    'Try searching for "announcements", "policies", or "portal".': 'Subukang maghanap ng “anunsyo,” “patakaran,” o “portal.”',
    'Welcome!': 'Maligayang pagdating!',
    'Sign in to continue.': 'Mag-sign in upang magpatuloy.',
    'Welcome, ': 'Maligayang pagdating, ',
    'Please sign in to access that workspace.': 'Mag-sign in upang ma-access ang workspace na iyon.',
    'Please provide both your official email and password.': 'Ilagay ang iyong opisyal na email at password.',
    'Please use an APEX Email ending in @apex.edu.ph.': 'Gumamit ng APEX Email na nagtatapos sa @apex.edu.ph.',
    'Invalid credentials. Please verify your email and password.': 'Hindi wastong mga kredensyal. Tiyaking tama ang iyong email at password.',
    'Registration successful! You may now sign in with your credentials.': 'Matagumpay ang pagpaparehistro! Maaari ka nang mag-sign in gamit ang iyong mga kredensyal.',
    'Password has been successfully updated. Please sign in.': 'Matagumpay na napalitan ang password. Mag-sign in upang magpatuloy.',
    'You have been safely signed out.': 'Matagumpay kang nag-sign out.',
    'Email': 'Email',
    'Password': 'Password',
    'Show password': 'Ipakita ang password',
    'Hide password': 'Itago ang password',
    'Forgot Password?': 'Nakalimutan ang Password?',
    'Enter your registered APEX email to reset your portal password.': 'Ilagay ang iyong nakarehistrong APEX email upang mapalitan ang password ng portal.',
    'APEX Email': 'Email ng APEX',
    'Find Account & Proceed': 'Hanapin ang Account at Magpatuloy',
    'Return to Sign In': 'Bumalik sa Pag-sign in',
    'Please enter your APEX email address.': 'Ilagay ang iyong APEX email address.',
    'Please provide a valid APEX email address.': 'Maglagay ng wastong APEX email address.',
    'No account was found with that email address.': 'Walang account na nahanap gamit ang email address na iyon.',
    'Sign Up': 'Mag-sign up',
    'Create your account': 'Gumawa ng iyong account',
    'First Name *': 'Pangalan *',
    'Last Name *': 'Apelyido *',
    'Email *': 'Email *',
    'Password *': 'Password *',
    'Confirm Password *': 'Kumpirmahin ang Password *',
    'Confirm Password': 'Kumpirmahin ang Password',
    'Already have an account?': 'May account ka na ba?',
    'Please fill in all required fields.': 'Punan ang lahat ng kinakailangang field.',
    'Passwords do not match.': 'Hindi magkatugma ang mga password.',
    'An account with this email address already exists. Please sign in.': 'May account nang gumagamit ng email address na ito. Mag-sign in.',
    'Create New Password': 'Gumawa ng Bagong Password',
    'Resetting credentials for:': 'Pinapalitan ang password para kay:',
    'New Password': 'Bagong Password',
    'Confirm New Password': 'Kumpirmahin ang Bagong Password',
    'Update Password & Sign In': 'Palitan ang Password at Mag-sign in',
    'Please provide and confirm your new password.': 'Ilagay at kumpirmahin ang iyong bagong password.',
    '8+ characters, upper/lowercase, number, symbol': 'Hindi bababa sa 8 character, may malaking at maliit na letra, numero, at simbolo',
    'Use at least 8 characters with an uppercase letter, a lowercase letter, a number, and a special character.': 'Gumamit ng hindi bababa sa 8 character na may malaking letra, maliit na letra, numero, at espesyal na simbolo.',
    'Re-enter new password': 'Ilagay muli ang bagong password',
    'e.g. John': 'hal. Juan',
    'e.g. Doe': 'hal. Dela Cruz',
    'e.g. name@apex.edu.ph': 'hal. pangalan@apex.edu.ph',
    'Welcome, ': 'Maligayang pagdating, ',
    'APEX Hub Registrar Workspace': 'Workspace ng Registrar ng APEX Hub',
    'Registrar Control Panel': 'Panel ng Pamamahala ng Registrar',
    'New Course': 'Bagong Kurso',
    'New User': 'Bagong User',
    'Announcement': 'Anunsyo',
    'Enrolled Students': 'Mga Naka-enroll na Mag-aaral',
    'Faculty Professors': 'Mga Guro',
    'Curriculum Courses': 'Mga Kurso sa Kurikulum',
    'Pending Applications': 'Mga Naghihintay na Aplikasyon',
    'Courses': 'Mga Kurso',
    'Users & Faculty': 'Mga User at Guro',
    'Enrollment Applications': 'Mga Aplikasyon sa Pagpapatala',
    'Announcements': 'Mga Anunsyo',
    'Code': 'Code',
    'Course & Schedule': 'Kurso at Iskedyul',
    'Assigned Professor': 'Itinalagang Guro',
    'Enrollment / Capacity': 'Naka-enroll / Kapasidad',
    'Actions': 'Mga Aksyon',
    'No courses created yet.': 'Wala pang nagagawang kurso.',
    'Unassigned': 'Walang nakatalaga',
    'Delete': 'Tanggalin',
    'Create Course': 'Gumawa ng Kurso',
    'Add User Account': 'Magdagdag ng User Account',
    'User Name': 'Pangalan ng User',
    'Role': 'Tungkulin',
    'Registered': 'Petsa ng Pagpaparehistro',
    '(You)': '(Ikaw)',
    'Current ': 'Kasalukuyang ',
    'Student': 'Mag-aaral',
    'Target Course': 'Nilalayong Kurso',
    'Instructor': 'Guro',
    'Status': 'Katayuan',
    'Applied Date': 'Petsa ng Pag-aaplay',
    'Registrar Actions': 'Mga Aksyon ng Registrar',
    'No enrollment records found.': 'Walang nakitang tala ng pagpapatala.',
    'Approve': 'Aprubahan',
    'Reject': 'Tanggihan',
    'Announcement Title': 'Pamagat ng Anunsyo',
    'Scope / Course': 'Saklaw / Kurso',
    'Author': 'May-akda',
    'Date Posted': 'Petsa ng Pag-post',
    'No announcements active.': 'Walang aktibong anunsyo.',
    'Global Campus': 'Buong Kampus',
    'Create New Academic Course': 'Gumawa ng Bagong Kursong Akademiko',
    'Course Code *': 'Code ng Kurso *',
    'Course Name *': 'Pangalan ng Kurso *',
    'Assign Faculty Instructor': 'Magtalaga ng Guro',
    'Maximum Student Capacity': 'Pinakamaraming Mag-aaral',
    'Start Time': 'Oras ng Pagsisimula',
    'End Time': 'Oras ng Pagtatapos',
    'Room / Location': 'Silid / Lokasyon',
    'Cancel': 'Kanselahin',
    'Set Course Schedule': 'Itakda ang Iskedyul ng Kurso',
    'Leave all schedule fields empty to mark the course schedule as TBA.': 'Iwanang blangko ang lahat ng field ng iskedyul kung hindi pa ito nakatakda.',
    'Save Schedule': 'I-save ang Iskedyul',
    'Create User Account': 'Gumawa ng User Account',
    'First Name *': 'Pangalan *',
    'Last Name *': 'Apelyido *',
    'APEX Email *': 'APEX Email *',
    'Account Role *': 'Tungkulin ng Account *',
    'Initial Password *': 'Paunang Password *',
    'Publish Campus Announcement': 'Maglathala ng Anunsyo sa Kampus',
    'Target Audience': 'Mga Paglalaanan',
    'Announcement Content *': 'Nilalaman ng Anunsyo *',
    'Broadcast Now': 'Ipadala Ngayon',
    'Faculty Workspace': 'Workspace ng Guro',
    'Course Leadership & Approvals': 'Pamamahala ng Kurso at mga Pag-apruba',
    'Assigned Courses': 'Mga Itinalagang Kurso',
    'Awaiting Approval': 'Naghihintay ng Pag-apruba',
    'Review and decide on student applications': 'Suriin at pagpasyahan ang mga aplikasyon ng mag-aaral',
    'Applicant': 'Aplikante',
    'Contact Email': 'Email sa Pakikipag-ugnayan',
    'Applied At': 'Petsa ng Pag-aaplay',
    'Approval Actions': 'Mga Aksyon sa Pag-apruba',
    'Max ': 'Pinakamarami: ',
    'Student Name': 'Pangalan ng Mag-aaral',
    'Enrolled Course': 'Kursong Kinuha',
    'Email Address': 'Email Address',
    'Enrolled Date': 'Petsa ng Pag-enroll',
    'No students enrolled yet.': 'Wala pang naka-enroll na mag-aaral.',
    'New Announcement': 'Bagong Anunsyo',
    'Subject & Message': 'Paksa at Mensahe',
    'Date Published': 'Petsa ng Paglathala',
    'Action': 'Aksyon',
    'You haven’t posted any announcements yet.': 'Wala ka pang nailalathalang anunsyo.',
    "You haven't posted any announcements yet.": 'Wala ka pang nailalathalang anunsyo.',
    'New Assignment': 'Bagong Takdang-Aralin',
    'Assignment': 'Takdang-Aralin',
    'Due': 'Takdang Petsa',
    'No assignments have been created yet.': 'Wala pang nagagawang takdang-aralin.',
    'Post Announcement to Class': 'Mag-post ng Anunsyo sa Klase',
    'Select Course *': 'Pumili ng Kurso *',
    'Announcement Details *': 'Mga Detalye ng Anunsyo *',
    'Post to Class': 'I-post sa Klase',
    'Create Course Assignment': 'Gumawa ng Takdang-Aralin sa Kurso',
    'Assignment title *': 'Pamagat ng Takdang-Aralin *',
    'Instructions': 'Mga Panuto',
    'Due date and time *': 'Takdang Petsa at Oras *',
    'Publish Assignment': 'I-publish ang Takdang-Aralin',
    'Student Portal': 'Portal ng Mag-aaral',
    'Here’s what’s happening with your courses today.': 'Narito ang mga update tungkol sa iyong mga kurso ngayon.',
    'View class schedule': 'Tingnan ang Iskedyul ng Klase',
    'Pending tasks': 'Mga Gawaing Naghihintay',
    'item': 'gawain',
    'items': 'gawain',
    'need attention': 'na nangangailangan ng aksyon',
    'View all': 'Tingnan lahat',
    'Enrollment decision pending': 'Naghihintay ang desisyon sa pagpapatala',
    'Pending': 'Naghihintay',
    'You’re all caught up. No pending tasks.': 'Wala ka nang nakabinbing gawain.',
    'Campus and class updates for you': 'Mga anunsyo para sa iyo mula sa kampus at klase',
    'No announcements for your courses yet.': 'Wala pang anunsyo para sa iyong mga kurso.',
    'Class schedule': 'Iskedyul ng Klase',
    'Open schedule': 'Buksan ang iskedyul',
    'Schedule TBA': 'Hindi pa nakatakda ang iskedyul',
    'Your schedule appears here after course enrollment.': 'Lalabas dito ang iyong iskedyul kapag naka-enroll ka na sa kurso.',
    'Enrolled Courses': 'Mga Kursong Kinuha',
    'Available Courses': 'Mga Kursong Maaaring Kunin',
    'Campus Notices': 'Mga Anunsyo sa Kampus',
    'No Active Course Enrollments': 'Wala Kang Aktibong Pagpapatala sa Kurso',
    'You are not currently enrolled in any courses. Browse the course catalog to submit enrollment applications for faculty review.': 'Wala ka pang kursong kinukuha. Tingnan ang katalogo ng mga kurso at magsumite ng aplikasyon upang masuri ng guro.',
    'Explore Course Catalog →': 'Tingnan ang Katalogo ng Kurso →',
    'Active Enrollment': 'Aktibong Pagpapatala',
    'Drop Course': 'Bawiin ang Pagpapatala',
    'Enrolled': 'Naka-enroll',
    'Pending Approval': 'Naghihintay ng Pag-apruba',
    'Rejected': 'Tinanggihan',
    'Class Full': 'Puno na ang Klase',
    'Open Seats': 'May Bakanteng Upuan',
    'Seats:': 'Mga Upuan:',
    'All courses you have applied for': 'Lahat ng kursong inaplayan mo',
    'Course': 'Kurso',
    'Applied On': 'Petsa ng Pag-aaplay',
    'Decision Date': 'Petsa ng Desisyon',
    'No enrollment applications submitted yet.': 'Wala ka pang naisusumiteng aplikasyon sa pagpapatala.',
    'Awaiting decision': 'Naghihintay ng desisyon',
    'Campus Bulletin': 'Anunsyo sa Kampus',
    'APEX Student': 'Mag-aaral ng APEX',
    'Your updates': 'Mga Update Mo',
    'Campus-wide notices and announcements from the instructors of your enrolled courses.': 'Mga anunsyo para sa buong kampus at mga guro ng mga kursong kinukuha mo.',
    'You’re all caught up': 'Wala ka nang bagong update',
    'There are no campus or course announcements for you right now.': 'Wala pang anunsyo para sa iyo mula sa kampus o sa mga kurso mo.',
    'Your weekly timetable': 'Ang Iyong Lingguhang Iskedyul',
    'Class Schedule': 'Iskedyul ng Klase',
    'Meeting times for your approved courses. Courses without published meeting details appear below as TBA.': 'Mga oras ng klase para sa mga aprubadong kurso mo. Lalabas sa ibaba ang mga kursong wala pang itinakdang iskedyul.',
    'No enrolled courses yet': 'Wala ka pang kursong kinukuha',
    'Approved course enrollments will appear on your weekly timetable.': 'Lalabas sa lingguhang iskedyul mo ang mga aprubadong pagpapatala.',
    'No classes': 'Walang klase',
    'Schedule to be announced': 'Iaanunsyo pa ang iskedyul',
    'These courses are enrolled, but meeting details have not been published yet.': 'Naka-enroll ka sa mga kursong ito, ngunit hindi pa inilalathala ang mga detalye ng klase.',
    'Stay on track': 'Subaybayan ang Iyong mga Gawain',
    'Pending Tasks': 'Mga Nakabinbing Gawain',
    'Assignments for your enrolled courses and enrollment decisions still in progress.': 'Mga takdang-aralin sa mga kursong kinukuha mo at mga aplikasyon sa pagpapatala na hindi pa napagpapasyahan.',
    'Assignments to complete': 'Mga Takdang-Araling Gagawin',
    'No assignments are currently waiting for you.': 'Wala kang nakabinbing takdang-aralin sa ngayon.',
    'Enrollment decisions': 'Mga Desisyon sa Pagpapatala',
    'No enrollment applications are awaiting a decision.': 'Walang aplikasyon sa pagpapatala na naghihintay ng desisyon.',
    'Awaiting review': 'Naghihintay ng pagsusuri',
    'Completed assignments': 'Mga Natapos na Takdang-Aralin',
    'Mark assignment complete': 'Markahang tapos ang takdang-aralin',
    'Weekly class timetable': 'Lingguhang iskedyul ng klase',
    'Announcements for this student': 'Mga anunsyo para sa mag-aaral na ito',
    'Search announcements': 'Maghanap ng mga anunsyo',
    'Search by course name, course code, title, or announcement...': 'Maghanap ayon sa pangalan o code ng kurso, pamagat, o nilalaman ng anunsyo...',
    'No announcements match your search.': 'Walang anunsyong tumutugma sa iyong paghahanap.',
    'Explore Course Catalog →': 'Tingnan ang Katalogo ng Kurso →',
    'Search student roster...': 'Maghanap sa talaan ng mga mag-aaral...',
    'No enrollment records found.': 'Walang nakitang tala ng pagpapatala.',
    'No enrollment records found.': 'Walang nakitang tala ng pagpapatala.',
    'System Administrator': 'Tagapangasiwa ng Sistema',
    'Administrator account': 'Account ng tagapangasiwa',
    'Administrator Workspace': 'Workspace ng Tagapangasiwa',
    'Registrar operations are managed through the dedicated Registrar account.': 'Pinamamahalaan ang mga gawain ng Registrar gamit ang nakalaang account ng Registrar.',
    'Sign out and sign in with the Registrar account to manage courses, users, enrollment applications, and announcements.': 'Mag-sign out at mag-sign in gamit ang account ng Registrar upang pamahalaan ang mga kurso, user, aplikasyon sa pagpapatala, at anunsyo.',
    'Announcements': 'Mga Anunsyo',
    'All Bulletins': 'Lahat ng Anunsyo',
    'Academic': 'Akademiko',
    'System Updates': 'Mga Update sa Sistema',
    'Campus Events': 'Mga Kaganapan sa Kampus',
    'Policy Notices': 'Mga Abiso sa Patakaran',
    'Institutional Policies': 'Mga Patakaran ng Institusyon',
    'Stay updated with the latest news, advisories, and academic bulletins from APEX Learning Hub.': 'Alamin ang pinakabagong balita, abiso, at anunsyong akademiko mula sa APEX Learning Hub.',
    'Contact Us': 'Makipag-ugnayan sa Amin',
    'Have a question, concern, or feedback? Reach out and we’ll get back to you as soon as possible.': 'May tanong, alalahanin, o mungkahi? Makipag-ugnayan sa amin at sasagot kami sa lalong madaling panahon.',
    'Send Us a Message': 'Magpadala sa Amin ng Mensahe',
    'Subject / Concern': 'Paksa / Alalahanin',
    'Select a topic...': 'Pumili ng paksa...',
    'Enrollment Inquiry': 'Tanong tungkol sa Pagpapatala',
    'Policy Question': 'Tanong tungkol sa Patakaran',
    'Technical Support': 'Tulong Teknikal',
    'Announcement / Bulletin': 'Anunsyo / Paunawa',
    'Other': 'Iba pa',
    'Message': 'Mensahe',
    'Describe your question or concern in detail...': 'Ilarawan nang detalyado ang iyong tanong o alalahanin...',
    'Send Message': 'Ipadala ang Mensahe',
    'Your message has been sent. We’ll get back to you within 1–2 business days.': 'Naipadala na ang iyong mensahe. Sasagot kami sa loob ng 1–2 araw ng trabaho.',
    'Office Information': 'Impormasyon ng Opisina',
    'Address': 'Tirahan',
    'Phone': 'Telepono',
    'Office Hours': 'Oras ng Opisina',
    'Frequently Asked Questions': 'Mga Madalas Itanong',
    'Where can I check exam schedules and faculty announcements?': 'Saan ko makikita ang iskedyul ng pagsusulit at mga anunsyo ng guro?',
    'Learn': 'Matuto',
    'Advance': 'Umunlad',
    'Achieve': 'Magtagumpay',
    'What APEX Offers': 'Mga Serbisyo ng APEX',
    'Latest Announcements': 'Mga Pinakabagong Anunsyo',
    'Campus Essentials & Student Guide': 'Mahahalagang Impormasyon sa Kampus at Gabay ng Mag-aaral',
    'About APEX': 'Tungkol sa APEX',
    'Search a topic': 'Maghanap ng paksa',
    'Previous announcement': 'Naunang anunsyo',
    'Next announcement': 'Susunod na anunsyo',
    'Previous offering': 'Naunang serbisyo',
    'Next offering': 'Susunod na serbisyo',
    'Previous student guide card': 'Naunang gabay ng mag-aaral',
    'Next student guide card': 'Susunod na gabay ng mag-aaral',
    'No matching pages found for': 'Walang nahanap na pahinang tumutugma sa',
    'Sending Message…': 'Ipinapadala ang mensahe…',
    'Please select a subject.': 'Pumili ng paksa.',
    'Please enter a valid email address.': 'Maglagay ng wastong email address.',
    'Message cannot be empty.': 'Hindi maaaring walang laman ang mensahe.',
    'First name is required.': 'Kinakailangan ang pangalan.',
    'Last name is required.': 'Kinakailangan ang apelyido.',
    'Email is required.': 'Kinakailangan ang email.',
    'Are you sure you want to drop this enrolled course?': 'Sigurado ka bang babawiin mo ang pagpapatala sa kursong ito?',
    'Remove this announcement?': 'Alisin ang anunsyong ito?',
    'e.g. Introduction to Computing': 'hal. Panimula sa Kompyuter',
    'e.g. Midterm Schedule Advisory': 'hal. Abiso sa Iskedyul ng Midterm',
    'e.g. Reading Assignment & Quiz Notice': 'hal. Abiso tungkol sa Babasahin at Pagsusulit',
    'Enter message details here...': 'Ilagay dito ang mga detalye ng mensahe...',
    'Enter message for your enrolled students...': 'Ilagay ang mensahe para sa mga naka-enroll mong mag-aaral...',
    'e.g. CS101': 'hal. CS101',
    'user@apex.edu.ph': 'user@apex.edu.ph',
    'Collapse navigation': 'I-collapse ang nabigasyon',
    'Close student navigation': 'Isara ang nabigasyon ng mag-aaral',
    'Open student navigation': 'Buksan ang nabigasyon ng mag-aaral',
    'Student dashboard navigation': 'Nabigasyon ng dashboard ng mag-aaral',
    'Student sections': 'Mga seksyon ng mag-aaral',
    'Dashboard': 'Dashboard',
    'My Enrolled Courses': 'Mga Kursong Kinuha Ko',
    'Course Catalog': 'Katalogo ng mga Kurso',
    'Application Status': 'Katayuan ng Aplikasyon',
    'Course Announcement Feed': 'Feed ng mga Anunsyo sa Kurso',
    'My Profile': 'Aking Profile',
    'My Courses': 'Mga Kurso Ko',
    'Student Privacy': 'Pagkapribado ng Mag-aaral',
    'Your learning': 'Iyong pag-aaral',
    'Your currently approved course enrollments and class details.': 'Mga aprubadong kurso mo at mga detalye ng klase.',
    'No courses yet': 'Wala ka pang kurso',
    'You are not currently enrolled in any courses.': 'Wala ka pang naka-enroll na kurso sa ngayon.',
    'Browse the course catalog': 'Tingnan ang katalogo ng kurso',
    'My enrolled courses': 'Mga kursong naka-enroll ka',
    'Enrolled': 'Naka-enroll',
    'Instructor to be announced': 'Ia-anunsyo pa ang guro',
    'Class days': 'Mga araw ng klase',
    'To be announced': 'Ia-anunsyo pa',
    'Time': 'Oras',
    'Room': 'Silid',
    'View schedule': 'Tingnan ang iskedyul',
    'Drop course': 'Mag-drop ng kurso',
    'Student portal': 'Portal ng mag-aaral',
    'This notice explains how information connected to your APEX Learning Hub student account is used within the portal.': 'Ipinapaliwanag ng abisong ito kung paano ginagamit sa portal ang impormasyong kaugnay ng iyong student account sa APEX Learning Hub.',
    'Information used in your account': 'Impormasyong ginagamit sa iyong account',
    'The portal uses account details such as your name, APEX Email, and student ID, along with information about your course enrollments, applications, class schedule, assignments, completion status, and announcements relevant to your courses.': 'Ginagamit ng portal ang mga detalye ng account gaya ng iyong pangalan, APEX Email, at student ID, kasama ang impormasyon tungkol sa iyong mga kurso, aplikasyon, iskedyul ng klase, takdang-aralin, katayuan ng pagkumpleto, at mga anunsyo para sa iyong mga kurso.',
    'Why this information is used': 'Bakit ginagamit ang impormasyong ito',
    'This information supports student portal features, including displaying your courses and schedule, managing enrollment requests, showing assignments and announcements, and maintaining your profile.': 'Sinusuportahan ng impormasyong ito ang mga feature ng portal ng mag-aaral, kabilang ang pagpapakita ng iyong mga kurso at iskedyul, pamamahala ng mga kahilingan sa pagpapatala, pagpapakita ng mga takdang-aralin at anunsyo, at pagpapanatili ng iyong profile.',
    'Access to student information': 'Pag-access sa impormasyon ng mag-aaral',
    'Information is available through the portal according to account roles and the features needed for academic and administrative work. Course-related information may be visible to the instructors responsible for those courses and authorized school staff.': 'Makikita ang impormasyon sa portal ayon sa mga tungkulin ng account at mga feature na kailangan para sa gawaing akademiko at administratibo. Maaaring makita ng mga gurong namamahala sa mga kurso at awtorisadong kawani ng paaralan ang impormasyong may kaugnayan sa kurso.',
    'Keeping your account details current': 'Pagpapanatiling napapanahon ng mga detalye ng account',
    'You can review and update editable profile details from My Profile. Institutional account information managed by the school may need to be corrected by the appropriate school administrator.': 'Maaari mong tingnan at baguhin ang mga nae-edit na detalye ng profile sa Aking Profile. Maaaring kailangang itama ng naaangkop na tagapangasiwa ng paaralan ang impormasyong pinamamahalaan ng institusyon.',
    'Questions or requests': 'Mga tanong o kahilingan',
    'For questions about your student information or requests to review or correct it, contact your school’s registrar or the administrator responsible for APEX Learning Hub.': 'Para sa mga tanong tungkol sa impormasyon mo bilang mag-aaral o kahilingang suriin o itama ito, makipag-ugnayan sa registrar ng paaralan o sa tagapangasiwang namamahala sa APEX Learning Hub.',
    'Fiscal Year': 'Taong Pananalapi',
    'Not set': 'Hindi pa naitatakda',
    'Privacy Policy': 'Patakaran sa Pagkapribado',
    'Set a fiscal year': 'Magtakda ng taong pananalapi',
    'Choose the academic year and semester you want to view.': 'Piliin ang akademikong taon at semestre na nais mong tingnan.',
    'Academic year': 'Akademikong taon',
    'Select an academic year': 'Pumili ng akademikong taon',
    'Semester': 'Semestre',
    'Select a semester': 'Pumili ng semestre',
    'First Semester': 'Unang Semestre',
    'Second Semester': 'Ikalawang Semestre',
    'Summer': 'Tag-init',
    'Save selection': 'I-save ang pinili',
    'Current selection:': 'Kasalukuyang pinili:',
    'The saved selection is invalid. Please choose the year and semester again.': 'Hindi wasto ang naka-save na pinili. Piliin muli ang taon at semestre.',
    'Unable to read the saved selection. Please choose the year and semester again.': 'Hindi mabasa ang naka-save na pinili. Piliin muli ang taon at semestre.',
    'Unable to save your selection in this browser. Please try again.': 'Hindi mai-save ang pinili sa browser na ito. Subukan muli.',
    'Your updates': 'Mga Update Mo',
    'Today': 'Ngayon',
    'Drop': 'Bawiin',
    'Cancel': 'Kanselahin',
    'My Application History & Decisions': 'Kasaysayan at mga Desisyon sa Aking mga Aplikasyon',
    'No announcements available right now. Check back later!': 'Wala pang anunsyo sa ngayon. Bumalik muli sa ibang pagkakataon!',
    'Edit Profile Information': 'I-edit ang Impormasyon ng Profile',
    'Student ID:': 'ID ng Mag-aaral:',
    'Joined:': 'Petsa ng Pagsali:',
    'Active Scholar': 'Aktibong Mag-aaral',
    'Email address is managed by campus administration.': 'Pinamamahalaan ng administrasyon ng kampus ang email address na ito.',
    'Seats:': 'Mga Upuan:',
    '% Available': '% ang Bakante',
    'Browse course catalog': 'Tingnan ang Katalogo ng mga Kurso',
    'Mark assignment complete': 'Markahang tapos ang takdang-aralin',
    'Your weekly timetable': 'Ang Iyong Lingguhang Iskedyul',
    'Assignments to complete': 'Mga Takdang-Araling Gagawin',
    'No enrollment applications are awaiting a decision.': 'Walang aplikasyon sa pagpapatala na naghihintay ng desisyon.',
    'Completed assignments': 'Mga Natapos na Takdang-Aralin',
    'Create Course': 'Gumawa ng Kurso',
    '+ Create Course': '+ Gumawa ng Kurso',
    '+ New Course': '+ Bagong Kurso',
    '+ New User': '+ Bagong User',
    '+ Announcement': '+ Anunsyo',
    '+ Add User Account': '+ Magdagdag ng User Account',
    '+ Post Announcement': '+ Mag-post ng Anunsyo',
    '+ New Announcement': '+ Bagong Anunsyo',
    '+ New Assignment': '+ Bagong Takdang-Aralin',
    '+ Post Class Announcement': '+ Mag-post ng Anunsyo sa Klase',
    '+ Create Assignment': '+ Gumawa ng Takdang-Aralin',
    'Create Course Assignment': 'Gumawa ng Takdang-Aralin sa Kurso',
    'Announcement Details *': 'Mga Detalye ng Anunsyo *',
    'Announcement Title *': 'Pamagat ng Anunsyo *',
    'Course Name *': 'Pangalan ng Kurso *',
    'Course Code *': 'Code ng Kurso *',
    'Maximum Student Capacity': 'Pinakamaraming Mag-aaral',
    'Maximum Capacity': 'Pinakamaraming Kapasidad',
    'Account Role *': 'Tungkulin ng Account *',
    'Target Audience': 'Mga Paglalaanan',
    'Announcement Content *': 'Nilalaman ng Anunsyo *',
    'Start Time': 'Oras ng Pagsisimula',
    'End Time': 'Oras ng Pagtatapos',
    'Room / Location': 'Silid / Lokasyon',
    'Broadcast Now': 'Ipadala Ngayon',
    'Save Schedule': 'I-save ang Iskedyul',
    'Add User Account': 'Magdagdag ng User Account',
    'Create New Academic Course': 'Gumawa ng Bagong Kursong Akademiko',
    'Pending Course Admission Requests': 'Mga Naghihintay na Kahilingan sa Pagpasok sa Kurso',
    'My Courses & Capacity': 'Mga Kurso Ko at Kapasidad',
    'Class Student Rosters': 'Mga Talaan ng Mag-aaral sa Klase',
    'Course Bulletins': 'Mga Anunsyo sa Kurso',
    'Assignments': 'Mga Takdang-Aralin',
    'Review and decide on student applications': 'Suriin at pagpasyahan ang mga aplikasyon ng mag-aaral',
    'Pending Applications': 'Mga Naghihintay na Aplikasyon',
    'Enrollment Applications': 'Mga Aplikasyon sa Pagpapatala',
    'Users & Faculty': 'Mga User at Guro',
    'No enrollment applications are awaiting a decision.': 'Walang aplikasyon sa pagpapatala na naghihintay ng desisyon.',
    'All Students (Global Campus Broadcast)': 'Lahat ng Mag-aaral (Anunsyo para sa Buong Kampus)',
    'Use at least 8 characters, including uppercase and lowercase letters, a number, and a special character.': 'Gumamit ng hindi bababa sa 8 character na may malaking letra, maliit na letra, numero, at espesyal na simbolo.',
    'Search by course code, title, or professor...': 'Maghanap ayon sa code o pangalan ng kurso, o pangalan ng guro...',
    'Search courses or codes...': 'Maghanap ng kurso o code...',
    'Search user by name or email...': 'Maghanap ng user ayon sa pangalan o email...',
    'Search student or course...': 'Maghanap ng mag-aaral o kurso...',
    'Search student roster...': 'Maghanap sa talaan ng mga mag-aaral...',
    'e.g. Introduction to Computing': 'hal. Panimula sa Kompyuter',
    'e.g. Midterm Schedule Advisory': 'hal. Abiso sa Iskedyul ng Midterm',
    'e.g. Reading Assignment & Quiz Notice': 'hal. Abiso tungkol sa Babasahin at Pagsusulit',
    'Enter message details here...': 'Ilagay dito ang mga detalye ng mensahe...',
    'Enter message for your enrolled students...': 'Ilagay ang mensahe para sa mga naka-enroll mong mag-aaral...',
    'My Class Announcements': 'Mga Anunsyo Ko sa Klase',
    'Course Assignments': 'Mga Takdang-Aralin sa Kurso',
    'No assignments have been created yet.': 'Wala pang nagagawang takdang-aralin.',
    'No students enrolled yet.': 'Wala pang naka-enroll na mag-aaral.',
    'No courses created yet.': 'Wala pang nagagawang kurso.',
    'No enrollment records found.': 'Walang nakitang tala ng pagpapatala.',
    'No announcements active.': 'Walang aktibong anunsyo.',
    'Pending Course Admission Requests': 'Mga Naghihintay na Kahilingan sa Pagpasok sa Kurso',
    'No students enrolled yet.': 'Wala pang naka-enroll na mag-aaral.',
    'No announcements available right now. Check back later!': 'Wala pang anunsyo sa ngayon. Bumalik muli sa ibang pagkakataon!',
    'Confirm New Password': 'Kumpirmahin ang Bagong Password',
    'e.g. Juan': 'hal. Juan',
    'e.g. Dela Cruz': 'hal. Dela Cruz',
    'Enter a message for your enrolled students...': 'Ilagay ang mensahe para sa mga naka-enroll mong mag-aaral...',
    'e.g. name@email.com': 'hal. pangalan@email.com',
    'Describe your question or concern in detail...': 'Ilarawan nang detalyado ang iyong tanong o alalahanin...',
    'You’re all caught up': 'Wala ka nang bagong update',
    'There are no campus or course announcements for you right now.': 'Wala pang anunsyo para sa iyo mula sa kampus o sa mga kurso mo.',
    'Your schedule appears here after course enrollment.': 'Lalabas dito ang iyong iskedyul kapag naka-enroll ka na sa kurso.',
    'Course Schedule': 'Iskedyul ng Kurso',
    'Courses and Codes': 'Mga Kurso at Code',
    'No enrollment applications submitted yet.': 'Wala ka pang naisusumiteng aplikasyon sa pagpapatala.',
    'No announcements for your courses yet.': 'Wala pang anunsyo para sa iyong mga kurso.',
    'My Application History & Decisions': 'Kasaysayan at mga Desisyon sa Aking mga Aplikasyon',
    'All courses you have applied for': 'Lahat ng kursong inaplayan mo',
    'Campus & Course Announcements Feed': 'Feed ng mga Anunsyo sa Kampus at Kurso',
    'Posted by': 'Ipinaskil ni',
    'Campus Bulletin': 'Anunsyo sa Kampus',
    'Edit Profile Information': 'I-edit ang Impormasyon ng Profile',
    'Student ID:': 'ID ng Mag-aaral:',
    'Joined:': 'Petsa ng Pagsali:',
    'Active Scholar': 'Aktibong Mag-aaral',
    'Email address is managed by campus administration.': 'Pinamamahalaan ng administrasyon ng kampus ang email address na ito.',
    'Your updates': 'Mga Update Mo',
    'Your weekly timetable': 'Ang Iyong Lingguhang Iskedyul',
    'Stay on track': 'Subaybayan ang Iyong mga Gawain',
    'Student dashboard navigation': 'Nabigasyon ng dashboard ng mag-aaral',
    'Announcements for this student': 'Mga anunsyo para sa mag-aaral na ito',
    'Weekly class timetable': 'Lingguhang iskedyul ng klase',
    'No classes': 'Walang klase',
    'Schedule to be announced': 'Iaanunsyo pa ang iskedyul',
    'These courses are enrolled, but meeting details have not been published yet.': 'Naka-enroll ka sa mga kursong ito, ngunit hindi pa inilalathala ang mga detalye ng klase.',
    'No enrollment applications are awaiting a decision.': 'Walang aplikasyon sa pagpapatala na naghihintay ng desisyon.',
    'Enrollment decision pending': 'Naghihintay ang desisyon sa pagpapatala',
    'Awaiting review': 'Naghihintay ng pagsusuri',
    'Completed assignments': 'Mga Natapos na Takdang-Aralin',
    'Mark assignment complete': 'Markahang tapos ang takdang-aralin',
    'No Active Course Enrollments': 'Wala Kang Aktibong Pagpapatala sa Kurso',
    'No Active Course Enrollment': 'Wala Kang Aktibong Pagpapatala sa Kurso',
    'You are not currently enrolled in any courses. Browse the course catalog to submit enrollment applications for faculty review.': 'Wala ka pang kursong kinukuha. Tingnan ang katalogo ng mga kurso at magsumite ng aplikasyon upang masuri ng guro.',
    'Browse course catalog': 'Tingnan ang Katalogo ng mga Kurso',
    'Active Enrollment': 'Aktibong Pagpapatala',
    'Drop Course': 'Bawiin ang Pagpapatala',
    'Open Seats': 'May Bakanteng Upuan',
    'Class Full': 'Puno na ang Klase',
    'Awaiting decision': 'Naghihintay ng desisyon',
    'Campus & Course Announcements Feed': 'Feed ng mga Anunsyo sa Kampus at Kurso',
    'Enrolled': 'Naka-enroll',
    'APPROVED': 'APRUBADO',
    'PENDING': 'NAKABINBIN',
    'REJECTED': 'TINANGGIHAN',
    'Student Portal | APEX Learning Hub': 'Portal ng Mag-aaral | APEX Learning Hub',
    'Registrar Workspace | APEX Learning Hub': 'Workspace ng Registrar | APEX Learning Hub',
    'Faculty Dashboard | APEX Learning Hub': 'Dashboard ng Guro | APEX Learning Hub',
    'Administrator Workspace | APEX Learning Hub': 'Workspace ng Tagapangasiwa | APEX Learning Hub',
    'Sign In • APEX Learning Hub': 'Mag-sign in • APEX Learning Hub',
    'Sign Up • APEX Learning Hub': 'Pagpaparehistro • APEX Learning Hub',
    'Forgot Password • APEX Learning Hub': 'Nakalimutan ang Password • APEX Learning Hub',
    'Set New Password • APEX Learning Hub': 'Magtakda ng Bagong Password • APEX Learning Hub',
    'APEX Learning Hub. All rights reserved 2026': 'APEX Learning Hub. Nakalaan ang lahat ng karapatan 2026',
    '© 2026 • All Rights Reserved.': '© 2026 • Nakalaan ang Lahat ng Karapatan.',
    'All Rights Reserved.': 'Nakalaan ang lahat ng karapatan.',
    'Administrator': 'Tagapangasiwa',
    'Registrar': 'Registrar',
    'Professor': 'Guro',
    'Faculty': 'Mga Guro',
    'First Name *': 'Pangalan *',
    'Last Name *': 'Apelyido *',
    'Initial Password *': 'Paunang Password *',
    'Maximum Student Capacity': 'Pinakamaraming Mag-aaral',
    'Create Course': 'Gumawa ng Kurso',
    'No courses created yet.': 'Wala pang nagagawang kurso.',
    'Unassigned': 'Walang nakatalaga',
    'Current Registrar': 'Kasalukuyang Registrar',
    'Current Administrator': 'Kasalukuyang Tagapangasiwa',
    'Student Name': 'Pangalan ng Mag-aaral',
    'Enrolled Course': 'Kursong Kinuha',
    'Applied At': 'Petsa ng Pag-aaplay',
    'Applied Date': 'Petsa ng Pag-aaplay',
    'Applied On': 'Petsa ng Pag-aaplay',
    'Date Posted': 'Petsa ng Pag-post',
    'Date Published': 'Petsa ng Paglathala',
    'Registrar Actions': 'Mga Aksyon ng Registrar',
    'Approval Actions': 'Mga Aksyon sa Pag-apruba',
    'No enrollment records found.': 'Walang nakitang tala ng pagpapatala.',
    'No announcements active.': 'Walang aktibong anunsyo.',
    'No students enrolled yet.': 'Wala pang naka-enroll na mag-aaral.',
    'No assignments have been created yet.': 'Wala pang nagagawang takdang-aralin.',
    'You haven’t posted any announcements yet.': 'Wala ka pang nailalathalang anunsyo.',
    "You haven't posted any announcements yet.": 'Wala ka pang nailalathalang anunsyo.',
    'Pending Course Admission Requests': 'Mga Naghihintay na Kahilingan sa Pagpasok sa Kurso',
    'Assigned Courses': 'Mga Itinalagang Kurso',
    'Awaiting Approval': 'Naghihintay ng Pag-apruba',
    'My Courses & Capacity': 'Mga Kurso Ko at Kapasidad',
    'Class Student Rosters': 'Mga Talaan ng Mag-aaral sa Klase',
    'Course Bulletins': 'Mga Anunsyo sa Kurso',
    'Subject & Message': 'Paksa at Mensahe',
    'Target Course': 'Nilalayong Kurso',
    'Contact Email': 'Email sa Pakikipag-ugnayan',
    'Approval Actions': 'Mga Aksyon sa Pag-apruba',
    'Enrollment / Capacity': 'Naka-enroll / Kapasidad',
    'Assigned Professor': 'Itinalagang Guro',
    'Maximum Capacity': 'Pinakamaraming Kapasidad',
    'No account was found with that email address.': 'Walang account na nahanap gamit ang email address na iyon.',
    'Please enter your APEX email address.': 'Ilagay ang iyong APEX email address.',
    'Please provide a valid APEX email address.': 'Maglagay ng wastong APEX email address.',
    'No matching pages found for': 'Walang nahanap na pahinang tumutugma sa',
    'We’ll get back to you within 1–2 business days.': 'Sasagot kami sa loob ng 1–2 araw ng trabaho.',
    'Your message has been sent. We’ll get back to you within 1–2 business days.': 'Naipadala na ang iyong mensahe. Sasagot kami sa loob ng 1–2 araw ng trabaho.',
    'All Bulletins': 'Lahat ng Anunsyo',
    'Academic': 'Akademiko',
    'System Updates': 'Mga Update sa Sistema',
    'Campus Events': 'Mga Kaganapan sa Kampus',
    'Policy Notices': 'Mga Abiso sa Patakaran',
    'Previous announcement': 'Naunang anunsyo',
    'Next announcement': 'Susunod na anunsyo',
    'Previous offering': 'Naunang iniaalok',
    'Next offering': 'Susunod na iniaalok',
    'Previous student guide card': 'Naunang gabay ng mag-aaral',
    'Next student guide card': 'Susunod na gabay ng mag-aaral',
    'APEX Learning Hub — Home': 'APEX Learning Hub — Pangunahing Pahina',
    'Announcements — APEX Learning Hub': 'Mga Anunsyo — APEX Learning Hub',
    'Contact Us — APEX Learning Hub': 'Makipag-ugnayan — APEX Learning Hub',
    'Policies — APEX Learning Hub': 'Mga Patakaran — APEX Learning Hub',
    'Sign In • APEX Learning Hub': 'Mag-sign in • APEX Learning Hub',
    'Forgot Password • APEX Learning Hub': 'Nakalimutan ang Password • APEX Learning Hub',
    'Sign Up • APEX Learning Hub': 'Magrehistro • APEX Learning Hub',
    'Set New Password • APEX Learning Hub': 'Magtakda ng Bagong Password • APEX Learning Hub',
    'Administrator Workspace | APEX Learning Hub': 'Workspace ng Tagapangasiwa | APEX Learning Hub',
    'Pending Tasks | APEX Learning Hub': 'Mga Nakabinbing Gawain | APEX Learning Hub',
    'Announcements | APEX Learning Hub': 'Mga Anunsyo | APEX Learning Hub',
    'Student Portal | APEX Learning Hub': 'Portal ng Mag-aaral | APEX Learning Hub',
    'Registrar Workspace | APEX Learning Hub': 'Workspace ng Registrar | APEX Learning Hub',
    'Class Schedule | APEX Learning Hub': 'Iskedyul ng Klase | APEX Learning Hub',
    'Faculty Dashboard | APEX Learning Hub': 'Dashboard ng Guro | APEX Learning Hub',
    'Read more': 'Magbasa pa',
    'Show less': 'Ipakita nang mas kaunti',
    'Create Account': 'Gumawa ng Account',
    '← Return to Sign In': '← Bumalik sa Pag-sign in',
    'Sign In to Portal': 'Mag-sign in sa Portal',
    'Curriculum': 'Kurikulum',
    'Coursework': 'Kurso at mga Gawain',
    'Bulletins': 'Mga Anunsyo',
    'Previous offering': 'Naunang alok',
    'Next offering': 'Susunod na alok',
    'Students studying with digital resources': 'Mga mag-aaral na gumagamit ng mga digital na sanggunian sa pag-aaral',
    'Interactive modern software interface': 'Makabagong interactive na interface ng software',
    'Examinations and university notices': 'Mga pagsusulit at anunsyo ng pamantasan',
    'Professor mentorship and classroom discussion': 'Paggabay ng guro at talakayan sa klase',
    'View details': 'Tingnan ang mga detalye',
    'Password must be 8-72 characters and include an uppercase letter, a lowercase letter, a number, and a special character.': 'Dapat may 8–72 character ang password at naglalaman ito ng malaking titik, maliit na titik, numero, at espesyal na simbolo.',
    'Email and password are required.': 'Kailangan ang email at password.',
    'Invalid email or password.': 'Mali ang email o password.',
    'All required fields must be filled.': 'Punan ang lahat ng kinakailangang field.',
    'An account already exists with that email.': 'May account nang gumagamit ng email na iyon.',
    'Registration successful!': 'Matagumpay ang pagpaparehistro!',
    'Unknown action.': 'Hindi kilalang aksyon.',
    'Invalid course selection.': 'Hindi wastong pagpili ng kurso.',
    'Course not found.': 'Hindi nahanap ang kurso.',
    'You are already enrolled in this course.': 'Naka-enroll ka na sa kursong ito.',
    'Your enrollment application is currently pending professor approval.': 'Naghihintay pa ng pag-apruba ng guro ang aplikasyon mo sa pagpapatala.',
    'This course has reached its maximum student capacity.': 'Naabot na ng kursong ito ang pinakamataas na bilang ng mag-aaral.',
    'Course application or enrollment has been dropped.': 'Binawi na ang aplikasyon o pagpapatala sa kurso.',
    'Invalid assignment selected.': 'Hindi wastong takdang-aralin ang napili.',
    'That assignment is not available in your enrolled courses.': 'Hindi bahagi ng mga kursong naka-enroll ka ang takdang-araling iyon.',
    'Assignment marked complete.': 'Minarkahang tapos ang takdang-aralin.',
    'First and last name cannot be empty.': 'Hindi maaaring blangko ang pangalan at apelyido.',
    'Profile details updated successfully.': 'Matagumpay na na-update ang mga detalye ng profile.',
    'Unknown student action.': 'Hindi kilalang aksyon ng mag-aaral.',
    'You do not have permission to moderate this enrollment.': 'Wala kang pahintulot na magpasya tungkol sa pagpapatala na ito.',
    'Course, Title, and Message are required.': 'Kailangan ang kurso, pamagat, at mensahe.',
    'You can only post announcements to your assigned courses.': 'Maaari ka lamang mag-post ng mga anunsyo sa mga kursong nakatalaga sa iyo.',
    'Announcement published to your class.': 'Naipaskil na ang anunsyo sa klase mo.',
    'Choose a course, enter a title, and provide a valid due date and time.': 'Pumili ng kurso, maglagay ng pamagat, at magbigay ng wastong takdang petsa at oras.',
    'You can only create assignments for your assigned courses.': 'Maaari ka lamang gumawa ng takdang-aralin para sa mga kursong nakatalaga sa iyo.',
    'Assignment published to your enrolled students.': 'Naipaskil na ang takdang-aralin para sa mga mag-aaral na naka-enroll sa klase mo.',
    'Assignment not found or you do not have permission to delete it.': 'Hindi nahanap ang takdang-aralin o wala kang pahintulot na burahin ito.',
    'Assignment deleted.': 'Nabura na ang takdang-aralin.',
    'Announcement removed.': 'Inalis na ang anunsyo.',
    'Unknown professor action.': 'Hindi kilalang aksyon ng guro.',
    'Course Code and Name are required. Enter a valid schedule or leave schedule fields blank.': 'Kailangan ang code at pangalan ng kurso. Maglagay ng wastong iskedyul o iwang blangko ang mga field ng iskedyul.',
    'Choose valid meeting days and a valid start and end time.': 'Pumili ng wastong mga araw ng klase at oras ng pagsisimula at pagtatapos.',
    'Invalid course selected.': 'Hindi wastong kurso ang napili.',
    'Course schedule updated.': 'Na-update na ang iskedyul ng kurso.',
    'Course removed successfully.': 'Matagumpay na naalis ang kurso.',
    'All user fields are required.': 'Kailangang punan ang lahat ng detalye ng gumagamit.',
    'Invalid role specified.': 'Hindi wastong tungkulin ang tinukoy.',
    'You cannot delete your own active account.': 'Hindi mo maaaring burahin ang sarili mong aktibong account.',
    'User deleted successfully.': 'Matagumpay na nabura ang gumagamit.',
    'Invalid enrollment decision.': 'Hindi wastong desisyon sa pagpapatala.',
    'Title and announcement content are required.': 'Kailangan ang pamagat at nilalaman ng anunsyo.',
    'Announcement published successfully.': 'Matagumpay na nailathala ang anunsyo.',
    'Announcement deleted.': 'Nabura na ang anunsyo.',
    'Invalid action specified.': 'Hindi wastong aksyon ang tinukoy.'
};

/* ── 1. Global Live Search Functionality ─────────────────────────── */
function initGlobalSearch() {
    const searchInput = document.getElementById('globalSearch');
    const resultsBox  = document.getElementById('searchResults');
    const clearBtn    = document.getElementById('searchClear');
    if (!searchInput || !resultsBox) return;

    let debounceTimer;

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        const query = searchInput.value.trim();

        if (clearBtn) {
            clearBtn.style.display = query.length > 0 ? 'block' : 'none';
        }

        debounceTimer = setTimeout(() => {
            renderSearchResults(query, resultsBox);
        }, 120);
    });

    searchInput.addEventListener('focus', () => {
        const query = searchInput.value.trim();
        if (query.length > 0) {
            renderSearchResults(query, resultsBox);
        }
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            clearBtn.style.display = 'none';
            resultsBox.classList.remove('visible');
            searchInput.focus();
        });
    }

    // Pressing Enter navigates directly to the top match
    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const firstResult = resultsBox.querySelector('.search-result-item');
            if (firstResult) {
                window.location.href = firstResult.getAttribute('href');
            } else if (searchInput.value.trim().length > 0) {
                window.location.href = `${document.body.dataset.visualBase || ''}announcement.php`;
            }
        } else if (e.key === 'Escape') {
            resultsBox.classList.remove('visible');
        }
    });

    // Close dropdown on outside click
    document.addEventListener('click', (e) => {
        if (!searchInput.closest('.sub-search').contains(e.target)) {
            resultsBox.classList.remove('visible');
        }
    });
}

function renderSearchResults(query, container) {
    if (query.length === 0) {
        container.classList.remove('visible');
        return;
    }

    const q = query.toLowerCase();
    const matches = SEARCH_INDEX.filter(item =>
        item.title.toLowerCase().includes(q) ||
        item.page.toLowerCase().includes(q)
    ).slice(0, 6);

    if (matches.length === 0) {
        container.innerHTML = `
            <div class="search-empty">
                No matching pages found for "<strong>${escapeHtml(query)}</strong>".
                <div style="margin-top:6px; font-size:12px; color:var(--text-light);">
                    Try searching for "announcements", "policies", or "portal".
                </div>
            </div>
        `;
    } else {
        const visualBase = document.body.dataset.visualBase || '';
        container.innerHTML = matches.map(m => `
            <a class="search-result-item" href="${visualBase}${m.url}">
                <span class="res-title">${highlightMatch(m.title, query)}</span>
                <span class="res-page">${escapeHtml(m.page)} &bull; View details &rarr;</span>
            </a>
        `).join('');
    }

    container.classList.add('visible');
}

function highlightMatch(text, query) {
    const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${escapedQuery})`, 'gi');
    return escapeHtml(text).replace(regex, '<mark style="background:#fee2e2;color:#991b1b;padding:0 2px;border-radius:2px;">$1</mark>');
}

function escapeHtml(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

/* ── 2. Language Switcher (Only English and Filipino) ────────────── */
function initLanguageSwitcher() {
    const langBtn   = document.getElementById('langBtn');
    const langDrop  = document.getElementById('langDropdown');
    const langLabel = document.getElementById('langLabel');
    if (!langBtn || !langDrop) return;

    // Load saved language (default: 'en')
    const currentLang = localStorage.getItem('apex_lang') || 'en';
    applyLanguage(currentLang, false);

    // Toggle dropdown
    langBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = langDrop.classList.toggle('open');
        langBtn.setAttribute('aria-expanded', String(isOpen));
        langBtn.closest('.lang-wrapper').classList.toggle('active', isOpen);
    });

    // Close on outside click
    document.addEventListener('click', () => {
        langDrop.classList.remove('open');
        langBtn.setAttribute('aria-expanded', 'false');
        langBtn.closest('.lang-wrapper').classList.remove('active');
    });

    langDrop.addEventListener('click', (e) => e.stopPropagation());

    // Option selection
    langDrop.querySelectorAll('.lang-option').forEach(opt => {
        opt.addEventListener('click', () => {
            const selectedLang = opt.getAttribute('data-lang');
            applyLanguage(selectedLang, true);
            langDrop.classList.remove('open');
            langBtn.setAttribute('aria-expanded', 'false');
            langBtn.closest('.lang-wrapper').classList.remove('active');
        });
    });

    if (!document.body.dataset.translationObserver) {
        const observer = new MutationObserver(() => translateInterface(document.body.classList.contains('lang-fil')));
        observer.observe(document.body, { childList: true, characterData: true, subtree: true });
        document.body.dataset.translationObserver = 'true';
    }
}

const originalTextNodes = new WeakMap();
const originalAttributes = new WeakMap();

function translateInterface(isFilipino) {
    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
    let node;

    while ((node = walker.nextNode())) {
        if (node.parentElement.closest('[data-lang-en], [data-lang-fil], script, style, noscript')) continue;
        const current = node.data;
        let record = originalTextNodes.get(node);
        if (!record || (current !== record.en && current !== record.fil)) {
            record = { en: current, fil: current };
            originalTextNodes.set(node, record);
        }

        const trimmed = record.en.trim();
        const translated = isFilipino ? (UI_TRANSLATIONS[trimmed] || trimmed) : trimmed;
        const text = record.en.replace(trimmed, translated);
        if (node.data !== text) {
            node.data = text;
        }
        record.fil = node.data;
    }

    const translatedAttributes = ['placeholder', 'title', 'aria-label', 'alt'];
    document.querySelectorAll('[placeholder], [title], [aria-label], [alt]').forEach(element => {
        let records = originalAttributes.get(element);
        if (!records) {
            records = {};
            originalAttributes.set(element, records);
        }

        translatedAttributes.forEach(attribute => {
            if (!element.hasAttribute(attribute)) return;
            const current = element.getAttribute(attribute);
            let record = records[attribute];
            if (!record || (current !== record.en && current !== record.fil)) {
                record = { en: current, fil: current };
                records[attribute] = record;
            }
            const key = record.en.trim();
            const value = isFilipino ? (UI_TRANSLATIONS[key] || key) : key;
            const translatedValue = record.en.replace(key, value);
            if (element.getAttribute(attribute) !== translatedValue) {
                element.setAttribute(attribute, translatedValue);
            }
            record.fil = element.getAttribute(attribute);
        });
    });
}

function applyLanguage(lang, save) {
    if (save) {
        localStorage.setItem('apex_lang', lang);
    }

    const isFilipino = (lang === 'fil');
    document.body.classList.toggle('lang-fil', isFilipino);
    document.documentElement.lang = isFilipino ? 'fil' : 'en';
    const originalTitle = document.documentElement.dataset.originalTitle || document.title;
    document.documentElement.dataset.originalTitle = originalTitle;
    document.title = isFilipino
        ? (UI_TRANSLATIONS[originalTitle] || originalTitle)
        : originalTitle;
    translateInterface(isFilipino);

    const langLabel = document.getElementById('langLabel');
    if (langLabel) {
        langLabel.textContent = isFilipino ? 'Filipino' : 'English';
    }

    document.querySelectorAll('.lang-option').forEach(opt => {
        const isCurrent = opt.getAttribute('data-lang') === lang;
        opt.classList.toggle('selected', isCurrent);
    });

    refreshGuideCards();
}

/* ── 3. Homepage Guide Card Expansion ───────────────────────────── */
function refreshGuideCards() {
    const isFilipino = document.body.classList.contains('lang-fil');

    document.querySelectorAll('.guide-card').forEach(card => {
        const answer = card.querySelector(
            isFilipino ? '.guide-answer-copy[data-lang-fil]' : '.guide-answer-copy[data-lang-en]'
        );
        const toggle = card.querySelector('.guide-toggle');
        if (!answer || !toggle) return;

        const wasExpanded = card.classList.contains('expanded');
        card.classList.remove('expanded');
        card.classList.add('is-measuring');
        const hasOverflow = answer.scrollHeight > answer.clientHeight + 1;
        card.classList.toggle('has-overflow', hasOverflow);
        card.classList.remove('is-measuring');
        card.classList.toggle('expanded', wasExpanded);

        toggle.setAttribute('aria-expanded', wasExpanded ? 'true' : 'false');
        toggle.textContent = isFilipino
            ? (wasExpanded ? 'Ipakita nang mas kaunti' : 'Magbasa pa')
            : (wasExpanded ? 'Show less' : 'Read more');
    });
}

function initGuideCards() {
    const guideCards = document.querySelectorAll('.guide-card');
    if (!guideCards.length) return;

    guideCards.forEach(card => {
        const toggle = card.querySelector('.guide-toggle');
        if (!toggle) return;

        toggle.addEventListener('click', () => {
            const isExpanded = card.classList.toggle('expanded');
            toggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            refreshGuideCards();
        });
    });

    refreshGuideCards();
    window.addEventListener('resize', refreshGuideCards);
}

/* ── 4. Picture Containers: Hover & Click Highlight ─────────────── */
function initMediaCards() {
    const cards = document.querySelectorAll('.media-card');

    cards.forEach(card => {
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const viewport = card.closest('.media-carousel')?.querySelector('.media-carousel-viewport');
                if (!viewport) return;

                const behavior = window.matchMedia('(prefers-reduced-motion: reduce)').matches
                    ? 'auto'
                    : 'smooth';
                viewport.scrollTo({
                    left: getCarouselCardOffset(viewport, card),
                    behavior
                });
            }
        });
    });
}

function updateCenteredCard(viewport, cards) {
    const viewportCenter = viewport.getBoundingClientRect().left + viewport.clientWidth / 2;
    let centeredCard = null;
    let closestDistance = Infinity;

    cards.forEach(card => {
        const bounds = card.getBoundingClientRect();
        const distance = Math.abs(bounds.left + bounds.width / 2 - viewportCenter);
        if (distance < closestDistance) {
            closestDistance = distance;
            centeredCard = card;
        }
    });

    cards.forEach(card => card.classList.toggle('is-center', card === centeredCard));
}

function getCarouselCardOffset(viewport, card) {
    const viewportBounds = viewport.getBoundingClientRect();
    const cardBounds = card.getBoundingClientRect();
    return viewport.scrollLeft + cardBounds.left - viewportBounds.left
        - (viewport.clientWidth - cardBounds.width) / 2;
}

function initMediaCarousel() {
    const carousel = document.querySelector('.media-carousel');
    const viewport = carousel?.querySelector('.media-carousel-viewport');
    const track = carousel?.querySelector('.media-grid');
    const originalCards = track ? Array.from(track.querySelectorAll('.media-card')) : [];
    if (!carousel || !viewport || !track || !originalCards.length) return;

    const createLoopClone = card => {
        const clone = card.cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        clone.setAttribute('tabindex', '-1');
        return clone;
    };

    const cloneGroups = 3;
    const beforeClones = Array.from(
        { length: cloneGroups },
        () => originalCards.map(createLoopClone)
    ).flat();
    const afterClones = Array.from(
        { length: cloneGroups },
        () => originalCards.map(createLoopClone)
    ).flat();
    const beforeFragment = document.createDocumentFragment();
    beforeClones.forEach(clone => beforeFragment.appendChild(clone));
    track.prepend(beforeFragment);
    afterClones.forEach(clone => track.appendChild(clone));

    let loopStart = 0;
    let loopWidth = 0;
    const alignToOriginals = () => {
        loopStart = getCarouselCardOffset(viewport, originalCards[0]);
        loopWidth = getCarouselCardOffset(viewport, afterClones[0]) - loopStart;
        viewport.scrollLeft = loopStart;
        updateCenteredCard(viewport, Array.from(track.children));
    };
    alignToOriginals();

    let centerFrame = 0;
    const updateCenterOnScroll = () => {
        if (centerFrame) return;
        centerFrame = window.requestAnimationFrame(() => {
            centerFrame = 0;
            updateCenteredCard(viewport, Array.from(track.children));
        });
    };
    viewport.addEventListener('scroll', updateCenterOnScroll, { passive: true });

    const normalizeLoopPosition = () => {
        if (!loopWidth) return;

        if (viewport.scrollLeft < loopStart - loopWidth * 2) {
            viewport.scrollLeft += loopWidth * cloneGroups;
        } else if (viewport.scrollLeft >= loopStart + loopWidth * 2) {
            viewport.scrollLeft -= loopWidth * cloneGroups;
        }
        updateCenteredCard(viewport, Array.from(track.children));
    };

    if ('onscrollend' in viewport) {
        viewport.addEventListener('scrollend', normalizeLoopPosition);
    } else {
        let settleTimer;
        viewport.addEventListener('scroll', () => {
            window.clearTimeout(settleTimer);
            settleTimer = window.setTimeout(normalizeLoopPosition, 140);
        }, { passive: true });
    }

    window.addEventListener('resize', alignToOriginals);

    carousel.querySelectorAll('.media-carousel-arrow').forEach(button => {
        button.addEventListener('click', () => {
            const firstCard = originalCards[0];
            const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
            const step = firstCard.getBoundingClientRect().width + gap;
            const behavior = window.matchMedia('(prefers-reduced-motion: reduce)').matches
                ? 'auto'
                : 'smooth';

            const direction = button.dataset.direction === 'next' ? 1 : -1;
            viewport.scrollBy({ left: direction * step, behavior });
        });
    });
}

function initHomeCardCarousels() {
    document.querySelectorAll('.home-card-carousel').forEach(carousel => {
        const viewport = carousel.querySelector('.home-card-carousel-viewport');
        const track = carousel.querySelector('.home-card-carousel-track');
        const originalCards = track ? Array.from(track.children) : [];
        if (!viewport || !track || originalCards.length < 2) return;

        const cloneGroups = 3;
        const createLoopClone = card => {
            const clone = card.cloneNode(true);
            clone.setAttribute('aria-hidden', 'true');
            clone.querySelectorAll('a, button, [tabindex]').forEach(item => {
                item.setAttribute('tabindex', '-1');
            });
            clone.querySelectorAll('.guide-card').forEach(guideCard => {
                const toggle = guideCard.querySelector('.guide-toggle');
                if (!toggle) return;

                toggle.addEventListener('click', () => {
                    const isExpanded = guideCard.classList.toggle('expanded');
                    toggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                    refreshGuideCards();
                });
            });
            return clone;
        };
        const beforeClones = Array.from(
            { length: cloneGroups },
            () => originalCards.map(createLoopClone)
        ).flat();
        const afterClones = Array.from(
            { length: cloneGroups },
            () => originalCards.map(createLoopClone)
        ).flat();
        const beforeFragment = document.createDocumentFragment();
        beforeClones.forEach(clone => beforeFragment.appendChild(clone));
        track.prepend(beforeFragment);
        afterClones.forEach(clone => track.appendChild(clone));

        const allCards = Array.from(track.children);
        let loopStart = 0;
        let loopWidth = 0;
        const alignToOriginals = () => {
            loopStart = getCarouselCardOffset(viewport, originalCards[0]);
            loopWidth = getCarouselCardOffset(viewport, afterClones[0]) - loopStart;
            viewport.scrollLeft = loopStart;
            updateCenteredCard(viewport, allCards);
        };
        alignToOriginals();

        let centerFrame = 0;
        const updateCenterOnScroll = () => {
            if (centerFrame) return;
            centerFrame = window.requestAnimationFrame(() => {
                centerFrame = 0;
                updateCenteredCard(viewport, allCards);
            });
        };
        viewport.addEventListener('scroll', updateCenterOnScroll, { passive: true });

        const normalizeLoopPosition = () => {
            if (!loopWidth) return;

            if (viewport.scrollLeft < loopStart - loopWidth * 2) {
                viewport.scrollLeft += loopWidth * cloneGroups;
            } else if (viewport.scrollLeft >= loopStart + loopWidth * 2) {
                viewport.scrollLeft -= loopWidth * cloneGroups;
            }
            updateCenteredCard(viewport, allCards);
        };

        if ('onscrollend' in viewport) {
            viewport.addEventListener('scrollend', normalizeLoopPosition);
        } else {
            let settleTimer;
            viewport.addEventListener('scroll', () => {
                window.clearTimeout(settleTimer);
                settleTimer = window.setTimeout(normalizeLoopPosition, 140);
            }, { passive: true });
        }

        window.addEventListener('resize', alignToOriginals);

        carousel.querySelectorAll('.media-carousel-arrow').forEach(button => {
            button.addEventListener('click', () => {
                const firstCard = originalCards[0];
                const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
                const step = firstCard.getBoundingClientRect().width + gap;
                const behavior = window.matchMedia('(prefers-reduced-motion: reduce)').matches
                    ? 'auto'
                    : 'smooth';

                const direction = button.dataset.direction === 'next' ? 1 : -1;
                viewport.scrollBy({ left: direction * step, behavior });
            });
        });
    });
}

/* ── 5. Mobile Navigation Menu Toggle ────────────────────────────── */
function initMobileNav() {
    const toggleBtn = document.getElementById('menuToggle');
    const mainNav   = document.getElementById('mainNav');
    if (!toggleBtn || !mainNav) return;

    toggleBtn.addEventListener('click', () => {
        const isOpen = mainNav.classList.contains('open');
        mainNav.classList.toggle('open');
        toggleBtn.classList.toggle('open');
        toggleBtn.setAttribute('aria-expanded', !isOpen);
    });

    // Close when clicking any nav link
    mainNav.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            mainNav.classList.remove('open');
            toggleBtn.classList.remove('open');
            toggleBtn.setAttribute('aria-expanded', 'false');
        });
    });
}

/* ── 6. Smooth Scrolling for Internal Anchor Links ───────────────── */
function initSmoothAnchors() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const headerOffset = 76;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/* ── 7. Back-To-Top Button ───────────────────────────────────────── */
function initBackToTop() {
    const btn = document.getElementById('backToTop');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 280) {
            btn.classList.add('visible');
        } else {
            btn.classList.remove('visible');
        }
    });

    btn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/* ── 8. Policies Sidebar Active Scroll (for policies.php) ────────── */
function initPolicySidebar() {
    const navItems = document.querySelectorAll('.policy-nav-item[data-target]');
    if (!navItems.length) return;

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            const targetId = item.getAttribute('data-target');
            const target = document.getElementById(targetId);
            if (target) {
                const headerOffset = 80;
                const pos = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;
                window.scrollTo({ top: pos, behavior: 'smooth' });
            }
        });
    });
}

/* ── 9. Announcement Filter Tabs (for announcement.php) ──────────── */
function initAnnouncementFilter() {
    const tabs  = document.querySelectorAll('.filter-tab[data-filter]');
    const cards = document.querySelectorAll('.announcement-card[data-category]');
    if (!tabs.length) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const filter = tab.getAttribute('data-filter');
            cards.forEach(card => {
                const match = (filter === 'all' || card.getAttribute('data-category') === filter);
                card.style.display = match ? '' : 'none';
            });
        });
    });
}

/* ── 10. Contact Form Submission (for contact.php) ───────────────── */
function initContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    const getActiveError = (field) => {
        const language = document.body.classList.contains('lang-fil') ? 'fil' : 'en';
        return field.closest('.form-group')?.querySelector(`.form-error-msg[data-lang-${language}]`);
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let valid = true;

        form.querySelectorAll('.form-error-msg').forEach(el => el.classList.remove('visible'));
        form.querySelectorAll('input, select, textarea').forEach(el => el.style.borderColor = '');

        form.querySelectorAll('[required]').forEach(field => {
            if (!field.value.trim()) {
                valid = false;
                field.style.borderColor = '#e11d48';
                const err = getActiveError(field);
                if (err) err.classList.add('visible');
            }
        });

        const emailField = form.querySelector('input[type="email"]');
        if (emailField && emailField.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
            valid = false;
            emailField.style.borderColor = '#e11d48';
            const err = getActiveError(emailField);
            if (err) {
                err.textContent = document.body.classList.contains('lang-fil')
                    ? 'Maglagay ng wastong email address.'
                    : 'Please enter a valid email address.';
                err.classList.add('visible');
            }
        }

        if (!valid) return;

        const submitBtn = form.querySelector('[type="submit"]');
        const isFilipino = document.body.classList.contains('lang-fil');
        const submitLabel = isFilipino ? 'Ipadala ang Mensahe' : 'Send Message';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = isFilipino ? 'Ipinapadala ang Mensahe…' : 'Sending Message…';
        }

        setTimeout(() => {
            form.reset();
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = submitLabel;
            }
            const success = document.getElementById('formSuccess');
            if (success) {
                success.classList.add('visible');
                setTimeout(() => success.classList.remove('visible'), 5000);
            }
        }, 800);
    });
}

/* ── DOM Ready Initializer ───────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    initGlobalSearch();
    initLanguageSwitcher();
    initGuideCards();
    initMediaCards();
    initMediaCarousel();
    initHomeCardCarousels();
    initMobileNav();
    initSmoothAnchors();
    initBackToTop();
    initPolicySidebar();
    initAnnouncementFilter();
    initContactForm();
});
