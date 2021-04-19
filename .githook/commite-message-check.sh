#!/bin/bash

commit_message_check (){
      # Get the current branch and apply it to a variable
      currentbranch=`git branch | grep \* | cut -d ' ' -f2`

      # Gets the commits for the current branch and outputs to file
      git log $currentbranch --pretty=format:"%H" --not master > shafile.txt

      # loops through the file an gets the message
      for i in `cat ./shafile.txt`;
      do 
      # gets the git commit message based on the sha
      gitmessage=`git log --format=%B -n 1 "$i"`
      
      # Checks gitmessage for string feat, fix, docs and breaking, if the messagecheck var is empty if fails
      messagecheck=`echo $gitmessage | grep -w "feat\|fix\|refactor\|docs\|breaking"`
      if [ -z "$messagecheck" ]
      then 
            echo "Your commit message must begin with one of the following"
            echo "  feat(feature-name)"
            echo "  fix(fix-name)"
            echo "  docs(docs-change)"
            echo " "
      fi
      # check the gitmessage for the Jira number
      messagecheck=`echo $gitmessage | grep "(AEROGEAR-"`
      if  [ -z "$messagecheck" ]
      then 
            echo "Your commit message must end with the following"
            echo "  (AEROGEAR-****)"
            echo "Where **** is the Jira number"
            echo " " 
      fi
      messagecheck=`echo $gitmessage | grep ": "`
      if  [ -z "$messagecheck" ]
      then 
            echo "Your commit message has a formatting error please take note of special characters '():' position and use in the example below"
            echo "   type(some txt): some txt (AEROGEAR-****)"
            echo "Where 'type' is fix, feat, docs or breaking and **** is the Jira number"
            echo " "
      fi

      # All checks run at the same time by pipeing from one grep to another
      messagecheck=`echo $gitmessage | grep -w "feat\|fix\|docs\|breaking" | grep "(AEROGEAR-" | grep ": "`



      # check to see if the messagecheck var is empty
      if [ -z "$messagecheck" ]
      then  
            echo "The commit message with sha: '$i' failed "
            echo "Please review the following :"
            echo " "
            echo $gitmessage
            echo " "
            rm shafile.txt >/dev/null 2>&1
            set -o errexit
      else
            echo "$messagecheck"
            echo "'$i' commit message passed"
      fi  
      done
      rm shafile.txt  >/dev/null 2>&1
}

# Calling the function
commit_message_check 
