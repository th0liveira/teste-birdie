var AppTesteBirdie = {
    currentPage : 1,

    /**
     * Initialize
     */
    init: function() {
        var self = this;
        jQuery('#lista').hide();

        jQuery('#exibirLista').click(function () {
            self.showList();
        });

        jQuery('#exportarCsv').click(function () {
            self.exportCsv();
        });

        jQuery('#exportarExcel').click(function () {
            self.exportExcel();
        });
    },

    /**
     * Show List
     */
    showList: function() {
        var self = this;

        jQuery('#lista').show();

        self.loadList();
    },

    /**
     * Load List
     */
    loadList: function() {
        var self = this;

        jQuery.ajax({
            url     : "/?action=list&page=" + self.currentPage,
            success: function(data) {

                var template =  '<tr>' +
                                '<td>{code}</td>' +
                                '<td>{name}</td>' +
                                '<td>{custom}</td>' +
                                '</tr>';

                jQuery('#listaDados').html('');

                jQuery.each(data.documents, function(i, item) {
                    var line = template.replace('{code}', data.documents[i].code)
                                       .replace('{name}', data.documents[i].name)
                                       .replace('{custom}', data.documents[i].custom);
                    jQuery('#listaDados').append(line);
                });

                self.updatePagination(data.pagination);
            }
        });
    },

    /**
     * Update Pagination
     */
    updatePagination: function (data) {
        jQuery('#paginacao-bt-anterior').hide();
        if (data.prev === true) {
            jQuery('#paginacao-bt-anterior').show();
        }

        var template = '<li class="page-item">' +
                       '<button class="page-link" onclick="AppTesteBirdie.gotoPage({pageNumber})">{pageNumber}</button>' +
                       '</li>';


        jQuery('#paginacao-bt-paginas').html('');
        jQuery.each(data.pages, function(i, item) {
            var line = template.replace(new RegExp('\{pageNumber\}', 'g'), item);
            jQuery('#paginacao-bt-paginas').append(line);
        });

        jQuery('#paginacao-bt-proximo').hide();
        if (data.next === true) {
            jQuery('#paginacao-bt-proximo').show();
        }

    },

    /**
     * Button Prev
     */
    buttonPrev : function () {
        var self = this;

        self.currentPage--;

        self.loadList();
    },

    /**
     * Button Next
     */
    buttonNext : function () {
        var self = this;

        self.currentPage++;

        self.loadList();
    },

    /**
     * Goto Page
     */
    gotoPage : function (pageNumber) {
        var self = this;

        self.currentPage = pageNumber;

        self.loadList();
    },

    /**
     * Export Csv
     */
    exportCsv: function () {
        window.location = '/?action=exportCsv';
    },

    /**
     * Export Excel
     */
    exportExcel: function () {
        window.location = '/?action=exportExcel';
    }
};

AppTesteBirdie.init();
