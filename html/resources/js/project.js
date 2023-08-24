export const project = {
    // Add a new project
    add: function() {
        let params = {
            name: $('#project-name').val(),
            _token: $('input[name="_token"').val(),
        };

        $.post('/api/projects', params, function(response) {
            if (response.error) {
                $('#project-error').html(response.error.join(', '));

            } else {
                $('#project-name').val('');
                $('#project-error').html('');

                // since we cannot use components directly in here, I've added a hidden element that contains the list component
                // then retrieving that element here as the template for the new project list item
                let template = $('#project-template').clone();
                $(template).find('.list-item').html(response.name);
                $('li', template).addClass('project-' + response.id).attr('data-id', response.id);
                $('#project-list').append($(template).html());

                // add also in the project dropdown then bind events
                $('#projects').append($('<option>', {value: response.id, text: response.name}));
                $('.project .delete').on('click', project.delete);
            }
        });
    },

    // delete a project
    delete: function() {
        let projectId = $(this).closest('li').data('id');

        $.ajax({
            url     : '/api/projects/' + projectId,
            type    : 'DELETE',
            success : function() {
                // remove the project in the project list, projects dropdown and reset the task list in case the deleted project is the active project in the task panel
                $('.project-' + projectId).remove();
                if ($('#projects').val() == projectId) {
                    $('#projects').val('').trigger('change');
                }
                $('#projects option[value="' + projectId + '"]').remove();
            },
        });
    },
};