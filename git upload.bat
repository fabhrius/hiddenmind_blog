
REM Get the current date and time
set "datetime=%DATE% %TIME%"

REM Add all changes to the staging area
git add .

REM Commit the changes with the current date and time
git commit -m "Update on %datetime%"

REM Push the changes to the remote repository
git push origin

Pause

