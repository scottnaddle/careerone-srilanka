<!doctype html>
<html lang="en" xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>The Career Key | National Career Guidance and counselling center</title>

    <link rel="stylesheet" href="{{asset('career-test-libs/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('career-test-libs/style2.css')}}">
    <link rel="stylesheet" href="{{asset('css/select2/select2.css')}}">
    <style>
        @media print {
            .hide-on-print {
                display: none;
            }
            #myChart1 {
                width: 100%;
                height: auto;
            }
            #myChartPrintContainer img {
                width: 100%;
            }
        }
        .select2-selection__rendered {
            line-height: 35px !important;
            color: grey !important;
        }
        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        .select2-selection__arrow {
            height: 36px !important;
        }
    </style>
    <script>
        let lang = 'en'
        if (localStorage.getItem('ckt-lang2')) {
            lang = localStorage.getItem('ckt-lang2')
        }

        let page = 1
        // if (localStorage.getItem('ckt-page2')) {
        //     page = localStorage.getItem('ckt-page2')
        // }

        let progress = 0;
        // if (localStorage.getItem('ckt-progress2')) {
        //     progress = localStorage.getItem('ckt-progress2')
        // }

        let personName = '';
        if (localStorage.getItem('ckt-personName2')) {
            personName = localStorage.getItem('ckt-personName2')
        }
        let personNIC = '';
        if (localStorage.getItem('ckt-personNIC2')) {
            personNIC = localStorage.getItem('ckt-personNIC2')
        }
        if (localStorage.getItem('ckt-personInstitute2')) {
            personNIC = localStorage.getItem('ckt-personInstitute2')
        }

        let results = {
            realistic: 0,
            investigative: 0,
            artistic: 0,
            social: 0,
            enterprising: 0,
            conventional: 0
        }
        // if (localStorage.getItem('ckt-results2')) {
        //     results = JSON.parse(localStorage.getItem('ckt-results2'))
        // }

        let completedQuestions = {}
        // if (localStorage.getItem('ckt-completedQuestions2')) {
        //     completedQuestions = JSON.parse(localStorage.getItem('ckt-completedQuestions2'))
        // }

        let translations = {
            en: {
                pageOnePreHeader: 'National Career Guidance and Counselling Center',
                pageOneTitle: 'The Career Key',
                pageOnePara1: 'Measure your interests and learn which job fits you best. Choosing an occupation is a matching process.',
                pageOneBox1Title: 'You',
                pageOneBox1Description: 'Your needs values, abilities, skills, interests and aspirations.',
                pageOneBox2Title: 'Occupation',
                pageOneBox2Description: 'The job’s demands and potential for satisfying your needs',
                pageOnePara2: 'The Career Key unlocks the mystery of this matching process. It will show you how to identify the jobs most likely to satisfy you.',
                pageOnePara3: 'To start the test, please fill the name and the NIC number below and click on the start button.',
                pageOneButton: 'Start the Test',
                pageOneError: 'Please add your name!',
                pageOneError1: 'Please add your NIC!',
                pageOneError2: 'Invalid NIC format.',
                pageOneError3: 'Please select your Institute!',
                pageOneSuccess1: 'Your NIC is confirmed!',
                pageOneCopyRight: 'By Lawrence K.Jones, Ph.D, NCC. Arranged by Dr. Keerthi Premadasa & Mr. Ajith Jayawardhane from Career Guidance Unit of University of Colombo.',
                pageTwoTitle: 'How You See Yourself?',
                pageTwoDescription: 'Read each statement below and decides how much it describes you. Please select the answers from the drop down menu.',
                pageTwoExit: 'Exit Test',
                pageTwoNext: 'Next',
                pageTwoError: 'Please answer all the questions!',
                pageThreeTitle: 'Appealing Occupations',
                pageThreeDescription: 'Please select the answer from the drop down menu. For the jobs listed below, select “Mostly True” to those that definitely interest or attract you in some way. Select “Very True” for those that might be interested to you. Select “Doesn\'t Apply” for any job that you are undecided about, do not sound interesting, or that you would dislike.',
                pageThreeExit: 'Exit Test',
                pageThreeBack: 'Back',
                pageThreeNext: 'See Results',
                pageThreeError: 'Please answer all the questions!',
                pageFourTitle: 'Your Career Key',
                pageFourPersonNameLabel: 'Name',
                pageFourPersonNICLabel: 'NIC number',
                pageFourPersonInstituteLabel: 'Institute',
                pageFourDateLabel: 'Date',
                pageFourResultsTableTitle: 'Career Key Results',
                pageFourResultsTableDescription: 'According to John Holland there are 6 types of people. The maximum amount you get in your job key indicates the personality type you prefer.',
                pageFourChartTitle: 'Career Key Chart',
                pageFourError: 'Not ready for the interpretation',
                pageFourNotesTitle: 'Career Counselling Notes',
                pageFourDownload: 'Download Results',
                pageFourNew: 'Start new Test',
                option1: 'Choose...',
                option2: 'Very True',
                option3: 'Mostly True',
                option4: 'Doesn\'t Apply',
                question011: 'I like to work with tools, machines and animals.',
                question012: 'Compared to others my age, I have good skills in working with tools, mechanical drawings,machines or animals.',
                question013: 'I value practical things you can see or touch and use like plants you can grow and animals, or things you can build or make better.',
                question014: 'I am realistic and like practical and machinery things.',
                question015: 'I like to study and solve mathematics and scientific queries.',
                question016: 'I am good at understanding and solving science and math problems, compared to others my age.',
                question017: 'I value science.',
                question018: 'I am a precise, scientific, and intellectual.',
                question019: 'I like to do creative things like art, drama, crafts, dance, music or creative writing.',
                question0110: 'Compared to others my age, I have good artistic abilities in writing, drama, crafts, music, or art.',
                question0111: 'I value the creative arts like drama, music and art, or the works of creative writers.',
                question0112: 'I am artistic, imaginative, original, and independent.',
                question0113: 'I like to do things where I can help people: like teaching, first aid, or giving information.',
                question0114: 'Compared to persons my age, I am good at teaching, counselling, nursing, or giving information.',
                question0115: 'I value helping people and solving social problems.',
                question0116: 'I am helpful, friendly, and trustworthy.',
                question0117: 'I like to lead and persuade people, and to sell things or ideas.',
                question0118: 'Compared to persons my age, I am good at leading people and selling things or ideas.',
                question0119: 'I value success in politics, leadership or business.',
                question0120: 'I am energetic, ambitions and sociable.',
                question0121: 'I like to work with numbers, records, or machines in a set, orderly way.',
                question0122: 'Compared to persons my age, I am good at working with written records and numbers in a systematic, orderly way.',
                question0123: 'I value success in business.',
                question0124: 'I am orderly, and good at following set plan.',
                question0125: 'Bus Driver',
                question0126: 'Truck Mechanic',
                question0127: 'Carpenter',
                question0128: 'Physical Therapist',
                question0129: 'Counsellor',
                question0130: 'Social Worker',
                question0131: 'Fish & Farm Warden',
                question0132: 'Airplane Pilot',
                question0133: 'Mechanical Engineer',
                question0134: 'Librarian',
                question0135: 'Speech Therapist',
                question0136: 'Teacher',
                question0137: 'Farmer',
                question0138: 'Bank Examiner',
                question0139: 'Tax Expert',
                question0140: 'Nurse',
                question0141: 'Actor/Actress',
                question0142: 'Novelist',
                question0143: 'Insurance Clerk',
                question0144: 'Bookkeeper',
                question0145: 'Business Teacher',
                question0146: 'Clothes Designer',
                question0147: 'Artist',
                question0148: 'Singer',
                question0149: 'Court Stenographer',
                question0150: 'Sales Manager',
                question0151: 'Salesperson',
                question0152: 'Dancer',
                question0153: 'Chemist',
                question0154: 'Electrical Engineer',
                question0155: 'Bank Teller',
                question0156: 'Apartment Manager',
                question0157: 'Restaurant Manager',
                question0158: 'Musician',
                question0159: 'Astronomer',
                question0160: 'Chemical Technician',
                question0161: 'Biologist',
                question0162: 'Radio /TV Announcer',
                question0163: 'Insurance Sales Agent',
                question0164: 'Lawyer',
                question0165: 'Laboratory Technician',
                question0166: 'Research Scientist',
                exitTestModalLabel: 'Are you sure?',
                exitTestModalDescription: 'Please confirm that you want to exit from the test. All your records will be removed.',
                exitTestModalButton: 'Confirm',
                chartCols: ['Realistic', 'Investigative', 'Artistic', 'Social', 'Enterprising', 'Conventional']
            },
            sn: {
                pageOnePreHeader: 'ජාතික වෘත්තීය මාර්ගෝපදේශ හා උපදේශන මධ්‍යස්ථානය',
                pageOneTitle: 'වෘත්තීය යතුර',
                pageOnePara1: 'ඔබේ කැමැත්ත මැන ගනිමින් ඔබට ගැළපෙනම රැකියාව තෝරාගන්න. ඔබේ රැකියාව තෝරාගැනීම ගැළපීමේ ක්‍රියාවලියකි.',
                pageOneBox1Title: 'ඔබ',
                pageOneBox1Description: 'ඔබේ අවශ්‍යතා, අගයන්, දක්ෂතාවන්, හැකියාවන්, රුචිකත්වයන් සහ අභිලාෂයන්',
                pageOneBox2Title: 'රැකියාව',
                pageOneBox2Description: 'ඔබේ අවශ්‍යතාව තෘප්තිමත් කිරීම සඳහා රැකියාවේ ඉල්ලුම සහ විභව්‍යතාව',
                pageOnePara2: 'වෘත්තීය යතුර මගින් මෙම සැසඳීමේ ක්‍රියාවලියේ අභිරහස් දොරටුව විවර කළ හැක. එය ඔබ වඩාත් තෘප්තිමත් කරන රැකියාව හඳුනා ගන්නේ කෙසේද යන්න පෙන්වා දෙයි.',
                pageOnePara3: 'පරීක්ෂණය ආරම්භ කිරීමට, කරුණාකර පහත නම සහ ජාතික හැඳුනුම්පත් අංකය පුරවා ආරම්භක බොත්තම ක්ලික් කරන්න.',
                pageOneButton: 'පරීක්ෂණය ආරම්භ කරන්න',
                pageOneError: 'කරුණාකර ඔබේ නම සඳහන් කරන්න!',
                pageOneError1: 'කරුණාකර ඔබේ NIC සඳහන් කරන්න!',
                pageOneError2: 'වලංගු නොවන NIC ආකෘතිය.',
                pageOneError3: 'කරුණාකර ඔබේ ආයතනය තෝරන්න!',
                pageOneSuccess1: 'ඔබගේ ජාතික හැඳුනුම්පත තහවුරු කර ඇත!',
                pageOneCopyRight: 'Lawrence K’Jones, Ph.D, NCC ගේ The Career Key ඇසුරෙන් කොළඹ විශ්ව විද්‍යාලයේ වෘත්තීය මාර්ගෝපදේශ ඒකකයේ ආචාර්ය කීර්ති ප්‍රේමදාස හා අජිත් ජයවර්ධනගේ සැකසුමකි.',
                pageTwoTitle: 'ඔබ දෙස ඔබම බලන්නේ කෙසේද?',
                pageTwoDescription: 'පහත දැක්වෙන සෑම වගන්තියක්ම කියවා එය ඔබ‍ව කොපමණ විස්තර කරන්නේදැයි තීරණය කරන්න. ඔබ සම්බන්ධයෙන් එම වගන්තිය වඩාත්ම නිවැරදි නම් වගන්තිය ඉදිරිපිට ඇති කොටුවෙන් "වඩාත්ම නිවැරදි" තෝරන්න. ඔබ සම්බන්ධයෙන් එම වගන්තිය නිවැරදි නම් "නිවැරදි" තෝරන්න. වගන්තිය ඔබව විස්තර නොකරයි නම් "විස්තර නොකරයි" තෝරන්න. සෑම වගන්තියක් ඉදිරියෙන්ම ඔබගේ තේරීම යොදන්න.',
                pageTwoExit: 'පරීක්ෂණයෙන් ඉවත් වන්න',
                pageTwoNext: 'ඊළඟ',
                pageTwoError: 'කරුණාකර සියලුම ප්‍රශ්න වලට පිළිතුරු සපයන්න!',
                pageThreeTitle: 'අභියාචනා වෘත්තීන්',
                pageThreeDescription: 'පහත දක්වා ඇති රැකියා ලැයිස්තුවේ ඔබට කුමන ආකාරයකින් හෝ පැහැදිලිවම ප්‍රයෝජනවත් වන හෝ සිත් බැඳගන්නා රැකියාවන් ඉදිරියෙන් "වඩාත්ම නිවැරදි" තෝරන්න. ඔබට ප්‍රයෝජනවත් වේ යැයි සිතෙන ඒවා ඉදිරියේ "නිවැරදි" තෝරන්න. ඔබට තීරණයක් ගත නොහැකි අකමැති වේ යයි සිතෙන ඔබට ප්‍රයෝජනයක් නොමැති ඒවා ඉදිරියෙන් "විස්තර නොකරයි" තෝරන්න.',
                pageThreeExit: 'පරීක්ෂණයෙන් ඉවත් වන්න',
                pageThreeBack: 'ආපසු',
                pageThreeNext: 'ප්‍රතිඵල බලන්න',
                pageThreeError: 'කරුණාකර සියලුම ප්‍රශ්න වලට පිළිතුරු සපයන්න!',
                pageFourTitle: 'ඔබගේ වෘත්තීය යතුර',
                pageFourPersonNameLabel: 'නම',
                pageFourPersonNICLabel: 'NIC අංකය',
                pageFourPersonInstituteLabel: 'ආයතනය',
                pageFourDateLabel: 'දිනය',
                pageFourResultsTableTitle: 'මනෝමිතික පරීක්ෂණයේ ප්‍රතිඵලය',
                pageFourResultsTableDescription: 'ආචාර්ය ජෝන් හොලන්ඩ්ට අනුව, මිනිසුන් වර්ග 6කි. ඔබේ රැකියා යතුරෙහි ඔබ ලබාගත් වැඩිම ප්‍රමාණය දැක්වෙන්නේ ඔබ වඩාත්ම කැමති පෞරුෂ වර්ගයයි.',
                pageFourChartTitle: 'මනෝමිතික පරීක්ෂණයේ ප්‍රස්ථාරය',
                pageFourError: 'අර්ථකථනයට නුසුදුසුයි',
                pageFourNotesTitle: 'වෘත්තීය මාර්ගෝපදේශක සටහන්',
                pageFourDownload: 'ප්‍රතිඵලය බාගන්න',
                pageFourNew: 'නව පරීක්ෂණය ආරම්භ කරන්න',
                option1: 'තෝරන්න...',
                option2: 'වඩාත්ම නිවැරදි',
                option3: 'නිවැරදි',
                option4: 'විස්තර නොකරයි',
                question011: 'සතුන්, උපකරණ හෝ යන්ත්‍ර සූත්‍ර සමඟ වැඩ කිරීමට මා කැමතියි.',
                question012: 'මගේ වයසේ අනෙක් අය සමඟ සසදන විට මට උපකරණ, යන්ත්‍ර සූත්‍ර හෝ සතුන් සමඟ වැඩ කිරීමේ හා යාන්ත්‍රික ඇඳීම් ආදියේ ඉහළ හැකියාවක් ඇත.',
                question013: 'මම ප්‍රායෝගික දේ අගය කරමි. දැකිය හැකි ස්පර්ශ කළ හැකි ගස්වැල් හා සතුන් හදා වඩා ගන්නටත් වඩා හොඳින් ‍සාදන්නටත් කැමතිය.',
                question014: 'මා ප්‍රායෝගික, යාන්ත්‍රික දේට කැමති අතර යථාර්ථවාදිය.',
                question015: 'මා ගණිතය හෝ විද්‍යා ගැටලු ඉගෙන ගැනීමට හා විසදීමට කැමතියි.',
                question016: 'මගේ වයසේ අනෙක් අයට සාපේක්ෂව මට ගණිත හා විද්‍යා ගැටලු අවබෝධ කර ගැනීමේ හා ඒවා විසඳීමේ ඉහළ හැකියාවක් ඇත.',
                question017: 'මා විද්‍යාව අගය කරනවා.',
                question018: 'මා සූක්‍ෂ්ම, විද්‍යාත්මක හා බුද්ධිමත් අයෙකි.',
                question019: 'මා චිත්‍ර, නාට්‍ය, කලා ශිල්ප, නැටුම්, සංගීතය හෝ නිර්මාණාත්මක ‍ලේඛනය වැනි නිර්මාණශීලි දේ කිරීමට කැමතිය.',
                question0110: 'මාගේ වයසේ අනෙක් අයට සාපේක්‍ෂව නිර්මාණාත්මක ලේඛනය, නාට්‍ය, කලා ශිල්ප, සංගීතය, චිත්‍ර වැනි ක්‍ෂේත්‍රයන්හි ඉහළ කුසලතාවක් මට ඇත.',
                question0111: 'නිර්මාණශීලි ලේඛකයන් අතින් බිහි වූ නාට්‍ය සංගීත, චිත්‍ර වැනි නිර්මාණාත්මක කලා කටයුතු මම අගය කරමි.',
                question0112: 'මා ප්‍රතිභා සම්පන්න කලාත්මක, පරිකල්පනාත්මක හැකියාවක් ඇති ස්වාධීන අයෙකි.',
                question0113: 'ඉගැන්වීම, ප්‍රථමාධාර දීම, තොරතුරු සපයා දීම වැනි මිනිසුන්ට උදව් කළ හැකි දේ කිරීමට මා කැමතියි.',
                question0114: 'මගේ වයසේ අනෙක් අයට සාපේක්‍ෂව මා ඉගැන්වීම, උපදේශනය, උපස්ථානය හෝ තොරතුරු සැපයීම වැනි ක්‍ෂේත්‍රයන්හි විශේෂ දක්ෂතාවක් දක්වයි.',
                question0115: 'මම මිනිස්සුන්ට උදව් කිරිම හා සමාජ ප්‍රශ්න විසඳීම අගය කොට සලකමි.',
                question0116: 'මා අන්‍යයන්ට උපකාර වන, මිත්‍රශීලි හා විශ්වාසවන්ත අයෙකි.',
                question0117: 'මා මිනිසුන්ට නායකත්වය දීමට සහ ඔවුන්ව මෙහෙයවීමටත් අදහස් ‍හා දේවල් විකිණීමටත් ඉහළ හැකියාවෙන්‍ යුතු අයෙකි.',
                question0118: 'මගේ වයසේ අනිත් අය සමඟ සසඳන විට මා මිනිසුන් පාලනය කිරිමේ සහ දේවල් විකිණීමේ හැකියාවන්ගෙන් ඉහළ තත්ත්වයක සිටී.',
                question0119: 'මම දේශපාලනය, නායකත්වය හා ව්‍යාපාර අගය කරමි.',
                question0120: 'මා උද්‍යෝගිමත් අධිෂ්ඨානශීලි හා සමාජශීලි අයෙකි.',
                question0121: 'මම ක්‍රමානුකූලව සංඛ්‍යා, වාර්තා හෝ යන්ත්‍ර සූත්‍ර සමග වැඩ කිරීමට කැමැත්තෙමි.',
                question0122: 'මගේ වයසේ අනිත් අය සමග සසදන විට මා පිළිවෙලට හා ක්‍රමානුකූලව, සංඛ්‍යා, ලිඛිත වාර්තා සමග වැඩ කිරිමේ සුදුසු තත්ත්වයෙන් ඉහළයි.',
                question0123: 'ව්‍යාපාර මගින් සාර්ථක වීම මම අගය කරමි.',
                question0124: 'මා ක්‍රමානුකූල මෙන්ම සැලසුම් කළ දෙය හොඳින් අනුගමනය කිරිමේ හැකියාවෙන් යුක්තය.',
                question0125: 'බස් රියදුරු',
                question0126: 'ට්‍රක් රථ මෙහෙයවන්නා',
                question0127: 'වඩු',
                question0128: 'භෞත චිකිත්සක',
                question0129: 'අනුශාසක',
                question0130: 'සමාජසේවා',
                question0131: 'මත්ස්‍ය/ගොවිපල පාලක',
                question0132: 'අහස්යාත්‍රා පදවන්නා',
                question0133: 'යාන්ත්‍රික ඉංජිනේරු',
                question0134: 'පුස්තකාලයාධිපති',
                question0135: 'භාෂා චිකිත්සක',
                question0136: 'ගුරු වෘත්තීය',
                question0137: 'ගොවි මහතා',
                question0138: 'බැංකු පරීක්‍ෂක',
                question0139: 'බදු විශේෂඥ',
                question0140: 'සාත්තු හෙද',
                question0141: 'නළු/නිළි',
                question0142: 'නවකථා රචකයා',
                question0143: 'රක්ෂණ ලිපිකරු',
                question0144: 'පොත් තබන්නා',
                question0145: 'ව්‍යාපාර ගුරු',
                question0146: 'රෙදි නිර්මාණකරු',
                question0147: 'චිත්‍ර ශිල්පි',
                question0148: 'ගායක',
                question0149: 'උසාවි ලඝුලේඛිකා',
                question0150: 'වෙළඳ කළමනාකරු',
                question0151: 'වෙළඳ නියෝජිත',
                question0152: 'නැටුම් ශිල්පි',
                question0153: 'රසායනඥ',
                question0154: 'විදුලි ඉංජිනේරු',
                question0155: 'බැංකුවේ මුදල් ගණන් කරන්නා',
                question0156: 'නවාතැන් කළමනාකරු',
                question0157: 'නිවාඩු නිකේතන කළමනාකරු',
                question0158: 'සංගීතඥයා',
                question0159: 'තාරකා ශාස්ත්‍රඥයා',
                question0160: 'රසායන තාක්‍ෂණ ශිල්පී',
                question0161: 'ජීව විද්‍යාඥයා',
                question0162: 'ගුවන් විදුලි/රූපවාහිනී නිවේදක',
                question0163: 'රක්ෂණ වෙළඳ නියෝජිත',
                question0164: 'නීතිඥයා',
                question0165: 'විද්‍යාගාර තාක්‍ෂණ ශිල්පී',
                question0166: 'පර්යේෂණාත්මක විද්‍යාඥ',
                exitTestModalLabel: 'ඔබට විශ්වාසද?',
                exitTestModalDescription: 'ඔබට පරීක්ෂණයෙන් ඉවත් වීමට අවශ්‍ය බව කරුණාකර තහවුරු කරන්න. ඔබගේ සියලුම වාර්තා ඉවත් කරනු ලැබේ.',
                exitTestModalButton: 'තහවුරු කරන්න',
                chartCols: ['යථාර්ථ නිරූපිත', 'විමර්ශනාත්මක', 'කලාත්මක', 'සමාජීය', 'ධෛර්ය සම්පන්න', 'චාරිත්‍රානුකූල']
            },
            tm: {
                pageOnePreHeader: 'National Career Guidance and Counselling Center',
                pageOneTitle: 'The Career Key',
                pageOnePara1: 'உங்கள் ஆர்வங்களை அளந்து, எந்த வேலை உங்களுக்கு மிகவும் பொருத்தமானது என்பதை அறிந்துகொள்ளவும். ஒரு தொழிலைத் தேர்ந்தெடுத்தல் என்பது பொருத்தப்படுத்தல் செயல்முறையாகும். ',
                pageOneBox1Title: 'தாங்கள்',
                pageOneBox1Description: 'தங்களது தேவை, விழுமியங்கள், ஆற்றல்கள், திறன்கள், ஆர்வங்கள் மற்றும் அவாக்கள் ',
                pageOneBox2Title: 'தொழில் ',
                pageOneBox2Description: 'தங்களது தேவைகளைத் திருப்திப்படுத்துவதற்காக தொழிலுக்கான கேள்விகள் மற்றும் இயலுமைகள் ',
                pageOnePara2: 'இந்த பொருத்தப்பாட்டு செயல்முறையின் மர்மத்தை Career Key திறக்கிறது.உங்களை திருப்திப்படுத்தக்கூடிய வேலைகளை எவ்வாறு அடையாளம் காண்பது என்பதை இது காண்பிக்கும்.',
                pageOnePara3: 'சோதனையத் தொடங்க, கீழே உள்ள பெயரையும் NIC இலக்கத்தையும் பூர்த்தி செய்து, தொடக்க பொத்தானைக் கிளிக் செய்யவும். ',
                pageOneButton: 'சோதனையைத் தொடங்குங்கள்',
                pageOneError: 'உங்கள் பெயரைச் சேர்க்கவும்!',
                pageOneError1: 'உங்கள் NIC சேர்க்கவும்!',
                pageOneError2: 'தவறான NIC வடிவம்.',
                pageOneError3: 'உங்கள் நிறுவனத்தைத் தேர்ந்தெடுக்கவும்!',
                pageOneSuccess1: 'உங்கள் NIC உறுதி செய்யப்பட்டது!',
                pageOneCopyRight: 'By Lawrence K.Jones, Ph.D, NCC. Arranged by Dr. Keerthi Premadasa & Mr. Ajith Jayawardhane from Career Guidance Unit of University of Colombo. ',
                pageTwoTitle: 'உங்களை எப்படிப் பார்க்கிறீர்கள்',
                pageTwoDescription: 'கீழே உள்ள ஒவ்வொரு அறிக்கையையும் படித்து, அது உங்களை எவ்வளவு விவரிக்கிறது என்பதை தீர்மானிக்கிறது. கீழ்தோன்றும் மெனுவிலிருந்து பதில்களைத் தேர்ந்தெடுக்கவும்.',
                pageTwoExit: 'டெஸ்டிலிருந்து வெளியேறு',
                pageTwoNext: 'அடுத்தது',
                pageTwoError: 'எல்லா கேள்விகளுக்கும் பதிலளிக்கவும்!',
                pageThreeTitle: 'மேல்முறையீட்டு தொழில்கள்',
                pageThreeDescription: 'கீழ்தோன்றும் மெனுவிலிருந்து பதிலைத் தேர்ந்தெடுக்கவும். கீழே பட்டியலிடப்பட்டுள்ள வேலைகளுக்கு, நிச்சயமாக ஆர்வமுள்ள அல்லது ஏதேனும் ஒரு வழியில் உங்களை ஈர்க்கும் நபர்களுக்கு “பெரும்பாலும் உண்மை” என்பதைத் தேர்ந்தெடுக்கவும். உங்களுக்கு ஆர்வமுள்ளவர்களுக்கு “மிகவும் உண்மை” என்பதைத் தேர்ந்தெடுக்கவும். நீங்கள் தீர்மானிக்கப்படாத, சுவாரஸ்யமானதாகத் தெரியாத அல்லது நீங்கள் விரும்பாத எந்தவொரு வேலைக்கும் “பொருந்தாது” என்பதைத் தேர்ந்தெடுக்கவும்.',
                pageThreeExit: 'டெஸ்டிலிருந்து வெளியேறு',
                pageThreeBack: 'மீண்டும்',
                pageThreeNext: 'முடிவுகளைக் காண்க',
                pageThreeError: 'எல்லா கேள்விகளுக்கும் பதிலளிக்கவும்!',
                pageFourTitle: 'உங்கள் தொழில் விசை',
                pageFourPersonNameLabel: 'பெயர்',
                pageFourPersonNICLabel: 'NIC எண்',
                pageFourPersonInstituteLabel: 'நிறுவனம்',
                pageFourDateLabel: 'தேதி',
                pageFourResultsTableTitle: 'தொழில் முக்கிய முடிவுகள்',
                pageFourResultsTableDescription: 'டாக்டர் ஜோன் ஹோலான்ட் அவர்கள் மக்களினை ஆறு வகைப்படுத்துகிறார் அவையாவன. உங்களது தொழிலுக்கான திறவுகோலினில் நீங்கள் அதிக புள்ளிகளை பெற்ற துறை உங்களுக்கு விருப்பமான தனித்துவ தன்மை ஆகும்.',
                pageFourChartTitle: 'தொழில் முக்கிய விளக்கப்படம்',
                pageFourError: 'விளக்கத்திற்கு தயாராக இல்லை',
                pageFourNotesTitle: 'தொழில் ஆலோசனை குறிப்புகள்',
                pageFourDownload: 'முடிவுகளைப் பதிவிறக்குக',
                pageFourNew: 'புதிய சோதனையைத் தொடங்கவும்',
                option1: 'தேர்வு செய்யவும்...',
                option2: 'மிகவும் உண்மை',
                option3: 'பெரும்பாலும் உண்மை',
                option4: 'பொருந்தாது',
                question011: 'நான் கருவிகள் இயந்திரங்கள் மற்றும் விலங்குகளுடன் வேலை செய்வதினை விரும்புகிறேன்.',
                question012: 'கருவிகள் இயந்திரங்கள் மற்றும் விலங்குகளுடன் வேலை செய்யும் எனது திறன் மற்ற சமனான வயதுடைய குழுக்களுடன் ஒப்பிடும் போது எனக்கு அதிகமாகும்.',
                question013: 'நடைமுறை விடயங்களுக்கு பெறுமதியளித்தல் தாவர விலங்கு கருவிகள் உபகரணங்கள் மற்றும் இயந்திரங்களுடன் பார்த்து பயன்படுத்த என்னால் முடியும்.',
                question014: 'நான் யதார்த்தமான அத்துடன் இயந்திர மற்றும் நடைமுறை விடயங்களை விரும்புகிறேன்.',
                question015: 'நான் கணித மற்றும் அறிவியல் கேள்விகளை கற்கவும் தீர்வு காணவும் விருப்பம் உடையவர்.',
                question016: 'கணித மற்றும் அறிவியல் கேள்விகளை கற்கவும் தீர்வு காணக்கூடிய ஆற்றல் மற்ற சமனான வயதுடைய குழுக்களுடன் ஒப்பிடும் போது எனக்கு அதிகமாகும்.',
                question017: 'நான் அறிவியல் விஞ்ஞானத்தை மெச்சுகிறேன்.',
                question018: 'நான் ஒரு அறிவியல் அறிவுடைய நபராவேன்.',
                question019: 'நான் கலை நாடகம் அழகியல் நடனம் இசை மற்றும் ஆக்கபூர்வமான எழுத்து போன்ற விடயங்களை விரும்புகிறேன்.',
                question0110: 'கலை நாடகம் அழகியல் நடனம் இசை மற்றும் ஆக்கபூர்வமான எழுத்து போன்ற விடயங்கள் தொடா;பான எனது ஆற்றல் மற்ற சமனான வயதுடைய குழுக்களுடன் ஒப்பிடும் போது எனக்கு அதிகமாகும்.',
                question0111: 'நான் கலை நாடகம் அழகியல் நடனம் இசை மற்றும் ஆக்கபூர்வமான எழுத்து போன்ற விடயங்களை மெச்சுகிறேன்.',
                question0112: 'நான் ஒரு சுயாதீன வெளிப்படையான திறமையான கலைஞர்.',
                question0113: 'நான் கற்பித்தல் ஆலோசனை வழங்குதல் முதலுதவி அளித்தல் போன்ற மற்றவர்களுக்கு உதவக்கூடியவற்றை செய்ய விரும்புகிறேன்.',
                question0114: 'நான் கற்பித்தல் ஆலோசனை வழங்குதல் முதலுதவி அளித்தல் போன்ற மற்றவர்களுக்குதவக்கூடியவற்றை செய்வதில் உள்ள எனது விசேட திறன் மற்ற சமனான வயதுடைய குழுக்களுடன் ஒப்பிடும் போது எனக்கு அதிகமாகும்.',
                question0115: 'நான் மக்களுக்கு உதவி செய்வதையும் சமூக பிரச்சனைகளை தீர்த்தல் போன்ற விடயங்களை மெச்சுகிறேன்.',
                question0116: 'நான் நட்புடைய நம்பகமான மற்றவர்களை வழிநடத்தக் கூடிய நபராவேன்.',
                question0117: 'நான் சிறந்த தலைமைத்துவ பண்பு மற்றும் பொருட்கள் எண்ணங்களை விற்பனை செய்யக் கூடிய ஆற்றல் உள்ளவர்.',
                question0118: 'சிறந்த தலைமைத்துவ பண்பு மற்றும் பொருட்கள் எண்ணங்களை விற்பனை செய்யக் கூடிய ஆற்றல் மற்ற சமனான வயதுடைய குழுக்களுடன் ஒப்பிடும் போது எனக்கு அதிகமாகும்.',
                question0119: 'நான் அரசியல் தலைமைத்துவ பண்பு அல்லது வணிக வெற்றிகளை மெச்சுகிறேன்.',
                question0120: 'நான் ஒரு துடிப்பான இலட்சிய மற்றும் சிநேகபூர்வமானவன்.',
                question0121: 'நான் முறையாக இலக்கங்கள் அறிக்கைகள் மற்றும் இயந்திரங்களுடன் வேலை செய்வதனை விரும்புகிறேன்.',
                question0122: 'நான் முறையாக இலக்கங்கள் அறிக்கைகள் மற்றும் இயந்திரங்களுடன் வேலை செய்யும் ஆற்றல் மற்ற சமனான வயதுடைய குழுக்களுடன் ஒப்பிடும் போது எனக்கு அதிகமாகும்.',
                question0123: 'நான் வணிக வெற்றிகளை மெச்சுகிறேன்.',
                question0124: 'நான் முறையான திட்டங்களை வகுக்கக் கூடிய நபராவேன்.',
                question0125: 'பஸ் சாரதி',
                question0126: 'ரக் வண்டி செயற்பாட்டாளர்',
                question0127: 'தச்சன்',
                question0128: 'பௌதீக சிகிச்சையாளர்',
                question0129: 'உள ஆற்றுப்படுத்துனர்',
                question0130: 'சமூக சேவையாளர்',
                question0131: 'மீன் /பண்ணை நிர்வாகி',
                question0132: 'விமானி',
                question0133: 'இயந்திர பொறியிலாளர்',
                question0134: 'நூலக பொறுப்பாளர்',
                question0135: 'மொழிச்சிகிச்சையாளர்',
                question0136: 'ஆசிரியர்',
                question0137: 'விவசாயி',
                question0138: 'வங்கிப் பரிசோதகர்',
                question0139: 'வரி நிபுணர்',
                question0140: 'தாதி உத்தியோகத்தர்',
                question0141: 'நடிகர்/நடிகை',
                question0142: 'நாவல் ஆசிரியர்',
                question0143: 'காப்புறுதி எழுதுவினைஞர்',
                question0144: 'கணக்குப்பதிவாளர்',
                question0145: 'வர்த்தக ஆசிரியர்',
                question0146: 'ஆடை தயாரிப்பாளர்',
                question0147: 'சித்திரக் கலைஞர்',
                question0148: 'பாடகர்',
                question0149: 'நீதி மன்ற சுருக்கெழுத்தாளர்',
                question0150: 'வர்த்தக முகாமையாளர்',
                question0151: 'வர்த்தக பிரதிநிதி',
                question0152: 'நடனக் கலைஞர்',
                question0153: 'இரசாயனகூட ஆய்வாளர்',
                question0154: 'மின் பொறியியலாளர்',
                question0155: 'வங்கி நிதிக் கணிப்பீட்டாளர்',
                question0156: 'தங்குமிட முகாமையாளர்',
                question0157: 'விடுதி முகாமையாளர்',
                question0158: 'இசையமைப்பாளர்',
                question0159: 'விண்வெளி ஆய்வாளர்',
                question0160: 'இரசாயன தொழில்நுடபவியலாளர்',
                question0161: 'உயிரியல் விஞ்ஞானம்',
                question0162: 'வானொலி/தொலைக்காட்சி அறிவிப்பாளர்',
                question0163: 'காப்புறுதி பிரதிநிதி',
                question0164: 'சட்டத்தரணி',
                question0165: 'விஞ்ஞான ஆய்வுகூட தொழில்நுட்பவியலாளர்',
                question0166: 'ஆராய்ச்சி விஞ்ஞானி',
                exitTestModalLabel: 'நீ சொல்வது உறுதியா?',
                exitTestModalDescription: 'நீங்கள் சோதனையிலிருந்து வெளியேற விரும்புகிறீர்கள் என்பதை உறுதிப்படுத்தவும். உங்கள் எல்லா பதிவுகளும் அகற்றப்படும்.',
                exitTestModalButton: 'உறுதிப்படுத்தவும்',
                chartCols: ['யதார்த்தமானது', 'விசாரணை', 'கலை', 'சமூக', 'தொழில்முனைவு', 'வழக்கமான']
            }
        }
        /*function checkNIC(e) {
            $("#pageOneError1").removeClass('d-block');
            $("#pageOneError2").removeClass('d-block');
            $("#pageOneSuccess1").addClass('d-none');
            const nic = $("input[id='personNIC']").val();
            if (!nic) {
                $("#pageOneError1").addClass('d-block');
                e.preventDefault();
                return;
            }
            $("#checNICButton").text('Please wait...');
            $.ajax({
                url: "{{ route('testnow.checkNIC') }}",
                type: 'GET',
                data: {
                    nic: nic
                },
                success: function(data) {
                    if(data.data != 'No Information.') {
                        $("input[id='personName']").val(data.data[0]['STD_FULL_NAME']);
                        $("#checNICButtonDiv").addClass('d-none');
                        $("#pageOneButtonDiv").removeClass('d-none');
                        $("#personName").attr('disabled', true);
                        $("#personNIC").attr('disabled', true);
                        $("#pageOneSuccess1").removeClass('d-none');
                    }else {
                        $("#pageOneError2").addClass('d-block');
                        $("#checNICButton").text('Check your NIC');
                    }
                }
            });
        }*/
        function checkNIC(e) {
            $("#pageOneError1").removeClass('d-block');
            $("#pageOneError2").removeClass('d-block');
            $("#pageOneSuccess1").addClass('d-none');

            const nic = $("input[id='personNIC']").val().trim();

            // Regular expression for Sri Lankan NIC validation
            const nicPattern = /^([0-9]{9}[vVxX]|[0-9]{12})$/;

            // Validate NIC
            if (!nic) {
                $("#pageOneError1").addClass('d-block');
                e.preventDefault();
                return false; // Indicate failure
            } else if (!nicPattern.test(nic)) {
                $("#pageOneError2").removeClass('d-none').addClass('d-block');
                e.preventDefault();
                return false; // Indicate failure
            }

            // Return true for success
            return true;
        }
        // Function to get the 'lang' parameter from the URL
        function getLanguageFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            const lang = urlParams.get('lang');

            // Allowed languages
            const allowedLanguages = ['en', 'sn', 'tm'];

            // Laravel's locale (passed from Blade)
            const appLocale = "{{ app()->getLocale() }}";

            return allowedLanguages.includes(lang)
                ? lang
                : (allowedLanguages.includes(appLocale) ? appLocale : 'en'); // Default to 'en'
        }


        function loadDefaults(lang, page, results, completedQuestions) {
            setTimeout(function() {
                $('.loader-wrapper').fadeOut('slow')
            }, 1000)
            //Force user to start new if exit
            localStorage.removeItem('ckt-personName2');
            localStorage.removeItem('ckt-personNIC2');
            localStorage.removeItem('ckt-personInstitute2');
            localStorage.removeItem('ckt-progress2');
            localStorage.removeItem('results');
            localStorage.removeItem('page');
            localStorage.removeItem('completedQuestions');
            localStorage.setItem('ckt-results2-pushed', 'false');

            var page = "1";

            var results = {
                realistic: 0,
                investigative: 0,
                artistic: 0,
                social: 0,
                enterprising: 0,
            }
            var completedQuestions = {};
            var lang = getLanguageFromURL();
            changeLanguage(lang)
            changePage(page)
            setResults(results)
            updateButtons(completedQuestions)
            setProgress(0);
            if (localStorage.getItem('ckt-personName2')) {
                $('#personName').val(localStorage.getItem('ckt-personName2'))
            }
            if (localStorage.getItem('ckt-personNIC2')) {
                $('#personNIC').val(localStorage.getItem('ckt-personNIC2'))
            }
            if (localStorage.getItem('ckt-personInstitute2')) {
                $('#personInstitute2').val(localStorage.getItem('ckt-personInstitute2'))
            }
            $(".select-2").select2({
                height: '38px'
            });
        }

        function changeLanguage(lang) {
            localStorage.setItem('ckt-lang2', lang)
            $('.top_menu a').removeClass('active')
            $('#langSelect-' + lang).addClass('active');

            for (let key in translations[lang]) {
                $('#' + key).text(translations[lang][key])
            }

            $('.form-select .option1').text(translations[lang]['option1'])
            $('.form-select .option2').text(translations[lang]['option2'])
            $('.form-select .option3').text(translations[lang]['option3'])
            $('.form-select .option4').text(translations[lang]['option4'])

            $('#pageFourPersonNameLabel').text(translations[localStorage.getItem('ckt-lang2')]['pageFourPersonNameLabel'])
            $('#pageFourPersonNICLabel').text(translations[localStorage.getItem('ckt-lang2')]['pageFourPersonNICLabel'])
            $('#pageFourPersonInstituteLabel').text(translations[localStorage.getItem('ckt-lang2')]['pageFourPersonInstituteLabel'])
            $('#pageFourDateLabel').text(translations[localStorage.getItem('ckt-lang2')]['pageFourDateLabel'])

            $('#pageTwoRealistic').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][0])
            $('#pageTwoInvestigative').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][1])
            $('#pageTwoArtistic').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][2])
            $('#pageTwoSocial').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][3])
            $('#pageTwoEnterprising').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][4])
            $('#pageTwoConventional').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][5])

            $('#resultsTableRealistic').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][0])
            $('#resultsTableInvestigative').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][1])
            $('#resultsTableArtistic').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][2])
            $('#resultsTableSocial').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][3])
            $('#resultsTableEnterprising').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][4])
            $('#resultsTableConventional').text(translations[localStorage.getItem('ckt-lang2')]['chartCols'][5])

            if(localStorage.getItem('ckt-page2') == '4') {
                updateChart(JSON.parse(localStorage.getItem('ckt-results2')));
            }
        }

        function changePage(page) {
            if (page === 2) {
                if ($('#personName').val() === '' || $('#personNIC').val() === '' || $('#personInstitute').val() === '') {
                    $('#pageOneNameDiv').addClass('was-validated')
                    return
                } else {
                    if (!checkNIC(event)) {
                        // Prevent further execution if checkNIC fails
                        $('#pageOneNameDiv').addClass('was-validated')
                        return;
                    }
                    localStorage.setItem('ckt-personName2', $('#personName').val())
                    localStorage.setItem('ckt-personNIC2', $('#personNIC').val())
                    localStorage.setItem('ckt-personInstitute2', $('#personInstitute').val())
                    $('#pageOneNameDiv').removeClass('was-validated')
                }
            }

            if (page === 3) {
                if (Object.keys(completedQuestions).length < 24) {
                    $('#pageTwoError').removeClass('d-none')
                    return
                } else {
                    $('#pageTwoError').addClass('d-none')
                }
            }

            if (page === 4) {
                if (Object.keys(completedQuestions).length < 66) {
                    $('#pageThreeError').removeClass('d-none')
                    return
                } else {
                    $('#pageThreeError').addClass('d-none')
                }
            }

            localStorage.setItem('ckt-page2', page)
            $('#page1').fadeOut()
            $('#page2').fadeOut()
            $('#page3').fadeOut()
            $('#page4').fadeOut()
            $('#page' + page).fadeIn()

            if (page === 1) {
                localStorage.removeItem('ckt-progress2')
                localStorage.removeItem('ckt-results2')
                localStorage.removeItem('ckt-completedQuestions2')
                localStorage.removeItem('ckt-personName2')
                localStorage.removeItem('ckt-personInstitute2')
                location.reload()
            }

            if (page == 4) {
                if (localStorage.getItem('ckt-progress2') === '0') {
                    $('#pageFourError').removeClass('d-none')
                } else {
                    $('#pageFourError').addClass('d-none')
                }
                $('#pageFourPersonName').text(localStorage.getItem('ckt-personName2'))
                $('#pageFourPersonNIC').text(localStorage.getItem('ckt-personNIC2'))
                $('#pageFourPersonInstitute').text($(".select-2 option:selected").text())
                $('#pageFourDate').text(new Date().toISOString().slice(0, 10))

                //Push result to controller to save it
                if (localStorage.getItem("ckt-results2") !== null && localStorage.getItem("ckt-results2-pushed") !== 'true') {
                    localStorage.setItem('ckt-results2-pushed', 'true');
                    let csrf = $('meta[name="csrf_token"]').attr('content');
                    $.ajax({
                        url : "{{ (isset($saveUrl)) ? $saveUrl : route('testnow.save-results') }}",
                        data : {
                            '_token': csrf,
                            'name' : localStorage.getItem("ckt-personName2"),
                            'nic' : localStorage.getItem("ckt-personNIC2"),
                            'institute' : localStorage.getItem("ckt-personInstitute2"),
                            'results' : localStorage.getItem("ckt-results2"),
                            'type': '2'
                        },
                        type : 'POST',
                        dataType : 'json',
                        success : function(result){
                            localStorage.setItem('ckt-results2-pushed', 'true');
                        }
                    });
                }
            }
            $("html, body").animate({ scrollTop: 0 }, "fast");
        }

        function setProgress(progress) {
            localStorage.setItem('ckt-progress2', progress)
            $("#progress-bar").css('width', progress + '%')
            $('#progress-bar').text(progress + '%')
            $("#progress-bar-2").css('width', progress + '%')
            $('#progress-bar-2').text(progress + '%')
        }

        function setResults(results) {
            localStorage.setItem('ckt-results2', JSON.stringify(results))
            let progress = Math.round((Object.keys(completedQuestions).length / 66) * 100)
            setProgress(progress)
            updateChart(results)
        }

        function updateResults(type, question) {
            let value = $('#' + question).val()
            if (value !== '') {
                completedQuestions[question] = {type, value}
            } else {
                delete completedQuestions[question]
            }
            localStorage.setItem('ckt-completedQuestions2', JSON.stringify(completedQuestions))

            let realistic = 0, investigative = 0, artistic = 0, social = 0, enterprising = 0, conventional = 0
            for (let key in completedQuestions) {
                if (completedQuestions[key].type === 'realistic') { realistic += parseInt(completedQuestions[key].value) }
                if (completedQuestions[key].type === 'investigative') { investigative += parseInt(completedQuestions[key].value) }
                if (completedQuestions[key].type === 'artistic') { artistic += parseInt(completedQuestions[key].value) }
                if (completedQuestions[key].type === 'social') { social += parseInt(completedQuestions[key].value) }
                if (completedQuestions[key].type === 'enterprising') { enterprising += parseInt(completedQuestions[key].value) }
                if (completedQuestions[key].type === 'conventional') { conventional += parseInt(completedQuestions[key].value) }
            }

            setResults({realistic: realistic, investigative: investigative, artistic: artistic, social: social, enterprising: enterprising, conventional: conventional})
        }

        function updateButtons(completedQuestions) {
            for (let key in completedQuestions) {
                $('#' + key).val(completedQuestions[key].value)
            }
        }

        function updateChart(results) {
            $('#pageFourRealistic').text(results['realistic'])
            $('#pageFourInvestigative').text(results['investigative'])
            $('#pageFourArtistic').text(results['artistic'])
            $('#pageFourSocial').text(results['social'])
            $('#pageFourEnterprising').text(results['enterprising'])
            $('#pageFourConventional').text(results['conventional'])

            $('#myChart1').zingchart({
                data: {
                    type: 'mixed',
                    plot: {
                        barWidth: 20,
                    },
                    scaleX: {
                        labels: translations[localStorage.getItem('ckt-lang2')]['chartCols']
                    },
                    series: [
                        {
                            type: "bar",
                            values: [
                                results['realistic'],
                                results['investigative'],
                                results['artistic'],
                                results['social'],
                                results['enterprising'],
                                results['conventional']
                            ]
                        },
                        {
                            type: "line",
                            values: [
                                results['realistic'],
                                results['investigative'],
                                results['artistic'],
                                results['social'],
                                results['enterprising'],
                                results['conventional']
                            ]
                        }
                    ]
                },
                width: '100%',
            });
        }

        function printPreview() {
            prepareChartForPrint();
            setTimeout(function() {
                window.print();
                return true;
            }, 2000);
        }
        function prepareChartForPrint() {
            $("#myChartPrintContainer").empty();
            zingchart.exec('myChart1', 'getimagedata', {
                filetype: 'png',
                callback: function(imageData) {
                    var img = document.createElement('img');
                    img.src = imageData;
                    img.style.width = '80%';
                    img.style.height = 'auto';
                    $("#myChartPrintContainer").show();
                    $("#myChartPrintContainer").append(img);
                    $("#myChart1").hide();
                }
            });
        }

    </script>
    <script>
        window.onbeforeprint = function() {
            setTimeout(function() {
                prepareChartForPrint();
            }, 2000);
        };
        window.onafterprint = function() {
            setTimeout(function() {
                $("#myChart1").show();
                $("#myChartPrintContainer").hide();
            }, 2000);
        };
    </script>

    <!--[if gte mso 9]><xml>
        <mso:CustomDocumentProperties>
            <mso:_dlc_DocId msdt:dt="string">KQHMHFRZ53V4-1615267566-6664</mso:_dlc_DocId>
            <mso:_dlc_DocIdItemGuid msdt:dt="string">3ed4f128-92a3-4fde-a5bf-825e2ddcedd0</mso:_dlc_DocIdItemGuid>
            <mso:_dlc_DocIdUrl msdt:dt="string">https://iescglobal.sharepoint.com/Programs/SRI171/field/_layouts/15/DocIdRedir.aspx?ID=KQHMHFRZ53V4-1615267566-6664, KQHMHFRZ53V4-1615267566-6664</mso:_dlc_DocIdUrl>
        </mso:CustomDocumentProperties>
    </xml><![endif]-->
</head>
<body onload="loadDefaults(lang, page, results, completedQuestions)">
<div class="loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>
<section>
    <div class="container">
        <div class="row">
            @if(activeGuard() == 'trainee')
                <a href="{{route('trainee.career-guidance.career-test.list')}}" style="position: absolute; top:1rem; font-weight: 500; width: auto" class="back-to-test-list hide-on-print">Back to test list</a>
            @elseif(activeGuard() == 'cgo')
                <a href="{{route('cgo.career-guidance.career-test.list')}}" style="position: absolute; top:1rem; font-weight: 500; width: auto" class="back-to-test-list hide-on-print">Back to test list</a>
            @else
                <a href="{{route('testnow.list')}}" style="position: absolute; top:1rem; font-weight: 500; width: auto" class="back-to-test-list hide-on-print">Back to test list</a>
            @endif
            <div class="col-md-12 top_menu">
                <a id="langSelect-en" href="javascript:;" onclick='changeLanguage("en")' class="lang-select active">English</a> |
                <a id="langSelect-sn" href="javascript:;" onclick='changeLanguage("sn")' class="lang-select">සිංහල</a> |
                <a id="langSelect-tm" href="javascript:;" onclick='changeLanguage("tm")' class="lang-select">தமிழ்</a>
            </div>
        </div>

        <div id="page1" class="row">
            <div class="col-lg-8 text-center content-box">
                <p id="pageOnePreHeader" class="fw-bold">National Career Guidance and Counselling Center</p>
                <h1 id="pageOneTitle">The Career Key</h1>
                <p id="pageOnePara1">Measure your interests and learn which job fits you best. Choosing an occupation is a matching process.</p>
                <div class="row mt-5 mb-5">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" id="pageOneBox1Title">You</h5>
                                <p class="card-text" id="pageOneBox1Description">Your needs values, abilities, skills, interests and aspirations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 align-self-center">
                        <i class="fas fa-arrows-alt-h fa-3x"></i>
                    </div>
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title" id="pageOneBox2Title">Occupation</h5>
                                <p class="card-text" id="pageOneBox2Description">The job’s demands and potential for satisfying your needs.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p id="pageOnePara2">The Career Key unlocks the mystery of this matching process. It will show you how to identify the jobs most likely to satisfy you.</p>
                <p id="pageOnePara3">To start the test, please fill the name and NIC number below and click on the start button.</p>
                <div id="pageOneNameDiv" class="row shadow-none p-3 mt-1 mb-3 bg-light rounded" style="justify-content: center">
                    <div class="col-md-6 btn">
                        <input type="text" class="form-control" id="personName" placeholder="Your name" {{$userFullName != '' ? 'disabled' : ''}} value="{{$userFullName}}" required>
                        <div id="pageOneError" class="invalid-feedback text-start">
                            Please add your name!
                        </div>
                    </div>
                    <div class="col-md-6 btn">
                        <input type="text" class="form-control" id="personNIC" placeholder="Your NIC" {{$userNIC != '' ? 'disabled' : ''}} value="{{$userNIC}}"  pattern="^([0-9]{9}[vVxX]|[0-9]{12})$"  required>
{{--                        <div id="pageOneError1" class="invalid-feedback text-start">--}}
{{--                            Please add your NIC number!--}}
{{--                        </div>--}}
                        <div id="pageOneError2" class="invalid-feedback text-start">
                            Invalid NIC format.
                        </div>
                        <div id="pageOneSuccess1" class="text-success d-none text-start">
                            Your NIC is confirmed!
                        </div>
                    </div>
                    <div class="col-md-12">
                        <select class="select-2 form-control" id="personInstitute" name="personInstitute" required>
                            <option value="">Select your institute</option>
                            @forelse($institutes as $institute)
                                <option value="{{$institute->id}}">{{$institute->name}} ({{$institute->reg_no}})</option>
                            @empty
                            @endforelse
                        </select>
                        <div id="pageOneError3" class="invalid-feedback text-start">
                            Please select your Institute!
                        </div>
                    </div>
                    {{--@if(activeGuard() == '' && !Auth::guard(activeGuard())->check())
                        <div class="col-auto" id="checNICButtonDiv">
                            <div class="btn">
                                <a href="javascript:;" onclick='checkNIC(event)' class="primary" id="checNICButton">Check your NIC</a>
                            </div>
                        </div>
                        <div class="col-auto d-none" id="pageOneButtonDiv">
                            <div class="btn">
                                <a href="javascript:;" onclick='changePage(2)' class="primary" id="pageOneButton">Start the Test</a>
                            </div>
                        </div>
                    @else--}}
                        <div class="col-auto" id="pageOneButtonDiv">
                            <div class="btn">
                                <a href="javascript:;" onclick='changePage(2)' class="primary" id="pageOneButton">Start the Test</a>
                            </div>
                        </div>
                    {{--@endif--}}
                </div>
                <p class="mt-5 fst-italic">
                    <small id="pageOneCopyRight">
                        By Lawrence K.Jones, Ph.D, NCC.<br/>
                        Arranged by Dr. Keerthi Premadasa & Mr. Ajith Jayawardhane from Career Guidance Unit of University of Colombo.
                    </small>
                </p>
            </div>
        </div>

        <div id="page2" class="row">
            <div class="col-lg-10 text-center content-box">
                <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 1rem;"></div>
                <h1 id="pageTwoTitle">How You See Yourself</h1>
                <p id="pageTwoDescription">Read each statement below and decides how much it describes you. Please select the answers from the drop down menu:</p>

                <div class="card card-realistic">
                    <div class="card-header" id="pageTwoRealistic">
                        Realistic
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <label class="input-group-text" id="question011">I like to work with tools, machines and animals.</label>
                            <select class="form-select" id="question01" onchange="updateResults('realistic', 'question01')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question012">Compared to others my age, I have good skills in working with tools, mechanical drawings,machines or animals.</label>
                            <select class="form-select" id="question02" onchange="updateResults('realistic', 'question02')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question013">I value practical things you can see or touch and use like plants you can grow and animals, or things you can build or make better.</label>
                            <select class="form-select" id="question03" onchange="updateResults('realistic', 'question03')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question014">I am realistic and like practical and machinery things.</label>
                            <select class="form-select" id="question04" onchange="updateResults('realistic', 'question04')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card card-investigative mt-4">
                    <div class="card-header" id="pageTwoInvestigative">
                        Investigative
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <label class="input-group-text" id="question015">I like to study and solve mathematics and scientific queries.</label>
                            <select class="form-select" id="question05" onchange="updateResults('investigative', 'question05')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question016">I am good at understanding and solving science and math problems, compared to others my age.</label>
                            <select class="form-select" id="question06" onchange="updateResults('investigative', 'question06')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question017">I value science.</label>
                            <select class="form-select" id="question07" onchange="updateResults('investigative', 'question07')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question018">I am a precise, scientific, and intellectual.</label>
                            <select class="form-select" id="question08" onchange="updateResults('investigative', 'question08')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card card-artistic mt-4">
                    <div class="card-header" id="pageTwoArtistic">
                        Artistic
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <label class="input-group-text" id="question019">I like to do creative things like art, drama, crafts, dance, music or creative writing.</label>
                            <select class="form-select" id="question09" onchange="updateResults('artistic', 'question09')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0110">Compared to others my age, I have good artistic abilities in writing, drama, crafts, music, or art.</label>
                            <select class="form-select" id="question10" onchange="updateResults('artistic', 'question10')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0111">I value the creative arts like drama, music and art, or the works of creative writers.</label>
                            <select class="form-select" id="question11" onchange="updateResults('artistic', 'question11')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0112">I am artistic, imaginative, original, and independent.</label>
                            <select class="form-select" id="question12" onchange="updateResults('artistic', 'question12')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card card-social mt-4">
                    <div class="card-header" id="pageTwoSocial">
                        Social
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <label class="input-group-text" id="question0113">I like to do things where I can help people: like teaching, first aid, or giving information.</label>
                            <select class="form-select" id="question13" onchange="updateResults('social', 'question13')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0114">Compared to persons my age, I am good at teaching, counselling, nursing, or giving information.</label>
                            <select class="form-select" id="question14" onchange="updateResults('social', 'question14')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0115">I value helping people and solving social problems.</label>
                            <select class="form-select" id="question15" onchange="updateResults('social', 'question15')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0116">I am helpful, friendly, and trustworthy.</label>
                            <select class="form-select" id="question16" onchange="updateResults('social', 'question16')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card card-enterprising mt-4">
                    <div class="card-header" id="pageTwoEnterprising">
                        Enterprising
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <label class="input-group-text" id="question0117">I like to lead and persuade people, and to sell things or ideas.</label>
                            <select class="form-select" id="question17" onchange="updateResults('enterprising', 'question17')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0118">Compared to persons my age, I am good at leading people and selling things or ideas.</label>
                            <select class="form-select" id="question18" onchange="updateResults('enterprising', 'question18')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0119">I value success in politics, leadership or business.</label>
                            <select class="form-select" id="question19" onchange="updateResults('enterprising', 'question19')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0120">I am energetic, ambitions and sociable.</label>
                            <select class="form-select" id="question20" onchange="updateResults('enterprising', 'question20')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card card-conventional mt-4">
                    <div class="card-header" id="pageTwoConventional">
                        Conventional
                    </div>
                    <div class="card-body">
                        <div class="input-group">
                            <label class="input-group-text" id="question0121">I like to work with numbers, records, or machines in a set, orderly way.</label>
                            <select class="form-select" id="question21" onchange="updateResults('conventional', 'question21')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0122">Compared to persons my age, I am good at working with written records and numbers in a systematic, orderly way.</label>
                            <select class="form-select" id="question22" onchange="updateResults('conventional', 'question22')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0123">I value success in business.</label>
                            <select class="form-select" id="question23" onchange="updateResults('conventional', 'question23')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label class="input-group-text" id="question0124">I am orderly, and good at following set plan.</label>
                            <select class="form-select" id="question24" onchange="updateResults('conventional', 'question24')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="btn">
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exitTestModal" class="secondary" id="pageTwoExit">Exit Test</a>
                    <a href="javascript:;" onclick='changePage(3)' class="primary" id="pageTwoNext">Next</a>
                </div>

                <div id="pageTwoError" class="d-none alert alert-danger mt-3" role="alert">
                    Please answer all the questions!
                </div>
            </div>
        </div>

        <div id="page3" class="row">
            <div class="text-center content-box">
                <div class="progress-bar" id="progress-bar-2" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="height: 1rem;"></div>
                <h1 id="pageThreeTitle">Appealing Occupations</h1>
                <p id="pageThreeDescription">Please select the answer from the drop down menu. For the jobs listed below, select “Mostly True” to those that definitely interest or attract you in some way. Select “Very True” for those that might be interested to you. Select “Doesn't Apply” for any job that you are undecided about, do not sound interesting, or that you would dislike.</p>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__realistic--type">R</span>
                            <select class="form-select" id="question25" onchange="updateResults('realistic', 'question25')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0125">Bus Driver</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__realistic--type">R</span>
                            <select class="form-select" id="question26" onchange="updateResults('realistic', 'question26')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0126">Truck Mechanic</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__realistic--type">R</span>
                            <select class="form-select" id="question27" onchange="updateResults('realistic', 'question27')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0127">Carpenter</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__social--type">S</span>
                            <select class="form-select" id="question28" onchange="updateResults('social', 'question28')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0128">Physical Therapist</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__social--type">S</span>
                            <select class="form-select" id="question29" onchange="updateResults('social', 'question29')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0129">Counsellor</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__social--type">S</span>
                            <select class="form-select" id="question30" onchange="updateResults('social', 'question30')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0130">Social Worker</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__realistic--type">R</span>
                            <select class="form-select" id="question31" onchange="updateResults('realistic', 'question31')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0131">Fish & Farm Warden</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__realistic--type">R</span>
                            <select class="form-select" id="question32" onchange="updateResults('realistic', 'question32')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0132">Airplane Pilot</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__realistic--type">R</span>
                            <select class="form-select" id="question33" onchange="updateResults('realistic', 'question33')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0133">Mechanical Engineer</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__social--type">S</span>
                            <select class="form-select" id="question34" onchange="updateResults('social', 'question34')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0134">Librarian</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__social--type">S</span>
                            <select class="form-select" id="question35" onchange="updateResults('social', 'question35')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0135">Speech Therapist</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__social--type">S</span>
                            <select class="form-select" id="question36" onchange="updateResults('social', 'question36')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0136">Teacher</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__realistic--type">R</span>
                            <select class="form-select" id="question37" onchange="updateResults('realistic', 'question37')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0137">Farmer</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__conventional--type">C</span>
                            <select class="form-select" id="question38" onchange="updateResults('conventional', 'question38')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0138">Bank Examiner</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__conventional--type">C</span>
                            <select class="form-select" id="question39" onchange="updateResults('conventional', 'question39')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0139">Tax Expert</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__social--type">S</span>
                            <select class="form-select" id="question40" onchange="updateResults('social', 'question40')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0140">Nurse</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__artistic--type">A</span>
                            <select class="form-select" id="question41" onchange="updateResults('artistic', 'question41')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0141">Actor/Actress</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__artistic--type">A</span>
                            <select class="form-select" id="question42" onchange="updateResults('artistic', 'question42')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0142">Novelist</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__conventional--type">C</span>
                            <select class="form-select" id="question43" onchange="updateResults('conventional', 'question43')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0143">Insurance Clerk</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__conventional--type">C</span>
                            <select class="form-select" id="question44" onchange="updateResults('conventional', 'question44')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0144">Bookkeeper</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__conventional--type">C</span>
                            <select class="form-select" id="question45" onchange="updateResults('conventional', 'question45')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0145">Business Teacher</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__artistic--type">A</span>
                            <select class="form-select" id="question46" onchange="updateResults('artistic', 'question46')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0146">Clothes Designer</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__artistic--type">A</span>
                            <select class="form-select" id="question47" onchange="updateResults('artistic', 'question47')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0147">Artist</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__artistic--type">A</span>
                            <select class="form-select" id="question48" onchange="updateResults('artistic', 'question48')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0148">Singer</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__conventional--type">C</span>
                            <select class="form-select" id="question49" onchange="updateResults('conventional', 'question49')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0149">Court Stenographer</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__enterprising--type">E</span>
                            <select class="form-select" id="question50" onchange="updateResults('enterprising', 'question50')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0150">Sales Manager</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__enterprising--type">E</span>
                            <select class="form-select" id="question51" onchange="updateResults('enterprising', 'question51')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0151">Salesperson</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__artistic--type">A</span>
                            <select class="form-select" id="question52" onchange="updateResults('artistic', 'question52')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0152">Dancer</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__investigative--type">I</span>
                            <select class="form-select" id="question53" onchange="updateResults('investigative', 'question53')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0153">Chemist</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__investigative--type">I</span>
                            <select class="form-select" id="question54" onchange="updateResults('investigative', 'question54')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0154">Electrical Engineer</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__conventional--type">C</span>
                            <select class="form-select" id="question55" onchange="updateResults('conventional', 'question55')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0155">Bank Teller</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__enterprising--type">E</span>
                            <select class="form-select" id="question56" onchange="updateResults('enterprising', 'question56')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0156">Apartment Manager</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__enterprising--type">E</span>
                            <select class="form-select" id="question57" onchange="updateResults('enterprising', 'question57')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0157">Restaurant Manager</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__artistic--type">A</span>
                            <select class="form-select" id="question58" onchange="updateResults('artistic', 'question58')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0158">Musician</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__investigative--type">I</span>
                            <select class="form-select" id="question59" onchange="updateResults('investigative', 'question59')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0159">Astronomer</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__investigative--type">I</span>
                            <select class="form-select" id="question60" onchange="updateResults('investigative', 'question60')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0160">Chemical Technician</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__investigative--type">I</span>
                            <select class="form-select" id="question61" onchange="updateResults('investigative', 'question61')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0161">Biologist</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__enterprising--type">E</span>
                            <select class="form-select" id="question62" onchange="updateResults('enterprising', 'question62')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0162">Radio /TV Announcer</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__enterprising--type">E</span>
                            <select class="form-select" id="question63" onchange="updateResults('enterprising', 'question63')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0163">Insurance Sales Agent</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__enterprising--type">E</span>
                            <select class="form-select" id="question64" onchange="updateResults('enterprising', 'question64')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0164">Lawyer</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__investigative--type">I</span>
                            <select class="form-select" id="question65" onchange="updateResults('investigative', 'question65')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0165">Laboratory Technician</span>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <div class="input-group">
                            <span class="input-group-text input-group__investigative--type">I</span>
                            <select class="form-select" id="question66" onchange="updateResults('investigative', 'question66')">
                                <option value="" selected class="option1">Choose...</option>
                                <option value="2" class="option2">Very True</option>
                                <option value="1" class="option3">Mostly True</option>
                                <option value="0" class="option4">Doesn't Apply</option>
                            </select>
                            <span class="input-group-text bg-light input-group__question" id="question0166">Research Scientist</span>
                        </div>
                    </div>
                </div>

                <div class="btn">
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exitTestModal" class="secondary" id="pageThreeExit">Exit Test</a>
                    <a href="javascript:;" onclick='changePage(2)' class="primary" id="pageThreeBack">Back</a>
                    <a href="javascript:;" onclick='changePage(4)' class="primary" id="pageThreeNext">Next</a>
                </div>

                <div id="pageThreeError" class="d-none alert alert-danger mt-3" role="alert">
                    Please answer all the questions!
                </div>
            </div>
        </div>

        <div id="page4" class="row">
            <div class="col-lg-10 text-center content-box" style="max-width: 1024px;">
                <h1 id="pageFourTitle">Your Career Key</h1>
                <table class="table mt-5">
                    <tbody>
                    <tr>
                        <th scope="row" width="20%"><span id="pageFourPersonNameLabel">Name</span></th>
                        <td class="text-start"><span id="pageFourPersonName"></span></td>
                    </tr>
                    <tr>
                        <th scope="row" width="20%"><span id="pageFourPersonNICLabel">NIC</span></th>
                        <td class="text-start"><span id="pageFourPersonNIC"></span></td>
                    </tr>
                    <tr>
                        <th scope="row" width="20%"><span id="pageFourPersonInstituteLabel">Institute</span></th>
                        <td class="text-start"><span id="pageFourPersonInstitute"></span></td>
                    </tr>
                    <tr>
                        <th scope="row"><span id="pageFourDateLabel">Date</span></th>
                        <td class="text-start"><span id="pageFourDate"></span></td>
                    </tr>
                    </tbody>
                </table>
                <div id="pageFourError" class="d-none alert alert-danger" role="alert">
                    Not ready for the interpretation!
                </div>
                <h5 class="text-start ps-md-4 mt-5" id="pageFourResultsTableTitle">Career Key Results</h5>
                <p id="pageFourResultsTableDescription" class="text-start ps-md-4">According to John Holland there are 6 types of people.</p>
                <div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                        <tr>
                            <th width="18%" class="results-table-realistic" id="resultsTableRealistic">Realistic</th>
                            <th width="18%" class="results-table-investigative" id="resultsTableInvestigative">Investigative</th>
                            <th width="18%" class="results-table-artistic" id="resultsTableArtistic">Artistic</th>
                            <th width="18%" class="results-table-social" id="resultsTableSocial">Social</th>
                            <th width="18%" class="results-table-enterprising" id="resultsTableEnterprising">Enterprising</th>
                            <th class="results-table-conventional" id="resultsTableConventional">Conventional</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="results-table-realistic"><span id="pageFourRealistic"></span></td>
                            <td class="results-table-investigative"><span id="pageFourInvestigative"></span></td>
                            <td class="results-table-artistic"><span id="pageFourArtistic"></span></td>
                            <td class="results-table-social"><span id="pageFourSocial"></span></td>
                            <td class="results-table-enterprising"><span id="pageFourEnterprising"></span></td>
                            <td class="results-table-conventional"><span id="pageFourConventional"></span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <h5 class="text-start ps-md-4 mt-5" id="pageFourChartTitle">Career Key Chart</h5>
                <div class="row">
                    <div id="myChart1" class="col-lg-10 chart"></div>
                    <div id="myChartPrintContainer"></div>
                </div>
{{--                <h5 class="text-start ps-md-4 mt-4 hide-on-print" id="pageFourNotesTitle">Career Counselling Notes</h5>--}}
{{--                <div class="form-group p-md-3 hide-on-print">--}}
{{--                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>--}}
{{--                </div>--}}
                <div class="btn hide-on-print">
                    <a href="javascript:;" onclick='printPreview()' class="secondary hide-on-print" id="pageFourDownload">Download Results</a>
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exitTestModal" class="primary hide-on-print" id="pageFourNew">Start new Test</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Exit Test -->
<div class="modal fade" id="exitTestModal" tabindex="-1" aria-labelledby="exitTestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exitTestModalLabel">Are you sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="exitTestModalDescription">
                Please confirm that you want to exit from the test. All your records will be removed.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="changePage(1)" id="exitTestModalButton">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('career-test-libs/jquery-3.3.1.js')}}"></script>
<script src="{{asset('js/select2.js')}}"></script>
<script src="{{asset('career-test-libs/bootstrap.js')}}"></script>
<script src="{{asset('career-test-libs/zingchart.js')}}"></script>
<script>
    $(document).ready(function () {
        $(".back-to-test-list").click(function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            localStorage.removeItem('ckt-progress2')
            localStorage.removeItem('ckt-results2')
            localStorage.removeItem('ckt-completedQuestions2')
            localStorage.removeItem('ckt-personName2')
            localStorage.removeItem('ckt-personNIC2')
            localStorage.removeItem('ckt-personInstitute2')
            localStorage.setItem('ckt-page2', 1)
            localStorage.setItem('ckt-progres', 0)
            localStorage.setItem('ckt-results2-pushed', 'false');
            window.location.href = url;
        });
    })
</script>
<script>
    !function(a){a.fn.zingchart=function(b){var c=this[0].id,d={id:c,height:"100%",width:"100%"};return a.extend(d,b),zingchart.render(d),this},a.fn.loadModules=function(a){return zingchart.loadModules(a),this},a.fn.addNode=function(a){return zingchart.exec(this[0].id,"addnode",a),this},a.fn.addPlot=function(a){return zingchart.exec(this[0].id,"addplot",a),this},a.fn.appendSeriesData=function(a){return zingchart.exec(this[0].id,"appendseriesdata",a),this},a.fn.appendSeriesValues=function(a){return zingchart.exec(this[0].id,"appendseriesvalues",a),this},a.fn.getSeriesData=function(a){return a?zingchart.exec(this[0].id,"getseriesdata",a):zingchart.exec(this[0].id,"getseriesdata",{})},a.fn.getSeriesValues=function(a){return a?zingchart.exec(this[0].id,"getseriesvalues",a):zingchart.exec(this[0].id,"getseriesvalues",{})},a.fn.modifyPlot=function(a){return zingchart.exec(this[0].id,"modifyplot",a),this},a.fn.removeNode=function(a){return zingchart.exec(this[0].id,"removenode",a),this},a.fn.removePlot=function(a){return zingchart.exec(this[0].id,"removeplot",a),this},a.fn.set3dView=function(a){return zingchart.exec(this[0].id,"set3dview",a),this},a.fn.setNodeValue=function(a){return zingchart.exec(this[0].id,"setnodevalue",a),this},a.fn.setSeriesData=function(a){return zingchart.exec(this[0].id,"setseriesdata",a),this},a.fn.setSeriesValues=function(a){return zingchart.exec(this[0].id,"setseriesvalues",a),this},a.fn.exportData=function(){return zingchart.exec(this[0].id,"exportdata"),this},a.fn.getImageData=function(a){if("png"==a||"jpg"==a||"bmp"==a)return zingchart.exec(this[0].id,"getimagedata",{filetype:a}),this;throw"Error: Got "+a+", expected 'png' or 'jpg' or 'bmp'"},a.fn.print=function(){return zingchart.exec(this[0].id,"print"),this},a.fn.saveAsImage=function(){return zingchart.exec(this[0].id,"saveasimage"),this},a.fn.clearFeed=function(){return zingchart.exec(this[0].id,"clearfeed"),this},a.fn.getInterval=function(){return zingchart.exec(this[0].id,"getinterval")},a.fn.setInterval=function(a){if("number"==typeof a)return zingchart.exec(this[0].id,"setinterval",{interval:a}),this;if("object"==typeof a)return zingchart.exec(this[0].id,"setinterval",a),this;throw"Error: Got "+typeof a+", expected number"},a.fn.startFeed=function(){return zingchart.exec(this[0].id,"startfeed"),this},a.fn.stopFeed=function(){return zingchart.exec(this[0].id,"stopfeed"),this},a.fn.getChartType=function(a){return a?zingchart.exec(this[0].id,"getcharttype",a):zingchart.exec(this[0].id,"getcharttype")},a.fn.getData=function(){return zingchart.exec(this[0].id,"getdata")},a.fn.getEditMode=function(){return zingchart.exec(this[0].id,"geteditmode")},a.fn.getGraphLength=function(){return zingchart.exec(this[0].id,"getgraphlength")},a.fn.getNodeLength=function(a){return a?zingchart.exec(this[0].id,"getnodelength",a):zingchart.exec(this[0].id,"getnodelength")},a.fn.getNodeValue=function(a){return zingchart.exec(this[0].id,"getnodevalue",a)},a.fn.getObjectInfo=function(a){return zingchart.exec(this[0].id,"getobjectinfo",a)},a.fn.getPlotLength=function(a){return a?zingchart.exec(this[0].id,"getplotlength",a):zingchart.exec(this[0].id,"getplotlength")},a.fn.getPlotValues=function(a){return zingchart.exec(this[0].id,"getplotvalues",a)},a.fn.getRender=function(){return zingchart.exec(this[0].id,"getrender")},a.fn.getRules=function(a){return zingchart.exec(this[0].id,"getrules",a)},a.fn.getScales=function(a){return zingchart.exec(this[0].id,"getscales",a)},a.fn.getVersion=function(){return zingchart.exec(this[0].id,"getversion")},a.fn.getXYInfo=function(a){return zingchart.exec(this[0].id,"getxyinfo",a)},a.fn.addScaleValue=function(a){return zingchart.exec(this[0].id,"addscalevalue",{dataurl:a}),this},a.fn.destroy=function(a){return a?a.hasOwnProperty(""):zingchart.exec(this[0].id,"destroy"),this},a.fn.loadNewData=function(a){return zingchart.exec(this[0].id,"load",a),this},a.fn.modify=function(a){return zingchart.exec(this[0].id,"modify",a),this},a.fn.reloadChart=function(a){return a?zingchart.exec(this[0].id,"reload",a):zingchart.exec(this[0].id,"reload"),this},a.fn.removeScaleValue=function(a){return zingchart.exec(this[0].id,"removescalevalue",a),this},a.fn.resizeChart=function(a){return zingchart.exec(this[0].id,"resize",a),this},a.fn.setData=function(a){return zingchart.exec(this[0].id,"setdata",a),this},a.fn.update=function(a){return zingchart.exec(this[0].id,"update"),this},a.fn.goBack=function(){return zingchart.exec(this[0].id,"goback"),this},a.fn.goForward=function(){return zingchart.exec(this[0].id,"goforward"),this},a.fn.addNodeIA=function(a){return a?zingchart.exec(this[0].id,"addnodeia",a):zingchart.exec(this[0].id,"addnodeia"),this},a.fn.enterEditMode=function(a){return a?zingchart.exec(this[0].id,"entereditmode",a):zingchart.exec(this[0].id,"entereditmode"),this},a.fn.exitEditMode=function(a){return a?zingchart.exec(this[0].id,"exiteditmode",a):zingchart.exec(this[0].id,"exiteditmode"),this},a.fn.removeNodeIA=function(a){return a?zingchart.exec(this[0].id,"removenodeia",a):zingchart.exec(this[0].id,"removenodeia"),this},a.fn.removePlotIA=function(a){return a?zingchart.exec(this[0].id,"removeplotia",a):zingchart.exec(this[0].id,"removeplotia"),this},a.fn.addNote=function(a){return zingchart.exec(this[0].id,"addnote",a),this},a.fn.removeNote=function(a){return zingchart.exec(this[0].id,"removenote",{id:a}),this},a.fn.updateNote=function(a){return zingchart.exec(this[0].id,"updatenote",a),this},a.fn.addObject=function(a){return zingchart.exec(this[0].id,"addobject",a),this},a.fn.removeObject=function(a){return zingchart.exec(this[0].id,"removeobject",a),this},a.fn.repaintObjects=function(a){return a?zingchart.exec(this[0].id,"repaintobjects",a):zingchart.exec(this[0].id,"repaintobjects",{}),this},a.fn.updateObject=function(a){return zingchart.exec(this[0].id,"updateobject",a),this},a.fn.addLabel=function(a){return zingchart.exec(this[0].id,"addobject",{type:"label",data:a}),this},a.fn.removeLabel=function(a){return zingchart.exec(this[0].id,"removeobject",{type:"label",id:a}),this},a.fn.updateLabel=function(a){return zingchart.exec(this[0].id,"updateobject",{type:"label",data:a}),this},a.fn.addRule=function(a){return zingchart.exec(this[0].id,"addrule",a),this},a.fn.removeRule=function(a){return zingchart.exec(this[0].id,"removerule",a),this},a.fn.updateRule=function(a){return zingchart.exec(this[0].id,"updaterule",a),this},a.fn.clearSelection=function(a){return a?zingchart.exec(this[0].id,"clearselection",a):zingchart.exec(this[0].id,"clearselection"),this},a.fn.chartDeselect=function(a){return zingchart.exec(this[0].id,"deselect",a),this},a.fn.getSelection=function(a){return a?zingchart.exec(this[0].id,"getselection",a):zingchart.exec(this[0].id,"getselection"),this},a.fn.chartSelect=function(a){return zingchart.exec(this[0].id,"select",a),this},a.fn.setSelection=function(a){return zingchart.exec(this[0].id,"setselection",a),this},a.fn.disable=function(a){return a?zingchart.exec(this[0].id,"disable",{text:a}):zingchart.exec(this[0].id,"disable"),this},a.fn.enable=function(){return zingchart.exec(this[0].id,"enable"),this},a.fn.exitFullscreen=function(){return zingchart.exec(this[0].id,"exitfullscreen"),this},a.fn.fullscreen=function(){return zingchart.exec(this[0].id,"fullscreen"),this},a.fn.hideMenu=function(){return zingchart.exec(this[0].id,"hidemenu"),this},a.fn.hidePlot=function(a){return zingchart.exec(this[0].id,"hideplot",a),this},a.fn.hideAllPlots=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid"))for(var d=0;d<c;d++)zingchart.exec(b,"hideplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)zingchart.exec(b,"hideplot",{plotindex:d});return this},a.fn.hideAllPlotsBut=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"hideplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"hideplot",{plotindex:d});return this},a.fn.modifyAllPlotsBut=function(a,b){var c=this[0].id,d=a&&a.hasOwnProperty("graphid")?zingchart.exec(c,"getplotlength",a):zingchart.exec(c,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var e=0;e<d;e++)e!=a.plotindex&&zingchart.exec(c,"modifyplot",{graphid:a.graphid,plotindex:e,data:b});else for(var e=0;e<d;e++)e!=a.plotindex&&zingchart.exec(c,"modifyplot",{plotindex:e,data:b});return this},a.fn.modifyAllPlots=function(a,b){for(var c=this[0].id,d=b?zingchart.exec(c,"getplotlength",b):zingchart.exec(c,"getplotlength"),e=0;e<d;e++)b&&b.graphid?zingchart.exec(c,"modifyplot",{graphid:b.graphid,plotindex:e,data:a}):zingchart.exec(c,"modifyplot",{plotindex:e,data:a});return this},a.fn.showAllPlots=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid"))for(var d=0;d<c;d++)zingchart.exec(b,"showplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)zingchart.exec(b,"showplot",{plotindex:d});return this},a.fn.showAllPlotsBut=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"showplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"showplot",{plotindex:d});return this},a.fn.legendMaximize=function(a){return a?zingchart.exec(this[0].id,"legendmaximize",a):zingchart.exec(this[0].id,"legendmaximize"),this},a.fn.legendMinimize=function(a){return a?zingchart.exec(this[0].id,"legendminimize",a):zingchart.exec(this[0].id,"legendminimize"),this},a.fn.showMenu=function(){return zingchart.exec(this[0].id,"showmenu"),this},a.fn.showPlot=function(a){return zingchart.exec(this[0].id,"showplot",a),this},a.fn.toggleAbout=function(){return zingchart.exec(this[0].id,"toggleabout"),this},a.fn.toggleBugReport=function(){return zingchart.exec(this[0].id,"togglebugreport"),this},a.fn.toggleDimension=function(){return zingchart.exec(this[0].id,"toggledimension"),this},a.fn.toggleLegend=function(){return zingchart.exec(this[0].id,"togglelegend"),this},a.fn.toggleSource=function(){return zingchart.exec(this[0].id,"togglesource"),this},a.fn.viewAll=function(){return zingchart.exec(this[0].id,"viewall"),this},a.fn.zoomIn=function(a){return a?zingchart.exec(this[0].id,"zoomin",a):zingchart.exec(this[0].id,"zoomin"),this},a.fn.zoomOut=function(a){return a?zingchart.exec(this[0].id,"zoomout",a):zingchart.exec(this[0].id,"zoomout"),this},a.fn.zoomTo=function(a){return zingchart.exec(this[0].id,"zoomto",a),this},a.fn.zoomToValues=function(a){return zingchart.exec(this[0].id,"zoomtovalues",a),this},a.fn.animationEnd=function(b){var c=this;return zingchart.bind(this[0].id,"animation_end",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.animationStart=function(b){var c=this;return zingchart.bind(this[0].id,"animation_start",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.animationStep=function(b){var c=this;return zingchart.bind(this[0].id,"animation_step",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartModify=function(b){var c=this;return zingchart.bind(this[0].id,"modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeAdd=function(b){var c=this;return zingchart.bind(this[0].id,"node_add",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeRemove=function(b){var c=this;return zingchart.bind(this[0].id,"node_remove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotAdd=function(b){var c=this;return zingchart.bind(this[0].id,"plot_add",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotModify=function(b){var c=this;return zingchart.bind(this[0].id,"plot_modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotRemove=function(b){var c=this;return zingchart.bind(this[0].id,"plot_remove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartReload=function(b){var c=this;return zingchart.bind(this[0].id,"reload",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dataSet=function(b){var c=this;return zingchart.bind(this[0].id,"setdata",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dataExport=function(b){var c=this;return zingchart.bind(this[0].id,"data_export",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.imageSave=function(b){var c=this;return zingchart.bind(this[0].id,"image_save",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartPrint=function(b){var c=this;return zingchart.bind(this[0].id,"print",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedClear=function(b){var c=this;return zingchart.bind(this[0].id,"feed_clear",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedIntervalModify=function(b){var c=this;return zingchart.bind(this[0].id,"feed_interval_modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedStart=function(b){var c=this;return zingchart.bind(this[0].id,"feed_start",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedStop=function(b){var c=this;return zingchart.bind(this[0].id,"feed_stop",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphClick=function(b){var c=this;return zingchart.bind(this[0].id,"click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphComplete=function(b){var c=this;return zingchart.bind(this[0].id,"complete",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphDataParse=function(b){var c=this;return zingchart.bind(this[0].id,"dataparse",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphDataReady=function(b){var c=this;return zingchart.bind(this[0].id,"dataready",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphGuideMouseMove=function(b){var c=this;return zingchart.bind(this[0].id,"guide_mousemove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphLoad=function(b){var c=this;return zingchart.bind(this[0].id,"load",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphMenuItemClick=function(b){var c=this;return zingchart.bind(this[0].id,"menu_item_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphResize=function(b){var c=this;return zingchart.bind(this[0].id,"resize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.historyForward=function(b){var c=this;return zingchart.bind(this[0].id,"history_forward",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.historyBack=function(b){var c=this;return zingchart.bind(this[0].id,"history_back",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeSelect=function(b){var c=this;return zingchart.bind(this[0].id,"node_select",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeDeselect=function(b){var c=this;return zingchart.bind(this[0].id,"node_deselect",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotSelect=function(b){var c=this;return zingchart.bind(this[0].id,"plot_select",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotDeselect=function(b){var c=this;return zingchart.bind(this[0].id,"plot_deselect",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendItemClick=function(b){var c=this;return zingchart.bind(this[0].id,"legend_item_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMarkerClick=function(b){var c=this;return zingchart.bind(this[0].id,"legend_marker_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeClick=function(b){var c=this;return zingchart.bind(this[0].id,"node_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeDoubleClick=function(b){var c=this;return zingchart.bind(this[0].id,"node_doubleclick",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"node_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"node_mouseout",function(){d=!1}),this},a.fn.nodeMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"node_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeHover=function(b,c){var d=this,e=!1;return zingchart.bind(this[0].id,"node_mouseover",function(c){e||(a.extend(d,{event:c}),e=!0,b.call(d))}),zingchart.bind(d[0].id,"node_mouseout",function(){e=!1,c.call(d)}),this},a.fn.labelClick=function(b){var c=this;return zingchart.bind(this[0].id,"label_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.labelMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"label_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"label_mouseout",function(){d=!1}),this},a.fn.labelMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"label_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.labelHover=function(b,c){return a(this).labelMouseOver(b).labelMouseOut(c),this},a.fn.shapeClick=function(b){var c=this;return zingchart.bind(this[0].id,"shape_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.shapeMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"shape_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"shape_mouseout",function(){d=!1}),this},a.fn.shapeMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"shape_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.shapeHover=function(b,c){return a(this).shapeMouseOver(b).shapeMouseOut(c),this},a.fn.plotClick=function(b){var c=this;return zingchart.bind(this[0].id,"plot_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotDoubleClick=function(b){var c=this;return zingchart.bind(this[0].id,"plot_doubleclick",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"plot_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"plot_mouseout",function(){d=!1}),this},a.fn.plotMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"plot_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotHover=function(b,c){return a(this).plotMouseOver(b).plotMouseOut(c),this},a.fn.plotShow=function(b){var c=this;return zingchart.bind(this[0].id,"plot_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotHide=function(b){var c=this;return zingchart.bind(this[0].id,"plot_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.aboutShow=function(b){var c=this;return zingchart.bind(this[0].id,"about_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.aboutHide=function(b){var c=this;return zingchart.bind(this[0].id,"about_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.bugReportShow=function(b){var c=this;return zingchart.bind(this[0].id,"bugreport_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.bugReportHide=function(b){var c=this;return zingchart.bind(this[0].id,"bugreport_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dimensionChange=function(b){var c=this;return zingchart.bind(this[0].id,"dimension_change",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.sourceShow=function(b){var c=this;return zingchart.bind(this[0].id,"source_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.sourceHide=function(b){var c=this;return zingchart.bind(this[0].id,"source_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendShow=function(b){var c=this;return zingchart.bind(this[0].id,"legend_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendHide=function(b){var c=this;return zingchart.bind(this[0].id,"legend_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMaximize=function(b){var c=this;return zingchart.bind(this[0].id,"legend_maximize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMinimize=function(b){var c=this;return zingchart.bind(this[0].id,"legend_minimize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.zoomEvent=function(b){var c=this;return zingchart.bind(this[0].id,"zoom",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.setTitle=function(a){return"object"==typeof a?zingchart.exec(this[0].id,"modify",{data:{title:a}}):zingchart.exec(this[0].id,"modify",{data:{title:{text:a}}}),this},a.fn.setSubtitle=function(a){return"object"==typeof a?zingchart.exec(this[0].id,"modify",{data:{subtitle:a}}):zingchart.exec(this[0].id,"modify",{data:{subtitle:{text:a}}}),this},a.fn.setType=function(a){return zingchart.exec(this[0].id,"modify",{data:{type:a}}),zingchart.exec(this[0].id,"update"),this},a.fn.drawTrendline=function(b){function d(c){for(var d=a(this).getSeriesValues({plotindex:c}),e=0,f=0,g=0,h=0,i=0,j=a(this).getObjectInfo({object:"scale",name:"scale-x"}),k=j.values,l=0;l<d.length;l++)d[l]&&void 0!=d[l][1]&&"number"==typeof d[l][1]?(e+=d[l][0]*d[l][1],f+=d[l][0],g+=d[l][1],h+=d[l][0]*d[l][0],i++):(e+=d[l]*k[l],f+=k[l],g+=d[l],h+=Math.pow(k[l],2),i++);var m=(i*e-f*g)/(i*h-f*f),n=(g-m*f)/i,j=a(this).getObjectInfo({object:"scale",name:"scale-x"}),k=j.values,o=k[0],p=k[k.length-1],q=[n+m*o,n+m*p],r={type:"line",lineColor:"#c00",lineWidth:2,alpha:.75,lineStyle:"dashed",label:{text:""}};b&&a.extend(r,b),r.range=q;var s=a(this).getObjectInfo({object:"scale",name:"scale-y"}),t=s.markers;t?t.push(r):t=[r],a(this).modify({data:{"scale-y":{markers:t}}})}this[0].id;return d.call(this,0),this}}(jQuery);
</script>
<script src="{{asset('career-test-libs/career-key-kit-loader-lib.js')}}"></script>
</body>
</html>
