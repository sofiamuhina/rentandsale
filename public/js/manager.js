jQuery(document).ready(function() {
    
    tableHelper = new TableHelper();
    tableHelper.initialize();    
});

var TableHelper = function() {
    
    this.initialize = function() {
        sortingCol = jQuery('.sort_desc');
        sortingCol.click();        
    }
}