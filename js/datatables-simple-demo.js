window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementsByTagName('table');
    if (datatablesSimple.length > 0) {
        $.each( datatablesSimple, function( key, element ) {
            // console.log( key + ": " + element );
            new simpleDatatables.DataTable(element);
          });
    }
});
