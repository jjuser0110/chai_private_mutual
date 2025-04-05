const maxRow = 20;

// SETUP TABLE PAGINATION
function setupPagination(table) {
    const totalRow = table.querySelectorAll('tbody tr').length;
    const pageNum = Math.ceil(totalRow / maxRow);

    const container = table.parentNode.closest('.table-container');
    const pagination = container.querySelector('.page_num');
    clearPagination(pagination);

    const ul = document.createElement('ul');
    for (let n = 1; n <= pageNum; n++) {
        const li = document.createElement('li');
        li.textContent = n;
        li.setAttribute('page', n);
        li.addEventListener('click', tablePagination);
        ul.appendChild(li);
    }

    pagination.appendChild(ul);
    pagination.querySelector('li').click();
}

// CLEAR PAGINATION
function clearPagination(pagination) {
    pagination.innerHTML = "";
}

// CREATE PAGINATION
function tablePagination() {
    try {
        let page = this.getAttribute('page');
        let container = this.parentNode.closest('.table-container');
        let table = container.querySelector('table');
        let start = (((maxRow * page) - maxRow) + 1);
        let end = maxRow * page;
        let n = 1;

        container.querySelectorAll('.page_num ul li').forEach((x) => {
            x.classList.remove('active');
        });

        this.classList.add('active');

        table.querySelectorAll('tbody tr').forEach((x) => {
            if (n >= start && n <= end) {
                x.classList.remove('hide');
            } else {
                x.classList.add('hide');
            }
            n++;
        });

        limitPagination(container);

        container.querySelectorAll('.btn-pagination').forEach((btn) => {
            btn.addEventListener('click', togglePagination);
        });
    } catch (e) {
        console.log(e);
    }
}

// PAGINATION 
function togglePagination() {
    const container = this.parentNode.closest('.table-pagination');
    const current = parseInt(container.querySelector('.page_num li.active').getAttribute('page'));
    const max = container.querySelectorAll('.page_num li').length;

    let point;

    if (this.getAttribute('page') == 'next') {
        point = current == max ? current : parseInt(current + 1);
    } else {
        point = current == 1 ? point : parseInt(current - 1);
    }

    container.querySelector('.page_num li:nth-child(' + point + ')').click();
}

// MAX 
function limitPagination(container) {
    const allPages = container.querySelectorAll('.page_num ul li');
    const currentPage = parseInt(container.querySelector('.page_num ul .active').getAttribute('page'));
    let start = 1;
    let end = 5;
    let between = 2;

    if (allPages.length > 5) {
        if (currentPage > 3) {
            end = currentPage + 2;
            while (end > allPages.length) {
                end--;
                between++;
            }
            start = currentPage - between;
        }
        let count = 1;
        allPages.forEach((x) => {
            if (count >= start && count <= end) {
                x.classList.remove('hide');
            } else {
                x.classList.add('hide');
            }
            count++;
        });
    } else {
        return;
    }
}

document.addEventListener('DOMContentLoaded',()=>{
    document.querySelectorAll('.cus-table').forEach((x)=>{
        setupPagination(x);
    });
});