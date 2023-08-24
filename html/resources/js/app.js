import {project} from './project.js';
import {task} from './task.js';

$(function() {
    // project events
    $('#project-name').on('keypress', function(e) {
        if (e.which == 13) {
            project.add();
        }
    });
    $('#add-project').on('click', project.add);
    $('.project .delete').on('click', project.delete);

    // task events
    $('#projects').on('change', task.list);
    $('#task-name').on('keypress', function(e) {
        if (e.which == 13) {
            task.add();
        }
    });
    $('#add-task').on('click', task.add);
    $('#task-list').sortable({stop: task.sort});
});