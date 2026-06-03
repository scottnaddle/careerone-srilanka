@extends('portfolio.layouts.master')
@section('content')
    <div class="loading hidden h-screen w-full opacity-70 z-50 absolute flex items-center justify-center w-56 h-56 border border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <div role="status">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div id="gjs" style="height:0px; overflow:hidden;"></div>
@endsection

@push('js')
    <script>



        $(document).ready(function () {
            const projectSaveEndpoint = `/trainee/career-guidance/portfolio/save-portfolio`;
            const projectLoadEndpoint = `/trainee/career-guidance/portfolio/load-portfolio/{{$id}}`;

            let editor = initializeEditor();


            editor.on('load', () => {
                addStylesheetsToIframe();
                removeDefaultPanelsAndButtons(editor);
                addCustomPanels(editor);
            });
            function initializeEditor() {
                return grapesjs.init({
                    showOffsets: 1,
                    noticeOnUnload: 0,
                    container: '#gjs',
                    height: '100%',
                    fromElement: true,
                    storageManager: {
                        type: 'remote',
                        autosave: false,
                        autoload: true,
                        stepsBeforeSave: 1,
                        options: {
                            remote: {
                                headers: {}, // Custom headers for the remote storage request
                                urlStore: projectSaveEndpoint, // Endpoint for saving
                                urlLoad: projectLoadEndpoint,  // Endpoint for loading
                                onStore: data => ({ data }),
                                onLoad: result => JSON.parse(result.data),
                            }
                        },
                    },
                    contentTypeJson: true,
                    plugins: [gTailwindcss, preset_newsletter],
                    styleManager: getStyleManagerConfig(),
                    pluginsOpts: {}
                });
            }

            function getStyleManagerConfig() {
                return {
                    sectors: [
                        { name: 'General', open: false, buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom'] },
                        { name: 'Flex', open: false, buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items', 'align-content', 'order', 'flex-basis', 'flex-grow', 'flex-shrink', 'align-self'] },
                        { name: 'Dimension', open: false, buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding'] },
                        { name: 'Typography', open: false, buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-shadow'] },
                        { name: 'Decorations', open: false, buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border', 'box-shadow', 'background'] },
                        { name: 'Extra', open: false, buildProps: ['transition', 'perspective', 'transform'] }
                    ]
                };
            }


            function addStylesheetsToIframe() {
                let iframe = $('.gjs-frame')[0];
                if (iframe) {
                    let iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

                    $('link[rel="stylesheet"]').each(function () {
                        let linkHref = $(this).attr('href');

                        $('<link>', { rel: 'stylesheet', href: linkHref }).appendTo($(iframeDoc.head));
                    });
                }
            }

            function removeDefaultPanelsAndButtons(editor) {
                let optionsPanel = editor.Panels;
                optionsPanel.removeButton('export-template');
                optionsPanel.removeButton('gjs-open-import-template');
                optionsPanel.removeButton('gjs-toggle-images');
                editor.Panels.removePanel('devices-c');

                let codeButton = optionsPanel.getButton("options", "export-template");
                let importButton = optionsPanel.getButton("options", "gjs-open-import-template");
                let toggleImageButton = optionsPanel.getButton("options", "gjs-toggle-images");
                let canvasClearButton = optionsPanel.getButton("options", "canvas-clear");

                codeButton.collection.remove(codeButton);
                importButton.collection.remove(importButton);
                toggleImageButton.collection.remove(toggleImageButton);
                canvasClearButton.collection.remove(canvasClearButton);

                //remove device panel
                editor.Panels.removePanel('devices-c')
                editor.Panels.removeButton('export-template')

                // Remove Component Settings button
                const componentSettingsButton = optionsPanel.getButton('views', 'open-tm'); // 'open-sm' is the default ID for Component Settings
                if (componentSettingsButton) {
                    componentSettingsButton.collection.remove(componentSettingsButton);
                }
                // Remove Layer Manager button
                const layerManagerButton = optionsPanel.getButton('views', 'open-layers'); // 'open-layers' is the default ID for Layer Manager
                if (layerManagerButton) {
                    layerManagerButton.collection.remove(layerManagerButton);
                }
            }

            function addCustomPanels(editor) {
                const panelManager = editor.Panels;

                // Add "Get Information" Button
                panelManager.addPanel({
                    id: 'leftPanel',
                    visible: true,
                    buttons: [
                        {
                            id: 'get-information',
                            className: 'fa fa-refresh',
                            label: ' Get my information from TVEC',
                            command: fetchTraineeInformation,
                            attributes: { title: 'Get your information from TVEC' }
                        }
                    ]
                });

                // Add "Save to Database" Button
                panelManager.addButton('options', {
                    id: 'save-db',
                    className: 'fa fa-floppy-o',
                    label: ' Save',
                    command(editor) {
                        // Get HTML and CSS content from the editor
                        let data = editor.getProjectData();
                        let html = editor.getHtml();
                        let css = editor.getCss();
                        $(".loading").removeClass('hidden');
                        // Send a POST request to save the content to the database
                        /*$.ajax({
                            url: '/trainee/career-guidance/portfolio/save-portfolio',  // Địa chỉ API
                            type: 'POST',
                            dataType: 'json',  // Dữ liệu trả về là JSON
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF Token
                            },
                            data: JSON.stringify({
                                'pid': {{$id}},
                                'data': data,
                                'html': html,
                                'css': css
                            }),
                            success: function(response) {
                                console.log(response);
                                if (response.status == 'success') {  // Kiểm tra nếu thành công
                                    showToast('Template saved successfully!', 'success', 'green');
                                    window.location.href = '/trainee/career-guidance/portfolio/my-portfolio';  // Điều hướng trang
                                } else {
                                    showToast('Failed to save template.', 'error', '#e74c3c');  // Thông báo lỗi
                                }
                            },
                            error: function(xhr, status, error) {  // Xử lý lỗi
                                console.error('Error:', error);
                                showToast('An error occurred.', 'error', '#e74c3c');
                            }
                        });*/
                        {{--let xhr = new XMLHttpRequest();--}}
                        {{--xhr.open('POST', '/trainee/career-guidance/portfolio/save-portfolio', true);--}}
                        {{--xhr.setRequestHeader('Content-Type', 'application/json');--}}
                        {{--xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));--}}

                        {{--xhr.onreadystatechange = function () {--}}
                        {{--    if (xhr.readyState === 4 && xhr.status === 200) {--}}
                        {{--        let response = JSON.parse(xhr.responseText);--}}
                        {{--        if (response.status === 'success') {--}}
                        {{--            showToast('Template saved successfully!', 'success', 'green');--}}
                        {{--            window.location.href = '/trainee/career-guidance/portfolio/my-portfolio';--}}
                        {{--        } else {--}}
                        {{--            showToast('Failed to save template.', 'error', '#e74c3c');--}}
                        {{--        }--}}
                        {{--    }--}}
                        {{--};--}}

                        {{--let datas = JSON.stringify({--}}
                        {{--    'pid': {{$id}},--}}
                        {{--    'data': data,--}}
                        {{--    'html': html,--}}
                        {{--    'css': css--}}
                        {{--});--}}

                        {{--xhr.send(datas);--}}
                        let formData = new FormData();
                        formData.append('json_data', JSON.stringify({
                            'pid': {{$id}},
                            'data': data,
                            'html': html,
                            'css': css
                        }));
                        $.ajax({
                            url: '/trainee/career-guidance/portfolio/save-portfolio',  // API URL
                            type: 'POST',
                            data: formData,  // Use FormData directly
                            processData: false,  // Prevent jQuery from processing data
                            contentType: false,  // Let FormData set the correct content type
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                            },
                            success: function(response) {
                                if (response.status === 'success') {  // Check if response is successful
                                    showToast('Template saved successfully!', 'success', 'green');
                                    window.location.href = '/trainee/career-guidance/portfolio/my-portfolio';  // Redirect
                                } else {
                                    showToast('Failed to save template.', 'error', '#e74c3c');  // Show error message
                                }
                            },
                            error: function(xhr, status, error) {  // Handle error
                                console.error('Error:', error);
                                showToast('An error occurred.', 'error', '#e74c3c');
                            }
                        });
                    },
                    attributes: { title: 'Save to Database' }
                });
            }

            async function fetchTraineeInformation() {
                $(".loading").removeClass('hidden');
                try {
                    let response = await fetch('/trainee/career-guidance/portfolio/get-my-information', { method: 'GET', headers: { 'Content-Type': 'application/json' } });

                    if (!response.ok) {
                        throw new Error('Failed to fetch data');
                    }

                    let data = await response.json();
                    displayTraineeInformation(data);

                    showToast("Your information is retrieved successfully!", "success", "green");
                } catch (error) {
                    console.error('Error:', error);
                    showToast("Failed to retrieve information.", "error", "#e74c3c");
                } finally {
                    $(".loading").addClass('hidden');
                }
            }

            function displayTraineeInformation(data) {
                let wrapper = editor.DomComponents.getWrapper();
                let traineeInfo = data.trainee_information;
                let traineeTraining = data.trainee_training_information;
                let latestTrainingInformation = data.latest_training_information;
                let skillsPassportCard = data.skills_passport_card;
                wrapper.find('#latest_training_information')[0].components(latestTrainingInformation);
                wrapper.find('#skills_passport_card')[0].components(skillsPassportCard);
                if (traineeInfo === 'No Information.') {
                    showToast("No Trainee Information From TVEC!", "info", "gray");
                } else {
                    wrapper.find('#trainee-name-heading')[0].components(`<p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${traineeInfo.full_name}</p>`);
                    wrapper.find('#trainee-name')[0].components(`<span data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${traineeInfo.full_name}</span>`);
                    wrapper.find('#trainee-email')[0].components(`<span data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${traineeInfo.email}</span>`);
                    wrapper.find('#trainee-phone')[0].components(`<span data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${traineeInfo.telephone ?? traineeInfo.mobile}</span>`);
                    wrapper.find('#trainee-address')[0].components(`<span data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${traineeInfo.contact_address}</span>`);
                }

                if (traineeTraining === 'No Information.') {
                    showToast("No Training History Information From TVEC!", "info", "gray");
                } else {
                    // Process training information
                    updateTrainingInfo(traineeTraining);

                }
            }

            function updateTrainingInfo(trainingInfo) {
                let wrapper = editor.DomComponents.getWrapper();
                let content = JSON.parse(trainingInfo.content);
                let nvq_content = JSON.parse(trainingInfo.nvq_content);
                let courseBlock = '';
                let qualificationBlock = '';

                content.forEach(item => {
                    courseBlock += buildCourseBlock(item);
                });
                nvq_content.forEach(item_nvq => {
                    qualificationBlock += buildQualificationBlock(item_nvq);
                });

                wrapper.find('#course_block')[0].components(courseBlock);
                wrapper.find('#qualification_block')[0].components(qualificationBlock);
                //Lock all tvec information
                wrapper.find('.tvec-information').forEach(component => {
                    component.set({
                        locked: true
                    })
                })

            }
            function buildCourseBlock(item) {
                let courseName = item.COURSE.COURSE_NAME
                    ? `<p draggable="false"><span class="font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">Course name: ${item.COURSE.COURSE_NAME}</span> <span class="text-sm">(${item.COURSE.START_DATE} - ${item.COURSE.END_DATE})</span></p>`
                    : `<p><span class="font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">Course name: No information</span></p>`;

                return `
        <div class="flex gap-4 items-baseline" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
            <svg width="10" height="10" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#4984F6" /></svg>
            <div class="flex flex-col gap-2">
                <p><span class="text-xl font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${item.INSTITUTE.INSTITUTE_NAME}</span> <span>(Industry sector: ${item.COURSE.INDUSTRY_SECTOR})</span></p>
                ${courseName}
            </div>
        </div>`;
            }

            function buildQualificationBlock(item) {
                return item.QUALIFICATION_NAME
                    ? `<div class="flex gap-4 items-baseline" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
                <svg width="10" height="10" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#4984F6" /></svg>
                <div class="flex flex-col gap-2">
                    <p><span class="text-xl font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${item.QUALIFICATION_NAME}</span> <span>(${item.QUALIFICATION_LEVEL})</span></p>
                    <p>${item.EFFECTIVE_DATE}</p>
                </div>
            </div>`
                    : `<div class="flex gap-4 items-baseline" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
                <svg width="10" height="10" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#4984F6" /></svg>
                <div class="flex flex-col gap-2">
                    <p><span class="text-xl font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">No NVQ qualification</span></p>
                </div>
            </div>`;
            }


            function showToast(message, type, bgColor) {
                Toastify({
                    text: message,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: bgColor,
                    duration: 3000
                }).showToast();
            }
        });

    </script>




@endpush
