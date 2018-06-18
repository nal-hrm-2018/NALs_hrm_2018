var lang = {
    /**
     function load the language file passed by function
     **/
    init : function (type,lang, afterLoad, options){
        this.type = type;
        var stag = document.createElement("script");
        stag.type = 'text/javascript';
        // you can replace the below url with your

        stag.src = $('meta[name="link_origin_multi_language"]').attr('content')+"/"+lang+"/"+ type+".js";
        document.querySelector("head").appendChild(stag);
        stag.onload = function (){
            afterLoad(options);
        }
    },

    /**
     This function is used to get string in your language
     passed by relative keyword
     **/
    getString : function (string, words){
        if(typeof window[this.type] != 'undefined'){
            var langString = window[this.type][string];
            if (typeof words != 'undefined' && words.length > 0) {
                langString = this.putDyanamicValue(langString, words);
            }
            return langString;
        }else {
            alert("'" + this.type +  '" language is not found');
        }
    },

    /**
     This puts the dynamic values in string passed by function, eg dynamic value DVD
     "Your Item {dvalue1} is not found"  is converted into  "Your Item DVD is not found"
     **/
    putDyanamicValue : function (langString, words){
        for (var i = 0; i < words.length; i++) {
            var spatt = new RegExp('{dvalue' + (i + 1) + '}');
            langString = langString.replace(spatt, words[i]);
        }
        return langString;
    }
}
