(function ($) {

    /**
     * collection of callback functions for window resize.
     */
    var resizeCallbacks = [];
    
    /**
     * Screen object containing dimensions of page and window.
     */
    $.screen = {
        /**
         * Page width.
         */
        width: 0,
        /**
         * Page height.
         */
        height: 0,
        /**
         * Viewing area width.
         */
        viewWidth: 0,
        /**
         * Viewing area height.
         */
        viewHeight: 0,
        /**
         * Horizontal scroll amount.
         */
        scrollX: 0,
        /**
         * Vertical scroll amount.
         */
        scrollY: 0, 
        /**
         * Add a function as a resize event handler.
         * @param Function Callback function to be added.
         */
        resize: function (callback) {
            if(typeof(callback) != 'function')
                return;
            resizeCallbacks.push(callback);
        }
    }

    function ___resetScreen(_pw, _ph, _ww, _wh, _sx, _sy) {
        $.screen.width = _pw;
        $.screen.height = _ph;
        $.screen.viewWidth = _ww;
        $.screen.viewHeight = _wh;
        $.screen.scrollX = _sx;
        $.screen.scrollY = _sy;
    }

    $(document).ready(function () {
        var sizes = ___getPageSize();
        var scrolls = ___getPageScroll();
        ___resetScreen(sizes[0], sizes[1], sizes[2], sizes[3], scrolls[0], scrolls[1]);
    });

    $(window).resize(function(evt) {
        var sizes = ___getPageSize();
        var scrolls = ___getPageScroll();
        ___resetScreen(sizes[0], sizes[1], sizes[2], sizes[3], scrolls[0], scrolls[1]);

        if(resizeCallbacks.length == 0) return;

        var callback = null;
        for(var i in resizeCallbacks) {
            callback = resizeCallbacks[i];
            callback(evt);
        }
    });

    /**
     * getPageSize() by quirksmode.com
     * @return Array Return an array with page width, height and window width, height
     */
    function ___getPageSize() {
        var xScroll, yScroll;
        if (window.innerHeight && window.scrollMaxY) {
            xScroll = window.innerWidth + window.scrollMaxX;
            yScroll = window.innerHeight + window.scrollMaxY;
        } else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
            xScroll = document.body.scrollWidth;
            yScroll = document.body.scrollHeight;
        } else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
            xScroll = document.body.offsetWidth;
            yScroll = document.body.offsetHeight;
        }
        var windowWidth, windowHeight;
        if (self.innerHeight) {	// all except Explorer
            if(document.documentElement.clientWidth){
                windowWidth = document.documentElement.clientWidth;
            } else {
                windowWidth = self.innerWidth;
            }
            windowHeight = self.innerHeight;
        } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
            windowWidth = document.documentElement.clientWidth;
            windowHeight = document.documentElement.clientHeight;
        } else if (document.body) { // other Explorers
            windowWidth = document.body.clientWidth;
            windowHeight = document.body.clientHeight;
        }
        // for small pages with total height less then height of the viewport
        if(yScroll < windowHeight){
            pageHeight = windowHeight;
        } else {
            pageHeight = yScroll;
        }
        // for small pages with total width less then width of the viewport
        if(xScroll < windowWidth){
            pageWidth = xScroll;
        } else {
            pageWidth = windowWidth;
        }
        arrayPageSize = new Array(pageWidth, pageHeight, windowWidth, windowHeight);
        return arrayPageSize;
    };

    /**
     * getPageScroll() by quirksmode.com
     * @return Array Return an array with x,y page scroll values.
     */
    function ___getPageScroll() {
        var xScroll, yScroll;
        if (self.pageYOffset) {
            yScroll = self.pageYOffset;
            xScroll = self.pageXOffset;
        } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
            yScroll = document.documentElement.scrollTop;
            xScroll = document.documentElement.scrollLeft;
        } else if (document.body) {// all other Explorers
            yScroll = document.body.scrollTop;
            xScroll = document.body.scrollLeft;
        }
        arrayPageScroll = new Array(xScroll,yScroll);
        return arrayPageScroll;
    };

})(jQuery);