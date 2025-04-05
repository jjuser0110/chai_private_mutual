document.addEventListener("DOMContentLoaded", function () {
    /* SET PAGE TITLE */
    setPageTitle('History');

    const urlParams = new URLSearchParams(window.location.search);
    var fetch = urlParams.get('fetch') ? urlParams.get('fetch') : 'deposit';

    document.querySelectorAll('.fetch-record').forEach((x)=>{
        x.addEventListener('click',(event)=>{
            
            /* STYLE THE BUTTON */
            setActive(event);

            /* FETCH RECORD */
            fetchData(x.getAttribute('target'));
        });
        if(x.getAttribute('target') == fetch){
            x.click();
        }
    });
});

function fetchData(x) {
    $.ajax({
        method: 'get',
        url: 'fth_history',
        data:{'action':x},
        success: function (res) {
            try {
                createTable('history', res.row, res.col);

            } catch (e) {
                alert("There is something wrong, please try again later");
            }
        }
    });
}

function setActive(event){
    const parent = event.target.closest('.table-filter');

    parent.querySelectorAll('.fetch-record').forEach((x)=>{
        x.classList.remove('active');
    });

    event.target.classList.add('active');
}
