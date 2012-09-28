(function ($) {
    $.extend({
        createUploadIframe: function(id, uri) {
            //create frame
            var frameId = 'jUploadFrame' + id,
                iframeHtml = '<iframe id="' + frameId + '" name="' + frameId + '" style="position:absolute; top:-9999px; left:-9999px"';
            if(window.ActiveXObject) {
                if(typeof uri== 'boolean') {
                    iframeHtml += ' src="' + 'javascript:false' + '"';
                }
                else if(typeof uri== 'string') {
                    iframeHtml += ' src="' + uri + '"';
                }	
            }
            iframeHtml += ' />';
            $(iframeHtml).appendTo(document.body);
            return $('#' + frameId).get(0);			
        },
        createUploadForm: function(id, fileElementId, url, data) {
            //create form	
            var formId = 'jUploadForm' + id,
                frameId = 'jUploadFrame' + id,
                fileId = 'jUploadFile' + id,
                $form = $('<form action="' + url + '" method="post" name="' + formId + '" target="' + frameId + '" id="' + formId + '" enctype="multipart/form-data"></form>'),
                $oldInput = $('#' + fileElementId),
                $newInput = $($oldInput).clone();
                
            $oldInput.attr('id', fileId)
                .before($newInput);
            $form.append($oldInput);
            
            // add additional data
            for(var key in data) {
                $form.append($('<input type="hidden" name="'+key+'" value="'+data[key]+'" />'));
            }
            // set attributes
            $form.css('position', 'absolute')
                .css('top', '-1200px')
                .css('left', '-1200px');
            $('body').append($form);

            return $form;
        },
        ajaxFileUpload: function(s) {
            // TODO introduce global settings, allowing the client to modify them for all requests, not only timeout		
            s = $.extend({}, $.ajaxSettings, s);

            if(!s.url.match(/^http/i))
                s.url = location.href.replace(/(https?:\/\/[^\/]+).*$/i, '$1/') + s.url.replace(/^\//i, '');

            var id = new Date().getTime();
            var fileName = $('#'+s.fileElementId).val();
            fileName = fileName.substr(fileName.lastIndexOf('\\') + 1);
            fileName = fileName.substr(fileName.lastIndexOf('/') + 1);
            var form = $.createUploadForm(id, s.fileElementId, s.url, s.data);
            var io = $.createUploadIframe(id, s.secureuri);
            var frameId = 'jUploadFrame' + id;
            var formId = 'jUploadForm' + id;		
            // Watch for a new set of requests
            if (s.global && ! $.active++) {
                $.event.trigger( "ajaxStart" );
            }            
            var requestDone = false;
            // Create the request object
            var xml = {}   
            if ( s.global )
                $.event.trigger("ajaxSend", [xml, s]);
            // Wait for a response to come back
            var uploadCallback = function(isTimeout) {	
                var io = document.getElementById(frameId);
                try {				
                    if(io.contentWindow) {
                        xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
                        xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;

                    }
                    else if(io.contentDocument) {
                        xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
                        xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
                    }						
                }
                catch(e) {}

                if (xml || isTimeout == "timeout") {				
                    requestDone = true;
                    var status;
                    try {
                        status = isTimeout != "timeout" ? "success" : "error";
                        if (status != "error") { // Make sure that the request was successful or notmodified
                            var data = xml.responseText.replace(/^[^\{]*(\{.+\})[^\}]*$/i, '$1'); // process the data (runs the xml through httpData regardless of callback)
                            if (s.success) s.success( data, status, fileName ); // If a local callback was specified, fire it and pass it the data
                            if (s.global) $.event.trigger( "ajaxSuccess", [xml, s] ); // Fire the global callback
                        }
                    }
                    catch (e) {
                        status = "error"; //$.handleError(s, xml, status, e);
                    }
                    if (s.global) $.event.trigger( "ajaxComplete", [xml, s] ); // The request was completed
                    if (s.global && ! --$.active) $.event.trigger( "ajaxStop" ); // Handle the global AJAX counter
                    if (s.complete) s.complete(xml, status); // Process result
                    $(io).unbind();

                    setTimeout(function () {	
                            try {
                                $(io).remove();
                                $(form).remove();	
                            }
                            catch (e) { }
                        }, 100);
                    xml = null;
                }
            }

            // Timeout checker
            if ( s.timeout > 0 ) {
                setTimeout(function () {
                    if (!requestDone) uploadCallback( "timeout" );
                   }, s.timeout);
            }

            form.submit();

            $('#'+frameId).load(uploadCallback);
            return { abort: function () {} };	
        },
        uploadHttpData: function( r, type ) {
            var data = !type;
            data = r;
            if ( type == "script" ) $.globalEval( data ); // If the type is "script", eval it in global context
            if ( type == "json" ) eval( "data = " + data ); // Get the JavaScript object, if JSON is used.
            if ( type == "html" ) $("<div>").html(data).evalScripts(); // evaluate scripts within html
            return data;
        }
    });

})(jQuery);

