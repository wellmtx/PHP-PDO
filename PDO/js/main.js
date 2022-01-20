(function(win, doc) {

    var app = (function() {
        return {
            attContacts: function attContacts() 
            {
                var ajax = new XMLHttpRequest();
                ajax.open('POST','class/contacts.php');
            }
        }
    })();
})(window, document);