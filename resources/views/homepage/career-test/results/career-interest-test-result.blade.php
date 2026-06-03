
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
    </style>
    <script type="application/javascript">
        let lang = 'en'
        if (localStorage.getItem('lang')) {
            lang = localStorage.getItem('lang')
        }

        let personName = '';
        if (localStorage.getItem('ckt-personName')) {
            personName = localStorage.getItem('ckt-personName')
        }


        let results = {
            outdoor: 0,
            practical: 0,
            science: 0,
            creative: 0,
            business: 0,
            office: 0,
            social: 0
        }

        if (localStorage.getItem('results')) {
            results = JSON.parse(localStorage.getItem('results'))
        }

        let completedQuestions = {}
        if (localStorage.getItem('completedQuestions')) {
            completedQuestions = JSON.parse(localStorage.getItem('completedQuestions'))
        }

        let translations = {
            en: {
                pageFiveTitle: 'Career Interest',
                pageFourPersonNameLabel: 'Name',
                pageFourPersonNICLabel: 'NIC number',
                pageFourPersonInstituteLabel: 'Institute',
                pageFourDateLabel: 'Date',
                pageFiveDescription1: 'This profile shows a graph of your interests in seven work or career activities. The highest scores show the type of activities you like best. More than one high score indicates a combination of interests. The lowest scores should also be considered since they show activities that you probably do not enjoy right now.',
                pageFiveDescription2: 'Use your two or three highest scores to help you find jobs that match your interests. Look in the classification of occupations that comes with this Career Interest Test.',
                pageFiveDownload: 'Download Results',
                pageFiveReference: 'Result Reference',
                chartCols: ['Outdoor', 'Practical', 'Science', 'Creative', 'Business', 'Office', 'Social']
            },
            sn: {
                pageFiveTitle: 'වෘත්තීය උනන්දුව',
                pageFourPersonNameLabel: 'නම',
                pageFourPersonNICLabel: 'NIC අංකය',
                pageFourPersonInstituteLabel: 'ආයතනය',
                pageFourDateLabel: 'දිනය',
                pageFiveDescription1: 'ඔබ වැඩිම ලකුණු ලබා ඇති කරුණු දෙක හෝ තුන ඔබේ රුචිකත්වය හා ගළපා ‍රැකියාවක් හෝ පුහුණුවක් සොයා ගැනීමේදි ප්‍රයෝජනයට ගන්න. රුචිකත්ව පැතිකඩ ඔබේ රුචිකත්ව මට්ටම් පෙන්නුම් කරන ප්‍රස්ථාරයකි.මෙහි වැඩිම ලකුණු සංඛ්‍යාවෙන් ඔබ වඩාත්ම කැමති ක්ෂේත්‍රය පෙන්වයි.එකකට වැඩි ගණනක් ඉහල ලකුණු ලබා ඇත්නම් එයින් එකිනෙකට සමාන රුචිකත්වයක් දක්වයි.',
                pageFiveDescription2: 'ඔබ බොහෝ විට සතුටක් නොලබන ක්ෂේත්‍ර සදහා ඉතා අඩු ලකුණු ලබා ඇති නිසා ඒවා ගැනද සැලකිල්ලක් දැක්වීම වැදගත්ය.',
                pageFiveDownload: 'ප්‍රථිපල බාගන්න',
                pageFiveReference: 'ප්‍රතිඵල යොමුව',
                chartCols: ['එළිමහනේ', 'ප්‍රායෝගික', 'විද්‍යාත්මක', 'නිර්මාණාත්මක', 'ව්‍යාපාරික', 'කාර්යයාල', 'මහජන සම්බන්ධතා']
            },
            tm: {
                pageFiveTitle: 'தொழில் ஆர்வம்',
                pageFourPersonNameLabel: 'பெயர்',
                pageFourPersonNICLabel: 'NIC எண்',
                pageFourPersonInstituteLabel: 'நிறுவனம்',
                pageFourDateLabel: 'தேதி',
                pageFiveDescription1: 'நீங்கள் உங்களது விருப்பத்திற்கேற்ப புள்ளியிடும் பிரிவுகள் இரண்டும்இ மூன்றும் உங்களுக்கு பிடித்தமான தொழில்களை தேடிக்கொள்ள உதவியளிக்க தொழில் ஆர்வ பரீட்சையில் உள்ள தொழிற் பிரிவுகளை கவனத்திற் கொள்ளவும்.நீங்கள் அதிகளவு விரும்பும் இரண்டு புள்ளிகளில் மூன்றினை உங்களுக்கு பிடித்தமான தொழிலினை தேடுவதற்கு பயன்படுத்திக் கொள்ளவும்.',
                pageFiveDescription2: 'நீங்கள் அதிகளவிலாக விரும்பும் புள்ளிகளின் இரு பிரிவுகளையும் மூன்றினையும் உங்களுக்கு எந்த விதத்திலும் தொழில்கள் தேட பயன்படுத்திக் கொள்ளலாம்.\n',
                pageFiveDownload: 'முடிவுகளைப் பதிவிறக்குக',
                pageFiveReference: 'முடிவு குறிப்பு',
                chartCols: ['வெளியில்', 'செயன்முறை ரீதியாக', 'விஞ்ஞான ரீதியான', 'படைப்பாற்றல் மிக்க', 'வர்த்தகம்', 'அலுவலகம்', 'மக்கள் தொடர்புகள்']
            }
        }
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
        function loadDefaults(lang, results) {
            setTimeout(function() {
                $('.loader-wrapper').fadeOut('slow')
            }, 1000)
            var lang = getLanguageFromURL();
            changeLanguage(lang)
            setResults(results)

            if (localStorage.getItem('ckt-personName')) {
                $('#personName').val(localStorage.getItem('ckt-personName'))
            }

        }

        function changeLanguage(lang) {
            localStorage.setItem('lang', lang)
            $('.top_menu a').removeClass('active')
            $('#langSelect-' + lang).addClass('active');

            for (let key in translations[lang]) {
                $('#' + key).text(translations[lang][key])
            }
            $('#resultsTableOutdoor').text(translations[localStorage.getItem('lang')]['chartCols'][0])
            $('#resultsTablePractical').text(translations[localStorage.getItem('lang')]['chartCols'][1])
            $('#resultsTableScience').text(translations[localStorage.getItem('lang')]['chartCols'][2])
            $('#resultsTableCreative').text(translations[localStorage.getItem('lang')]['chartCols'][3])
            $('#resultsTableBusiness').text(translations[localStorage.getItem('lang')]['chartCols'][4])
            $('#resultsTableOffice').text(translations[localStorage.getItem('lang')]['chartCols'][5])
            $('#resultsTableSocial').text(translations[localStorage.getItem('lang')]['chartCols'][6])
        }

        function setResults() {
            let res = {};
            res.outdoor = {{json_decode($result->result)->outdoor}};
            res.practical = {{json_decode($result->result)->practical}};
            res.science = {{json_decode($result->result)->science}};
            res.creative = {{json_decode($result->result)->creative}};
            res.business = {{json_decode($result->result)->business}};
            res.office = {{json_decode($result->result)->office}};
            res.social = {{json_decode($result->result)->social}};
            localStorage.setItem('results', JSON.stringify(res))
            let name = '{{$result->name}}'
            localStorage.setItem('ckt-personName', JSON.stringify(name))
            updateChart(res)
        }

        function updateChart(results) {
            $('#pageFourOutdoor').text(results['outdoor'])
            $('#pageFourPractical').text(results['practical'])
            $('#pageFourScience').text(results['science'])
            $('#pageFourCreative').text(results['creative'])
            $('#pageFourBusiness').text(results['business'])
            $('#pageFourOffice').text(results['office'])
            $('#pageFourSocial').text(results['social'])

            $('#myChart1').zingchart({
                data: {
                    type: 'bar',
                    plot: {
                        barWidth: 20,
                    },
                    scaleX: {
                        labels: translations[lang]['chartCols']
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
                width: '70%',
            });
        }

        function printPreview() {
            prepareChartForPrint();
            setTimeout(function() {
                window.print();
                return true;
            }, 1000);
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
            }, 1000);
        };
        window.onafterprint = function() {
            setTimeout(function() {
                $("#myChart1").show();
                $("#myChartPrintContainer").hide();
            }, 1000);
        };
    </script>
</head>
<body onload="loadDefaults(lang, results)">
<div class="loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 top_menu">
                <a id="langSelect-en" href="javascript:;" onclick='changeLanguage("en")' class="lang-select active">English</a> |
                <a id="langSelect-sn" href="javascript:;" onclick='changeLanguage("sn")' class="lang-select">සිංහල</a> |
                <a id="langSelect-tm" href="javascript:;" onclick='changeLanguage("tm")' class="lang-select">தமிழ்</a>
            </div>
        </div>

        <div id="page5" class="row">
            <div class="col-lg-12 text-center content-box" style="max-width: 1024px">
                <h1 id="pageFourTitle">Career Interest</h1>
                <p id="pageFiveDescription1">This profile shows a graph of your interests in seven work or career activities. The highest scores show the type of activities you like best. More than one high score indicates a combination of interests. The lowest scores should also be considered since they show activities that you probably do not enjoy right now.</p>
                <table class="table mt-5">
                    <tbody>
                    <tr>
                        <th scope="row" width="20%"><span id="pageFourPersonNameLabel">Name</span></th>
                        <td class="text-start"><span id="pageFourPersonName">{{$result->name}}</span></td>
                    </tr>
                    <tr>
                        <th scope="row" width="20%"><span id="pageFourPersonNICLabel">NIC</span></th>
                        <td class="text-start"><span id="pageFourPersonNIC">{{$result->nic}}</span></td>
                    </tr>
                    <tr>
                        <th scope="row" width="20%"><span id="pageFourPersonInstituteLabel">Institute</span></th>
                        <td class="text-start"><span id="pageFourPersonInstitute"></span>{{($result->institute != '') ? $result->institute->name : 'NULL'}}</td>
                    </tr>
                    <tr>
                        <th scope="row"><span id="pageFourDateLabel">Date</span></th>
                        <td class="text-start"><span id="pageFourDate"></span>{{date("Y-m-d H:i:s", strtotime($result->created_at))}}</td>
                    </tr>
                    </tbody>
                </table>
                <div id="pageFourError" class="d-none alert alert-danger" role="alert">
                    Not ready for the interpretation!
                </div>
                <h5 class="text-start ps-md-4 mt-5" id="pageFourResultsTableTitle">Career Interest Results</h5>
                <div class="table-responsive">
                    <table class="table mt-3">
                        <thead>
                        <tr>
                            <th width="14%" class="results-table-realistic" id="resultsTableOutdoor">Outdoor</th>
                            <th width="14%" class="results-table-investigative" id="resultsTablePractical">Practical</th>
                            <th width="14%" class="results-table-artistic" id="resultsTableScience">Science</th>
                            <th width="14%" class="results-table-social" id="resultsTableCreative">Creative</th>
                            <th width="14%" class="results-table-enterprising" id="resultsTableBusiness">Business</th>
                            <th width="14%" class="results-table-conventional" id="resultsTableOffice">Office</th>
                            <th width="14%" class="results-table-conventional" id="resultsTableSocial">Social</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="results-table-realistic"><span id="pageFourOutdoor"></span></td>
                            <td class="results-table-investigative"><span id="pageFourPractical"></span></td>
                            <td class="results-table-artistic"><span id="pageFourScience"></span></td>
                            <td class="results-table-social"><span id="pageFourCreative"></span></td>
                            <td class="results-table-enterprising"><span id="pageFourBusiness"></span></td>
                            <td class="results-table-conventional"><span id="pageFourOffice"></span></td>
                            <td class="results-table-conventional"><span id="pageFourSocial"></span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div id="myChart1" class="chart" style="display:flex; justify-content: center"></div>
                <div id="myChartPrintContainer"></div>
                <p id="pageFiveDescription2">Use your two or three highest scores to help you find jobs that match your interests. Look in the classification of occupations that comes with this Career Interest Test.</p>
                <div class="btn">
                    <a href="{{asset('/files/Career Interest Result Reference.pdf')}}" target="_blank" class="secondary" id="pageFiveReference">Result Reference</a>
                    <a href="javascript:;" onclick='printPreview()' class="secondary" id="pageFiveDownload">Download Results</a>
                </div>
            </div>
        </div>
    </div>
</section>


<script src="{{asset('career-test-libs/jquery-3.3.1.js')}}"></script>
<script src="{{asset('career-test-libs/bootstrap.js')}}"></script>
<script src="{{asset('career-test-libs/zingchart.js')}}"></script>
<script type="application/javascript">
    !function(a){a.fn.zingchart=function(b){var c=this[0].id,d={id:c,height:"100%",width:"100%"};return a.extend(d,b),zingchart.render(d),this},a.fn.loadModules=function(a){return zingchart.loadModules(a),this},a.fn.addNode=function(a){return zingchart.exec(this[0].id,"addnode",a),this},a.fn.addPlot=function(a){return zingchart.exec(this[0].id,"addplot",a),this},a.fn.appendSeriesData=function(a){return zingchart.exec(this[0].id,"appendseriesdata",a),this},a.fn.appendSeriesValues=function(a){return zingchart.exec(this[0].id,"appendseriesvalues",a),this},a.fn.getSeriesData=function(a){return a?zingchart.exec(this[0].id,"getseriesdata",a):zingchart.exec(this[0].id,"getseriesdata",{})},a.fn.getSeriesValues=function(a){return a?zingchart.exec(this[0].id,"getseriesvalues",a):zingchart.exec(this[0].id,"getseriesvalues",{})},a.fn.modifyPlot=function(a){return zingchart.exec(this[0].id,"modifyplot",a),this},a.fn.removeNode=function(a){return zingchart.exec(this[0].id,"removenode",a),this},a.fn.removePlot=function(a){return zingchart.exec(this[0].id,"removeplot",a),this},a.fn.set3dView=function(a){return zingchart.exec(this[0].id,"set3dview",a),this},a.fn.setNodeValue=function(a){return zingchart.exec(this[0].id,"setnodevalue",a),this},a.fn.setSeriesData=function(a){return zingchart.exec(this[0].id,"setseriesdata",a),this},a.fn.setSeriesValues=function(a){return zingchart.exec(this[0].id,"setseriesvalues",a),this},a.fn.exportData=function(){return zingchart.exec(this[0].id,"exportdata"),this},a.fn.getImageData=function(a){if("png"==a||"jpg"==a||"bmp"==a)return zingchart.exec(this[0].id,"getimagedata",{filetype:a}),this;throw"Error: Got "+a+", expected 'png' or 'jpg' or 'bmp'"},a.fn.print=function(){return zingchart.exec(this[0].id,"print"),this},a.fn.saveAsImage=function(){return zingchart.exec(this[0].id,"saveasimage"),this},a.fn.clearFeed=function(){return zingchart.exec(this[0].id,"clearfeed"),this},a.fn.getInterval=function(){return zingchart.exec(this[0].id,"getinterval")},a.fn.setInterval=function(a){if("number"==typeof a)return zingchart.exec(this[0].id,"setinterval",{interval:a}),this;if("object"==typeof a)return zingchart.exec(this[0].id,"setinterval",a),this;throw"Error: Got "+typeof a+", expected number"},a.fn.startFeed=function(){return zingchart.exec(this[0].id,"startfeed"),this},a.fn.stopFeed=function(){return zingchart.exec(this[0].id,"stopfeed"),this},a.fn.getChartType=function(a){return a?zingchart.exec(this[0].id,"getcharttype",a):zingchart.exec(this[0].id,"getcharttype")},a.fn.getData=function(){return zingchart.exec(this[0].id,"getdata")},a.fn.getEditMode=function(){return zingchart.exec(this[0].id,"geteditmode")},a.fn.getGraphLength=function(){return zingchart.exec(this[0].id,"getgraphlength")},a.fn.getNodeLength=function(a){return a?zingchart.exec(this[0].id,"getnodelength",a):zingchart.exec(this[0].id,"getnodelength")},a.fn.getNodeValue=function(a){return zingchart.exec(this[0].id,"getnodevalue",a)},a.fn.getObjectInfo=function(a){return zingchart.exec(this[0].id,"getobjectinfo",a)},a.fn.getPlotLength=function(a){return a?zingchart.exec(this[0].id,"getplotlength",a):zingchart.exec(this[0].id,"getplotlength")},a.fn.getPlotValues=function(a){return zingchart.exec(this[0].id,"getplotvalues",a)},a.fn.getRender=function(){return zingchart.exec(this[0].id,"getrender")},a.fn.getRules=function(a){return zingchart.exec(this[0].id,"getrules",a)},a.fn.getScales=function(a){return zingchart.exec(this[0].id,"getscales",a)},a.fn.getVersion=function(){return zingchart.exec(this[0].id,"getversion")},a.fn.getXYInfo=function(a){return zingchart.exec(this[0].id,"getxyinfo",a)},a.fn.addScaleValue=function(a){return zingchart.exec(this[0].id,"addscalevalue",{dataurl:a}),this},a.fn.destroy=function(a){return a?a.hasOwnProperty(""):zingchart.exec(this[0].id,"destroy"),this},a.fn.loadNewData=function(a){return zingchart.exec(this[0].id,"load",a),this},a.fn.modify=function(a){return zingchart.exec(this[0].id,"modify",a),this},a.fn.reloadChart=function(a){return a?zingchart.exec(this[0].id,"reload",a):zingchart.exec(this[0].id,"reload"),this},a.fn.removeScaleValue=function(a){return zingchart.exec(this[0].id,"removescalevalue",a),this},a.fn.resizeChart=function(a){return zingchart.exec(this[0].id,"resize",a),this},a.fn.setData=function(a){return zingchart.exec(this[0].id,"setdata",a),this},a.fn.update=function(a){return zingchart.exec(this[0].id,"update"),this},a.fn.goBack=function(){return zingchart.exec(this[0].id,"goback"),this},a.fn.goForward=function(){return zingchart.exec(this[0].id,"goforward"),this},a.fn.addNodeIA=function(a){return a?zingchart.exec(this[0].id,"addnodeia",a):zingchart.exec(this[0].id,"addnodeia"),this},a.fn.enterEditMode=function(a){return a?zingchart.exec(this[0].id,"entereditmode",a):zingchart.exec(this[0].id,"entereditmode"),this},a.fn.exitEditMode=function(a){return a?zingchart.exec(this[0].id,"exiteditmode",a):zingchart.exec(this[0].id,"exiteditmode"),this},a.fn.removeNodeIA=function(a){return a?zingchart.exec(this[0].id,"removenodeia",a):zingchart.exec(this[0].id,"removenodeia"),this},a.fn.removePlotIA=function(a){return a?zingchart.exec(this[0].id,"removeplotia",a):zingchart.exec(this[0].id,"removeplotia"),this},a.fn.addNote=function(a){return zingchart.exec(this[0].id,"addnote",a),this},a.fn.removeNote=function(a){return zingchart.exec(this[0].id,"removenote",{id:a}),this},a.fn.updateNote=function(a){return zingchart.exec(this[0].id,"updatenote",a),this},a.fn.addObject=function(a){return zingchart.exec(this[0].id,"addobject",a),this},a.fn.removeObject=function(a){return zingchart.exec(this[0].id,"removeobject",a),this},a.fn.repaintObjects=function(a){return a?zingchart.exec(this[0].id,"repaintobjects",a):zingchart.exec(this[0].id,"repaintobjects",{}),this},a.fn.updateObject=function(a){return zingchart.exec(this[0].id,"updateobject",a),this},a.fn.addLabel=function(a){return zingchart.exec(this[0].id,"addobject",{type:"label",data:a}),this},a.fn.removeLabel=function(a){return zingchart.exec(this[0].id,"removeobject",{type:"label",id:a}),this},a.fn.updateLabel=function(a){return zingchart.exec(this[0].id,"updateobject",{type:"label",data:a}),this},a.fn.addRule=function(a){return zingchart.exec(this[0].id,"addrule",a),this},a.fn.removeRule=function(a){return zingchart.exec(this[0].id,"removerule",a),this},a.fn.updateRule=function(a){return zingchart.exec(this[0].id,"updaterule",a),this},a.fn.clearSelection=function(a){return a?zingchart.exec(this[0].id,"clearselection",a):zingchart.exec(this[0].id,"clearselection"),this},a.fn.chartDeselect=function(a){return zingchart.exec(this[0].id,"deselect",a),this},a.fn.getSelection=function(a){return a?zingchart.exec(this[0].id,"getselection",a):zingchart.exec(this[0].id,"getselection"),this},a.fn.chartSelect=function(a){return zingchart.exec(this[0].id,"select",a),this},a.fn.setSelection=function(a){return zingchart.exec(this[0].id,"setselection",a),this},a.fn.disable=function(a){return a?zingchart.exec(this[0].id,"disable",{text:a}):zingchart.exec(this[0].id,"disable"),this},a.fn.enable=function(){return zingchart.exec(this[0].id,"enable"),this},a.fn.exitFullscreen=function(){return zingchart.exec(this[0].id,"exitfullscreen"),this},a.fn.fullscreen=function(){return zingchart.exec(this[0].id,"fullscreen"),this},a.fn.hideMenu=function(){return zingchart.exec(this[0].id,"hidemenu"),this},a.fn.hidePlot=function(a){return zingchart.exec(this[0].id,"hideplot",a),this},a.fn.hideAllPlots=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid"))for(var d=0;d<c;d++)zingchart.exec(b,"hideplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)zingchart.exec(b,"hideplot",{plotindex:d});return this},a.fn.hideAllPlotsBut=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"hideplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"hideplot",{plotindex:d});return this},a.fn.modifyAllPlotsBut=function(a,b){var c=this[0].id,d=a&&a.hasOwnProperty("graphid")?zingchart.exec(c,"getplotlength",a):zingchart.exec(c,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var e=0;e<d;e++)e!=a.plotindex&&zingchart.exec(c,"modifyplot",{graphid:a.graphid,plotindex:e,data:b});else for(var e=0;e<d;e++)e!=a.plotindex&&zingchart.exec(c,"modifyplot",{plotindex:e,data:b});return this},a.fn.modifyAllPlots=function(a,b){for(var c=this[0].id,d=b?zingchart.exec(c,"getplotlength",b):zingchart.exec(c,"getplotlength"),e=0;e<d;e++)b&&b.graphid?zingchart.exec(c,"modifyplot",{graphid:b.graphid,plotindex:e,data:a}):zingchart.exec(c,"modifyplot",{plotindex:e,data:a});return this},a.fn.showAllPlots=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid"))for(var d=0;d<c;d++)zingchart.exec(b,"showplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)zingchart.exec(b,"showplot",{plotindex:d});return this},a.fn.showAllPlotsBut=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"showplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"showplot",{plotindex:d});return this},a.fn.legendMaximize=function(a){return a?zingchart.exec(this[0].id,"legendmaximize",a):zingchart.exec(this[0].id,"legendmaximize"),this},a.fn.legendMinimize=function(a){return a?zingchart.exec(this[0].id,"legendminimize",a):zingchart.exec(this[0].id,"legendminimize"),this},a.fn.showMenu=function(){return zingchart.exec(this[0].id,"showmenu"),this},a.fn.showPlot=function(a){return zingchart.exec(this[0].id,"showplot",a),this},a.fn.toggleAbout=function(){return zingchart.exec(this[0].id,"toggleabout"),this},a.fn.toggleBugReport=function(){return zingchart.exec(this[0].id,"togglebugreport"),this},a.fn.toggleDimension=function(){return zingchart.exec(this[0].id,"toggledimension"),this},a.fn.toggleLegend=function(){return zingchart.exec(this[0].id,"togglelegend"),this},a.fn.toggleSource=function(){return zingchart.exec(this[0].id,"togglesource"),this},a.fn.viewAll=function(){return zingchart.exec(this[0].id,"viewall"),this},a.fn.zoomIn=function(a){return a?zingchart.exec(this[0].id,"zoomin",a):zingchart.exec(this[0].id,"zoomin"),this},a.fn.zoomOut=function(a){return a?zingchart.exec(this[0].id,"zoomout",a):zingchart.exec(this[0].id,"zoomout"),this},a.fn.zoomTo=function(a){return zingchart.exec(this[0].id,"zoomto",a),this},a.fn.zoomToValues=function(a){return zingchart.exec(this[0].id,"zoomtovalues",a),this},a.fn.animationEnd=function(b){var c=this;return zingchart.bind(this[0].id,"animation_end",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.animationStart=function(b){var c=this;return zingchart.bind(this[0].id,"animation_start",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.animationStep=function(b){var c=this;return zingchart.bind(this[0].id,"animation_step",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartModify=function(b){var c=this;return zingchart.bind(this[0].id,"modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeAdd=function(b){var c=this;return zingchart.bind(this[0].id,"node_add",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeRemove=function(b){var c=this;return zingchart.bind(this[0].id,"node_remove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotAdd=function(b){var c=this;return zingchart.bind(this[0].id,"plot_add",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotModify=function(b){var c=this;return zingchart.bind(this[0].id,"plot_modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotRemove=function(b){var c=this;return zingchart.bind(this[0].id,"plot_remove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartReload=function(b){var c=this;return zingchart.bind(this[0].id,"reload",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dataSet=function(b){var c=this;return zingchart.bind(this[0].id,"setdata",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dataExport=function(b){var c=this;return zingchart.bind(this[0].id,"data_export",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.imageSave=function(b){var c=this;return zingchart.bind(this[0].id,"image_save",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartPrint=function(b){var c=this;return zingchart.bind(this[0].id,"print",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedClear=function(b){var c=this;return zingchart.bind(this[0].id,"feed_clear",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedIntervalModify=function(b){var c=this;return zingchart.bind(this[0].id,"feed_interval_modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedStart=function(b){var c=this;return zingchart.bind(this[0].id,"feed_start",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedStop=function(b){var c=this;return zingchart.bind(this[0].id,"feed_stop",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphClick=function(b){var c=this;return zingchart.bind(this[0].id,"click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphComplete=function(b){var c=this;return zingchart.bind(this[0].id,"complete",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphDataParse=function(b){var c=this;return zingchart.bind(this[0].id,"dataparse",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphDataReady=function(b){var c=this;return zingchart.bind(this[0].id,"dataready",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphGuideMouseMove=function(b){var c=this;return zingchart.bind(this[0].id,"guide_mousemove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphLoad=function(b){var c=this;return zingchart.bind(this[0].id,"load",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphMenuItemClick=function(b){var c=this;return zingchart.bind(this[0].id,"menu_item_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphResize=function(b){var c=this;return zingchart.bind(this[0].id,"resize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.historyForward=function(b){var c=this;return zingchart.bind(this[0].id,"history_forward",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.historyBack=function(b){var c=this;return zingchart.bind(this[0].id,"history_back",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeSelect=function(b){var c=this;return zingchart.bind(this[0].id,"node_select",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeDeselect=function(b){var c=this;return zingchart.bind(this[0].id,"node_deselect",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotSelect=function(b){var c=this;return zingchart.bind(this[0].id,"plot_select",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotDeselect=function(b){var c=this;return zingchart.bind(this[0].id,"plot_deselect",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendItemClick=function(b){var c=this;return zingchart.bind(this[0].id,"legend_item_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMarkerClick=function(b){var c=this;return zingchart.bind(this[0].id,"legend_marker_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeClick=function(b){var c=this;return zingchart.bind(this[0].id,"node_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeDoubleClick=function(b){var c=this;return zingchart.bind(this[0].id,"node_doubleclick",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"node_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"node_mouseout",function(){d=!1}),this},a.fn.nodeMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"node_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeHover=function(b,c){var d=this,e=!1;return zingchart.bind(this[0].id,"node_mouseover",function(c){e||(a.extend(d,{event:c}),e=!0,b.call(d))}),zingchart.bind(d[0].id,"node_mouseout",function(){e=!1,c.call(d)}),this},a.fn.labelClick=function(b){var c=this;return zingchart.bind(this[0].id,"label_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.labelMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"label_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"label_mouseout",function(){d=!1}),this},a.fn.labelMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"label_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.labelHover=function(b,c){return a(this).labelMouseOver(b).labelMouseOut(c),this},a.fn.shapeClick=function(b){var c=this;return zingchart.bind(this[0].id,"shape_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.shapeMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"shape_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"shape_mouseout",function(){d=!1}),this},a.fn.shapeMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"shape_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.shapeHover=function(b,c){return a(this).shapeMouseOver(b).shapeMouseOut(c),this},a.fn.plotClick=function(b){var c=this;return zingchart.bind(this[0].id,"plot_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotDoubleClick=function(b){var c=this;return zingchart.bind(this[0].id,"plot_doubleclick",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"plot_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"plot_mouseout",function(){d=!1}),this},a.fn.plotMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"plot_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotHover=function(b,c){return a(this).plotMouseOver(b).plotMouseOut(c),this},a.fn.plotShow=function(b){var c=this;return zingchart.bind(this[0].id,"plot_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotHide=function(b){var c=this;return zingchart.bind(this[0].id,"plot_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.aboutShow=function(b){var c=this;return zingchart.bind(this[0].id,"about_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.aboutHide=function(b){var c=this;return zingchart.bind(this[0].id,"about_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.bugReportShow=function(b){var c=this;return zingchart.bind(this[0].id,"bugreport_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.bugReportHide=function(b){var c=this;return zingchart.bind(this[0].id,"bugreport_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dimensionChange=function(b){var c=this;return zingchart.bind(this[0].id,"dimension_change",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.sourceShow=function(b){var c=this;return zingchart.bind(this[0].id,"source_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.sourceHide=function(b){var c=this;return zingchart.bind(this[0].id,"source_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendShow=function(b){var c=this;return zingchart.bind(this[0].id,"legend_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendHide=function(b){var c=this;return zingchart.bind(this[0].id,"legend_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMaximize=function(b){var c=this;return zingchart.bind(this[0].id,"legend_maximize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMinimize=function(b){var c=this;return zingchart.bind(this[0].id,"legend_minimize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.zoomEvent=function(b){var c=this;return zingchart.bind(this[0].id,"zoom",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.setTitle=function(a){return"object"==typeof a?zingchart.exec(this[0].id,"modify",{data:{title:a}}):zingchart.exec(this[0].id,"modify",{data:{title:{text:a}}}),this},a.fn.setSubtitle=function(a){return"object"==typeof a?zingchart.exec(this[0].id,"modify",{data:{subtitle:a}}):zingchart.exec(this[0].id,"modify",{data:{subtitle:{text:a}}}),this},a.fn.setType=function(a){return zingchart.exec(this[0].id,"modify",{data:{type:a}}),zingchart.exec(this[0].id,"update"),this},a.fn.drawTrendline=function(b){function d(c){for(var d=a(this).getSeriesValues({plotindex:c}),e=0,f=0,g=0,h=0,i=0,j=a(this).getObjectInfo({object:"scale",name:"scale-x"}),k=j.values,l=0;l<d.length;l++)d[l]&&void 0!=d[l][1]&&"number"==typeof d[l][1]?(e+=d[l][0]*d[l][1],f+=d[l][0],g+=d[l][1],h+=d[l][0]*d[l][0],i++):(e+=d[l]*k[l],f+=k[l],g+=d[l],h+=Math.pow(k[l],2),i++);var m=(i*e-f*g)/(i*h-f*f),n=(g-m*f)/i,j=a(this).getObjectInfo({object:"scale",name:"scale-x"}),k=j.values,o=k[0],p=k[k.length-1],q=[n+m*o,n+m*p],r={type:"line",lineColor:"#c00",lineWidth:2,alpha:.75,lineStyle:"dashed",label:{text:""}};b&&a.extend(r,b),r.range=q;var s=a(this).getObjectInfo({object:"scale",name:"scale-y"}),t=s.markers;t?t.push(r):t=[r],a(this).modify({data:{"scale-y":{markers:t}}})}this[0].id;return d.call(this,0),this}}(jQuery);
</script>
</body>
</html>
