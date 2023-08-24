export const task = {
    // list all tasks for the chosen project
    list: function() {
        let projectId   = $('#projects').val();
        let projectName = (projectId) ? $('#projects option:selected').text() : '';
        $('#project').html(projectName);
        $('#task-list').html('');

        if (projectId) {
            $.get('/api/projects/' + projectId, {}, function(response) {

                // since we cannot use components directly in here, I've added a hidden element that contains the list component
                // then retrieving that element here as the template for the new task list item
                $.each(response, function() {
                    let template = $('#task-template').clone();
                    $(template).find('.list-item').html(this.name);
                    $('li', template).addClass('task-' + this.id).attr('data-id', this.id);
                    $('#task-list').append($(template).html());
                });

                // bind events
                $('.edit').on('click', task.edit);
                $('.task .delete').on('click', task.delete);
            });
        }
    },

    // add a new task
    add: function() {
        let params      = {
            project_id  : $('#projects').val(),
            name        : $('#task-name').val(),
            order       : $('#task-list li').length + 1,
            _token      : $('input[name="_token"').val(),
        };

        $.post('/api/tasks', params, function(response) {
            if (response.error) {
                $('#task-error').html(response.error.join(', '));

            } else {
                $('#task-name').val('');
                $('#task-error').html('');

                // get task template then append with data
                let template = $('#task-template').clone();
                $(template).find('.list-item').html(response.name);
                $('li', template).addClass('task task-' + response.id).attr('data-id', response.id);
                $('#task-list').append($(template).html());

                // don't forget to bind events
                $('.edit').on('click', task.edit);
                $('.task .delete').on('click', task.delete);
            }
        });
    },

    // edit task name
    edit: function() {
        let taskId = $(this).closest('li').data('id');
        let taskName = $(this).closest('li').find('.list-item').html();
        let newName = prompt('Enter new task name', taskName);

        if (newName) {
            let params = {
                project_id  : $('#projects').val(),
                name        : newName,
            };

            $.ajax({
                url     : '/api/tasks/' + taskId,
                type    : 'PUT',
                data    : params,
                success : function(response) {
                    if (response.success) {
                        $('.task-' + taskId + ' .list-item').html(newName);
                    } else {
                        alert(response.error.join("<br/>"));
                    }
                },
            });
        }
    },

    // delete a task
    delete: function() {
        let taskId = $(this).closest('li').data('id');
        $.ajax({
            url     : '/api/tasks/' + taskId,
            type    : 'DELETE',
            success : function() {
                $('.task-' + taskId).remove();
            },
        });
    },

    // handle sorting of task list
    sort: function(event, ui) {
        let tasks = {};
        let order = 1;
        $('#task-list').children().each(function() {
            tasks[order++] = ($(this).data('id'));
        });

        $.ajax({
            url     : '/api/tasks/sort',
            type    : 'PUT',
            data    : {tasks: tasks},
        });
    },
};