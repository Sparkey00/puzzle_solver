$(document).on('change', 'input[type="file"]', function () {
    let file = this.files[0];
    let button = $('#upload-button');
    let errors = $('#file-errors');

    errors.html('');
    if (file == null) {
        errors.html('You need to select file with sudoku!');
        button.prop("disabled", true);
        return;
    }

    if (file.size > 1024) {
        errors.html('Max upload size is 1 KB');
        button.prop("disabled", true);
        return;
    }

    button.prop("disabled", false);
});

$(document).on('click', '#upload-button', function () {
    $.ajax({
        url: '/sudoku/upload',
        type: 'POST',
        data: new FormData($('#sudoku-form')[0]),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend(jqXHR, settings) {
            $('#button-spinner').show();
            $('#upload-button').prop("disabled", true);
        },
        success: function (data) {
            console.log('Successfully loaded');
        },
        error: function () {
            console.log('error');
        },
    }).done(() => {
        getSolution();
    });
});

/**
 * Ajax call for solution of puzzle
 */
function getSolution() {
    $.ajax({
        url: '/sudoku/solve',
        type: 'GET',
        success: function (data) {
            $('#solved-title').html(formSolutionText(data.valid, data.genuine, data.solved));

            if (data.valid) {
                $('#unsolved-title').html('Here\'s your sudoku!');
                $('#unsolved-wrapper').html(formTable(data.original));
                if(data.solved) {
                    $('#solved-wrapper').html(formTable(data.results.forward));
                } else {
                    $('#solved-wrapper').html('');
                }
            } else {
                $('#unsolved-title').html('Your sudoku file wasn\'t valid');
                $('#unsolved-wrapper').html('');

                $('#solved-wrapper').html(formTable(data.results, false));
            }
        },
        error: function () {
            console.log('error');
        }
    }).done(() => {
        $('#button-spinner').hide();
        $('#upload-button').prop("disabled", false);
    })
}

/**
 * Forms a text for solution
 * @param valid
 * @param genuine
 * @param solved
 * @returns {string}
 */
function formSolutionText(valid, genuine, solved) {
    if (!valid) {
        return 'Your sudoku is invalid :(';
    }

    let text = 'Your sudoku is valid. '

    if (!solved) {
        text += 'But it is unsolvable.'
        return text;
    }
    if (!genuine) {
        text += 'However it is not genuine. There are more than one solution.'
    } else {
        text += 'And it is genuine, which means it has only one solution. Here it is.'
    }

    return text

}

/**
 * Forms table for sudoku or errors
 * @param sudoku
 * @param success
 *
 * @returns {string}
 */
function formTable(sudoku, success = true) {
    let cssClass = success ? 'sudoku' : 'errors';
    let html = '<table class="' + cssClass +' table">';
    sudoku.forEach(row => {
            if (Array.isArray(row)) {
                html += '<tr>';
                row.forEach(value => {
                    value != 0 ?
                        (html += '<td>' + value + '</td>')
                        : (html += '<td></td>')
                });
                html += '</tr>';
            } else {
                html += '<tr>';
                html += '<td>' + row + '</td>';
                html += '</tr>';
            }
        }
    );
    html += '<table>';

    return html;
}
