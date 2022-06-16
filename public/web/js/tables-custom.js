'use strict';

const ctrlStatus = document.getElementById('ctrl_status').value;

(function ($, window, i) {
    $('#employees').DataTable({
        serverSide: true,
        ajax: '/api/employees/' + ctrlStatus,
        aLengthMenu: [
            [7, 20, 50, 100, -1],
            [7, 20, 50, 100, 'All'],
        ],
        iDisplayLength: 7,
        columns: [
            { data: 'payroll' },
            { data: 'name' },
            { data: 'status' },
            { data: 'created_at' },
            { data: 'updated_at' },
            { data: 'btn' },
        ],
    });
})(jQuery, this, 0);
