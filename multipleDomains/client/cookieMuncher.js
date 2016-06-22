var Example = Example || {}
Example = {
    /*
        function returns value for a provided key from a cookie
    */
    GetCookie: function(cname) {
        // helper function capturing & decoding cookie content
        var name = cname + '=';
        var ca = document.cookie.split('; ');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) {
                return atob(decodeURIComponent(c.substring(name.length, c.length)));
            }
        }
        return "";
    },
    /* do note - Cookie name must be identical to name set in CookieCreator.php
    // allows to look after particular cookie key => value
    */
    NameMyCookie : 'Retargeting',
    SetRetargeting: function() {
        /* 
            Function gets value from cookie for key set in NameMyCookie
            Value returned is parsed and passed to retargeting in DFP
            This example utilises two ad formats under the two names:
            example_160x600
            example_300x600
            Please do note, that these exact names must be set through CookieCreator.php

            Loop iterates through Placements array, assumes each second value is timestamp that can be ommited. 
            All the rest is passed as targeting array to DFP adserver
        */
        var cv = Example.GetCookie(Example.NameMyCookie);
        if (!cv) return;
        var Placements = cv.split('|');
        var targeting = [];
        for (var i = 0; i < Placements.length; i+=2) {
            targeting.push(Placements[i]);
        }
        googletag.cmd.push(function() {
            googletag.pubads().setTargeting('retarget', targeting); // part sets a key=value targeting in DFP
        });
    },
};
try{Example.SetRetargeting()}
catch(err) {/*ignore errors*/};
