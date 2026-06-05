// $(document).ready(function (){
//     const projectID = Math.floor(Math.random() * 100);
//     const projectSaveEndpoint = `/trainee/career-guidance/portfolio/save-portfolio/${projectID}`;
//     const projectLoadEndpoint = `/trainee/career-guidance/portfolio/load-portfolio`;
//     let editor = grapesjs.init({
//         showOffsets: 1,
//         noticeOnUnload: 0,
//         container: '#gjs',
//         height: '100%',
//         fromElement: true,
//         storageManager: {
//             type: 'remote',
//             autosave: false,
//             autoload: false,
//             stepsBeforeSave: 1,
//             options: {
//                 remote: {
//                     headers: {}, // Custom headers for the remote storage request
//                     urlStore: projectSaveEndpoint, // Endpoint for saving
//                     urlLoad: projectLoadEndpoint,  // Endpoint for loading
//                     onStore: data => ({ id: projectID, data }),
//                     // onLoad: result => JSON.parse(result.data),
//                 }
//             },
//         },
//         contentTypeJson: true,
//         plugins: [gTailwindcss, preset_newsletter],
//         styleManager: {
//             sectors: [{
//                 name: 'General',
//                 open: false,
//                 buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
//             }, {
//                 name: 'Flex',
//                 open: false,
//                 buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items', 'align-content', 'order', 'flex-basis', 'flex-grow', 'flex-shrink', 'align-self']
//             }, {
//                 name: 'Dimension',
//                 open: false,
//                 buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding'],
//             }, {
//                 name: 'Typography',
//                 open: false,
//                 buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-shadow'],
//             }, {
//                 name: 'Decorations',
//                 open: false,
//                 buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border', 'box-shadow', 'background'],
//             }, {
//                 name: 'Extra',
//                 open: false,
//                 buildProps: ['transition', 'perspective', 'transform'],
//             }
//             ],
//         },
//         pluginsOpts: {}
//     });
//     fetch('/portfolio/templates/basic.html')
//         .then(response => response.text())
//         .then(html => {
//             // Load the fetched HTML into the GrapesJS editor
//             editor.setComponents(html);
//         })
//         .catch(err => console.error('Error loading HTML file:', err));
//
//
//
//
//     editor.on('load', () => {
//         var iframe = $('.gjs-frame')[0];
//         if(iframe != undefined) {
//             var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
//
//             // Get all link tags with rel="stylesheet" from the parent document
//             $('link[rel="stylesheet"]').each(function() {
//                 var linkHref = $(this).attr('href');  // Get the href of the stylesheet
//
//                 // Create a new link element in the iframe
//                 var $iframeLink = $('<link>', {
//                     rel: 'stylesheet',
//                     href: linkHref
//                 });
//
//                 // Append the new link tag to the iframe's head
//                 $($iframeLink).appendTo($(iframeDoc.head));
//             });
//         }
//
//
//         let codeButton = editor.Panels.getButton("options", "export-template");
//         let importButton = editor.Panels.getButton("options", "gjs-open-import-template");
//         let toggleImageButton = editor.Panels.getButton("options", "gjs-toggle-images");
//
//         codeButton.collection.remove(codeButton);
//         importButton.collection.remove(importButton);
//         toggleImageButton.collection.remove(toggleImageButton);
//
//         //remove device panel
//         editor.Panels.removePanel('devices-c')
//         editor.Panels.removeButton('export-template')
//         const panelManager = editor.Panels; // Reference to the panel manager
//
//         // Create a new panel with a button
//         const newPanel = panelManager.addPanel({
//             id: 'leftPanel', // Unique panel ID
//             visible: true,   // Make the panel visible
//             buttons: [
//                 {
//                     id: 'get-information',       // Button ID
//                     className: 'fa fa-refresh',   // FontAwesome icon class (optional)
//                     label: ' Get my information from TVEC',  // Button label
//                     command() {                   // Command that runs on button click
//                         $(".loading").removeClass('hidden');
//
//                         // Perform GET request to the endpoint
//                         fetch('/trainee/career-guidance/portfolio/get-my-information', {
//                             method: 'GET',
//                             headers: {
//                                 'Content-Type': 'application/json',
//                             },
//                         })
//                             .then(response => {
//                                 // Check if the response is successful
//                                 if (response.ok) {
//                                     // Return the JSON data so it can be processed in the next then()
//                                     return response.json();
//                                 } else {
//                                     // If response is not ok, show an error toast
//                                     Toastify({
//                                         text: "Failed to get Information from TVEC",
//                                         duration: 2000,
//                                         className: "error",
//                                         style: {
//                                             background: "#e74c3c",
//                                         }
//                                     }).showToast();
//                                     // Reject the promise to skip the next then() block
//                                     throw new Error('Failed to fetch data');
//                                 }
//                             })
//                             .then(data => {
//                                 // Get the wrapper and find the component where you want to display the data
//                                 let wrapper = editor.DomComponents.getWrapper();
//                                 // Process the data received from the API
//                                 let result = data;
//                                 let trainee_information = result.trainee_information;
//                                 let trainee_training_information = result.trainee_training_information;
//                                 if (trainee_information == 'No Information.') { //Empty basic information
//                                     // Display a message if no information is found
//                                     Toastify({
//                                         text: "No Trainee Information From TVEC!",
//                                         duration: 5000,
//                                         className: "info",
//                                         style: {
//                                             background: "gray",
//                                         }
//                                     }).showToast();
//                                 }else {
//                                     wrapper.find('#trainee-name-heading')[0].components(`<p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false" id="trainee-name-heading">`+trainee_information.full_name+`</p>`);
//                                     wrapper.find('#trainee-name')[0].components(trainee_information.full_name);
//                                     wrapper.find('#trainee-email')[0].components(trainee_information.email);
//                                     wrapper.find('#trainee-phone')[0].components(trainee_information.telephone ?? trainee_information.mobile);
//                                     wrapper.find('#trainee-address')[0].components(trainee_information.contact_address);
//                                 }
//                                 if (trainee_training_information === 'No Information.') { //Empty training information
//                                     // Display a message if no information is found
//                                     Toastify({
//                                         text: "No Training History Information From TVEC!",
//                                         duration: 5000,
//                                         className: "info",
//                                         style: {
//                                             background: "gray",
//                                         }
//                                     }).showToast();
//                                 } else {
//                                     //Perform trainee training course and certificate
//                                     let content = JSON.parse(trainee_training_information.content);
//                                     let course_block = ``;
//                                     let qualification_block = ``;
//                                     for (let i = 0; i < content.length; i++) {
//                                         let courseName = (content[i].COURSE.COURSE_NAME != null) ? `
//                                                 <p>
//                                                     <span class="text-[#91919A] dark:text-white font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">Course name: `+content[i].COURSE.COURSE_NAME+` </span>
//                                                     <span class="text-[#91919A] dark:text-white text-sm" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">(`+content[i].COURSE.START_DATE+` - `+content[i].COURSE.END_DATE+`)</span>
//                                                 </p>
//                                     ` : `<p>
//                                                     <span class="text-[#91919A] dark:text-white font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">Course name: No information </span>
//                                                 </p>
//                                     `;
//                                         course_block += `
//                                         <div class="flex gap-4 items-baseline" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
//                                             <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
//                                                 <circle cx="5" cy="5" r="5" fill="#4984F6" />
//                                             </svg>
//                                             <div class="flex flex-col gap-2" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
//                                                 <p data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
//                                                     <span class="text-[#464559] text-xl font-semibold dark:text-white" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">`+content[i].INSTITUTE.INSTITUTE_NAME+` </span>
//                                                     <span class="text-[#706F81]  dark:text-white" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false"> (Industry sector: `+content[i].COURSE.INDUSTRY_SECTOR+`)</span>
//                                                 </p>
//                                                 ${courseName}
//                                             </div>
//                                         </div>`;
//
//                                         if (content[i].NVQ_QUALIFICATION.QUALIFICATION_NAME != null) {
//                                             qualification_block += `
//                                             <div class="flex gap-4 items-baseline"  data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
//                                                 <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
//                                                     <circle cx="5" cy="5" r="5" fill="#4984F6" />
//                                                 </svg>
//                                                 <div class="flex flex-col gap-2" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
//                                                     <p>
//                                                         <span class="text-[#464559] text-xl font-semibold dark:text-white" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">`+content[i].NVQ_QUALIFICATION.QUALIFICATION_NAME+`</span>
//                                                         <span class="text-[#706F81] dark:text-white" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false"> (`+content[i].NVQ_QUALIFICATION.QUALIFICATION_LEVEL+`)</span>
//                                                     </p>
//                                                     <p  data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
//                                                         <span class="text-[#91919A] dark:text-white" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">`+content[i].NVQ_QUALIFICATION.EFFECTIVE_DATE+`</span>
//                                                     </p>
//                                                 </div>
//                                             </div>
//                                         `;
//                                         }else {
//                                             qualification_block += `
//                                             <div class="flex gap-4 items-baseline">
//                                                 <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
//                                                     <circle cx="5" cy="5" r="5" fill="#4984F6" />
//                                                 </svg>
//                                                 <div class="flex flex-col gap-2">
//                                                     <p>
//                                                         <span class="text-[#464559] text-xl font-semibold dark:text-white" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">No Information.</span>
//                                                     </p>
//                                                 </div>
//                                             </div>
//                                         `;
//                                         }
//
//                                     }
//                                     wrapper.find('#course_block')[0].components(course_block);
//                                     wrapper.find('#qualification_block')[0].components(qualification_block);
//                                     Toastify({
//                                         text: "Your information is retrieved successfully!",
//                                         duration: 5000,
//                                         className: "success",
//                                         style: {
//                                             background: "green",
//                                         }
//                                     }).showToast();
//                                 }
//
//                                 // Hide the loading spinner
//                                 $(".loading").addClass('hidden');
//                             })
//                             .catch(error => {
//                                 console.error('Error:', error);
//                                 Toastify({
//                                     text: "Failed to retrieve information.",
//                                     duration: 2000,
//                                     className: "error",
//                                     style: {
//                                         background: "#e74c3c",
//                                     }
//                                 }).showToast();
//                                 // Hide the loading spinner
//                                 $(".loading").addClass('hidden');
//                             });
//                     },
//                     attributes: {
//                         title: 'Get your information from TVEC'  // Tooltip for the button
//                     }
//                 }
//             ]
//
//         });
//
//         editor.Panels.addButton('options', { // Add a new button to the 'options' panel
//             id: 'save-db',
//             className: 'fa fa-floppy-o',
//             label: ' Save',
//             command(editor) {
//                 // Get HTML and CSS content from the editor
//                 let data = editor.getProjectData();
//                 let html = editor.getHtml();
//                 let css = editor.getCss();
//                 $(".loading").removeClass('hidden');
//                 // Send a POST request to save the content to the database
//                 fetch('/trainee/career-guidance/portfolio/save-portfolio', {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/json',
//                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
//                     },
//                     body: JSON.stringify({
//                         'data' : data,
//                         'html' : html,
//                         'css' : css
//                     })
//                 }).then(response => {
//                     if (response.ok) {
//                         $(".loading").addClass('hidden');
//                         Toastify({
//                             text: "Template saved successfully!",
//                             duration: 5000,
//                             className: "success",
//                             style: {
//                                 background: "green",
//                             }
//                         }).showToast();
//                         window.location.href = '/trainee/career-guidance/portfolio/my-portfolio'
//                     } else {
//                         Toastify({
//                             text: "Failed to save template.",
//                             duration: 2000,
//                             className: "error",
//                             style: {
//                                 background: "#e74c3c",
//                             }
//                         }).showToast();
//                     }
//                 }).catch(error => {
//                     console.error('Error:', error);
//                 });
//             },
//             attributes: {
//                 title: 'Save to Database'
//             }
//         });
//
//     });
//
//
// });

$(document).ready(function () {
    const projectID = Math.floor(Math.random() * 100);
    const projectSaveEndpoint = `/trainee/career-guidance/portfolio/save-portfolio/${projectID}`;
    const projectLoadEndpoint = `/trainee/career-guidance/portfolio/load-portfolio`;

    let editor = initializeEditor();

    // Load HTML template
    fetchHTMLTemplate('/portfolio/templates/basic.html');

    editor.on('load', () => {
        addStylesheetsToIframe();
        removeDefaultPanelsAndButtons(editor);
        addCustomPanels(editor);
    });
    editor.on('component:selected', (model) => {
        let selectedComponent = editor.getSelected();
        if (selectedComponent) {
            let classes = [];
            for(let i = 0; i < selectedComponent.parents().length; i++) {
                if (selectedComponent.parents()[i].getClasses().includes('example-information')) {
                    selectedComponent.parents()[i].removeClass('example-information');
                }
                classes = classes.concat(selectedComponent.parents()[i].getClasses());
            }
            classes = classes.concat(selectedComponent.getClasses());
            // let classes = selectedComponent.getClasses();
            if (classes.includes('example-information')) {
                selectedComponent.removeClass('example-information');
            }
        }
    });

    fetchTraineeInformation();
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
                autoload: false,
                stepsBeforeSave: 1,
                options: {
                    remote: {
                        headers: {}, // Custom headers for the remote storage request
                        urlStore: projectSaveEndpoint, // Endpoint for saving
                        urlLoad: projectLoadEndpoint,  // Endpoint for loading
                        onStore: data => ({ id: projectID, data }),
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

    async function fetchHTMLTemplate(url) {
        try {
            let response = await fetch(url);
            let html = await response.text();
            editor.setComponents(html);
        } catch (error) {
            console.error('Error loading HTML file:', error);
        }
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
        // console.log(editor.Panels.getPanel('options').get('buttons'));

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
                // Get the iframe document
                const iframeDoc = editor.Canvas.getDocument();

                // Use iframeDoc to check for elements inside the iframe
                if ($(iframeDoc).find(".example-information").length > 0) {
                    event.preventDefault();

                    // Add class
                    $(iframeDoc).find(".example-information").addClass('example-information-highlight');

                    // Ensure the element can be focused
                    $(iframeDoc).find(".example-information").attr('tabindex', '-1').focus();

                    // Scroll into view
                    iframeDoc.querySelector(".example-information").scrollIntoView({ behavior: 'smooth', block: 'center' });
                    showToast("You must to fill all or remove if not need the example data!", "error", "red");
                    return;
                }
                // Get HTML and CSS content from the editor
                let data = editor.getProjectData();
                let html = editor.getHtml();
                let css = editor.getCss();
                $(".loading").removeClass('hidden');
                // Send a POST request to save the content to the database
                // fetch('/trainee/career-guidance/portfolio/save-portfolio', {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
                //     },
                //     body: JSON.stringify({
                //         'data' : data,
                //         'html' : html,
                //         'css' : css
                //     })
                // }).then(response => {
                //     if (response.ok) {
                //         showToast('Template saved successfully!', 'success', 'green');
                //         window.location.href = '/trainee/career-guidance/portfolio/my-portfolio'
                //     } else {
                //         showToast('Failed to save template.', 'error', '#e74c3c');
                //     }
                // }).catch(error => {
                //     console.error('Error:', error);
                // });
                let formData = new FormData();
                formData.append('json_data', JSON.stringify({
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
                // let xhr = new XMLHttpRequest();
                // xhr.open('POST', '/trainee/career-guidance/portfolio/save-portfolio', true);
                // xhr.setRequestHeader('Content-Type', 'application/json');
                // xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                //
                // xhr.onreadystatechange = function () {
                //     if (xhr.readyState === 4 && xhr.status === 200) {
                //         let response = JSON.parse(xhr.responseText);
                //         if (response.status === 'success') {
                //             showToast('Template saved successfully!', 'success', 'green');
                //             window.location.href = '/trainee/career-guidance/portfolio/my-portfolio';
                //         } else {
                //             showToast('Failed to save template.', 'error', '#e74c3c');
                //         }
                //     }
                // };
                //
                // let datas = JSON.stringify({
                //     'data': data,
                //     'html': html,
                //     'css': css
                // });
                //
                // xhr.send(datas);
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
            wrapper.find('#trainee-address')[0].components(`<span data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${traineeInfo.contact_address}</span>`)
            if (traineeInfo.profile_image != '') {
                wrapper.find('#trainee_avatar')[0].components(`<img class="h-32 w-32 bg-white p-1 rounded-full" src="${traineeInfo.profile_image}" alt="avatar" />`);
            }

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
            ? `<p class="dark:text-white" draggable="false"><span class="font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">Course name: ${item.COURSE.COURSE_NAME}</span> <span class="text-sm">(${item.COURSE.START_DATE} - ${item.COURSE.END_DATE})</span></p>`
            : `<p class="dark:text-white"><span class="font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">Course name: No information</span></p>`;

        return `
       <div class="flex gap-4 items-baseline" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
            <svg  class="shrink-0" width="10" height="10" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#4984F6" /></svg>
            <div class="flex flex-col gap-2">
                <p class="dark:text-white" ><span class="text-xl font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${item.INSTITUTE.INSTITUTE_NAME}</span> <span>(Industry sector: ${item.COURSE.INDUSTRY_SECTOR})</span></p>
                ${courseName}
            </div>
        </div>`;
    }

    function buildQualificationBlock(item) {
        return item.QUALIFICATION_NAME
            ? `<div class="flex gap-4 items-baseline" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
                <svg   class="shrink-0" width="10" height="10" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#4984F6" /></svg>
                <div class="flex flex-col gap-2">
                    <p class="dark:text-white"><span class="text-xl font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">${item.QUALIFICATION_NAME}</span> <span>(${item.QUALIFICATION_LEVEL})</span></p>
                    <p class="dark:text-white" >${item.EFFECTIVE_DATE}</p>
                </div>
            </div>`
            : `<div class="flex gap-4 items-baseline" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">
                <svg   class="shrink-0" width="10" height="10" viewBox="0 0 10 10"><circle cx="5" cy="5" r="5" fill="#4984F6" /></svg>
                <div class="flex flex-col gap-2">
                    <p class="dark:text-white"><span class="text-xl font-semibold" data-gjs-editable="false" data-gjs-removable="false" data-gjs-draggable="false" data-gjs-droppable="false" data-gjs-copyable="false"  data-gjs-highlightable="false">No NVQ qualification</span></p>
                </div>
            </div>`;
    }

    async function saveTemplate() {
        try {
            await editor.store();
            showToast('Template saved successfully!', 'success', 'green');
        } catch (error) {
            console.error('Error saving template:', error);
            showToast('Failed to save the template.', 'error', '#e74c3c');
        }
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
