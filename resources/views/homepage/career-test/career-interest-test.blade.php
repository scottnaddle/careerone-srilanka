
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Career Interest Test</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('career-test-libs/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('career-test-libs/style1.css')}}">
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


    <script type="application/javascript">
        let lang = 'en'
        if (localStorage.getItem('lang')) {
            lang = localStorage.getItem('lang')
        }

        let page = 1
        // if (localStorage.getItem('page')) {
        //     page = localStorage.getItem('page')
        // }

        let progress = 0;
        // if (localStorage.getItem('progress')) {
        //     progress = localStorage.getItem('progress')
        // }

        let results = {
            outdoor: 0,
            practical: 0,
            science: 0,
            creative: 0,
            business: 0,
            office: 0,
            social: 0
        }
        // if (localStorage.getItem('results')) {
        //     results = JSON.parse(localStorage.getItem('results'))
        // }

        let completedQuestions = {}
        // if (localStorage.getItem('completedQuestions')) {
        //     completedQuestions = JSON.parse(localStorage.getItem('completedQuestions'))
        // }

        let translations = {
            en: {
                pageOneError: 'Please add your name!',
                pageOneError1: 'Please add your NIC!',
                pageOneError2: 'Invalid NIC format.',
                pageOneError3: 'Please select your Institute!',
                pageOneSuccess1: 'Your NIC is confirmed!',
                pageOneTitle: 'Career Interest Test',
                pageOnePara1: 'This test is used to help you understand your interests. It may show you some kinds of careers you might find satisfying. The next few pages list many jobs, courses and activities. From each pair pick the one you prefer.',
                pageOnePara2: 'Look at each pair. If you prefer the one on the right, put a tick on the right hand side. If you like the answer on the left, put your tick on the left hand side. If you are not really sure what you would like then you should just guess.',
                pageOnePara3: 'Work as quickly as you can. Most people find it easy to complete. At the end you will be given a copy of the results.',
                pageOnePara4: 'Read each question. Think which one you would like the most and select your answer. If you are not sure, then just guess what is best for you. You have to choose one, and you cannot leave any blank.',
                pageOnePara5: 'To start the test, please fill the name below and click on the start button.',
                pageOneButton: 'Start the Test',
                pageTwoTitle: 'Jobs',
                pageTwoDescription: 'Select one that best suites you:',
                pageTwoExit: 'Exit Test',
                pageTwoNext: 'Next',
                pageThreeTitle: 'Courses',
                pageThreeDescription: 'Select one that best suites you:',
                pageThreeExit: 'Exit Test',
                pageThreeBack: 'Back',
                pageThreeNext: 'Next',
                pageFourTitle: 'Activities',
                pageFourDescription: 'Select one that best suites you:',
                pageFourExit: 'Exit Test',
                pageFourPersonNameLabel: 'Name',
                pageFourPersonNICLabel: 'NIC number',
                pageFourPersonInstituteLabel: 'Institute',
                pageFourDateLabel: 'Date',
                pageFourBack: 'Back',
                pageFourNext: 'Show Results',
                pageTwoError: 'Please answer all the questions!',
                pageThreeError: 'Please answer all the questions!',
                pageFourEmptyResults: 'Please complete the questions to see Your Career Interest',
                pageFiveTitle: 'Your Career Interest',
                pageFiveDescription1: 'This profile shows a graph of your interests in seven work or career activities. The highest scores show the type of activities you like best. More than one high score indicates a combination of interests. The lowest scores should also be considered since they show activities that you probably do not enjoy right now.',
                pageFiveDescription2: 'Use your two or three highest scores to help you find jobs that match your interests. Look in the classification of occupations that comes with this Career Interest Test.',
                pageFiveDownload: 'Download Results',
                pageFiveNew: 'Start new Test',
                pageFiveReference: 'Result Reference',
                question1: 'GROW CROPS',
                question2: 'FIX MACHINES',
                question3: 'DIAGNOSE AN ILLNESS',
                question4: 'FLY A PLANE',
                question5: 'DESIGN BUILDINGS',
                question6: 'WORK IN A SCIENCE LAB',
                question7: 'HELP FAMILIES WITH PROBLEMS',
                question8: 'PAINT PORTRAITS',
                question9: 'PREPARE TAX RETURNS',
                question10: 'BE IN CHARGE OF WORKERS',
                question11: 'VISIT CUSTOMERS',
                question12: 'LOOK AFTER CHILDREN',
                question13: 'MEASURE BLOCKS OF LAND',
                question14: 'SELL MEDICINES',
                question15: 'MAKE DIAMOND RINGS',
                question16: 'FIX LIGHTS',
                question17: 'HELP SICK PEOPLE IN HOSPITAL',
                question18: 'MASSAGE SORE MUSCLES',
                question19: 'ORGANISE TRAVEL PLANS',
                question20: 'PLAY IN A BAND',
                question21: 'TEACH IN A SCHOOL',
                question22: 'DESIGN BRIDGES',
                question23: 'TRAIN FOR SPORT',
                question24: 'ACT IN A PLAY',
                question25: 'OWN A SHOP',
                question26: 'FIX COMPUTERS',
                question27: 'DEFEND SOMEONE IN COURT',
                question28: 'TREAT SICK ANIMALS',
                question29: 'MANAGE A LIBRARY',
                question30: 'WRITE FOR A NEWSPAPER',
                question31: 'LOOK AFTER FORESTS',
                question32: 'HELP PEOPLE WITH INJURIES',
                question33: 'APPROVE A HOME LOAN',
                question34: 'BUILD A HOUSE',
                question35: 'DEVELOP COMPUTER SOFTWARE',
                question36: 'FIX TEETH',
                question37: 'PREPARE A LAWN',
                question38: 'OWN A SHOP',
                question39: 'ANALYSE FINANCES',
                question40: 'GIVE ADVICE ABOUT JOBS',
                question41: 'DRIVE A TRUCK',
                question42: 'WORK IN AN OFFICE',
                question43: 'GEOGRAPHY',
                question44: 'TECHNICAL DRAWING',
                question45: 'CHEMISTRY',
                question46: 'METALWORK',
                question47: 'MUSIC',
                question48: 'BIOLOGY',
                question49: 'HOME SCIENCE',
                question50: 'POETRY',
                question51: 'MATHEMATICS',
                question52: 'COMMERCE',
                question53: 'BUSINESS',
                question54: 'HEALTH CARE',
                question55: 'AGRICULTURE',
                question56: 'PHYSICS',
                question57: 'TEXTILES',
                question58: 'WOODWORK',
                question59: 'HISTORY',
                question60: 'GEOLOGY',
                question61: 'ECONOMICS',
                question62: 'DRAMA',
                question63: 'RELIGIOUS STUDIES',
                question64: 'ENGINEERING',
                question65: 'ZOOLOGY',
                question66: 'PHOTOGRAPHY',
                question67: 'RETAILING',
                question68: 'PLUMBING',
                question69: 'POLITICS',
                question70: 'BOTANY',
                question71: 'SECRETARIAL STUDIES',
                question72: 'ART',
                question73: 'ENVIRONMENT',
                question74: 'SOCIAL PROBLEMS',
                question75: 'ACCOUNTANCY',
                question76: 'ELECTRONICS',
                question77: 'COMPUTING',
                question78: 'MEDICINE',
                question79: 'PHYSICAL EDUCATION',
                question80: 'ADVERTISING',
                question81: 'LIBRARIANSHIP',
                question82: 'EDUCATION/TEACHING',
                question83: 'BUILDING',
                question84: 'MANAGEMENT',
                question85: 'LOOK AFTER ANIMALS',
                question86: 'OPERATE POWER TOOLS',
                question87: 'DO AN EXPERIMENT',
                question88: 'FIX CARS',
                question89: 'CREATE A SCULPTURE',
                question90: 'DISSECT SPECIMENS',
                question91: 'HELP PEOPLE WITH PROBLEMS',
                question92: 'SKETCH A SCENE',
                question93: 'WORK PART TIME IN AN OFFICE',
                question94: 'SELL CLOTHES IN A SHOP',
                question95: 'SUPERVISE OTHERS',
                question96: 'HELP SICK PEOPLE',
                question97: 'SAIL A BOAT',
                question98: 'STUDY ASTRONOMY',
                question99: 'ACT IN A PLAY',
                question100: 'PRINT A MAGAZINE',
                question101: 'INTERVIEW PEOPLE',
                question102: 'WATCH A SCIENCE SHOW',
                question103: 'DIRECT A PLAY',
                question104: 'COMPOSE A SONG',
                question105: 'ANSWER PEOPLE\'S ENQUIRIES',
                question106: 'DISMANTLE SOMETHING',
                question107: 'GO FISHING',
                question108: 'TAKE PHOTOGRAPHS',
                question109: 'PREPARE ADVERTISING',
                question110: 'RESTORE FURNITURE',
                question111: 'ADVISE CUSTOMERS',
                question112: 'COLLECT ROCK SAMPLES',
                question113: 'PREPARE A RESEARCH REPORT',
                question114: 'WRITE A STORY',
                question115: 'GO HIKING/BUSHWALKING',
                question116: 'PLAY SPORT',
                question117: 'BE TREASURER FOR A GROUP',
                question118: 'ASSEMBLE HOBBY KITS',
                question119: 'HELP IN A LIBRARY',
                question120: 'COLLECT WEATHER DETAILS',
                question121: 'DRIVE A TRACTOR',
                question122: 'MANAGE A SHOP',
                question123: 'PROGRAM A COMPUTER',
                question124: 'TRAIN NEW STAFF',
                question125: 'DO SOME GARDENING',
                question126: 'TYPE SOME LETTERS',
                exitTestModalLabel: 'Are you sure?',
                exitTestModalDescription: 'Please confirm that you want to exit from the test. All your records will be removed.',
                exitTestModalButton: 'Confirm',
                chartCols: ['Outdoor', 'Practical', 'Science', 'Creative', 'Business', 'Office', 'Social']
            },
            sn: {
                pageOneError: 'කරුණාකර ඔබේ නම සඳහන් කරන්න!',
                pageOneError1: 'කරුණාකර ඔබේ NIC සඳහන් කරන්න!',
                pageOneError2: 'වලංගු නොවන NIC ආකෘතිය.',
                pageOneError3: 'කරුණාකර ඔබේ ආයතනය තෝරන්න!',
                pageOneSuccess1: 'ඔබගේ ජාතික හැඳුනුම්පත තහවුරු කර ඇත!',
                pageOneTitle: 'වෘත්තීය ලැදියා පරීක්ෂණය',
                pageOnePara1: 'මෙම පරීක්ෂණය ඔබගේ රුචි අරුචිකම් හදුනා ගැනීමට අත්වැළකි. එය ඔබේ රුචියට අනුකුල යම් වෘත්තීන් වෙත ඔබ ගේ අවධානය යොමු කරනු ඇත. ඉදිරි පි‍ටුවල ‍රැකියාවන්, පාඨමාලා හා ක්‍රියාවලි රාශියක් අඩංගු වී ඇත. එක්, එක් යුගලයන්ගෙන් ඔබ කැමති යුගලය ‍තෝරන්න.',
                pageOnePara2: 'සෑම යුගලයක් දෙසම බලන්න. ඔබ දකුණු පස යුගලයට කැමති නම් එය සලකුණු කරන්න. වම් පස යුගලයට කැමති නම් එය සලකුණු කරන්න. ඔබේ කැමැත්ත ඉතා පැහැදිළි නැත්තම් අනුමානයෙන් සිතන්න.',
                pageOnePara3: 'හැකි ඉක්මණින් පිළිතුර සපයන්න. බොහෝ අයට පිළිතුරු සම්පූර්ණයෙන් සැපයීම අපහසු කාර්යයකි. අවසානයේදි ප්‍රතිඵල ලේඛනයක් ඔබට ලැබෙනු ඇත.',
                pageOnePara4: 'හැම ප්‍රශ්නයක්ම කියවන්න. ඔබ වඩාත්ම ප්‍රිය කරන්නේ කුමක්දැයි සිතන්න. ඔබේ පිළිතුර ( √ ) සටහන් කරන්න. තීරණය අපහැදිළි නම් වඩාත් හොද කුමක්දැයි අනුමාන කරන්න. සෑම ප්‍රශ්නයකටම පිළිතුරු සැපයීම අනිවාර්යය වෙයි.',
                pageOnePara5: 'ආරම්භ කිරීම සඳහා පහත කොටුවෙහි ඔබගේ නම සඳහන් කර ආරම්භක බොත්තම ක්ලික් කරන්න',
                pageOneButton: 'පරීක්ෂණය ආරම්භ කරන්න',
                pageTwoTitle: 'රැකියා',
                pageTwoDescription: 'ඔබට වඩාත් ගැලපෙන එකක් තෝරන්න:',
                pageTwoExit: 'පරීක්ෂණයෙන් ඉවත් වන්න',
                pageTwoNext: 'ඊළඟ',
                pageThreeTitle: 'පාඨමාලා',
                pageThreeDescription: 'ඔබට වඩාත් ගැලපෙන එකක් තෝරන්න:',
                pageThreeExit: 'පරීක්ෂණයෙන් ඉවත් වන්න',
                pageThreeBack: 'ආපසු',
                pageThreeNext: 'ඊළඟ',
                pageFourTitle: 'ක්‍රියාකාරකම්',
                pageFourDescription: 'ඔබට වඩාත් ගැලපෙන එකක් තෝරන්න:',
                pageFourExit: 'පරීක්ෂණයෙන් ඉවත් වන්න',
                pageFourPersonNameLabel: 'නම',
                pageFourPersonNICLabel: 'NIC අංකය',
                pageFourPersonInstituteLabel: 'ආයතනය',
                pageFourDateLabel: 'දිනය',
                pageFourBack: 'ආපසු',
                pageFourNext: 'ප්‍රථිපල පෙන්වන්න',
                pageTwoError: 'කරුණාකර සියලුම ප්‍රශ්න වලට පිළිතුරු සපයන්න!',
                pageThreeError: 'කරුණාකර සියලුම ප්‍රශ්න වලට පිළිතුරු සපයන්න!',
                pageFourEmptyResults: 'ඔබේ වෘත්තීය උනන්දුව බැලීමට කරුණාකර ප්‍රශ්න සම්පූර්ණ කරන්න',
                pageFiveTitle: 'ඔබේ වෘත්තීය උනන්දුව',
                pageFiveDescription1: 'ඔබ වැඩිම ලකුණු ලබා ඇති කරුණු දෙක හෝ තුන ඔබේ රුචිකත්වය හා ගළපා ‍රැකියාවක් හෝ පුහුණුවක් සොයා ගැනීමේදි ප්‍රයෝජනයට ගන්න. රුචිකත්ව පැතිකඩ ඔබේ රුචිකත්ව මට්ටම් පෙන්නුම් කරන ප්‍රස්ථාරයකි.මෙහි වැඩිම ලකුණු සංඛ්‍යාවෙන් ඔබ වඩාත්ම කැමති ක්ෂේත්‍රය පෙන්වයි.එකකට වැඩි ගණනක් ඉහල ලකුණු ලබා ඇත්නම් එයින් එකිනෙකට සමාන රුචිකත්වයක් දක්වයි.',
                pageFiveDescription2: 'ඔබ බොහෝ විට සතුටක් නොලබන ක්ෂේත්‍ර සදහා ඉතා අඩු ලකුණු ලබා ඇති නිසා ඒවා ගැනද සැලකිල්ලක් දැක්වීම වැදගත්ය.',
                pageFiveDownload: 'ප්‍රථිපල බාගන්න',
                pageFiveNew: 'නව පරීක්ෂණය ආරම්භ කරන්න',
                pageFiveReference: 'ප්‍රතිඵල යොමුව',
                question1: 'කෘෂිකර්මය',
                question2: 'යන්ත්‍ර අලුත්වැඩියාව',
                question3: 'රෝග හදුනා ගැනීම',
                question4: 'අහස්යානයක් පැදවීම',
                question5: 'ගොඩනැගිලි සැලසුම් කිරීම',
                question6: 'විද්‍යාගාරයක වැඩකිරීම',
                question7: 'ප්‍රශ්න විසදීමට පවුල් වලට උදවු කිරීම',
                question8: 'චිත්‍ර ඇදීම',
                question9: 'බදු වාර්තා සැකසීම',
                question10: 'සේවකයින් අධීක්ෂණය',
                question11: 'ගණුදෙනු කරුවන් හමුවීම',
                question12: 'ළමයින් බලාගැනීම',
                question13: 'ඉඩම් මැනීම',
                question14: 'බෙහෙත් විකිණීම',
                question15: 'දියමන්ති මුදු සෑදීම',
                question16: 'විදුලි ලාම්පු සැකසීම',
                question17: 'රෝහලේ ගිලනුන්ට උදව් වීම',
                question18: 'ආබාධිත මස්පිඩු සම්බාහනය',
                question19: 'සංචාර සැලසුම් කිරීම',
                question20: 'සංගීත කණ්ඩායමක වාදනයකිරීම',
                question21: 'පාසලක ඉගැන්වීම',
                question22: 'පාලම් සැලසුම් කිරීම',
                question23: 'ක්‍රීඩා සදහා පුහුණු වීම',
                question24: 'නාට්‍යයක රගපෑම',
                question25: 'සාප්පු හිමියෙකු වීම',
                question26: 'පරිගණක අලුත් වැඩියාව',
                question27: 'නීතිඥයකු වීම',
                question28: 'පශු වෛද්‍යවරයෙකු වීම',
                question29: 'පුස්තකාලයක් පාලනය',
                question30: 'පුවත්පතක්ට ලිපි ලිවීම',
                question31: 'වන සංරක්ෂණය',
                question32: 'ශල්‍ය වෛද්‍යවරයෙකු වීම',
                question33: 'නිවාස ණයක් අනුමත කිරීම',
                question34: 'නිවාසයක් ඉදි කිරීම',
                question35: 'පරිගණක මෘදුකාංග නිෂ්පාදනය',
                question36: 'දන්ත කාර්මික',
                question37: 'උද්‍යාන සැකසුම',
                question38: 'සාප්පු හිමියෙකු වීම',
                question39: 'ගිණුම් විග්‍රහය මූල්‍ය විශ්ලේෂණය කිරීම',
                question40: 'රැකියා උපදේශනය',
                question41: 'ලොරි රියදුරු',
                question42: 'කාර්යාලයක වැඩ',
                question43: 'භූගෝල විද්‍යාව',
                question44: 'යාන්ත්‍රික ඇදීම',
                question45: 'රසායන විද්‍යාව',
                question46: 'ලෝහ වැඩ',
                question47: 'සංගීතය',
                question48: 'ජීව විද්‍යාව',
                question49: 'ගෘහ විද්‍යාව',
                question50: 'කවි ලිවීම',
                question51: 'ගණිතය',
                question52: 'වාණිජ්‍යය',
                question53: 'ව්‍යාපාර',
                question54: 'සෞඛ්‍ය සේවා',
                question55: 'කෘෂිකර්මය',
                question56: 'භෞතික විද්‍යාව',
                question57: 'රෙදිපිළි කර්මාන්තය',
                question58: 'වඩුවැඩ',
                question59: 'ඉතිහාසය',
                question60: 'භූ විද්‍යාව',
                question61: 'ආර්ථික විද්‍යාව',
                question62: 'නාට්‍ය ශිල්පය',
                question63: 'ආගම',
                question64: 'ඉංජිනේරු විද්‍යාව',
                question65: 'සත්ව විද්‍යාව',
                question66: 'ඡායාරූප ශිල්පය',
                question67: 'සිල්ලර වෙළදාම',
                question68: 'ජලනල කර්මාන්තය',
                question69: 'දේශපාලන විද්‍යාව',
                question70: 'උද්භිද විද්‍යාව',
                question71: 'ලේකම් කටයුතු හැදැරීම',
                question72: 'චිත්‍ර ශිල්පය',
                question73: 'පරිසර විද්‍යාව',
                question74: 'සමාජ විද්‍යාව',
                question75: 'ගණකාධිකරණය',
                question76: 'ඉලෙක්ට්‍රොනික ශිල්පය',
                question77: 'පරිගණක විද්‍යාව',
                question78: 'වෛද්‍ය වෘත්තිය',
                question79: 'ශාරිරික අධ්‍යාපනය',
                question80: 'ප්‍රචාරණය',
                question81: 'පුස්තකාලයාධිපති',
                question82: 'අධ්‍යාපන / ඉගැන්වීම',
                question83: 'ගෘහනිර්මාණ',
                question84: 'කළමනාකරණය',
                question85: 'සතුන් බලාගැනීම',
                question86: 'බල ආවුද ක්‍රියාකිරීම',
                question87: 'පර්යේෂණයක් කිරීම',
                question88: 'මෝටර් රථ අලුත්වැඩියාව',
                question89: 'මූර්ති ඇඹීම',
                question90: 'සතුන් කපා පර්යේෂණ කිරීම',
                question91: 'ප්‍රශ්න විසදීමට මිනිසුන්ට උදව් කිරීම',
                question92: 'දර්ශනයක් චිත්‍ර ගත කිරීම',
                question93: 'කාර්යාලයක අර්ධකාලිනව වැඩකිරීම',
                question94: 'සාප්පුවක ඇදුම් පැළදුම් විකිණීම',
                question95: 'අන් අය අධික්ෂණය',
                question96: 'ගිලනුන්ට උදව් කිරීම',
                question97: 'බෝට්‍ටුවක් පැදවීම',
                question98: 'තාරකා ශාස්ත්‍රය ඉගෙනීම',
                question99: 'නාට්‍යයක රඟපෑම',
                question100: 'සඟරාවක් මුද්‍රණය කිරීම',
                question101: 'මිනිසුන් සමග සම්මුඛ සාකච්ඡා',
                question102: 'විද්‍යාත්මක දර්ශනයක් නැරඹීම',
                question103: 'නාට්‍යයක් අධ්‍යක්ෂණය කිරීම',
                question104: 'ගීතයක් ලිවීම',
                question105: 'මිනිසුන්ගේ විම්සුම් වලට පිළිතුරුදීම',
                question106: 'යමක කොටස් ගලවා වෙන් කිරීම',
                question107: 'මාලු ඇල්ලීම',
                question108: 'ඡායාරූප ගැනීම',
                question109: 'ප්‍රචාරණ දැන්වීම් සැකසීම',
                question110: 'ගෘහ භාන්ඩ අලුත්වැඩියාව',
                question111: 'පාරිභෝගිකයන්ට උපදෙස් දීම',
                question112: 'පාෂාණ සාම්පල ‍රැස්කිරීම',
                question113: 'පර්යේෂණ වාර්තාවක් සැකසීම',
                question114: 'කථාවක් ලිවීම',
                question115: 'විනෝදය පිණිස ඇවිදීම',
                question116: 'ක්‍රීඩාවක යෙදීම',
                question117: 'සංගමයක භාන්ඩාගාරික වීම',
                question118: 'විනෝද ක්‍රීඩා කට්ටල් එකලස් කිරීම',
                question119: 'පුස්තකාලයක වැඩකටයුතු වලට උදව් දීම',
                question120: 'කාළගුණ තොරතුරු ‍රැස්කිරීම',
                question121: 'ට්‍රැක්ටරයක් පැදවීම',
                question122: 'සාප්පුවක් කළමනාකරණය කිරීම',
                question123: 'පරිගණකයක වැඩ සටහන් සම්පාදනය',
                question124: 'නව කාර්ය මණ්ඩල පුහුණු කිරීම',
                question125: 'වත්තේ වැඩකිරීම',
                question126: 'යතුරු ලියනය කිරීම',
                exitTestModalLabel: 'ඔබට විශ්වාසද?',
                exitTestModalDescription: 'ඔබට පරීක්ෂණයෙන් ඉවත් වීමට අවශ්‍ය බව කරුණාකර තහවුරු කරන්න. ඔබගේ සියලුම වාර්තා ඉවත් කරනු ලැබේ.',
                exitTestModalButton: 'තහවුරු කරන්න',
                chartCols: ['පිටත', 'ප්‍රායෝගික', 'විද්‍යාත්මක', 'නිර්මාණශීලී', 'ව්‍යාපාරික', 'කාර්යාලීය', 'සමාජ']
            },
            tm: {
                pageOneError: 'உங்கள் பெயரைச் சேர்க்கவும்!',
                pageOneError1: 'உங்கள் NIC சேர்க்கவும்!',
                pageOneError2: 'தவறான NIC வடிவம்.',
                pageOneError3: 'உங்கள் நிறுவனத்தைத் தேர்ந்தெடுக்கவும்!',
                pageOneSuccess1: 'உங்கள் NIC உறுதி செய்யப்பட்டது!',
                pageOneTitle: 'தொழில் ஆர்வச் சோதனை',
                pageOnePara1: 'இந்தச் சோதனை உங்கள் ஆர்வங்களைப் புரிந்துகொள்ள உதவும். நீங்கள் திருப்திகரமாக காணக்கூடிய சில வகையான தொழில்களை இச்சோதனை உங்களுக்குக் காட்டக்கூடும். அடுத்துவரும் சில பக்கங்கள் பல வேலைகள், பாடநெறிகள் மற்றும் செயல்பாடுகளை பட்டியலிடும். ஒவ்வொரு  சோடியிலிருந்தும் நீங்கள் விரும்பும் ஒன்றைத் தேர்ந்தெடுக்கவும். ',
                pageOnePara2: 'ஒவ்வொரு  சோடியையும் பாருங்கள். வலதுபுறத்தில் உள்ளதை நீங்கள் விரும்பினால், வலது பக்கத்தில் உள்ளதை  தேர்வு  செய்யவும்.. இடதுபுறத்தில் உள்ள பதில் உங்களுக்குப் பிடித்திருந்தால், இடதுபுறத்தில் உள்ளதை  தேர்வு  செய்யவும். நீங்கள் எதை விரும்புகிறீர்கள் என்பது உங்களுக்குத் தெரியாவிட்டால், நீங்கள் யூகித்து (guess)  தேர்வு  செய்யவும்.',
                pageOnePara3: 'உங்களால் முடிந்தவரை விரைவாக இதனைச்  செய்யவும். பெரும்பாலானோர் இதனை எளிதில்  செய்து முடிப்பர். இறுதியில்  சோதனை முடிவின் பிரதியொன்று வழங்கப்படும். ',
                pageOnePara4: 'ஒவ்வொரு கேள்வியையும் படியுங்கள். நீங்கள் எதை அதிகம் விரும்புகிறீர்கள் என்று யோசித்து உங்கள் பதிலைத் தேர்ந்தெடுக்கவும். உங்களுக்கு உறுதியாக தெரியவில்லை என்றால், உங்களுக்கு எது சிறந்தது என்று யூகிக்கவும். நீங்கள் ஒன்றைத் தேர்ந்தெடுக்க வேண்டும், மேலும் நீங்கள் எதையும் காலியாக விட முடியாது.',
                pageOnePara5: 'சோதனையைத் தொடங்க, கீழே உள்ள பெயரைப் பூர்த்தி செய்து தொடக்க பொத்தானைக் கிளிக் செய்யவும். ',
                pageOneButton: 'சோதனையைத் தொடங்கவும்',
                pageTwoTitle: 'தொழில்',
                pageTwoDescription: 'உங்களுக்கு மிகவும் பொருத்தமான ஒன்றைத் தேர்ந்தெடுக்கவும்:',
                pageTwoExit: 'வெளியேறும் சோதனை',
                pageTwoNext: 'அடுத்தது',
                pageThreeTitle: 'பயிற்சி நெறிகள்',
                pageThreeDescription: 'உங்களுக்கு மிகவும் பொருத்தமான ஒன்றைத் தேர்ந்தெடுக்கவும்:',
                pageThreeExit: 'வெளியேறும் சோதனை',
                pageThreeBack: 'மீண்டும்',
                pageThreeNext: 'அடுத்தது',
                pageFourTitle: 'செயற்பாடுகள்',
                pageFourDescription: 'உங்களுக்கு மிகவும் பொருத்தமான ஒன்றைத் தேர்ந்தெடுக்கவும்:',
                pageFourExit: 'வெளியேறும் சோதனை',
                pageFourBack: 'மீண்டும்',
                pageFourNext: 'முடிவுகளை காட்டு',
                pageTwoError: 'எல்லா கேள்விகளுக்கும் பதிலளிக்கவும்!',
                pageThreeError: 'எல்லா கேள்விகளுக்கும் பதிலளிக்கவும்!',
                pageFourPersonNameLabel: 'பெயர்',
                pageFourPersonNICLabel: 'NIC எண்',
                pageFourPersonInstituteLabel: 'நிறுவனம்',
                pageFourDateLabel: 'தேதி',
                pageFourEmptyResults: 'உங்கள் தொழில் ஆர்வத்தைக் காண கேள்விகளை முடிக்கவும்',
                pageFiveTitle: 'உங்கள் தொழில் ஆர்வம்',
                pageFiveDescription1: 'நீங்கள் உங்களது விருப்பத்திற்கேற்ப புள்ளியிடும் பிரிவுகள் இரண்டும்இ மூன்றும் உங்களுக்கு பிடித்தமான தொழில்களை தேடிக்கொள்ள உதவியளிக்க தொழில் ஆர்வ பரீட்சையில் உள்ள தொழிற் பிரிவுகளை கவனத்திற் கொள்ளவும்.நீங்கள் அதிகளவு விரும்பும் இரண்டு புள்ளிகளில் மூன்றினை உங்களுக்கு பிடித்தமான தொழிலினை தேடுவதற்கு பயன்படுத்திக் கொள்ளவும்.',
                pageFiveDescription2: 'நீங்கள் அதிகளவிலாக விரும்பும் புள்ளிகளின் இரு பிரிவுகளையும் மூன்றினையும் உங்களுக்கு எந்த விதத்திலும் தொழில்கள் தேட பயன்படுத்திக் கொள்ளலாம்.\n',
                pageFiveDownload: 'முடிவுகளைப் பதிவிறக்குக',
                pageFiveNew: 'புதிய சோதனையைத் தொடங்கவும்',
                pageFiveReference: 'முடிவு குறிப்பு',
                question1: 'விவசாயம்',
                question2: 'இயந்திரங்களை புதுப்பித்தல்',
                question3: 'நோய்களை இனம் காணுதல்',
                question4: 'ஆகாய விமானம் செலுத்துதல்',
                question5: 'கட்டிடங்களை கட்ட திட்டமிடல்',
                question6: 'விஞ்ஞான கூடத்தில் வேலைசெய்தல்',
                question7: 'பிரச்சினைகளைத் தீர்க்க குடும்பங்களுக்கு உதவுதல்',
                question8: 'சித்திரம் வரைதல்',
                question9: 'வரி அறிக்கைகள் தயாரித்தல்',
                question10: 'ஊழியர்களை மேற்பார்வை செய்தல்',
                question11: 'வாடிக்கையாளர்களை சந்தித்தல்',
                question12: 'பிள்ளைகளை பராமரித்தல்',
                question13: 'காணிகளை அளவீடு செய்தல்',
                question14: 'மருந்து வகைகளை விற்றல்',
                question15: 'மாணிக்கக் கற்களை பதித்து மோதிரங்களைத் தயாரித்தல்',
                question16: 'மின்சார விளக்குகள் தயாரித்தல்',
                question17: 'வைத்திய சாலையில் நோயாளிகளை பராமரித்தல்',
                question18: 'வலது குறைந்தோர் புனர்வாழ்வு',
                question19: 'சுற்றுலாக்களை திட்டமிடல்',
                question20: 'இசைக்குழுவில் கலைஞராதல்',
                question21: 'பாடசாலைகளில் கற்பித்தல்',
                question22: 'பாலங்கள் அமைக்கத் திட்டமிடல்',
                question23: 'விளையாட்டுக்கள் தொடர்பான பயிற்சி',
                question24: 'நாடகத்தில் நடித்தல்',
                question25: 'கடையொன்றின் உரிமையாளராகுதல்',
                question26: 'கணணி புதுப்பித்தல்',
                question27: 'சட்டத்தரணியாகுதல்',
                question28: 'கால்நடை வைத்தியராகுதல்',
                question29: 'நூலக நிர்வாகி',
                question30: 'செய்தித்தாளுக்கு கட்டுரையெழுதல்',
                question31: 'வனபாதுகாப்பு',
                question32: 'சத்திரசிகி்ச்சை வைத்தியராகுதல்',
                question33: 'வீட்டுக்கடன் அனுமதித்தல்',
                question34: 'வீடொன்றினைக் கட்டுதல்',
                question35: 'கணணி மென்பொருள் தயாரித்தல்',
                question36: 'பல் வைத்தியராகுதல்',
                question37: 'பூந்தோட்ட அலங்கரிப்பாளர்',
                question38: 'கடை உரிமையாளராதல்',
                question39: 'கணக்கு பரிசீலனை',
                question40: 'தொழில் ஆலோசனை',
                question41: 'லொறி சாரதி',
                question42: 'அலுவலக வேலை',
                question43: 'பூகோளவியல்',
                question44: 'பூகோள படம் வரைதல்',
                question45: 'இரசாயன வேலைகள்',
                question46: 'உலோக வேலை',
                question47: 'சங்கீதம்',
                question48: 'உயிரியல் விஞ்ஞானம்',
                question49: 'மனையியல்',
                question50: 'கவிதை எழுதுதல்',
                question51: 'கணிதம்',
                question52: 'வர்த்தகவியல்',
                question53: 'வர்த்தகம்',
                question54: 'சுகாதார சேவை',
                question55: 'விவசாயம்',
                question56: 'பௌதிகவியல்',
                question57: 'ஆடைக்கைத்தொழில்',
                question58: 'மரவேலை',
                question59: 'வரலாறு',
                question60: 'புவிசரிதவியல்',
                question61: 'பொருளாதாரம்',
                question62: 'நாடகக்கலை',
                question63: 'மதக்கல்வி',
                question64: 'பொறியியல்துறை',
                question65: 'விலங்கியல்',
                question66: 'புகைப்படக் கலை',
                question67: 'சில்லறை வியாபாரம்',
                question68: 'நீர்க்குழாய் வேலை',
                question69: 'அரசியல் விஞ்ஞானம்',
                question70: 'தாவர விஞ்ஞானம்',
                question71: 'ஆவணங்கள் தயாரித்தல்',
                question72: 'சித்திரக்கலை',
                question73: 'சுற்றாடல் விஞ்ஞானம்',
                question74: 'சமூகவியல்',
                question75: 'கணக்கியல்',
                question76: 'இலக்ரோனிக் கலை',
                question77: 'கணணி பயிற்சி',
                question78: 'வைத்திய தொழில்',
                question79: 'உடற்கல்வி',
                question80: 'பிரச்சார நடவடிக்கை',
                question81: 'நூலக அதிபர்',
                question82: 'கல்வி – கற்பித்தல்',
                question83: 'வீட்டு நிர்வாகம்',
                question84: 'முகாமைத்துவம்',
                question85: 'மிருகங்கள் பராமரிப்பு',
                question86: 'மின்சார உபகரணங்கள் இயக்குதல்',
                question87: 'ஆய்வுகள் நடத்துதல்',
                question88: 'மோட்டார் வாகனம் புதுப்பித்தல்',
                question89: 'சிற்ப வேலைகள்',
                question90: 'மிருகங்களை வெட்டி ஆய்வுகள் மேற்கொள்ளுதல்',
                question91: 'பிரச்சினைகளை தீர்ப்பதற்கு மனிதர்களுக்கு உதவியளித்தல்',
                question92: 'திரைப்படம் தயாரித்தல்',
                question93: 'அலுவலகமொன்றில் பகுதிநேர வேலை செய்தல்',
                question94: 'கடையொன்றில் துணிவிற்றல்',
                question95: 'வேறு ஆட்களை மேற்பார்வை செய்தல்',
                question96: 'முதியோருக்கு உதவி செய்தல்',
                question97: 'படகு ஓட்டுதல்',
                question98: 'நட்சத்திர விஞ்ஞானம்',
                question99: 'நாடகத்தில் நடித்தல்',
                question100: 'சஞ்சிகை ஒன்றினை அச்சிடுதல்',
                question101: 'மனிதர்களுடன் நேரடி கலந்துரையாடல்',
                question102: 'விஞ்ஞான சாட்சியினை பார்த்தல்',
                question103: 'நாடகம் ஒன்றினை தயாரித்தல்',
                question104: 'பாடலொன்றினை எழுதுதல்',
                question105: 'மனிதர்களது கேள்விகளுக்கு பதில் கூறுதல்',
                question106: 'ஏதேனும் ஒன்றில் துண்டுகளை வேறுபடுத்தல்',
                question107: 'மீன் பிடித்தல்',
                question108: 'புகைப்படம் எடுத்தல்',
                question109: 'பிரசார தயாரிப்புகள்',
                question110: 'மரத்தளபாடங்களை தயாரித்தல்',
                question111: 'சேவை பெறுநர்களுக்கு ஆலோசனை வழங்குதல்',
                question112: 'கற்களிலான ஞாபகாரத்த பொருட்களை சேர்த்தல்',
                question113: 'ஆய்வு அறிக்கைகள் தயாரித்தல்',
                question114: 'கதை எழுதுதல்',
                question115: 'நடந்து செல்லல் / காடுகளில் உலாவுதல்',
                question116: 'விளையாட்டுக்களில் ஈடுபடுதல்',
                question117: 'ஒரு குழுவின் பொருளாளராக இருத்தல்',
                question118: 'வினோத விளையாட்டு பொருள் தொகுதி ஒன்றினை உற்பத்தி செய்தல்',
                question119: 'நூல் நிலையத்தில் உதவி செய்தல்',
                question120: 'காலநிலை தகவல்கள் சேர்த்தல்',
                question121: 'உழவுயந்திரங்களை செலுத்துதல்',
                question122: 'கடையொன்றின் முகாமையாளராதல்',
                question123: 'கணணி வேலைகள் குறிப்புகள் தயாரித்தல்',
                question124: 'புதிய சேவையாளர்களை பயிற்றுவித்தல்',
                question125: 'தோட்டத்தில் வேலை செய்தல்',
                question126: 'தட்டெழுத்து விடயத்தில் ஈடுபடுதல்',
                exitTestModalLabel: 'நீ சொல்வது உறுதியா?',
                exitTestModalDescription: 'நீங்கள் சோதனையிலிருந்து வெளியேற விரும்புகிறீர்கள் என்பதை உறுதிப்படுத்தவும். உங்கள் எல்லா பதிவுகளும் அகற்றப்படும்.',
                exitTestModalButton: 'உறுதிப்படுத்தவும்',
                chartCols: ['வெளிப்புற', 'செய்முறை', 'அறிவியல்', 'படைப்பாற்றல்', 'வணிகம்', 'அலுவலகம்', 'சமூக']
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
            localStorage.removeItem('ckt-personName');
            localStorage.removeItem('ckt-personNIC');
            localStorage.removeItem('ckt-personInstitute');
            localStorage.removeItem('progress');
            localStorage.removeItem('results');
            localStorage.removeItem('page');
            localStorage.removeItem('completedQuestions');
            localStorage.setItem('ckt-results-pushed', 'false');
            var results = {
                outdoor: 0,
                practical: 0,
                science: 0,
                creative: 0,
                business: 0,
                office: 0,
                social: 0
            }
            var page = "1";
            var completedQuestions = {};
            var lang = getLanguageFromURL();
            changeLanguage(lang)
            changePage(page)
            setResults(results)
            updateButtons(completedQuestions)
            setProgress(0);
            if (localStorage.getItem('ckt-personName')) {
                $('#personName').val(localStorage.getItem('ckt-personName'))
            }
            if (localStorage.getItem('ckt-personNIC')) {
                $('#personNIC').val(localStorage.getItem('ckt-personNIC'))
            }
            if (localStorage.getItem('ckt-personInstitute')) {
                $('#personInstitute').val(localStorage.getItem('ckt-personInstitute'))
            }
            $(".select-2").select2({
                height: '38px'
            });
        }

        function changeLanguage(lang) {
            localStorage.removeItem('lang')
            localStorage.setItem('lang', lang)
            $('.top_menu a').removeClass('active')
            $('#langSelect-' + lang).addClass('active');

            for (let key in translations[lang]) {
                $('#' + key).text(translations[lang][key])
            }
            $('#pageFourPersonNameLabel').text(translations[localStorage.getItem('lang')]['pageFourPersonNameLabel'])
            $('#pageFourDateLabel').text(translations[localStorage.getItem('lang')]['pageFourDateLabel'])
            $('#pageFourPersonNICLabel').text(translations[localStorage.getItem('lang')]['pageFourPersonNICLabel'])
            $('#pageFourPersonInstituteLabel').text(translations[localStorage.getItem('lang')]['pageFourPersonInstituteLabel'])


            // $('#resultsTableOutdoor').text(translations[localStorage.getItem('lang')]['chartCols'][0])
            // $('#resultsTablePractical').text(translations[localStorage.getItem('lang')]['chartCols'][1])
            // $('#resultsTableScience').text(translations[localStorage.getItem('lang')]['chartCols'][2])
            // $('#resultsTableCreative').text(translations[localStorage.getItem('lang')]['chartCols'][3])
            // $('#resultsTableBusiness').text(translations[localStorage.getItem('lang')]['chartCols'][4])
            // $('#resultsTableOffice').text(translations[localStorage.getItem('lang')]['chartCols'][5])
            // $('#resultsTableSocial').text(translations[localStorage.getItem('lang')]['chartCols'][6])

            if(localStorage.getItem('page') == '5') {
                updateChart(JSON.parse(localStorage.getItem('results')));
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
                        return;
                    }
                    localStorage.setItem('ckt-personName', $('#personName').val())
                    localStorage.setItem('ckt-personNIC', $('#personNIC').val())
                    localStorage.setItem('ckt-personInstitute', $('#personInstitute').val())
                    $('#pageOneNameDiv').removeClass('was-validated')
                }
            }

            if (page === 3) {
                if (Object.keys(completedQuestions).length < 21) {
                    $('#pageTwoError').removeClass('d-none')
                    return
                } else {
                    $('#pageTwoError').addClass('d-none')
                }
            }

            if (page === 4) {
                if (Object.keys(completedQuestions).length < 42) {
                    $('#pageThreeError').removeClass('d-none')
                    return
                } else {
                    $('#pageThreeError').addClass('d-none')
                }
            }
            if (page === 5) {
                if (Object.keys(completedQuestions).length < 63) {
                    $('#pageFourEmptyResults').removeClass('d-none')
                    return
                } else {
                    $('#pageFourEmptyResults').addClass('d-none')
                }
            }

            localStorage.setItem('page', page)
            $('#page1').fadeOut()
            $('#page2').fadeOut()
            $('#page3').fadeOut()
            $('#page5').fadeOut()

            if (page === 5) {
                $('#pageFourPersonName').text(localStorage.getItem('ckt-personName'))
                $('#pageFourPersonNIC').text(localStorage.getItem('ckt-personNIC'))
                $('#pageFourPersonInstitute').text($(".select-2 option:selected").text())
                $('#pageFourDate').text(new Date().toISOString().slice(0, 10))
                //Push result to controller to save it
                if (localStorage.getItem("results") !== null && localStorage.getItem("ckt-results-pushed") !== 'true') {
                    localStorage.setItem('ckt-results-pushed', 'true');
                    let csrf = $('meta[name="csrf_token"]').attr('content');
                    $.ajax({
                        url : "{{ (isset($saveUrl)) ? $saveUrl : route('testnow.save-results') }}",
                        data : {
                            '_token': csrf,
                            'name' : localStorage.getItem("ckt-personName"),
                            'nic' : localStorage.getItem("ckt-personNIC"),
                            'institute' : localStorage.getItem("ckt-personInstitute"),
                            'results' : localStorage.getItem("results"),
                            'type': '1'
                        },
                        type : 'POST',
                        dataType : 'json',
                        success : function(result){
                            // Mark the results as pushed to prevent multiple submissions
                            localStorage.setItem('ckt-results-pushed', 'true');
                        }
                    });
                }
            }

            if (page === 5 && localStorage.getItem('progress') === '0') {
                localStorage.setItem('page', 4)
                $('#pageFourEmptyResults').removeClass('d-none')
            } else {
                $('#page4').fadeOut()
                $('#page' + page).fadeIn()
                $('#pageFourEmptyResults').addClass('d-none')
            }

            if (page === 1) {
                localStorage.removeItem('progress')
                localStorage.removeItem('results')
                localStorage.removeItem('completedQuestions')
                localStorage.removeItem('ckt-personName')
                localStorage.removeItem('ckt-personNIC')
                localStorage.removeItem('ckt-personInstitute')
                location.reload()
            }
            $("html, body").animate({ scrollTop: 0 }, "fast");
        }

        function setProgress(progress) {
            localStorage.setItem('progress', progress)
            $("#progress-bar").css('width', progress + '%')
            $('#progress-bar').text(progress + '%')
            $("#progress-bar-2").css('width', progress + '%')
            $('#progress-bar-2').text(progress + '%')
            $("#progress-bar-3").css('width', progress + '%')
            $('#progress-bar-3').text(progress + '%')
        }

        function setResults(results) {
            localStorage.setItem('results', JSON.stringify(results))
            let progress = Math.round((Object.keys(completedQuestions).length / 63) * 100)
            setProgress(progress)
            updateChart(results)
        }

        function updateResults(typeAdd, typeRemove, question, option) {
            $('#pageFourEmptyResults').addClass('d-none')
            completedQuestions[question] = option
            localStorage.setItem('completedQuestions', JSON.stringify(completedQuestions))

            let outdoor = 0, practical = 0, science = 0, creative = 0, business = 0, office = 0, social = 0
            for (let key in completedQuestions) {
                let value = $('#' + completedQuestions[key]).val()
                if (value === 'outdoor') outdoor = outdoor + 1
                if (value === 'practical') practical = practical + 1
                if (value === 'science') science = science + 1
                if (value === 'creative') creative = creative + 1
                if (value === 'business') business = business + 1
                if (value === 'office') office = office + 1
                if (value === 'social') social = social + 1
            }

            setResults({outdoor: outdoor, practical: practical, science: science, creative: creative, business: business, office: office, social: social})
        }

        function updateButtons(completedQuestions) {
            for (let key in completedQuestions) {
                $('#' + completedQuestions[key]).attr('checked', true)
            }
        }

        function updateChart(results) {
            $('#myChart1').zingchart({
                data: {
                    type: 'bar',
                    plot: {
                        barWidth: 20,
                    },
                    scaleX: {
                        labels: translations[localStorage.getItem('lang')]['chartCols']
                    },
                    series: [
                        {
                            values: [
                                results['outdoor'],
                                results['practical'],
                                results['science'],
                                results['creative'],
                                results['business'],
                                results['office'],
                                results['social']
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
        function prepareChartForPrint(){
            $("#myChartPrintContainer").empty();
            zingchart.exec('myChart1', 'getimagedata', {
                filetype: 'png',
                callback: function (imageData){
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
                <h1 id="pageOneTitle">Career Interest Test</h1>
                <p id="pageOnePara1">This test is used to help you understand your interests. It may show you some kinds of careers you might find satisfying. The next few pages list many jobs, courses and activities. From each pair pick the one you prefer.</p>
                <p id="pageOnePara2">Look at each pair. If you prefer the one on the right, put a tick on the right hand side. If you like the answer on the left, put your tick on the left hand side. If you are not really sure what you would like then you should just guess.</p>
                <p id="pageOnePara3">Work as quickly as you can. Most people find it easy to complete. At the end you will be given a copy of the results.</p>
                <p id="pageOnePara4">Read each question. Think which one you would like the most and select your answer. If you are not sure, then just guess what is best for you. You have to choose one, and you cannot leave any blank.</p>
                <p id="pageOnePara5">To start the test, please fill the name below and click on the start button.</p>
                <div id="pageOneNameDiv" class="row shadow-none p-3 mt-1 mb-3 bg-light rounded" style="justify-content: center">
                    <div class="col-md-6 btn">
                        <input type="text" class="form-control" id="personName" placeholder="Your name" {{$userFullName != '' ? 'disabled' : ''}} value="{{$userFullName}}" required>
                        <div id="pageOneError" class="invalid-feedback text-start">
                            Please add your name!
                        </div>
                    </div>
                    <div class="col-md-6 btn">
                        <input type="text" class="form-control" id="personNIC" placeholder="Your NIC" {{$userNIC != '' ? 'disabled' : ''}} value="{{$userNIC}}" pattern="^([0-9]{9}[vVxX]|[0-9]{12})$" required>
{{--                        <div id="pageOneError1" class="invalid-feedback text-start">--}}
{{--                            Please add your NIC!--}}
{{--                        </div>--}}
                        <div id="pageOneError2" class="invalid-feedback text-start">
                            Invalid NIC format.
                        </div>
                        <div id="pageOneSuccess1" class="d-none text-success text-start">
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
{{--                    @if(activeGuard() == '' && !Auth::guard(activeGuard())->check())--}}
{{--                    <div class="col-auto" id="checNICButtonDiv">--}}
{{--                        <div class="btn">--}}
{{--                            <a href="javascript:;" onclick='checkNIC(event)' class="primary" id="checNICButton">Check your NIC</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-auto d-none" id="pageOneButtonDiv">--}}
{{--                        <div class="btn">--}}
{{--                            <a href="javascript:;" onclick='changePage(2)' class="primary" id="pageOneButton">Start the Test</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @else--}}
                        <div class="col-auto" id="pageOneButtonDiv">
                            <div class="btn">
                                <a href="javascript:;" onclick='changePage(2)' class="primary" id="pageOneButton">Start the Test</a>
                            </div>
                        </div>
{{--                    @endif--}}
                </div>
            </div>
        </div>

        <div id="page2" class="row">
            <div class="col-lg-10 text-center content-box">
                <div class="progress-bar" id="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                <h1 id="pageTwoTitle">Jobs</h1>
                <p id="pageTwoDescription">Select one that best suites you:</p>

                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q1" id="option1" value="social" onchange='updateResults("social", "practical", "q1", "option1")'>
                        <label class="btn btn-outline-secondary" for="option1" id="question1">GROW CROPS</label>

                        <input type="radio" class="btn-check btn-secondary" name="q1" id="option2" value="practical" onchange='updateResults("practical", "social", "q1", "option2")'>
                        <label class="btn btn-outline-secondary" for="option2" id="question2">FIX MACHINES</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q2" id="option3" value="science" onchange='updateResults("science", "practical", "q2", "option3")'>
                        <label class="btn btn-outline-secondary" for="option3" id="question3">DIAGNOSE AN ILLNESS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q2" id="option4" value="practical" onchange='updateResults("practical", "science", "q2", "option4")'>
                        <label class="btn btn-outline-secondary" for="option4" id="question4">FLY A PLANE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q3" id="option5" value="creative" onchange='updateResults("creative", "science", "q3", "option5")'>
                        <label class="btn btn-outline-secondary" for="option5" id="question5">DESIGN BUILDINGS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q3" id="option6" value="science" onchange='updateResults("science", "creative", "q3", "option6")'>
                        <label class="btn btn-outline-secondary" for="option6" id="question6">"science", "creative", "q3", "option6</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q4" id="option7" value="social" onchange='updateResults("social", "creative", "q4", "option7")'>
                        <label class="btn btn-outline-secondary" for="option7" id="question7">HELP FAMILIES WITH PROBLEMS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q4" id="option8" value="creative" onchange='updateResults("creative", "social", "q4", "option8")'>
                        <label class="btn btn-outline-secondary" for="option8" id="question8">PAINT PORTRAITS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q5" id="option9" value="office" onchange='updateResults("office", "business", "q5", "option9")'>
                        <label class="btn btn-outline-secondary" for="option9" id="question9">PREPARE TAX RETURNS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q5" id="option10" value="business" onchange='updateResults("business", "office", "q5", "option10")'>
                        <label class="btn btn-outline-secondary" for="option10" id="question10">BE IN CHARGE OF WORKERS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q6" id="option11" value="business" onchange='updateResults("business", "social", "q6", "option11")'>
                        <label class="btn btn-outline-secondary" for="option11" id="question11">VISIT CUSTOMERS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q6" id="option12" value="social" onchange='updateResults("social", "business", "q6", "option12")'>
                        <label class="btn btn-outline-secondary" for="option12" id="question12">LOOK AFTER CHILDREN</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q7" id="option13" value="outdoor" onchange='updateResults("outdoor", "science", "q7", "option13")'>
                        <label class="btn btn-outline-secondary" for="option13" id="question13">MEASURE BLOCKS OF LAND</label>
                        <input type="radio" class="btn-check btn-secondary" name="q7" id="option14" value="science" onchange='updateResults("science", "outdoor", "q7", "option14")'>
                        <label class="btn btn-outline-secondary" for="option14" id="question14"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q8" id="option15" value="creative" onchange='updateResults("creative", "practical", "q8", "option15")'>
                        <label class="btn btn-outline-secondary" for="option15" id="question15">MAKE DIAMOND RINGS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q8" id="option16" value="practical" onchange='updateResults("practical", "creative", "q8", "option16")'>
                        <label class="btn btn-outline-secondary" for="option16" id="question16">FIX LIGHTS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q9" id="option17" value="social" onchange='updateResults("social", "science", "q9", "option17")'>
                        <label class="btn btn-outline-secondary" for="option17" id="question17">HELP SICK PEOPLE IN HOSPITAL</label>
                        <input type="radio" class="btn-check btn-secondary" name="q9" id="option18" value="science" onchange='updateResults("science", "social", "q9", "option18")'>
                        <label class="btn btn-outline-secondary" for="option18" id="question18">MASSAGE SORE MUSCLES</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q10" id="option19" value="business" onchange='updateResults("business", "creative", "q10", "option19")'>
                        <label class="btn btn-outline-secondary" for="option19" id="question19">ORGANISE TRAVEL PLANS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q10" id="option20" value="creative" onchange='updateResults("creative", "business", "q10", "option20")'>
                        <label class="btn btn-outline-secondary" for="option20" id="question20">PLAY IN A BAND</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q11" id="option21" value="social" onchange='updateResults("social", "practical", "q11", "option21")'>
                        <label class="btn btn-outline-secondary" for="option21" id="question21">TEACH IN A SCHOOL</label>
                        <input type="radio" class="btn-check btn-secondary" name="q11" id="option22" value="practical" onchange='updateResults("practical", "social", "q11", "option22")'>
                        <label class="btn btn-outline-secondary" for="option22" id="question22">DESIGN BRIDGES</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q12" id="option23" value="outdoor" onchange='updateResults("outdoor", "creative", "q12", "option23")'>
                        <label class="btn btn-outline-secondary" for="option23" id="question23">TRAIN FOR SPORT</label>
                        <input type="radio" class="btn-check btn-secondary" name="q12" id="option24" value="creative" onchange='updateResults("creative", "outdoor", "q12", "option24")'>
                        <label class="btn btn-outline-secondary" for="option24" id="question24">ACT IN A PLAY</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q13" id="option25" value="business" onchange='updateResults("business", "practical", "q13", "option25")'>
                        <label class="btn btn-outline-secondary" for="option25" id="question25">OWN A SHOP</label>
                        <input type="radio" class="btn-check btn-secondary" name="q13" id="option26" value="practical" onchange='updateResults("practical", "business", "q13", "option26")'>
                        <label class="btn btn-outline-secondary" for="option26" id="questio26">FIX COMPUTERS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q14" id="option27" value="business" onchange='updateResults("business", "science", "q14", "option27")'>
                        <label class="btn btn-outline-secondary" for="option27" id="question27">DEFEND SOMEONE IN COURT</label>
                        <input type="radio" class="btn-check btn-secondary" name="q14" id="option28" value="science" onchange='updateResults("science", "business", "q14", "option28")'>
                        <label class="btn btn-outline-secondary" for="option28" id="question28">TREAT SICK ANIMALS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q15" id="option29" value="business" onchange='updateResults("business", "creative", "q15", "option29")'>
                        <label class="btn btn-outline-secondary" for="option29" id="question29">MANAGE A LIBRARY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q15" id="option30" value="creative" onchange='updateResults("creative", "office", "q15", "option30")'>
                        <label class="btn btn-outline-secondary" for="option30" id="question30">WRITE FOR A NEWSPAPER</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q16" id="option31" value="outdoor" onchange='updateResults("outdoor", "social", "q16", "option31")'>
                        <label class="btn btn-outline-secondary" for="option31" id="question31">LOOK AFTER FORESTS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q16" id="option32" value="social" onchange='updateResults("social", "outdoor", "q16", "option32")'>
                        <label class="btn btn-outline-secondary" for="option32" id="question32">HELP PEOPLE WITH INJURIES</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q17" id="option33" value="office" onchange='updateResults("office", "practical", "q17", "option33")'>
                        <label class="btn btn-outline-secondary" for="option33" id="question33">APPROVE A HOME LOAN</label>
                        <input type="radio" class="btn-check btn-secondary" name="q17" id="option34" value="practical" onchange='updateResults("practical", "office", "q17", "option34")'>
                        <label class="btn btn-outline-secondary" for="option34" id="question34">BUILD A HOUSE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q18" id="option35" value="office" onchange='updateResults("office", "science", "q18", "option35")'>
                        <label class="btn btn-outline-secondary" for="option35" id="question35">DEVELOP COMPUTER SOFTWARE</label>
                        <input type="radio" class="btn-check btn-secondary" name="q18" id="option36" value="science" onchange='updateResults("science", "office", "q18", "option36")'>
                        <label class="btn btn-outline-secondary" for="option36" id="question36">FIX TEETH</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q19" id="option37" value="outdoor" onchange='updateResults("outdoor", "business", "q19", "option37")'>
                        <label class="btn btn-outline-secondary" for="option37" id="question37">PREPARE A LAWN</label>
                        <input type="radio" class="btn-check btn-secondary" name="q19" id="option38" value="business" onchange='updateResults("business", "outdoor", "q19", "option38")'>
                        <label class="btn btn-outline-secondary" for="option38" id="question38">OWN A SHOP</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q20" id="option39" value="office" onchange='updateResults("office", "social", "q20", "option39")'>
                        <label class="btn btn-outline-secondary" for="option39" id="question39">ANALYSE FINANCES</label>
                        <input type="radio" class="btn-check btn-secondary" name="q20" id="option40" value="social" onchange='updateResults("social", "office", "q20", "option40")'>
                        <label class="btn btn-outline-secondary" for="option40" id="question40">GIVE ADVICE ABOUT JOBS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q21" id="option41" value="outdoor" onchange='updateResults("outdoor", "office", "q21", "option41")'>
                        <label class="btn btn-outline-secondary" for="option41" id="question41">DRIVE A TRUCK</label>
                        <input type="radio" class="btn-check btn-secondary" name="q21" id="option42" value="office" onchange='updateResults("office", "outdoor", "q21", "option42")'>
                        <label class="btn btn-outline-secondary" for="option42" id="question42">WORK IN AN OFFICE</label>
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
            <div class="col-lg-10 text-center content-box">
                <div class="progress-bar" id="progress-bar-2" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                <h1 id="pageThreeTitle">Courses</h1>
                <p id="pageThreeDescription">Select one that best suites you:</p>

                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q22" id="option43" value="social" onchange='updateResults("social", "practical", "q22", "option43")'>
                        <label class="btn btn-outline-secondary" for="option43" id="question43">GEOGRAPHY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q22" id="option44" value="practical" onchange='updateResults("practical", "social", "q22", "option44")'>
                        <label class="btn btn-outline-secondary" for="option44" id="question44">TECHNICAL DRAWING</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q23" id="option45" value="science" onchange='updateResults("science", "practical", "q23", "option45")'>
                        <label class="btn btn-outline-secondary" for="option45" id="question45">CHEMISTRY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q23" id="option46" value="practical" onchange='updateResults("practical", "science", "q23", "option46")'>
                        <label class="btn btn-outline-secondary" for="option46" id="question46">METALWORK</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q24" id="option47" value="creative" onchange='updateResults("creative", "science", "q24", "option47")'>
                        <label class="btn btn-outline-secondary" for="option47" id="question47">MUSIC</label>
                        <input type="radio" class="btn-check btn-secondary" name="q24" id="option48" value="science" onchange='updateResults("science", "creative", "q24", "option48")'>
                        <label class="btn btn-outline-secondary" for="option48" id="question48">BIOLOGY</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q25" id="option49" value="social" onchange='updateResults("social", "creative", "q25", "option49")'>
                        <label class="btn btn-outline-secondary" for="option49" id="question49">HOME SCIENCE</label>
                        <input type="radio" class="btn-check btn-secondary" name="q25" id="option50" value="creative" onchange='updateResults("creative", "social", "q25", "option50")'>
                        <label class="btn btn-outline-secondary" for="option50" id="question50">POETRY</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q26" id="option51" value="office" onchange='updateResults("office", "business", "q26", "option51")'>
                        <label class="btn btn-outline-secondary" for="option51" id="question51">MATHEMATICS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q26" id="option52" value="business" onchange='updateResults("business", "office", "q26", "option52")'>
                        <label class="btn btn-outline-secondary" for="option52" id="question52">COMMERCE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q27" id="option53" value="business" onchange='updateResults("business", "social", "q27", "option53")'>
                        <label class="btn btn-outline-secondary" for="option53" id="question53">BUSINESS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q27" id="option54" value="social" onchange='updateResults("social", "business", "q27", "option54")'>
                        <label class="btn btn-outline-secondary" for="option54" id="question54">HEALTH CARE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q28" id="option55" value="outdoor" onchange='updateResults("outdoor", "science", "q28", "option55")'>
                        <label class="btn btn-outline-secondary" for="option55" id="question55">AGRICULTURE</label>
                        <input type="radio" class="btn-check btn-secondary" name="q28" id="option56" value="science" onchange='updateResults("science", "outdoor", "q28", "option56")'>
                        <label class="btn btn-outline-secondary" for="option56" id="question56">AGRICULTURE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q29" id="option57" value="creative" onchange='updateResults("creative", "practical", "q29", "option57")'>
                        <label class="btn btn-outline-secondary" for="option57" id="question57">TEXTILES</label>
                        <input type="radio" class="btn-check btn-secondary" name="q29" id="option58" value="practical" onchange='updateResults("practical", "creative", "q29", "option58")'>
                        <label class="btn btn-outline-secondary" for="option58" id="question58">WOODWORK</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q30" id="option59" value="social" onchange='updateResults("social", "science", "q30", "option59")'>
                        <label class="btn btn-outline-secondary" for="option59" id="question59">HISTORY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q30" id="option60" value="science" onchange='updateResults("science", "social", "q30", "option60")'>
                        <label class="btn btn-outline-secondary" for="option60" id="question60">GEOLOGY</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q31" id="option61" value="business" onchange='updateResults("business", "creative", "q31", "option61")'>
                        <label class="btn btn-outline-secondary" for="option61" id="question61">ECONOMICS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q31" id="option62" value="creative" onchange='updateResults("creative", "business", "q31", "option62")'>
                        <label class="btn btn-outline-secondary" for="option62" id="question62">DRAMA</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q32" id="option63" value="social" onchange='updateResults("social", "practical", "q32", "option63")'>
                        <label class="btn btn-outline-secondary" for="option63" id="question63">RELIGIOUS STUDIES</label>
                        <input type="radio" class="btn-check btn-secondary" name="q32" id="option64" value="practical" onchange='updateResults("practical", "social", "q32", "option64")'>
                        <label class="btn btn-outline-secondary" for="option64" id="question64">ENGINEERING</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q33" id="option65" value="outdoor" onchange='updateResults("outdoor", "creative", "q33", "option65")'>
                        <label class="btn btn-outline-secondary" for="option65" id="question65">ZOOLOGY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q33" id="option66" value="creative" onchange='updateResults("creative", "outdoor", "q33", "option66")'>
                        <label class="btn btn-outline-secondary" for="option66" id="question66">PHOTOGRAPHY</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q34" id="option67" value="business" onchange='updateResults("business", "practical", "q34", "option67")'>
                        <label class="btn btn-outline-secondary" for="option67" id="question67">RETAILING</label>
                        <input type="radio" class="btn-check btn-secondary" name="q34" id="option68" value="practical" onchange='updateResults("practical", "business", "q34", "option68")'>
                        <label class="btn btn-outline-secondary" for="option68" id="question68">PLUMBING</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q35" id="option69" value="business" onchange='updateResults("business", "science", "q35", "option69")'>
                        <label class="btn btn-outline-secondary" for="option69" id="question69">POLITICS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q35" id="option70" value="science" onchange='updateResults("science", "business", "q35", "option70")'>
                        <label class="btn btn-outline-secondary" for="option70" id="question70">BOTANY</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q36" id="option71" value="business" onchange='updateResults("business", "creative", "q36", "option71")'>
                        <label class="btn btn-outline-secondary" for="option71" id="question71">SECRETARIAL STUDIES</label>
                        <input type="radio" class="btn-check btn-secondary" name="q36" id="option72" value="creative" onchange='updateResults("creative", "office", "q36", "option72")'>
                        <label class="btn btn-outline-secondary" for="option72" id="question72">ART</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q37" id="option73" value="outdoor" onchange='updateResults("outdoor", "social", "q37", "option73")'>
                        <label class="btn btn-outline-secondary" for="option73" id="question73">ENVIRONMENT</label>
                        <input type="radio" class="btn-check btn-secondary" name="q37" id="option74" value="social" onchange='updateResults("social", "outdoor", "q37", "option74")'>
                        <label class="btn btn-outline-secondary" for="option74" id="question74">SOCIAL PROBLEMS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q38" id="option75" value="office" onchange='updateResults("office", "practical", "q38", "option75")'>
                        <label class="btn btn-outline-secondary" for="option75" id="question75">ACCOUNTANCY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q38" id="option76" value="practical" onchange='updateResults("practical", "office", "q38", "option76")'>
                        <label class="btn btn-outline-secondary" for="option76" id="question76">ELECTRONICS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q39" id="option77" value="office" onchange='updateResults("office", "science", "q39", "option77")'>
                        <label class="btn btn-outline-secondary" for="option77" id="question77">COMPUTING</label>
                        <input type="radio" class="btn-check btn-secondary" name="q39" id="option78" value="science" onchange='updateResults("science", "office", "q39", "option78")'>
                        <label class="btn btn-outline-secondary" for="option78" id="question78">MEDICINE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q40" id="option79" value="outdoor" onchange='updateResults("outdoor", "business", "q40", "option79")'>
                        <label class="btn btn-outline-secondary" for="option79" id="question79">PHYSICAL EDUCATION</label>
                        <input type="radio" class="btn-check btn-secondary" name="q40" id="option80" value="business" onchange='updateResults("business", "outdoor", "q40", "option80")'>
                        <label class="btn btn-outline-secondary" for="option80" id="question80">ADVERTISING</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q41" id="option81" value="office" onchange='updateResults("office", "social", "q41", "option81")'>
                        <label class="btn btn-outline-secondary" for="option81" id="question81">LIBRARIANSHIP</label>
                        <input type="radio" class="btn-check btn-secondary" name="q41" id="option82" value="social" onchange='updateResults("social", "office", "q41", "option82")'>
                        <label class="btn btn-outline-secondary" for="option82" id="question82">EDUCATION/TEACHING</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q42" id="option83" value="outdoor" onchange='updateResults("outdoor", "office", "q42", "option83")'>
                        <label class="btn btn-outline-secondary" for="option83" id="question83">BUILDING</label>
                        <input type="radio" class="btn-check btn-secondary" name="q42" id="option84" value="office" onchange='updateResults("office", "outdoor", "q42", "option84")'>
                        <label class="btn btn-outline-secondary" for="option84" id="question84">MANAGEMENT</label>
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
            <div class="col-lg-10 text-center content-box">
                <div class="progress-bar" id="progress-bar-3" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                <h1 id="pageFourTitle">Activities</h1>
                <p id="pageFourDescription">Select one that best suites you:</p>

                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q43" id="option85" value="social" onchange='updateResults("social", "practical", "q43", "option85")'>
                        <label class="btn btn-outline-secondary" for="option85" id="question85">LOOK AFTER ANIMALS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q43" id="option86" value="practical" onchange='updateResults("practical", "social", "q43", "option86")'>
                        <label class="btn btn-outline-secondary" for="option86" id="question86">OPERATE POWER TOOLS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q44" id="option87" value="science" onchange='updateResults("science", "practical", "q44", "option87")'>
                        <label class="btn btn-outline-secondary" for="option87" id="question87">DO AN EXPERIMENT</label>
                        <input type="radio" class="btn-check btn-secondary" name="q44" id="option88" value="practical" onchange='updateResults("practical", "science", "q44", "option88")'>
                        <label class="btn btn-outline-secondary" for="option88" id="question88">FIX CARS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q45" id="option89" value="creative" onchange='updateResults("creative", "science", "q45", "option89")'>
                        <label class="btn btn-outline-secondary" for="option89" id="question89">CREATE A SCULPTURE</label>
                        <input type="radio" class="btn-check btn-secondary" name="q45" id="option90" value="science" onchange='updateResults("science", "creative", "q45", "option90")'>
                        <label class="btn btn-outline-secondary" for="option90" id="question90">DISSECT SPECIMENS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q46" id="option91" value="social" onchange='updateResults("social", "creative", "q46", "option91")'>
                        <label class="btn btn-outline-secondary" for="option91" id="question91">HELP PEOPLE WITH PROBLEMS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q46" id="option92" value="creative" onchange='updateResults("creative", "social", "q46", "option92")'>
                        <label class="btn btn-outline-secondary" for="option92" id="question92">SKETCH A SCENE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q47" id="option93" value="office" onchange='updateResults("office", "business", "q47", "option93")'>
                        <label class="btn btn-outline-secondary" for="option93" id="question93">WORK PART TIME IN AN OFFICE</label>
                        <input type="radio" class="btn-check btn-secondary" name="q47" id="option94" value="business" onchange='updateResults("business", "office", "q47", "option94")'>
                        <label class="btn btn-outline-secondary" for="option94" id="question94">SELL CLOTHES IN A SHOP</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q48" id="option95" value="business" onchange='updateResults("business", "social", "q48", "option95")'>
                        <label class="btn btn-outline-secondary" for="option95" id="question95">SUPERVISE OTHERS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q48" id="option96" value="social" onchange='updateResults("social", "business", "q48", "option96")'>
                        <label class="btn btn-outline-secondary" for="option96" id="question96">HELP SICK PEOPLE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q49" id="option97" value="outdoor" onchange='updateResults("outdoor", "science", "q49", "option97")'>
                        <label class="btn btn-outline-secondary" for="option97" id="question97">SAIL A BOAT</label>
                        <input type="radio" class="btn-check btn-secondary" name="q49" id="option98" value="science" onchange='updateResults("science", "outdoor", "q49", "option98")'>
                        <label class="btn btn-outline-secondary" for="option98" id="question98">STUDY ASTRONOMY</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q50" id="option99" value="creative" onchange='updateResults("creative", "practical", "q50", "option99")'>
                        <label class="btn btn-outline-secondary" for="option99" id="question99">ACT IN A PLAY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q50" id="option100" value="practical" onchange='updateResults("practical", "creative", "q50", "option100")'>
                        <label class="btn btn-outline-secondary" for="option100" id="question100">PRINT A MAGAZINE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q51" id="option101" value="social" onchange='updateResults("social", "science", "q51", "option101")'>
                        <label class="btn btn-outline-secondary" for="option101" id="question101">INTERVIEW PEOPLE</label>
                        <input type="radio" class="btn-check btn-secondary" name="q51" id="option102" value="science" onchange='updateResults("science", "social", "q51", "option102")'>
                        <label class="btn btn-outline-secondary" for="option102" id="question102">WATCH A SCIENCE SHOW</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q52" id="option103" value="creative" onchange='updateResults("business", "creative", "q52", "option103")'>
                        <label class="btn btn-outline-secondary" for="option103" id="question103">DIRECT A PLAY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q52" id="option104" value="creative" onchange='updateResults("creative", "business", "q52", "option104")'>
                        <label class="btn btn-outline-secondary" for="option104" id="question104">COMPOSE A SONG</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q53" id="option105" value="social" onchange='updateResults("social", "practical", "q53", "option105")'>
                        <label class="btn btn-outline-secondary" for="option105" id="question105">ANSWER PEOPLE'S ENQUIRIES</label>
                        <input type="radio" class="btn-check btn-secondary" name="q53" id="option106" value="practical" onchange='updateResults("practical", "social", "q53", "option106")'>
                        <label class="btn btn-outline-secondary" for="option106" id="question106">DISMANTLE SOMETHING</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q54" id="option107" value="outdoor" onchange='updateResults("outdoor", "creative", "q54", "option107")'>
                        <label class="btn btn-outline-secondary" for="option107" id="question107">GO FISHING</label>
                        <input type="radio" class="btn-check btn-secondary" name="q54" id="option108" value="creative" onchange='updateResults("creative", "outdoor", "q54", "option108")'>
                        <label class="btn btn-outline-secondary" for="option108" id="question108">TAKE PHOTOGRAPHS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q55" id="option109" value="business" onchange='updateResults("business", "practical", "q55", "option109")'>
                        <label class="btn btn-outline-secondary" for="option109" id="question109">PREPARE ADVERTISING</label>
                        <input type="radio" class="btn-check btn-secondary" name="q55" id="option110" value="practical" onchange='updateResults("practical", "business", "q55", "option110")'>
                        <label class="btn btn-outline-secondary" for="option110" id="question110">RESTORE FURNITURE</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q56" id="option111" value="business" onchange='updateResults("business", "science", "q56", "option111")'>
                        <label class="btn btn-outline-secondary" for="option111" id="question111">ADVISE CUSTOMERS</label>
                        <input type="radio" class="btn-check btn-secondary" name="q56" id="option112" value="science" onchange='updateResults("science", "business", "q56", "option112")'>
                        <label class="btn btn-outline-secondary" for="option112" id="question112">COLLECT ROCK SAMPLES</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q57" id="option113" value="business" onchange='updateResults("business", "creative", "q57", "option113")'>
                        <label class="btn btn-outline-secondary" for="option113" id="question113">PREPARE A RESEARCH REPORT</label>
                        <input type="radio" class="btn-check btn-secondary" name="q57" id="option114" value="creative" onchange='updateResults("creative", "office", "q57", "option114")'>
                        <label class="btn btn-outline-secondary" for="option114" id="question114">WRITE A STORY</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q58" id="option115" value="outdoor" onchange='updateResults("outdoor", "social", "q58", "option115")'>
                        <label class="btn btn-outline-secondary" for="option115" id="question115">GO HIKING/BUSHWALKING</label>
                        <input type="radio" class="btn-check btn-secondary" name="q58" id="option116" value="social" onchange='updateResults("social", "outdoor", "q58", "option116")'>
                        <label class="btn btn-outline-secondary" for="option116" id="question116">PLAY SPORT</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q59" id="option117" value="office" onchange='updateResults("office", "practical", "q59", "option117")'>
                        <label class="btn btn-outline-secondary" for="option117" id="question117">BE TREASURER FOR A GROUP</label>
                        <input type="radio" class="btn-check btn-secondary" name="q59" id="option118" value="practical" onchange='updateResults("practical", "office", "q59", "option118")'>
                        <label class="btn btn-outline-secondary" for="option118" id="question118">ASSEMBLE HOBBY KITS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q60" id="option119" value="office" onchange='updateResults("office", "science", "q60", "option119")'>
                        <label class="btn btn-outline-secondary" for="option119" id="question119">HELP IN A LIBRARY</label>
                        <input type="radio" class="btn-check btn-secondary" name="q60" id="option120" value="science" onchange='updateResults("science", "office", "q60", "option120")'>
                        <label class="btn btn-outline-secondary" for="option120" id="question120">COLLECT WEATHER DETAILS</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q61" id="option121" value="outdoor" onchange='updateResults("outdoor", "business", "q61", "option121")'>
                        <label class="btn btn-outline-secondary" for="option121" id="question121">DRIVE A TRACTOR</label>
                        <input type="radio" class="btn-check btn-secondary" name="q61" id="option122" value="business" onchange='updateResults("business", "outdoor", "q61", "option122")'>
                        <label class="btn btn-outline-secondary" for="option122" id="question122">MANAGE A SHOP</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q62" id="option123" value="office" onchange='updateResults("office", "social", "q62", "option123")'>
                        <label class="btn btn-outline-secondary" for="option123" id="question123">PROGRAM A COMPUTER</label>
                        <input type="radio" class="btn-check btn-secondary" name="q62" id="option124" value="social" onchange='updateResults("social", "office", "q62", "option124")'>
                        <label class="btn btn-outline-secondary" for="option124" id="question124">TRAIN NEW STAFF</label>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group">
                        <input type="radio" class="btn-check btn-secondary" name="q63" id="option125" value="outdoor" onchange='updateResults("outdoor", "office", "q63", "option125")'>
                        <label class="btn btn-outline-secondary" for="option125" id="question125">DO SOME GARDENING</label>
                        <input type="radio" class="btn-check btn-secondary" name="q63" id="option126" value="office" onchange='updateResults("office", "outdoor", "q63", "option126")'>
                        <label class="btn btn-outline-secondary" for="option126" id="question126">TYPE SOME LETTERS</label>
                    </div>
                </div>
                <div class="btn">
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exitTestModal" class="secondary" id="pageFourExit">Exit Test</a>
                    <a href="javascript:;" onclick='changePage(3)' class="primary" id="pageFourBack">Back</a>
                    <a href="javascript:;" onclick='changePage(5)' class="primary" id="pageFourNext">Show Results</a>
                </div>
                <div class="row">
                    <div class="alert alert-danger d-none" role="alert" id="pageFourEmptyResults">
                        Please complete the questions to see Your Career Interest
                    </div>
                </div>
            </div>
        </div>

        <div id="page5" class="row">
            <div class="col-lg-12 text-center content-box" style="max-width: 1024px">
                <h1 id="pageFiveTitle">Your Career Interest</h1>
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
                <p id="pageFiveDescription1">This profile shows a graph of your interests in seven work or career activities. The highest scores show the type of activities you like best. More than one high score indicates a combination of interests. The lowest scores should also be considered since they show activities that you probably do not enjoy right now.</p>
                <div id="myChart1" class="chart" style="display: flex; justify-content: center"></div>
                <div id="myChartPrintContainer"></div>
                <p id="pageFiveDescription2">Use your two or three highest scores to help you find jobs that match your interests. Look in the classification of occupations that comes with this Career Interest Test.</p>
                <div class="btn">
                    <a href="{{asset('/files/Career Interest Result Reference.pdf')}}" target="_blank" class="secondary" id="pageFiveReference">Result Reference</a>
                    <a href="javascript:;" onclick='printPreview()' class="secondary" id="pageFiveDownload">Download Results</a>
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exitTestModal" class="primary" id="pageFiveNew">Start new Test</a>
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
            localStorage.removeItem('ckt-personNIC');
            localStorage.removeItem('ckt-personName');
            localStorage.removeItem('ckt-personInstitute');
            localStorage.removeItem('progress');
            localStorage.removeItem('results');
            localStorage.removeItem('page');
            localStorage.removeItem('completedQuestions');
            localStorage.setItem('page', 1)
            localStorage.setItem('progress', 0)
            localStorage.setItem('ckt-results-pushed', 'false');
            window.location.href = url;
        });
    })
</script>
<script type="application/javascript">
    !function(a){a.fn.zingchart=function(b){var c=this[0].id,d={id:c,height:"100%",width:"100%"};return a.extend(d,b),zingchart.render(d),this},a.fn.loadModules=function(a){return zingchart.loadModules(a),this},a.fn.addNode=function(a){return zingchart.exec(this[0].id,"addnode",a),this},a.fn.addPlot=function(a){return zingchart.exec(this[0].id,"addplot",a),this},a.fn.appendSeriesData=function(a){return zingchart.exec(this[0].id,"appendseriesdata",a),this},a.fn.appendSeriesValues=function(a){return zingchart.exec(this[0].id,"appendseriesvalues",a),this},a.fn.getSeriesData=function(a){return a?zingchart.exec(this[0].id,"getseriesdata",a):zingchart.exec(this[0].id,"getseriesdata",{})},a.fn.getSeriesValues=function(a){return a?zingchart.exec(this[0].id,"getseriesvalues",a):zingchart.exec(this[0].id,"getseriesvalues",{})},a.fn.modifyPlot=function(a){return zingchart.exec(this[0].id,"modifyplot",a),this},a.fn.removeNode=function(a){return zingchart.exec(this[0].id,"removenode",a),this},a.fn.removePlot=function(a){return zingchart.exec(this[0].id,"removeplot",a),this},a.fn.set3dView=function(a){return zingchart.exec(this[0].id,"set3dview",a),this},a.fn.setNodeValue=function(a){return zingchart.exec(this[0].id,"setnodevalue",a),this},a.fn.setSeriesData=function(a){return zingchart.exec(this[0].id,"setseriesdata",a),this},a.fn.setSeriesValues=function(a){return zingchart.exec(this[0].id,"setseriesvalues",a),this},a.fn.exportData=function(){return zingchart.exec(this[0].id,"exportdata"),this},a.fn.getImageData=function(a){if("png"==a||"jpg"==a||"bmp"==a)return zingchart.exec(this[0].id,"getimagedata",{filetype:a}),this;throw"Error: Got "+a+", expected 'png' or 'jpg' or 'bmp'"},a.fn.print=function(){return zingchart.exec(this[0].id,"print"),this},a.fn.saveAsImage=function(){return zingchart.exec(this[0].id,"saveasimage"),this},a.fn.clearFeed=function(){return zingchart.exec(this[0].id,"clearfeed"),this},a.fn.getInterval=function(){return zingchart.exec(this[0].id,"getinterval")},a.fn.setInterval=function(a){if("number"==typeof a)return zingchart.exec(this[0].id,"setinterval",{interval:a}),this;if("object"==typeof a)return zingchart.exec(this[0].id,"setinterval",a),this;throw"Error: Got "+typeof a+", expected number"},a.fn.startFeed=function(){return zingchart.exec(this[0].id,"startfeed"),this},a.fn.stopFeed=function(){return zingchart.exec(this[0].id,"stopfeed"),this},a.fn.getChartType=function(a){return a?zingchart.exec(this[0].id,"getcharttype",a):zingchart.exec(this[0].id,"getcharttype")},a.fn.getData=function(){return zingchart.exec(this[0].id,"getdata")},a.fn.getEditMode=function(){return zingchart.exec(this[0].id,"geteditmode")},a.fn.getGraphLength=function(){return zingchart.exec(this[0].id,"getgraphlength")},a.fn.getNodeLength=function(a){return a?zingchart.exec(this[0].id,"getnodelength",a):zingchart.exec(this[0].id,"getnodelength")},a.fn.getNodeValue=function(a){return zingchart.exec(this[0].id,"getnodevalue",a)},a.fn.getObjectInfo=function(a){return zingchart.exec(this[0].id,"getobjectinfo",a)},a.fn.getPlotLength=function(a){return a?zingchart.exec(this[0].id,"getplotlength",a):zingchart.exec(this[0].id,"getplotlength")},a.fn.getPlotValues=function(a){return zingchart.exec(this[0].id,"getplotvalues",a)},a.fn.getRender=function(){return zingchart.exec(this[0].id,"getrender")},a.fn.getRules=function(a){return zingchart.exec(this[0].id,"getrules",a)},a.fn.getScales=function(a){return zingchart.exec(this[0].id,"getscales",a)},a.fn.getVersion=function(){return zingchart.exec(this[0].id,"getversion")},a.fn.getXYInfo=function(a){return zingchart.exec(this[0].id,"getxyinfo",a)},a.fn.addScaleValue=function(a){return zingchart.exec(this[0].id,"addscalevalue",{dataurl:a}),this},a.fn.destroy=function(a){return a?a.hasOwnProperty(""):zingchart.exec(this[0].id,"destroy"),this},a.fn.loadNewData=function(a){return zingchart.exec(this[0].id,"load",a),this},a.fn.modify=function(a){return zingchart.exec(this[0].id,"modify",a),this},a.fn.reloadChart=function(a){return a?zingchart.exec(this[0].id,"reload",a):zingchart.exec(this[0].id,"reload"),this},a.fn.removeScaleValue=function(a){return zingchart.exec(this[0].id,"removescalevalue",a),this},a.fn.resizeChart=function(a){return zingchart.exec(this[0].id,"resize",a),this},a.fn.setData=function(a){return zingchart.exec(this[0].id,"setdata",a),this},a.fn.update=function(a){return zingchart.exec(this[0].id,"update"),this},a.fn.goBack=function(){return zingchart.exec(this[0].id,"goback"),this},a.fn.goForward=function(){return zingchart.exec(this[0].id,"goforward"),this},a.fn.addNodeIA=function(a){return a?zingchart.exec(this[0].id,"addnodeia",a):zingchart.exec(this[0].id,"addnodeia"),this},a.fn.enterEditMode=function(a){return a?zingchart.exec(this[0].id,"entereditmode",a):zingchart.exec(this[0].id,"entereditmode"),this},a.fn.exitEditMode=function(a){return a?zingchart.exec(this[0].id,"exiteditmode",a):zingchart.exec(this[0].id,"exiteditmode"),this},a.fn.removeNodeIA=function(a){return a?zingchart.exec(this[0].id,"removenodeia",a):zingchart.exec(this[0].id,"removenodeia"),this},a.fn.removePlotIA=function(a){return a?zingchart.exec(this[0].id,"removeplotia",a):zingchart.exec(this[0].id,"removeplotia"),this},a.fn.addNote=function(a){return zingchart.exec(this[0].id,"addnote",a),this},a.fn.removeNote=function(a){return zingchart.exec(this[0].id,"removenote",{id:a}),this},a.fn.updateNote=function(a){return zingchart.exec(this[0].id,"updatenote",a),this},a.fn.addObject=function(a){return zingchart.exec(this[0].id,"addobject",a),this},a.fn.removeObject=function(a){return zingchart.exec(this[0].id,"removeobject",a),this},a.fn.repaintObjects=function(a){return a?zingchart.exec(this[0].id,"repaintobjects",a):zingchart.exec(this[0].id,"repaintobjects",{}),this},a.fn.updateObject=function(a){return zingchart.exec(this[0].id,"updateobject",a),this},a.fn.addLabel=function(a){return zingchart.exec(this[0].id,"addobject",{type:"label",data:a}),this},a.fn.removeLabel=function(a){return zingchart.exec(this[0].id,"removeobject",{type:"label",id:a}),this},a.fn.updateLabel=function(a){return zingchart.exec(this[0].id,"updateobject",{type:"label",data:a}),this},a.fn.addRule=function(a){return zingchart.exec(this[0].id,"addrule",a),this},a.fn.removeRule=function(a){return zingchart.exec(this[0].id,"removerule",a),this},a.fn.updateRule=function(a){return zingchart.exec(this[0].id,"updaterule",a),this},a.fn.clearSelection=function(a){return a?zingchart.exec(this[0].id,"clearselection",a):zingchart.exec(this[0].id,"clearselection"),this},a.fn.chartDeselect=function(a){return zingchart.exec(this[0].id,"deselect",a),this},a.fn.getSelection=function(a){return a?zingchart.exec(this[0].id,"getselection",a):zingchart.exec(this[0].id,"getselection"),this},a.fn.chartSelect=function(a){return zingchart.exec(this[0].id,"select",a),this},a.fn.setSelection=function(a){return zingchart.exec(this[0].id,"setselection",a),this},a.fn.disable=function(a){return a?zingchart.exec(this[0].id,"disable",{text:a}):zingchart.exec(this[0].id,"disable"),this},a.fn.enable=function(){return zingchart.exec(this[0].id,"enable"),this},a.fn.exitFullscreen=function(){return zingchart.exec(this[0].id,"exitfullscreen"),this},a.fn.fullscreen=function(){return zingchart.exec(this[0].id,"fullscreen"),this},a.fn.hideMenu=function(){return zingchart.exec(this[0].id,"hidemenu"),this},a.fn.hidePlot=function(a){return zingchart.exec(this[0].id,"hideplot",a),this},a.fn.hideAllPlots=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid"))for(var d=0;d<c;d++)zingchart.exec(b,"hideplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)zingchart.exec(b,"hideplot",{plotindex:d});return this},a.fn.hideAllPlotsBut=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"hideplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"hideplot",{plotindex:d});return this},a.fn.modifyAllPlotsBut=function(a,b){var c=this[0].id,d=a&&a.hasOwnProperty("graphid")?zingchart.exec(c,"getplotlength",a):zingchart.exec(c,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var e=0;e<d;e++)e!=a.plotindex&&zingchart.exec(c,"modifyplot",{graphid:a.graphid,plotindex:e,data:b});else for(var e=0;e<d;e++)e!=a.plotindex&&zingchart.exec(c,"modifyplot",{plotindex:e,data:b});return this},a.fn.modifyAllPlots=function(a,b){for(var c=this[0].id,d=b?zingchart.exec(c,"getplotlength",b):zingchart.exec(c,"getplotlength"),e=0;e<d;e++)b&&b.graphid?zingchart.exec(c,"modifyplot",{graphid:b.graphid,plotindex:e,data:a}):zingchart.exec(c,"modifyplot",{plotindex:e,data:a});return this},a.fn.showAllPlots=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid"))for(var d=0;d<c;d++)zingchart.exec(b,"showplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)zingchart.exec(b,"showplot",{plotindex:d});return this},a.fn.showAllPlotsBut=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"showplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"showplot",{plotindex:d});return this},a.fn.legendMaximize=function(a){return a?zingchart.exec(this[0].id,"legendmaximize",a):zingchart.exec(this[0].id,"legendmaximize"),this},a.fn.legendMinimize=function(a){return a?zingchart.exec(this[0].id,"legendminimize",a):zingchart.exec(this[0].id,"legendminimize"),this},a.fn.showMenu=function(){return zingchart.exec(this[0].id,"showmenu"),this},a.fn.showPlot=function(a){return zingchart.exec(this[0].id,"showplot",a),this},a.fn.toggleAbout=function(){return zingchart.exec(this[0].id,"toggleabout"),this},a.fn.toggleBugReport=function(){return zingchart.exec(this[0].id,"togglebugreport"),this},a.fn.toggleDimension=function(){return zingchart.exec(this[0].id,"toggledimension"),this},a.fn.toggleLegend=function(){return zingchart.exec(this[0].id,"togglelegend"),this},a.fn.toggleSource=function(){return zingchart.exec(this[0].id,"togglesource"),this},a.fn.viewAll=function(){return zingchart.exec(this[0].id,"viewall"),this},a.fn.zoomIn=function(a){return a?zingchart.exec(this[0].id,"zoomin",a):zingchart.exec(this[0].id,"zoomin"),this},a.fn.zoomOut=function(a){return a?zingchart.exec(this[0].id,"zoomout",a):zingchart.exec(this[0].id,"zoomout"),this},a.fn.zoomTo=function(a){return zingchart.exec(this[0].id,"zoomto",a),this},a.fn.zoomToValues=function(a){return zingchart.exec(this[0].id,"zoomtovalues",a),this},a.fn.animationEnd=function(b){var c=this;return zingchart.bind(this[0].id,"animation_end",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.animationStart=function(b){var c=this;return zingchart.bind(this[0].id,"animation_start",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.animationStep=function(b){var c=this;return zingchart.bind(this[0].id,"animation_step",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartModify=function(b){var c=this;return zingchart.bind(this[0].id,"modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeAdd=function(b){var c=this;return zingchart.bind(this[0].id,"node_add",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeRemove=function(b){var c=this;return zingchart.bind(this[0].id,"node_remove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotAdd=function(b){var c=this;return zingchart.bind(this[0].id,"plot_add",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotModify=function(b){var c=this;return zingchart.bind(this[0].id,"plot_modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotRemove=function(b){var c=this;return zingchart.bind(this[0].id,"plot_remove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartReload=function(b){var c=this;return zingchart.bind(this[0].id,"reload",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dataSet=function(b){var c=this;return zingchart.bind(this[0].id,"setdata",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dataExport=function(b){var c=this;return zingchart.bind(this[0].id,"data_export",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.imageSave=function(b){var c=this;return zingchart.bind(this[0].id,"image_save",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartPrint=function(b){var c=this;return zingchart.bind(this[0].id,"print",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedClear=function(b){var c=this;return zingchart.bind(this[0].id,"feed_clear",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedIntervalModify=function(b){var c=this;return zingchart.bind(this[0].id,"feed_interval_modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedStart=function(b){var c=this;return zingchart.bind(this[0].id,"feed_start",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedStop=function(b){var c=this;return zingchart.bind(this[0].id,"feed_stop",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphClick=function(b){var c=this;return zingchart.bind(this[0].id,"click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphComplete=function(b){var c=this;return zingchart.bind(this[0].id,"complete",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphDataParse=function(b){var c=this;return zingchart.bind(this[0].id,"dataparse",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphDataReady=function(b){var c=this;return zingchart.bind(this[0].id,"dataready",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphGuideMouseMove=function(b){var c=this;return zingchart.bind(this[0].id,"guide_mousemove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphLoad=function(b){var c=this;return zingchart.bind(this[0].id,"load",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphMenuItemClick=function(b){var c=this;return zingchart.bind(this[0].id,"menu_item_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphResize=function(b){var c=this;return zingchart.bind(this[0].id,"resize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.historyForward=function(b){var c=this;return zingchart.bind(this[0].id,"history_forward",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.historyBack=function(b){var c=this;return zingchart.bind(this[0].id,"history_back",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeSelect=function(b){var c=this;return zingchart.bind(this[0].id,"node_select",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeDeselect=function(b){var c=this;return zingchart.bind(this[0].id,"node_deselect",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotSelect=function(b){var c=this;return zingchart.bind(this[0].id,"plot_select",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotDeselect=function(b){var c=this;return zingchart.bind(this[0].id,"plot_deselect",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendItemClick=function(b){var c=this;return zingchart.bind(this[0].id,"legend_item_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMarkerClick=function(b){var c=this;return zingchart.bind(this[0].id,"legend_marker_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeClick=function(b){var c=this;return zingchart.bind(this[0].id,"node_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeDoubleClick=function(b){var c=this;return zingchart.bind(this[0].id,"node_doubleclick",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"node_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"node_mouseout",function(){d=!1}),this},a.fn.nodeMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"node_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeHover=function(b,c){var d=this,e=!1;return zingchart.bind(this[0].id,"node_mouseover",function(c){e||(a.extend(d,{event:c}),e=!0,b.call(d))}),zingchart.bind(d[0].id,"node_mouseout",function(){e=!1,c.call(d)}),this},a.fn.labelClick=function(b){var c=this;return zingchart.bind(this[0].id,"label_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.labelMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"label_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"label_mouseout",function(){d=!1}),this},a.fn.labelMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"label_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.labelHover=function(b,c){return a(this).labelMouseOver(b).labelMouseOut(c),this},a.fn.shapeClick=function(b){var c=this;return zingchart.bind(this[0].id,"shape_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.shapeMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"shape_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"shape_mouseout",function(){d=!1}),this},a.fn.shapeMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"shape_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.shapeHover=function(b,c){return a(this).shapeMouseOver(b).shapeMouseOut(c),this},a.fn.plotClick=function(b){var c=this;return zingchart.bind(this[0].id,"plot_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotDoubleClick=function(b){var c=this;return zingchart.bind(this[0].id,"plot_doubleclick",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"plot_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"plot_mouseout",function(){d=!1}),this},a.fn.plotMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"plot_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotHover=function(b,c){return a(this).plotMouseOver(b).plotMouseOut(c),this},a.fn.plotShow=function(b){var c=this;return zingchart.bind(this[0].id,"plot_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotHide=function(b){var c=this;return zingchart.bind(this[0].id,"plot_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.aboutShow=function(b){var c=this;return zingchart.bind(this[0].id,"about_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.aboutHide=function(b){var c=this;return zingchart.bind(this[0].id,"about_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.bugReportShow=function(b){var c=this;return zingchart.bind(this[0].id,"bugreport_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.bugReportHide=function(b){var c=this;return zingchart.bind(this[0].id,"bugreport_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dimensionChange=function(b){var c=this;return zingchart.bind(this[0].id,"dimension_change",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.sourceShow=function(b){var c=this;return zingchart.bind(this[0].id,"source_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.sourceHide=function(b){var c=this;return zingchart.bind(this[0].id,"source_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendShow=function(b){var c=this;return zingchart.bind(this[0].id,"legend_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendHide=function(b){var c=this;return zingchart.bind(this[0].id,"legend_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMaximize=function(b){var c=this;return zingchart.bind(this[0].id,"legend_maximize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMinimize=function(b){var c=this;return zingchart.bind(this[0].id,"legend_minimize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.zoomEvent=function(b){var c=this;return zingchart.bind(this[0].id,"zoom",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.setTitle=function(a){return"object"==typeof a?zingchart.exec(this[0].id,"modify",{data:{title:a}}):zingchart.exec(this[0].id,"modify",{data:{title:{text:a}}}),this},a.fn.setSubtitle=function(a){return"object"==typeof a?zingchart.exec(this[0].id,"modify",{data:{subtitle:a}}):zingchart.exec(this[0].id,"modify",{data:{subtitle:{text:a}}}),this},a.fn.setType=function(a){return zingchart.exec(this[0].id,"modify",{data:{type:a}}),zingchart.exec(this[0].id,"update"),this},a.fn.drawTrendline=function(b){function d(c){for(var d=a(this).getSeriesValues({plotindex:c}),e=0,f=0,g=0,h=0,i=0,j=a(this).getObjectInfo({object:"scale",name:"scale-x"}),k=j.values,l=0;l<d.length;l++)d[l]&&void 0!=d[l][1]&&"number"==typeof d[l][1]?(e+=d[l][0]*d[l][1],f+=d[l][0],g+=d[l][1],h+=d[l][0]*d[l][0],i++):(e+=d[l]*k[l],f+=k[l],g+=d[l],h+=Math.pow(k[l],2),i++);var m=(i*e-f*g)/(i*h-f*f),n=(g-m*f)/i,j=a(this).getObjectInfo({object:"scale",name:"scale-x"}),k=j.values,o=k[0],p=k[k.length-1],q=[n+m*o,n+m*p],r={type:"line",lineColor:"#c00",lineWidth:2,alpha:.75,lineStyle:"dashed",label:{text:""}};b&&a.extend(r,b),r.range=q;var s=a(this).getObjectInfo({object:"scale",name:"scale-y"}),t=s.markers;t?t.push(r):t=[r],a(this).modify({data:{"scale-y":{markers:t}}})}this[0].id;return d.call(this,0),this}}(jQuery);
</script>
</body>
</html>
