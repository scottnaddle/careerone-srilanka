
<!doctype html>
<html lang="en" xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>The Career Key | National Career Guidance and counselling center</title>

    <link rel="stylesheet" href="{{asset('career-test-libs/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('career-test-libs/style2.css')}}">
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

    <script>
        let lang = 'en'
        if (localStorage.getItem('ckt-lang')) {
            lang = localStorage.getItem('ckt-lang')
        }

        let personName = '';
        if (localStorage.getItem('ckt-personName')) {
            personName = localStorage.getItem('ckt-personName')
        }

        let translations = {
            en: {
                pageFourTitle: 'Career Key',
                pageFourPersonNameLabel: 'Name',
                pageFourPersonNICLabel: 'NIC number',
                pageFourPersonInstituteLabel: 'Institute',
                pageFourDateLabel: 'Date',
                pageFourResultsTableTitle: 'Career Key Results',
                pageFourResultsTableDescription: 'According to John Holland there are 6 types of people. The maximum amount you get in your job key indicates the personality type you prefer.',
                pageFourChartTitle: 'Career Key Chart',
                chartCols: ['Realistic', 'Investigative', 'Artistic', 'Social', 'Enterprising', 'Conventional']
            },
            sn: {
                pageFourTitle: 'ඔබගේ වෘත්තීය යතුර',
                pageFourPersonNameLabel: 'නම',
                pageFourPersonNICLabel: 'NIC අංකය',
                pageFourPersonInstituteLabel: 'ආයතනය',
                pageFourDateLabel: 'දිනය',
                pageFourResultsTableTitle: 'මනෝමිතික පරීක්ෂණයේ ප්‍රතිඵලය',
                pageFourResultsTableDescription: 'ආචාර්ය ජෝන් හොලන්ඩ්ට අනුව, මිනිසුන් වර්ග 6කි. ඔබේ රැකියා යතුරෙහි ඔබ ලබාගත් වැඩිම ප්‍රමාණය දැක්වෙන්නේ ඔබ වඩාත්ම කැමති පෞරුෂ වර්ගයයි.',
                pageFourChartTitle: 'මනෝමිතික පරීක්ෂණයේ ප්‍රස්ථාරය',
                chartCols: ['යථාර්ථ නිරූපිත', 'පරීක්ෂාකාරී/සෝදිසිකාරී', 'කලාත්මක', 'සමාජීය', 'ධෛර්ය සම්පන්න', 'චාරිත්‍රානුකූල']
            },
            tm: {
                pageFourTitle: 'உங்கள் தொழில் விசை',
                pageFourPersonNameLabel: 'பெயர்',
                pageFourPersonNICLabel: 'NIC எண்',
                pageFourPersonInstituteLabel: 'நிறுவனம்',
                pageFourDateLabel: 'தேதி',
                pageFourResultsTableTitle: 'தொழில் முக்கிய முடிவுகள்',
                pageFourResultsTableDescription: 'டாக்டர் ஜோன் ஹோலான்ட் அவர்கள் மக்களினை ஆறு வகைப்படுத்துகிறார் அவையாவன. உங்களது தொழிலுக்கான திறவுகோலினில் நீங்கள் அதிக புள்ளிகளை பெற்ற துறை உங்களுக்கு விருப்பமான தனித்துவ தன்மை ஆகும்.',
                pageFourChartTitle: 'தொழில் முக்கிய விளக்கப்படம்',
                chartCols: ['யதார்த்தமானது', 'விசாரணை', 'கலை', 'சமூக', 'தொழில்முனைவு', 'வழக்கமான']
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
        function loadDefaults(lang, page, results, completedQuestions) {
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
            localStorage.setItem('ckt-lang', lang)
            $('.top_menu a').removeClass('active')
            $('#langSelect-' + lang).addClass('active');

            for (let key in translations[lang]) {
                $('#' + key).text(translations[lang][key])
            }

            $('.form-select .option1').text(translations[lang]['option1'])
            $('.form-select .option2').text(translations[lang]['option2'])
            $('.form-select .option3').text(translations[lang]['option3'])
            $('.form-select .option4').text(translations[lang]['option4'])

            $('#pageFourPersonNameLabel').text(translations[localStorage.getItem('ckt-lang')]['pageFourPersonNameLabel'])
            $('#pageFourPersonNICLabel').text(translations[localStorage.getItem('ckt-lang')]['pageFourPersonNICLabel'])
            $('#pageFourPersonInstituteLabel').text(translations[localStorage.getItem('ckt-lang')]['pageFourPersonInstituteLabel'])
            $('#pageFourDateLabel').text(translations[localStorage.getItem('ckt-lang')]['pageFourDateLabel'])

            $('#pageTwoRealistic').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][0])
            $('#pageTwoInvestigative').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][1])
            $('#pageTwoArtistic').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][2])
            $('#pageTwoSocial').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][3])
            $('#pageTwoEnterprising').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][4])
            $('#pageTwoConventional').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][5])

            $('#resultsTableRealistic').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][0])
            $('#resultsTableInvestigative').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][1])
            $('#resultsTableArtistic').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][2])
            $('#resultsTableSocial').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][3])
            $('#resultsTableEnterprising').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][4])
            $('#resultsTableConventional').text(translations[localStorage.getItem('ckt-lang')]['chartCols'][5])
        }



        function setResults() {
            let results = [];
            results['realistic'] = {{json_decode($result->result)->realistic}};
            results['investigative'] = {{json_decode($result->result)->investigative}};
            results['artistic'] = {{json_decode($result->result)->artistic}};
            results['social'] = {{json_decode($result->result)->social}};
            results['enterprising'] = {{json_decode($result->result)->enterprising}};
            results['conventional'] = {{json_decode($result->result)->conventional}};
            localStorage.setItem('ckt-results', JSON.stringify(results))
            let name = '{{$result->name}}'
            localStorage.setItem('ckt-personName', JSON.stringify(name))
            updateChart(results)
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
                        labels: translations[localStorage.getItem('ckt-lang')]['chartCols']
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
                width: '90%',
            });
        }

        function printPreview() {
            prepareChartForPrint();
            setTimeout(function() {
                window.print();
                return true;
            }, 1000);
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
            }, 1000);
        };
        window.onafterprint = function() {
            setTimeout(function() {
                $("#myChart1").show();
                $("#myChartPrintContainer").hide();
            }, 1000);
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
<body onload="loadDefaults(lang)">
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


        <div id="page4" class="row">
            <div class="col-lg-10 hide-on-print">
                <a href="{{url()->previous()}}" class="btn btn-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back</a>
            </div>
            <div class="col-lg-10 text-center content-box">
                <h1 id="pageFourTitle">Career Key</h1>
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
                        <td class="text-start"><span id="pageFourDate"></span>{{date("Y-m-d", strtotime($result->created_at))}}</td>
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
                    <div id="myChart1" class="col-lg-9 chart"></div>
                    <div id="myChartPrintContainer"></div>
                </div>
                <div class="btn hide-on-print">
                    <a href="javascript:;" onclick='printPreview()' class="secondary hide-on-print" id="pageFourDownload">Download Results</a>
                </div>
            </div>
            <div class="col-lg-10 hide-on-print">
                <a href="{{url()->previous()}}" class="btn btn-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg> Back</a>
            </div>
        </div>
    </div>
</section>


<script src="{{asset('career-test-libs/jquery-3.3.1.js')}}"></script>
<script src="{{asset('career-test-libs/bootstrap.js')}}"></script>
<script src="{{asset('career-test-libs/zingchart.js')}}"></script>
<script>
    !function(a){a.fn.zingchart=function(b){var c=this[0].id,d={id:c,height:"100%",width:"100%"};return a.extend(d,b),zingchart.render(d),this},a.fn.loadModules=function(a){return zingchart.loadModules(a),this},a.fn.addNode=function(a){return zingchart.exec(this[0].id,"addnode",a),this},a.fn.addPlot=function(a){return zingchart.exec(this[0].id,"addplot",a),this},a.fn.appendSeriesData=function(a){return zingchart.exec(this[0].id,"appendseriesdata",a),this},a.fn.appendSeriesValues=function(a){return zingchart.exec(this[0].id,"appendseriesvalues",a),this},a.fn.getSeriesData=function(a){return a?zingchart.exec(this[0].id,"getseriesdata",a):zingchart.exec(this[0].id,"getseriesdata",{})},a.fn.getSeriesValues=function(a){return a?zingchart.exec(this[0].id,"getseriesvalues",a):zingchart.exec(this[0].id,"getseriesvalues",{})},a.fn.modifyPlot=function(a){return zingchart.exec(this[0].id,"modifyplot",a),this},a.fn.removeNode=function(a){return zingchart.exec(this[0].id,"removenode",a),this},a.fn.removePlot=function(a){return zingchart.exec(this[0].id,"removeplot",a),this},a.fn.set3dView=function(a){return zingchart.exec(this[0].id,"set3dview",a),this},a.fn.setNodeValue=function(a){return zingchart.exec(this[0].id,"setnodevalue",a),this},a.fn.setSeriesData=function(a){return zingchart.exec(this[0].id,"setseriesdata",a),this},a.fn.setSeriesValues=function(a){return zingchart.exec(this[0].id,"setseriesvalues",a),this},a.fn.exportData=function(){return zingchart.exec(this[0].id,"exportdata"),this},a.fn.getImageData=function(a){if("png"==a||"jpg"==a||"bmp"==a)return zingchart.exec(this[0].id,"getimagedata",{filetype:a}),this;throw"Error: Got "+a+", expected 'png' or 'jpg' or 'bmp'"},a.fn.print=function(){return zingchart.exec(this[0].id,"print"),this},a.fn.saveAsImage=function(){return zingchart.exec(this[0].id,"saveasimage"),this},a.fn.clearFeed=function(){return zingchart.exec(this[0].id,"clearfeed"),this},a.fn.getInterval=function(){return zingchart.exec(this[0].id,"getinterval")},a.fn.setInterval=function(a){if("number"==typeof a)return zingchart.exec(this[0].id,"setinterval",{interval:a}),this;if("object"==typeof a)return zingchart.exec(this[0].id,"setinterval",a),this;throw"Error: Got "+typeof a+", expected number"},a.fn.startFeed=function(){return zingchart.exec(this[0].id,"startfeed"),this},a.fn.stopFeed=function(){return zingchart.exec(this[0].id,"stopfeed"),this},a.fn.getChartType=function(a){return a?zingchart.exec(this[0].id,"getcharttype",a):zingchart.exec(this[0].id,"getcharttype")},a.fn.getData=function(){return zingchart.exec(this[0].id,"getdata")},a.fn.getEditMode=function(){return zingchart.exec(this[0].id,"geteditmode")},a.fn.getGraphLength=function(){return zingchart.exec(this[0].id,"getgraphlength")},a.fn.getNodeLength=function(a){return a?zingchart.exec(this[0].id,"getnodelength",a):zingchart.exec(this[0].id,"getnodelength")},a.fn.getNodeValue=function(a){return zingchart.exec(this[0].id,"getnodevalue",a)},a.fn.getObjectInfo=function(a){return zingchart.exec(this[0].id,"getobjectinfo",a)},a.fn.getPlotLength=function(a){return a?zingchart.exec(this[0].id,"getplotlength",a):zingchart.exec(this[0].id,"getplotlength")},a.fn.getPlotValues=function(a){return zingchart.exec(this[0].id,"getplotvalues",a)},a.fn.getRender=function(){return zingchart.exec(this[0].id,"getrender")},a.fn.getRules=function(a){return zingchart.exec(this[0].id,"getrules",a)},a.fn.getScales=function(a){return zingchart.exec(this[0].id,"getscales",a)},a.fn.getVersion=function(){return zingchart.exec(this[0].id,"getversion")},a.fn.getXYInfo=function(a){return zingchart.exec(this[0].id,"getxyinfo",a)},a.fn.addScaleValue=function(a){return zingchart.exec(this[0].id,"addscalevalue",{dataurl:a}),this},a.fn.destroy=function(a){return a?a.hasOwnProperty(""):zingchart.exec(this[0].id,"destroy"),this},a.fn.loadNewData=function(a){return zingchart.exec(this[0].id,"load",a),this},a.fn.modify=function(a){return zingchart.exec(this[0].id,"modify",a),this},a.fn.reloadChart=function(a){return a?zingchart.exec(this[0].id,"reload",a):zingchart.exec(this[0].id,"reload"),this},a.fn.removeScaleValue=function(a){return zingchart.exec(this[0].id,"removescalevalue",a),this},a.fn.resizeChart=function(a){return zingchart.exec(this[0].id,"resize",a),this},a.fn.setData=function(a){return zingchart.exec(this[0].id,"setdata",a),this},a.fn.update=function(a){return zingchart.exec(this[0].id,"update"),this},a.fn.goBack=function(){return zingchart.exec(this[0].id,"goback"),this},a.fn.goForward=function(){return zingchart.exec(this[0].id,"goforward"),this},a.fn.addNodeIA=function(a){return a?zingchart.exec(this[0].id,"addnodeia",a):zingchart.exec(this[0].id,"addnodeia"),this},a.fn.enterEditMode=function(a){return a?zingchart.exec(this[0].id,"entereditmode",a):zingchart.exec(this[0].id,"entereditmode"),this},a.fn.exitEditMode=function(a){return a?zingchart.exec(this[0].id,"exiteditmode",a):zingchart.exec(this[0].id,"exiteditmode"),this},a.fn.removeNodeIA=function(a){return a?zingchart.exec(this[0].id,"removenodeia",a):zingchart.exec(this[0].id,"removenodeia"),this},a.fn.removePlotIA=function(a){return a?zingchart.exec(this[0].id,"removeplotia",a):zingchart.exec(this[0].id,"removeplotia"),this},a.fn.addNote=function(a){return zingchart.exec(this[0].id,"addnote",a),this},a.fn.removeNote=function(a){return zingchart.exec(this[0].id,"removenote",{id:a}),this},a.fn.updateNote=function(a){return zingchart.exec(this[0].id,"updatenote",a),this},a.fn.addObject=function(a){return zingchart.exec(this[0].id,"addobject",a),this},a.fn.removeObject=function(a){return zingchart.exec(this[0].id,"removeobject",a),this},a.fn.repaintObjects=function(a){return a?zingchart.exec(this[0].id,"repaintobjects",a):zingchart.exec(this[0].id,"repaintobjects",{}),this},a.fn.updateObject=function(a){return zingchart.exec(this[0].id,"updateobject",a),this},a.fn.addLabel=function(a){return zingchart.exec(this[0].id,"addobject",{type:"label",data:a}),this},a.fn.removeLabel=function(a){return zingchart.exec(this[0].id,"removeobject",{type:"label",id:a}),this},a.fn.updateLabel=function(a){return zingchart.exec(this[0].id,"updateobject",{type:"label",data:a}),this},a.fn.addRule=function(a){return zingchart.exec(this[0].id,"addrule",a),this},a.fn.removeRule=function(a){return zingchart.exec(this[0].id,"removerule",a),this},a.fn.updateRule=function(a){return zingchart.exec(this[0].id,"updaterule",a),this},a.fn.clearSelection=function(a){return a?zingchart.exec(this[0].id,"clearselection",a):zingchart.exec(this[0].id,"clearselection"),this},a.fn.chartDeselect=function(a){return zingchart.exec(this[0].id,"deselect",a),this},a.fn.getSelection=function(a){return a?zingchart.exec(this[0].id,"getselection",a):zingchart.exec(this[0].id,"getselection"),this},a.fn.chartSelect=function(a){return zingchart.exec(this[0].id,"select",a),this},a.fn.setSelection=function(a){return zingchart.exec(this[0].id,"setselection",a),this},a.fn.disable=function(a){return a?zingchart.exec(this[0].id,"disable",{text:a}):zingchart.exec(this[0].id,"disable"),this},a.fn.enable=function(){return zingchart.exec(this[0].id,"enable"),this},a.fn.exitFullscreen=function(){return zingchart.exec(this[0].id,"exitfullscreen"),this},a.fn.fullscreen=function(){return zingchart.exec(this[0].id,"fullscreen"),this},a.fn.hideMenu=function(){return zingchart.exec(this[0].id,"hidemenu"),this},a.fn.hidePlot=function(a){return zingchart.exec(this[0].id,"hideplot",a),this},a.fn.hideAllPlots=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid"))for(var d=0;d<c;d++)zingchart.exec(b,"hideplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)zingchart.exec(b,"hideplot",{plotindex:d});return this},a.fn.hideAllPlotsBut=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"hideplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"hideplot",{plotindex:d});return this},a.fn.modifyAllPlotsBut=function(a,b){var c=this[0].id,d=a&&a.hasOwnProperty("graphid")?zingchart.exec(c,"getplotlength",a):zingchart.exec(c,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var e=0;e<d;e++)e!=a.plotindex&&zingchart.exec(c,"modifyplot",{graphid:a.graphid,plotindex:e,data:b});else for(var e=0;e<d;e++)e!=a.plotindex&&zingchart.exec(c,"modifyplot",{plotindex:e,data:b});return this},a.fn.modifyAllPlots=function(a,b){for(var c=this[0].id,d=b?zingchart.exec(c,"getplotlength",b):zingchart.exec(c,"getplotlength"),e=0;e<d;e++)b&&b.graphid?zingchart.exec(c,"modifyplot",{graphid:b.graphid,plotindex:e,data:a}):zingchart.exec(c,"modifyplot",{plotindex:e,data:a});return this},a.fn.showAllPlots=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid"))for(var d=0;d<c;d++)zingchart.exec(b,"showplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)zingchart.exec(b,"showplot",{plotindex:d});return this},a.fn.showAllPlotsBut=function(a){var b=this[0].id,c=a&&a.hasOwnProperty("graphid")?zingchart.exec(b,"getplotlength",a):zingchart.exec(b,"getplotlength");if(a&&a.hasOwnProperty("graphid")&&a.hasOwnProperty("plotindex"))for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"showplot",{graphid:a.graphid,plotindex:d});else for(var d=0;d<c;d++)d!=a.plotindex&&zingchart.exec(b,"showplot",{plotindex:d});return this},a.fn.legendMaximize=function(a){return a?zingchart.exec(this[0].id,"legendmaximize",a):zingchart.exec(this[0].id,"legendmaximize"),this},a.fn.legendMinimize=function(a){return a?zingchart.exec(this[0].id,"legendminimize",a):zingchart.exec(this[0].id,"legendminimize"),this},a.fn.showMenu=function(){return zingchart.exec(this[0].id,"showmenu"),this},a.fn.showPlot=function(a){return zingchart.exec(this[0].id,"showplot",a),this},a.fn.toggleAbout=function(){return zingchart.exec(this[0].id,"toggleabout"),this},a.fn.toggleBugReport=function(){return zingchart.exec(this[0].id,"togglebugreport"),this},a.fn.toggleDimension=function(){return zingchart.exec(this[0].id,"toggledimension"),this},a.fn.toggleLegend=function(){return zingchart.exec(this[0].id,"togglelegend"),this},a.fn.toggleSource=function(){return zingchart.exec(this[0].id,"togglesource"),this},a.fn.viewAll=function(){return zingchart.exec(this[0].id,"viewall"),this},a.fn.zoomIn=function(a){return a?zingchart.exec(this[0].id,"zoomin",a):zingchart.exec(this[0].id,"zoomin"),this},a.fn.zoomOut=function(a){return a?zingchart.exec(this[0].id,"zoomout",a):zingchart.exec(this[0].id,"zoomout"),this},a.fn.zoomTo=function(a){return zingchart.exec(this[0].id,"zoomto",a),this},a.fn.zoomToValues=function(a){return zingchart.exec(this[0].id,"zoomtovalues",a),this},a.fn.animationEnd=function(b){var c=this;return zingchart.bind(this[0].id,"animation_end",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.animationStart=function(b){var c=this;return zingchart.bind(this[0].id,"animation_start",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.animationStep=function(b){var c=this;return zingchart.bind(this[0].id,"animation_step",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartModify=function(b){var c=this;return zingchart.bind(this[0].id,"modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeAdd=function(b){var c=this;return zingchart.bind(this[0].id,"node_add",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeRemove=function(b){var c=this;return zingchart.bind(this[0].id,"node_remove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotAdd=function(b){var c=this;return zingchart.bind(this[0].id,"plot_add",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotModify=function(b){var c=this;return zingchart.bind(this[0].id,"plot_modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotRemove=function(b){var c=this;return zingchart.bind(this[0].id,"plot_remove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartReload=function(b){var c=this;return zingchart.bind(this[0].id,"reload",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dataSet=function(b){var c=this;return zingchart.bind(this[0].id,"setdata",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dataExport=function(b){var c=this;return zingchart.bind(this[0].id,"data_export",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.imageSave=function(b){var c=this;return zingchart.bind(this[0].id,"image_save",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.chartPrint=function(b){var c=this;return zingchart.bind(this[0].id,"print",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedClear=function(b){var c=this;return zingchart.bind(this[0].id,"feed_clear",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedIntervalModify=function(b){var c=this;return zingchart.bind(this[0].id,"feed_interval_modify",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedStart=function(b){var c=this;return zingchart.bind(this[0].id,"feed_start",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.feedStop=function(b){var c=this;return zingchart.bind(this[0].id,"feed_stop",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphClick=function(b){var c=this;return zingchart.bind(this[0].id,"click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphComplete=function(b){var c=this;return zingchart.bind(this[0].id,"complete",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphDataParse=function(b){var c=this;return zingchart.bind(this[0].id,"dataparse",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphDataReady=function(b){var c=this;return zingchart.bind(this[0].id,"dataready",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphGuideMouseMove=function(b){var c=this;return zingchart.bind(this[0].id,"guide_mousemove",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphLoad=function(b){var c=this;return zingchart.bind(this[0].id,"load",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphMenuItemClick=function(b){var c=this;return zingchart.bind(this[0].id,"menu_item_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.graphResize=function(b){var c=this;return zingchart.bind(this[0].id,"resize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.historyForward=function(b){var c=this;return zingchart.bind(this[0].id,"history_forward",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.historyBack=function(b){var c=this;return zingchart.bind(this[0].id,"history_back",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeSelect=function(b){var c=this;return zingchart.bind(this[0].id,"node_select",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeDeselect=function(b){var c=this;return zingchart.bind(this[0].id,"node_deselect",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotSelect=function(b){var c=this;return zingchart.bind(this[0].id,"plot_select",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotDeselect=function(b){var c=this;return zingchart.bind(this[0].id,"plot_deselect",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendItemClick=function(b){var c=this;return zingchart.bind(this[0].id,"legend_item_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMarkerClick=function(b){var c=this;return zingchart.bind(this[0].id,"legend_marker_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeClick=function(b){var c=this;return zingchart.bind(this[0].id,"node_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeDoubleClick=function(b){var c=this;return zingchart.bind(this[0].id,"node_doubleclick",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"node_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"node_mouseout",function(){d=!1}),this},a.fn.nodeMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"node_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.nodeHover=function(b,c){var d=this,e=!1;return zingchart.bind(this[0].id,"node_mouseover",function(c){e||(a.extend(d,{event:c}),e=!0,b.call(d))}),zingchart.bind(d[0].id,"node_mouseout",function(){e=!1,c.call(d)}),this},a.fn.labelClick=function(b){var c=this;return zingchart.bind(this[0].id,"label_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.labelMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"label_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"label_mouseout",function(){d=!1}),this},a.fn.labelMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"label_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.labelHover=function(b,c){return a(this).labelMouseOver(b).labelMouseOut(c),this},a.fn.shapeClick=function(b){var c=this;return zingchart.bind(this[0].id,"shape_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.shapeMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"shape_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"shape_mouseout",function(){d=!1}),this},a.fn.shapeMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"shape_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.shapeHover=function(b,c){return a(this).shapeMouseOver(b).shapeMouseOut(c),this},a.fn.plotClick=function(b){var c=this;return zingchart.bind(this[0].id,"plot_click",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotDoubleClick=function(b){var c=this;return zingchart.bind(this[0].id,"plot_doubleclick",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotMouseOver=function(b){var c=this,d=!1;return zingchart.bind(this[0].id,"plot_mouseover",function(e){d||(a.extend(c,{event:e}),d=!0,b.call(c))}),zingchart.bind(c[0].id,"plot_mouseout",function(){d=!1}),this},a.fn.plotMouseOut=function(b){var c=this;return zingchart.bind(this[0].id,"plot_mouseout",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotHover=function(b,c){return a(this).plotMouseOver(b).plotMouseOut(c),this},a.fn.plotShow=function(b){var c=this;return zingchart.bind(this[0].id,"plot_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.plotHide=function(b){var c=this;return zingchart.bind(this[0].id,"plot_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.aboutShow=function(b){var c=this;return zingchart.bind(this[0].id,"about_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.aboutHide=function(b){var c=this;return zingchart.bind(this[0].id,"about_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.bugReportShow=function(b){var c=this;return zingchart.bind(this[0].id,"bugreport_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.bugReportHide=function(b){var c=this;return zingchart.bind(this[0].id,"bugreport_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.dimensionChange=function(b){var c=this;return zingchart.bind(this[0].id,"dimension_change",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.sourceShow=function(b){var c=this;return zingchart.bind(this[0].id,"source_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.sourceHide=function(b){var c=this;return zingchart.bind(this[0].id,"source_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendShow=function(b){var c=this;return zingchart.bind(this[0].id,"legend_show",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendHide=function(b){var c=this;return zingchart.bind(this[0].id,"legend_hide",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMaximize=function(b){var c=this;return zingchart.bind(this[0].id,"legend_maximize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.legendMinimize=function(b){var c=this;return zingchart.bind(this[0].id,"legend_minimize",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.zoomEvent=function(b){var c=this;return zingchart.bind(this[0].id,"zoom",function(d){a.extend(c,{event:d}),b.call(c)}),this},a.fn.setTitle=function(a){return"object"==typeof a?zingchart.exec(this[0].id,"modify",{data:{title:a}}):zingchart.exec(this[0].id,"modify",{data:{title:{text:a}}}),this},a.fn.setSubtitle=function(a){return"object"==typeof a?zingchart.exec(this[0].id,"modify",{data:{subtitle:a}}):zingchart.exec(this[0].id,"modify",{data:{subtitle:{text:a}}}),this},a.fn.setType=function(a){return zingchart.exec(this[0].id,"modify",{data:{type:a}}),zingchart.exec(this[0].id,"update"),this},a.fn.drawTrendline=function(b){function d(c){for(var d=a(this).getSeriesValues({plotindex:c}),e=0,f=0,g=0,h=0,i=0,j=a(this).getObjectInfo({object:"scale",name:"scale-x"}),k=j.values,l=0;l<d.length;l++)d[l]&&void 0!=d[l][1]&&"number"==typeof d[l][1]?(e+=d[l][0]*d[l][1],f+=d[l][0],g+=d[l][1],h+=d[l][0]*d[l][0],i++):(e+=d[l]*k[l],f+=k[l],g+=d[l],h+=Math.pow(k[l],2),i++);var m=(i*e-f*g)/(i*h-f*f),n=(g-m*f)/i,j=a(this).getObjectInfo({object:"scale",name:"scale-x"}),k=j.values,o=k[0],p=k[k.length-1],q=[n+m*o,n+m*p],r={type:"line",lineColor:"#c00",lineWidth:2,alpha:.75,lineStyle:"dashed",label:{text:""}};b&&a.extend(r,b),r.range=q;var s=a(this).getObjectInfo({object:"scale",name:"scale-y"}),t=s.markers;t?t.push(r):t=[r],a(this).modify({data:{"scale-y":{markers:t}}})}this[0].id;return d.call(this,0),this}}(jQuery);
</script>
<script src="{{asset('career-test-libs/career-key-kit-loader-lib.js')}}"></script>
</body>
</html>
