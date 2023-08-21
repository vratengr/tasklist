### TASK:
Create a very simple Laravel web application for task management:  

Create task (info to save: task name, priority, timestamps)  
Edit task  
Delete task  
Reorder tasks with drag and drop in the browser. Priority should automatically be updated based on this. #1 priority goes at top, #2 next down and so on.  

Tasks should be saved to a mysql table.  

BONUS POINT: add project functionality to the tasks. User should be able to select a project from a dropdown and only view tasks associated with that project.


### SOLUTION:
The zip file contains a docker compose file to set up the local dev environment. If you already have your own local web server, please extract the main code which is within the /html folder and deploy it in your web directory.

For Docker deployment, please see instructions below:
- Prerequisite:
    - Install [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- Steps:
    1. Unzip file
    1. Open the extracted folder in a terminal
    1. Run `docker compose up -d`
    1. Access site in http://localhost:8006
- Note:
    - By default, Laravel has a defined ``.gitignore`` file which excludes packages/dependencies.
    - For portability of this code, all packages/dependencies have been included.
    - `.env` file has also been included since there is no critical information in it, however, this is a no-no in shared repositories.
    - In production/real-world scenarios, Laravel's `.gitignore` will be retained, as such, you will have to:
        1. install dependencies using `composer install` and/or `npm install`
        1. copy `.env.example` to `.env`
        1. run `php artisan key:generate` to create your APP_KEY
        1. modify the `.env` file according to your local setup